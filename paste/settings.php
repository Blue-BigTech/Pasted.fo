<?php
// Import config.php
require_once("includes/config.php");

$currentcolor = "#00f784";

if (isset($_COOKIE["color"])) {
    $currentcolor = $_COOKIE["color"];
}

$currentvisibility = "public";

if (isset($_COOKIE["visibility"])) {
    $currentvisibility = $_COOKIE["visibility"];
}

$currentglow = 0;

if (isset($_COOKIE["glow"])) {
    $currentglow = $_COOKIE["glow"];
}


?>

<div class="wrapper">

<?php
include 'includes/header.php';
include("includes/ads.php");
?>

    <div class="page-header">
    <h2 class="pagetitle">Settings</h2>
</div>
    <form class="settingsform" method="POST" action="setsettings.php">
        <div class="form-elements" style="margin: 0; flex-direction: column;">

            <h4 class="paste-info">Paste Visibility (Default)</h4>
            <select id="visibility" name="visibility" class="form-element">
                <option value="public" <?php if ($currentvisibility == "public") {
                                            echo "selected";
                                        } ?>>Public</option>
                <option value="private" <?php if ($currentvisibility == "private") {
                                            echo "selected";
                                        } ?>>Private</option>
            </select>
            <button type="submit">Save Settings</button>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>