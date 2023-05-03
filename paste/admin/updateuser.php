<?php 
include 'config.php';

if (isset($_POST['edituserbtn'])) {
    $username = $_POST['username'];
    $usergroup = $_POST['usergroup'];
    mysqli_query($link, "UPDATE accounts SET usergroup='$usergroup' WHERE username='$username'");
    header("Location: reguserlist.php");
}
?>