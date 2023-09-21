<?php
	ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM enquiry WHERE id='$id'";
    $result = $conn->query($sql);
	$row = $result->fetch_assoc();
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
	<meta name="description" content="Dropped Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Dropped Enquiry | Project Management System" />
	<meta property="og:description" content="Dropped Enquiry | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Dropped Enquiry | Project Management System</title>
	
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
				<h4 class="breadcrumb-title">Dropped Enquiry</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
					<li>Dropped Enquiry</li>
				</ul>
			</div>	
			<div class="row">
				<!-- Your Profile Views Chart -->
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

										<label class="col-sm-2 col-form-label">Division</label>
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
                                        <input class="form-control" value="<?php echo $row["scope"] ?>" type="text" readonly>
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
									</div>

									<div class="form-group row">
									<label class="col-sm-2 col-form-label">Responsibility</label>
										<div class="col-sm-4 course">
                                        <input class="form-control" value="<?php echo $row["responsibility"] ?>" type="text" readonly>
											
										</div>

                                        <label class="col-sm-2 col-form-label">Enquiry Status</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo $row["qstatus"] ?>" type="text" readonly>
										</div>
										
									</div>

									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Enquiry Date by Client</label>
										<div class="col-sm-4">
										<input class="form-control" value="<?php echo date('d-m-Y',strtotime($row["qdatec"])) ?>" type="text" readonly>
										</div>
													
										<label class="col-sm-2 col-form-label">Enquiry Submitted Date</label>
										<div class="col-sm-4">
                                        <input class="form-control" value="<?php echo date('d-m-Y',strtotime($row["qdate"])) ?>" type="text" readonly>
										</div>
									</div>

									<div class="form-group row">
										
										<label class="col-sm-2 col-form-label">Notes</label>
										<div class="col-sm-10">
                                        	<textarea class="form-control" style="height:100px" readonly><?php echo $row["notes"] ?></textarea>
										</div>
									</div>

								</div>
								
							</form>
							
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>

<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>

</body>
</html>