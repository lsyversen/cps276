<?php
// Include StickyForm class
require_once('classes/StickyForm.php');

// Create StickyForm instance and ensure security
$stickyForm = new StickyForm();
$stickyForm->security();

// Initialize the form
function init(){
    global $elementsArr, $stickyForm;

    if(isset($_POST['submit'])){
        $postArr = $stickyForm->validateForm($_POST, $elementsArr);
        if($postArr['masterStatus']['status'] == "noerrors"){
            return addData($_POST);
        }else{
            return getForm("", $postArr);
        }
    }else{
        return getForm("", $elementsArr);
    }
}

// Function to add data to the database
function addData($post){
    global $elementsArr;
    require_once('classes/Pdo_methods.php');
    $pdo = new PdoMethods();

    $sql = "SELECT admin_email FROM admins WHERE admin_email = :email";
    $bindings = [[':email', $post['email'], 'str']];

    $records = $pdo->selectBinded($sql, $bindings);

    if($records == 'error'){return getForm("<p class='errorMsg'>There was an error processing your request.</p>", $elementsArr);}
    if(count($records) != 0){return getForm("<p class='errorMsg'>Email already in use.</p>", $elementsArr);}

    $sql = "INSERT INTO admins (admin_name, admin_email, admin_password, admin_status) VALUES (:name, :email, :password, :status)";
    $bindings = [
        [':name', $post['name'], 'str'],
        [':email', $post['email'], 'str'],
        [':password', password_hash($post['password'], PASSWORD_DEFAULT), 'str'],
        [':status', $post['status'], 'str']
    ];

    $result = $pdo->otherBinded($sql, $bindings);

    if($result == "error"){
        return getForm("<p class='errorMsg'>There was a problem processing your form.</p>", $elementsArr);
    }else{
        return getForm("<p class='successMsg'>Admin Added</p>", $elementsArr);
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

    return [$acknowledgement, $form];
}
?>

