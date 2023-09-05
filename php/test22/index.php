<?php
function executeLinuxCommand($command) {
    $output = shell_exec($command);
    return $output;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $directory = isset($_POST["directory"]) ? $_POST["directory"] : "/";
    $lsOutput = executeLinuxCommand("ls -l " . escapeshellarg($directory));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Linux Command Execution</title>
</head>
<body>
    <h1>Linux Command Execution</h1>
    <form method="post">
        <label for="directory">Enter a directory path:</label><br>
        <input type="text" name="directory" value="<?php echo $directory ?? ''; ?>" required><br>
        <input type="submit" value="Execute ls Command">
    </form>
    
    <?php if (isset($lsOutput)) : ?>
        <h2>ls Command Output:</h2>
        <pre><?php echo $lsOutput; ?></pre>
    <?php endif; ?>
</body>
</html>
