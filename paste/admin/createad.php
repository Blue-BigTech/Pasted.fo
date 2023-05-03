<?php
// Include config file
require_once "config.php";
define('Include', TRUE);

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["Aloggedin"]) || $_SESSION["Aloggedin"] !== true){
    header("location: login.php");
    exit;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Prepare an insert statement
    $sql = "INSERT INTO `ads`(`url`, `img`, `info`, `expire`) VALUES (?,?,?,FROM_UNIXTIME(?))";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "sssi", $param_url, $param_img, $param_info, $param_expire);
        // Set parameters
        $param_url = $_POST["url"];
        $param_img = $_POST["img"];
        $param_info = $_POST["info"];
        $t_expire = time() + ($_POST["expire"] * 86400);
        $param_expire = $t_expire;
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: ads.php");
        } else{
            echo "Oops! Something went wrong. Please try again later." . $stmt->error;
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $admintitle; ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
            <?php
                include("parts/sidebar.php");
            ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
                <?php
                    include("parts/navbar.php");
                ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Create new Ad Spot </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Create new Ad Spot</h4>
                            <p class="card-description">Please fill out this form to create a new ad spot.</p>
                            <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="forms-sample">
                                <div class="form-group">
                                <label for="InputTitle">URL</label>
                                <input style="color: #fff;" type="text" name="url" class="form-control" id="InputTitle" placeholder="Example: https://example.com/">
                                </div>
                                <div class="form-group">
                                <label for="InputTitle">Image URL</label>
                                <input style="color: #fff;" type="text" name="img" class="form-control" id="InputTitle" placeholder="Example: /assets/img/testad.png">
                                </div>
                                <div class="form-group">
                                <label for="InputTitle">Information</label>
                                <input style="color: #fff;" type="text" name="info" class="form-control" id="InputTitle" placeholder="Example: Name of Customer">
                                </div>
                                <div class="form-group">
                                <label for="InputURL">Expiring in (in days)</label>
                                <input style="color: #fff;" type="text" name="expire" class="form-control" id="InputURL" placeholder="Example: 7">
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                <button class="btn btn-dark">Cancel</button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>

</html>