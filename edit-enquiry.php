<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	$user=$_SESSION["username"];
	$id = $_REQUEST["id"];
	$m = $_REQUEST["m"];
	
	$sub_divition_id = 0;
    $sql = "SELECT * FROM enquiry WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

	$mainrfq = $row["rfqid"];
	$scope_id = $row['scope'];
	$division_name = $row['rfq'];
	$sub_divition_name = $row['division'];
	$scope_type = $row['scope_type'];
	$qstatus = $row["qstatus"]; 

	$gst_percentage_sql = "SELECT * FROM division WHERE division = '$division_name'";
	$gst_percentage_result = $conn->query($gst_percentage_sql);
	$gst_percentage_row = mysqli_fetch_array($gst_percentage_result);
	$gst_percentage = $gst_percentage_row['gst_percentage'];

	if($sub_divition_name == "DEPUTATION")
	{
		$sub_divition_id = 1;
	}else{
		$sub_divition_id = 2;
	}

	$exp_rfqid = explode('-', $mainrfq);
	$pro_abbr = $exp_rfqid[2];
	$client_abbr = $exp_rfqid[3];

    if(isset($_POST['save']))
    {
		$rfq = $_POST["rfq"];
		$division = $_POST["division"];
		$name = $_POST["name"];
		$location = $_POST["location"];
		$enqdate = $_POST["enqdate"];
		$stage = $_POST["stage"];
		$cname = $_POST["cname"];
		$responsibility = $_POST["responsibility"];
		$qstatus = $_POST["qstatus"];
		$qdate = $_POST["qdate"];
		$query = $_POST["query"];
		$notes = $_POST["notes"];
		$scope = $_POST["scope"];
		$cabre = $_POST['cabre'];
		$paddr = $_POST['paddr'];
		$proposal = $_POST['proposal'];
		$scope_gst_status = $_POST['scope_gst_status'];
		$scope_gst_value = $_POST['scope_gst_value'];
		$quotation = $_POST['quotation'];

		$scope_type = 1;
		
		if($scope =="others")
		{
			$scope = "0";
			$scope_type = 0;
			$countscope = count($_POST["o_scope"]);  
		}
		// echo $countscope."type";
		// 	echo $_POST['o_scope_gst_status0']; 
		// 	echo $_POST['o_scope_gst_status1']; 
		// 	echo "<br>".$_POST['o_scope_gst_status2']; 
		// 	echo "<br>".$_POST['o_scope_gst_status3']."<br>";
		// 	print_r($_POST['o_scope_proposal']) ;
		// 	exit();
		// if($row['qstatus'] != "SUBMITTED" || $scope = "others"){
		// 	$proposal = 0;
		// 	$scope_gst_status = 0;
		// 	$scope_gst_value = 0;
		// }
		
		$te = "";
		if($rfq == "ENGINEERING")
		{
			$te = "ENG";
		}
		if($rfq == "SUSTAINABILITY")
		{
			$te = "SUS";
		}
		if($rfq == "DEPUTATION")
		{
			$te = "DEP";
		}
		if($rfq == "MEP")
		{
			$te = "MEP";
		}
		if($rfq == "SIMULATION & ANALYSIS")
		{
			$te = "S&A";
		}
		if($rfq == "LASER SCANNING SERVICES")
		{
			$te = "LSS";
		}
		if($rfq == "MISCELLANEOUS")
		{
			$te = "MIS";
		}
		if($rfq == "ENVIRONMENTAL")
		{
			$te = "ENV";
		}
		if($rfq == "ACOUSTICS")
		{
			$te = "ACO";
		}
		if($rfq == "LASER SCANNING")
		{
			$te = "LSS";
		}
		if($rfq == "OIL & GAS")
		{
			$te = "O&G";
		}

		$rfqupdate = explode("-", $row["rfqid"]);
		$rfqid = $rfqupdate[0]."-".strtoupper($te)."-".$paddr."-".$cabre."-".date('m',strtotime($enqdate))."-".$rfqupdate[5]."-".$rfqupdate[6];
		$rfqid1 = substr($mainrfq, 0, -3);

		$sql1 = "SELECT * FROM notes WHERE rfqid LIKE '$rfqid1%'";
		$result1 = $conn->query($sql1);
		if($result1->num_rows > 0)
		{
			$result1->num_rows;
			while($row1 = $result1->fetch_assoc())
			{
				$noteid = $row1["id"];

				$sql2 = "UPDATE notes SET rfqid='$rfqid' WHERE id='$noteid'";
				if($conn->query($sql2) === TRUE)
				{
					header("Location: entire-enquiry.php?msg=Updated!&id=$id");
				}
			}
		}

		$sql3 = "SELECT * FROM invoice WHERE rfqid LIKE '$rfqid1%'";
		$result3 = $conn->query($sql3);
		if($result3->num_rows > 0)
		{
			$result3->num_rows;
			while($row3 = $result3->fetch_assoc())
			{
				$invid = $row3["id"];

				$sql4 = "UPDATE invoice SET rfqid='$rfqid' WHERE id='$invid'";
				if($conn->query($sql4) === TRUE)
				{
					header("Location: entire-enquiry.php?msg=Updated!&id=$id");
				}
			}
		}

		$sql5 = "SELECT * FROM client WHERE rfqid LIKE '$rfqid1%'";
		$result5 = $conn->query($sql5);
		if($result5->num_rows > 0)
		{
			$result5->num_rows;
			while($row5 = $result5->fetch_assoc())
			{
				$clientid = $row5["id"];

				$sql6 = "UPDATE client SET rfqid='$rfqid' WHERE id='$clientid'";
				if($conn->query($sql6) === TRUE)
				{
					header("Location: entire-enquiry.php?msg=Updated!&id=$id");
				}
			}
		}

		$time = date('y-m-d H:i:s');
		if($scope_type == 1){
			$default_scope_proposal 	= $_POST['default_scope_proposal'];
			$default_scope_gst_status 	= $_POST['default_scope_gst_status'];
			$default_scope_gst_value	= $_POST['default_scope_gst_value'];
			// If Change Custom to Default Scope delete Custom Scope from scope table
			// $mult_to_single_sql = "DELETE FROM scope WHERE eid = '$id'";
			// $mult_to_single_result = $conn->query($mult_to_single_sql);
			// ==========================================================================
			$sql = "UPDATE enquiry SET rfqid='$rfqid',division='$division',rfq='$rfq',name='$name',scope='$scope',scope_type='$scope_type',scope_value= '$default_scope_proposal', location='$location',enqdate='$enqdate',stage='$stage',cname='$cname',responsibility='$responsibility',qstatus='$qstatus',qdate='$qdate',notes='$notes',price='$default_scope_proposal',gst_status = '$default_scope_gst_status',gst_value ='$default_scope_gst_value',quotation = '$quotation' WHERE id='$id'";
		}
		if($scope_type ==0){
			$default_scope_proposal 	= "";
			$default_scope_gst_status 	= "";
			$default_scope_gst_value	="";

			$sql = "UPDATE enquiry SET rfqid='$rfqid',division='$division',rfq='$rfq',name='$name',scope='$scope',scope_type='$scope_type',scope_value= '$default_scope_proposal', location='$location',enqdate='$enqdate',stage='$stage',cname='$cname',responsibility='$responsibility',qstatus='$qstatus',qdate='$qdate',notes='$notes',price='$default_scope_proposal',gst_status = '$default_scope_gst_status',gst_value ='$default_scope_gst_value',quotation = '$quotation' WHERE id='$id'";
		}
		if($conn->query($sql) === TRUE)
		{
			if($scope_type == 1)
			{
				$sql12 = "UPDATE project SET scope='$scope',scope_type='1' WHERE eid='$id'";
				$conn->query($sql12);
			}
			$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
			$conn->query($sql8);

			$sql7 = "SELECT * FROM project WHERE eid='$id'";
			$result7 = $conn->query($sql7);

			if($result7->num_rows == 0)
			{
				if($scope_type == 0)
				{ 
					$sql1 = "DELETE FROM scope WHERE eid='$id'";
					if($conn->query($sql1) === TRUE)
					{ 
						$countscope1 = $countscope-1;
						// echo "<script>alert(".$countscope.");</script>";
						for($i=0;$i<$countscope;$i++)
						{
							$o_scope = $_POST["o_scope"][$i]; 
							$o_scope_gst_status	= $_POST["o_scope_gst_status".$i];
							$o_scope_proposal	= $_POST["o_scope_proposal"][$i];
							$o_scope_gst_value 	= $_POST["o_scope_gst_value"][$i];
							
							if($scope !="")
							{
								$sql2 = "INSERT INTO scope (eid,scope,value,gst_status,gst_value) VALUES ('$id','$o_scope','$o_scope_proposal','$o_scope_gst_status','$o_scope_gst_value')";
								if($conn->query($sql2) === TRUE)
								{
									if($m != "")
									{
										header("location: entire-enquiry.php?msg=Enquiry Updation Successful&id=$id");
									}
									else
									{
										header("location: entire-enquiry.php?msg=Enquiry Updation Successful&id=$id");
									}
								}else{
									header("location: entire-enquiry.php?msg=Enquiry Updation Successful&id=$id");
								}
							}
						}
					}else{
						header("location: entire-enquiry.php?msg=Scope Deletion faled!&id=$id");
					}
					
				}
			}
			else
			{
				if($scope_type == 0)
				{
					$sql1 = "DELETE FROM scope WHERE eid='$id'";
					if($conn->query($sql1) === TRUE)
					{
						$countscope1 = $countscope-1;
						for($i=0;$i<$countscope;$i++)
						{
							$o_scope = $_POST["o_scope"][$i]; 
							$o_scope_proposal	= $_POST["o_scope_proposal"][$i];
							$o_scope_gst_status	= $_POST["o_scope_gst_status".$i];
							$o_scope_gst_value 	= $_POST["o_scope_gst_value"][$i];

							if($scope !="")
							{
								$sql2 = "INSERT INTO scope (eid,scope,value,gst_status,gst_value) VALUES ('$id','$o_scope','$o_scope_proposal','$o_scope_gst_status','$o_scope_gst_value')";
								if($conn->query($sql2) === TRUE)
								{
									$sql11 = "UPDATE project SET scope='0',scope_type='0' WHERE eid='$id'";
									if($conn->query($sql11)==TRUE)
									{
										header("Location: entire-enquiry.php?msg=Enquiry updation successful&id=$id");
									}
								}else{
									header("location: entire-enquiry.php?msg=Enquiry Updation Successful&id=$id");
								}
							}
						}
					}else{
						header("location: entire-enquiry.php?msg=Scope Deletion faled!&id=$id");
					}
	
					header("location: entire-enquiry.php?msg=Enquiry Updation Successful&id=$id");
				}
			}
		}else{
			header("location: entire-enquiry.php?msg=$sql&id=$id");
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
	<meta name="description" content="Edit Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Enquiry | Project Management System" />
	<meta property="og:description" content="Edit Enquiry | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Enquiry | Project Management System</title>
	
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
		#scope_gst_value_input {
			display:none;
		}
		#scope_gst_value_div{
			display:none;
		}
		/* .c_scope{
			display:none;
		} */
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
						<h4 class="breadcrumb-title">Edit Enquiry</h4>
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
										<label class="col-sm-2 col-form-label">Division</label>
										<!-- <div class="col-sm-4">
											<select class="form-control" name="rfq">
												<option value="<?php echo $row["rfq"] ?>"><?php echo $row["rfq"] ?></option>
												<option value="SUSTAINABILITY">SUSTAINABILITY</option>
												<option value="DEPUTATION">DEPUTATION</option>
												<option value="MEP">MEP</option>
												<option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
												<option value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
												<option value="MISCELLANEOUS">MISCELLANEOUS</option>
											</select>
										</div> -->
										<div class="col-sm-4">
											<select class="form-control" name="rfq" id="rfq" required onchange="gets()">
											<option value="<?php echo $row["rfq"] ?>"><?php echo $row["rfq"] ?></option>
												<option value="ENGINEERING">ENGINEERING </option>
												<option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
												<option value="SUSTAINABILITY">SUSTAINABILITY</option>
												<option value="ACOUSTICS">ACOUSTICS</option>
												<option value="LASER SCANNING">LASER SCANNING</option>
												<option value="OIL & GAS">OIL & GAS</option>
											</select>
										</div>

										<label class="col-sm-2 col-form-label">Project Type</label>
										<!-- <div class="col-sm-4">
											<select class="form-control" name="division">
												<option value="<?php echo $row["division"] ?>"><?php echo $row["division"] ?></option>
												<option value="DEPUTATION">DEPUTATION</option>
												<option value="ENGINEERING SERVICES">ENGINEERING SERVICES</option>
												<option value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
												<option value="SIMULATION & ANALYSIS SERVICES">SIMULATION & ANALYSIS SERVICES</option>
												<option value="SUSTAINABILITY">SUSTAINABILITY</option>
											</select>
										</div> -->
										<div class="col-sm-4">
											<select class="form-control" name="division" id="div" required onchange="gets()">
												<?php
													if($sub_divition_name == "DEPUTATION"){
														$select_deputation = "selected";
													}else{
														$select_project = "selected";
													}
												?>
												<option value readonly>Select Division</option>
												<option value="DEPUTATION" <?php echo $select_deputation;?>>DEPUTATION</option>
												<option value="PROJECT" <?php echo $select_project;?>>PROJECT</option>
											</select>
										</div>

									</div>
									
									<div class="form-group row">

                                        <label class="col-sm-2 col-form-label">Enquiry Date</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="date" value="<?php echo $row["enqdate"] ?>" name="enqdate">
										</div>

                                    	<label class="col-sm-2 col-form-label">Project Name*</label>
										<div class="col-sm-3">
                                            <input class="form-control" value="<?php echo $row["name"] ?>" type="text" name="name">
										</div>
										<div class="col-sm-1">
											<input class="form-control" type="text" placeholder="abbr." name="paddr" value="<?php echo $pro_abbr;?>" required>
										</div>

									</div>
									
									<div class="form-group row">
									
										<label class="col-sm-2 col-form-label">Location</label>
										<div class="col-sm-4">
											<select class="form-control" name="location">
                                                <option value="<?php echo $row["location"] ?>"><?php echo $row["location"] ?></option>
												<!-- <option value="Qatar">Qatar</option>
												<option value="UAE">UAE</option>
												<option value="Canada">Canada</option>
												<option value="Singapore">Singapore</option>
												<option value="India">India</option> -->
												<option value="Saudi Arabia">Saudi Arabia</option>
											</select>
										</div>

										<label class="col-sm-2 col-form-label">Stage</label>
										<div class="col-sm-4">
											<select class="form-control" name="stage">
                                                <option value="<?php echo $row["stage"] ?>"><?php echo $row["stage"] ?></option>
												<option value="Tender">Tender</option>
												<option value="Job In Hand">Job In Hand</option>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row m-b20">
											<label class="col-sm-2 col-form-label">Scope</label>
											<div class="col-sm-4">
												<select name="scope" id="scopes" class="form-control" onclick="divi()">
													<option value="" selected value disabled> Select Division</option>
													<?php
														$sql10 = "SELECT * FROM scope_list WHERE divi='$division_name' AND sub_divi='$sub_divition_id'";
														$result10 = $conn->query($sql10);
														while($row10 = $result10->fetch_assoc())
														{
															$selected_scope = "";
															if($scope_id == $row10['id'])
															{
																$selected_scope = "selected";
															}
															?>
																<option value="<?php echo $row10['id'];?>" <?php echo $selected_scope;?>><?php echo $row10['scope'];?></option>
															<?php
														}
														if($scope_id == 0) 
														{
															?>
																<option value="others" selected>Others</option>
															<?php
														}
													?>
												</select>
											</div>
											<!--====================== Default Scope ===========================-->
											<?php 
												if($row['scope_type'] == 1){
													if($row['qstatus']== "SUBMITTED"){
											?>
											<label class="col-sm-2 col-form-label d_scope " id="d_scope_val_lab">Proposal Value</label>
											<div class="col-sm-4 d_scope" id="d_scope_val_input">
												<input class="form-control scope_value" value="<?php echo $row["price"] ?>" type="number" name="default_scope_proposal" id = "default_scope_proposal" onkeyup = "d_scope(<?php echo $gst_percentage; ?>)"> 
											</div>
											<label class="col-sm-2 col-form-label d_scope" style="margin-top:20px;" id="d_scope_sts_lab">VAT Status</label> 
											<div class="col-md-4" id="d_scope_sts_input" >
												<div class="radio d_scope " style="border:2px solid #ccc;margin-left:18px;padding-left:20px;margin-top:20px;margin-left:-1px;">
													<label  for="default_scope_inclusive" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
													<input type="radio" name="default_scope_gst_status" id="default_scope_inclusive" value="1" onclick="d_scope_inclu(<?php echo $gst_percentage;?>)" <?php if($row['gst_status']==1){echo "CHECKED";} ?>>
													<label for= "default_scope_exclusive"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
													<input type="radio" name="default_scope_gst_status" id="default_scope_exclusive" value="0" onclick="d_scope_exclu(<?php echo $gst_percentage;?>)" <?php if($row['gst_status']==0){echo "CHECKED";} ?>>
												</div>
											</div>
											<label class="col-sm-2 col-form-label d_scope " style="margin-top:20px;" id="d_scope_gst_lab">VAT Value</label>
											<div class="col-sm-4 d_scope" style="margin-top:20px;" id="d_scope_gst_input">
												<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;">
													<input class="form-control scope_gst_value" value="<?php echo $row["gst_value"] ?>" type="number" name="default_scope_gst_value" id="default_scope_gst_value" readonly>
												</div>
											</div>
											<?php
												}
											}
											?>
											<!--====================== Custom ==> to==> Default Scope ===========================-->
											<?php 
												if($row['scope_type'] == 0){
													if($row['qstatus']== "SUBMITTED"){
											?>
											<label class="col-sm-2 col-form-label c_scope" id="c_scope_val_lab" style="display:none">Proposal Value</label>
											<div class="col-sm-4 c_scope" id="c_scope_val_input" style="display:none">
												<input class="form-control scope_value" value="<?php echo $row["price"] ?>" type="number" name="default_scope_proposal" id="default_scope_proposal" placeholder="₹" onkeyup = "d_scope(<?php echo $gst_percentage; ?>)" >
											</div>
											<label class="col-sm-2 col-form-label c_scope" style="margin-top:20px;display:none;" id="c_scope_sts_lab" style="">VAT Status</label> 
											<div class="col-md-4" id="c_scope_sts_input" style="display:none">
												<div class="radio" style="border:2px solid #ccc;margin-left:18px;padding-left:20px;margin-top:20px;margin-left:-1px;">
													<label  for="default_scope_inclusive" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
													<input type="radio" name="default_scope_gst_status" id="default_scope_inclusive" value="1" onclick="d_scope_inclu(<?php echo $gst_percentage;?>)">
													<label for= "default_scope_exclusive"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
													<input type="radio" name="default_scope_gst_status" id="default_scope_exclusive" value="0" onclick="d_scope_exclu(<?php echo $gst_percentage;?>)">
												</div>
											</div>
											<label class="col-sm-2 col-form-label c_scope" style="margin-top:20px; display:none;display:none" id="c_scope_gst_lab" style="">VAT Value</label>
											<div class="col-sm-4 c_scope" style="margin-top:20px;display:none" id="c_scope_gst_input">
												<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;">
													<input class="form-control scope_gst_value" value="<?php echo $row["gst_value"] ?>" type="number" name="default_scope_gst_value" id="default_scope_gst_value" placeholder="₹" readonly >
												</div>
											</div>
											<?php
												}	
											}
											?>
										</div>
									</div>
									<?php if($scope_type == 1){ /*======= Default Scope  ======*/
												$s_id = $row["scope"];
												$sql_scope_default = "SELECT * FROM scope_list WHERE id= '$s_id'";
												$result_scope_default = $conn->query($sql_scope_default);
												$row_scope_default = $result_scope_default->fetch_assoc();
									?>
									<!-- <div class="form-group" id="default_scope">
										<div class="row m-b20">
										<?php 
												if($scope_type== 0)
												{
											?>
											<label class="col-sm-2 col-form-label">Scope Default</label>
											<div class="col-sm-4">
												<input class="form-control" value="<?php echo $row_scope_default["scope"] ?>" type="text" name="">
											</div>
											<?php 
												}
												if($row['qstatus']== "SUBMITTED")
												{
											?>
											<label class="col-sm-2 col-form-label">Proposal Value</label>
											<div class="col-sm-4">
												<input class="form-control" value="<?php echo $row["price"] ?>" type="number" name="default_scope_proposal" >
											</div>
											<label class="col-sm-2 col-form-label" style="margin-top:20px;">GST Status</label> 
											<div class="col-md-4" >
												<div class="radio" style="border:2px solid #ccc;margin-left:18px;padding-left:20px;margin-top:20px;margin-left:-1px;">
													<label  for="default_scope_inclusive" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
													<input type="radio" name="default_scope_gst_status" id="default_scope_inclusive" value="1" onclick="scope_inclu()">
													<label for= "default_scope_exclusive"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
													<input type="radio" name="default_scope_gst_status" id="default_scope_exclusive" value="0" onclick="scope_exclu()">
												</div>
											</div>
											<label class="col-sm-2 col-form-label" style="margin-top:20px;">GST Value read</label>
											<div class="col-sm-4" style="margin-top:20px;">
												<input class="form-control" value="<?php echo $row["gst_value"] ?>" type="number" name="default_scope_gst_value">
											</div>
											<?php
												}
											?>
										</div>
									</div> -->
									<?php
									}		
									?>
									<?php
										if($scope_type == 0)
										{
											?>
												<div class="form-group" id="duplicate">
												<?php

													$sql1 = "SELECT * FROM scope WHERE eid='$id' ORDER BY id DESC";
													$result1 = $conn->query($sql1);
													$i = 0;
													if($result1->num_rows > 0)  /* Scope Table Value Not NUll */
													{
														$count = $result1->num_rows;
														while($row1 = $result1->fetch_assoc())
														{
												?>
													<div class="row m-t10" id="duplicate<?php echo $i ?>">

														<label class="col-sm-2 col-form-label">Scope</label>
														<div class="col-sm-4">
															<input class="form-control" value="<?php echo $row1["scope"] ?>" type="text" name="o_scope[]">
														</div>
														<?php 
														if($row['qstatus']== "SUBMITTED")
														{
														?>
														<label class="col-sm-2 col-form-label ">Proposal Value</label>
														<div class="col-sm-4">
															<input class="form-control scope_value" value="<?php echo $row1["value"] ?>" type="number" name="o_scope_proposal[]" id="proposal_value<?php echo $i;?>" onkeyup="amount(<?php echo $i;?>,<?php echo $gst_percentage;?>)">
														</div>
														<label class="col-sm-2 col-form-label" style="margin-top:20px;" >VAT Status</label> 
															<div class="col-md-4 radio"  >
																	<?php
																	if($row1['gst_status']==1){
																		$inclu = "CHECKED";
																	}if($row1['gst_status']==0){
																		$exclu = "CHECKED";
																	}
																	?>
																<div class="" style="border:2px solid #ccc;padding-left:20px;margin-top:20px;margin-left:-1px;">
																	<label  for="o_scope_inclusive<?php echo $i; ?>" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
																	<input type="radio" name="o_scope_gst_status<?php echo $i; ?>" id="o_scope_inclusive<?php echo $i; ?>" value="1" onclick="scope_inclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php if($row1['gst_status']==1){echo "CHECKED";} ?>>
																	<label for= "o_scope_exclusive<?php echo $i; ?>"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
																	<input type="radio" name="o_scope_gst_status<?php echo $i; ?>" id="o_scope_exclusive<?php echo $i; ?>" value="0" onclick="scope_exclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php if($row1['gst_status']==0){echo "CHECKED";} ?>> 
																</div>
															</div>
														<label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Value</label>
														<div class="col-sm-4" style="margin-top:20px;">
															<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;" >
																<input class="form-control scope_gst_value" value="<?php echo $row1["gst_value"] ?>" type="number" name="o_scope_gst_value[]" id="GST_value<?php echo $i;?>" readonly>
															</div>
														</div>
														<?php
														}
														?>
														<div class="col-sm-12 text-right">
												<?php
														if($i == 0)
														{
													?>
														<button type="button" name="add" id="add" onclick="clicks()" class="btn btn-success">+</button>
													<?php
														}
														else
														{
													?>
														<button type="button" name="remove" class="btn btn-danger btn_remove" onclick="remove(this.id)" id="<?php echo $i ?>">X</button>
													<?php
														}
												?>
														</div>

													</div>

												<?php
														$i++;
														}
													}
													else
													{
												?>
														<div class="row">
														<!--========== if Scope table empty==============================================  -->
															<label class="col-sm-2 col-form-label">Scope</label>
															<div class="col-sm-4">
																<input class="form-control" value="<?php echo $row["scope"] ?>" type="text" name="o_scope[]">
															</div>
															<?php
																if($row['qstatus']== "SUBMITTED")
																{
															?>
															<label class="col-sm-2 col-form-label ">Proposal Value</label>
														<div class="col-sm-4">
															<input class="form-control scope_value" value="<?php echo $row1["value"] ?>" type="number" name="o_scope_proposal[]" id="proposal_value<?php echo $i;?>" onkeyup="amount(<?php echo $i;?>,<?php echo $gst_percentage;?>)">
														</div>
														<label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Status</label> 
														<div class="col-md-4 radio"  style="margin-top:20px;">
															<div class="" style="border:2px solid #ccc;padding-left:20px;margin-left:-1px;">
																<label  for="o_scope_inclusive<?php echo $i; ?>" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
																<input type="radio" name="o_scope_gst_status<?php echo $i; ?>" id="o_scope_inclusive<?php echo $i; ?>" value="1" onclick="scope_inclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php echo $inclu;?>>
																<label for= "o_scope_exclusive<?php echo $i; ?>"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
																<input type="radio" name="o_scope_gst_status<?php echo $i; ?>" id="o_scope_exclusive<?php echo $i; ?>" value="0"  onclick="scope_exclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php echo $exclu;?>>
															</div>
														</div>
														<label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Value</label>
														<div class="col-sm-4" style="margin-top:20px;">
															<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;" >
																<input class="form-control scope_gst_value" value="<?php echo $row1["gst_value"] ?>" type="number" name="o_scope_gst_value[]" id="GST_value<?php echo $i;?>" readonly>
															</div>
														</div>
														<?php
																}
														?>
															<div class="col-sm-12 text-right">
																<button type="button" name="add" id="add" onclick="clicks()" class="btn btn-success">+</button>
															</div>
														</div>
												<?php
													}
												?>

												</div>
											<?php
										}
									?>
										<!-- ==============change to name bcoz add new array============== -->
									<?php 
										if($row['scope_type'] ==1){
									?>
									<div class="form-group" id="duplicate" style="display:none">
										<div class="row m-b20">
											<label class="col-sm-2 col-form-label">Others</label>
											<div class="col-sm-4">
												<input class="form-control" type="text" name="o_scope[]">
											</div>
											<?php 
												if($row['qstatus']== "SUBMITTED")
												{
													$i = 0;
											?>
											<label class="col-sm-2 col-form-label">Proposal Value</label>
											<div class="col-sm-4">
												<input class="form-control scope_value" value="<?php echo $row1["scope"] ?>" type="number" name="o_scope_proposal[]" id="proposal_value<?php echo $i;?>" onkeyup="amount(<?php echo $i;?>,<?php echo $gst_percentage;?>)">
											</div>
											<label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Status</label>
											<div class="col-md-4 radio"  style="margin-top:20px;">
												<div class="" style="border:2px solid #ccc;padding-left:20px;margin-left:-1px;">
													<label  for="o_scope_inclusive<?php echo $i;?>" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
													<input type="radio" name="o_scope_gst_status0" id="o_scope_inclusive<?php echo $i;?>" value="1" onclick="scope_inclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php echo $inclu;?>>
													<label for= "o_scope_exclusive<?php echo $i;?>"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
													<input type="radio" name="o_scope_gst_status0" id="o_scope_exclusive<?php echo $i;?>" value="0" onclick="scope_exclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php echo $exclu;?>>
												</div>
											</div>
											<label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Value</label>
											<div class="col-sm-4" style="margin-top:20px;">
												<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;">
													<input class="form-control scope_gst_value" value="<?php echo $row1["scope"] ?>" type="number" name="o_scope_gst_value[]" id="GST_value<?php echo $i;?>" readonly>
												</div>	
											</div>
											<?php
												}
											?>
											<div class="col-sm-12 text-right">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
										</div>
									</div>


                                    <div class="form-group row">
										<label style="color: black;font-style:bold;font-size:20px" class="col-sm-3 col-form-label">Client Details</label>
									</div>
											<?php
										}
											?>
                                    <div class="form-group row">
									<label class="col-sm-2 col-form-label">Client Name</label>
										<div class="col-sm-3 course">
											<!-- <input class="form-control" value="<?php echo $row["cname"] ?>" type="text" name="cname"> -->
											<select class="form-control" name="cname" required>
												<option value selected Disabled>Select Client</option>
												<?php
													$sql6 = "SELECT * FROM main ORDER BY name ASC";
													$result6 = $conn->query($sql6);
													while($row6 = $result6->fetch_assoc())
													{
														$selected = "";
														if($row6['name'] == $row['cname'])
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
										<div class="col-sm-1">
											<input class="form-control" type="text" placeholder="abbr." name="cabre" value="<?php echo $client_abbr;?>" required>
										</div>
                                    </div>

									<div class="form-group row">
									<label class="col-sm-2 col-form-label">Responsibility</label>
										<div class="col-sm-4 course">
                                            <select class="form-control" name="responsibility">
                                                <option value="<?php echo $row["responsibility"] ?>"><?php echo $row["responsibility"] ?></option>
												<?php
													$responsibility_sql = "SELECT * FROM login WHERE responsibility = 1";
													$responsibility_result = $conn->query($responsibility_sql);
													while($responsibility_row = mysqli_fetch_array($responsibility_result)){
												?>
												<option value="<?php echo $responsibility_row['name'] ?>"><?php echo $responsibility_row['name'] ?></option>
												<?php			
													}
												?>
												<!-- <option value="NAGARAJAN NEHRUJI">NAGARAJAN NEHRUJI</option>
												<option value="VENKATESH">VENKATESH</option>
												<option value="NAVEEN KUMAR">NAVEEN KUMAR</option>
												<option value="VISWANATHAN">VISWANATHAN</option>
												<option value="BALAMURUGAN">BALAMURUGAN</option>
												<option value="SABIR">SABIR</option>
												<option value="AJMAL">AJMAL</option>
												<option value="BAZEETH AHAMED">BAZEETH AHAMED</option>
												<option value="KARTHIKEYAN">KARTHIKEYAN</option>
												<option value="GOPALAKRISHNAN">GOPALAKRISHNAN</option>
												<option value="MADHAN KUMAR">MADHAN KUMAR</option>
												<option value="SHEIKH ABDULLAH">SHEIKH ABDULLAH</option>
												<option value="RAMESH">RAMESH</option>
												<option value="VISHNUGOPAN">VISHNUGOPAN</option>
												<option value="VAISHALI LADOLE">VAISHALI LADOLE</option> -->
											</select>
											
										</div>

                                        <label class="col-sm-2 col-form-label">Quotation Status</label>
										<div class="col-sm-4">
											<select class="form-control" name="qstatus">
                                                <option value="<?php echo $row["qstatus"] ?>"><?php echo $row["qstatus"] ?></option>
												<option value="SUBMITTED">SUBMITTED</option>
												<option value="NOT SUBMITTED">NOT SUBMITTED</option>
												<option value="IN PROGRESS">IN PROGRESS</option>
												<option value="DROPPED">DROPPED</option>
											</select>
										</div>
										
									</div>

									<div class="form-group row">
										<!-- <label class="col-sm-2 col-form-label">Quotation Date by Client</label>
										<div class="col-sm-4">
											<input class="form-control" type="date" value="<?php echo $row["qdatec"] ?>" name="qdatec">
										</div> -->
													
										<label class="col-sm-2 col-form-label">Submission Date</label>
										<div class="col-sm-4">
											<input class="form-control" type="date" value="<?php echo $row["qdate"] ?>" name="qdate">
										</div>
										<?php 
										if($row['qstatus']== "SUBMITTED")
										{
										?>
										<!-- <label class="col-sm-2 col-form-label">Quotation</label>
										<div class="col-sm-4">
											<input class="form-control" type="text"  name="quotation" value="<?php echo $row["quotation"] ?>">
										</div> -->
										<?php
										}
										?>
									</div>

									<div class="form-group row">
										
										<label class="col-sm-2 col-form-label">Notes</label>
										<div class="col-sm-10">
                                            <textarea style="height:100px" class="form-control" name="notes"><?php echo $row["notes"] ?></textarea>
										</div>
									</div>
									<!--  -->
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
	<?php
		if($count == "")
		{
			$count = 0;
		}
	?>
<script>
	// var i = <?php echo $count ?>;
	// function clicks()
	// {
	// 	i++;
    //     $('#duplicate').append('<div class="row m-t10" id="duplicate'+i+'"><div class="col-sm-2"><label class="col-form-label">Scope</label></div><div class="col-sm-4"><input class="form-control" type="text" name="scope[]" required></div><div class="col-sm-2"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'" onclick="remove(this.id)">X</button></div></div>');
	// }
    // function remove(btn)
	// {
    //     $('#duplicate'+btn+'').remove();  
    // }
</script>
<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
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
	var i = <?php echo $count ?>;
	
	if(i==0){
		var j = 0;
	}else{
		var j = i-1;
	}
	
	$('#add').click(function(){
			i++;
			j++;
           $('#duplicate').append(
			   '<div class="form-group row" id="duplicate'+i+'"><div class="col-sm-2 col-form-label">Scope</div><div class="col-sm-4"><input class="form-control" type="text" name="o_scope[]"></div><?php if($qstatus == "SUBMITTED"){?><label class="col-sm-2 col-form-label">Proposal Value</label><div class="col-sm-4"><input class="form-control scope_value"  type="number" name="o_scope_proposal[]" id="proposal_value'+i+'" onkeyup="amount('+i+',<?php echo $gst_percentage;?>)"></div><label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Status</label><div class="col-md-4 radio"  style="margin-top:20px;"><div class="" style="border:2px solid #ccc;padding-left:20px;margin-left:-1px;"><label  for="o_scope_inclusive'+i+'" style="font-family: inherit; color:#495057;" class="col-form-label"> Inclusive </label>&nbsp<input type="radio" name="o_scope_gst_status'+j+'" id="o_scope_inclusive'+i+'" value="1" onclick="scope_inclu('+i+',<?php echo $gst_percentage;?>)">&nbsp<label for= "o_scope_exclusive'+i+'" style="font-family: inherit; color:#495057;" class="col-form-label"> Exclusive </label>&nbsp<input type="radio" name="o_scope_gst_status'+j+'" id="o_scope_exclusive'+i+'" value="0" onclick="scope_exclu('+i+',<?php echo $gst_percentage;?>)"></div></div><label class="col-sm-2 col-form-label" style="margin-top:20px;">VAT Value</label><div class="col-sm-4" style="margin-top:20px;"><div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;"><input class="form-control scope_gst_value" type="number" name="o_scope_gst_value[]" id="GST_value'+i+'" readonly></div></div><?php }?><div class="col-sm-12 text-right buttons_add"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div></div>');
			  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#duplicate'+button_id+'').remove();  
      }); 
	   
</script>
<script>
	function gets() 
	{
		var division = document.getElementById("rfq").value;
		var sub_divi = document.getElementById("div").value;

		if(division !="" && sub_divi !="") 
		{
			$.ajax({
				type: "POST",
				url: "assets/ajax/get-scope.php",
				data:{'division':division,'sub_divi':sub_divi},
				beforeSend: function() 
				{
					$("#scopes").addClass("loader");
				},
				success: function(data)
				{
					$("#scopes").html(data);  
					$("#scopes").removeClass("loader");
				}
			});
		}
		 $(".scope_value").val("");
		 $(".scope_gst_value").val("");
	}

	function divi()
	{
		var divi = document.getElementById("rfq").value;
		var sub_divi = document.getElementById("div").value;
		var others = document.getElementById("scopes").value;
		
		if(divi =="")
		{
			document.getElementById("rfq").style.border = "1px solid red";
		}
		if(sub_divi =="")
		{
			document.getElementById("div").style.border = "1px solid red";
		}
	}
</script>
<script>
	$(document).ready(function(){
		$("#scopes").change(function(){
			var scope = document.getElementById("scopes").value;   
			var scope_type = <?php echo $row['scope_type']; ?> 
			if(scope_type == 1){ /*=====Default to multiple===============*/
				if(scope == "others"){
					document.getElementById("duplicate").style.display = "block";
					document.getElementById("d_scope_val_lab").style.display = "none";
					document.getElementById("d_scope_val_input").style.display = "none";
					document.getElementById("d_scope_sts_lab").style.display = "none";
					document.getElementById("d_scope_sts_input").style.display = "none";
					document.getElementById("d_scope_gst_lab").style.display = "none";
					document.getElementById("d_scope_gst_input").style.display = "none";
				}else{
					document.getElementById("duplicate").style.display = "none";
					document.getElementById("d_scope_val_lab").style.display = "block";
					document.getElementById("d_scope_val_input").style.display = "block";
					document.getElementById("d_scope_sts_lab").style.display = "block";
					document.getElementById("d_scope_sts_input").style.display = "block";
					document.getElementById("d_scope_gst_lab").style.display = "block";
					document.getElementById("d_scope_gst_input").style.display = "block";
				}
			}
			if(scope_type == 0){ /*=====  Multiple to Default===========*/
				if(scope == "others"){
					document.getElementById("duplicate").style.display = "block";
					document.getElementById("c_scope_val_lab").style.display = "none";
					document.getElementById("c_scope_val_input").style.display = "none";
					document.getElementById("c_scope_sts_lab").style.display = "none";
					document.getElementById("c_scope_sts_input").style.display = "none";
					document.getElementById("c_scope_gst_lab").style.display = "none";
					document.getElementById("c_scope_gst_input").style.display = "none";
				}else{  
					document.getElementById("duplicate").style.display = "none";
					document.getElementById("c_scope_val_lab").style.display = "block";
					document.getElementById("c_scope_val_input").style.display = "block";
					document.getElementById("c_scope_sts_lab").style.display = "block";
					document.getElementById("c_scope_sts_input").style.display = "block";
					document.getElementById("c_scope_gst_lab").style.display = "block";
					document.getElementById("c_scope_gst_input").style.display = "block";
				}
			}
		});
	});
</script>
<!-- =========Single Scope GST Status=============== -->
<script> 
	function scope_inclu(){
		document.getElementById('scope_gst_value_input').style.display = 'block'; 
		document.getElementById('scope_gst_value_div').style.display = 'block';
	}
	function scope_exclu(){     
		document.getElementById('scope_gst_value_input').style.display = 'none';
		document.getElementById('scope_gst_value_div').style.display = 'none';
	}
</script>
<script> /* Multi scope Start */
	function amount(id,pers)
	{	
		var ids =  id; 
		var division = $("#rfq").val();
		$.ajax({
			type: "POST",
			url: "assets/ajax/get-gst_percentage.php",
			data:{'division':division},
			success: function(data)
			{
				var percentage = parseInt(data);
				
				if(document.getElementById("o_scope_inclusive"+ids).checked == true){
					var amounts = $("#proposal_value"+ids).val();
						// GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
						inclusive	 = amounts-(amounts*(100/(100+percentage)));  
						inclusive_gst = inclusive.toFixed(2);
						$("#GST_value"+ids).val(inclusive_gst);
				}
				if(document.getElementById("o_scope_exclusive"+ids).checked == true){
					var amounts = $("#proposal_value"+ids).val();
						// GST Amount = ( Original Cost * GST% ) / 100
						exclusive_gst = (amounts*percentage )/100;
						$("#GST_value"+ids).val(exclusive_gst);
				}
			}
		});
	}
	function scope_inclu(id,pers){
		var ids =  id;
		var division = $("#rfq").val();
		$.ajax({
			type: "POST",
			url: "assets/ajax/get-gst_percentage.php",
			data:{'division':division},
			success: function(data)
			{
				var percentage = parseInt(data);
				var amounts = $("#proposal_value"+ids).val();
				// GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
				inclusive	 = amounts-(amounts*(100/(100+percentage)));  
				inclusive_gst = inclusive.toFixed(2);
				$("#GST_value"+ids).val(inclusive_gst);
			}
		});
	}
	function scope_exclu(id,pers){
		var ids =  id; 
		var division = $("#rfq").val();
		$.ajax({
			type: "POST",
			url: "assets/ajax/get-gst_percentage.php",
			data:{'division':division},
			success: function(data)
			{
				var percentage = parseInt(data);
				var amounts = $("#proposal_value"+ids).val();
				// GST Amount = ( Original Cost * GST% ) / 100
				exclusive_gst = (amounts*percentage )/100;
				$("#GST_value"+ids).val(exclusive_gst);
			}
		});
	}
</script> <!-- /* Multi scope end */ -->
<!-- ================================================================================================================================ -->
<script>/* Default scope Start Proposal Value D*/ 
	function d_scope(pers)
	{
		var division = $("#rfq").val();
		$.ajax({
			type: "POST",
			url: "assets/ajax/get-gst_percentage.php",
			data:{'division':division},
			success: function(data)
			{
				var percentage = parseInt(data);
				if(document.getElementById("default_scope_inclusive").checked == true)
				{
					var amounts = $("#default_scope_proposal").val();
						// ========================GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )==================================
						inclusive	 = amounts-(amounts*(100/(100+percentage)));  
						inclusive_gst = inclusive.toFixed(2);
						$("#default_scope_gst_value").val(inclusive_gst);
				}
				if(document.getElementById("default_scope_exclusive").checked == true)
				{
					var amounts = $("#default_scope_proposal").val();
						//==========================GST Amount = ( Original Cost * GST% ) / 100========================================================
						exclusive_gst = (amounts*percentage )/100;
						$("#default_scope_gst_value").val(exclusive_gst);
				}
			}
		});
		
			
	}
	function d_scope_inclu(pers)
	{
		var division = $("#rfq").val();
		$.ajax({
			type: "POST",
			url: "assets/ajax/get-gst_percentage.php",
			data:{'division':division},
			success: function(data)
			{
				var percentage = parseInt(data);
				var amounts = $("#default_scope_proposal").val();
					inclusive	 = amounts-(amounts*(100/(100+percentage)));  
					inclusive_gst = inclusive.toFixed(2);
					$("#default_scope_gst_value").val(inclusive_gst);
			}
		});
	}
	function d_scope_exclu(pers)
	{
		var division = $("#rfq").val();
		$.ajax({
			type: "POST",
			url: "assets/ajax/get-gst_percentage.php",
			data:{'division':division},
			success: function(data)
			{
				var percentage = parseInt(data);
				var amounts = $("#default_scope_proposal").val();
					exclusive_gst = (amounts*percentage )/100;
					$("#default_scope_gst_value").val(exclusive_gst);
			}
		});
	}

</script> <!-- /* Default scope Start */ -->  
</body>
</html>
<!-- every thing ok -->
