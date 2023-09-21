<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	
	$id = $_REQUEST["id"];
	
	if($id == 1)
	{
		$div = "SUSTAINABILITY";
		$div1 = "SUSTAINABILITY";
	}
	if($id == 2)
	{
		$div = "ENGINEERING SERVICES";
		$div1 = "ENGINEERING";
	}
	if($id == 3)
	{
		$div = "SIMULATION & ANALYSIS SERVICES";
		$div1 = "SIMULATION & ANALYSIS";
	}
	if($id == 4)
	{
		$div = "DEPUTATION";
		$div1 = "DEPUTATION";
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
	<meta name="description" content="All Statement | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Statement | Project Management System" />
	<meta property="og:description" content="All Statement | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Statement | Project Management System</title>
	
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
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	<style>
	.table th, .table td {text-align: center;}
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
						<h4 class="breadcrumb-title"><?php echo $div ?></h4>
					</div>
					
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
					
				</div>
				
			</div>
			<!-- Card -->
			

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th style="color: #C54800">Project Id</th>
											<th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Scope</th>
											<th>Payment Terms</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$pstatus = "AWARDED";
											$sql = "SELECT * FROM enquiry WHERE pstatus='$pstatus'";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$eid = $row["id"];
												$scope = "";
												$sql1 = "SELECT * FROM project WHERE eid='$eid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();

												$sql2 = "SELECT * FROM scope WHERE eid='$eid'";
												$result2 = $conn->query($sql2);
												if($result2->num_rows > 0)
												{
													while($row2 = $result2->fetch_assoc())
													{
														$scope .= $row2["scope"]."<br>";
													}
												}
												else
												{
													$scope = $row["scope"];
												}

												if($row1["pterms"] == 1)
												{
													$mode = "MileStone";
												}
												if($row1["pterms"] == 2)
												{
													$mode = "Monthly";
												}
												if($row1["pterms"] == 3)
												{
													$mode = "Prorata";
												}

												if($row1["divi"] == $div1)
												{
										?>
												<tr>
													<td><?php echo $count++ ?></td>
													<td><?php echo $row1["proid"] ?></td>
													<td><a href="statement-main.php?id=<?php echo $eid ?>"><?php echo $row["name"] ?></a></td>
													<td><?php echo $row["cname"] ?></td>
													<td><?php echo $scope ?> Basis</td>
													<td><?php echo $mode ?> Basis</td>
												</tr>
										<?php
												}
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
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [6, 25, 50, -1],
                    [6, 25, 50, "All"]
                ],
                "iDisplayLength": 6
            });
</script>
</body>
</html>