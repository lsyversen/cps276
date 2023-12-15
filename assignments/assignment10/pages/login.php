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
            "value"=>"lsyversen@admin.com",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"email" 
        ],
        "password"=>[
            "value"=>"password",
            "errorMessage"=>"<span class='errorMsg'>Password must not be blank</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"nonBlank"
        ]
    ];

    // Function to initialize the login page
    function init(){
        global $stickyForm ,$elementsArr;

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
                    <input name="email" id="email" type="text" class="form-control" value="{$elementsArr['email']['value']}">
                </div>
                <div class="form-group">
                    <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
                    <input name="password" id="password" type="password" class="form-control" value="{$elementsArr['password']['value']}">
                </div>
                <div class="form-group padtop">
                    <input name="login" id="login" type="submit" class="btn btn-primary" value="Log In">
                </div> 
            </form>
        HTML;   

        // Return an array with acknowledgement message and login form HTML
        return [$acknowledgement, $loginForm];
    }
?>

