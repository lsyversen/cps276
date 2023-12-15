<?php
session_start();

// Expire the session cookie by setting it back one hour
setcookie("PHPSESSID", "", time() - 3600, "/");

// Destroy session values
session_destroy();

// Redirect to the login page in index.php
header('Location: index.php?page=login');
