<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");

	$user=$_SESSION["username"];
	$id = $_REQUEST["id"];

	$sql = "SELECT * FROM project WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$divi1 = $row["divi"];
	$value1 = $row["value"];
	$type1 = $row["subdivi"];
	$noofm1 = $row["noofm"];
	$dept1 = $row["dept"];
	$status1 = $row["status"];
	$finalq1 = $row["finalq"];
	$invdues1 = $row["invdues"];

	$eid = $row["eid"];
	$proid = $row["proid"];
	$scope = $row["scope"];
	$count = substr($row["proid"], 8);

	$sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
	$result1 = $conn->query($sql1);
	$row1 = $result1->fetch_assoc();

	if($row1["scope"] == "")
	{
		$sql5 = "SELECT * FROM scope WHERE id='$scope'";
		$result5 = $conn->query($sql5);
		$row5 = $result5->fetch_assoc();

		$row1["scope"] = $row5["scope"];
	}

	$rfqid = $row1["rfqid"];

    if(isset($_POST['save']))
    {
		$logo = $cont = "";
		$divi = $_POST["divi"];
		$value = $_POST["value"];
		$type = $_POST["type"];
		$noofm = $_POST["noofm"];
		$dept = $_POST["dept"];
		$status = $_POST["status"];
		$finalq = $_POST["finalq"];
		$invdues = $_POST["invdues"];
		$po = $_POST["po"];
		$link = $_POST["link"];
		$comrefno = $_POST["comrefno"];
		$comlink = $_POST["comlink"];

		if($divi != $divi1)
		{
			$cont .= "Division,";
		}
		if($value != $value1)
		{
			$cont .= "Total,";
		}
		if($type != $type1)
		{
			$cont .= "Subdivision,";
		}
		if($noofm != $noofm1)
		{
			$cont .= "Dues,";
		}
		if($dept != $dept1)
		{
			$cont .= "Department,";
		}
		if($status != $status1)
		{
			$cont .= "Status,";
		}
		if($finalq != $finalq1)
		{
			$cont .= "Final Quotation,";
		}
		if($invdues != $invdues1)
		{
			$cont .= "Invoice Dues,";
		}

		if($dept == "")
		{
			$dept = 0;
		}

		$first = substr($divi, 0, 3);
		$second = substr($type, 0, 3);

		$resumename1=$_FILES["logo"]["name"];
        $resumename = "Logo/".$row["name"].basename($resumename1);
        $resumetype = Pathinfo($resumename1,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');

		if($resumename1 != "")
		{
			if(in_array($resumetype, $allowTypes))
			{
				if(move_uploaded_file($_FILES["logo"]["tmp_name"], $resumename))
				{
					$logo = $resumename;
				}
				else
				{
					echo "HI";
				}
			}
			else
			{
				echo "<script>alert('File Format for logo is not accepted!')</script>";
			}
		}
		else
		{
			$logo = $row["logo"];
		}

		$projid = strtoupper($first)."-".strtoupper($second)."-".$count;

		$time = date('y-m-d H:i:s');

		$sql2 = "UPDATE project SET dept='$dept',logo='$logo',proid='$projid',divi='$divi',value='$value',subdivi='$type',noofm='$noofm',status='$status',finalq='$finalq',invdues='$invdues' WHERE id='$id'";
		if($conn->query($sql2) === TRUE)
		{
			if($cont != "")
			{
				$sql8 = "INSERT INTO mod_details (enq_no,po_no,user_id,control,update_details,content,datetime) VALUES ('$eid','$id','$user','3','2','$cont','$time')";
				$conn->query($sql8);
			}
			
		 	if($link != "" || $po != "")
		 	{
		 		$sql6 = "INSERT INTO poss (pid,po,polink) VALUES ('$id','$link','$po')";
				if($conn->query($sql6) === TRUE)
				{
					$sql8 = "SELECT * FROM poss ORDER BY id DESC LIMIT 1";
					$result8 = $conn->query($sql8);
					$row8 = $result8->fetch_assoc();

					$poid = $row8["id"];

					$sql8 = "INSERT INTO mod_details (enq_no,po_no,po,user_id,control,update_details,datetime) VALUES ('$eid','$id','$poid','$user','5','1','$time')";
					$conn->query($sql8);	
				}
			}
			if($comrefno != "" || $comlink != "")
			{
				$sql7 = "INSERT INTO commu (pid,comrefno,comlink) VALUES ('$id','$comrefno','$comlink')";
				$conn->query($sql7);
				
				$sql8 = "SELECT * FROM commu ORDER BY id DESC LIMIT 1";
				$result8 = $conn->query($sql8);
				$row8 = $result8->fetch_assoc();

				$poid = $row8["id"];

				$sql8 = "INSERT INTO mod_details (enq_no,po_no,comu,user_id,control,update_details,datetime) VALUES ('$eid','$id','$poid','$user','6','1','$time')";
				$conn->query($sql8);
			}
		 	$sql4 = "SELECT * FROM invoice WHERE pid='$proid'";
		 	$result4 = $conn->query($sql4);
		 	if($result4->num_rows > 0)
		 	{
		 		while($row4 = $result4->fetch_assoc())
		 		{
		 			$invid = $row4["id"];

					$sql3 = "UPDATE invoice SET total='$value',pid='$projid' WHERE id='$invid'";
					if($conn->query($sql3) === TRUE)
		 			{
		 				header("location:all-projects.php?msg=Project Updated!");
		 			}
		 		}
			}
		 	else
			{
		 		$sql3 = "UPDATE invoice SET total='$value',pid='$projid' WHERE rfqid='$rfqid'";
		 		if($conn->query($sql3) === TRUE)
		 		{
		 			header("location:all-projects.php?msg=Project Updated!");
		 		}
		 	}
	 }
		 else
		 {
		 	header("location:edit-project.php?msg=Project not Updated!&id=$id");
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
	<meta name="description" content="Edit Project | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Project | Project Management System" />
	<meta property="og:description" content="Edit Project | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Project | Project Management System</title>
	
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
		.border
		{
			border: 1px solid #B0B0B0 !important;
			padding: 5px 10px;
			border-radius: 4px;
		}
		.custom-file-label
		{
			font-weight: unset !important;
		}
		.hide
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
						<h4 class="breadcrumb-title">Edit Project</h4>
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
								
									<?php
										$de = $pr = $mil = "";
										$subdivi1 = $row["subdivi"];
										$mb = "";
										if($row["pterms"] == "2")
										{
											$mb = "Monthly";
										}
										if($row["pterms"] == "1")
										{
											$mb = "Milestone";
											$mil = "readonly";
										}
										if($row["pterms"] == "3")
										{
											$mb = "Prorata";
										}
									?>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">RFQ Id</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" value="<?php echo $row1["rfqid"] ?>" readonly>
										</div>
									
										<label class="col-sm-2 col-form-label">Project</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="text" value="<?php echo $row1["name"] ?>" readonly>
										</div>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Client</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" value="<?php echo $row1["cname"] ?>" readonly>
										</div>
									
										<label class="col-sm-2 col-form-label">Responsibility</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="text" value="<?php echo $row1["responsibility"] ?>" readonly>
										</div>

									</div>

									<div class="border">

									<div class="form-group row m-t30 m-b30">
										<div class="col-sm-1">
											<center><label class="col-form-label">Scope</label></center>
										</div>
										<div class="col-sm-2">
											<center><label class="col-form-label">Division</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Value</label></center>
										</div>
										<div class="col-sm-2">
											<center><label class="col-form-label">Payment Terms</label></center>
										</div>
										<div class="col-sm-2">
											<center><label class="col-form-label">Project Type</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Po Link</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Po Ref.No</label></center>
										</div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Dues</label></center>
										</div>
									</div>

									<div class="form-group row m-b30">
										<div class="col-sm-1">
											<center><label class="col-form-label"><?php echo $row1["scope"] ?></label></center>
										</div>
										<div class="col-sm-2">
											<select name="divi" class="form-control">
												<?php
													$su = $de = $en = $me = $sim = $lss = $mis = "";
													if($row["divi"] == "SUSTAINABILITY")
													{
														$su = "selected";
													}
													if($row["divi"] == "DEPUTATION")
													{
													$de = "selected";
													}
													if($row["divi"] == "ENGINEERING")
													{
														$en = "selected";
													}
													if($row["divi"] == "MEP")
													{
														$me = "selected";
													}
													if($row["divi"] == "SIMULATION & ANALYSIS")
													{
														$sim = "selected";
													}
													if($row["divi"] == "LASER SCANNING SERVICES")
													{
														$lss = "selected";
													}
													if($row["divi"] == "MISCELLANEOUS")
													{
														$mis = "selected";
													}
												?>
												<option <?php echo $su ?> value="SUSTAINABILITY">SUSTAINABILITY</option>
												<option <?php echo $de ?> value="DEPUTATION">DEPUTATION</option>
												<option <?php echo $en ?> value="ENGINEERING">ENGINEERING</option>
												<option <?php echo $me ?> value="MEP">MEP</option>
												<option <?php echo $sim ?> value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
												<option <?php echo $lss ?> value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
												<option <?php echo $mis ?> value="MISCELLANEOUS">MISCELLANEOUS</option>
											</select>
										</div>
										<div class="col-sm-1">
											<input type="number" min="0" class="form-control" name="value" placeholder="Value" value="<?php echo $row["value"] ?>">
										</div>
										<div class="col-sm-2">
											<center><label style="color: #767676" class="col-form-label"><?php echo $mb ?></label></center>
										</div>
										<div class="col-sm-2">
											<select class="form-control" name="type" required>
												<?php
													$d = $p = "";
													if($subdivi1 == "Deputation")
													{
														$d = "Selected";
													}
													else
													{
														$p = "Selected";
													}
												?>
												<option <?php echo $d ?> value="Deputation">Deputation</option>
												<option <?php echo $p ?> value="Project">Project</option>
											</select>
										</div>
										
										<div class="col-sm-1">
											<input type="text" name="po" class="form-control" placeholder="PO Link">
										</div>
										<div class="col-sm-2">
											<input type="text" name="link" class="form-control" placeholder="PO Number">
										</div>
										<div class="col-sm-1">
											<input type="number" name="noofm" class="form-control" placeholder="Dues" value="<?php echo $row["noofm"] ?>">
										</div>
									</div>
									
									<div class="form-group row m-t30">
										<?php
											$ru = $co = $clo = "";
											$status1 = $row["status"];
											if($status1 == "Running")
											{
												$ru = "selected";
											}
											if($status1 == "Commercially Open")
											{
												$co = "selected";
											}
											if($status1 == "Project Closed")
											{
												$clo1 = "selected";
											}
											if($status1 == "Commercially Closed")
											{
												$clo2 = "selected";
											}
										?>
										
										<div class="col-sm-4">
											<select class="form-control" name="status">
												<option value disabled selected>Select Status</option>
												<option <?php echo $ru ?> value="Running">Running</option>
												<option <?php echo $co ?> value="Commercially Open">Commercially Open</option>
												<option <?php echo $clo1 ?> value="Project Closed">Project Closed</option>
												<option <?php echo $clo2 ?> value="Commercially Closed">Commercially Closed</option>
											</select>
										</div>

										<div class="col-sm-3">
											<input class="custom-file-input" type="file" name="logo" id="customFile">
											<label class="custom-file-label" for="customFile">Upload Client Logo</label>
										</div>
										<div class="col-sm-1">
											<center><a href="<?php echo $row["logo"] ?>" target="_blank"><i style="margin-top: 2px" class="fa fa-picture-o fa-2x" aria-hidden="true"></i></a></center>
										</div>

										<div class="col-sm-4">
											<select name="dept" class="form-control" required>
												<option value disabled selected>Select Department</option>
												<?php
													$sql8 = "SELECT * FROM dept ORDER BY name ASC";
													$result8 = $conn->query($sql8);
													while($row8 = $result8->fetch_assoc())
													{
														$s = "";
														if($row["dept"] == $row8["id"])
														{
															$s = "SELECTED";
														}
												?>
														<option <?php echo $s ?> value="<?php echo $row8["id"] ?>"><?php echo $row8["name"] ?></option>
												<?php
													}
												?>
											</select>
										</div>

									</div>

									<div class="form-group row">
										<div class="col-sm-1"></div>
										<label style="color:red;font-weight:bold" class="col-sm-2 col-form-label">File Uploads</label>
									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Final Quotation</label>
										<div class="col-sm-10">
											<input class="form-control" type="text" name="finalq" value="<?php echo $row["finalq"] ?>">
										</div>
										
									
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Communication</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" name="comrefno" placeholder="Ref. No">
										</div>
										<div class="col-sm-5">
											<input class="form-control" type="text" name="comlink" placeholder="Link">
										</div>
										<label class="col-sm-1 col-form-label right">Dues</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" name="invdues" value="<?php echo $row["invdues"] ?>">
										</div>
									</div>


								</div>
								<div class="" >
									<div class="">
										<div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 20px;">
											<div class="col-sm-11">
											</div>
											<div class="col-sm-1">
												<input type="submit" name="save" class="btn" value="Save">
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
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
<script>
	function show(v)
	{
		var tester = document.getElementById("h"+v).style.display;

		if(tester == "block")
		{
			document.getElementById("h"+v).style.display = "none";
			document.getElementById(v).value = "+";	
		}
		else
		{
			document.getElementById("h"+v).style.display = "block";
			document.getElementById(v).value = "-";
		}
	}
</script>
</body>
</html>