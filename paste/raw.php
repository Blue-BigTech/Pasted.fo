<?php
// Import config.php
require_once("includes/config.php");

if(!isset($_GET["p"])){
    exit("Incorrect parameters.");
}

header("content-type: text/plain");

$content = "";
$title = "";
$syntax = "";
$cleanid = "";
$expire = 0;
$password = "";



if($stmt = mysqli_prepare($mysqli, "SELECT id, content, title, syntax, expire, password FROM pastes WHERE id = ?")){
    mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $_GET["p"];

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $temp_id, $temp_content, $temp_title, $temp_syntax, $temp_expire, $temp_password);
    
    while( $stmt->fetch() ) {
        $cleanid = $temp_id;
        $content = $temp_content;
        $title = $temp_title;
        $syntax = $temp_syntax;
        $expire = $temp_expire;
        $password = $temp_password;
        if(!empty($password)){
            if(!$_GET['password'] || $_GET['password'] == null){
                exit("Incorrect parameters.");
            }
            if($password != $_GET['password']){
                    header("location: /?error=Password for RAW view is incorrect.");
                exit();
            }
        }
    }
}

if($expire < time()){ 
    header("location: /?error=The paste has expired or does not exist.");
    exit();
}

if(empty($cleanid)){
    header("location: /?error=The paste has expired or does not exist.");
    exit();
}

if(isset($_GET['type']) == "download"){
    $file = "$title.txt";
    $txt = fopen($file, "w") or die("Unable to open file!");
    fwrite($txt, "$content");
    fclose($txt);
    
    header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/plain");
readfile($file);
}else{
echo($content); 
}

?>