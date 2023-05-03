<?php
// Import config.php
require_once("includes/config.php");

// Initialize the session


// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $logizn_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (!isset($_SESSION["captcha"])) {
        $data = array(
            'secret' => HCAPTCHA_SECRET,
            'response' => $_POST['h-captcha-response'],
            'lang' => 'en'
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        //var_dump($response);
        $responseData = json_decode($response);
        if ($responseData->success) {
    

    $link = $mysqli;

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM accounts WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: dashboard");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                            header('Location: login?error='.$login_err);
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                    header('Location: login?error='.$login_err);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
        } else {
            header("location: login?error=Invalid Captcha.");
            exit();
        }
    }
    
    
}

?>
 
 <div class="wrapper">
<?php
include 'includes/header.php';
include("includes/ads.php");
?>


    <div class="page-header">
    <h2 class="pagetitle">Login</h2>
</div>

    <form id="logform" class="settingsform" method="POST" action="login.php">
        <div class="form-elements" style="margin: 0; flex-direction: column;">
<?php 
                $login_err = $_GET['error'];
                if(isset($login_err)) {
                    echo '
                    <div class="pagetitle" style="color:red !important;font-size:20px !important;">'.$login_err.'</div>
                    ';
                }
                ?>
            <input maxlength="50" name="username" type="text" placeholder="Username" class="form-element">
            <input maxlength="50" name="password" type="password" placeholder="Password" class="form-element">
          
         
            <div class="h-captcha" data-sitekey="<?php echo HCAPTCHA_SITEKEY; ?>"></div>
			<button data-callback="login">Login</button>
            <h4 class="pagetitle"><a href="register" style="font-size:20px!important;">If you don't have an account yet, register now.</a></h4>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>