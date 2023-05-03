<?php
// Include config file
require_once "config.php";
define('Include', TRUE);

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["Aloggedin"]) || $_SESSION["Aloggedin"] !== true){
    header("location: login.php");
    exit;
}


if(!isset($_GET["id"]) || empty($_GET["id"])){
    exit;
}

if($stmt = mysqli_prepare($link, "DELETE FROM ads WHERE id = ?")){
    mysqli_stmt_bind_param($stmt, "s", $param_url);
    $param_url = $_GET["id"];

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    header("location: ads.php");
}

?>