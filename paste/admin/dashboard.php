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

if($stmt = mysqli_prepare($link, "SELECT id, username, password FROM users WHERE username = ?")){
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $_SESSION["Ausername"];

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

    while( $stmt->fetch() ) {
        //echo $id;
    }
}

$res1 = $link -> query("SELECT count(id) as count FROM `pastes`");
$row1 = mysqli_fetch_array($res1);

$pastecount = $row1["count"];

$res2 = $link -> query("SELECT sum(views) as views FROM `pastes`");
$row2 = mysqli_fetch_array($res2);

$totalviews = $row2["views"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <script src="assets/vendors/chart.js/Chart.min.js"></script>
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
                        <h3 class="page-title"> Dashboard </h3>
                    </div>

                <div class="row">
                        <div class="col-sm-6 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Total Pastes</h5>
                                    <div class="row">
                                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                                <h2 id="pastes-text" class="mb-0"><?php echo $pastecount; ?></h2>
                                            </div>
                                        </div>
                                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                            <i class="icon-lg mdi mdi-content-paste text-success ms-auto"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Total Views</h5>
                                    <div class="row">
                                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                                <h2 id="views-text" class="mb-0"><?php echo $totalviews; ?></h2>
                                            </div>
                                        </div>
                                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                            <i class="icon-lg mdi mdi-eye text-primary ms-auto"></i>
                                        </div>
                                    </div>
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
    <script src="https://pastehub.net/assets/map.php"></script>
</body>

</html>