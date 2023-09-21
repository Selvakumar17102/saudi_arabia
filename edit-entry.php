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

	$rfqid = $row['rfqid'];

	$sql3 = "SELECT * FROM enquiry WHERE rfqid='$rfqid'";
	$result3 = $conn->query($sql3);
    $row3 = $result3->fetch_assoc();
	
	$eid = $row3['id'];

	$sql4 = "SELECT * FROM project WHERE eid='$eid'";
	$result4 = $conn->query($sql4);
	$row4 = $result4->fetch_assoc();

	$pid = $row4['proid'];

    if(isset($_POST["save"]))
    {
        $demo = $_POST["demo"];
		$demo_gst = $_POST["demo_gst"];
		$demo_tds = $_POST["demo_tds"];
		$month = $_POST["month"];
		$inv = $_POST["inv"];
		$bank = $_POST["bank"];
		$invoice_no = $_POST['invoice_no'];
		$invoice_date = $_POST['invoice_date'];
		$po_number = $_POST['po_number'];
		$sub_date = $_POST['sub_date'];
		$received_amt = $_POST['received_amt'];
		$received_gts_amt = $_POST['received_gts_amt'];
		$received_tds_amt = $_POST['received_tds_amt'];
		$received_date = $_POST['received_date'];
		$remark = $_POST['remark'];
		$time = date('y-m-d H:i:s');
		if($received_amt == ""){
			$received_amt = 0;
		}
		if($received_gts_amt == ""){
			$received_gts_amt = 0;
		}
		if($received_tds_amt == ""){
			$received_tds_amt = 0;
		}
		
		if($row["term"] == 2)
		{
			if($received_date !="" && $sub_date !=""){
				$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',month='$month',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',recdate='$received_date',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt',subdate='$sub_date' WHERE id='$id'";
			}else{

				if($sub_date == "" && $received_date == ""){
					$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',month='$month',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt' WHERE id='$id'";
				}else{
					if($sub_date !=""){
						$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',month='$month',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt',subdate='$sub_date' WHERE id='$id'";
					}
					
					if($received_date !=""){
						$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',month='$month',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',recdate='$received_date',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt' WHERE id='$id'";
					}
				}
				
			}
		}
		else
		{
			if($received_date !="" && $sub_date !=""){
				$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',recdate='$received_date',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt',subdate='$sub_date' WHERE id='$id'";
			}else{
				if($sub_date == "" && $received_date == ""){
					$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt' WHERE id='$id'";
				}else{
					if($sub_date !=""){
						$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt',subdate='$sub_date' WHERE id='$id'";
					}
					if($received_date !=""){
						$sql1 = "UPDATE invoice SET demo='$demo',demo_gst='$demo_gst',demo_tds='$demo_tds',invdoc='$inv',pid='$pid',bank='$bank',invid='$invoice_no',date='$invoice_date',po='$po_number',remarks='$remark',current='$received_amt',current_gst='$received_gts_amt',current_tds='$received_tds_amt',recdate='$received_date' WHERE id='$id'";
					}
				}
				
			}
		}
        if($conn->query($sql1) === TRUE)
        {
			
			$sql2 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime) VALUES ('$eid','$proid','$id','$user','4','2','$time')";
			if($conn->query($sql2) === TRUE)
			{
				header("Location:edit-entry.php?id=$id&enq=".$_REQUEST['enq']."&msg=Invoice Updated!");
			}
        }else{
			header("Location: statement-main.php?id=$enq&msg=$sql1");
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
						<!-- <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a> -->
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

										
										<label class="col-sm-2 col-form-label">Invoice NO</label>
										<div class="col-sm-4">
                                            <input type="text" name="invoice_no" class="form-control" value="<?php echo $row["invid"] ?>">
										</div>
										<label class="col-sm-2 col-form-label">Invoice Value</label>
										<div class="col-sm-4">
                                            <input type="text" min="0" name="demo" class="form-control" value="<?php echo $row["demo"] ?>">
										</div>
										<label class="col-sm-2 col-form-label" style="margin-top:20px;">Invoice VAT Value</label>
										<div class="col-sm-4" style="margin-top:20px;">
                                            <input type="text" min="0" name="demo_gst" class="form-control" value="<?php echo $row["demo_gst"] ?>">
										</div>
										<label class="col-sm-2 col-form-label" style="margin-top:20px;"></label>
										<div class="col-sm-4" style="margin-top:20px;">
                                            <!-- <input type="text" min="0" name="demo_tds" class="form-control" value="<?php echo $row["demo_tds"] ?>"> -->
										</div>
									<?php
										if($row["term"] == 2)
										{
									?>
										<label class="col-sm-2 col-form-label" style="margin-top:20px;">Month</label>
										<div class="col-sm-4" style="margin-top:20px;">

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
									<div class="row">
										<label class="col-sm-2 col-form-label">Invoice Date</label>
										<div class="col-sm-4">
											<input type="date" name="invoice_date" id="invoice_date" class="form-control" value="<?php echo $row['date'];?>">
										</div>
										<label class="col-sm-2 col-form-label">PO Number</label>
										<div class="col-sm-4">
											<input type="text" name="po_number" id="po_number" class="form-control" value="<?php echo $row['po'];?>">
										</div>
									</div>
									<div class="row mt-3">
										<label class="col-sm-2 col-form-label">Submitted Date</label>
										<div class="col-sm-4">
											<input type="date" name="sub_date" id="sub_date" class="form-control" value="<?php echo $row['subdate'];?>">
										</div>
										<label class="col-sm-2 col-form-label">Received Amount</label>
										<div class="col-sm-4">
											<input type="text" name="received_amt" id="received_amt" class="form-control" value="<?php echo $row['current'];?>">
										</div>
									</div>
									<div class="row mt-3">
										<label class="col-sm-2 col-form-label">Received VAT Amount</label>
										<div class="col-sm-4">
											<input type="text" name="received_gts_amt" id="received_gts_amt" class="form-control" value="<?php echo $row['current_gst'];?>">
										</div>
										<label class="col-sm-2 col-form-label"></label>
										<div class="col-sm-4">
											<!-- <input type="text" name="received_tds_amt" id="received_tds_amt" class="form-control" value="<?php echo $row['current_tds'];?>"> -->
										</div>
									</div>
									<div class="row mt-3">
										<label class="col-sm-2 col-form-label">Received Date</label>
										<div class="col-sm-4">
											<input type="date" name="received_date" id="received_date" class="form-control" value="<?php echo $row['recdate'];?>">
										</div>
										<label class="col-sm-2 col-form-label">Remark</label>
										<div class="col-sm-4">
											<input type="text" name="remark" id="remark" class="form-control" value="<?php echo $row['remarks'];?>">
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