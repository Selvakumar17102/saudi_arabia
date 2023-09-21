<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$date = date("Y-m-d");

	$id = $_REQUEST["id"];
	$div = $_REQUEST["div"];

	$divi = "";

	if($div == "Sustainability")
	{
		$divi = "SUSTAINABILITY";
	}
	if($div == "Engineering" || $div == "ENGINEERING SERVICES")
	{
		$divi = "ENGINEERING SERVICES";
	}
	if($div == "Simulation" || $div == "SIMULATION & ANALYSIS SERVICES")
	{
		$divi = "SIMULATION & ANALYSIS SERVICES";
	}
	if($div == "DEPUTATION")
	{
		$divi = "DEPUTATION";
	}

	$start = date('Y-m-01');
	$today = date('Y-m-d');
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
	<meta name="description" content="All Projects | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Projects | Project Management System" />
	<meta property="og:description" content="All Projects | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Projects | Project Management System</title>
	
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
			<div class="row m-b30">
				<div class="col-sm-11">
					<h4 class="breadcrumb-title">All Projects</h4>
				</div>
				<div class="col-sm-1">
					<?php
						if($id != "")
						{
					?>
						<a href="all-projects.php" style="color: #fff" class="bg-primary btn">Back</a>
					<?php
						}
					?>
				</div>
			</div>
			<!-- Card -->
			<div class="row head-count m-b30">

				<div class="col-lg-3">
					<a href="all-projects.php?id=1" title="Running Projects"><div class="widget-card widget-bg1">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Running
							</h4>
							<span class="wc-stats">
								<?php $tot1 = "SELECT * FROM project where status = 'Running'";
										$tot2 = $conn->query($tot1);
										$tot = $tot2->num_rows;
										if($tot > 0) {
											echo $tot;
										} else {
											echo $tot = 0;
										}
										?>
							</span>		
							
						</div>				      
					</div></a>
				</div>

				<div class="col-lg-3">
					<a href="all-projects.php?id=2" title="Commercially Open Projects"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Commercially Open
							</h4>
							<span class="wc-stats">
								<?php $tend1 = "SELECT * FROM project where status = 'Commercially Open'";
										$tend2 = $conn->query($tend1);
										$tend = $tend2->num_rows;
										if($tend > 0) {
											echo $tend;
										} else {
											echo $tend = 0;
										}
										?>
							</span>		
						
						</div>				      
					</div><a>
				</div>

				<div class="col-lg-3">
					<a href="all-projects.php?id=3" title="Project Closed"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Project Closed
							</h4>
							<span class="wc-stats">
								<?php $jobin1 = "SELECT * FROM project where status = 'Project Closed'";
										$jobin2 = $conn->query($jobin1);
										$jobin = $jobin2->num_rows;
										if($jobin > 0) {
											echo $jobin;
										} else {
											echo $jobin = 0;
										}
										?>
							</span>		
							
						</div>				      
					</div></a>
				</div>

				<div class="col-lg-3">
					<a href="all-projects.php?id=4" title="Commercially Closed"><div class="widget-card widget-bg4">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Commercially Closed
							</h4>
							<span class="wc-stats">
								<?php $jobin1 = "SELECT * FROM project where status = 'Commercially Closed'";
										$jobin2 = $conn->query($jobin1);
										$jobin = $jobin2->num_rows;
										if($jobin > 0) {
											echo $jobin;
										} else {
											echo $jobin = 0;
										}
										?>
							</span>		
							
						</div>				      
					</div></a>
				</div>
				
			</div>

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
                                            <th style="color: #C54800">S.NO</th>
											<th>Division</th>											
											<th>Project ID</th>
											<th>Project Name</th>
											<th>Client</th>
											<th>Scope</th>
											<th>Total PO (QAR)</th>
                                            <th>Month of Award</th>
											<th>Status of the Projects</th>
											<?php
														if($user == "conserveadmin")
														{
													?>
											<th>Last Updated</th>
											<?php
														}
													?>
											<?php
												if($rowside["id"] != 2)
												{
											?>
											<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											if($id == "")
											{
												$sql = "SELECT * FROM project ORDER BY id DESC";
											}
											else
											{
												$stat = "";
												if($id == "1")
												{
													$stat = "Running";
												}
												if($id == "2")
												{
													$stat = "Commercially Open";
												}
												if($id == "3")
												{
													$stat = "Project Closed";
												}
												if($id == "4")
												{
													$stat = "Commercially Closed";
												}

												$sql = "SELECT * FROM project WHERE status='$stat' ORDER BY id DESC";
											}
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$id = $row["id"];

												$sql6 = "SELECT * FROM mod_details WHERE po_no='$id' AND control='3' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();
												if($row6["update_details"] == 1)
												{
													$s1 = "Created";
												}
												else
												{
													$s1 = "Edited";
												}
												$status = $row["nostatus"];
												$proid = $row["proid"];
												$scope = $row["scope"];

												if($status == 0)
												{
													$tempcolor = "#f98585";
												}
												$id = $row["eid"];
												$pid = $row["id"];
												if($div == "")
												{
													$sql1 = "SELECT * FROM enquiry WHERE id='$id'";
												}
												else
												{
													// echo $sql1 = "SELECT * FROM enquiry WHERE id='$id' AND division='$divi' AND qdate BETWEEN '$start' AND '$today'";
													$sql1 = "SELECT * FROM enquiry WHERE id='$id' AND division='$divi'";
												}
												
												$result1 = $conn->query($sql1);
												if($result1->num_rows > 0)
												{
													$s = "";
													$divimain = $row["divi"];

													if($divimain == "")
													{
														$divimain = $row1["division"];
													}
													$row1 = $result1->fetch_assoc();

													if($scope != "0")
													{
														$sql2 = "SELECT * FROM scope WHERE id='$scope'";
														$result2 = $conn->query($sql2);
														$row2 = $result2->fetch_assoc();

														$s = $row2["scope"];
													}
													else
													{
														$s = $row1["scope"];
													}
													echo '<tr style="background-color:'.$tempcolor.'">';
													echo '<td><center>'.$count.'</center></td>';
													echo '<td><center>'.$divimain.'</center></td>';
													echo '<td><center>'.$row["proid"].'</center></td>';
													echo '<td><center>'.$row1["name"].'</center></td>';
													echo '<td><center>'.$row1["cname"].'</center></td>';
													echo '<td><center>'.$s.'</center></td>';
													echo '<td><center>'.$row["value"].'</center></td>';
													$time=strtotime($row1["qdatec"]);
													$month=date("F'y",$time);
													echo '<td><center>'.$month.'</center></td>';
													echo '<td><center>'.$row["status"].'</center></td>';
													?>
													<?php
														if($user == "conserveadmin")
														{
													?>
														<td><center>
													<?php
															if($row6["user_id"] != "")
															{
																echo $s1.' by '.$row6["user_id"].'<br>'.date('d-m-Y | h:i:s a',strtotime($row6["datetime"]));
															}
															else
															{
																echo "-";
															}
													?>
														</center></td>
														<?php
														}
													?>
													<?php
													if($rowside["id"] != 2)
													{
													if($status == 0)
													{?>
														<td><table class="action"><tr><td><a href="new-project.php?id=<?php echo $id; ?>" title="Edit"><span class="notification-icon dashbg-primary"><i class="fa fa-pencil" aria-hidden="true"></i></span></a></td><td><a href="view-project.php?id=<?php echo $pid; ?>" title="View"><span class="notification-icon dashbg-green"><i class="fa fa-eye" aria-hidden="true"></i></span></a></td><td><a href="deleted-project.php?id=<?php echo $id; ?>" title="delete" onclick="return confirm('Sure to Delete!');"><span class="notification-icon dashbg-red"><i class="fa fa-trash" aria-hidden="true"></i></span></a></td></tr></table></td>
													<?php }
													else
													{ ?>
														<td><table class="action"><tr><td><a href="edit-project.php?id=<?php echo $pid; ?>" title="Edit"><span class="notification-icon dashbg-primary"><i class="fa fa-pencil" aria-hidden="true"></i></span></a></td><td><a href="view-project.php?id=<?php echo $pid; ?>" title="View"><span class="notification-icon dashbg-green"><i class="fa fa-eye" aria-hidden="true"></i></span></a></td><td><a href="deleted-project.php?id=<?php echo $id; ?>" title="delete" onclick="return confirm('Sure to Delete!');"><span class="notification-icon dashbg-red"><i class="fa fa-trash" aria-hidden="true"></i></span></a></td></tr></table></td>
													<?php }
													}
													echo '</tr>';
													$count++;
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