<?php
ini_set('display_errors','off');
session_start();
include("inc/dbconn.php");
if(isset($_POST['forgotpassword'])) {
$email = $_POST["email"];
$sql = "SELECT * FROM login WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row  = mysqli_fetch_array($result);
if(is_array($row)) {
$sql1 = "select username,password from login where email = '$email'";
$result1 = mysqli_query($conn, $sql1);	
while($row1 = mysqli_fetch_array($result1))
 {
	$username = $row1['username'];
	$password = $row1['password'];
$to = $email;
$email_subject = "PMS : Admin Forgot Password";
$email_body = "Username: $username\n\nPassword: $password";
$headers = "From: info@conservesolution.com\n";
$headers .= "Reply-To: $email";
mail($to,$email_subject,$email_body,$headers);
 }
header("Location: forgot-password.php?msg=Check your mail. we will send new password!");
} else {
header("Location: forgot-password.php?msg=Email Id Wrong!"); 
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
	<meta name="description" content="Forgot Password | Enquiry Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Forgot Password | Enquiry Management System" />
	<meta property="og:description" content="Forgot Password | Enquiry Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Forgot Password | Enquiry Management System</title>
	
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
					<h2 class="title-head">Forgot <span>Password</span></h2>
					<p style="text-align: center;color: red;"><?php echo $_REQUEST['msg']; ?></p>
				</div>	
				<form class="contact-bx" name="changepassword" method="post" action="">
					<div class="row placeani">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="input-group"> 
									<label>Enter Register Email Id</label>
									<input name="email" type="email" class="form-control" required="">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group form-forget">
								<a href="index.php" class="ml-auto">Login</a>
							</div>
						</div>
						<div class="col-lg-12 m-b30">
							<input type="submit" name="forgotpassword" value="Submit" class="btn button-md" />
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
