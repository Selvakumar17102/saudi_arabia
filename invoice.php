<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	$user=$_SESSION["username"];
	$id = $_REQUEST["id"];
	
	$testing = "TRUE";
    $sql1 = "SELECT * FROM project WHERE id='$id'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
	
	$eid = $row1["eid"];
	$proid = $row1["proid"];
	$totalvalue = $row1["value"];
	$total_gst_value = $row1["gst_value"];
	
    $sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();

	$rfqid = $row2["rfqid"];
	
	$sql3 = "SELECT * FROM invoice";
	$result3 = $conn->query($sql3);
	$tot = $result3->num_rows;

	$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;
	
	$sql4 = "SELECT sum(current) AS current,sum(demo) AS demo,sum(current_gst) AS current_gst,sum(demo_gst) AS demo_gst FROM invoice WHERE pid='$proid' AND paystatus!='0'";
	$result4 = $conn->query($sql4); 
	$row4 = $result4->fetch_assoc(); 
	if($row4["current"] == "") 
	{
		
		$sql4 = "SELECT sum(current) as current,sum(demo) AS demo,sum(current_gst) AS current_gst,sum(demo_gst) AS demo_gst FROM invoice WHERE rfqid='$rfqid' AND paystatus!='0'";
		$result4 = $conn->query($sql4); 
		$row4 = $result4->fetch_assoc();	
	}
	
	$totcurrent = $row4["current"];
	$totaldemo  = $row4["demo"];

	$totcurrent_gst = $row4["current_gst"];
	$totaldemo_gst  = $row4["demo_gst"];

	$rem = $totalvalue - $totaldemo;
	$rem_gst = $total_gst_value - $totaldemo_gst;


	if(isset($_POST["pay"]))
	{
		$term = $_POST["term"];      			/* Project terms */
		$total = $_POST["total"];     			/* Total value*/
		$total_gst = $_POST["total_gst"];     			/* Total gst*/
		$total_tds = ($total*10)/100;     			/* Total tds*/
		$invid = $_POST["invid"];     			/* Invoice Id*/
		$invdoc = $_POST["invdoc"];   			/* invidocumenty*/
		$current = $_POST["current"]; 			/* generate invoice amount */
		$current_gst = $_POST["current_gst"];   /* generate invoice gstamount */
		$po = $_POST["po"];			  			/* phone number */
		$month12 = $_POST["month"];   			/* month */
		$date = $_POST["date"];       			/* date*/
		
		$remk = $_POST["remk"];       			/* rewmarl*/
		$divi = $_POST["divi"];    				/* division*/
		$time = date('y-m-d H:i:s');  			/* */
		$sql9 = "SELECT * FROM invoice WHERE invid='$invid'";
		$result9 = $conn->query($sql9);
		if($result9->num_rows > 0)
		{
			echo '<script language="javascript">';
		    echo 'alert("Invoice Number Repeated!")';
		    echo '</script>';
		}
		else
		{
			if($row1["pterms"] == 2)
			{
				$month = date('m',strtotime($date));
				$year = date('Y',strtotime($date));

				$start = date($year.'-'.$month.'-01');
				$end = date($year.'-'.$month.'-t');

				if($current > $rem)
				{
					echo '<script language="javascript">';
					echo 'alert("Current Pay is greater than Remaining amount!")';
					echo '</script>';
				}
				else
				{
					$sql5 = "INSERT INTO invoice (invid,rfqid,pid,term,current,date,po,invdoc,month,demo,demo_gst,remrk,divi) VALUES ('$invid','$rfqid','$proid','$term','0','$date','$po','$invdoc','$month12','$current','$current_gst','$remk','$divi')";
					if($conn->query($sql5) === TRUE)
					{
						$sql11 = "SELECT * FROM invoice WHERE invid='$invid' LIMIT 1";
						$result11 = $conn->query($sql11);
						$row11 = $result11->fetch_assoc();
						$id11 = $row11["id"];
						$sql8 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime) VALUES ('$eid','$id','$id11','$user','4','1','$time')";
						$conn->query($sql8);
						header("location: invoice.php?id=$id&msg=Invoice Generated Successfully!");
					}else{
						header("location: invoice.php?id=$id&msg=Failed!");
					}
				}
			}
			else
			{
				if($row1["pterms"] == 1)
				{
					$pay = round($current/$total * 100,2);
					if($current > $rem)
					{
						echo '<script language="javascript">';
						echo 'alert("Current Pay is greater than Remaining amount!")';
						echo '</script>';
					}
					else
					{
						$sql5 = "INSERT INTO invoice (invid,rfqid,pid,term,current,percent,date,po,invdoc,demo,demo_gst,divi) VALUES ('$invid','$rfqid','$proid','$term',' ','$pay','$date','$po','$invdoc','$current','$current_gst','$divi')";
						if($conn->query($sql5) === TRUE)
						{
							$sql11 = "SELECT * FROM invoice WHERE invid='$invid' LIMIT 1";
							$result11 = $conn->query($sql11);
							$row11 = $result11->fetch_assoc();
							$id11 = $row11["id"];
							$sql8 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime) VALUES ('$eid','$id','$id11','$user','4','1','$time')";
							$conn->query($sql8);
							header("location: invoice.php?id=$id&msg=Invoice Generated Successfully!");
						}else{
							header("location: invoice.php?id=$id&msg=Failed!");
						}
					}
				}
				else
				{
					if($current > $rem)
					{
						echo '<script language="javascript">';
						echo 'alert("Current Pay is greater than Remaining amount!")';
						echo '</script>';
					}
					else
					{
						$sql5 = "INSERT INTO invoice (invid,rfqid,pid,term,current,date,po,invdoc,demo,demo_gst,month,divi) VALUES ('$invid','$rfqid','$proid','$term','0','$date','$po','$invdoc','$current','$current_gst','$month12','$divi')";
						if($conn->query($sql5) === TRUE)
						{
							$sql11 = "SELECT * FROM invoice WHERE invid='$invid' LIMIT 1";
							$result11 = $conn->query($sql11);
							$row11 = $result11->fetch_assoc();
							$id11 = $row11["id"];
							$sql8 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime) VALUES ('$eid','$id','$id11','$user','4','1','$time')";
							$conn->query($sql8);
							header("location: invoice.php?id=$id&msg=Invoice Generated Successfully!");
						}else{
							header("location: invoice.php?id=$id&msg=Failed!");
						}
					}
				}
			}
		}
	}
	$datestart = date('Y-m-01');
	$dateend = date('Y-m-t');

	$project = "";
	if($row1["pterms"] == 1)
	{
		$project = "Milestone";
	}
	if($row1["pterms"] == 2)
	{
		$project = "Monthly";
	}
	if($row1["pterms"] == 3)
	{
		$project = "Prorata";
	}

	$invval = $recval = 0;
	$inv_gst_val = $rec_gst_val = 0;

	$sql5 = "SELECT * FROM invoice WHERE pid='$proid'";
	$result5 = $conn->query($sql5);
	if($result5->num_rows > 0)
	{
		while($row5 = $result5->fetch_assoc())
		{
			$invval += $row5["demo"];
			$inv_gst_val += $row5["demo_gst"];

			if($row5["paystatus"] == 2)
			{
				$recval += $row5["current"];
				$rec_gst_val += $row5["current_gst"];
			}
		}
	}
	else
	{
		$sql5 = "SELECT * FROM invoice WHERE rfqid='$rfqid'";
		$result5 = $conn->query($sql5);
		while($row5 = $result5->fetch_assoc())
		{
			$invval += $row5["demo"];
			$inv_gst_val += $row5["demo_gst"];

			if($row5["paystatus"] == 2)
			{
				$recval += $row5["current"];
				$rec_gst_val += $row5["current_gst"];
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
	<meta name="description" content="Invoice | Project Management System" />

	<!-- OG -->
	<meta property="og:title" content="Invoice | Project Management System" />
	<meta property="og:description" content="Invoice | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice | Project Management System</title>

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

	<!-- DataTable ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">

	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		.w-100p
		{
			width: 100% !important;
		}
	</style>

	<script>
		function validate()
		{
			var x = document.getElementById("current").value;

			if(x == "")
			{
				$("#current").css("border", "1px solid red");
				$("#amount").css("border", "1px solid red");
				$("#gst_val").css("border", "1px solid red");
				// $("#tds_val").css("border", "1px solid red");
				return false;
			}
		}
	</script>

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
						<h4 class="breadcrumb-title"><?php echo $project ?> Projects</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>
			<p style="text-align:center;color:green;"><?php echo $_REQUEST['msg']; ?></p>
			<div class="row widget-box m-b30">
				<div class="card-header w-100p">
					<h4><?php echo $row2["name"] ?></h4>
				</div>
				<div class="col-12"><center><h5 style="margin-top:15px;" >Invoiced Value (exclusive VAT)</h5></center></div>
					<div class="col-sm-4 m-b10">
						<div class="widget-card widget-bg1">   
							<div class="wc-item">
								<span class="wc-stats">
									Total Invoiced Value <br>
									SAR <?php echo number_format($invval,2) ?>
								</span>

							</div>
						</div>
					</div>
					<div class="col-sm-4 m-b10">
						<div class="widget-card widget-bg2">
							<div class="wc-item">
								<span class="wc-stats">
									Total Recieved Value <br>
									SAR <?php echo number_format($recval,2) ?>
								</span>

							</div>
						</div>
					</div>
					<div class="col-sm-4 m-b10">   
						<div class="widget-card widget-bg3">
							<div class="wc-item">
								<span class="wc-stats">
								Total Outstanding Value <br>
								SAR <?php echo number_format($invval - $recval,2) ?>
								</span>

							</div>
						</div>
					</div>
					<div class="col-12"><center><h5 style="margin-top:15px;" >Invoiced VAT Value</h5></center></div>
					<div class="col-sm-12 m-b10">
						<div class="widget-card widget-bg4">
							<div class="wc-item">
								<div class="row">
									<div class="col-sm-4">
										<span class="wc-stats">
											Total Invoiced VAT Value <br>
											SAR <?php echo number_format($inv_gst_val,2) ?>
										</span>
									</div>
									<div class="col-sm-4">
										<span class="wc-stats">
											Total Recieved VAT Value <br>
											SAR <?php echo number_format($rec_gst_val,2) ?>
										</span>
									</div>
									<div class="col-sm-4">
										<span class="wc-stats">
											Total Outstanding VAT Value <br>
											SAR <?php echo number_format($inv_gst_val - $rec_gst_val,2) ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				
			</div>
		<div class="row m-b30">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
				<div class="card">
					<div class="card-header">
						<center><h4>Generate to Invoice</h4></center>
					</div>
						<div class="card-content">
							<div class="table-responsive col-lg-12">

								<!-- stsrt -->
								<form class="edit-profile" method="post" enctype="multipart/form-data">
									<div class="">
										<div class="form-group row">

											<label class="col-sm-2 col-form-label">Project Id</label>
											<input type="hidden" class="form-control" name="rfqid" value="<?php echo $rfqid ?>">
											<div class="col-sm-4">
												<input type="text" class="form-control" value="<?php echo $row1["proid"] ?>" readonly>
												<input type="hidden" class="form-control" name= "divi" value="<?php echo $row1["divi"] ?>" readonly>
											</div>
											
										<?php
											if($row1["pterms"] == 1 || $row1["pterms"] == 2)
											{
												$due = $row1["noofm"];
												$num = 0;

												$sql8 = "SELECT * FROM invoice WHERE pid='$proid' AND current='0'";
												$result8 = $conn->query($sql8);
												if($result8->num_rows > 0)
												{
													$sql8 = "SELECT * FROM invoice WHERE pid='$proid' AND current!='0'";
													$result8 = $conn->query($sql8);
													$num = $result8->num_rows;
												}
												else
												{
													$sql8 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
													$result8 = $conn->query($sql8);
													$num = $result8->num_rows;
												}
												$remain = $due - $num;
										?>

											<label class="col-sm-2 col-form-label">Pending Dues/Installments</label>
											<div style="margin-top:5px" class="col-sm-4">
												<input type="number" class="form-control" name="remaining" value="<?php echo $remain ?>" readonly>
											</div>

										<?php
											}
										?>

											<input type="hidden" name="term" value="<?php echo $row1["pterms"] ?>">

										</div>
											<!-- db stored value -->
										<div class="form-group row" style="margin-top:30px">

											<label class="col-sm-2 col-form-label">PO Value</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" value="SAR <?php echo number_format($totalvalue,2) ?>" readonly>
												<input type="hidden" name="total" value="<?php echo $totalvalue ?>">
											</div>
											<label class="col-sm-2 col-form-label">Yet To Invoice</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" value="SAR <?php echo number_format($rem,2) ?>" readonly>
												<input type="hidden" name="remaining" value="<?php echo $rem ?>">
											</div>

										</div>
												<!-- ==========GST VAlue============== -->
										<div class="form-group row" style="margin-top:30px">
											<label class="col-sm-2 col-form-label">VAT Value</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" value="SAR <?php echo number_format($total_gst_value,2) ?>" readonly>
												<input type="hidden" name="total_gst" value="<?php echo $total_gst_value ?>">
											</div>
											<label class="col-sm-2 col-form-label">Yet To Invoice VAT</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" value="SAR <?php echo number_format($rem_gst,2) ?>" readonly>
												<input type="hidden" name="remaining_gst" value="<?php echo $rem_gst ?>">
											</div>

											</div>	
										<?php
											if($rem <= 0)
											{
												echo '<div style="margin-top:20px" class="col-sm-12">';
												echo '<center><h4>Payment Finished for this Project</h4></center>';
												echo '</div>';
											}
											else
											{

												if($row1["pterms"] == 1)
												{
													$sql7 = "SELECT * FROM invoice WHERE pid='$proid' AND current='0'";
													$result7 = $conn->query($sql7);
													if($result7->num_rows > 0)
													{
														$sql7 = "SELECT * FROM invoice WHERE pid='$proid' AND current!='0'";
														$result7 = $conn->query($sql7);
														$number = $result7->num_rows;
													}
													else
													{
														$sql7 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
														$result7 = $conn->query($sql7);
														$number = $result7->num_rows;
													}
													if($number >= $row1["noofm"])
													{
														$testing = "FALSE";
													}
												}
												if($testing == "TRUE")
												{

										?>

										<div class="form-group row" style="margin-top:30px">
											
											<label class="col-sm-2 col-form-label">Invoice Ref. No</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="invid" required>
											</div>
											
											<label class="col-sm-2 col-form-label">PO Number</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="po" required value="<?php echo $row1["polink"] ?>">
											</div>
										
											</div>

										<div class="form-group row" style="margin-top:30px">

											<label class="col-sm-2 col-form-label">Invoice Link</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="invdoc">
											</div>
											<label class="col-sm-2 col-form-label">Remarks</label>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="remk">
											</div>

										</div>

										<div class="form-group row" style="margin-top:30px">
											<?php
												if($row1["pterms"] == 2)
												{
											?>
											<label class="col-sm-2 col-form-label">Invoice Date</label>
											<div class="col-sm-4">
												<input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>" required>
											</div>
											<label class="col-sm-2 col-form-label">Invoice Month</label>
											<div class="col-sm-4">
												<select class="form-control" name="month" required>
													<option value disabled selected>Select Month</option>
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
											</div>
											<?php
												}
												if($row1["pterms"] == 1 )
												{
											?>
												<label class="col-sm-2 col-form-label">Invoice Date</label>
												<div class="col-sm-4">
													<input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>">
												</div>
												<div class="col-sm-6"></div>
											<?php }
													if($row1["pterms"] == 3)
													{
											?>
														<label class="col-sm-2 col-form-label">Invoice Date</label>
														<div class="col-sm-4">
															<input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>">
														</div>
														<label class="col-sm-2 col-form-label">Payment Terms</label>
														<div class="col-sm-4">
															<input type="text" class="form-control" name="month">
														</div>
											<?php
													}
												
											?>
											<?php
												if($row1["pterms"] == 1)
												{
											?>
											
											<label class="col-sm-1 col-form-label" style="margin-top:30px;">Payment %</label>
											<div class="col-sm-2" style="margin-top:30px;">
												<input type="number" step="0.001" class="form-control" name="amount" id="current" onkeyup="minus()">
											</div>
											<label class="col-sm-1 col-form-label" style="margin-top:30px;">Invoice</label>
											<div class="col-sm-2" style="margin-top:30px;">
												<input type="number" step="0.001" min="0" class="form-control" name="current" id="amount" placeholder="Amount" onkeyup="amo()">
											</div>
											<label class="col-sm-1 col-form-label" style="margin-top:30px;">VAT Value</label>
											<div class="col-sm-2" style="margin-top:30px;">
												<div class="" style="border: 1px solid #ced4da;border-radius: 0.25rem;" >
													<input type="number" style="border:none"step="0.001" min="0" class="form-control" name="current_gst" id="amount_gst" placeholder="VAT Amount" onkeyup="gstamo()" readonly>
												</div>
											</div>
											<!-- <label class="col-sm-1 col-form-label" style="margin-top:30px;" >TDS Status</label> 
												<div class="col-md-2" style="margin-top:30px;" >
													<div class="radio d_scope " style="border: 1px solid #ced4da; border-radius: 0.25rem;margin-left:18px;padding-left:20px;margin-left:-1px; height:42px;">
														<label  for="tds_inclusive" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
														<input type="radio" name="tds_status" id="tds_inclusive" value="1">
														<label for= "tds_exclusive"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
														<input type="radio" name="tds_status" id="tds_exclusive" value="0">
													</div>
												</div> -->
											<?php
												}
												else
												{
											?>
											<label class="col-sm-1 col-form-label" style="margin-top:30px;">Payment %</label>
											<div class="col-sm-2" style="margin-top:30px;">
												<input type="number" step="0.001" class="form-control" name="amount" id="current" onkeyup="minus()">
											</div>
											<label class="col-sm-1 col-form-label" style="margin-top:30px;">Invoice</label>
											<div class="col-sm-2" style="margin-top:30px;">
												<input type="number" step="0.001" min="0" class="form-control" name="current" id="amount" placeholder="Amount" onkeyup="amo()">
											</div>
											<label class="col-sm-1 col-form-label" style="margin-top:30px;">VAT Value</label>
											<div class="col-sm-2" style="margin-top:30px;">
												<div class="" style="border: 1px solid #ced4da;border-radius: 0.25rem;" id="gst_val">
													<input type="number" style="border:none"step="0.001" min="0" class="form-control" name="current_gst" id="amount_gst" placeholder="GST Amount" onkeyup="gstamo()" readonly>
												</div>
											</div>
											<!-- <label class="col-sm-1 col-form-label" style="margin-top:30px;" >TDS Status</label> 
											<div class="col-md-2" style="margin-top:30px;" >
												<div class="radio d_scope " style="border: 1px solid #ced4da; border-radius: 0.25rem;margin-left:18px;padding-left:20px;margin-left:-1px; height:42px;" id="tds_val">
													<label  for="tds_inclusive" style="font-family: inherit; color:#495057;" class="col-form-label">Inclusive</label> 
													<input type="radio" name="tds_status" id="tds_inclusive" value="1">
													<label for= "tds_exclusive"  style="font-family: inherit; color:#495057;" class="col-form-label">Exclusive</label>
													<input type="radio" name="tds_status" id="tds_exclusive" value="0">
												</div>
											</div> -->
											<?php
												}
											?>
										</div>

										<div class="form-group row" style="margin-top:30px">
											<div class="col-sm-10"></div>
											<div class="col-sm-2">
												<input type="submit" value="Generate Invoice" name="pay" class="btn" onclick="return validate()" style="width: 100%;">
											</div>
										</div>

										<?php
											}
											else
											{
												if($row1["pterms"] == 1)
												{
													echo '<div style="margin-top:20px" class="col-sm-12">';
													echo '<center><h4>Dues finished for this Project</h4></center>';
													echo '</div>';
												}
											}
										}

										?>
										
									</div>
								</form>
								<!-- end -->
							</div>
						</div>
				</div>
			</div>
		</div>

			<div class="row m-b30">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    	<?php
							$sql7 = "SELECT * FROM invoice WHERE pid='$proid' AND demo!='0'";
							$result7 = $conn->query($sql7);
							if($result7->num_rows > 0)
							{
								$sql = "SELECT * FROM invoice WHERE pid='$proid' AND paystatus='0' AND demo!='0' ORDER BY date DESC";
							}
							else
							{
								$sql = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND paystatus='0' AND demo!='0' ORDER BY date DESC";
							}
							$result = $conn->query($sql);
							$row_t = $result7->fetch_assoc();
							$count = 1;
						?>
					<div class="card">
						<div class="card-header">
							<h4>List of Generated Invoices</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive col-lg-12">
								<table id="dataTableExample1" class="table table-striped">
									<thead>
										<tr>
											<th >S.NO</th>
											<th>Invoice Id</th>
											<th>PO Ref.</th>
											<th>Invoice Link</th>
											<th>Receiving  Copy</th>
											<th>Invoice Prepared Date</th>
											<th>Invoice Submitted Date</th>
												
											<?php
											if($row1["pterms"] == 2)
											{
												echo '<th>Payment for the Month</th>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<th>Payment %</th>';
											}
											if($row1["pterms"] == 3)
											{
												echo '<th>Payment Terms</th>';
											}
										?>
											<th>Invoiced Value <?php echo  $row1['tds_status'];?></th>
											<th>Invoiced VAT Value</th>
												<?php
														// if($user == "conserveadmin")
														// {
													?>
											<th>Last Updated</th>
											<?php
														// }
													?>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

						<?php
								while($row = $result->fetch_assoc())
								{
									$cid = $row["id"];

									if($row['receiving_status']=="" || $row['receiving_status']=="No")
									{
										$no = "selected";
									}else{
										$yes = "selected";
									}

									$sql6 = "SELECT * FROM mod_details WHERE inv_no='$cid' ORDER BY id DESC LIMIT 1";
									$result6 = $conn->query($sql6);
									$row6 = $result6->fetch_assoc();
                        ?>
                            			<tr>
                                    		<td><center><?php echo $count ?></center></td>
                                            <td><center><?php echo $row["invid"] ?></center></td>
											<td><center><?php echo $row["po"] ?></center></td>
											<td>
												<center>
													<input type="text" id="invoice_doc" class="form-control" value="<?php echo $row["invdoc"] ?>" style="width: 200px;" onkeyup="update_link(this.value, <?php echo $cid;?>)">
												</center>
											</td>

											<td>
												<center>
													<select id="receiving_copy" class="form-control" onchange="update(this.value, <?php echo $cid;?>)">
														<option value="" selected value disabled>Receiving Copy Status</option>
														<option value="Yes" <?php echo $yes;?>>Yes</option>
														<option value="No" <?php echo $no;?>>No</option>
													</select>
												</center>
											</td>

											<td><center><?php echo date('d-m-Y',strtotime($row["date"])) ?></center></td>
											
											<form action="invoice-submit.php?id=<?php echo $id ?>" method="post">
											<td><input type="date" name="sdate" class="form-control" value="<?php echo date('Y-m-d') ?>" required></td>
											
											<?php
											if($row1["pterms"] == 2)
											{
												echo '<td><center>'.$row["month"].'</center></td>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<td><center>'.$row["percent"].'%</center></td>';
											}
											if($row1["pterms"] == 3)
											{
												echo '<td><center>'.$row["month"].'</center></td>';
											}
										?>
											
												<input type="hidden" name="ids" value="<?php echo $row["id"] ?>">
												<?php
														// if($user == "conserveadmin")
														// {
													?>
												<td><center>SAR&nbsp<?php echo number_format($row["demo"],2) ?></center></td>										
												<td><center>SAR&nbsp<?php echo number_format($row["demo_gst"],2) ?></center></td>
												
												<td><center>
												<?php
													if($row6["user_id"] != "")
													{
														echo date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.$row6["user_id"]; 
													}
													else
													{
														echo "-";
													}
												?></center></td>
												<?php
														// }
													?>
												<td>
													<table class="action">
														<tr>
															<td>
																<button type="submit" class="btn-link" title="Next">
																	<span class="notification-icon dashbg-yellow">
																		<i style="margin-left:0px" class="fa fa-arrow-right" aria-hidden="true"></i>
																	</span>
																</button>
															</td>
															<td>
																<a href="delete-invoice.php?id=<?php echo $row["id"] ?>&mid=<?php echo $id ?>" title="Delete">
																	<span class="notification-icon dashbg-red" onClick="return confirm('Sure to Delete this Invoice!');">
																		<i class="fa fa-trash" aria-hidden="true"></i>
																	</span>
																</a>
															</td>
														</tr>
													</table>
												</td>
											</form>
                                        </tr>

                        <?php
                                    $count++;
								}
							
						?>
									</tbody>
                                </table>
                            </div>
                        </div>
						
                    </div>
                </div>		
			</div>
			<div class="row m-b30">
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    	<?php
							$sql7 = "SELECT * FROM invoice WHERE pid='$proid' AND current='0'";
							$result7 = $conn->query($sql7);
							if($result7->num_rows > 0)
							{
								$sqls = "SELECT * FROM invoice WHERE pid='$proid' AND paystatus='1' ORDER BY date DESC";
							}
							else
							{
								$sqls = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND paystatus='1' ORDER BY date DESC";
							}
							$results = $conn->query($sqls);
                            $counts = 1;
						?>
					<div class="card">
						<div class="card-header">
							<h4>List of Submitted Invoices</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive col-lg-12">
								<table id="dataTableExample2" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Invoice Id</th>
											<th>PO Ref.</th>										
											<th>Invoice Prepared Date</th>
											<th>Invoice Submitted Date</th>
											<th>Invoice Value</th>
											<th>Invoice VAT Value </th>
											<?php
											if($row1["pterms"] == 2)
											{
												echo '<th>Month</th>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<th>Payment %</th>';
											}
											if($row1["pterms"] == 3)
											{
												echo '<th>Payment Terms</th>';
											}
										?>
											<th>Payment Recieved Date</th>
											<th>Payment Mode</th>
											<th>Current Value</th>
											<th>Current VAT</th>
											<!-- <th>&nbsp&nbsp&nbsp<span>Current TDS</span>&nbsp&nbsp&nbsp</th> -->
											<th>Remarks</th>
											<th>Documents</th>
											<?php
														// if($user == "conserveadmin")
														// {
													?>
											<th>Last Updated</th>
											<?php
														// }
													?>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

						<?php
								while($rows = $results->fetch_assoc())
								{
									$cid = $row["id"];
									$total = $row['total'];

									$sql6 = "SELECT * FROM mod_details WHERE inv_no='$cid' ORDER BY id DESC LIMIT 1";
									$result6 = $conn->query($sql6);
									$row6 = $result6->fetch_assoc();
                        ?>
                            			<tr>
                                    		<td><center><?php echo $counts++ ?></center></td>
                                            <td><center><?php echo $rows["invid"] ?></center></td>
											<td><center><?php echo $rows["po"] ?></center></td>
											<td><center><?php echo date('d-m-Y',strtotime($rows["date"])) ?></center></td>
											<td><center><?php echo date('d-m-Y',strtotime($rows["subdate"])) ?></center></td>
											<td><center>SAR&nbsp<?php echo number_format($rows["demo"],2); ?></center></td>
											<td><center>SAR&nbsp<?php echo number_format($rows["demo_gst"],2);?></center></td>
										<?php
											if($row1["pterms"] == 2)
											{
												echo '<td><center>'.$rows["month"].'</center></td>';
											}
											if($row1["pterms"] == 3)
											{
												echo '<td><center>'.$rows["month"].'</center></td>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<td><center>'.$rows["percent"].'%</center></td>';
											}
										?>
											
											<form action="invoice-recieve.php?id=<?php echo $id ?>" method="post">
												<td><input type="date" style="width:150px" name="rdate" class="form-control" value="<?php echo date('Y-m-d') ?>" required></td>
												<?php 
													if($rows["mode"] == "Cheque"){
														echo $a = "selected";
													}
													if($rows["mode"] == "Online"){
														echo $b = "selected";
													}
													if($rows["mode"] == "Cash"){
														echo $c = "selected";
													}
												?>
												<td><select name="mode" style="width:100px" class="form-control">
													<option <?php echo $a; ?> value="Cheque">Cheque</option>
													<option <?php echo $b; ?> value="Online">Online</option>
													<option <?php echo $c; ?> value="Cash">Cash</option>
												</select></td>
												<td><input type="number" step="0.01" min="0" name="current" class="form-control" value="<?php echo $rows["current"] ?>" ></td>
												<td><input type="number" step="0.01" min="0" name="current_gst" class="form-control" value="<?php echo $rows["current_gst"] ?>" ></td>
												
												<?php 
												if($rows['tds_status']){
												?>
													<!-- <td><input type="number" step="0.01" min="0" name="current_tds" class="form-control" value="<?php echo $rows["current_tds"] ?>" ></td> -->
												<?php	
												}
												else{
												?>
													<!-- <td><center>NA</center></td> -->
												<?php
												}
												?>
												
												<td><textarea name="remarks" class="form-control"></textarea></td>
												<td><input type="text" name="docu" class="form-control"></td>
												<input type="hidden" name="ids" value="<?php echo $rows["id"] ?>">
												<?php
														// if($user == "conserveadmin")
														// {
													?>
												<td><center>
												<?php
													if($row6["user_id"] != "")
													{
														echo date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.$row6["user_id"]; 
													}
													else
													{
														echo "-";
													}
												?></center></td>
												<?php
														// }
													?>
												<td>
													<table class="action">
													<tr>
													<td>
													<button type="submit" class="btn-link" title="Next">
														<span class="notification-icon dashbg-yellow">
															<i style="margin-left:0px" class="fa fa-arrow-right" aria-hidden="true"></i>
														</span>
													</button>
													</td>
													<td>
													<a href="undo-submit.php?id=<?php echo $id.'&ids='.$rows["id"] ?>" class="btn-link" title="Undo">
														<span class="notification-icon dashbg-yellow">
															<i style="margin-left:0px" class="fa fa-undo" aria-hidden="true"></i>
														</span>
													</a>
													</td>
													</tr></table>
												</td>
											</form>
                                        </tr>

                        <?php
                                    $count++;
								}
							
						?>
									</tbody>
                                </table>
                            </div>
                        </div>
						
                    </div>
                </div>		
			</div>
			<div class="row m-b30">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					
                    	<?php
							$sql7 = "SELECT * FROM invoice WHERE pid='$proid' AND current='0'";
							$result7 = $conn->query($sql7);
							if($result7->num_rows > 0)
							{
								$sql = "SELECT * FROM invoice WHERE pid='$proid' AND paystatus='2' ORDER BY date DESC";
							}
							else
							{
								$sql = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND paystatus='2' ORDER BY date DESC";
							}
							$result = $conn->query($sql);
                            $count = 1;
                            
						?>
					<div class="card">
						<div class="card-header">
							<h4>List of Completed Invoices</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive col-lg-12">
								<table id="dataTableExample3" class="table table-striped">
									<thead>
										<tr>
											<th rowspan="2">S.NO</th>
											<th rowspan="2">Invoice Id</th>
											<th rowspan="2">PO Ref.</th>
										<?php
											if($row1["pterms"] == 2)
											{
												echo '<th rowspan="2">Month</th>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<th rowspan="2">Payment %</th>';
											}
											if($row1["pterms"] == 3)
											{
												echo '<th rowspan="2">Payment Terms</th>';
											}
										?>
											<th>Invoiced</th>	
											<th>Received</th>
											<!-- <th rowspan="2">Received TDS Value</th>	 -->
											<th rowspan="2">Invoice Submitted Date</th>											
											<th rowspan="2">Payment Recieved Date</th>
											<th rowspan="2">Payment Mode</th>
											<th rowspan="2">Remarks</th>
											<?php
														// if($user == "conserveadmin")
														// {
													?>
											<th rowspan="2">Last Updated</th>
											<?php
														// }
													?>
											<th rowspan="2">Action</th>
										</tr>
										<tr>
											<th><span>Value</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>VAT</span></th>  
											<th><span>Value</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>VAT</span></th>  
										</tr>
									</thead>
									<tbody>

						<?php
								while($row = $result->fetch_assoc())
								{
									$cid = $row["id"];

									$sql6 = "SELECT * FROM mod_details WHERE inv_no='$cid' ORDER BY id DESC LIMIT 1";
									$result6 = $conn->query($sql6);
									$row6 = $result6->fetch_assoc();
                        ?>
                            			<tr>
                                    		<td><center><?php echo $count ?></center></td>
                                            <td><center><a href="invoice-history.php?id=<?php echo $row['id'];?>"><?php echo $row["invid"] ?></a></center></td>
											<td><center><?php echo $row["po"] ?></center></td>
										<?php
											if($row1["pterms"] == 2 || $row1["pterms"] == 3)
											{
												echo '<td><center>'.$row["month"].'</center></td>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<td><center>'.$row["percent"].'%</center></td>';
											}
										?>
											<td><table style="margin-top:-7px;"><tr ><td style="border:none;">SAR&nbsp<?php echo number_format($row["demo"],2); ?></td><td  style="border:none;">SAR&nbsp<?php echo number_format($row["demo_gst"],2); ?></td></tr></table></td>
											<td><table style="margin-top:-7px;"><tr ><td style="border:none;">SAR&nbsp<?php echo number_format($row["current"],2);?></td><td  style="border:none;">SAR&nbsp<?php echo number_format($row["current_gst"],2); ?></td></tr></table></td>
											
											<!-- <td><center> -->
												<?php 
													if($row["tds_status"]== "1"){
														echo '₹'.number_format($row["current_tds"],2);
													}
													if($row["tds_status"]== "0"){
														echo "NA";
													}
												// ?>
												<!-- </center></td> -->
                                            <td><center><?php echo date('d-m-Y',strtotime($row["subdate"])) ?></center></td>
											<td><center><?php echo date('d-m-Y',strtotime($row["recdate"])) ?></center></td>
											<td><center><?php echo $row["mode"] ?></center></td>
											<td><center><?php echo $row["remarks"] ?></center></td>
											<?php
														// if($user == "conserveadmin")
														// {
													?>
											<td><center>
												<?php
													if($row6["user_id"] != "")
													{
														echo date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.$row6["user_id"]; 
													}
													else
													{
														echo "-";
													}
												?>
											</center></td>
											<?php
														// }
													?>
											<td>
												<a href="undo-submit.php?idm=1&id=<?php echo $id.'&ids='.$row["id"] ?>" class="btn-link" title="Undo">
													<span class="notification-icon dashbg-yellow">
														<i style="margin-left:0px" class="fa fa-undo" aria-hidden="true"></i>
													</span>
												</a>
											</td>
                                        </tr>

                        <?php
                                    $count++;
								}
							
						?>
									</tbody>
                                </table>
                            </div>
                        </div>
						
                    </div>
                </div>		
			</div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
	// alert("saudi");
// Start of jquery datatable
// alert("saudi")
	$('#dataTableExample1').DataTable({
		dom: 'Bfrtip',
		lengthMenu: [
			[ 15, 50, 100, -1 ],
			[ '15 rows', '50 rows', '100 rows', 'Show all' ]
		],
		buttons: [
			'pageLength','excel','print'
		]
	});
	$('#dataTableExample2').DataTable({
		dom: 'Bfrtip',
		lengthMenu: [
			[ 15, 50, 100, -1 ],
			[ '15 rows', '50 rows', '100 rows', 'Show all' ]
		],
		buttons: [
			'pageLength','excel','print'
		]
	});
	$('#dataTableExample3').DataTable({
		dom: 'Bfrtip',
		lengthMenu: [
			[ 15, 50, 100, -1 ],
			[ '15 rows', '50 rows', '100 rows', 'Show all' ]
		],
		buttons: [
			'pageLength','excel','print'
		]
	});
	$('#dataTableExample4').DataTable({
		dom: 'Bfrtip',
		lengthMenu: [
			[ 15, 50, 100, -1 ],
			[ '15 rows', '50 rows', '100 rows', 'Show all' ]
		],
		buttons: [
			'pageLength','excel','print'
		]
	});
</script>
<script>
	function minus()  /* Payment % */
	{
		var txt1  = document.getElementById('current').value;

		var total 			= <?php echo $totalvalue ?>;
		var total_gst_value = <?php echo $total_gst_value ?>;

		var rems  = txt1/100 * total;
		var gst_rems  = txt1/100 * total_gst_value;
		if (!isNaN(rems))
		{
			var rems1 = rems.toFixed(2);
			document.getElementById('amount').value = rems1;
		}
		if (!isNaN(rems))
		{
			var gst_rems1 = gst_rems.toFixed(2);
			document.getElementById('amount_gst').value = gst_rems1;
		}
	}
	function amo()
	{
		var amount = document.getElementById('amount').value;
		var total = <?php echo $totalvalue ?>;
		var total_gst_value = <?php echo $total_gst_value ?>;
		var ads = amount/total * 100;
		if (!isNaN(ads))
		{
			var ads1 = ads.toFixed(2);
			document.getElementById('current').value = ads1;
			var gst = ads/100 *total_gst_value;
			var gst1 = gst.toFixed(2);
			document.getElementById('amount_gst').value = gst1;
		}
	}
	function update(status, id)
	{
		$.ajax({
            type: "POST",
            url: "assets/ajax/receiving_status.php",
            data:{'status':status, 'id':id},
            success: function(data)
            {
                console.log(data);
            }
        });
	}
	function update_link(link, id)
	{
		$.ajax({
            type: "POST",
            url: "assets/ajax/receiving_status.php",
            data:{'link':link, 'id':id},
            success: function(data)
            {
                console.log(data);
            }
        });
	}
</script>

</body>
</html>