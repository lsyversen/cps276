<?php
require_once 'addNameProc.php';
$namelist = new addNameProc();
$output = $namelist->addClearNames();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Name List</title>
</head>
<body>
  <div class="container">
    <h1>Add Names</h1>
    <form method="post">
      <button type="submit" class="btn btn-primary" name="add">Add Name</button>
      <button type="submit" class="btn btn-primary" name="clear">Clear Names</button>
      <div class="form-group">
        <label for="name">Enter Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter first and last name">
      </div>
    </form>
    <br>
    <div class="form-group">
      <label for="list">List of Names</label>
      <textarea style="height: 500px;" class="form-control" id="namelist" name="namelist"><?php echo $output ?></textarea>
    </div>
  </div>
</body>
</html>