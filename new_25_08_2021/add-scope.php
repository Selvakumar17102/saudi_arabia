<?php
    ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	
	$id = $_REQUEST["id"];
	$enq = $_REQUEST["enq"];
	$user=$_SESSION["username"];

    if(isset($_POST["save"]))
    {
        $divi = $_POST["rfq"];
		$scope = $_POST["scope"];
		$sub_divi = $_POST["sub_divi"];

		$sql = "INSERT INTO scope_list (divi,scope,sub_divi) VALUES ('$divi','$scope','$sub_divi')";
        if($conn->query($sql) === TRUE)
        {
			header("location: add-scope.php?msg=scope added!");
        }
        else
        {
            header("location: add-scope.php?msg=failed!");
        }
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
	<meta name="description" content="Edit Invoice | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Invoice | Project Management System" />
	<meta property="og:description" content="Edit Invoice | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Invoice | Project Management System</title>
	
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
				<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">Edit Invoice</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>	
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12">
					<div class="widget-box">
						
						<div class="widget-inner">
						<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile" method="post" enctype="multipart/form-data">
								<div class="m-b30">
								
									<div class="form-group row">

										<label class="col-sm-1 col-form-label">Division</label>
										    <div class="col-sm-3">
                                                <select class="form-control" name="rfq" id="rfq" required>
                                                    <option value readonly>Select RFQ...</option>
                                                    <option value="ENGINEERING">ENGINEERING </option>
                                                    <option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
                                                    <option value="SUSTAINABILITY">SUSTAINABILITY</option>
                                                    <option value="ENVIRONMENTAL">ENVIRONMENTAL</option>
                                                    <option value="ACOUSTICS">ACOUSTICS</option>
                                                    <option value="LASER SCANNING">LASER SCANNING</option>
                                                </select>
										    </div>

										<label class="col-sm-1 col-form-label">Sub Division</label>
										<div class="col-sm-3">
                                            <select name="sub_divi" id="" class="form-control" required>
                                                <option value="" selected value disabled>Select Sub Division</option>
                                                <option value="1">DEPUTATION</option>
												<option value="2">PROJECT</option>
                                            </select>
										</div>
										<label class="col-sm-1 col-form-label">Scope</label>
										<div class="col-sm-3">
                                            <input type="text" name="scope" class="form-control" required>
										</div>
									</div>
                                    <div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 10px">
                                        <div class="col-sm-11">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="submit" name="save" class="btn" value="Save">
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

		
		<!-- Slick Slider js-->
		<script src="assets/plugins/slick-slider/slick.js"></script>
		
		<!-- wysihtml5 editor js -->
		<script src="assets/plugins/bootstrap/js/bootstrap-wysihtml5.js"></script>
		
		<!-- Custom Js -->

<script src="assets/js/admin.js"></script>
</body>
</html>