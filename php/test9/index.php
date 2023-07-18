<?php  
$quotes = [
    [
        "quote" => "The only way to do great work is to love what you do.",
        "author" => "Steve Jobs"
    ],
    [
        "quote" => "Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful.",
        "author" => "Albert Schweitzer"
    ],
    // Add more quotes as desired
];

function getRandomQuote($quotes) {
    $randomIndex = array_rand($quotes);
    return $quotes[$randomIndex];
}

$randomQuote = getRandomQuote($quotes);
$quote = $randomQuote["quote"];
$author = $randomQuote["author"];

echo "<h3>Quote of the Day:</h3>";
echo "<p>$quote</p>";
echo "<p>- $author</p>";
?>