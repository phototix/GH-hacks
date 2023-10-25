<?php

$jsonData = '{
    "1": "Test",
    "3": "Test",
    "4": "Test",
    "6": "Test",
    "2": "Test",
    "9": "Test"
}';

// Decode the JSON data
$data = json_decode($jsonData, true);

// Sort the keys in ascending order
ksort($data);

// Build a new JSON object
$sortedJsonData = json_encode($data, JSON_PRETTY_PRINT);

// Output the sorted JSON
echo $sortedJsonData;
