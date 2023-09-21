<?php
    ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user=$_SESSION["username"];
	date_default_timezone_set("Asia/Qatar");
	
    $id = $_REQUEST["id"];
    $m = $_REQUEST["m"];
	
	if($m == "")
	{
		$sql = "SELECT * FROM poss WHERE id='$id'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		$pid = $row["pid"];

		$sql1 = "SELECT * FROM project WHERE id='$pid'";
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();

		$eid = $row1["eid"];
	}
	else
	{
		$sql = "SELECT * FROM project WHERE id='$id'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		$pid = $row["id"];
		$eid = $row["eid"];
	}
	
    if(isset($_POST["save"]))
    {
        $po = $_POST["po"];
		$link = $_POST["link"];
		$time = date('y-m-d H:i:s');
		if($m == "")
		{
			$sql1 = "UPDATE poss SET polink='$link',po='$po' WHERE id='$id'";
			$sql2 = "INSERT INTO mod_details (enq_no,po_no,po,user_id,control,update_details,datetime) VALUES ('$eid','$pid','$id','$user','5','2','$time')";
		}
		else
		{
			$sql1 = "UPDATE project SET polink='$link',po='$po' WHERE id='$id'";
			$sql2 = "INSERT INTO mod_details (enq_no,po_no,user_id,control,update_details,datetime) VALUES ('$eid','$pid','$user','3','2','$time')";
		}
        if($conn->query($sql1) === TRUE)
        {
			if($conn->query($sql2) === TRUE)
			{
				header("Location: view-project.php?id=$pid&msg=Po Updated!");
			}
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
	<meta name="description" content="Edit po | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit po | Project Management System" />
	<meta property="og:description" content="Edit po | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit po | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Edit po</h4>
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

										<label class="col-sm-2 col-form-label">Po Link</label>
										<div class="col-sm-4">
											<input type="text" name="link" class="form-control" value="<?php echo $row["polink"] ?>">
										</div>
										<label class="col-sm-2 col-form-label">Po</label>
										<div class="col-sm-4">
											<input type="text" name="po" class="form-control" value="<?php echo $row["po"] ?>">
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

<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/slick-slider/slick.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap-wysihtml5.js"></script>
<script src="assets/js/admin.js"></script>
</body>
</html>