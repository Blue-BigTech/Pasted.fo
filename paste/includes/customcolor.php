<?php

require_once("includes/functions.php");

?>

<style>
:root {

<?php
if(isset($_COOKIE["color"])){
    $primarycolor = $_COOKIE["color"];
    $primaryhover = adjustBrightness($primarycolor, 100);
?>
    --primary: <?php echo $primarycolor; ?>;
    --primary-hover: <?php echo $primaryhover; ?>;
<?php
}
?>

<?php
if(isset($_COOKIE["glow"])){
    $glow = $_COOKIE["glow"];
?>
    --glow: <?php echo $glow; ?>px;
<?php
}
?>


}
</style>
