<?php
    // Include StickyForm class
    require_once('classes/StickyForm.php');

    // Create StickyForm instance and ensure security
    $stickyForm = new StickyForm();
    $stickyForm->security();

    // Function to add data to the database
    function addData($post){
    global $elementsArr;

    // Include Pdo_methods class
    require_once('classes/Pdo_methods.php');
    $pdo = new PdoMethods();

    // SQL query for inserting data into the database
    $sql = "INSERT INTO contacts (contact_name, contact_address, contact_city, contact_state, contact_phone, contact_email, contact_DOB, contact_contacts, contact_age) VALUES (:name, :address, :city, :state, :phone, :email, :DOB, :contacts, :age)";

    // Prepare data for binding
    if(isset($post['contactMethod'])){
        $contactMethods = implode("<br>", $post['contactMethod']);
    }else{
        $contactMethods = "no contact";
    }

    $bindings = [
        [':name', $post['name'], 'str'],
        [':address', $post['address'], 'str'],
        [':city', $post['city'], 'str'],
        [':state', $post['state'], 'str'],
        [':phone', $post['phone'], 'str'],
        [':email', $post['email'], 'str'],
        [':DOB', $post['date'], 'str'],
        [':contacts', $contactMethods, 'str'],
        [':age', $post['ageGroup'], 'str']
    ];

    // Execute the SQL query with the provided data
    $result = $pdo->otherBinded($sql, $bindings);

    // Check the result and return appropriate form
    if($result == "error"){
        return getForm("<p class='errorMsg'>There was an error processing your form</p>", $elementsArr);
    }else{
        return getForm("<p class='successMsg'>Contact Added</p>", $elementsArr);
    }
    }

    // Initialize the form
    function init(){
    global $elementsArr, $stickyForm;

    // Check if the form is submitted
    if(isset($_POST['submit'])){
        // Validate form data
        $postArr = $stickyForm->validateForm($_POST, $elementsArr);

        // Check validation status
        if($postArr['masterStatus']['status'] == "noerrors"){
            // Add data to the database if validation is successful
            return addData($_POST);
        }else{
            // Return the form with validation errors
            return getForm("", $postArr);
        }
    }else{
        // Return the form with initial values
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
            "errorMessage"=>"<span class='errorMsg'>Name must be provided and adhere to standard naming conventions</span>",
            "value"=>"Liam Syversen",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"name"
        ],
        "phone"=>[
            "errorMessage"=>"<span class='errorMsg'>Phone must be provided and formatted as 111.111.1111</span>",
            "value"=>"810.123.4567",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"phone"
        ],
        "address"=>[
            "errorMessage"=>"<span class='errorMsg'>Address must be provided and valid</span>",
            "value"=>"1234 Main Street",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"address"
        ],
        "city"=>[
            "errorMessage"=>"<span class='errorMsg'>City name must be provided and valid</span>",
            "value"=>"Brighton",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"name"
        ],
        "state"=>[
            "type"=>"select",
            "options"=>["mi"=>"Michigan","oh"=>"Ohio","pa"=>"Pennsylvania","tx"=>"Texas", "fl"=>"Florida"],
            "selected"=>"mi",
            "regex"=>"name"
        ],
        "email"=>[
            "errorMessage"=>"<span class='errorMsg'>Please enter a valid, non-blank email</span>",
            "value"=>"lsyversen@wccnet.edu",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"email"
        ],
        "date"=>[
            "errorMessage"=>"<span class='errorMsg'>Please enter a valid, non-blank date</span>",
            "value"=>"06/09/2002",
            "errorOutput"=>"",
            "type"=>"text",
            "regex"=>"date"
        ],
        "contactMethod"=>[
            "errorMessage"=>"<span class='errorMsg'>An error occurred</span>",
            "action"=>"none",
            "errorOutput"=>"",
            "type"=>"checkbox",
            "status"=>["Newsletter"=>"", "Email"=>"", "SMS"=>""]
        ],
        "ageGroup"=>[
            "errorMessage"=>"<span class='errorMsg'>You must select an age range</span>",
            "type"=>"radio",
            "errorOutput"=>"",
            "action"=>"required",
            "value"=>["10-18"=>"", "19-30"=>"", "30-50"=>"", "51+"=>""]
        ]
    ];

    // Function to generate the HTML form
    function getForm($acknowledgement, $elementsArr){
        global $stickyForm;
        $options = $stickyForm->createOptions($elementsArr['state']);

        // Heredoc string to create the form
        $form = <<<HTML
            <form method="post" action="index.php?page=addContact">
                <div class="form-group">
                    <label for="name">Name (letters only) {$elementsArr['name']['errorOutput']}</label>
                    <input name="name" id="name" type="text" class="form-control" value="{$elementsArr['name']['value']}">
                </div>
                <div class="form-group">
                    <label for="address">Address (number and street only) {$elementsArr['address']['errorOutput']}</label>
                    <input name="address" id="address" type="text" class="form-control" value="{$elementsArr['address']['value']}">
                </div>
                <div class="form-group">
                    <label for="city">City {$elementsArr['city']['errorOutput']}</label>
                    <input name="city" id="city" type="text" class="form-control" value="{$elementsArr['city']['value']}">
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <select name="state" id="state" class="form-control">
                        $options
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone">Phone {$elementsArr['phone']['errorOutput']}</label>
                    <input name="phone" id="phone" type="text" class="form-control" value="{$elementsArr['phone']['value']}">
                </div>
                <div class="form-group">
                    <label for="email-address">Email {$elementsArr['email']['errorOutput']}</label>
                    <input name="email" id="email" type="text" class="form-control" value="{$elementsArr['email']['value']}">
                </div>
                <div class="form-group">
                    <label for="DOB">Date of Birth (MM/DD/YYYY) {$elementsArr['date']['errorOutput']}</label>
                    <input name="date" id="date" type="text" class="form-control" value="{$elementsArr['date']['value']}">
                </div>
                <p>Please check all contact options (Optional): {$elementsArr['contactMethod']['errorOutput']}</p>
                <span>
                    <div class="form-check form-check-inline">
                        <input name="contactMethod[]" id="contactMethod1" class="form-check-input" type="checkbox" value="Newsletter" {$elementsArr['contactMethod']['status']['Newsletter']}>
                        <label class="form-check-label" for="contactMethod1">Newsletter</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="contactMethod[]" id="contactMethod2" class="form-check-input" type="checkbox" value="Email" {$elementsArr['contactMethod']['status']['Email']}>
                        <label class="form-check-label" for="contactMethod2">Email Updates</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="contactMethod[]" id="contactMethod3" class="form-check-input" type="checkbox" value="SMS" {$elementsArr['contactMethod']['status']['SMS']}>
                        <label class="form-check-label" for="contactMethod3">Text Updates</label>
                    </div>
                </span>
                <p class="padtop">Please select an age range (Required): {$elementsArr['ageGroup']['errorOutput']}</p>
                <span>
                    <div class="form-check form-check-inline">
                        <input name="ageGroup" id="ageGroup1" class="form-check-input" type="radio" value="10-18" {$elementsArr['ageGroup']['value']['10-18']}>
                        <label class="form-check-label" for="ageGroup1">10-18</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="ageGroup" id="ageGroup2" class="form-check-input" type="radio" value="19-30" {$elementsArr['ageGroup']['value']['19-30']}>
                        <label class="form-check-label" for="ageGroup2">19-30</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="ageGroup" id="ageGroup3" class="form-check-input" type="radio" value="30-50" {$elementsArr['ageGroup']['value']['30-50']}>
                        <label class="form-check-label" for="ageGroup3">30-50</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input name="ageGroup" id="ageGroup4" class="form-check-input" type="radio" value="51+" {$elementsArr['ageGroup']['value']['51+']}>
                        <label class="form-check-label" for="ageGroup4">51+</label>
                    </div>
                </span>
                <div class="padtop">
                    <button name="submit" type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        HTML;

        return [$acknowledgement, $form];
    }
?>


