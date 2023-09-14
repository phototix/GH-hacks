<?php
# Install SLIM Packge
# composer require slim/slim "^4.0"

require 'vendor/autoload.php';

// Create a Slim app
$app = Slim\Factory\AppFactory::create();

// Define a route to execute a function
$app->post('/execute', function ($request, $response) {
    // Parse the JSON data sent by the client
    $data = $request->getParsedBody();

    // Check if a function name and arguments are provided
    if (!isset($data['function']) || !isset($data['arguments'])) {
        return $response->withStatus(400)->withJson(['error' => 'Invalid request']);
    }

    // Extract function name and arguments
    $functionName = $data['function'];
    $arguments = $data['arguments'];

    // Check if the function exists
    if (!function_exists($functionName)) {
        return $response->withStatus(404)->withJson(['error' => 'Function not found']);
    }

    // Call the function and pass arguments
    $result = call_user_func_array($functionName, $arguments);

    return $response->withJson(['result' => $result]);
});

// Run the Slim app
$app->run();

# Using CURL to call the API from external.
# curl -X POST -H "Content-Type: application/json" -d '{"function":"add","arguments":[5,3]}' http://localhost:8000/execute