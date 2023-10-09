<?php
class Calculator {
    public function calc($operator, $firstNum = null, $secondNum = null) {
        if ($firstNum === null || $secondNum === null || !is_string($operator)) {
            return "You must enter a string and two numbers";
        }
        switch ($operator) {
            case '+':
                $result = $firstNum + $secondNum;
                return "The sum of the numbers is $result";
            case '-':
                $result = $firstNum - $secondNum;
                return "The difference of the numbers is $result";
            case '*':
                $result = $firstNum * $secondNum;
                return "The product of the numbers is $result";
            case '/':
                if ($secondNum == 0) {
                    return "Cannot divide by zero";
                }
                $result = $firstNum / $secondNum;
                return "The division of the numbers is $result";
            default:
                return "Invalid operator";
        }
    }
}
?>