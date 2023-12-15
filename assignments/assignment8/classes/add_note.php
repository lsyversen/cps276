<?php
require_once 'Note.php';

$note = new Note();

// Handle adding a note if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['dateTime']) && !empty($_POST['noteContent'])) {
    $timestamp = $_POST['dateTime'];
    $noteContent = $_POST['noteContent'];
    $note->addNote($timestamp, $noteContent);
}
?>s

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-3">Add Notes</h1>
    <a href="display_notes.php" class="btn btn-primary mb-3">Display Notes</a>

    <!-- Add Note Form -->
    <form method="post">
        <div class="form-group">
            <label for="dateTime">Date and Time:</label>
            <input type="datetime-local" class="form-control" id="dateTime" name="dateTime" required>
        </div>
        <div class="form-group">
            <label for="noteContent">Note Content:</label>
            <textarea class="form-control" id="noteContent" name="noteContent" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Note</button>
    </form>
</div>

</body>
</html>

