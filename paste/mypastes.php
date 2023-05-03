<?php
// Import config.php
require_once("includes/config.php");

// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<div class="wrapper">
<?php
include 'includes/header.php';
include("includes/ads.php");
?>
<h2 class="pagetitle">My Pastes</h2>
<table class="pastelist">
    <tr class="toprow">
        <th>Paste</th>
        <th>Views</th>
        <th class="td-time">Creation Time</th>
        <th>Delete</th>
    </tr>
    <?php
   if ($res = $mysqli->query("SELECT *, UNIX_TIMESTAMP(create_time) as unix FROM pastes WHERE expire > " . time() . " AND username = '{$_SESSION["username"]}' ORDER BY create_time DESC")) {
  while ($row = mysqli_fetch_array($res)) {
    $create_time = date('Y-m-d H:i:s', $row['unix']);
    // The 'Y-m-d H:i:s' format string represents the date and time in the format of "Year-Month-Day Hour:Minute:Second"
    ?>
            <tr>
                <td><a href="/paste.php?p=<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></a></td>
                <td><?php echo $row["views"]; ?></td>
                <td class="td-time"><?php echo $create_time; ?></td>
                <td><a title="Delete Paste" class="remove-btn" onclick="remove('<?php echo $row["id"]; ?>');"><img src="assets/svg/trash-can-solid.svg"></a></td>
            </tr>
    <?php
        }
    }
    ?>
</table>
<a class="util-button" href="dashboard.php">Go Back</a>
</div>
<?php include 'includes/footer.php'; ?>