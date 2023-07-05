<?php 
$maxFileSize = 10 * 1024 * 1024; // 10MB in bytes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $uploadedFileSize = $_FILES['file']['size'];
        
        if ($uploadedFileSize > $maxFileSize) {
            // File size exceeds the limit, handle the error
            echo "Error: File size exceeds the limit of 10MB.";
            exit;
        }
        
        // Process the uploaded file
        // ...
    }
}
?>