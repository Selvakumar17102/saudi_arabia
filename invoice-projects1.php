<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

	$id = $_REQUEST["id"];

	$test = "";
	
	if($id == 1)
	{
		$test = "MileStone";
	}
	if($id == 2)
	{
		$test = "Monthly";
	}
	if($id == 3)
	{
		$test = "Prorata";
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
	<meta name="description" content="Invoice Projects | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Invoice Projects | Project Management System" />
	<meta property="og:description" content="Invoice Projects | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice Projects | Project Management System</title>
	
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
	<?php include_once("inc/header.php");?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Project Invoice</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
					<li>Invoice</li>
				</ul>
				
			</div>	
			<!-- Card -->
			

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">
						<div class="card-header">
							<h4><?php echo $test ?> Projects</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
                                            <th>Client Name</th>
											<th>Total Value</th>
											<th>Remaining Value</th>
											<th>Previous Invoice Value</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM project WHERE pterms='$id' AND status='Commercially Open'";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$ids = $row["eid"];
												$pid = $row["id"];
												$proid = $row["proid"];
												$total = $row["value"];
												$sql1 = "SELECT * FROM enquiry WHERE id='$ids'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();
												$rfqid = $row1["rfqid"];
												echo '<tr>';
                                                echo '<td><center>'.$count.'</center></td>';
                                                echo '<td><center>'.$row1["rfq"].'</center></td>';
                                                echo '<td><center>'.$row["proid"].'</center></td>';
                                                echo '<td><center>'.$row1["name"].'</center></td>';
                                                echo '<td><center>'.$row1["cname"].'</center></td>';
												echo '<td><center>'.$total.'</center></td>';
												$sql2 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqid' AND paystatus='2'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();
												$testing = $total-$row2["current"];												
                                                echo '<td><center>'.$testing.'</center></td>';
												$sql3 = "SELECT current FROM invoice WHERE rfqid='$rfqid' AND paystatus='2' order by id DESC limit 1";
												$result3 = $conn->query($sql3);
												$row3 = $result3->fetch_assoc();
												$preamount = $row3["current"];	
												if($preamount == "")
												{
													$preamount = 0;
												}
												echo '<td><center>'.($total-$testing).'</center></td>';												
                                                echo '<td><center><a href="invoice.php?id='.$pid.'" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>';
                                                echo '</tr>';
                                                $count++;
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