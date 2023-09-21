<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	$user=$_SESSION["username"];	
    $id = $_REQUEST["id"];
    $tests = $_REQUEST["test"];

    $sql = "SELECT * FROM enquiry WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $pstatus = $row["qstatus"];
    $rfqid = $row["rfqid"];

    if(isset($_POST['save']))
    {
        $ps = $_POST["qstatus"];
		$date = $_POST["qdate"];
		$notes = $_POST["notes"];
		$time = date('y-m-d H:i:s');

		if($ps == "SUBMITTED")
		{
			$foll = "FOLLOW UP";

			$sql = "SELECT * FROM scope WHERE eid='$id'";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				$i = 0;
				while($row = $result->fetch_assoc())
				{
					$sid = $row["id"];
					$pv = $_POST["pv"][$i];

					$sql2 = "UPDATE scope SET value='$pv' WHERE id='$sid'";
					if($conn->query($sql2) === TRUE)
					{
						$sql1 = "UPDATE enquiry SET qstatus='$ps',qdate='$date',pstatus='$foll' WHERE id='$id'";
						if($conn->query($sql1) === TRUE)
						{
							$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
							$conn->query($sql8);	
							header("location: client.php?msg=Revision updated And Enquiry moved to Proposal Followup!");
						}
					}
					$i++;
				}
			}
			else
			{
				$pv = $_POST["pv"][0];
				$check = $_POST["check"][0];
				if($check == "")
				{
					$check = 0;
				}
				$sql1 = "UPDATE enquiry SET qstatus='$ps',qdate='$date',price='$pv',pstatus='$foll' WHERE id='$id'";
				if($conn->query($sql1) === TRUE)
				{
					if($tests == "")
					{
						header("location: all-enquiry.php?msg=Revision Updated!");
					}
					else
					{
						header("location: selected-enquiry.php?msg=Revision Updated!&id=$tests");
					}
				}
			}
		}
		else
		{
			if($ps == "DROPPED")
			{
				$sql1 = "UPDATE enquiry SET qstatus='$ps',notes='$notes' WHERE id='$id'";
			}
			else
			{
				$sql1 = "UPDATE enquiry SET qstatus='$ps',qdate='$date' WHERE id='$id'";
			}
			if($conn->query($sql1) === TRUE)
			{
				
				if($ps == "DROPPED")
				{
					header("location: all-enquiry.php?msg=Enquiry moved to Dropped!");
				}
				else
				{
					if($tests == "")
					{
						header("location: all-enquiry.php?msg=Revision Updated!");
					}
					else
					{
						header("location: selected-enquiry.php?msg=Revision Updated!&id=$tests");
					}
				}
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
	<meta name="description" content="Update Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Update Enquiry | Project Management System" />
	<meta property="og:description" content="Update Enquiry | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Update Enquiry | Project Management System</title>
	
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

	<style>
		.de
		{
			display: none;
		} 
		.des
		{
			display: none;
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
						<h4 class="breadcrumb-title">Update Enquiry</h4>
					</div>
					<div class="col-sm-1">
                        <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
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
                                        <label class="col-sm-2 col-form-label">RFQ ID</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="text" name="rfqid" value="<?php echo $rfqid ?>" readonly>
                                        </div>
                                    </div>
								
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Quotation Status</label>
										<div class="col-sm-3">
                                            <?php
                                                $atc = $a = $d = $fu = $l = "";
                                                if($pstatus == "SUBMITTED")
                                                {
                                                    $atc = "selected";
                                                }
                                                if($pstatus == "NOT SUBMITTED")
                                                {
                                                    $a = "selected";
                                                }
                                                if($pstatus == "DROPPED")
                                                {
                                                    $d = "selected";
                                                }
                                            ?>
											<select class="form-control" id="qstatus" name="qstatus" onclick="gets(this.value)">
												<option <?php echo $atc ?> value="SUBMITTED">SUBMITTED</option>
												<option <?php echo $a ?> value="NOT SUBMITTED">NOT SUBMITTED</option>
												<option <?php echo $d ?> value="DROPPED">DROPPED</option>
											</select>
										</div>
										
										<label class="col-sm-2 col-form-label right">Submitted Date</label>
										<div class="col-sm-2">
											<input type="date" name="qdate" value="<?php echo date('Y-m-d')?>" class="form-control">
										</div>

									</div>

									<div class="form-group de">

										<?php
											$sql1 = "SELECT * FROM scope WHERE eid='$id'";
											$result1 = $conn->query($sql1);
											if($result1->num_rows > 0)
											{
												while($row1 = $result1->fetch_assoc())
												{
											?>
												<div class="row m-b10">
													<label class="col-sm-2 col-form-label">Scope</label>
													<label class="col-sm-3 col-form-label"><?php echo $row1["scope"] ?></label>
													<label class="col-sm-1 col-form-label right">Value</label>
													<div class="col-sm-3">
														<input type="number" name="pv[]" id="pv" class="form-control" placeholder="QAR">
													</div>
													<!-- <div class="col-sm-2">
														<div class="form-check">
															<input style="margin-top:10px" class="form-check-input" type="checkbox" name="check[]" value="1">
															<label class="col-form-label">
																Monthly Basis
															</label>
														</div>
													</div> -->
												</div>
											<?php
												}
											}
											else
											{
										?>
												<div class="row">
													<label class="col-sm-2 col-form-label">Scope</label>
													<label class="col-sm-3 col-form-label"><?php echo $row["scope"] ?></label>
													<label class="col-sm-1 col-form-label right">Value</label>
													<div class="col-sm-3">
														<input type="number" name="pv" id="pv" class="form-control" placeholder="QAR">
													</div>
													<!-- <div class="col-sm-2">
														<div class="form-check">
															<input style="margin-top:10px" class="form-check-input" type="checkbox" name="check" value="1" id="defaultCheck1">
															<label class="col-form-label" for="defaultCheck1">
																Monthly Basis
															</label>
														</div>
													</div> -->
												</div>
										<?php
											}
										?>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 des col-form-label">Reason</label>
										<div class="col-sm-3 des">
											<textarea name="notes" id="notes" class="form-control"></textarea>
										</div>

									</div>

								</div>
								<div class="" >
									<div class="">
										<div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 20px;">
											<div class="col-sm-11">
											</div>
											<div class="col-sm-1">
												<input type="submit" name="save" class="btn" value="Update">
											</div>
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

<script>
	function gets(val)
	{
		if(val == "SUBMITTED")
		{
			document.getElementsByClassName('de')[0].style.display = 'block';
			document.getElementsByClassName('des')[0].style.display = 'none';
			document.getElementsByClassName('des')[1].style.display = 'none';
		}
		else
		{
			if(val == "DROPPED")
			{
				document.getElementsByClassName('des')[0].style.display = 'block';
				document.getElementsByClassName('des')[1].style.display = 'block';
				document.getElementsByClassName('de')[0].style.display = 'none';
			}
			else
			{
				document.getElementsByClassName('de')[0].style.display = 'none';
				document.getElementsByClassName('des')[0].style.display = 'none';
				document.getElementsByClassName('des')[1].style.display = 'none';
			}
		}
	}
</script>

</body>
</html>