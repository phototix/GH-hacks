<?php
// Replace with your database credentials
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch table names
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $tables = array();
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }
    // Convert to JSON and output
    echo json_encode($tables);
} else {
    echo "No tables found.";
}

$conn->close();
?>
