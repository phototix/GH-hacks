<?php

function isPalindrome($inputString) {
    // Remove spaces and convert to lowercase
    $cleanedString = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $inputString));

    // Compare the cleaned string with its reverse
    return $cleanedString === strrev($cleanedString);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = isset($_POST["input"]) ? $_POST["input"] : "";
    $isPalindrome = isPalindrome($input);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Palindrome Checker</title>
</head>
<body>
    <h1>Palindrome Checker</h1>
    <form method="post">
        <label for="input">Enter a word or phrase:</label><br>
        <input type="text" name="input" value="<?php echo $input ?? ''; ?>" required><br>
        <input type="submit" value="Check Palindrome">
    </form>
    
    <?php if (isset($isPalindrome)) : ?>
        <p><?php echo $isPalindrome ? 'Yes, it is a palindrome.' : 'No, it is not a palindrome.'; ?></p>
    <?php endif; ?>
</body>
</html>
