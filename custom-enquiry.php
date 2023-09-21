<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

    $start_date = $_REQUEST['sdate'];
    $end_date = $_REQUEST['ldate'];

    if($start_date == "")
    {
        $start_date = date("Y-m-d", strtotime("-1 day"));
        $end_date = date("Y-m-d");
    }
    $division = array('ENGINEERING','SIMULATION & ANALYSIS','SUSTAINABILITY','ENVIRONMENTAL','ACOUSTICS','LASER SCANNING');

    if(isset($_POST['search']))
    {
        $fd = $_POST['fd'];
        $td = $_POST['td'];

        header("Location: custom-enquiry.php?sdate=$fd&ldate=$td");
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
	<meta name="description" content="Enquiry Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Enquiry Reports | Project Management System" />
	<meta property="og:description" content="Enquiry Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Enquiry Reports | Project Management System</title>
	
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
	<style>
	.table-striped tr td {text-align: center;}
	.table-striped tr td a{padding: 10px;}
    .edit-profile .col-form-label{
        color: black;
    }
    table tr{
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
        color: black;
    }
    table td {
    padding: 5px;
    }
    b{
        font-weight: 900;
    }
	</style>
</head>
<body class="ttr-pinned-sidebar">
	
	<!-- header start -->
	<?php include_once("inc/header.php");?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
                <div class="row r-p100">
                    <div class="col-sm-11">
                        <h4 class="breadcrumb-title">Custom Enquiry Reports</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">

                    <div class="widget-box card">

                        <div class="card-header">
                            <h4>Custom Search</h4>
                        </div>
                        <div class="widget-inner">
                            <form method="post" class="edit-profile">

                                <div class="form-group row">
									
                                    <label class="col-sm-2 col-form-label">From Date</label>
                                    <div class="col-sm-3 course">
                                        <input class="form-control" type="date" name="fd" value="<?php echo $start_date ?>" required>
                                    </div>

                                    <label class="col-sm-2 col-form-label">To Date</label>
                                    <div class="col-sm-3 course">
                                        <input class="form-control" type="date" name="td" value="<?php echo $end_date ?>" required>
                                    </div>

                                    <div class="col-sm-2">
										<input type="submit" name="search" class="btn" value="Search">
									</div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
					    <div class="card-header">
							<h4 style="text-align: center;">Enquiry Report's</h4>
						</div>
                	    <div class="row" style="margin-bottom:30px;margin-left: 25px;margin-right: 25px;">
                            <div class="col-sm-12">
                            <div class="row" style="margin-bottom:30px;margin-left: 25px;margin-right: 25px;">
                                <div class="col-sm-12">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td colspan="6"><center><b>RFQ</center></b></td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2"><center><b>Division</center></b></td>
                                                <td colspan="2"><center><b>Total</b></center></td>
                                                <td colspan="2"><center><b>Not Submitted</b></center></td>
                                            </tr>
                                            <tr>
                                                <td><center><b>Tender</b></center></td>
                                                <td><center><b>Job In Hand</b></center></td>
                                                <td><center><b>Tender</b></center></td>
                                                <td><center><b>Job In Hand</b></center></td>
                                            </tr>
                                            <?php
                                                for($i=0;$i < count($division);$i++)
                                                {
                                                    $my_division = $division[$i];

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Tender' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_tenders = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_Job_In_Hand = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Tender' AND qstatus='NOT SUBMITTED' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Not_Total_tenders = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND qstatus='NOT SUBMITTED' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Not_Total_Job_In_Hand = $result1->num_rows;
                                                    ?>
                                                        <tr>
                                                            <td><center><?php echo $my_division;?></center></td>
                                                            <td><center><a href="custom-enquiry-details.php?type=1&division=<?php echo rawurlencode(urldecode($my_division));?>&sdate=<?php echo $start_date;?>&edate=<?php echo $end_date;?>"><?php echo $Total_tenders;?></a></center></td>
                                                            <td><center><a href="custom-enquiry-details.php?type=2&division=<?php echo rawurlencode(urldecode($my_division));?>&sdate=<?php echo $start_date;?>&edate=<?php echo $end_date;?>"><?php echo $Total_Job_In_Hand;?></a></center></td>
                                                            <td><center><a href="custom-enquiry-details.php?type=5&division=<?php echo rawurlencode(urldecode($my_division));?>&sdate=<?php echo $start_date;?>&edate=<?php echo $end_date;?>"><?php echo $Not_Total_tenders;?></a></center></td>
                                                            <td><center><a href="custom-enquiry-details.php?type=6&division=<?php echo rawurlencode(urldecode($my_division));?>&sdate=<?php echo $start_date;?>&edate=<?php echo $end_date;?>"><?php echo $Not_Total_Job_In_Hand;?></a></center></td>
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
            </div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

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
            [ 15, 50, 100, -1 ],
            [ '15 rows', '50 rows', '100 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','excel','print'
        ]
    });
</script>
</body>
</html>