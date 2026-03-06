<?php
/**
 * Single-file PHP app: Mini Notes
 * - Add / delete notes
 * - Persists to a local JSON file (notes.json) next to this script
 * - Basic CSRF protection via session token
 *
 * Run locally:
 *   php -S localhost:8000
 * then open:
 *   http://localhost:8000/php/single-file-notes/index.php
 */

declare(strict_types=1);

session_start();

// ---------- Config ----------
$APP_TITLE = 'Mini Notes';
$MAX_NOTE_LENGTH = 2000;
$DATA_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'notes.json';

// ---------- Helpers ----------
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function now_iso(): string {
    return (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format(DateTimeInterface::ATOM);
}

function text_len(string $s): int {
  // Prefer multibyte length when available; otherwise fall back to byte length.
  if (function_exists('mb_strlen')) {
    return (int)mb_strlen($s, 'UTF-8');
  }
  return strlen($s);
}

function ensure_csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return (string)$_SESSION['csrf'];
}

function require_post(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        exit('Method Not Allowed');
    }
}

function verify_csrf(): void {
    $sent = (string)($_POST['csrf'] ?? '');
    $sess = (string)($_SESSION['csrf'] ?? '');
    if ($sent === '' || $sess === '' || !hash_equals($sess, $sent)) {
        http_response_code(400);
        exit('Bad Request (CSRF)');
    }
}

/**
 * @return array<int, array{id:string, text:string, created_at:string}>
 */
function load_notes(string $dataFile): array {
    if (!is_file($dataFile)) {
        return [];
    }
    $raw = @file_get_contents($dataFile);
    if ($raw === false || trim($raw) === '') {
        return [];
    }
    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return [];
    }
    // Defensive normalization
    $notes = [];
    foreach ($decoded as $n) {
        if (!is_array($n)) {
            continue;
        }
        $id = isset($n['id']) && is_string($n['id']) ? $n['id'] : '';
        $text = isset($n['text']) && is_string($n['text']) ? $n['text'] : '';
        $created = isset($n['created_at']) && is_string($n['created_at']) ? $n['created_at'] : '';
        if ($id === '' || $text === '' || $created === '') {
            continue;
        }
        $notes[] = ['id' => $id, 'text' => $text, 'created_at' => $created];
    }
    return $notes;
}

/**
 * @param array<int, array{id:string, text:string, created_at:string}> $notes
 */
function save_notes(string $dataFile, array $notes): bool {
    $json = json_encode($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }

  // Keep it simple and Windows-friendly.
  // (rename() may fail to replace an existing file on Windows.)
  return (@file_put_contents($dataFile, $json, LOCK_EX) !== false);
}

function redirect_with_flash(string $message, string $type = 'info'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
  $base = strtok((string)($_SERVER['REQUEST_URI'] ?? ''), '?');
  if ($base === false || $base === '') {
    $base = (string)($_SERVER['PHP_SELF'] ?? '');
  }
  header('Location: ' . $base);
    exit;
}

function get_flash(): ?array {
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
        return null;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

function uuid_like(): string {
    // Not a true UUID, but good enough for a demo: 32 hex chars
    return bin2hex(random_bytes(16));
}

// ---------- Actions ----------
$csrf = ensure_csrf_token();
$action = (string)($_GET['action'] ?? '');

if ($action === 'add') {
    require_post();
    verify_csrf();

    $text = (string)($_POST['text'] ?? '');
    $text = trim($text);

    if ($text === '') {
        redirect_with_flash('Please type something before saving.', 'warn');
    }

    if (text_len($text) > $MAX_NOTE_LENGTH) {
        redirect_with_flash('Note is too long.', 'warn');
    }

    $notes = load_notes($DATA_FILE);
    array_unshift($notes, [
        'id' => uuid_like(),
        'text' => $text,
        'created_at' => now_iso(),
    ]);

    if (!save_notes($DATA_FILE, $notes)) {
        redirect_with_flash('Could not save notes (file permissions?).', 'error');
    }

    redirect_with_flash('Saved!', 'ok');
}

if ($action === 'delete') {
    require_post();
    verify_csrf();

    $id = (string)($_POST['id'] ?? '');
    if ($id === '') {
        redirect_with_flash('Missing note id.', 'error');
    }

    $notes = load_notes($DATA_FILE);
    $before = count($notes);
    $notes = array_values(array_filter($notes, fn($n) => is_array($n) && ($n['id'] ?? '') !== $id));

    if (count($notes) === $before) {
        redirect_with_flash('Note not found (maybe already deleted).', 'warn');
    }

    if (!save_notes($DATA_FILE, $notes)) {
        redirect_with_flash('Could not save notes (file permissions?).', 'error');
    }

    redirect_with_flash('Deleted.', 'ok');
}

// ---------- Render ----------
$notes = load_notes($DATA_FILE);
$flash = get_flash();

?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= h($APP_TITLE) ?></title>
  <style>
    :root {
      --bg: #0b1220;
      --card: rgba(255,255,255,.06);
      --card2: rgba(255,255,255,.085);
      --text: #e8eefc;
      --muted: rgba(232, 238, 252, .7);
      --border: rgba(255,255,255,.12);
      --ok: #22c55e;
      --warn: #f59e0b;
      --error: #ef4444;
      --accent: #7c3aed;
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      background: radial-gradient(1200px 800px at 20% 10%, rgba(124,58,237,.35), transparent 60%),
                  radial-gradient(1200px 800px at 80% 20%, rgba(34,197,94,.18), transparent 55%),
                  var(--bg);
      color: var(--text);
    }

    .wrap {
      max-width: 900px;
      margin: 36px auto;
      padding: 0 16px 48px;
    }

    header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 18px;
    }

    h1 {
      margin: 0;
      font-size: 28px;
      letter-spacing: .2px;
    }

    .subtitle {
      margin: 0;
      color: var(--muted);
      font-size: 14px;
    }

    .card {
      background: linear-gradient(180deg, var(--card), rgba(255,255,255,.045));
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px;
      box-shadow: 0 10px 35px rgba(0,0,0,.25);
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 14px;
    }

    @media (min-width: 860px) {
      .grid { grid-template-columns: 360px 1fr; }
    }

    textarea {
      width: 100%;
      min-height: 120px;
      resize: vertical;
      padding: 12px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: rgba(0,0,0,.22);
      color: var(--text);
      outline: none;
      font-size: 14px;
      line-height: 1.45;
    }

    textarea:focus {
      border-color: rgba(124,58,237,.55);
      box-shadow: 0 0 0 4px rgba(124,58,237,.18);
    }

    .row {
      display: flex;
      gap: 10px;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .btn {
      border: 1px solid var(--border);
      background: rgba(255,255,255,.06);
      color: var(--text);
      padding: 10px 12px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
    }

    .btn:hover { background: rgba(255,255,255,.09); }

    .btn.primary {
      background: rgba(124,58,237,.35);
      border-color: rgba(124,58,237,.55);
    }

    .btn.danger {
      background: rgba(239,68,68,.14);
      border-color: rgba(239,68,68,.35);
    }

    .hint {
      color: var(--muted);
      font-size: 12px;
    }

    .flash {
      margin: 12px 0 0;
      padding: 10px 12px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: var(--card2);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .flash.ok { border-color: rgba(34,197,94,.35); }
    .flash.warn { border-color: rgba(245,158,11,.35); }
    .flash.error { border-color: rgba(239,68,68,.35); }

    .flash b { font-weight: 700; }

    .note {
      border: 1px solid var(--border);
      background: rgba(0,0,0,.18);
      border-radius: 14px;
      padding: 12px;
      margin-bottom: 10px;
    }

    .note-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 12px;
    }

    .note-meta {
      color: var(--muted);
      font-size: 12px;
      margin: 0 0 8px;
    }

    .note-text {
      white-space: pre-wrap;
      overflow-wrap: anywhere;
      margin: 0;
      line-height: 1.45;
    }

    .small {
      font-size: 12px;
      color: var(--muted);
    }

    .footer {
      margin-top: 14px;
      color: var(--muted);
      font-size: 12px;
    }

    code.inline {
      padding: 2px 6px;
      border-radius: 8px;
      background: rgba(0,0,0,.22);
      border: 1px solid var(--border);
      color: var(--text);
    }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div>
        <h1><?= h($APP_TITLE) ?></h1>
        <p class="subtitle">A tiny single-file PHP app (with JSON persistence). Add a note, refresh, it’s still there.</p>
      </div>
      <div class="small">Data file: <code class="inline"><?= h(basename($DATA_FILE)) ?></code></div>
    </header>

    <div class="grid">
      <section class="card">
        <h2 style="margin:0 0 10px; font-size:16px;">New note</h2>

        <form method="post" action="?action=add">
          <input type="hidden" name="csrf" value="<?= h($csrf) ?>" />
          <textarea name="text" maxlength="<?= (int)$MAX_NOTE_LENGTH ?>" placeholder="Write something…"></textarea>
          <div class="row">
            <button class="btn primary" type="submit">Save note</button>
            <div class="hint">Max <?= (int)$MAX_NOTE_LENGTH ?> chars. Stored server-side.</div>
          </div>
        </form>

        <?php if ($flash !== null):
            $ft = isset($flash['type']) && is_string($flash['type']) ? $flash['type'] : 'info';
            $msg = isset($flash['message']) && is_string($flash['message']) ? $flash['message'] : '';
        ?>
          <div class="flash <?= h($ft) ?>">
            <div><b><?= h(strtoupper($ft)) ?></b> — <?= h($msg) ?></div>
            <div class="small">(refresh-safe)</div>
          </div>
        <?php endif; ?>

        <div class="footer">
          Tip: this file writes <code class="inline"><?= h(basename($DATA_FILE)) ?></code> next to itself. If saving fails, check folder permissions.
        </div>
      </section>

      <section class="card">
        <h2 style="margin:0 0 10px; font-size:16px;">Notes (<?= (int)count($notes) ?>)</h2>

        <?php if (count($notes) === 0): ?>
          <p class="small" style="margin:0;">No notes yet. Add your first one on the left.</p>
        <?php else: ?>
          <?php foreach ($notes as $n):
              $id = (string)$n['id'];
              $text = (string)$n['text'];
              $created = (string)$n['created_at'];
              $dt = DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, $created);
              $pretty = $dt ? $dt->setTimezone(new DateTimeZone(date_default_timezone_get()))->format('Y-m-d H:i:s T') : $created;
          ?>
            <div class="note">
              <div class="note-top">
                <div style="min-width:0; flex:1;">
                  <p class="note-meta">Created: <?= h($pretty) ?></p>
                  <p class="note-text"><?= h($text) ?></p>
                </div>
                <form method="post" action="?action=delete" style="margin:0;">
                  <input type="hidden" name="csrf" value="<?= h($csrf) ?>" />
                  <input type="hidden" name="id" value="<?= h($id) ?>" />
                  <button class="btn danger" type="submit" onclick="return confirm('Delete this note?');">Delete</button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <p class="small" style="margin: 12px 0 0;">Privacy note: this is a local demo. Don’t put secrets here unless you trust the server.</p>
      </section>
    </div>
  </div>
</body>
</html>
