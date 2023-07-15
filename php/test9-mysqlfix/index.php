<?php
// MySQL database connection
$servername = "localhost"; // Replace with your server name
$username = "your_username"; // Replace with your MySQL username
$password = "your_password"; // Replace with your MySQL password
$dbname = "your_database"; // Replace with your database name

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the text from the database
$query = "SELECT text_column FROM your_table WHERE id = 1"; // Modify the query according to your table structure and conditions
$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $text = $row['text_column']; // Replace 'text_column' with the actual column name in your table

    // Convert the text to readable format
    $readableText = utf8_encode($text); // Assuming the text is encoded in UTF-8
    echo $readableText;
} else {
    echo "Failed to fetch the text from the database.";
}

// Close the connection
mysqli_close($connection);
?>