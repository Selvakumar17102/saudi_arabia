<?php
ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");
date_default_timezone_set("Asia/Qatar");

$message = "";

$id = $_REQUEST['id'];

$sql1 = "SELECT * FROM login WHERE id='$id'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

if (isset($_POST['save_select'])) {

    $name           = $_POST['name'];
    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $designation    = $_POST['designation'];
    $email          = $_POST['email'];
    $responsibility = $_POST['responsibility'];

    $sql = "UPDATE login SET name='$name',username='$username',password='$password',designation='$designation',email='$email', responsibility = '$responsibility' WHERE id='$id'";
    if ($conn->query($sql) == TRUE) {
        header("location: newemployees.php?msg=Updated!");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- META ============================================= -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />

    <!-- DESCRIPTION -->
    <meta name="description" content="Edit New Employee | Project Management System" />

    <!-- OG -->
    <meta property="og:title" content="Edit New Employee | Project Management System" />
    <meta property="og:description" content="Edit New Employee | Project Management System" />
    <meta property="og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>Edit New Employee | Project Management System</title>

    <!-- MOBILE SPECIFIC ============================================= -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->

    <!-- All PLUGINS CSS ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/assets.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/calendar/fullcalendar.css">

    <!-- TYPOGRAPHY ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/typography.css">

    <!-- SHORTCODES ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">

    <!-- STYLESHEETS ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">


    <link rel="stylesheet" type="text/css" href="../assets/css/assets.css">
    <link rel="stylesheet" type="text/css" href="../assets/vendors/calendar/fullcalendar.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/typography.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/shortcodes/shortcodes.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="../assets/css/color/color-1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <style>
        .drop{
            height:none;
        }
    </style>
</head>

<body class="ttr-pinned-sidebar">

    <!-- header start -->
    <?php include_once("inc/header.php"); ?>
    <!-- header end -->
    <!-- Left sidebar menu start -->
    <?php include_once("inc/sidebar.php"); ?>
    <!-- Left sidebar menu end -->

    <!--Main container start -->
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <div class="row r-p100">
                    <div class="col-sm-11">
                        <h4 class="breadcrumb-title">Edit New Employee</h4>
                    </div>
                    <div class="col-sm-1">
                        <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
                    </div>
                </div>
            </div>
            <!-- Your Profile Views Chart -->
            <div class="widget-inner">
                <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                <form class="edit-profile m-b30" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Name</label>
                            <input type="name" placeholder="Enter Name" class="form-control" name="name" id="name" value="<?php echo $row1['name']; ?>"><br><br>
                        </div>
                        <div class="col-sm-6 ">
                            <label class="col-form-label">Designation</label>
                            <select class="form-control drop" name="designation" required>
                                <?php
                                $Directors_Leader_Team = $Domain_Lead = $Admin_and_accounts = $Finance = $Business_Development = "";
                                switch ($row1['designation']) {
                                    case '1':
                                        $Directors_Leader_Team = 'selected';
                                        break;
                                    case '2':
                                        $Domain_Lead = 'selected';
                                        break;
                                    case '3':
                                        $Admin_and_accounts = 'selected';
                                        break;
                                    case '4':
                                        $Finance = 'selected';
                                        break;
                                    case '5':
                                        $Business_Development = 'selected';
                                        break;
                                }
                                ?>
                                <option selected value disabled>Select Designation</option>
                                <option value="1" <?php echo $Directors_Leader_Team; ?>>Directors/ Leader Team</option>
                                <option value="2" <?php echo $Domain_Leads; ?>>Domain Leads</option>
                                <option value="3" <?php echo $Admin_and_accounts; ?>>Admin and accounts</option>
                                <option value="4" <?php echo $Finance; ?>>Finance</option>
                                <option value="5" <?php echo $Business_Development; ?>>Business Development</option>
                            </select><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Username</label>
                            <input type="username" placeholder="Enter username" class="form-control" name="username" id="username" value="<?php echo $row1['username']; ?>"><br><br>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Password</label>
                            <input type="password" placeholder="Enter password" class="form-control" name="password" id="password" value="<?php echo $row1['password']; ?>"><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Email</label>
                            <input type="email" placeholder="Enter email" class="form-control" name="email" id="email" value="<?php echo $row1['email']; ?>"><br><br>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Responsibility</label>
                                <select name="responsibility" id="responsibility" required class="form-control drop">
                                    <option value readonly>-- Select Responsibility --</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2">
                            <br><button style="width: 100%;" type="submit" name="save_select" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>


    <!-- External JavaScripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="assets/vendors/bootstrap/js/popper.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
    <script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
    <script src="assets/vendors/counter/waypoints-min.js"></script>
    <script src="assets/vendors/counter/counterup.min.js"></script>
    <script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
    <script src="assets/vendors/masonry/masonry.js"></script>
    <script src="assets/vendors/masonry/filter.js"></script>
    <script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
    <script src='assets/vendors/scroll/scrollbar.min.js'></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/vendors/chart/chart.min.js"></script>
    <script src="assets/js/admin.js"></script>

    <script>
        $(function() {
            setTimeout(function() {
                $("#hideDiv").fadeOut(1500);
            }, 5000)
        })
    </script>
    <script>
        // Start of jquery datatable
        $('#dataTableExample1').DataTable({
            "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "lengthMenu": [
                [6, 25, 50, -1],
                [6, 25, 50, "All"]
            ],
            "iDisplayLength": 50
        });
    </script>
</body>

</html>