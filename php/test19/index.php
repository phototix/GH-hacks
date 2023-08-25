<?php

function countWordFrequency($text) {
    $words = str_word_count($text, 1); // Split text into words
    $wordFrequency = array_count_values($words); // Count word occurrences
    arsort($wordFrequency); // Sort by frequency in descending order
    return $wordFrequency;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputText = isset($_POST["text"]) ? $_POST["text"] : "";
    $wordFrequency = countWordFrequency($inputText);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Word Frequency Counter</title>
</head>
<body>
    <h1>Word Frequency Counter</h1>
    <form method="post">
        <label for="text">Enter a paragraph of text:</label><br>
        <textarea name="text" rows="6" cols="50" required><?php echo $inputText ?? ''; ?></textarea><br>
        <input type="submit" value="Count Frequency">
    </form>
    
    <?php if (isset($wordFrequency)) : ?>
        <h2>Word Frequency:</h2>
        <ul>
            <?php foreach ($wordFrequency as $word => $count) : ?>
                <li><?php echo "$word: $count"; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
