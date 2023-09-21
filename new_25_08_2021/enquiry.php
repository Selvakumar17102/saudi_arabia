<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$div = $_REQUEST['div'];
	$stage = $_REQUEST['stage'];
	$date1 = $_REQUEST['date'];
	if($date1 == "today"){
		 $today = $date;
	} else {
		 $month = $date1;
	}
	if($div == "Sustainability"){
		$div1 = "SUSTAINABILITY";
	}
	if($div == "Engineering"){
		$div1 = "ENGINEERING SERVICES";
	}
	if($div == "Simulation"){
		$div1 = "SIMULATION & ANALYSIS SERVICES";
	}
	if($div == "Depu"){
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
	<meta name="description" content="All Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Enquiry | Project Management System" />
	<meta property="og:description" content="All Enquiry | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Enquiry | Project Management System</title>
	
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
				<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title"><?php echo $div1; ?></h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>			
			</div>				

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
											<th>S.NO</th>
											<th>RFQ</th>											
											<th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Responsibility</th>
                                            <th>Scope</th>
                                            <th>Stage</th>
                                            <th>Enquiry Status</th>
                                            <th>Submission Deadline</th>
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
											if($date != '' && $stage != '' && $today != ''){
											$sql1 = "SELECT * FROM enquiry WHERE division = '$div1' AND enqdate = '$today' AND stage = '$stage'";
											} else if($date != '' && $stage != '' && $month != ''){
											$sql1 = "SELECT * FROM enquiry WHERE division = '$div1' AND MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND stage = '$stage'";
											} else if($stage == '' && $today != ''){
											$sql1 = "SELECT * FROM enquiry WHERE division = '$div1' AND enqdate = '$today'";
											} else if($stage == '' && $month != ''){
											$sql1 = "SELECT * FROM enquiry WHERE division = '$div1' AND MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE())";
											} else {
												$sql1 = "SELECT * FROM enquiry WHERE division = '$div1' AND stage = '$stage' AND qstatus = 'NOT SUBMITTED'";
											}
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{
												$eid = $row1["id"];
												$scope = "";

												$sql = "SELECT * FROM scope WHERE eid='$eid'";
												$result = $conn->query($sql);
												if($result->num_rows > 0)
												{
													while($row = $result->fetch_assoc())
													{
														$scope .= $row["scope"]."<br>";
													}
												}
												else
												{
													$scope = $row1["scope"];
												}
												$date = strtotime($row1["qdate"]);
												echo '<tr style="background-color:'.$tempcolor.'">';
												echo '<td><center>'.$count.'</center></td>';
												echo '<td><center>'.$row1["rfq"].'</center></td>';
												
												echo '<td><center><a href="view-enquiry.php?id='.$row1["id"].'">'.$row1["name"].'</a></center></td>';
												echo '<td><center>'.$row1["cname"].'</center></td>';
												echo '<td><center>'.$row1["responsibility"].'</center></td>';
												echo '<td><center>'.$scope.'</center></td>';
												echo '<td><center>'.$row1["stage"].'</center></td>';
												echo '<td><center>'.$row1["qstatus"].'</center></td>';
												echo '<td><center>'.date('d-m-Y', $date).'</center></td>';
												if($rowside["id"] != 2)
												{
												?>
												<td><table><tr><td><a href="revision-edit.php?id=<?php echo $row1["id"]; ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td><td><a href="view-enquiry.php?id=<?php echo $row1["id"]; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td><td><a href="edit-enquiry.php?id=<?php echo $row1["id"]; ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td><td><a href="delete-enquiry.php?id=<?php echo $row1["id"]; ?>" onClick="return confirm('Sure to Delete this Enquiry !');"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr></table></td>
												<?php
												}
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