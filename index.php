<?php
	ini_set('display_errors','off');
	session_start();
	include("inc/dbconn.php");


	$url =  isset($_SERVER['HTTPS']) &&
	$_SERVER['HTTPS'] === 'on' ? "https://" : "http://";  
	
	$url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];    
	$splitedBySlash = explode('/', $url); 
	$location =  $splitedBySlash[4];

	if(count($_POST) > 0)
	{
		$user = $_POST["username"];
		$pass = $_POST["password"];

		$sql = "SELECT * FROM login WHERE BINARY username = '$user'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$desi = $row['designation'];

			if($row["password"] === $pass && $row["location"] == $location)
			{
				
				$_SESSION["username"] = $user;
				$_SESSION["control"] = $desi;
				$_SESSION["saudi_branch"] = $location;
				
				header("Location: dashboard.php");
			}
			else
			{
				header("Location: index.php?msg=Invalid Password!");
			}
		} 
		else 
		{
			header("Location: index.php?msg=Invalid Username!");
		}
	}
	if(isset($_SESSION["username"])) 
	{

		if($_SESSION['username'] == $user){
			
			$userid = $_SESSION["username"];
			$control = $_SESSION['control'];
			header("Location: dashboard.php");
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
	<meta name="description" content="Conserve Solutions | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Conserve Solutions | Project Management System" />
	<meta property="og:description" content="Conserve Solutions | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Conserve Solutions | Project Management System</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- DataTable ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables/dataTables.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	
</head>
<body id="bg">
<div class="page-wraper">
	<div id="loading-icon-bx"></div>
	<div class="account-form">
		<div class="account-head" style="background-image:url(assets/images/bg.png);">
			<a href="index.php"><img src="assets/images/logo.svg" alt=""></a>
		</div>
		<div class="account-form-inner">
			<div class="account-container">
				<div class="heading-bx left">
				    <h1 style="text-align: center;">Project Management Tool</h1>
					<h3 class="title-head">Login to your <span>Account</span></h3>
					<p style="text-align: center;color: red;"><?php echo $_REQUEST['msg']; ?></p>
				</div>	
				<form class="contact-bx" name="login" method="post" action="">
					<div class="row placeani">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group">
									<label>Your Name</label>
									<input name="username" type="text" required="" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group"> 
									<label>Your Password</label>
									<input name="password" type="password" class="form-control" required="">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group form-forget">
								<a href="forgot-password.php" class="ml-auto">Forgot Password?</a>
							</div>
						</div>
						<div class="col-lg-12 m-b30">
							<input name="submit" type="submit" name="login" value="Submit" class="btn button-md" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src="assets/js/functions.js"></script>
<script src="assets/js/contact.js"></script>
</body>
</html>
