<?php

class Note {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=lsyversen', 'lsyversen', '2DxbYbF5gyf5');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function addNote($timestamp, $noteContent) {
        $sql = "INSERT INTO notes (timestamp, note_content) VALUES (:timestamp, :noteContent)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->bindParam(':noteContent', $noteContent);
        $stmt->execute();
    }

    public function getNotes($startDate, $endDate) {
        $sql = "SELECT * FROM notes WHERE timestamp BETWEEN :startDate AND :endDate ORDER BY timestamp DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

