<?php
class addNameProc {
    private $names;
    //constructor for array names
    public function __construct() {
        session_start();
        if (!isset($_SESSION['names'])) {
            $_SESSION['names'] = array();
        }
        $this->names = &$_SESSION['names'];
    }
    //add name or clear functionality 
    public function addClearNames() {
        $output = ' ';
        if (isset($_POST["add"])) {
            $name = $_POST["name"];
            $f = explode(" ", $name);
            $this->names[] = array("lname" => $f[1], "fname" => $f[0]);
        } else if (isset($_POST["clear"])) {
            $this->names = array();
        }
        //creates a sorted copy of $names by iterating through each person
        $sortedNames = $this->names;
        usort($sortedNames, function($a, $b) {
            return strcmp($a['lname'], $b['lname']);
        });

        foreach ($sortedNames as $person) {
            $output .= $person['lname'] . ", " . $person['fname'] . "\n";
        }
        return $output;
    }
}
?>