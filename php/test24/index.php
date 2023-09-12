<?php
# git clone https://github.com/ratchetphp/Ratchet


// Define the root directory where you want to start including files
$rootDirectory = __DIR__ . '/your_root_directory';

// Define an array of allowed file extensions
$allowedExtensions = ['php'];

// Function to include PHP files recursively
function includeFilesRecursively($directory, $allowedExtensions) {
    if (is_dir($directory)) {
        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $path = $directory . '/' . $file;
                if (is_dir($path)) {
                    // If it's a directory, recurse into it
                    includeFilesRecursively($path, $allowedExtensions);
                } elseif (in_array(pathinfo($path, PATHINFO_EXTENSION), $allowedExtensions)) {
                    // If it's a PHP file with an allowed extension, include it
                    include_once $path;
                }
            }
        }
    }
}

// Include PHP files recursively
includeFilesRecursively($rootDirectory, $allowedExtensions);

// Additional checks to prevent potentially buggy files
// For example, you can define a list of safe file names or patterns
$safeFilePatterns = ['safe_file.php', 'another_safe_file.php'];

// Check if the included file matches a safe pattern
if (!in_array(basename($_SERVER['SCRIPT_FILENAME']), $safeFilePatterns)) {
    die('Access denied. This file is not allowed.');
}
?>