<?php
require_once 'DBConn.php'; // Include the correct database connection class

class DB {
  private $conn;

  public function __construct() {
    $db = new DatabaseConn();
    $this->conn = $db->dbOpen(); // Create an instance and then call the non-static method
  }

  public function insertFile($file_name, $file_path) {
    $stmt = $this->conn->prepare("INSERT INTO files (file_name, file_path) VALUES (:file_name, :file_path)");
    $stmt->bindParam(':file_name', $file_name, PDO::PARAM_STR);
    $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
    $stmt->execute();
  }

  public function getFiles() {
    $stmt = $this->conn->query("SELECT file_name, file_path FROM files");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>



