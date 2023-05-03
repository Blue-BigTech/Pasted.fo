<?php
// Import config.php
require_once("config.php");

$result = $mysqli -> query("SELECT `url`,`img` FROM ads WHERE expire > NOW() ORDER BY RAND() LIMIT 2");

$row = mysqli_fetch_assoc($result);
$row1 = mysqli_fetch_assoc($result);

$displayads = true;

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    $ugres = $mysqli -> query("SELECT usergroup FROM accounts WHERE id = {$_SESSION["id"]}");
    $ugrow = mysqli_fetch_array($ugres);
    $usergroup = $ugrow["usergroup"];
    if($usergroup > 0){
        $displayads = false;
    }
}

if($displayads == true){
?>
<div class="banners">
    <a href="<?php echo("redir.php?uri=" . $row['url']); ?>" target="_blank" class="banner"><img src="<?php echo $row['img']; ?>" ></a>
    <a href="<?php echo("redir.php?uri=" . $row1['url']); ?>" target="_blank" class="banner"><img src="<?php echo $row1['img']; ?>" ></a>
</div>
<?php
}
?>