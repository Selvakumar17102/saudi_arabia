<?php

	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$id = $_REQUEST["id"];

	$scope = "";
	
    $sql = "SELECT * FROM enquiry WHERE id='$id'";
    $result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$sql1 = "SELECT * FROM scope WHERE eid='$id'";
	$result1 = $conn->query($sql1);
	if($result1->num_rows > 0)
	{
		while($row1 = $result1->fetch_assoc())
		{
			$scope .= $row1["scope"]."<br>";
		}
	}
	else
	{
		$scope = $row["scope"];
	}

	$pstatus = $row["pstatus"];
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
	<meta name="description" content="View Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="View Enquiry | Project Management System" />
	<meta property="og:description" content="View Enquiry | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>View Enquiry | Project Management System</title>
	
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

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		.lab
		{
			color: #49505C;
			font-size: 13px;
			padding: 10px;
		}
		.table th, .table td
		{
			text-align: center;
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
						<h4 class="breadcrumb-title">View Enquiry</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="widget-inner">
						<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile m-b30" method="post" enctype="multipart/form-data">
								<div class="m-b30">
								
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Division</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["rfq"] ?>" type="text" readonly>
										</div>

										<label class="col-sm-2 col-form-label">RFQ Id</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["rfqid"] ?>" type="text" readonly>
										</div>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Sub Division</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["division"] ?>" type="text" readonly>
										</div>

										<label class="col-sm-2 col-form-label">Enquiry Date</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo date('d-m-Y',strtotime($row["enqdate"])) ?>" type="text" readonly>
										</div>
										
									</div>
									
									<div class="form-group row">
									<label class="col-sm-2 col-form-label">Project Name*</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["name"] ?>" type="text" readonly>
										</div>

									<label class="col-sm-2 col-form-label">Location</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["location"] ?>" type="text" readonly>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Stage</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["stage"] ?>" type="text" readonly>
										</div>

                                        <label class="col-sm-2 col-form-label">Scope</label>
										<div class="col-sm-4">
                                        <label class="lab"><?php echo $scope ?></label>
										</div>

									</div>

									<div class="form-group row">
										<label style="color: black;font-style:bold;font-size:20px" class="col-sm-3 col-form-label">Client Details</label>
									</div>

                                    <div class="form-group row">

										<label class="col-sm-2 col-form-label">Client Name</label>

										<div class="col-sm-4 course">
                                        	<input class="form-control" value="<?php echo $row["cname"] ?>" type="text" readonly>
										</div>

										<label class="col-sm-2 col-form-label">Responsibility</label>

										<div class="col-sm-4 course">
                                        	<input class="form-control" value="<?php echo $row["responsibility"] ?>" type="text" readonly>
										</div>

									</div>

									<div class="form-group row">
										
                                        <label class="col-sm-2 col-form-label">Enquiry Status</label>

										<div class="col-sm-4">
                                        	<input class="form-control" value="<?php echo ucwords(strtolower($row["qstatus"]))	 ?>" type="text" readonly>
										</div>
										
										<label class="col-sm-2 col-form-label">Enquiry Deadline</label>

										<div class="col-sm-4">
                                        	<input class="form-control" value="<?php echo date('d-m-Y',strtotime($row["qdate"])) ?>" type="text" readonly>
										</div>
										
									</div>

									<div class="form-group row">
										
										<label class="col-sm-2 col-form-label">Notes</label>
										<div class="col-sm-10">
                                        	<textarea class="form-control" style="height:100px;resize: none" disabled><?php echo $row["notes"] ?></textarea>
										</div>
									</div>

								</div>
								<?php
									if($rowside["id"] != 2)
									{
								?>
								<div class="" >
									<div class="">
										<div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 20px;">
											<div class="col-sm-11">
											</div>
											<div class="col-sm-1">
												<a href="edit-enquiry.php?id=<?php echo $row["id"]?>" class="btn">Edit</a>
											</div>
										</div>
									</div>
								</div>
								<?php
									}
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
				if($user == "conserveadmin")
				{
			?>
			<div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="card-header">
							<h4>History</h4>
						</div>
						<div class="widget-inner">
							<div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
										<tr>
											<td>S.No</td>
											<td>Description</td>
											<td>User</td>
											<td>Content</td>
											<td>Time</td>
										</tr>
                                    </thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM mod_details WHERE enq_no='$id' AND control='1' ORDER BY id DESC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$desc = "";
												if($row["update_details"] == 1)
												{
													$desc = "Created";
												}
												else
												{
													$desc = "Edited";
												}
										?>
												<tr>
													<td><?php echo $count++ ?></td>
													<td><?php echo $desc ?></td>
													<td><?php echo $row["user_id"] ?></td>
													<td><?php echo rtrim($row["content"],',') ?></td>
													<td><?php echo date('d-m-Y | h:i:s A',strtotime($row["datetime"])) ?></td>
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
			<?php } ?>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
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