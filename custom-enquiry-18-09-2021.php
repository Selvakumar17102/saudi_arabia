<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');

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
                                        <input class="form-control" type="date" name="fd" value="<?php echo date("Y-m-d", strtotime("-1 day")) ?>" required>
                                    </div>

                                    <label class="col-sm-2 col-form-label">To Date</label>
                                    <div class="col-sm-3 course">
                                        <input class="form-control" type="date" name="td" value="<?php echo date("Y-m-d") ?>" required>
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

            <?php

                if(isset($_POST["search"]))
                {
                    $fd = $_POST["fd"];
                    $td = $_POST["td"];

                    $sustot = $estot = $simtot = $lsstot = 0;
                    $suste = $este = $simte = $lsste = 0;
                    $susjih = $esjih = $simjih = $lssjih = 0;

                    $pstatus = "FOLLOW UP";

                    $sql = "SELECT * FROM enquiry WHERE pstatus='$pstatus' AND qdate BETWEEN '$fd' AND '$td'";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc())
                    {

                        $divi = $row["division"];
                        $stage = $row["stage"];

                        if($divi == "SUSTAINABILITY")
                        {
                            $sustot++;
                            if($stage == "Tender")
                            {
                                $suste++;
                            }
                            if($stage == "Job In Hand")
                            {
                                $susjih++;
                            }
                        }
                        if($divi == "ENGINEERING SERVICES")
                        {
                            $estot++;
                            if($stage == "Tender")
                            {
                                $este++;
                            }
                            if($stage == "Job In Hand")
                            {
                                $esjih++;
                            }
                        }
                        if($divi == "SIMULATION & ANALYSIS SERVICES")
                        {
                            $simtot++;
                            if($stage == "Tender")
                            {
                                $simte++;
                            }
                            if($stage == "Job In Hand")
                            {
                                $simjih++;
                            }
                        }
                        if($divi == "DEPUTATION")
                        {
                            $lsstot++;
                            if($stage == "Tender")
                            {
                                $lsste++;
                            }
                            if($stage == "Job In Hand")
                            {
                                $lssjih++;
                            }
                        }

                    }


                    $sus1 = $es1 = $sim1 = $lss1 = 0;

                    $qstatus = "NOT SUBMITTED";

                    $sql1 = "SELECT * FROM enquiry WHERE qstatus='$qstatus'";
                    $result1 = $conn->query($sql1);
                    while($row1 = $result1->fetch_assoc())
                    {
                        $divi1 = $row1["division"];

                        if($divi1 == "SUSTAINABILITY")
                        {
                            $sus1++;
                        }
                        if($divi1 == "ENGINEERING SERVICES")
                        {
                            $es1++;
                        }
                        if($divi1 == "SIMULATION & ANALYSIS SERVICES")
                        {
                            $sim1++;
                        }
                        if($divi1 == "DEPUTATION")
                        {
                            $lss1++;
                        }
                    }
            ?>

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="text-align: center;">Enquiry Report's</h4>
                        </div>
                        <div class="table-responsive">
                    	    <table class="table table-striped" style="margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th>DIVISION</th>
										<th>RFQ ID</th>
										<th>Tender Projects</th>
										<th>Job In Hand</th>
										<th>Not Submitted</th>
                                    </tr>
                                </thead>
								<tbody>
									<tr>
										<th>Sustainability</th>
										<td><?php echo $sustot ?></td>
										<td><?php echo $suste ?></td>
										<td><?php echo $susjih ?></td>
										<td><?php echo $sus1 ?></td>
											
									</tr>
									<tr>
										<th>Engineering Services</th>
                                        <td><?php echo $estot ?></td>
                                        <td><?php echo $este ?></td>
										<td><?php echo $esjih ?></td>
										<td><?php echo $es1 ?></td>
											
									</tr>
									<tr>
										<th>Simulation & Analysis Services</th>
                                        <td><?php echo $simtot ?></td>
										<td><?php echo $simte ?></td>
										<td><?php echo $simjih ?></td>
										<td><?php echo $sim1 ?></td>

									</tr>
									<tr>
										<th>Deputation</th>
                                        <td><?php echo $lsstot ?></td>
                                        <td><?php echo $lsste ?></td>
										<td><?php echo $lssjih ?></td>
										<td><?php echo $lss1 ?></td>

									</tr>
									   
										
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
			</div>

            <?php
                }
            ?>
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