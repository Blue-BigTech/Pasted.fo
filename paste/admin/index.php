<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["Aloggedin"]) && $_SESSION["Aloggedin"] === true){
    header("location: dashboard.php");
    exit;
}

header("location: login.php");

?>