<?php

function performLoadTest($url, $numRequests) {
    $results = [];

    // Create a multi-handle to handle multiple curl requests
    $multiHandle = curl_multi_init();

    // Initialize an array to store individual curl handles
    $curlHandles = [];

    // Create multiple curl handles and add them to the multi-handle
    for ($i = 0; $i < $numRequests; $i++) {
        $curlHandles[$i] = curl_init();
        curl_setopt($curlHandles[$i], CURLOPT_URL, $url);
        curl_setopt($curlHandles[$i], CURLOPT_RETURNTRANSFER, true);
        curl_multi_add_handle($multiHandle, $curlHandles[$i]);
    }

    // Execute the multi-handle requests
    $active = null;
    do {
        $status = curl_multi_exec($multiHandle, $active);
    } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

    // Retrieve the results of each curl handle
    foreach ($curlHandles as $i => $handle) {
        $results[$i] = curl_multi_getcontent($handle);
        curl_multi_remove_handle($multiHandle, $handle);
        curl_close($handle);
    }

    // Close the multi-handle
    curl_multi_close($multiHandle);

    return $results;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $numRequests = $_POST['num_requests'];

    $results = performLoadTest($url, $numRequests);

    // Output the results
    foreach ($results as $i => $result) {
        echo "Request " . ($i + 1) . ":\n";
        echo $result . "\n";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Load Test Form</title>
</head>
<body>
    <h1>Perform Load Test</h1>
    <form method="POST" action="">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" required><br><br>

        <label for="num_requests">Number of Requests:</label>
        <select id="num_requests" name="num_requests" required>
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="500">500</option>
        </select><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
