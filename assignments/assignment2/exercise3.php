<?php

$i=1;
$j=1;

$row = 15;
$cell =5;

$table = "<table border='1'>";

while ($i <= $row){
    $table .= "<tr>";
    $j = 0;
    while ($j < $cell){
        $tempJ = 0;
        $tempJ = $j + 1;
        $table .= "<td>Row $i Cell $tempJ</td>";
        $j++;
    }
    $i++;
    $table .= "</tr>";
}

$table .= "</table>";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Exercise3</title>
    </head>
    <body>
        <?php echo $table; ?>
</body>
</html>
    