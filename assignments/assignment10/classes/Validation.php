<?php

class Validation {
    
    // Flag to track if one or more errors are found
    private $error = false;

     // Login method to validate credentials
     public function login($post) {
        require_once 'classes/Pdo_methods.php';
        $pdo = new PdoMethods();
        $sql = "SELECT admin_email, admin_name, admin_password, admin_status FROM admins WHERE admin_email = :email";
        $bindings = [[':email', $post['email'], 'str']];

        $records = $pdo->selectBinded($sql, $bindings);

        if (count($records) != 0) {
            if (password_verify($post['password'], $records[0]['admin_password'])) {
                session_start();
                $_SESSION['status'] = $records[0]['admin_status'];
                $_SESSION['access'] = "accessGranted";
                $_SESSION['name'] = $records[0]['admin_name'];
                return "success"; // 
            } else {
                return "<p class='errorMsg'>Wrong credentials.</p>"; // Password doesn't match
            }
        } else {
            return "<p class='errorMsg'>Wrong credentials</p>"; // No records
        }
    }

    // Security method to check if access is granted
    public function security() {
        session_start();
        if ($_SESSION['access'] !== "accessGranted") {
            header('location: index.php?page=login');
        }
    }
    // Switch statement to determine which validation method to call based on regex
    public function checkFormat($value, $regex) {
        switch($regex) {
            case "name": return $this->validateName($value); break;
            case "email": return $this->validateEmail($value); break;
            case "password": return $this->validatePassword($value); break;
            case "phone": return $this->validatePhone($value); break;
            case "address": return $this->validateAddress($value); break;
            case "date": return $this->validateDate($value); break;
            case "nonBlank": return $this->validateNonBlank($value); break;
        }
    }

    // Validation method for addresses
       private function validateAddress($value) {
        $match = preg_match('/^(\d{2,})(\s\w.\s)?(\b\w*(-?\w*?)\b\s){1,4}(\w*.$)/im', $value);
        return $this->setError($match);
    }
    // Validation method for names
    private function validateName($value) {
        $match = preg_match('/^[a-z-\' ]{1,50}$/i', $value);
        return $this->setError($match);
    }
      // Validation method for emails
    private function validateEmail($value) {
        $match = preg_match('/^\S+@\S+\.\S+$/i', $value);
        return $this->setError($match);
    }
    // Validation method for phone numbers
    private function validatePhone($value) {
        $match = preg_match('/\d{3}\.\d{3}.\d{4}/', $value);
        return $this->setError($match);
    }

    // Validation method for dates
    private function validateDate($value) {
        $match = preg_match('/([1-9]|0[1-9]|1[012]).([1-9]|0[1-9]|1[0-9]|2[0-9]|3[01]).([12][0-99])?([0-9]{2})$/m' , $value);
        return $this->setError($match);
    }

    // Validation method for passwords
    private function validatePassword($value) {
        $match = preg_match('/[[:alnum:]]{8,50}[*.!@#$%^&():;<>,.?~_+-=|]{0,10}/i', $value);
        return $this->setError($match);
    }

    // Validation method for non-blank values
    private function validateNonBlank($value) {
        $match = preg_match('/[[:alnum:]]{1,50}[*.!@#$%^&():;<>,.?~_+-=|]{0,10}/i', $value);
        return $this->setError($match);
    }

    // Helper method to set error flag
    private function setError($match) {
        if (!$match) {
            $this->error = true;
            return "error";
        } else {
            return "";
        }
    }

    // Check if there are any errors
    public function checkErrors() {
        return $this->error;
    }

}
