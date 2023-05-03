<?php

setcookie("color", $_POST["color"], time()+86400);

setcookie("visibility", $_POST["visibility"], time()+86400);

setcookie("glow", $_POST["glow"], time()+86400);

header("location: /settings.php");

?>