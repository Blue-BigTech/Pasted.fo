<head>
    <link rel="shortcut icon" href="pn.ico" />
</head>


<?php
// Import config.php
require_once("includes/config.php");
require_once("includes/functions.php");

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if (!isset($_GET["p"])) {
    exit("Error p not defined.");
}

$content = "";
$title = "";
$syntax = "";
$cleanid = "";
$expire = 0;
$username = "";
$password = "";

if ($stmt = mysqli_prepare($mysqli, "SELECT `id`, `content`, `title`, `syntax`, `expire`, `username`, `password` FROM `pastes` WHERE `id` = ?")) {
    mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $_GET["p"];

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $temp_id, $temp_content, $temp_title, $temp_syntax, $temp_expire, $temp_username, $temp_password);

    while ($stmt->fetch()) {
        $cleanid = $temp_id;
        $content = $temp_content;
        $title = $temp_title;
        $syntax = $temp_syntax;
        $expire = $temp_expire;
        $username = $temp_username;
        $password = $temp_password;
    }
}

if ($expire < time()) {
    header("location: /?error=The paste has expired or does not exist.");
    exit();
}

if (empty($cleanid)) {
    header("location: /?error=The paste has expired or does not exist.");
    exit();
}

$resrating = $mysqli->query("SELECT SUM(rating) as rating FROM ratings WHERE paste = '{$cleanid}'");
$rating1 = mysqli_fetch_array($resrating);
$rating = $rating1["rating"];

if (empty($rating)) {
    $rating = 0;
}

$md5ip = md5($ip);

$resyourrating = $mysqli->query("SELECT rating FROM ratings WHERE paste = '{$cleanid}' AND ip = '{$md5ip}'");
$yourrating1 = mysqli_fetch_array($resyourrating);
$yourrating = $yourrating1["rating"];

if (empty($yourrating)) {
    $yourrating = 0;
}

$likeimg = "assets/svg/thumbs-up-regular.svg";
$dislikeimg = "assets/svg/thumbs-down-regular.svg";

if ($yourrating == 1) {
    $likeimg = "assets/svg/thumbs-up-solid.svg";
}

if ($yourrating == -1) {
    $dislikeimg = "assets/svg/thumbs-down-solid.svg";
}


$mysqli->query("UPDATE pastes SET views = views + 1, rating = {$rating} WHERE id = \"{$cleanid}\"");

$expstr = "";

if ($expire == 2147483647) {
    $expstr = "never";
} else {
    $expstr = time2str($expire);
}

$usergroup1 = 0;

if (empty($username)) {
    $username = "Anonymous";
} elseif (!empty($username)) {
    $ugres = $mysqli->query("SELECT `usergroup`, `useritem` FROM accounts WHERE username = '{$username}';");
    $ugrow = mysqli_fetch_array($ugres);
    $usergroup = $ugrow["usergroup"];
    $useritemug = $ugrow['useritem'];

    if ($result6 = $mysqli->query("SELECT `id`, `name`,`color1`,`color2`,`useritem` FROM `usergroup` WHERE name='$usergroup'")) {
        while ($row6 = mysqli_fetch_assoc($result6)) {
            $userfromdb = $row6["name"];
            $color1 = $row6["color1"];
            $color2 = $row6["color2"];
            $useritem = $row6['useritem'];
        }
    }
}





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["load_password"])) {
        if ($password == $_POST["load_password"]) {
            $_SESSION["load_password"] = $_POST["load_password"];
        } else {
            header("location: ./paste.php?p={$cleanid}&error=Wrong password.");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo (htmlspecialchars($title)); ?> | Quickpaste.it
    </title>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <link rel="stylesheet" href="codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="codemirror/theme/material-palenight.css">
    <script src="codemirror/lib/codemirror.js"></script>

    <script src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/javascript/javascript.js"></script>
    <script src="codemirror/mode/css/css.js"></script>
    <script src="codemirror/mode/sql/sql.js"></script>
    <script src="codemirror/mode/php/php.js"></script>
    <script src="codemirror/mode/python/python.js"></script>
    <script src="codemirror/mode/shell/shell.js"></script>
    <script src="codemirror/mode/clike/clike.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>

    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

    <?php

    include("includes/customcolor.php");

    ?>

    <script>
        function reqListener() {
            if (this.responseText == "OK") {
                location.reload();
            }
        }


        function onLike(token) {
            const req = new XMLHttpRequest();
            req.addEventListener("load", reqListener);
            req.open("GET", "rate.php?captcha=" + token + "&rating=1&pid=<?php echo $cleanid; ?>");
            req.send();
        }

        function onDislike(token) {
            const req = new XMLHttpRequest();
            req.addEventListener("load", reqListener);
            req.open("GET", "rate.php?captcha=" + token + "&rating=-1&pid=<?php echo $cleanid; ?>");
            req.send();
        }

    </script>


</head>

<body>
    <div class="wrapper">
        <?php
            $accounttext = "Account";
            $accountug = 0;

            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                $accounttext = $_SESSION["username"];
                $ugres = $mysqli->query("SELECT usergroup FROM accounts WHERE username = '{$_SESSION["username"]}';");
                $ugrow = mysqli_fetch_array($ugres);
                $accountug = $ugrow["usergroup"];

            }
        ?>
        <?php
            include 'includes/header.php';
            include("includes/ads.php");
        ?>
        <script>
            /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }
        </script>
        <?php
            //IF IS SET PASSWORD IN SESSION
            if ((isset($_SESSION["load_password"]) && $_SESSION["load_password"] == $password) || $password == "") {
        ?>
            <h2 class="pagetitle">
                <?php echo htmlspecialchars($title); ?>
            </h2>
            <form>
                <div class="form-elements">
                    <h4 class="paste-info">Created By
                        <?php if ($usergroup !== ''): ?>
                            <a href="user.php?username=<?php echo $username; ?>" style="text-decoration: none;">
                            <?php endif ?>
                            <span style="
                            background: #ffffff;background: url('/assets/img/textparticle.gif'), linear-gradient(to right, <?php if ($usergroup === $userfromdb) {
                                echo $color1;
                            } ?> 0%, <?php if ($usergroup === $userfromdb) {
                                  echo $color2;
                              } ?> 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;font: weight 700px; font-size: 20px;
                            <?php ?>
                            ">
                                <?php
                                if ($usergroup === '0') {
                                } else {
                                    echo $usergroup;
                                }

                                ?>

                                <?php echo $username; ?>
                                <?php if ($usergroup === $userfromdb): ?>
                                    <img src="<?php echo $useritem ?>"
                                        style="display:inline-flex !important;align-items:center;width:15px;"></img>
                                <?php endif ?>
                            </span>
                            <?php if ($usergroup !== ''): ?>
                            </a>
                        <?php endif ?>
                    </h4>
                    <h4 class="paste-info">Expires
                        <?php echo $expstr; ?>
                    </h4>
                    <hr>
                    <a href="./raw.php?p=<?php echo $cleanid; ?>&password=<?= $password; ?>" class="util-button" title="Raw"
                        target="_blank">Raw</a>
                    <a href="./raw.php?p=<?php echo $cleanid; ?>&password=<?= $password; ?>&type=download" class="util-button"
                        title="Download" target="_blank" download>Download</a>
                    <div class="ratings">
                        <button class="h-captcha ratebutton" data-sitekey="<?php echo HCAPTCHA_SITEKEY; ?>"
                            data-callback="onLike" class="ratebutton"><img src="<?php echo $likeimg; ?>"></button>
                        <h3 class="currentrating">
                            <?php echo $rating; ?>
                        </h3>
                        <button class="h-captcha ratebutton" data-sitekey="<?php echo HCAPTCHA_SITEKEY; ?>"
                            data-callback="onDislike" class="ratebutton"><img src="<?php echo $dislikeimg; ?>"></button>
                    </div>
                </div>
                <textarea id="editor" name="content"><?php echo (htmlspecialchars($content)); ?></textarea>
            </form>
        <?php
            } else {
                //password form
                echo '
                    <form style="display: inline-flex;flex-direction: column;width: 250px;justify-content: center;align-items: center;" method="post" action="paste.php?p='.$cleanid.'">
                        <p style="color:white; padding: 20px; text-align: center;"> Paste is password protected. </p>
                        <input maxlength="20" name="load_password" type="text" placeholder="Password" class="form-element" style="background-color: var(--background-textarea);font-size: 15.5px;font-family: \'Source Code Pro\', monospace;color: var(--text-color);height: 40px;min-height: 40px;min-width: 200px;padding: 0px 0px 0px 10px;margin: 10px 5px 10px 5px;flex: 1;border-color: transparent;border-radius: 7px;border-width: 2px;border-style: solid;outline: none;display: block;width: 100%;box-sizing: border-box;">
                        <button data-callback="createpost" style="width: 100%;">Paste</button>
                    </form>
                ';
            }
        ?>
    </div>
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
            mode: "text/<?php echo $syntax; ?>",
            theme: 'material-palenight',
            inputStyle: 'textarea',
            readOnly: true,
            lineNumbers: true
        })
    </script>
</body>

</html>
<?php include 'includes/footer.php'; ?>