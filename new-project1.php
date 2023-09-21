<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");

	$id = $_REQUEST["id"];
	$today = date('Y-m-d');

	$sql = "SELECT * FROM enquiry WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$rfqid = $row["rfqid"];

	$sql4 = "SELECT * FROM project WHERE eid='$id'";
	$result4 = $conn->query($sql4);
	$row4 = $result4->fetch_assoc();

	$proid = $row4["id"];

    if(isset($_POST['save']))
    {
		$logo = "";
		$status = $_POST["status"];
		$dept = $_POST["dept"];
		$finalq = $_POST["finalq"];

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
			}
			else
			{
				echo "<script>alert('File Format for logo is not accepted!')</script>";
			}
		}

		$sql = "SELECT * FROM scope WHERE eid='$id'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			$i = 0;
			$sql1 = "DELETE FROM project WHERE id='$proid'";
			if($conn->query($sql1) === TRUE)
			{
				while($row = $result->fetch_assoc())
				{
					$sql4 = "SELECT * FROM project";
					$result4 = $conn->query($sql4);
					$sum = $result4->num_rows;

					$sid = $row["id"];

					$divi = $_POST["divi"][$i];
					$value = $_POST["value"][$i];
					$pterm = $_POST["pterms"][$i];
					$type = $_POST["type"][$i];
					$po = $_POST["po"][$i];
					$link = $_POST["link"][$i];
					$noofm = $_POST["noofm"][$i];

					$first = substr($divi, 0, 3);
					$second = substr($type, 0, 3);

					$projid = strtoupper($first)."-".strtoupper($second)."-000".$sum;

					$sql2 = "INSERT INTO project (eid,logo,subdivi,finalq,value,pterms,noofm,status,nostatus,scope,proid,divi,dept) VALUES ('$id','$logo','$type','$finalq','$value','$pterm','$noofm','$status','1','$sid','$projid','$divi','$dept')";
					if($conn->query($sql2) === TRUE)
					{
						$sql3 = "SELECT * FROM invoice";
						$result3 = $conn->query($sql3);
						$tot = $result3->num_rows;

						$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;

						$sql1 = "INSERT INTO invoice (invid,rfqid,term,total,current,date,pid) VALUES ('$invid','$rfqid','$pterm','$value','0','$today','$projid')";
						if($conn->query($sql1) === TRUE)
						{
							$sql3 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
							$result3 = $conn->query($sql3);
							$row3 = $result3->fetch_assoc();

							$projectid = $row3["id"];

							$sql4 = "INSERT INTO poss (pid,po,polink) VALUES ('$projectid','$link','$po')";
							if($conn->query($sql4) === TRUE)
							{
								header("location:all-projects.php?msg=Project Registered!");
							}
						}
					}
					$i++;
				}
			}
		}
		else
		{
			$divi = $_POST["divi"][0];
			$value = $_POST["value"][0];
			$pterm = $_POST["pterms"][0];
			$type = $_POST["type"][0];
			$po = $_POST["po"][0];
			$link = $_POST["link"][0];
			$noofm = $_POST["noofm"][0];

			$sql4 = "SELECT * FROM project";
			$result4 = $conn->query($sql4);
			$sum = $result4->num_rows;

			$first = substr($divi, 0, 3);
			$second = substr($type, 0, 3);

			$projid = strtoupper($first)."-".strtoupper($second)."-000".$sum;

			$sql2 = "UPDATE project SET dept='$dept',divi='$divi',eid='$id',logo='$logo',subdivi='$type',value='$value',status='$status',nostatus='1',pterms='$pterm',noofm='$noofm',po='$po',finalq='$link',proid='$projid' WHERE id='$proid'";
			if($conn->query($sql2) === TRUE)
			{
				$sql3 = "SELECT * FROM invoice";
				$result3 = $conn->query($sql3);
				$tot = $result3->num_rows;

				$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;

				$sql1 = "INSERT INTO invoice (invid,rfqid,term,total,current,date,pid) VALUES ('$invid','$rfqid','$pterm','$value','0','$today','$projid')";
				if($conn->query($sql1) === TRUE)
				{
					$sql4 = "INSERT INTO poss (pid,po,polink) VALUES ('$proid','$link','$po')";
					if($conn->query($sql4) === TRUE)
					{
						header("location:all-projects.php?msg=Project Registered!");
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
	<meta name="description" content="New Project | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="New Project | Project Management System" />
	<meta property="og:description" content="New Project | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Project | Project Management System</title>
	
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
		.border
		{
			border: 1px solid #B0B0B0 !important;
			padding: 5px 10px;
			border-radius: 4px;
		}
		.hide
		{
			display: none;
		}
		.custom-file-label
		{
			font-weight: unset !important;
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
				<h4 class="breadcrumb-title">New Project</h4>
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
										<label class="col-sm-2 col-form-label">RFQ Id</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" value="<?php echo $row["rfqid"] ?>" readonly>
										</div>
									
										<label class="col-sm-1 col-form-label">Division</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" value="<?php echo $row["rfq"] ?>" readonly>
										</div>

									</div>

									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Project</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="text" value="<?php echo $row["name"] ?>" name="name" readonly>
										</div>
									
										<label class="col-sm-1 col-form-label">Client</label>
										<div class="col-sm-2">
											<input class="form-control" type="text" name="client" value="<?php echo $row["cname"] ?>" readonly>
										</div>
									
										<label class="col-sm-1 col-form-label">Responsibility</label>
										<div class="col-sm-2">
                                            <input class="form-control" type="text" value="<?php echo $row["responsibility"] ?>" name="name" readonly>
										</div>

									</div>

									<div class="border">
									
									<div class="form-group row m-b30">
										<div class="col-sm-1">
											<center>
												<label class="col-form-label">Scope</label>
											</center>
										</div>
										<div class="col-sm-1">
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
											<center><label class="col-form-label">Po</label></center>
										</div>
										<div class="col-sm-1">
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Dues</label></center>
										</div>
									</div>

									<?php
										$sql1 = "SELECT * FROM scope WHERE eid='$id'";
										$result1 = $conn->query($sql1);
										$i = 1;
										if($result1->num_rows > 0)
										{
											while($row1 = $result1->fetch_assoc())
											{
									?>
										<div class="form-group row m-b30">
											<div class="col-sm-1">
												<center><label class="col-form-label"><?php echo $row1["scope"] ?></label></center>
											</div>
											<div class="col-sm-1">
												<select name="divi[]" class="form-control">
													<option value selected disabled>Select Division</option>
													<option value="SUSTAINABILITY">SUSTAINABILITY</option>
													<option value="DEPUTATION">DEPUTATION</option>
													<option value="ENGINEERING">ENGINEERING</option>
													<option value="MEP">MEP</option>
													<option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
													<option value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
													<option value="MISCELLANEOUS">MISCELLANEOUS</option>
												</select>
											</div>
											<div class="col-sm-1">
												<input type="number" class="form-control" name="value[]" placeholder="Value" id="value<?php echo $i ?>" onchange="vals(this.value)">
											</div>
											<div class="col-sm-2">
												<select class="form-control" name="pterms[]" onclick="fun(this.value,<?php echo $i ?>)">
													<option value="">Select Term</option>
													<option value="1">Milestone Basic</option>
													<option value="2">Monthly Basic</option>
													<option value="3">Prorata Basic</option>
												</select>
											</div>
											<div class="col-sm-2">
												<select class="form-control" name="type[]" required>
													<option value readonly>Select Type</option>
													<option value="Deputation">Deputation</option>
													<option value="Project">Project</option>
												</select>
											</div>
											<div class="col-sm-1">
												<input type="text" name="po[]" class="form-control" placeholder="PO Link">
											</div>
											<div class="col-sm-2">
												<input type="text" name="link[]" class="form-control" placeholder="PO Number">
											</div>
											<div class="col-sm-1">
												<input id="nom<?php echo $i ?>" type="number" min="1" name="noofm[]" class="form-control" placeholder="Dues">
											</div>
											<div class="col-sm-1">
												<a onClick="return confirm('Sure to Delete this Scope!');" href="delete-scope.php?id=<?php echo $row1["id"]."&m=".$id ?>" class="btn btn-danger btn_remove">X</a>
											</div>
										</div>
									<?php
											$i++;
											}
										}
										else
										{
									?>
										<div class="form-group row m-b30">
											<div class="col-sm-1">
												<center><label class="col-form-label"><?php echo $row["scope"] ?></label></center>
											</div>
											<div class="col-sm-1">
												<select name="divi[]" class="form-control">
													<option value selected disabled>Select Division</option>
													<option value="SUSTAINABILITY">SUSTAINABILITY</option>
													<option value="DEPUTATION">DEPUTATION</option>
													<option value="ENGINEERING">ENGINEERING</option>
													<option value="MEP">MEP</option>
													<option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
													<option value="LASER SCANNING SERVICES">LASER SCANNING SERVICES</option>
													<option value="MISCELLANEOUS">MISCELLANEOUS</option>
												</select>
											</div>
											<div class="col-sm-1">
												<input type="number" class="form-control" name="value[]" placeholder="Value" id="value1" onchange="vals(this.value)">
											</div>
											<div class="col-sm-2">
												<select class="form-control" name="pterms[]" onclick="fun(this.value,1)">
													<option value="">Select Term</option>
													<option value="1">Milestone Basic</option>
													<option value="2">Monthly Basic</option>
													<option value="3">Prorata Basic</option>
												</select>
											</div>
											<div class="col-sm-2">
												<select class="form-control" name="type[]" required>
													<option value readonly>Select Type</option>
													<option value="Deputation">Deputation</option>
													<option value="Project">Project</option>
												</select>
											</div>
											<div class="col-sm-1">
												<input type="text" name="po[]" class="form-control" placeholder="PO Link">
											</div>
											<div class="col-sm-2">
												<input type="text" name="link[]" class="form-control" placeholder="PO Number">
											</div>
											<div class="col-sm-2">
												<input type="number" min="1" id="nom1" name="noofm[]" class="form-control" placeholder="Dues">
											</div>
										</div>		
									<?php
										}
									?>

									</div>
									
									<div class="form-group row m-b30 m-t30">

										<label class="col-sm-2 col-form-label">Total PO</label>
										<div class="col-sm-4">
											<input type="Text" id="total" class="form-control" readonly>
										</div>

									</div>
									
									<div class="form-group row m-b30 m-t30">

										<div class="col-sm-4">
											<select class="form-control" name="status" required>
												<option value selected disabled>Select Status</option>
												<option value="Running">Running</option>
												<option value="Commercially Open">Commercially Open</option>
												<option value="Project Closed">Project Closed</option>
												<option value="Commercially Closed">Commercially Closed</option>
											</select>
										</div>

										<div class="col-sm-4">
											<input class="custom-file-input" type="file" name="logo" id="customFile">
											<label class="custom-file-label" for="customFile">Update Client Logo</label>
										</div>

										<div class="col-sm-4">
											<select name="dept" class="form-control" required>
												<option value selected disabled>Select Department</option>
												<?php
													$sql5 = "SELECT * FROM dept ORDER BY name ASC";
													$result5 = $conn->query($sql5);
													while($row5 = $result5->fetch_assoc())
													{
												?>
														<option value="<?php echo $row5["id"] ?>"><?php echo $row5["name"] ?></option>
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
											<input class="form-control" type="text" name="finalq" required>
										</div>
									
									</div>


								</div>
								<div class="" >
									<div class="">
										<div class="row" style="border-top: 1px solid rgba(0,0,0,0.05);padding: 20px;">
											<div class="col-sm-11">
											</div>
											<div class="col-sm-1">
												<input type="submit" name="save" class="btn" value="Add" onclick=" return validate();">
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
	function validate()
	{
		var pterms = document.getElementById("pterms").value;
		var month = document.getElementById("month").value;
		var values = document.getElementById("value").value;

		if(pterms == "")
		{
			$("#pterms").css("border", "1px solid red");
        	return false;
		}
		else
		{
			if(pterms == "1" || pterms == "2")
			{
				if(month == "")
				{
					$("#month").css("border", "1px solid red");
        			return false;
				}
				if(values == "")
				{
					$("#value").css("border", "1px solid red");
        			return false;
				}
			}
		}
	}

</script>

<script>
	function gets(val)
	{
		if(val == "1" || val == "2")
		{
			document.getElementsByClassName('de')[0].style.display = 'block';
			document.getElementsByClassName('de')[1].style.display = 'block';
		}
		else
		{
			document.getElementsByClassName('de')[0].style.display = 'none';
			document.getElementsByClassName('de')[1].style.display = 'none';
		}
	}
	function vals(val)
	{
		var tot = 0;
		var inc = <?php echo $i ?>;

		for(var j=1;j<inc;j++)
		{
			var z = document.getElementById("value"+j).value;
			tot = Number(z) + Number(tot);
		}
		document.getElementById("total").value = "QAR " + String(tot);
	}
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
	function fun(numb1,numb2)
	{
		var demo = "nom" + String(numb2);
		if(numb1 == "3")
		{
			document.getElementById(demo).style.display = "none";
		}
		else
		{
			document.getElementById(demo).style.display = "block";
		}
	}
</script>
<script>
// Add the following code if you want the name of the file appear on select
	$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
</body>
</html>