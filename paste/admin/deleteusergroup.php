<?php 
include 'config.php';
$id = $_GET['id'];
mysqli_query($link, "DELETE FROM usergroup WHERE id='$id'");
header("Location: usergrouplist.php");
?>