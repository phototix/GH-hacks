<?php  
function generateFileToken($fileId) {
    $token = uniqid($fileId . '_', true);
    return $token;
}

// Usage example:
$fileId = 12345; // Replace with your file ID
$token = generateFileToken($fileId);
echo $token;
?>