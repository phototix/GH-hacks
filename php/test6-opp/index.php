<?php  
$directory = __DIR__; // Use the current script's directory

$phpFiles = glob($directory . '/*.php');

foreach ($phpFiles as $phpFile) {
    include $phpFile;
}
?>