<?php
require_once 'Note.php';

$note = new Note();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $startDate = isset($_POST['begDate']) ? $_POST['begDate'] : date('Y-m-d');
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : date('Y-m-d');
    
    // Retrieve notes within the date range
    $notes = $note->getNotes($startDate, $endDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Notes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-3">Display Notes</h1>
    <a href="add_note.php" class="btn btn-primary mb-3">Add Notes</a>

    <!-- Display Notes Form -->
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="begDate">Beginning Date:</label>
                <input type="date" class="form-control" id="begDate" name="begDate" required>
            </div>
            <div class="form-group col-md-3">
                <label for="endDate">End Date:</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="form-group col-md-2">
                <label for="getNotesBtn"></label>
                <button type="submit" class="btn btn-primary form-control" id="getNotesBtn">Get Notes</button>
            </div>
        </div>
    </form>

    <!-- Display Notes Table -->
    <?php if (isset($notes) && !empty($notes)) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Date and Time</th>
                    <th>Note Content</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notes as $note) : ?>
                    <tr>
                        <td><?php echo date('m/d/Y h:i A', strtotime($note['timestamp'])); ?></td>
                        <td><?php echo $note['note_content']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($notes) && empty($notes)) : ?>
        <p>No notes available for the selected date range.</p>
    <?php endif; ?>
</div>

</body>
</html>
