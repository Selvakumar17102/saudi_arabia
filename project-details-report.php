<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
	$user = $_SESSION["user"];
    $qst = "SUBMITTED";
	$pst = "FOLLOW UP";
	
	$div = $_REQUEST["div"];
	$stage = $_REQUEST["stage"];

	$start_date = $_REQUEST['start_date'];
	$end_date = $_REQUEST['end_date'];
	$from = 0;

	if($start_date == "" || $end_date == "")
	{
		$start_date = date("Y-m-01");
		$end_date = date("Y-m-t");
		$from = 1;
	}

    $type = $_REQUEST["type"];
    $my_division = $_REQUEST["division"];

	$d1 = $d2 = $d3 = $d4 = "";

	if($div == "ENGINEERING")
	{
		$d1 = "selected";
	}
	if($div == "SIMULATION & ANALYSIS")
	{
		$d2 = "selected";
	}
	if($div == "SUSTAINABILITY")
	{	
		$d3 = "selected";
	}
	if($div == "ENVIRONMENTAL")
	{
		$d4 = "selected";
	}
	if($div == "ACOUSTICS")
	{
		$d5 = "selected";
	}
	if($div == "LASER SCANNING")
	{
		$d6 = "selected";
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
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Proposal Followup | Project Management System</title>
	
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
						<h4 class="breadcrumb-title"><?php echo $my_division;?></h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>

			<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <h4><?php echo $text ?></h4>
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">
                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
											<th>S.NO</th>
											<th>Enquiry Date</th>
											<th style="color: #C54800">RFQ ID</th>
											<th>Project Name</th>
											<th>Project Type</th>
                                            <th>Client Name</th>
											<th>Scope</th>
                                            <th>Responsible Person</th>
                                            <th>Submitted Date</th>
											<th>Stage</th>
											<th>Enquiry Status</th>
											<th>Project Status</th>
                                            <th>Proposal Value (₹)</th>
											<th>VAT Value (₹)</th>
											<th>Revision</th>
											<?php
												if($type == 10)
												{
													?>
														<th>Lost Date</th>
													<?php
												}
											?>
											<?php
												if($user == "conserveadmin")
												{
											?>
											<th>Last Updated</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											if($type == 1){
												if($from)
												{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND new_status='1'";
												} else{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND new_status='1' AND enqdate BETWEEN '$start_date' AND '$end_date' ";
												}
											}elseif ($type == 2) {
												
												if($from)
												{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Job In Hand' AND new_status='1'";
												} else{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Job In Hand' AND new_status='1' AND enqdate BETWEEN '$start_date' AND '$end_date'";
												}
											}elseif ($type == 3) {
												$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND enqdate BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
											}elseif ($type == 4) {
												$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Job In Hand' AND enqdate BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
											}elseif ($type == 5) {
												if($from)
												{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND pstatus='FOLLOW UP' AND new_status='1'";
												}else{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND pstatus='FOLLOW UP' AND new_status='1' AND enqdate BETWEEN '$start_date' AND '$end_date'";
												}
											}elseif ($type == 6) {
												if($from)
												{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND pstatus='FOLLOW UP' AND new_status='1' AND qstatus!='DROPPED'";
												}else{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND pstatus='FOLLOW UP' AND new_status='1' AND qstatus!='DROPPED' AND enqdate BETWEEN '$start_date' AND '$end_date'";
												}
											}elseif ($type == 7) {
												if($from)
												{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND pstatus='AWARDED' AND new_status='1'";
												}else{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND pstatus='AWARDED' AND new_status='1' AND enqdate BETWEEN '$start_date' AND '$end_date'";
												}
											}elseif ($type == 8) {
												$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND pstatus='AWARDED' AND enqdate BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
											}elseif ($type == 9) {
												if($from)
												{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND pstatus='LOST' AND new_status='1'";
												}else{
													$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND pstatus='LOST' AND new_status='1' AND qdatec BETWEEN '$start_date' AND '$end_date'";
												}
											}elseif ($type == 10) {
												$sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND pstatus='LOST' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
											}
											$result1 = $conn->query($sql1);
											$Total_tenders = $result1->num_rows;
											$count = 1;
											// echo $result1->num_rows; exit();
											if($result1->num_rows > 0)
											{
												while($row1 = $result1->fetch_assoc())
												{
													$id = $row1["id"];
													$scope = $words = $value = "";
													$value = $row1["price"];
													$gst_value = $row1["gst_value"];
													$scope_id = $row1['scope'];
													$scope_type = $row1['scope_type'];

													$sql6 = "SELECT * FROM mod_details WHERE enq_no='$id' AND control='1' ORDER BY id DESC LIMIT 1";
													$result6 = $conn->query($sql6);
													$row6 = $result6->fetch_assoc();
													if($row6["update_details"] == 1)
													{
														$s = "Created";
													}
													else
													{
														$s = "Edited";
													}
													if($scope_type == 1)
													{
														$sql = "SELECT * FROM scope_list WHERE id='$scope_id'";
														$result = $conn->query($sql);
														if($result->num_rows > 0)
														{
															$row = $result->fetch_assoc();
															$scope = $row["scope"];	
														}
													}else{
														$sql = "SELECT * FROM scope WHERE eid='$id'";
														$result = $conn->query($sql);
														if($result->num_rows > 0)
														{
															while($row = $result->fetch_assoc())
															{
																$scope = $row["scope"]."<br>";
																$value = $row["value"]."<br>";
																$gst_value = $row["gst_value"]."<br>";
															}
														}else{
															$scope = $row1['scope'];
															$value = $row1['value'];
														}
													}

													echo '<tr style="background-color:'.$tempcolor.' !important;">';
													echo '<td><center>'.$count.'</center></td>';
													echo '<td><center>'.date('d-m-Y', strtotime($row1['enqdate'])).'</center></td>';
													echo '<td><center>'.$row1["rfqid"].'</center></td>';
													echo '<td><center><a href="client-view.php?id='.$row1["id"].'">'.$row1["name"].'</a></center></td>';
													echo '<td><center>'.$row1["division"].'</center></td>';
													echo '<td><center>'.$row1["cname"].'</center></td>';
													echo '<td><center>'.$scope.'</center></td>';
													echo '<td><center>'.$row1["responsibility"].'</center></td>';
													echo '<td><center>'.date('d-m-Y', strtotime($row1["qdate"])).'</center></td>';
													echo '<td><center>'.$row1["stage"].'</center></td>';
													echo '<td><center>'.$row1["qstatus"].'</center></td>';
													echo '<td><center>'.$row1["pstatus"].'</center></td>';
													if($words == "1")
													{
														echo '<td><center>'.$value.'</center></td>';
														echo '<td><center>'.$gst_value.'</center></td>';
													}
													else
													{
														echo '<td><center>'.$value.'</center></td>';
														echo '<td><center>'.$gst_value.'</center></td>';
													}
														// echo '<td><center>'.$value.'</center></td>';
													echo '<td><center>'.$row1["revision"].'</center></td>';
													?>
													<?php
														if($type == 10)
														{
															echo '<td><center>'.date('d-m-Y', strtotime($row1["qdatec"])).'</center></td>';
														
														}
													?>
													<?php
														if($user == "conserveadmin")
														{
													?>
														<td><center>
													<?php
															if($row6["user_id"] != "")
															{
																echo $s.' by '.$row6["user_id"].'<br>'.date('d-m-Y | h:i:s a',strtotime($row6["datetime"]));
															}
															else
															{
																echo "-";
															}
													?>
														</center></td>
														<?php
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
<script>
	function direct(val)
	{
		if(val == 1)
		{
			location.replace("job-in-hand.php");
		}
		else
		{
			location.replace("job-in-hand.php?ch=1");
		}
	}
	function divi(val)
	{
		if(val == "SIMULATION & ANALYSIS SERVICES")
		{
			val = "SIMULATION+%26+ANALYSIS+SERVICES";
		}
		location.replace("client.php?div="+val);
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