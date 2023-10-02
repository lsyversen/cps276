<?php

$mainNumber = "5";
$subNumber = "5";
$print = "<ul>";
for($i=1;$i<=$mainNumber;$i++){
        $print .= "<li> $i<ul>";
        for($j=1;$j<=$subNumber;$j++){
            $print .= "<li>$j";
         }
         $print .= "</ul>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <title>Exercise1</title>
    </head>
    <body>
        <?php echo $print; ?>
    </body>
</html>