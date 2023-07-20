<?php
function generateRandomPassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    $password = '';
    $charLength = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charLength);
        $password .= $chars[$randomIndex];
    }

    return $password;
}

// Generate a random password with default length (12 characters)
$randomPassword = generateRandomPassword();
echo "Random Password: $randomPassword";
?>