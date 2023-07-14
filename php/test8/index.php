<?php

// Initialize cURL
$curl = curl_init();

// Set the cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://whatsapp.brandon.my/api/sessions/start',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode(array(
        'name' => 'brandonchong',
    )),
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'X-Api-Key: API_CRED_KEY',
        'Content-Type: application/json',
    ),
));

// Send the request and store the response in a variable
$response = curl_exec($curl);

// Close cURL
curl_close($curl);

// Display the response
echo $response;

?>