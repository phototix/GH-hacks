<?php

function callTeslaAPI($endpoint, $payload = []) {
    $apiUrl = "https://api.tesla.io/v1" . $endpoint;
    
    // Create a new cURL resource
    $ch = curl_init($apiUrl);

    // Set cURL options
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    ];

    // If a payload is provided, set it as JSON data
    if (!empty($payload)) {
        $options[CURLOPT_POSTFIELDS] = json_encode($payload);
    }

    curl_setopt_array($ch, $options);

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    return $response;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $endpoint = isset($_POST["endpoint"]) ? $_POST["endpoint"] : "/";
    $payload = isset($_POST["payload"]) ? json_decode($_POST["payload"], true) : [];

    // Call the Tesla API
    $apiResponse = callTeslaAPI($endpoint, $payload);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tesla API Controller</title>
</head>
<body>
    <h1>Tesla API Controller</h1>
    <form method="post">
        <label for="endpoint">Enter an API endpoint (/doors/, /core/, /travel/):</label><br>
        <input type="text" name="endpoint" value="<?php echo $endpoint ?? ''; ?>" required><br>
        
        <label for="payload">Enter JSON payload (if required):</label><br>
        <textarea name="payload" rows="6" cols="50"><?php echo $payload ?? ''; ?></textarea><br>
        
        <input type="submit" value="Call API">
    </form>
    
    <?php if (isset($apiResponse)) : ?>
        <h2>API Response:</h2>
        <pre><?php echo $apiResponse; ?></pre>
    <?php endif; ?>
</body>
</html>
