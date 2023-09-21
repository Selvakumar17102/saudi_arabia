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
        $division 		= $_POST["division"];
		$gst_percentage = $_POST['gst_percentage'];
		// $sql = "INSERT INTO division (division,gst_percentage) VALUES ('$division','$gst_percentage')";
		$sql = "UPDATE division SET gst_percentage = '$gst_percentage' WHERE id ='$division'";
        if($conn->query($sql) === TRUE)
        {
			header("location: set_vat.php?msg=Set VAT Successufully!");
        }
        else
        {
            header("location: set_vat.php?msg=failed!");
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
	<meta name="description" content="VAT| Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="VAT | Project Management System" />
	<meta property="og:description" content="VAT | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Set VAT | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Set VAT%</h4>
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

										<label class="col-sm-2 col-form-label">Division</label>
											<div class="col-sm-4">
												<select name="division" class="form-control" id="division" required>
													<option value="">--Select Division--</option>
													<?php
														$divsion_show_sql = "SELECT * FROM division";
														$divsion_show_result = $conn->query($divsion_show_sql);
														while($divsion_show_row = mysqli_fetch_array($divsion_show_result)){
															?>
															<option value="<?php echo $divsion_show_row["id"]?>"><?php echo $divsion_show_row["division"]?></option>
															<?php
														}
													?>
												</select>
										    </div>
										<label class="col-sm-2 col-form-label">Set VAT%</label>
										<div class="col-sm-4">
											<input class="form-control" type="number" name="gst_percentage" placeholder="Set VAT%" required>
											<!-- <select name="gst_percentage" id="gst_percentage" class="form-control" required>
                                                <option value="" selected value disabled>--Select GST%--</option>
                                                <option value="5">5%</option>
												<option value="12">12%</option>
												<option value="18">18%</option>
												<option value="28">28%</option>
                                            </select> -->
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