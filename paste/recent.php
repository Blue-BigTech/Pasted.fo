<head>
     <title>Recent Pastes | Pasted.fo</title>
     <link rel="shortcut icon" href="pn.ico" />
</head>


<?php
// Import config.php
require_once("includes/config.php");
require_once("includes/functions.php");
?>


<div class="wrapper">
            
            <?php
include 'includes/header.php';
include 'includes/ads.php';
?>

<div class="page-header">
    <h2 class="pagetitle">Recent Pastes</h2>
</div>

    <tbody>
        <?php

        if ($res = $mysqli->query("SELECT *,UNIX_TIMESTAMP(create_time) as unix FROM pastes WHERE pinned='1'")) {
            while ($row = mysqli_fetch_array($res)) {
                $username = "Anonymous";
                $usergroup = "";
                if (!empty($row["username"])) {
                    $username = $row["username"];
                    $ugres = $mysqli->query("SELECT usergroup FROM accounts WHERE username = '{$username}';");
                    $ugrow = mysqli_fetch_array($ugres);
                    $usergroup = $ugrow["usergroup"];

                    if ($result6 = $mysqli->query("SELECT `id`, `name`,`color1`,`color2`,`useritem` FROM `usergroup` WHERE name='$usergroup'")) {
                        while ($row6 = mysqli_fetch_assoc($result6)) {
                            $userfromdb =  $row6["name"];
                            $color1 = $row6["color1"];
                            $color2 = $row6["color2"];
                            $useritem = $row6['useritem'];
                        }
                    }   
                }
        ?>

                <tr>
                    <td><a href="/paste.php?p=<?php echo $id; ?>"</td></a>
                    <td class="td-creator">
                        by
                        <?php if ($usergroup !== '') : ?>
                            <a href="user.php?username=<?php echo $username; ?>" style="text-decoration: none;">
                            <?php endif ?>
                            <span style="
                            background: #ffffff;background: url('/assets/img/textparticle.gif'), linear-gradient(to right, <?php if ($usergroup === $userfromdb) {
                                                                                                                                echo $color1;
                                                                                                                            } ?> 0%, <?php if ($usergroup === $userfromdb) {
                                                                                                                                            echo $color2;
                                                                                                                                        } ?> 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;font: weight 700px;
                            <?php ?>
                            ">
                                <?php
                                if ($usergroup === '0') {
                                } else {
                                    echo $usergroup;
                                }

                                ?>

                                <?php echo $username; ?>
                                <?php if($useritem !== "") : ?>
                                <img src="<?php echo $useritem ?>" width="3%"></img>
                                <?php endif ?>
                            </span>
                            <i class="fa fa-thumbtack"></i>
                            <?php if ($usergroup !== '') : ?>
                            </a>
                        <?php endif ?>
                    </td>
                    </td>
                </tr>

        <?php
            }
        }
        ?>

    </tbody>
</table>

<table class="pastelist">
    <tr class="toprow">
        <th>Pastes</th>
        <th>Views</th>
        <th class="td-creator">Creator</th>
        <th class="td-time">Creation Time</th>
    </tr>

    <?php


    if ($res = $mysqli->query("SELECT *,UNIX_TIMESTAMP(create_time) as unix FROM pastes WHERE visibility = 'public' AND expire > " . time() . " ORDER BY create_time DESC LIMIT 40")) {
        while ($row = mysqli_fetch_array($res)) {
            $username = "Anonymous";
            $usergroup = "";
            if (!empty($row["username"])) {
                $username = $row["username"];
                $ugres = $mysqli->query("SELECT `usergroup`, `useritem` FROM accounts WHERE username = '{$username}';");
                $ugrow = mysqli_fetch_array($ugres);
                $usergroup = $ugrow["usergroup"];
                $useritemug = $ugrow['useritem'];

                if ($result6 = $mysqli->query("SELECT `id`, `name`,`color1`,`color2`,`useritem` FROM `usergroup` WHERE name='$usergroup'")) {
                    while ($row6 = mysqli_fetch_assoc($result6)) {
                        $userfromdb =  $row6["name"];
                        $color1 = $row6["color1"];
                        $color2 = $row6["color2"];
                        $useritem = $row6['useritem'];
                    }
                }
            }
    ?>
            <tr>
                <td><a href="/paste.php?p=<?php echo $row["id"]; ?>" style="font-weight:lighter;"><?php echo $row["title"]; ?></a></td>
                <td><?php echo $row["views"]; ?></td>
                <td class="td-creator">
                    by
                    <?php if ($usergroup !== '') : ?>
                        <a href="user.php?username=<?php echo $username; ?>" style="text-decoration: none;">
                        <?php endif ?>
                        <span style="
                            background: #ffffff;background: url('/assets/img/textparticle.gif'), linear-gradient(to right, <?php if ($usergroup === $userfromdb) {
                                                                                            echo $color1;
                                                                                        } ?> 0%, <?php if ($usergroup === $userfromdb) {
                                                                                                        echo $color2;
                                                                                                    } ?> 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;font: weight 700px;
                            <?php ?>
                            ">
                            <?php
                            if ($usergroup === '0') {
                            } else {
                                echo $usergroup;
                            }

                            ?>

                            <?php echo $username; ?>
                            <?php if($usergroup === $userfromdb) : ?>
                                <img src="<?php echo $useritem ?>" style="display:inline-flex !important;align-items:center;width:15px;"></img>
                                <?php endif ?>
                        </span>
                        <?php if ($usergroup !== '') : ?>
                        </a>
                    <?php endif ?>
                </td>
                <td class="td-time"><?php echo time2str($row["unix"]); ?></td>
            </tr>
    <?php
        }
    }
    ?>
</table>

</div>

<?php include 'includes/footer.php'; ?>