<?php
// Import config.php
require_once("includes/config.php");

session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$cleanid = "";
$username = "";

if($stmt = mysqli_prepare($mysqli, "SELECT id,username FROM pastes WHERE id = ?")){
    mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $_GET["pid"];

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $temp_id, $temp_username);

    while( $stmt->fetch() ) {
        $cleanid = $temp_id;
        $username = $temp_username;
    }
}

if($username == $_SESSION["username"]){
    if($mysqli -> query("UPDATE `pastes` SET expire = 0 WHERE id = '{$cleanid}' AND username = '{$_SESSION["username"]}'")){
        exit("OK");
    }
}

?>