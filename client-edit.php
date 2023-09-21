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
		$scope_type = $row["scope_type"]; 
		$division_name = $row["rfq"];

		$gst_percentage_sql = "SELECT * FROM division WHERE division = '$division_name'";
		$gst_percentage_result = $conn->query($gst_percentage_sql);
		$gst_percentage_row = mysqli_fetch_array($gst_percentage_result);
		$gst_percentage = $gst_percentage_row['gst_percentage'];
		if(isset($_POST['save']))
		{
			
			$ps = $_POST["pstatus"];
			$date = $_POST["qdate"];
			$re = $_POST["revision"];
			$notes = $_POST["notes"];
			$value = $_POST["price"];
			$quotation = $_POST["quotation"];
			$gst_value = $_POST["gst_value"];
			$default_scope_gst_status = $_POST['default_scope_gst_status'];
				
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
			// echo $re; exit();
			if($ps == "AWARDED")
			{
				$sql1 = "UPDATE enquiry SET pstatus='$ps',qdatec='$date' WHERE id='$id'";
			}
			else
			{
				if($ps == "LOST")
				{
					$sql1 = "UPDATE enquiry SET pstatus='$ps',notes='$notes',qdatec='$date' WHERE id='$id'";
					$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
					if($conn->query($sql8)==TRUE){
						header("location: client.php?msg=Status Updated!");
					}
				}
				else
				{
					// =============Revision======================//
					if($row['revision'] != $_POST["revision"]){
						$dateq = date('y-m-d');
						$quation_sql = "INSERT INTO quotation(rfqid, date, quotation, eid) VALUES('$rfqid', '$dateq', '$quotation', '$id')";
						$conn->query($quation_sql);
					}
					if($re == "" || $re == "0")
					{
						
						if($scope_type == 1){
							
						$sql1 = "UPDATE enquiry SET rfqid='$replace',pstatus='$ps',qdatec='$date',revision='$count',price='$value',gst_value ='$gst_value',gst_status ='$default_scope_gst_status', quotation = '$quotation' WHERE id='$id'";
						$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
						$conn->query($sql1);
							if($conn->query($sql8)==TRUE){
							header("location: client.php?msg=Status Updated!");
						}
						}else{
							$quotation_sql = "UPDATE enquiry SET revision='$count',quotation='$quotation' WHERE id='$id'";
							$conn->query($quotation_sql);

							$sql_scope = "SELECT * FROM scope WHERE eid = '$id'";
							$result_scope = $conn->query($sql_scope);
							$i = 0;
							while($row_scope = $result_scope->fetch_assoc()){
								$scope_id = $row_scope['id'];
								$val = $_POST['price'][$i];
								$gst_val = $_POST['gst_value'][$i];
								$o_scope_gst_status = $_POST['o_scope_gst_status'.$i];
								$sql1 = "UPDATE scope SET value='$val',gst_value ='$gst_val', gst_status = '$o_scope_gst_status' WHERE id='$scope_id'";
								$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
								$conn->query($sql1);
								$conn->query($sql8);
								$i++;
							}	
							header("location: client.php?msg=Status Updated!");
						}
						
					}
					else
					{
						if($scope_type == 1){
							$sql1 = "UPDATE enquiry SET rfqid='$replace',pstatus='$ps',qdatec='$date',revision='$count',price='$value',gst_value = '$gst_value',gst_status = '$default_scope_gst_status', quotation = '$quotation' WHERE id='$id'";
							$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
							$conn->query($sql1);
							if($conn->query($sql8)==TRUE){
								header("location: client.php?msg=Status Updated!");
							}
						}else{
							$quotation_sql = "UPDATE enquiry SET quotation='$quotation',revision='$count' WHERE id='$id'";
							$conn->query($quotation_sql);
							$sql_scope = "SELECT * FROM scope WHERE eid = '$id'";
							$result_scope = $conn->query($sql_scope);
							$i = 0;
							$j = 1;
							while($row_scope = $result_scope->fetch_assoc()){
								$scope_id = $row_scope['id'];
								$val = $_POST['price'][$i];
								$gst_val = $_POST['gst_value'][$i];
								$o_scope_gst_status = $_POST['o_scope_gst_status'.$j];
								$sql1 = "UPDATE scope SET value='$val',gst_value ='$gst_val',gst_status = '$o_scope_gst_status' WHERE id='$scope_id'";
								$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
								$conn->query($sql1);
								$conn->query($sql8);
								$i++;
								$j++;
						}
						header("location: client.php?msg=Status Updated!");	
					}
				}
			}
			// ===============Revision End=============//
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
						$sql2 = "INSERT INTO notes (rfqid,qdatec,notes) VALUES ('$rfqid','$date','$notes')";
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
			.follow{
				/* display: none; */
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
												<select class="form-control" name="pstatus" onchange="gets(this.value)" id="pstatus">
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
										<?php
										if($result4->num_rows == "0" OR $row4["revision"] == "") 
										{
											
											$testings = '0';
										} 
										else 
										{ 
											$testings = $row4["revision"];
										}
									?>
										<div class="form-group row"  id="revision" style="display:none;">
											<div class="col-sm-12">
												<div class="row">
													<div class="col-sm-2">		
														<label class="col-form-label">Revision</label>
													</div>
													<div class="col-sm-4">
														<select class="form-control" name="revision"> 
															<option  value="<?php echo $row4["revision"] ?>">Revision<?php echo $testings ?></option>
															<option value="1">Revision 1</option>
															<option value="2">Revision 2</option>
															<option value="3">Revision 3</option>
															<option value="4">Revision 4</option>
														</select>
													</div>
													<div class="col-sm-6"></div>
												</div>
											</div>
											
										</div>
										<div class="form-group row" id="scope_ststus" style="display:none;">	
										
											<?php
												if($scope_type == 1){ 
													$scope_value_sql = "SELECT * FROM enquiry WHERE id='$id'";
													$scope_value_result = $conn->query($scope_value_sql);
													$scope_value_row = $scope_value_result->fetch_assoc();
													$scope_id = $scope_value_row["scope"];

													$sql_scope_default = "SELECT * FROM scope_list WHERE id= '$scope_id'";
													$result_scope_default = $conn->query($sql_scope_default);
													$row_scope_default = $result_scope_default->fetch_assoc();
													$i = 0;
												?>
											<div class="col-sm-12">
												<div class="row">
													<label class="col-sm-2 col-form-label" style="margin-top:0px;">Scope Name</label>
													<div class="col-md-4 radio"  style="margin-top:0px;">
														<!-- <div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;"> -->
															<input type="text" class="form-control" value="<?php echo $row_scope_default['scope']; ?>" readonly>
														<!-- </div> -->
													</div>
													<div class="col-sm-2" >
														<label class="col-form-label">Value</label>
													</div>
													<div class="col-sm-4" >
														<input type="number" min='0' class="form-control" name="price" value="<?php echo $scope_value_row["price"] ?>" id = "scope_proposal<?php echo $i;?>" onkeyup = "scopes(<?php echo $i;?>,<?php echo $gst_percentage; ?>)" required=false >
													</div>
												</div>
											</div>
												
											<div class="col-sm-12" style="margin-top:10px;">
												<div class="row">
													<div class="col-sm-2">		
														<label class="col-form-label d_scope" id="d_scope_sts_lab">VAT Status</label> 
													</div>
														<?php
														if($scope_value_row['gst_status']==1){
															$inclu = "CHECKED";
														}if($scope_value_row['gst_status']==0){
															$exclu = "CHECKED";
														}
														?>
													<div class="col-md-4" id="d_scope_sts_input">
														<div class="radio d_scope " style="border:2px solid #ccc;margin-left:18px;padding-left:20px;margin-left:-1px;">
															<label  for="scope_inclusive<?php echo $i;?>" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
															<input type="radio" name="default_scope_gst_status" id="scope_inclusive<?php echo $i;?>" value="1" onclick="scope_inclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php echo $inclu; ?>>
															<label for= "scope_exclusive<?php echo $i;?>"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
															<input type="radio" name="default_scope_gst_status" id="scope_exclusive<?php echo $i;?>" value="0" onclick="scope_exclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php echo $exclu; ?>>
														</div>
													</div>
													<div class="col-sm-2">
														<label class="col-form-label"> VAT Value </label>
													</div>
													<div class="col-sm-4">
													<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;">
														<input type="number" min='0' class="form-control" name="gst_value" value="<?php echo $scope_value_row["gst_value"] ?>" id="scope_gst<?php echo $i;?>" required=false readonly>
													</div>
													</div>
												</div>
											</div>
											
											
											<?php
												}
												else
												{	
													$scope_value_sql1 = "SELECT * FROM scope WHERE eid='$id'";
													$scope_value_result1 = $conn->query($scope_value_sql1);
													
													$i=1;
														while($scope_value_row1 = $scope_value_result1->fetch_assoc()){
														
											?>
											
											<div class="col-sm-12" style="margin-top:10px;">
												<div class="row">
														<label class="col-sm-2 col-form-label follow " style="margin-top:0px;" id="follow1">Scope Name</label>
													<div class="col-md-4 radio follow"  style="margin-top:0px;" id="follow2">
														<!-- <div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;"> -->
														<input type="text" class="form-control" value="<?php echo $scope_value_row1['scope']; ?>" readonly>
														<!-- </div> -->
													</div>
													<div class="col-sm-2 follow" style="margin-top:0px;" id="follow3">
														<label class="col-form-label">Value</label>
													</div>
													<div class="col-sm-4 follow" style="margin-top:0px;" id="follow4">
														<input type="number" min='0' class="form-control" name="price[]" value="<?php echo $scope_value_row1["value"] ?>" id = "scope_proposal<?php echo $i;?>" onkeyup = "scopes(<?php echo $i;?>,<?php echo $gst_percentage; ?>)" required=false>
													</div>
												</div>
											</div>
											<div class="col-sm-12" style="margin-top:10px;">
												<div class="row">
													<label class="col-sm-2 col-form-label follow" style="margin-top:0px;" id="follow5">VAT Status</label>
													<div class="col-md-4 radio follow"  style="margin-top:0px;" id="follow6">
															
														<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;">
															<label  for="scope_inclusive<?php echo $i;?>" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
															<input type="radio" name="o_scope_gst_status<?php echo $i;?>" id="scope_inclusive<?php echo $i;?>" value="1" onclick="scope_inclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php if($scope_value_row1['gst_status']==1){echo "CHECKED";} ?>>
															<label for= "scope_exclusive<?php echo $i;?>"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
															<input type="radio" name="o_scope_gst_status<?php echo $i;?>" id="scope_exclusive<?php echo $i;?>" value="0" onclick="scope_exclu(<?php echo $i;?>,<?php echo $gst_percentage;?>)" <?php if($scope_value_row1['gst_status']==0){echo "CHECKED";} ?>>
														</div>
													</div>
													<div class="col-sm-2 follow" style="margin-top:0px;" id="follow7">
														<label class="col-form-label"> VAT Value</label>
													</div>
													<div class="col-sm-4 follow" style="margin-top:0px;" id="follow">
														<div class=""style="border:2px solid #ccc;padding-left:20px;margin-top:px;margin-left:-1px;height:38px;">
															<input type="number" min='0' class="form-control" name="gst_value[]" value="<?php echo $scope_value_row1["gst_value"] ?>" id="scope_gst<?php echo $i;?>" required=false readonly>
														</div>
													</div>
												</div>
											</div>
											<?php
											$i++;
												}
											}
											?>
										</div>
										<div class="form-group row" id="q_tation" style="display:none;">
											<div class="col-sm-12" style="margin-top:10px;">
												<div class="row">	
													<div class="col-sm-2" >
														<label class="col-form-label">Quotation</label>
													</div>
													<div class="col-sm-10" >
														<input type="text"  class="form-control" name="quotation" value="<?php echo $row["quotation"] ?>">
													</div>
												</div>
											</div>			
										</div>
										<div class="form-group row" id="notes" style="display:none;">
											<div class="col-sm-12" style="margin-top:10px;">
												<div class="row">
													<label class="col-sm-2  col-form-label">Notes</label>
													<div class="col-sm-10">
														<textarea name="notes" class="form-control"></textarea>
													</div>
												</div>
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
		$(document).ready(function(){
			var val = document.getElementById('pstatus').value;
			if(val == "FOLLOW UP")
			{
				document.getElementById('revision').style.display="block";   
				document.getElementById('scope_ststus').style.display="block";
				document.getElementById('q_tation').style.display="block";   
				document.getElementById('notes').style.display="block";
			}
			else if(val == "LOST")
			{
				document.getElementById('revision').style.display="none";   
				document.getElementById('scope_ststus').style.display="none";
				document.getElementById('q_tation').style.display="none";   
				document.getElementById('notes').style.display="block";
			}
			else
			{
				document.getElementById('revision').style.display="none";   
				document.getElementById('scope_ststus').style.display="none";
				document.getElementById('q_tation').style.display="none";   
				document.getElementById('notes').style.display="none";
			}
		});
		function gets(val) 
		{
			if(val == "FOLLOW UP")
			{
				document.getElementById('revision').style.display="block";   
				document.getElementById('scope_ststus').style.display="block";
				document.getElementById('q_tation').style.display="block";   
				document.getElementById('notes').style.display="block";
			}
			else if(val == "LOST")
			{
				document.getElementById('revision').style.display="none";   
				document.getElementById('scope_ststus').style.display="none";
				document.getElementById('q_tation').style.display="none";   
				document.getElementById('notes').style.display="block";
			}
			else
			{
				document.getElementById('revision').style.display="none";   
				document.getElementById('scope_ststus').style.display="none";
				document.getElementById('q_tation').style.display="none";   
				document.getElementById('notes').style.display="none";
			}
		}
	</script>
	<script>
		function scopes(id,pers) 
		{
			var ids = id;
			var percentage = pers;
			if(document.getElementById("scope_inclusive"+id).checked == true)
			{
				var amounts = $("#scope_proposal"+id).val();
					// ========================GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )==================================
					inclusive	 = amounts-(amounts*(100/(100+percentage)));  
					inclusive_gst = inclusive.toFixed(2);
					$("#scope_gst"+id).val(inclusive_gst);
			}
			if(document.getElementById("scope_exclusive"+id).checked == true)
			{
				var amounts = $("#scope_proposal"+id).val();
					//==========================GST Amount = ( Original Cost * GST% ) / 100========================================================
					exclusive_gst = (amounts*percentage)/100;
					$("#scope_gst"+id).val(exclusive_gst);
			}
		}
		function scope_inclu(id,pers)
		{
			var ids = id;
			var percentage = pers;
			var amounts = $("#scope_proposal"+id).val();
			// ========================GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )==================================
			inclusive	 = amounts-(amounts*(100/(100+percentage)));  
			inclusive_gst = inclusive.toFixed(2);
			$("#scope_gst"+id).val(inclusive_gst);
		}
		function scope_exclu(id,pers)
		{
			var ids = id;
			var percentage = pers;
			var amounts = $("#scope_proposal"+id).val();
			//==========================GST Amount = ( Original Cost * GST% ) / 100========================================================
			exclusive_gst = (amounts*percentage)/100;
			$("#scope_gst"+id).val(exclusive_gst);
			
		}
	</script>

	</body>
	</html>
