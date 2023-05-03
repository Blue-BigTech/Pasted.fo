<?php
// Import config.php
require_once("includes/config.php");

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard");
    exit;
}
error_reporting(E_ALL);

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!isset($_SESSION["captcha"])){
        $data = array(
            'secret' => HCAPTCHA_SECRET,
            'response' => $_POST['h-captcha-response']
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
            
        } 
        else {
            header("location: register?error=captcha is incorrect.");
            exit();
        }
    }



    $link = $mysqli;

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM accounts WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                header("location: register?error=databaseerrror");
                exit();
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if($username_err == null && $password_err == null && $confirm_password_err == null){
        
        // Prepare an insert statement
        $sql = "INSERT INTO accounts (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{            
                header("location: register?error=registration error");
                exit();
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }else{
        header("location: register?error=input error");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quickpaste.it</title>
        <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

        <script>
            function register(token){
                document.getElementById("hcpr").value = token;
                document.getElementById("regform").submit();
            }
        </script>
<?php

include("includes/customcolor.php");

?>
    </head>
    <body>

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



        <div class="wrapper">

            
            <?php
                include("includes/header.php");
                include("includes/ads.php");

            ?>

            <h2 class="pagetitle">Register</h2>

            <form id="regform" class="settingsform" method="POST" action="/register.php">
                <div class="form-elements" style="margin: 0; flex-direction: column;">

                    <input maxlength="50" name="username" type="text" placeholder="Username" class="form-element">
                    <input maxlength="50" name="password" type="password" placeholder="Password" class="form-element">
                    <input maxlength="50" name="confirm_password" type="password" placeholder="Confirm Password" class="form-element">
                    <div class="h-captcha" data-sitekey="<?php echo HCAPTCHA_SITEKEY; ?>"></div>

                    <button data-callback="register">Register</button>
                    <h4 class="pagetitle"><a href="login" style="font-size:20px!important;">If you have a account, Login now.</a></h4>
                </div>
            </form>
        </div>
        <div class="footer">
            <h3>&copy; <?php echo(date("Y")); ?> Quickpaste.it</h3>
        </div>
    </body>
</html>