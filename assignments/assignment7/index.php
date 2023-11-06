<?php
require_once 'classes/FileProc.php';
$fileProc = new FileProc();
$results = $fileProc->init();
?>

<!DOCTYPE html>
<html>
<head>
  <title>File Upload and Display</title>
  <!-- Include Bootstrap CSS here -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>Upload File</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="file_name">Enter file name:</label>
        <input type="text" class="form-control" name="file_name" id="file_name" placeholder="Enter file name" required>
      </div>
      <div class="form-group">
        <label for="file">Select a PDF file:</label>
        <input type="file" class="form-control-file" name="file" id="file" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload File</button>
    </form>
    <h2>Display File List</h2>
    <?php
    echo $results[1]; // Display list of files
    ?>
  </div>
  <!-- Include Bootstrap JS here -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
