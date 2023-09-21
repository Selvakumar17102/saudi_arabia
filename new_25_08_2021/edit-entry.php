<?php
    ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	
	$id = $_REQUEST["id"];
	$enq = $_REQUEST["enq"];
	$user=$_SESSION["username"];
	
	$sql2 = "SELECT * FROM project WHERE eid='$enq'";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	$pid = $row2["proid"];
	$proid = $row2["id"];
    
    $sql = "SELECT * FROM invoice WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(isset($_POST["save"]))
    {
        $demo = $_POST["demo"];
		$month = $_POST["month"];
		$inv = $_POST["inv"];
		$bank = $_POST["bank"];
		
		if($row["term"] == 2)
		{
			$sql1 = "UPDATE invoice SET demo='$demo',month='$month',invdoc='$inv',pid='$pid',bank='$bank' WHERE id='$id'";
		}
		else
		{
			$sql1 = "UPDATE invoice SET demo='$demo',invdoc='$inv',pid='$pid',bank='$bank' WHERE id='$id'";
		}
		$time = date('y-m-d H:i:s');
        if($conn->query($sql1) === TRUE)
        {
			$sql2 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime) VALUES ('$enq','$proid','$id','$user','4','2','$time')";
			if($conn->query($sql2) === TRUE)
			{
				header("Location: statement-main.php?id=$enq&msg=Invoice Updtaed!");
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

										<label class="col-sm-2 col-form-label">Invoice</label>
										<div class="col-sm-4">
                                            <input type="number" min="0" name="demo" class="form-control" value="<?php echo $row["demo"] ?>">
										</div>
									<?php
										if($row["term"] == 2)
										{
									?>
										<label class="col-sm-2 col-form-label">Month</label>
										<div class="col-sm-4">

                                            <select class="form-control" name="month" required>
                                                <option value="<?php echo $row["month"] ?>"><?php echo $row["month"] ?></option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
									<?php
										}
									?>
								        </div>
										
									</div>
									
									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Invoice Link</label>
										<div class="col-sm-4">
											<input type="text" name="inv" class="form-control" value="<?php echo $row["invdoc"] ?>">
										</div>
										<label class="col-sm-2 col-form-label">Cheque / Bank Transfer</label>
										<?php
											$ref = "";
											if($row["bank"] == "")
											{
												if($row["refdoc"] != "")
												{
													$ref = $row["refdoc"];
												}
											}
											else
											{
												$ref = $row["bank"];
											}
										?>
										<div class="col-sm-4">
											<input type="text" name="bank" class="form-control" value="<?php echo $ref ?>">
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
<script>
$('.extra-field-box').each(function() {
	var $wrapp = $('.multi-box', this);
	$(".add-field", $(this)).on('click', function() {
		$('.dublicat-box:first-child', $wrapp).clone(true).appendTo($wrapp).find('input').val('').focus();
	});
	$('.dublicat-box .remove-field', $wrapp).on('click', function() {
		if ($('.dublicat-box', $wrapp).length > 1)
			$(this).parent('.dublicat-box').remove();
		});
	});
</script>
<script>
	function dates()
	{
		var y = document.getElementById("qdc").value;
		var vars = document.getElementById("qd").value;
		if(vars > y)
		{
			$("#qd").css("border", "1px solid red");
        	return false;
		}
		
	}

</script>

</body>
</html>