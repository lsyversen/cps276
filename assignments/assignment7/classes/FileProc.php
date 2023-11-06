<?php
require_once 'classes/DB.php';

class FileProc {
  private $uploadDir = 'uploads/'; // Your PDF files upload directory
  private $allowedMimeTypes = ['application/pdf'];
  private $maxFileSize = 100000; // 100KB

  public function init() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return [$this->fileUpload(), $this->displayList()];
    } else {
      return ["", $this->displayList()];
    }
  }

  public function fileUpload() {
    if (empty($_POST['file_name'])) {
      return "No file name was entered";
    }

    if (empty($_FILES['file']['name'])) {
      return "No file was uploaded. Make sure you choose a file to upload.";
    }

    $fileSize = $_FILES['file']['size'];
    $fileType = mime_content_type($_FILES['file']['tmp_name']);

    if ($fileSize > $this->maxFileSize) {
      return "The file is too large";
    }

    if (!in_array($fileType, $this->allowedMimeTypes)) {
      return "PDF files only";
    }

    $fileName = $_POST['file_name'];
    $filePath = $this->uploadDir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
      $db = new DB();
      $db->insertFile($fileName, $filePath);
      return "File has been added.";
    } else {
      return "Could not move file";
    }
  }

  public function displayList() {
    $db = new DB();
    $fileList = $db->getFiles();

    if (empty($fileList)) {
      return "There are no files to display";
    } else {
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

