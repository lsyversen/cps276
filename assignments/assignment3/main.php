<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <title>Calculator</title>
    </head>
    <body>
        <?php
        require_once "calculator.php";
        $Calculator = new Calculator();
        echo $Calculator->calc("/", 10, 0) . "<br>"; //will output Cannot divide by zero
        echo $Calculator->calc("*", 10, 2) . "<br>"; //will output The product of the numbers is 20
        echo $Calculator->calc("/", 10, 2) . "<br>"; //will output The division of the numbers is 5
        echo $Calculator->calc("-", 10, 2) . "<br>"; //will output The difference of the numbers is 8
        echo $Calculator->calc("+", 10, 2) . "<br>"; //will output The sum of the numbers is 12
        echo $Calculator->calc("*", 10) . "<br>"; //will output You must enter a string and two numbers
        echo $Calculator->calc(10) . "<br>"; //will output You must enter a string and two numbers
        ?>
    </body>
</html>