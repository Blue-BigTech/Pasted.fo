<?php
error_reporting(0);

define('DB_USERNAME','root');
define('DB_PASSWORD','bluesky0812');
define('DB_SERVER','localhost');
define('DB_NAME','pastedfo_main');

define('HCAPTCHA_SECRET', '0x60D2185638853fa163DFee81b6E4c0096F475fFa');
define('HCAPTCHA_SITEKEY', '6815302e-d52d-4814-8a85-b928af1bc489');


//define('HCAPTCHA_SECRET', '0xc1692fbBF5A56c99A9857a313F7a46838E6c94dC');
//define('HCAPTCHA_SITEKEY', '10ad4f4d-07a7-4e60-b0cf-d903c6b3f539');

session_start();

//true = captcha, false = no captcha
define('CAPTCHA', true);


// paste.php
define('PASTE_P_NOT_DEFINED',"Error p not defined.");

// create.php
define('CREATE_CONTENT_NOT_DEFINED',"Error content not defined.");
define('CREATE_INSERT_FAILED',"Oops! Something went wrong. Please try again later.");

// Attempt to connect to MySQL database
$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($result = $mysqli -> query("SELECT `id`,`ip_address` FROM `banned_ips`")) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ip_add_client = $_SERVER['REMOTE_ADDR'];
        $ip_add_server = $row['ip_address'];

        if($ip_add_client === $ip_add_server) {
            header("Location: /banned.php");
        }
    }
}

?>