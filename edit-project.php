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

	$project_id = $row['id'];
	$divi1 = $row["divi"];
	$value1 = $row["value"];
	$gst_value = $row["gst_value"];
	$type1 = $row["subdivi"];
	$noofm1 = $row["noofm"];
	$dept1 = $row["dept"];
	$status1 = $row["status"];
	$finalq1 = $row["finalq"];
	$invdues1 = $row["invdues"];
	$scope_type = $row["scope_type"];
	$open_status = $row["open_status"];
	$logo_url = $row["logo"];
	$my_payment_responsibility = $row['payment_responsibility'];

	$open = $exp = "none";
	$open_yes = "selected";
	if($row['po_status'] == "Yes")
	{
		$open = "block";

		if($open_status == "No")
		{
			$exp = "block";
			$open_yes = "";
			$open_no = "selected";
			$exp_date = $row["exp_date"];
		}
	}
	

	$mb = "";
	if($row["pterms"] == "2")
	{
		$mb = "Monthly";
		$montyly = "selected";
	}
	if($row["pterms"] == "1")
	{
		$mb = "Milestone";
		$mil = "readonly";
		$milestone = "selected";
	}
	if($row["pterms"] == "3")
	{
		$mb = "Prorata";
		$prorata = "selected";
	}

	if($row['po_status'] == "Yes")
	{
		$yes = "selected";
	}else{
		$no = "selected";
	}

	$sql9 = "SELECT * FROM commu WHERE pid='$project_id'";
	$result19 = $conn->query($sql9);
	$row9 = $result19->fetch_assoc();

	$sql10 = "SELECT * FROM poss WHERE pid='$project_id'";
	$result10 = $conn->query($sql10);
	$row10 = $result10->fetch_assoc();

	$eid = $row["eid"];
	$proid = $row["proid"];
	$scope = $row["scope"];
	$count = substr($row["proid"], 8);

	$sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
	$result1 = $conn->query($sql1);
	$row1 = $result1->fetch_assoc();

	$enq_id = $row1["id"];
	$scope_id = $row1['scope'];

	if($scope_type == 0)
	{
		$sql2 = "SELECT * FROM scope WHERE eid='$enq_id'";
		$result2 = $conn->query($sql2);
		if($result2->num_rows > 0)
		{	
			if($result2->num_rows == 1){
				$row2 = $result2->fetch_assoc();
				$scope = $row2["scope"];
			} else{
				while($row2 = $result2->fetch_assoc())
				{
					$scope .= $row2["scope"].",";
				}
			}
		}else{
			$scope = $row1['scope'];
		}
	}
	else
	{
		$sql2 = "SELECT * FROM scope_list WHERE id='$scope_id'";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();

		$scope = $row2["scope"];
	}
	

	$rfqid = $row1["rfqid"];

    if(isset($_POST['save']))
    {
		$logo = $cont = "";
		$divi = $_POST["divi"];
		$value = $_POST["value"];
		$gst_value = $_POST["gst_value"];
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
		$cname = $_POST["cname"];
		$pname = $_POST["pname"];
		$pterms = $_POST["pterms"];
		$po_status = $_POST['po_status'];
		$open_status = $_POST['open_status'];
		$exp_date = $_POST['exp_date'];
		$url = $_POST['url'];
		$payment_responsibility = $_POST['payment_responsibility'];
		$totcp = count($_POST["contactId"]);

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

		// $resumename1=$_FILES["logo"]["name"];
        $resumename = "Logo/".$row["name"].basename($resumename1);
        $resumetype = Pathinfo($resumename1,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF');

		$projid = strtoupper($first)."-".strtoupper($second)."-".$count;

		$time = date('y-m-d H:i:s');
		for($i=0;$i<$totcp;$i++)
		{
					 $idContact = $_POST["contactId"][$i];
					  $cp = $_POST["cp"][$i];
					 $cpd = $_POST["cpd"][$i];
					 $pn = $_POST["pn"][$i];
					 $email = $_POST["email"][$i];
					  $sqlContact = "UPDATE client SET cp='$cp',cpd='$cpd',pn='$pn',email='$email' WHERE id='$idContact'";
					  $conn->query($sqlContact);
				
		}
		if($exp_date == "")
		{
			$sql2 = "UPDATE project SET logo='$url',proid='$projid',divi='$divi',value='$value',gst_value = '$gst_value',subdivi='$type',noofm='$noofm',status='$status',finalq='$finalq',invdues='$invdues',pterms='$pterms',po_status='$po_status',open_status='$open_status',payment_responsibility='$payment_responsibility' WHERE id='$id'";
		}else{
			$sql2 = "UPDATE project SET logo='$url',proid='$projid',divi='$divi',value='$value',gst_value = '$gst_value',subdivi='$type',noofm='$noofm',status='$status',finalq='$finalq',invdues='$invdues',pterms='$pterms',po_status='$po_status',open_status='$open_status',exp_date='$exp_date',payment_responsibility='$payment_responsibility' WHERE id='$id'";
		}
		if($conn->query($sql2) === TRUE)
		{
			if($cont != "")
			{
				$sql8 = "INSERT INTO mod_details (enq_no,po_no,user_id,control,update_details,content,datetime) VALUES ('$eid','$id','$user','3','2','$cont','$time')";
				$conn->query($sql8);
			}
			
		 	if($link != "" || $po != "")
		 	{
				$sql55 = "SELECT * FROM poss WHERE pid = '$id'";
				$result55 = $conn->query($sql55);
				if($result55->num_rows > 0){
					$sql6 = "UPDATE poss SET po ='$link',polink ='$po' WHERE pid='$id'";
				}
				else{
					$sql6 = "INSERT INTO poss (pid,po,polink) VALUES ('$id','$link','$po')";
				}
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

					$sql3 = "UPDATE invoice SET total='$value',gst_value = '$gst_value',pid='$projid' WHERE id='$invid'";
					if($conn->query($sql3) === TRUE)
		 			{
		 				header("location:all-projects.php?msg=Project Updated!");
		 			}
		 		}
			}
		 	else
			{
		 		$sql3 = "UPDATE invoice SET total='$value',gst_value = '$gst_value',pid='$projid' WHERE rfqid='$rfqid'";
		 		if($conn->query($sql3) === TRUE)
		 		{
		 			header("location:all-projects.php?msg=Project Updated!");
		 		}
		 	}

			$sql11 = "UPDATE enquiry SET cname='$cname',name='$pname' WHERE id='$eid'";
			$conn->query($sql11);

			$sql12 = "SELECT * FROM invoice WHERE pid='$proid'";
			$result12 = $conn->query($sql12);
			if($result12->num_rows > 0)
			{
				while ($row12 = $result12->fetch_assoc()) {
					$invoice_id = $row12['id'];
					$current = $row12['current'];
					$percentage = round($current/$value * 100,2);

					$sql13 = "UPDATE invoice SET total='$value',gst_value ='$gst_value',percent='$percentage' WHERE id='$invoice_id'";
					if($conn->query($sql13)==TRUE)
					{
						header("location: all-projects.php?msg=updated!");
					}
				}
			}
	 	}
		else
		{
		header("location: all-projects.php?msg=Project not Updated!&id=$id");
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
										
									?>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">RFQ Id</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" value="<?php echo $row1["rfqid"] ?>" readonly>
										</div>
									
										<label class="col-sm-2 col-form-label">Project</label>
										<div class="col-sm-4">
                                            <input class="form-control" name="pname" type="text" value="<?php echo $row1["name"] ?>">
										</div>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Client</label>
										<div class="col-sm-4">
											<!-- <input class="form-control" type="text" value="<?php echo $row1["cname"] ?>" readonly> -->
											<select class="form-control" name="cname" required>
												<option value selected Disabled>Select Client</option>
												<?php
													$sql6 = "SELECT * FROM main ORDER BY name ASC";
													$result6 = $conn->query($sql6);
													while($row6 = $result6->fetch_assoc())
													{
														$selected = "";
														if($row6['name'] == $row1['cname'])
														{
															$selected = "selected";
														}
												?>
														<option value="<?php echo $row6["name"] ?>" <?php echo $selected;?>><?php echo $row6["name"] ?></option>
												<?php
													}
												?>
											</select>
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
										<div class="col-sm-1">
											<center><label class="col-form-label">VAT Value</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Payment Terms</label></center>
										</div>
										<div class="col-sm-2">
											<center><label class="col-form-label">Project Type</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">PO Link</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">PO Ref.No</label></center>
										</div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Invoice Dues</label></center>
										</div>
									</div>

									<div class="form-group row m-b30">
										<div class="col-sm-1">
											<center><label class="col-form-label"><?php echo $scope ?></label></center>
										</div>
										<div class="col-sm-2">
											<select name="divi" class="form-control">
												<?php
													$eng = $sa = $su = $env = $ac = $lss = $og = "";
													if($divi1 == "ENGINEERING")
													{
														$eng = "selected";
													}
													if($divi1 == "SIMULATION & ANALYSIS")
													{
														$sa = "selected";
													}
													if($divi1 == "SUSTAINABILITY")
													{
														$su = "selected";
													}
													if($divi1 == "ACOUSTICS")
													{
														$ac = "selected";
													}
													if($divi1 == "LASER SCANNING")
													{
														$lss = "selected";
													}
													if($divi1 == "OIL & GAS")
													{
														$og = "selected";
													}
												?>
												<option value="ENGINEERING" <?php echo $eng;?>>ENGINEERING </option>
												<option value="SIMULATION & ANALYSIS" <?php echo $sa;?>>SIMULATION & ANALYSIS</option>
												<option value="SUSTAINABILITY" <?php echo $su;?>>SUSTAINABILITY</option>
												<option value="ACOUSTICS" <?php echo $ac;?>>ACOUSTICS</option>
												<option value="LASER SCANNING" <?php echo $lss;?>>LASER SCANNING</option>
												<option value="OIL & GAS" <?php echo $og;?>>OIL & GAS</option>
											</select>
										</div>
										<div class="col-sm-1">
											<input type="number" min="0" step="any" class="form-control" name="value" placeholder="Value" value="<?php echo $value1; ?>">
										</div>
										<div class="col-sm-1">
											<input type="number" min="0" step="any" class="form-control" name="gst_value" placeholder="VAT Value" value="<?php echo $gst_value; ?>">
										</div>
										<div class="col-sm-1">
											<!-- <center><label style="color: #767676" class="col-form-label"><?php echo $mb ?></label></center> -->
											<select class="form-control" name="pterms" onclick="fun(this.value,<?php echo $i ?>)">
												<option value="">Select Term</option>
												<option value="1" <?php echo $milestone;?>>Milestone Basis</option>
												<option value="2" <?php echo $montyly;?>>Monthly Basis</option>
												<option value="3" <?php echo $prorata;?>>Prorata Basis</option>
											</select>
										</div>
										<div class="col-sm-2">
											<select class="form-control" name="type" required>
												<?php
													$d = $p = "";
													if($type1 == "Deputation")
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
										<?php
											$poss_sql = "SELECT * FROM poss WHERE pid = '$id' ORDER BY id DESC LIMIT 1";
											$poss_result = $conn->query($poss_sql);
											$poss_row = $poss_result->fetch_assoc();
										?>
										<div class="col-sm-1">
											<input type="text" name="po" class="form-control" value="<?php echo $poss_row['polink']; ?>" placeholder="PO Link">
										</div>
										<div class="col-sm-2">
											<input type="text" name="link" class="form-control" value="<?php echo $poss_row['po']; ?>" placeholder="PO Number">
										</div>
										<div class="col-sm-1">
											<input type="number" name="noofm" class="form-control" placeholder="Dues" min="0" value="<?php echo $noofm1; ?>">
										</div>
									</div>
									<div class="row">
										<label class="col-sm-1 col-form-label">PO Status</label>
										<div class="col-sm-3">
											<select class="form-control" name="po_status" onchange="checK_open(this.value)" required>
												<option selected value disabled>Select PO Status</option>
												<option value="Yes" <?php echo $yes;?>>Yes</option>
												<option value="No" <?php echo $no;?>>No</option>
											</select>
										</div>

										<label class="col-sm-1 col-form-label" id="open_lable" style="display: <?php echo $open;?>">Open PO</label>
										<div class="col-sm-3">
											<select class="form-control" name="open_status" id="open_status" style="display: <?php echo $open;?>" onchange="check_exp(this.value)">
												<option selected value disabled>Select PO Status</option>
												<option value="Yes" <?php echo $open_yes;?>>Yes</option>
												<option value="No" <?php echo $open_no;?>>No</option>
											</select>
										</div>
										<label class="col-sm-1 col-form-label" id="exp_lable" style="display: <?php echo $exp;?>">Expiry Date</label>
										<div class="col-sm-3">
											<input type="date" name="exp_date" id="exp_date" style="display: <?php echo $exp;?>" class="form-control" value="<?php echo $exp_date;?>">
										</div>

									</div>
									
									<div class="form-group row m-t30">
									<div class="col-sm-1">
											<center><label class="col-form-label">Status</label></center>
									</div>
										<?php
											$ru = $co = $clo = "";
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
											if($status1 == "Hold")
											{
												$hold = "selected";
											}
										?>
										
										<div class="col-sm-3">
											<select class="form-control" name="status">
												<option value disabled selected>Select Status</option>
											        <option <?php echo $hold ?> value="Hold">Hold</option>
												<option <?php echo $ru ?> value="Running">Running</option>
												<option <?php echo $co ?> value="Commercially Open">Commercially Open</option>
												<option <?php echo $clo1 ?> value="Project Closed">Project Closed</option>
												<option <?php echo $clo2 ?> value="Commercially Closed">Commercially Closed</option>
											</select>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Logo</label></center>
										</div>
										<div class="col-sm-2">
											<input type="text" name="url" id="url" placeholder="Client url" class="form-control" value="<?php echo $logo_url;?>">
											<!-- <input class="custom-file-input" type="file" name="logo" id="customFile">
											<label class="custom-file-label" for="customFile">Upload Client Logo</label> -->
										</div>
										<div class="col-sm-1">
											<center><a href="<?php echo $row["logo"] ?>" target="_blank"><i style="margin-top: 2px" class="fa fa-picture-o fa-2x" aria-hidden="true"></i></a></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Payment Dues</label></center>
										</div>
										<div class="col-sm-3">
											<input class="form-control" type="text" id="invdues" name="invdues" placeholder="Payment dues" value="<?php echo $invdues1 ?>">
										</div>

										<!-- <div class="col-sm-4">
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
										</div> -->

									</div>
									<?php
 												$rfqid = $row1["rfqid"];
												 $rfqid1 = substr($rfqid, 0, -3);
												 $sql2 = "SELECT * FROM client WHERE rfqid LIKE '$rfqid1%'";
												 $result2 = $conn->query($sql2);
											 
											if (mysqli_num_rows($contactData))
											 {
											?>
									<div class="form-group row">
											<div class="col-sm-1"></div>
											<label style="color:red;font-weight:bold" class="col-sm-2 col-form-label">Contact Details</label>
										</div>
										<?php
										}?>
						
										<?php
												$rfqid = $row1["rfqid"];
												$rfqid1 = substr($rfqid, 0, -3);
												$sql2 = "SELECT * FROM client WHERE rfqid LIKE '$rfqid1%'";
												$result2 = $conn->query($sql2);
											
											 $index=1;
											while ($rowData = $result2->fetch_assoc()) {
											?>
														<div class="form-group row">
														<input class="form-control" type='text' hidden name="contactId[]" value="<?php  echo $rowData['id'] ?>" >
											<label class="col-sm-2 col-form-label">Contact Person  <?php  echo $index ?></label>	
											<div class="col-sm-2">
												<input class="form-control" type="text" name="cp[]" placeholder="name" value="<?php  echo $rowData['cp'] ?>">
											</div>
											<div class="col-sm-2">
												<input class="form-control" type="text" name="cpd[]" placeholder="designation" value="<?php  echo $rowData['cpd'] ?>">
											</div>
											<div class="col-sm-2">
												<input class="form-control" type="number" name="pn[]" placeholder="phone number" value="<?php  echo $rowData['pn'] ?>">
											</div>
											<div class="col-sm-2">
												<input class="form-control" type="email" name="email[]" placeholder="email" value="<?php  echo $rowData['email'] ?>">
											</div>
											</div>
											<?php
											$index++;
											}
											?>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<label style="color:red;font-weight:bold" class="col-sm-2 col-form-label">File Uploads</label>
									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Final Quotation</label>
										<div class="col-sm-10">
											<input class="form-control" type="text" name="finalq" value="<?php echo $finalq1 ?>">
										</div>
										
									
									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Communication</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" name="comrefno" placeholder="Ref. No" value="">
										</div>
										<div class="col-sm-5">
											<input class="form-control" type="text" name="comlink" placeholder="Link" value="">
										</div>
									</div>
									<div class="row">
										<label class="col-sm-2 col-form-label">Payment Responsibility</label>
										<div class="col-sm-6">
											<select name="payment_responsibility" id="payment_responsibility" class="form-control">
												<option value="<?php echo $my_payment_responsibility ?>"><?php echo $my_payment_responsibility ?></option>
												<?php
													$responsibility_sql = "SELECT * FROM login WHERE responsibility = 1";
													$responsibility_result = $conn->query($responsibility_sql);
													while($responsibility_row = mysqli_fetch_array($responsibility_result)){
												?>
												<option value="<?php echo $responsibility_row['name'] ?>"><?php echo $responsibility_row['name'] ?></option>
												<?php			
													}
												?>
											</select>
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
<script>
	function checK_open(value)
	{
		if(value == "Yes")
		{
			document.getElementById('open_lable').style.display = 'block';
			document.getElementById('open_status').style.display = 'block';
			document.getElementById('invdues').required = true;

		}else{
			document.getElementById('open_lable').style.display = 'none';
			document.getElementById('open_status').style.display = 'none';
			document.getElementById('invdues').required = false;
		}
	}

	function check_exp(value) {
		if(value == "No")
		{
			document.getElementById('exp_lable').style.display = 'block';
			document.getElementById('exp_date').style.display = 'block';
			document.getElementById('exp_date').required = true;
		}else{
			document.getElementById('exp_lable').style.display = 'none';
			document.getElementById('exp_date').style.display = 'none';
			document.getElementById('exp_date').required = false;
		}
	}
</script>
</body>
</html>
