<?php
// Import config.php
require_once("includes/config.php");

session_start();

//Check if Paste is empty.
if (empty(htmlspecialchars(str_replace(" ", "", $_POST['content'])))) {
    header("Location: /?error=Your Paste can't be empty!");
    exit;
}

//Clear Syntax
$syntaxraw = htmlspecialchars($_POST['syntax']);
$syntaxarray = [
    "plain",
    "html",
    "javascript",
    "css",
    "xml",
    "x-sql",
    "x-php",
    "x-java",
    "x-csharp",
    "x-sh",
    "x-python",
    "x-c++src"
];

$syntax = $syntaxraw;
if (!in_array($syntaxraw, $syntaxarray)) {
    $syntax = "plain";
}

//CHECK IF VISIBILITY IS VALID AND IF NOT SET TO PUBLIC
$visibility = "";
$visibilityori = htmlspecialchars($_POST['visibility']);
if ($visibilityori != "public" && $visibilityori != "private") {
    $visibility = "public";
} else {
    $visibility = $visibilityori;
}

//Set Title
$title = substr($_POST["title"], 0, 50);
if (empty(str_replace(" ", "", $_POST['title']))) {
    $title = "Untitled Paste";
}

//Set Expire
$expire = 0;
if ($_POST["expire"] == 0) {
    $expire = 2147483647;
} else {
    $expire = time() + $_POST["expire"];
}

if (isset($_POST["content"])) {

    // $data = array(
    //     'secret' => HCAPTCHA_SECRET,
    //     'response' => $_POST['h-captcha-response']
    // );
    // $verify = curl_init();
    // curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    // curl_setopt($verify, CURLOPT_POST, true);
    // curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    // curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    // $response = curl_exec($verify);
    // // var_dump($response);
    // $responseData = json_decode($response);
    // if (!$responseData->success) {
    //     header("location: /?error=Invalid Captcha.");
    //     exit();
    // }

    // Get ID for paste
    $id = substr(md5(uniqid()), 0, 12);

    $password = substr($_POST["password"], 0, 20);

    $sql = "INSERT INTO `pastes` (`id`, `content`, `title`, `syntax`,`visibility`, `expire`,`username`,`password`) VALUES (?,?,?,?,?,?,?,?)";

    if ($stmt = mysqli_prepare($mysqli, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssiss", $param_id, $param_content, $param_title, $param_syntax, $param_visibility, $param_expire, $param_username, $param_password);

        $param_id = $id;
        $param_content = $_POST["content"];
        $param_title = $title;
        $param_syntax = $syntax;
        $param_visibility = $visibility;
        $param_expire = $expire;
        $param_password = $password;

        echo $sql;
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
            $param_username = $_SESSION["username"];
        } else {
            $param_username = "";
        }


        if (mysqli_stmt_execute($stmt)) {
            header("Location: ./paste.php?p={$id}");
        } else {
            echo (CREATE_INSERT_FAILED);
        }

        mysqli_stmt_close($stmt);
    }
} else {
    exit(CREATE_CONTENT_NOT_DEFINED);
}

?>