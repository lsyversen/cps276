<?php
    // Include StickyForm class
    require_once('classes/StickyForm.php');

    // Create StickyForm instance and ensure security
    $stickyForm = new StickyForm();
    $stickyForm->security();

    // Function to add data to the database
    function addData($post){
        global $elementsArr;
        require_once('classes/Pdo_methods.php');
        $pdo = new PdoMethods();

        // Check if the provided email already exists in the database
        $sql = "SELECT admin_email FROM admins WHERE admin_email = :email";
        $bindings = [[':email', $post['email'], 'str']];
        $records = $pdo->selectBinded($sql, $bindings);

        // Check for errors in the database query
        if ($records == 'error') {
            return getForm("<p class='errorMsg'>There was an error processing your request.</p>", $elementsArr);
        }

        // If the email already exists, display an error message
        if (count($records) != 0) {
            return getForm("<p class='errorMsg'>Email already in use.</p>", $elementsArr);
        }

        // If email is unique, insert the admin data into the database
        $sql = "INSERT INTO admins (admin_name, admin_email, admin_password, admin_status) VALUES (:name, :email, :password, :status)";
        $bindings = [
            [':name', $post['name'], 'str'],
            [':email', $post['email'], 'str'],
            [':password', password_hash($post['password'], PASSWORD_DEFAULT), 'str'],
            [':status', $post['status'], 'str']
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        // Check the result of the database insertion and display appropriate form
        if ($result == "error") {
            return getForm("<p class='errorMsg'>There was a problem processing your form.</p>", $elementsArr);
        } else {
            return getForm("<p class='successMsg'>Admin Added</p>", $elementsArr);
        }
    }

    // Initialize the form
    function init(){
        global $elementsArr, $stickyForm;

        // Check if the user has the necessary access and status
        if ($_SESSION['access'] !== "accessGranted" || $_SESSION['status'] !== "admin") {
            header('Location: index.php?page=login');
        }

        // If the form is submitted, validate and process the data
        if (isset($_POST['submit'])) {
            // Validate form data and get updated form array
            $postArr = $stickyForm->validateForm($_POST, $elementsArr);

            // If there are no errors, add data to the database
            if ($postArr['masterStatus']['status'] == "noerrors") {
                return addData($_POST);
            } else {
                // If there are errors, display the form with error messages
                return getForm("", $postArr);
            }
        } else {
            // Display the initial form
            return getForm("", $elementsArr);
        }
    }

    // Array defining form elements and their initial values
    $elementsArr = [
        "masterStatus"=>[
            "status"=>"noerrors",
            "type"=>"masterStatus"
        ],
        "name"=>[
            "errorMessage"=>"<span class='errorMsg'>Name cannot be blank and must be a valid name</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"Liam Syversen",
            "regex"=>"name"
        ],
        "email"=>[
            "errorMessage"=>"<span class='errorMsg'>Invalid email format</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"lsyversen@wccnet.edu",
            "regex"=>"email"
        ],
        "password"=>[
            "errorMessage"=>"<span class='errorMsg'>Please choose a stronger password (at least 8 characters)</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"password",
            "regex"=>"password"
        ],
        "status"=>[
            "errorMessage"=>"<span class='errorMsg'>An error occurred</span>",
            "errorOutput"=>"",
            "type"=>"select",
            "options"=>["admin"=>"Admin","staff"=>"Staff"],
            "selected"=>"staff",
            "regex"=>"name"
        ]
    ];

    // Function to generate the HTML form
    function getForm($acknowledgement, $elementsArr){
        global $stickyForm;
        $options = $stickyForm->createOptions($elementsArr['status']);

        $form = <<<HTML
            <form name="addAdmin" method="post" action="index.php?page=addAdmin">
                <div class="form-group">
                    <label for="name">Name (letters only) {$elementsArr['name']['errorOutput']}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{$elementsArr['name']['value']}">
                </div>
                <div class="form-group">
                    <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
                    <input type="text" class="form-control" id="email" name="email" value="{$elementsArr['email']['value']}">
                </div>
                <div class="form-group">
                    <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
                    <input type="password" class="form-control" id="password" name="password" value="{$elementsArr['password']['value']}">
                </div>
                <div class="form-group">
                    <label for="status">Status {$elementsArr['status']['errorOutput']}</label>
                    <select class="form-control" id="status" name="status">
                        $options
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" id="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        HTML;

        // Return an array containing an acknowledgement and the form
        return [$acknowledgement, $form];
    }
?>

