<?php
// Import config.php
require_once("includes/config.php");

session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login");
    exit;
}

$ugres = $mysqli->query("SELECT usergroup FROM accounts WHERE id = {$_SESSION["id"]}");
$ugrow = mysqli_fetch_array($ugres);
$usergroup = $ugrow["usergroup"];

$pcres = $mysqli->query("SELECT count(id) as pcnt FROM pastes WHERE expire > " . time() . " AND username = '{$_SESSION["username"]}'");
$pcrow = mysqli_fetch_array($pcres);
$pastecount = $pcrow["pcnt"];


$vcres = $mysqli->query("SELECT SUM(views) as vcnt FROM pastes WHERE expire > " . time() . " AND username = '{$_SESSION["username"]}'");
$vcrow = mysqli_fetch_array($vcres);
$viewcount = $vcrow["vcnt"];

?>

<?php
include 'includes/header.php';
include 'includes/ads.php';
?>
<div class="wrapper">
    <div class="page-header">
    <hr>
    <h2 class="pagetitle">My Account</h2>
    <hr>
</div>
    <form class="settingsform">
        <div class="form-elements" style="margin: 0; flex-direction: column;">

            <h3 class="pagetitle"><span class="ug-<?php echo $usergroup; ?>"><?php echo $_SESSION["username"]; ?></span></h3>
            <h4 class="pagetitle" style="text-align: center; margin: 0px 0px 20px 0px;"><?php echo $pastecount; ?> pastes<br><?php echo $viewcount; ?> views</h4>
            <a class="util-button" href="mypastes">My Pastes</a>
            <a class="util-button" href="changepw">Change Password</a>
            <a class="util-button" href="logout">Logout</a>
            <a class="util-button" style="background-color: red;" href="selfdestruct.php">Delete Account</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>