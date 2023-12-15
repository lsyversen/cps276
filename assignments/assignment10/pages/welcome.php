<?php
    // Necessary class
    require_once 'classes/StickyForm.php';

    // Create an instance of StickyForm and apply security measures
    $stickyForm = new StickyForm(); 
    $stickyForm->security();

    //Initialize the welcome page
    function init(){
        // Return a welcome message with the user's name
        return ["", "Welcome ".$_SESSION['name']];
    }
?>
