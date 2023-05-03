<?php 
include 'includes/config.php';
$usernameid = $_SESSION["username"];
mysqli_query($mysqli, "DELETE FROM accounts WHERE username='$usernameid'");
session_destroy();
header("Location: /index.php");
?>