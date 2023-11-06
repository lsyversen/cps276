<?php
require_once 'classes/DB.php';

class FileProc {
  private $uploadDir = 'uploads/'; // Define the upload directory for PDF files
  private $allowedMimeTypes = ['application/pdf']; // Define allowed PDF MIME types
  private $maxFileSize = 100000; // Define the maximum file size (100KB)

  public function init() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // If it's a POST request, handle file upload and display file list
      return [$this->fileUpload(), $this->displayList()];
    } else {
      // If it's not a POST request, only display the file list
      return ["", $this->displayList()];
    }
  }

  public function fileUpload() {
    if (empty($_POST['file_name'])) {
      // Check if the user didn't enter a file name
      return "No file name was entered";
    }

    if (empty($_FILES['file']['name'])) {
      // Check if no file was uploaded
      return "No file was uploaded. Make sure you choose a file to upload.";
    }

    $fileSize = $_FILES['file']['size'];
    $fileType = mime_content_type($_FILES['file']['tmp_name']);

    if ($fileSize > $this->maxFileSize) {
      // Check if the file size exceeds the maximum allowed size
      return "The file is too large";
    }

    if (!in_array($fileType, $this->allowedMimeTypes)) {
      // Check if the file is not a PDF
      return "PDF files only";
    }

    $fileName = $_POST['file_name'];
    $filePath = '/home/l/s/lsyversen/public_html/cps276/assignments/assignment7/uploads/' . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
      // If the file is successfully moved to the upload directory
      $db = new DB();
      $db->insertFile($fileName, $filePath); // Insert file info into the database
      return "File has been added.";
    } else {
      // If there was an issue moving the file
      return "Could not move file";
    }
  }

  public function displayList() {
    $db = new DB();
    $fileList = $db->getFiles(); // Retrieve the list of files from the database

    if (empty($fileList)) {
      // If there are no files in the list
      return "There are no files to display";
    } else {
      // If there are files in the list, generate HTML to display them
      $listHTML = '<ul>';
      foreach ($fileList as $file) {
        $listHTML .= '<li><a href="' . $file['file_path'] . '" target="_blank">' . $file['file_name'] . '</a></li>';
      }
      $listHTML .= '</ul>';
      return $listHTML;
    }
  }
}
?>


