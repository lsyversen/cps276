<?php
if (isset($_GET['dir']) && isset($_GET['file'])) {
    $directory = $_GET['dir'];
    $file = $_GET['file'];
    $filePath = "/home/l/s/lsyversen/public_html/directories/$directory/$file";

    if (file_exists($filePath)) {
        header('Content-Type: text/plain');
        readfile($filePath);
    } else {
        echo "File not found. Directory: $directory, File: $file, Full Path: $filePath";
    }
} else {
    echo "Invalid request";
}
?>