<?php
    // Include the necessary class
    require_once 'classes/StickyForm.php';

    // Create an instance of StickyForm and apply security measures
    $stickyForm = new StickyForm(); 
    $stickyForm->security();

    /**
     * Initialize the deleteContacts page
     *
     * @return array An array containing the message and output to be displayed
     */
    function init(){
        // Include the Pdo_methods class
        require_once 'classes/Pdo_methods.php';

        // Check if the delete button is pressed
        if(isset($_POST['delete'])){
            // Check if any checkboxes are selected for deletion
            if(isset($_POST['chkbx'])){
                // Initialize error variable
                $error = "noError";
                
                // Loop through selected checkboxes and delete corresponding contacts
                foreach($_POST['chkbx'] as $id){
                    // Create a PDO instance
                    $sql = "DELETE FROM contacts WHERE contact_id=:id";
                    $pdo = new PdoMethods();
                    $bindings = [[':id', $id, 'int'],];
    
                    // Perform the delete operation
                    $result = $pdo->otherBinded($sql, $bindings);
                    
                    // Check for errors during deletion
                    if($result === 'error'){
                        $error = "error"; 
                        break;
                    }
                }
            }else{
                // No checkboxes selected for deletion
                $error = "noneSelected";
            }
        }    

        // Retrieve all contact records
        $sql = "SELECT * FROM contacts";
        $pdo = new PdoMethods(); 
        $output = "";
        
        // Fetch records after deletion
        $records = $pdo->selectNotBinded($sql);

        // Check if there are records to display
        if(count($records) === 0){
            $output = "<p>There are no records to display</p>";
            return [$output,""];
        }else{
            // Display a form with contact records and checkboxes
            $output = "<form method='post' action='index.php?page=deleteContacts'>";
            $output .= "<input name='delete' value='Delete'type='submit' class='btn btn-danger'/><br><br>
            <table class='table table-striped table-bordered'>
                <thead><tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Contact</th>
                    <th>Age</th>
                    <th>Delete</th>
            </tr></thead><tbody>";

            // Loop through the records and display them in a table
            foreach($records as $row){
                $output .= "<tr>
                <td>{$row['contact_name']}</td>
                <td>{$row['contact_address']}</td>
                <td>{$row['contact_city']}</td>
                <td>{$row['contact_state']}</td>
                <td>{$row['contact_phone']}</td>
                <td>{$row['contact_email']}</td>
                <td>{$row['contact_DOB']}</td>
                <td>{$row['contact_contacts']}</td>
                <td>{$row['contact_age']}</td>
                <td><input type='checkbox' name='chkbx[]' value='{$row['contact_id']}' /></td></tr>";
            }

            $output .= "</tbody></table></form>";

            // Display messages based on the deletion result
            if(isset($error)){
                switch ($error){
                    case 'noError':
                        $msg = "<p class='successMsg'>Contact(s) deleted</p>";
                        break;
                    case 'noneSelected':
                        $msg = "<p class='errorMsg'>Please select a contact to delete.</p>";
                        break;
                    default:
                        $msg = "<p class='errorMsg'>Could not delete the contact(s)</p>";
                        break;
                }
            }else{
                $msg = "";
            }

            return [$msg, $output];
        }        
    }
?>

