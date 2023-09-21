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
	$scope_id = $row['scope'];
	$scope_type = $row['scope_type'];

	$division_gst = $row['rfq'];
	$gst_percentage_sql = "SELECT * FROM division WHERE division = '$division_gst'";
	$gst_percentage_result = $conn->query($gst_percentage_sql);
	$gst_percentage_row = mysqli_fetch_array($gst_percentage_result);
	$gst_percentage = $gst_percentage_row['gst_percentage'];

    if(isset($_POST['save']))
    {
        $ps = $_POST["qstatus"]; 
		$date = $_POST["qdate"];
		$notes = $_POST["notes"];
		$time = date('y-m-d H:i:s');
		$dateq = date('y-m-d');
		$quotation = $_POST["quotation"];

		if($ps == "SUBMITTED")
		{
			$foll = "FOLLOW UP"; 
				$quation_sql = "INSERT INTO quotation(rfqid, date, quotation, eid) VALUES('$rfqid', '$dateq', '$quotation', '$id')";
				$conn->query($quation_sql);
					
			if($scope_type == 1)
			{
				$pv = $_POST["pv"][0];
				$gst_status = $_POST['gst_status1'];
				$gst_value =  $_POST['gst_value'][0];
				$sql1 = "UPDATE enquiry SET qstatus='$ps',sub_date='$date',pstatus='$foll',scope_value='$pv',price='$pv',gst_status = '$gst_status', gst_value = '$gst_value',quotation = '$quotation' WHERE id='$id'";
				if($conn->query($sql1) === TRUE)
				{
					$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
					$conn->query($sql8);	
					header("location: client.php?msg=Revision updated And Enquiry moved to Proposal Followup!");
				}
			}else{
				$quotation_sql1 = "UPDATE enquiry SET quotation='$quotation'  WHERE id='$id'";
				$quotation_result = $conn->query($quotation_sql1);
				$sql = "SELECT * FROM scope WHERE eid='$id'";
								
				$result = $conn->query($sql);
				
				if($result->num_rows > 0) // multiple scope
				{
					$i = 0;
					
					while($row = $result->fetch_assoc())
					{
						$sid 		= $row["id"];
						$pv 		= $_POST["pv"][$i];
						$con=$i+1;
						$gst_status = $_POST['gst_status'.$con];
						$gst_value 	= $_POST["gst_value"][$i];
						

						if($gst_value == 0){
							$gst_value = "";
						}

						$sql2 = "UPDATE scope SET  value ='$pv',gst_status= '$gst_status', gst_value = '$gst_value' WHERE id='$sid'";

						if($conn->query($sql2) === TRUE)
						{
							$sql1 = "UPDATE enquiry SET qstatus='$ps',sub_date='$date',pstatus='$foll',scope_value='$pv',price='$pv' WHERE id='$id'";
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
					// single scope
					$pv = $_POST["pv"]; 
					$gst_status = $_POST["gst_status"][0]; 
					$gst_value =  $_POST["gst_value"];
					$check = $_POST["check"][0];
					if($check == "")
					{
						$check = 0;
					}

					$sql1 = "UPDATE enquiry SET qstatus='$ps',sub_date='$date',price='$pv',pstatus='$foll', gst_status = '$gst_status', gst_value= '$gst_value' , quotation = '$quotation' WHERE id='$id'";
					
					if($conn->query($sql1) == TRUE)
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
		.quotation{
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
										<div class="col-sm-2">
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

										<label class="col-sm-2 col-form-label right quotation" id="quotation" >Quotation</label>
										<div class="col-sm-2 quotation" id="quotation">
											<input type="text" name="quotation" value="<?php ?>" class="form-control" placeholder = "Quotation">
										</div>
										
									</div>
									
									<div class="form-group de" style="padding-top:30px;">
										<?php
											if($scope_type == 0)
											{
												$sql1 = "SELECT * FROM scope WHERE eid='$id'";
											}else{
												$sql1 = "SELECT * FROM scope_list WHERE id='$scope_id'";
											}
											$result1 = $conn->query($sql1);
											if($result1->num_rows > 0)
											{
												
												$i = 0;
												while($row1 = $result1->fetch_assoc())
												{
													$i += 1;
													// multiple scope
											?>
												<div>
													<div class="row m-b10">
														<div class="col-md-3">
															<div class="row">
																<div class="col-md-4">
																	<label class="col-form-label">Scope</label>
																</div>
																<div class="col-md-8 form-control" >
																		<?php echo $row1["scope"] ?>
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="row">
																<div class="col-md-4">
																	<label class="col-form-label">VAT Status </label> 
																</div>
																	<div class="col-md-8" style="border:2px solid #ccc;pading: 10px; width:10px;">
																		<div class="radio" style="pading-left:px;">
																		<label  for="inclusive<?php echo $i;?>" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
																		<input type="radio" name="gst_status<?php echo $i;?>" id="inclusive<?php echo $i;?>" value="1" onclick="multiple_inclu1(<?php echo $i;?>,<?php echo $gst_percentage;?>)">
																		<label for= "exclusive<?php echo $i;?>"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
																		<input type="radio" name="gst_status<?php echo $i;?>" id="exclusive<?php echo $i;?>" value="0" onclick="multiple_exclu1(<?php echo $i;?>,<?php echo $gst_percentage;?>)">
																	</div>
																</div>
															</div>
														</div>
														<div class="col-md-3">
															<div class="row">
																<div class="col-md-4">
																	<label class="col-form-label">Value</label>
																</div>
																<div class="col-md-8">
																	<input type="number" name="pv[]" id="proval<?php echo $i;?>" onkeyup="amount(<?php echo $i;?>,<?php echo $gst_percentage;?>)" class="form-control" placeholder="SAR">
																</div>
															</div>
														</div>
														<div class="col-md-3" id="gst_value_div<?php echo $i; ?>">
															 <div class="row" style="">
																<div class="col-md-4">
																	<label class="col-form-label">VAT Value</label> 	
																</div>
																<div class="col-md-8" style="border:2px solid #ccc;padding:px; width:10px;">
																	<input type="number" name="gst_value[]" id="gst_value<?php echo $i;?>" class="form-control" value="" placeholder="SAR" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php
												}
											}
											else
											{
											
												
										?>
											<div style="padding:10px;">
												<div class="row">
													<div class="col-md-3">
														<div class="row">
															<div class="col-md-4">
																<label class="col-form-label">Scope</label>
															</div>
															<div class="col-md-8 form-control">
																<?php echo $row1["scope"] ?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="row">
															<div class="col-md-4">
																<label class="col-form-label">Value</label>
															</div>
															<div class="col-md-8">
																<input type="number" name="pv" id="pv" class="form-control" placeholder="SAR">
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="row">
															<div class="col-md-4">
																	<label class="col-form-label">VAT Status s</label> 
																</div>
																	<div class="col-md-8" style="border:2px solid #ccc;pading: 10px; width:10px;">
																		<div class="radio" style="pading-left:px;">
																		<label  for="inclusive" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
																		<input type="radio" name="gst_status" id="inclusive" value="1" onclick="inclu_gst()">
																		<label for= "exclusive"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
																		<input type="radio" name="gst_status" id="exclusive" value="0" onclick="exclu_gst()"> 
																	</div>
																</div>
														</div>
													</div>
													<div class="col-md-3" id="inclusive_gst">
														<div class="row" >
															<div class="col-md-4">
																<label class="col-form-label">VAT Value</label>
															</div>
															<div class="col-md-8">
															<input type="number" name="gst_value" id="gst_value" class="form-control" placeholder="SAR">
															</div>
														</div>
													</div>
												</div>
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
												<input type="submit" name="save" onclick="return validate()" class="btn" value="Update">
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
		var status = document.getElementById("qstatus").value;
		if(status == "SUBMITTED")
		{
			document.getElementsByClassName('de')[0].style.display = 'block';
			document.getElementsByClassName('des')[0].style.display = 'none';
			document.getElementsByClassName('des')[1].style.display = 'none';
			document.getElementsByClassName('quotation')[0].style.display = 'block';
			document.getElementsByClassName('quotation')[1].style.display = 'block';
		}
	});
	function gets(val)
	{
		if(val == "SUBMITTED")
		{
			document.getElementsByClassName('de')[0].style.display = 'block';
			document.getElementsByClassName('des')[0].style.display = 'none';
			document.getElementsByClassName('des')[1].style.display = 'none';
			document.getElementsByClassName('quotation')[0].style.display = 'block';
			document.getElementsByClassName('quotation')[1].style.display = 'block';
		}
		else
		{
			if(val == "DROPPED")
			{
				document.getElementsByClassName('des')[0].style.display = 'block';
				document.getElementsByClassName('des')[1].style.display = 'block';
				document.getElementsByClassName('de')[0].style.display = 'none';
				document.getElementsByClassName('quotation')[0].style.display = 'none';
				document.getElementsByClassName('quotation')[1].style.display = 'none';
			}
			else
			{
				document.getElementsByClassName('de')[0].style.display = 'none';
				document.getElementsByClassName('des')[0].style.display = 'none';
				document.getElementsByClassName('des')[1].style.display = 'none';
				document.getElementsByClassName('quotation')[0].style.display = 'none';
				document.getElementsByClassName('quotation')[1].style.display = 'none';
			}
		}
	}
	
</script>
<script>
	function amount(id,per){
		var ids =  id;
		var percentage = per;
		
			if(document.getElementById("inclusive"+ids).checked == true){
				var amounts = $("#proval"+ids).val();
					// GST Amount = Original Cost – (Original Cost * (100 / (100 + GST% ) ) )
					inclusive	 = amounts-(amounts*(100/(100+percentage)));  
					inclusive_gst = inclusive.toFixed(2);
					$("#gst_value"+ids).val(inclusive_gst);
				
			}
			else if(document.getElementById("exclusive"+ids).checked == true){
				var amounts = $("#proval"+ids).val();
					// GST Amount = ( Original Cost * GST% ) / 100
					exclusive_gst = (amounts*percentage )/100;
					$("#gst_value"+ids).val(exclusive_gst);
				
			}
			else{
				alert("First you select GST status..!!!");
				$("#proval"+ids).val("");
			}	
	}
	function multiple_inclu1(id,per)
	{
		var ids =  id;
		var percentage = per;
		var amounts = $("#proval"+ids).val();
		inclusive	 = amounts-(amounts*(100/(100+percentage)));  
		inclusive_gst = inclusive.toFixed(2);
		$("#gst_value"+ids).val(inclusive_gst);
	}
	function multiple_exclu1(id,per)
	{
		var ids =  id;
		var percentage = per;
		var amounts = $("#proval"+ids).val();
		// GST Amount = ( Original Cost * GST% ) / 100
		exclusive_gst = (amounts*percentage )/100;
		$("#gst_value"+ids).val(exclusive_gst);
	}
</script>
</body>
</html>
