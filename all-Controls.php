<?php
ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");
$user = $_SESSION["user"];
$qst = "SUBMITTED";
$pst = "FOLLOW UP";

$s1 = $_REQUEST["s1"];
$s2 = $_REQUEST["s2"];

$status = $stage = "";
$s11 = $s12 = $s13 = $s21 = $s22 = $s23 = "";

if ($s1 == 1) {
    $status = "Accounts";
    $s11 = "selected";
} else {
    if ($s1 == 2) {
        $status = "Balamurugan";
        $s12 = "selected";
    }
    if ($s1 == 3) {
        $status = "Kavya";
        $s13 = "selected";
    }
}
if ($s2 == 1) {
    $stage = "";
    $s21 = "selected";
} else {
    if ($s2 == 2) {
        $stage = "";
        $s22 = "selected";
    }
    if ($s2 == 3) {
        $stage = "";
        $s23 = "selected";
    }
    if (isset($_POST['save_select'])) {

        $designation = $_POST['designation'];
        $employee_id = $_POST['employee_id'];

         $sql = "UPDATE login SET designation='$designation' WHERE id='$employee_id'";
        $result = mysqli_query($conn, $sql);
        if ($result == true) {
            echo "successfully";
        } else {
            echo "not successful";
        }    
    }

$select.='</select>';
echo $select;
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
    <meta name="description" content="Proposal Followup | Project Management System" />

    <!-- OG -->
    <meta property="og:title" content="Proposal Followup | Project Management System" />
    <meta property="og:description" content="Proposal Followup | Project Management System" />
    <meta property=" og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>Controls Followup | Project Management System</title>

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

    <!-- DataTable ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">

    <!-- STYLESHEETS ============================================= -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

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
                <div class="row" style="width: 100%">
                    <div class="col-sm-11">
                        <h4 class="breadcrumb-title">Controls Followup</h4>
                    </div>
                    <?php
                    if ($s1 != "" || $s2 != "") {
                    ?>
                        <div class="col-sm-1">
                            <a href="entire-enquiry.php" style="color: #fff" class="bg-primary btn">Back</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="row m-t10">

                <div class="col-sm-12">

                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-5">
                                <form action="" method="post" role="form">

                                    <label class="col-form-label">Name</label>
                                    <select name="employee_id" class="form-control">
                                        <option value selected disabled>Select Status</option>
                                        <?php
                                        $sql1 = "SELECT * FROM login";
                                        $result1 = $conn->query($sql1);
                                        while ($row1 = $result1->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <label class="col-form-label">Designation</label>
                                    <select name="designation" class="form-control">
                                        <option selected value disabled>Select Designation</option>}
                                        <option value="1">Directors/ Leader Team</option>
                                        <option value="2">Domain Leads</option>
                                        <option value="3">Admin and accounts</option>
                                        <option value="4">Finance</option>
                                        <option value="5">Business Development</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                <br><button type="submit" name="save_select" class="btn btn-primary">Save</button>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                                <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        $sql1 = "SELECT * FROM login";
                                        $result1 = $conn->query($sql1);
                                        while ($row1 = $result1->fetch_assoc()) {
                                        	$value = $row1['designation'];
										?>
                                            <tr>
                                                <td>
                                                    <center><?php echo $count++ ?></center>
                                                </td>
                                                <td>
                                                    <center>
                                                       <?php echo $row1["name"] ?>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                    <?php
														switch ($value) {
															case "1":
																$my_design = "Directors/ Leader Team";
																break;
															case "2":
																$my_design = "Domain Leads";
																break;
															case "3":
																$my_design = "Admin and accounts";
																break;
															case "4":
																$my_design = "Finance";
																break;
															case "5":
																$my_design = "Business Development";
																break;
															default:
																$my_design = "N/A";
														}
														?>
														<?php echo $my_design; ?>                                                    </center>
                                                </td>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="ttr-overlay"></div>
    <script>
        function direct(val) {
            if (val == 1) {
                location.replace("job-in-hand.php");
            } else {
                location.replace("job-in-hand.php?ch=1");
            }
        }

        function divi(val) {
            if (val == "SIMULATION & ANALYSIS") {
                val = "SIMULATION+%26+ANALYSIS";
            }
            location.replace("client.php?div=" + val);
        }
    </script>
    <!-- External JavaScripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/vendors/bootstrap/js/popper.min.js"></script>
    <script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
    <script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
    <script src="assets/vendors/counter/waypoints-min.js"></script>
    <script src="assets/vendors/counter/counterup.min.js"></script>
    <script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
    <script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/vendors/datatables/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="assets/vendors/masonry/masonry.js"></script>
    <script src="assets/vendors/masonry/filter.js"></script>
    <script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
    <script src='assets/vendors/scroll/scrollbar.min.js'></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/vendors/chart/chart.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script src='assets/vendors/calendar/moment.min.js'></script>
    <script src='assets/vendors/calendar/fullcalendar.js'></script>
    <script>
        // Start of jquery datatable
        $('#dataTableExample1').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [15, 50, 100, -1],
                ['15 rows', '50 rows', '100 rows', 'Show all']
            ],
            buttons: [
                'pageLength', 'excel', 'print'
            ]
        });
    </script>
</body>

</html>