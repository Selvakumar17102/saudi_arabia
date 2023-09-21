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

    $pstatus = $row["pstatus"];
	$rfqid = $row["rfqid"];
	$testing = substr_replace($rfqid,"",-3);
	$revision = $row["revision"];
	
    if(isset($_POST['save']))
    {
        $ps = $_POST["pstatus"];
		$date = $_POST["qdate"];
		$re = $_POST["revision"];
		$notes = $_POST["notes"];
		$value = $_POST["price"];

		if($re == "1")
		{
			$test = "_01";
			$count = "1";
			$replace = substr_replace($rfqid,$test,-3);
		}
		if($re == "2")
		{
			$test = "_02";
			$count = "2";
			$replace = substr_replace($rfqid,$test,-3);
		}
		if($re == "3")
		{
			$test = "_03";
			$count = "3";
			$replace = substr_replace($rfqid,$test,-3);
		}
		if($re == "4")
		{
			$test = "_04";
			$count = "4";
			$replace = substr_replace($rfqid,$test,-3);
		}
		if($re == "" || $re == "0")
		{
			$replace = $rfqid;
		}

		$time = date('y-m-d H:i:s');

		if($ps == "AWARDED")
		{
			$sql1 = "UPDATE enquiry SET pstatus='$ps',qdatec='$date' WHERE id='$id'";
		}
		else
		{
			if($ps == "LOST")
			{
				$sql1 = "UPDATE enquiry SET pstatus='$ps',notes='$notes' WHERE id='$id'";
				$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
				$conn->query($sql8);
			}
			else
			{
				if($re == "" || $re == "0")
				{
					$sql1 = "UPDATE enquiry SET rfqid='$replace',pstatus='$ps',qdatec='$date',price='$value' WHERE id='$id'";
					$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
					$conn->query($sql8);
				}
				else
				{
					$sql1 = "UPDATE enquiry SET rfqid='$replace',pstatus='$ps',qdatec='$date',revision='$count',price='$value' WHERE id='$id'";
					$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
					$conn->query($sql8);
				}
			}
		}

        if($conn->query($sql1) === TRUE)
        {
			if($ps == "AWARDED")
			{
				$sql3 = "INSERT INTO project (eid,nostatus) VALUES ('$id','0')";
				if($conn->query($sql3) === TRUE)
				{
					$sql9 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
					$result9 = $conn->query($sql9);
					$row9 = $result9->fetch_assoc();
					$id9 = $row9["id"];
					
					$sql8 = "INSERT INTO mod_details (enq_no,po_no,user_id,control,update_details,datetime) VALUES ('$id','$id9','$user','3','1','$time')";
					$conn->query($sql8);
					header("location: new-project.php?msg=Proposal/Quotation moved to Projects!&id=$id");
				}
			}
			else
			{
				if($ps == "LOST")
				{
					$sql2 = "INSERT INTO notes (rfqid,date,notes) VALUES ('$rfqid','$date','$notes')";
					if($conn->query($sql2) === TRUE)
					{
						header("location: client.php?msg=Status Updated!");
					}
				}
				else
				{
					$sql2 = "INSERT INTO notes (rfqid,date,revision,notes) VALUES ('$rfqid','$date','$re','$notes')";
					if($conn->query($sql2) === TRUE)
					{
						header("location: client.php?msg=Status Updated!");
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
	<meta name="description" content="Client Followup Edit | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Client Followup Edit | Project Management System" />
	<meta property="og:description" content="Client Followup Edit | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Client Followup Edit | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Edit Clients Followup</h4>
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

                                    <div class="form-group row" style="margin-bottom: 20px">
                                        <label class="col-sm-2 col-form-label">RFQ Id</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="text" name="rfqid" value="<?php echo $rfqid ?>" readonly>
                                        </div>

										<label class="col-sm-2 col-form-label">Enquiry Status</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="text" value="<?php echo $row["qstatus"] ?>" readonly>
                                        </div>
                                    </div>
								
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Project Status</label>
										<div class="col-sm-4">
                                            <?php
                                                $atc = $a = $d = $fu = $l = "";
                                                if($pstatus == "AWARDED")
                                                {
                                                    $atc = "selected";
                                                }
                                                if($pstatus == "FOLLOW UP")
                                                {
                                                    $a = "selected";
                                                }
                                                if($pstatus == "LOST")
                                                {
                                                    $d = "selected";
                                                }
                                            ?>
											<select class="form-control" name="pstatus" onclick="gets(this.value)">
												<option  value readonly>Select Status</option>
												<option <?php echo $atc ?> value="AWARDED">AWARDED</option>
												<option <?php echo $a ?> value="FOLLOW UP">FOLLOW UP</option>
												<option <?php echo $d ?> value="LOST">LOST</option>
											</select>
										</div>
										
										<label class="col-sm-2 col-form-label">Date</label>
										<div class="col-sm-4">
											<input type="date" name="qdate" value="<?php echo date('Y-m-d')?>" class="form-control">
										</div>
									</div>

									<?php
										$sql4 = "SELECT * FROM notes WHERE rfqid LIKE '$testing%' ORDER BY revision DESC LIMIT 1";
										$result4 = $conn->query($sql4);
										$row4 = $result4->fetch_assoc();
									?>

									<div class="form-group row">

									<?php
										if($result4->num_rows == "0" OR $row4["revision"] == "") 
										{
											
											$testings = '0';
										} 
										else 
										{ 
											$testings = $row4["revision"] ;
										}
									?>
										<div class="col-sm-6 de">
											<div class="row">
												<div class="col-sm-12">
													<div class="row">
														<div class="col-sm-4">
															<label class="col-form-label">Revision</label>
														</div>
														<div class="col-sm-8">
															<div class="">
																<select class="form-control" name="revision">
																	<option  value="<?php echo $row4["revision"] ?>">Revision <?php echo $testings ?></option>
																	<option value="1">Revision 1</option>
																	<option value="2">Revision 2</option>
																	<option value="3">Revision 3</option>
																	<option value="4">Revision 4</option>
																</select>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-12 m-t10">
													<div class="row">
														<div class="col-sm-4">
															<label class="col-form-label">Value</label>
														</div>
														<div class="col-sm-8">
															<input type="number" min='0' class="form-control" name="price" value="<?php echo $row["price"] ?>" required=false>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<label class="col-sm-2 de col-form-label">Notes</label>
										<div class="col-sm-4">
											<textarea name="notes" class="form-control de"></textarea>
										</div>

									</div>

								</div>
								<div class="" >
									<div class="">
										<div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 20px;">
											<div class="col-sm-11">
											</div>
											<div class="col-sm-1">
												<button type="submit" name="save" class="btn">Update</button>
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
		if(val == "FOLLOW UP")
		{
			document.getElementsByClassName('de')[0].style.display = 'block';
			document.getElementsByClassName('de')[1].style.display = 'block';
			document.getElementsByClassName('de')[2].style.display = 'block';
		}
		else
		{
			if(val == "LOST")
			{
				document.getElementsByClassName('de')[2].style.display = 'block';
				document.getElementsByClassName('de')[0].style.display = 'none';
				document.getElementsByClassName('de')[1].style.display = 'block';
			}
			else
			{
				document.getElementsByClassName('de')[0].style.display = 'none';
				document.getElementsByClassName('de')[1].style.display = 'none';
				document.getElementsByClassName('de')[2].style.display = 'none';
			}
		}
	}
</script>


</body>
</html>