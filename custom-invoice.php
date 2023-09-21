<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');

	$dates = "0000-00-00";
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
	<meta name="description" content="Invoice Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Invoice Reports | Project Management System" />
	<meta property="og:description" content="Invoice Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice Reports | Project Management System</title>
	
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
	.table-hover tr td {text-align: center;}
	.table-hover tr td a{padding: 10px;}
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
						<h4 class="breadcrumb-title">Custom Invoice Reports</h4>
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

            ?>

			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30 m-t30">
                    <div class="card">
					<div class="card-header">
							<h4>Division Wise Invoice Report</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table id="dataTableExample3" class="table table-striped">
                                    <thead>
                                        <tr>
                                           	<th>S.NO</th>
											<th>Division Name</th>
											<th>Total Amount</th>
											<th>Payment</th>
                                        </tr>
                                    </thead>
									<tbody>

                                    <?php

                                        $pstatus = "AWARDED";

                                        $sustot = $estot = $simtot = $lsstot = 0;
                                        $suspay = $espay = $simpay = $lsspay = 0;

                                        $sql = "SELECT * FROM enquiry WHERE pstatus='$pstatus'";
                                        $result = $conn->query($sql);
                                        while($row = $result->fetch_assoc())
                                        {
                                            $rfqid = $row["rfqid"];
                                            $divi = $row["division"];

                                            $sql1 = "SELECT total,sum(current) as current FROM invoice WHERE rfqid='$rfqid' AND recdate BETWEEN '$fd' AND '$td'";
                                            $result1 = $conn->query($sql1);
                                            $row1 = $result1->fetch_assoc();

                                            if($divi == "SUSTAINABILITY")
                                            {
                                                $sustot = $sustot + $row1["total"];
                                                $suspay = $suspay + $row1["current"];
                                            }
                                            if($divi == "ENGINEERING SERVICES")
                                            {
                                                $estot = $estot + $row1["total"];
                                                $espay = $espay + $row1["current"];
                                            }
                                            if($divi == "SIMULATION & ANALYSIS SERVICES")
                                            {
                                                $simtot = $simtot + $row1["total"];
                                                $simpay = $simpay + $row1["current"];
                                            }
                                            if($divi == "LASER SCANNING SERVICES")
                                            {
                                                $lsstot = $lsstot + $row1["total"];
                                                $lsspay = $lsspay + $row1["current"];
                                            }
                                        }
                                    ?>
									
											<tr>
												<td><center> 1 </center></td>
												<td><center><a href="invoice-custom.php?id=1&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>">SUSTAINABILITY</a></center></td>
												<td><center><a href="invoice-custom.php?id=1&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $sustot ?></center></a></td>
												<td><center><a href="invoice-custom.php?id=1&set=2&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $suspay ?></center></a></td>
											</tr>
											<tr>
												<td><center> 2 </center></td>
												<td><center><a href="invoice-custom.php?id=2&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>">ENGINEERING SERVICES</a></center></td>
												<td><center><a href="invoice-custom.php?id=2&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $estot ?></center></a></td>
												<td><center><a href="invoice-custom.php?id=2&set=2&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $espay ?></center></a></td>
											</tr>
											<tr>
												<td><center> 3 </center></td>
												<td><center><a href="invoice-custom.php?id=3&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>">SIMULATION & ANALYSIS SERVICES</a></center></td>
												<td><center><a href="invoice-custom.php?id=3&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $simtot ?></center></a></td>
												<td><center><a href="invoice-custom.php?id=3&set=2&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $simpay ?></center></a></td>
											</tr>
											<tr>
												<td><center> 4 </center></td>
												<td><center><a href="invoice-custom.php?id=4&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>">LASER SCANNING SERVICES</a></center></td>
												<td><center><a href="invoice-custom.php?id=4&set=1&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $lsstot ?></center></a></td>
												<td><center><a href="invoice-custom.php?id=4&set=2&<?php echo 'fd='.$fd.'&td='.$td ?>"><?php echo $lsspay ?></center></a></td>
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
			$('#dataTableExample2').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
			$('#dataTableExample3').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
			$('#dataTableExample4').DataTable({
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