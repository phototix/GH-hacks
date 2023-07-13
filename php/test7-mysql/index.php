<?php
require_once 'config.php';

// Anti-hack mechanisms
$host = filter_var($host, FILTER_SANITIZE_STRING);
$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);
$database = filter_var($database, FILTER_SANITIZE_STRING);

// Establish MySQL connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Use the $conn object for executing MySQL queries
// ...
?>