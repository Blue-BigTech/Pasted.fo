<head>
     <link rel="shortcut icon" href="pn.ico" />
</head>


<?php
// Import config.php
require_once("includes/config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Top Pastes | Pasted.fo</title>
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        
        <?php

            include("includes/customcolor.php");

        ?>
    </head>


    <body>
        <div class="wrapper">
        <?php

$accounttext = "Account";
$accountug = 0;

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    $accounttext = $_SESSION["username"];
    $ugres = $mysqli -> query("SELECT usergroup FROM accounts WHERE username = '{$_SESSION["username"]}';");
    $ugrow = mysqli_fetch_array($ugres);
    $accountug = $ugrow["usergroup"];
}

?>

            
            <?php
include 'includes/header.php';
include 'includes/ads.php';
?>
            <h2 class="pagetitle">Top Pastes</h2>
                <table class="pastelist">
                    <tr class="toprow">
                        <th>Paste</th>
                        <th>Views</th>
                        <th class="td-creator">Creator</th>
                        <th class="td-time">Creation Time</th>
                    </tr>
                    <?php
                        if($res = $mysqli -> query("SELECT *,UNIX_TIMESTAMP(create_time) as unix FROM pastes WHERE visibility = 'public' AND expire > " . time() . " ORDER BY views DESC LIMIT 10")){
                            while($row = mysqli_fetch_array($res)){
                                $username = "Anonymous";
                                $usergroup = 0;
                                if(!empty($row["username"])){
                                    $username = $row["username"];
                                    $ugres = $mysqli -> query("SELECT usergroup FROM accounts WHERE username = '{$username}';");
                                    $ugrow = mysqli_fetch_array($ugres);
                                    $usergroup = $ugrow["usergroup"];
                                }
                    ?>
                    <tr>
                        <td><a href="/paste.php?p=<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></a></td>
                        <td><?php echo $row["views"]; ?></td>
                        <td class="td-creator">by <span class="ug-<?php echo $usergroup; ?>"><?php echo $username; ?></span></td>
                        <td class="td-time"><?php echo time2str($row["unix"]); ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>

        </div>
    </body>
</html>
<?php include 'includes/footer.php'; ?>