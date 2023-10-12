<?php

$url = "http://localhost";  // Replace with your local server URL

// Use get_headers() to retrieve the headers from the local server
$headers = get_headers($url);

// Output the headers
foreach ($headers as $header) {
    echo $header . "\n";
}

?>