<head>
     <link rel="shortcut icon" href="pn.ico" />
</head>

<?php

require_once("includes/config.php");

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$hcaptcha = $_GET["captcha"];
$pasteid = htmlspecialchars($_GET["pid"]);
$rating = $_GET["rating"];

$data = array(
    'secret' => HCAPTCHA_SECRET,
    'response' => $hcaptcha
);

$verify = curl_init();
curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
curl_setopt($verify, CURLOPT_POST, true);
curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($verify);
// var_dump($response);
$responseData = json_decode($response);
if($responseData->success) {


    if($stmt = mysqli_prepare($mysqli, "SELECT count(ip) FROM ratings WHERE ip = ? AND paste = ?")){
        mysqli_stmt_bind_param($stmt, "ss", $param_ip, $param_paste);
        $param_ip = md5($ip);
        $param_paste = $pasteid;
    
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $temp_count);
    
        while( $stmt->fetch() ) {
            if($temp_count > 0){
                if($stmt = mysqli_prepare($mysqli, "DELETE FROM ratings WHERE ip = ? AND paste = ?")){
                    mysqli_stmt_bind_param($stmt, "ss", $param_ip, $param_paste);
                    $param_ip = md5($ip);
                    $param_paste = $pasteid;
                
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }

    if($rating != -1 && $rating != 1){
        exit();
    }
            
    if($stmt = mysqli_prepare($mysqli, "INSERT INTO `ratings`(`paste`, `ip`, `rating`) VALUES (?,?,?)")){
        mysqli_stmt_bind_param($stmt, "ssi", $param_paste, $param_ip, $param_rating);
        
        $param_paste = $pasteid;
        $param_rating = $rating;
        $param_ip = md5($ip);
        
        
        if(mysqli_stmt_execute($stmt)){
            exit("OK");
        }

        mysqli_stmt_close($stmt);
    }
} 
else {
    exit();
}

?>