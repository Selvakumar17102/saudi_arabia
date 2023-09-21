<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	$user=$_SESSION["username"];
	$id = $_REQUEST["id"];
	$m = $_REQUEST["m"];
	
    $sql = "SELECT * FROM enquiry WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

	$mainrfq = $row["rfqid"];

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
		//$qdatec = $_POST["qdatec"];
		$qdate = $_POST["qdate"];
		$query = $_POST["query"];
		$notes = $_POST["notes"];

		$te = "";
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

		$rfqupdate = explode("-", $row["rfqid"]);

		$rfqid = $rfqupdate[0]."-".strtoupper($te)."-".$rfqupdate[2]."-".$rfqupdate[3]."-".$rfqupdate[4]."-".$rfqupdate[5]."-".$rfqupdate[6];

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

				}
			}
		}

		$time = date('y-m-d H:i:s');
		
		$sql = "UPDATE enquiry SET rfqid='$rfqid',division='$division',rfq='$rfq',name='$name',location='$location',enqdate='$enqdate',stage='$stage',cname='$cname',responsibility='$responsibility',qstatus='$qstatus',qdate='$qdate',notes='$notes' WHERE id='$id'";
		if($conn->query($sql) === TRUE)
		{
			$sql8 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','2','$time')";
			$conn->query($sql8);
			
			$count = count($_POST["scope"]);

			$sql7 = "SELECT * FROM project WHERE eid='$id'";
			$result7 = $conn->query($sql7);

			if($result7->num_rows == 0)
			{
				$sql1 = "DELETE FROM scope WHERE eid='$id'";
				if($conn->query($sql1) === TRUE)
				{
					for($i=0;$i<$count;$i++)
					{
						$scope = $_POST["scope"][$i];

						$sql2 = "INSERT INTO scope (eid,scope) VALUES ('$id','$scope')";
						if($conn->query($sql2) === TRUE)
						{
							if($m != "")
							{
								header("location: entire-enquiry.php?msg=Enquiry Updation Successful");
							}
							else
							{
								header("location: all-enquiry.php?msg=Enquiry Updation Successful");
							}
						}
					}
				}
			}
			else
			{
				if($m != "")
				{
					header("location: entire-enquiry.php?msg=Enquiry Updation Successful");
				}
				else
				{
					header("location: all-enquiry.php?msg=Enquiry Updation Successful");
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
										<div class="col-sm-4">
											<select class="form-control" name="rfq">
												<option value="<?php echo $row["rfq"] ?>"><?php echo $row["rfq"] ?></option>
												<option value="SUSTAINABILITY">SUSTAINABILITY</option>
												<option value="DEPUTATION">DEPUTATION</option>
												<option value="MEP">MEP</option>
												<option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
												<option value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
												<option value="MISCELLANEOUS">MISCELLANEOUS</option>
											</select>
										</div>

										<label class="col-sm-2 col-form-label">Sub Division</label>
										<div class="col-sm-4">
											<select class="form-control" name="division">
												<option value="<?php echo $row["division"] ?>"><?php echo $row["division"] ?></option>
												<option value="DEPUTATION">DEPUTATION</option>
												<option value="ENGINEERING SERVICES">ENGINEERING SERVICES</option>
												<option value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
												<option value="SIMULATION & ANALYSIS SERVICES">SIMULATION & ANALYSIS SERVICES</option>
												<option value="SUSTAINABILITY">SUSTAINABILITY</option>
											</select>
										</div>

									</div>
									
									<div class="form-group row">

                                        <label class="col-sm-2 col-form-label">Enquiry Date</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="date" value="<?php echo $row["enqdate"] ?>" name="enqdate">
										</div>

                                    	<label class="col-sm-2 col-form-label">Project Name*</label>
										<div class="col-sm-4">
                                            <input class="form-control" value="<?php echo $row["name"] ?>" type="text" name="name">
										</div>

									</div>
									
									<div class="form-group row">
									
										<label class="col-sm-2 col-form-label">Location</label>
										<div class="col-sm-4">
											<select class="form-control" name="location">
                                                <option value="<?php echo $row["location"] ?>"><?php echo $row["location"] ?></option>
												<option value="Qatar">Qatar</option>
												<option value="UAE">UAE</option>
												<option value="Canada">Canada</option>
												<option value="Singapore">Singapore</option>
												<option value="India">India</option>
											</select>
										</div>

										<label class="col-sm-2 col-form-label">Stage</label>
										<div class="col-sm-4">
											<select class="form-control" name="stage">
                                                <option value="<?php echo $row["stage"] ?>"><?php echo $row["stage"] ?></option>
												<option value="Tender">Tender</option>
												<option value="Job In Hand">Job In Hand</option>
												<option value="Training">Training</option>
											</select>
										</div>

									</div>

									<div class="form-group" id="duplicate">

									<?php

										$sql1 = "SELECT * FROM scope WHERE eid='$id'";
										$result1 = $conn->query($sql1);
										$i = 0;
										if($result1->num_rows > 0)
										{
											$count = $result1->num_rows;
											while($row1 = $result1->fetch_assoc())
											{
									?>

										<div class="row m-t10" id="duplicate<?php echo $i ?>">

											<label class="col-sm-2 col-form-label">Scope</label>
											<div class="col-sm-4">
												<input class="form-control" value="<?php echo $row1["scope"] ?>" type="text" name="scope[]">
											</div>

											<div class="col-sm-1">
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

												<label class="col-sm-2 col-form-label">Scope</label>
												<div class="col-sm-4">
													<input class="form-control" value="<?php echo $row["scope"] ?>" type="text" name="scope[]">
												</div>
												<div class="col-sm-1">
													<button type="button" name="add" id="add" onclick="clicks()" class="btn btn-success">+</button>
												</div>
											</div>
									<?php
										}
									?>

									</div>

                                    <div class="form-group row">
										<label style="color: black;font-style:bold;font-size:20px" class="col-sm-3 col-form-label">Client Details</label>
									</div>

                                    <div class="form-group row">
									<label class="col-sm-2 col-form-label">Client Name</label>
										<div class="col-sm-4 course">
											<input class="form-control" value="<?php echo $row["cname"] ?>" type="text" name="cname">
										</div>
                                    </div>

									<div class="form-group row">
									<label class="col-sm-2 col-form-label">Responsibility</label>
										<div class="col-sm-4 course">
                                            <select class="form-control" name="responsibility">
                                                <option value="<?php echo $row["responsibility"] ?>"><?php echo $row["responsibility"] ?></option>
												<option value="NN">NN</option>
												<option value="KMB">KMB</option>
												<option value="NK">NK</option>
												<option value="VS">VS</option>
												<option value="SV">SV</option>
												<option value="SB">SB</option>
												<option value="AJ">AJ</option>
												<option value="BM">BM</option>
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
										<label class="col-sm-2 col-form-label">Quotation Date by Client</label>
										<div class="col-sm-4">
										<input class="form-control" type="date" value="<?php echo $row["qdatec"] ?>" name="qdatec">
										</div>
													
										<label class="col-sm-2 col-form-label">Quotation Submitted Date</label>
										<div class="col-sm-4">
											<input class="form-control" type="date" value="<?php echo $row["qdate"] ?>" name="qdate">
										</div>
									</div>

									<div class="form-group row">
										
										<label class="col-sm-2 col-form-label">Notes</label>
										<div class="col-sm-10">
                                            <textarea style="height:100px" class="form-control" name="notes"><?php echo $row["notes"] ?></textarea>
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
	<?php
		if($count == "")
		{
			$count = 0;
		}
	?>
<script>
	var i = <?php echo $count ?>;
	function clicks()
	{
		i++;
        $('#duplicate').append('<div class="row m-t10" id="duplicate'+i+'"><div class="col-sm-2"><label class="col-form-label">Scope</label></div><div class="col-sm-4"><input class="form-control" type="text" name="scope[]" required></div><div class="col-sm-2"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'" onclick="remove(this.id)">X</button></div></div>');
	}
    function remove(btn)
	{
        $('#duplicate'+btn+'').remove();  
    }
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

</body>
</html>