<?php
    // Include the necessary class
    require_once 'classes/StickyForm.php';
    $stickyForm = new StickyForm(); 

    // Set the default path
    $path = "index.php?page=login";

    // Define CSS styles
    $css = <<<css
    <style>
        .nav-header li {
            margin-right: 22px;
        }
        .nav-header ul {
            display: flex;
            margin: 0;
            padding: 12px;
        }
        .nav-header {
            list-style: none;
            display: flex;
            padding: 12px;
        }
    </style>
    <style>.padtop {padding-top: 12px;}</style>
    <style>.errorMsg span{color: red; margin-left: 12px;} .errorMsg{color: red;}</style>
    <style>.successMsg{color: green;}</style>
    css;

    // Initialize navigation with CSS styles
    $nav = $css;

    // Start the session
    session_start();

    // Check for access and user status
    if(isset($_SESSION['access'])){
        if($_SESSION['access'] == "accessGranted"){
            if($_SESSION['status'] == "admin"){
                // Navigation for admin
                $nav = <<<HTML
                $css
                <nav>
                    <ul class="nav-header">
                        <li><a href="index.php?page=addContact">Add Contact</a></li>
                        <li><a href="index.php?page=deleteContacts">Delete contact(s)</a></li>    
                        <li><a href="index.php?page=addAdmin">Add Admin</a></li>
                        <li><a href="index.php?page=deleteAdmins">Delete Admin(s)</a></li> 
                        <li><a href="logout.php">Logout</a></li>    
                    </ul>
                </nav>
                HTML;
            } else if($_SESSION['status'] == "staff"){
                // Navigation for staff
                $nav = <<<HTML
                $css
                <nav>
                    <ul class="nav-header">
                        <li><a href="index.php?page=addContact">Add Contact</a></li>
                        <li><a href="index.php?page=deleteContacts">Delete contact(s)</a></li>  
                        <li><a href="logout.php">Logout</a></li>   
                    </ul>
                </nav>
                HTML;
            }
        }
    }

    // End the session
    session_abort();

    // Check for the page parameter in the URL
    if(isset($_GET)){
        if($_GET['page'] === "welcome"){
            // Include and initialize the welcome page
            require_once('pages/welcome.php');
            $nav .= "<h1>Welcome</h1>";
            $result = init();
        }
        else if($_GET['page'] === "addAdmin"){
            // Include and initialize the addAdmin page
            require_once('pages/addAdmin.php');
            $nav .= "<h1>Add Admin</h1>";
            $result = init();
        }
        else if($_GET['page'] === "addContact"){
            // Include and initialize the addContact page
            require_once('pages/addContact.php');
            $nav .= "<h1>Add Contact</h1>";
            $result = init();
        }
        else if($_GET['page'] === "deleteAdmins"){
            // Include and initialize the deleteAdmins page
            require_once('pages/deleteAdmins.php');
            $nav .= "<h1>Delete Admin(s)</h1>";
            $result = init();
        }
        else if($_GET['page'] === "deleteContacts"){
            // Include and initialize the deleteContacts page
            require_once('pages/deleteContacts.php');
            $nav .= "<h1>Delete Contact(s)</h1>";
            $result = init();
        }
        else if($_GET['page'] === "login"){
            // Include and initialize the login page
            require_once('pages/login.php');
            $nav .= "<h1>Login</h1>";
            $result = init();
        }
        else {
            // Redirect to the default path if the page is not recognized
            header('location: '.$path);
        }
    } else {
        // Redirect to the default path if no page parameter is provided
        header('location: '.$path);
    }

?>
