<?php
    require_once('classes/StickyForm.php');
    $stickyForm = new StickyForm(); 
    
    // Define the initial form elements with default values
    $elementsArr = [
        "masterStatus"=>[
            "status"=>"noerrors",
            "type"=>"masterStatus"
        ],
        "email"=>[
            "errorMessage"=>"<span class='errorMsg'>Please enter a valid email</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"lsyversen@admin.com",
            "regex"=>"email" 
        ],
        "password"=>[
            "errorMessage"=>"<span class='errorMsg'>Password must not be blank</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"password",
            "regex"=>"nonBlank"
        ]
    ];

    // Function to initialize the login page
    function init(){
        global $elementsArr, $stickyForm;

        // Check if the login form is submitted
        if(isset($_POST['login'])){ 
            // Validate form inputs and get the validation results
            $postArr = $stickyForm->validateForm($_POST, $elementsArr);

            // Attempt to log in using the provided credentials
            $loginOutput = $stickyForm->login($_POST);

            // Check if the form validation has no errors
            if($postArr['masterStatus']['status'] == "noerrors"){
                // Check if login is successful
                if($loginOutput === 'success'){
                    // Redirect to the welcome page on successful login
                    header('Location: index.php?page=welcome');
                }

                // Return the login form with appropriate messages
                return getForm($loginOutput, $postArr);
            }
            else{
                // Return the login form with validation errors
                return getForm("", $postArr);
            }
        }
        else {
            // Return the login form with default values
            return getForm("", $elementsArr);
        } 
    }

    // Function to generate the login form HTML
    function getForm($acknowledgement, $elementsArr){
        global $stickyForm;

        // Construct the HTML for the login form
        $loginForm = <<<HTML
            <form name="login" action="index.php?page=login" method="post">
                <div class="form-group">
                    <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
                    <input type="text" class="form-control" name="email" id="email" value="{$elementsArr['email']['value']}">
                </div>
                <div class="form-group">
                    <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
                    <input type="password" class="form-control" name="password" id="password" value="{$elementsArr['password']['value']}">
                </div>
                <div class="form-group padtop">
                    <input type="submit" class="btn btn-primary" name="login" id="login" value="Log In">
                </div> 
            </form>
        HTML;   

        // Return an array with acknowledgement message and login form HTML
        return [$acknowledgement, $loginForm];
    }
?>

