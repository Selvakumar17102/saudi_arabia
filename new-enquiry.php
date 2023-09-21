<?php
	// ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");

	$user=$_SESSION["username"];
	$today = date("Y-m-d");
	
    if(isset($_POST['save']))
    {
		$rfq = $_POST["rfq"];
		$division = $_POST["division"];
		$name = $_POST["name"];
		$location = $_POST["location"];
		$enqdate = $_POST["enqdate"];
		$stage = $_POST["stage"];
		$scope = $_POST["scope"];
		$cname = $_POST["cname"];
		$responsibility = $_POST["responsibility"];
		$qstatus = $_POST["qstatus"];
		$qdate = $_POST["qdate"];
		$notes = $_POST["notes"];
		$pabre = $_POST["pabre"];
		$cabre = $_POST["cabre"];
		
		$scope_type = 1;
		$cid = $revision = 0;
		
		if($scope =="others")
		{
			$scope = "0";
			$scope_type = 0;
			$countscope = count($_POST["o_scope"]);
		}
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
		
		$totcp = count($_POST["cp"]);
		$time = date('y-m-d H:i:s');
		
		$sql2 = "SELECT * FROM enquiry WHERE new_status='1'";
		$result2 = $conn->query($sql2);
		
		$num = $result2->num_rows;
		
		$num +=1001;
		$row2 = $result2->fetch_assoc();
		
		$sql7 = "SELECT rfqid FROM enquiry ORDER BY id DESC LIMIT 1";
		$result7 = $conn->query($sql7);
		$row7 = $result7->fetch_assoc();
		
		$last_rfqid = $row7['rfqid'];
		
		$last_rfqid_no = explode('-', $last_rfqid); 
		$last_rfqid_no = explode('_', $last_rfqid_no[6]); 
		$last_rfqid_no = $last_rfqid_no[0];  
		$int_rfq_no  = (int)$last_rfqid_no+=1;
		
		
		$sql = "SELECT * FROM enquiry WHERE rfqno='$last_rfqid_no'";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			
			$sql1 = "SELECT * FROM enquiry ORDER BY rfqno DESC LIMIT 1";
			$result1 = $conn->query($sql1);
			$row1 = $result1->fetch_assoc();

			$last_rfqid_no = $row1['rfqno'];
			$last_rfqid_no += 1;
			$int_rfq_no = $last_rfqid_no;
		}

		$number = $last_rfqid_no;
		$number = sprintf('%04d',$number);
		$update_rfq_id = $number;

		$rfqid = "CONSA-".strtoupper($te)."-".strtoupper($pabre)."-".strtoupper($cabre)."-".date('m',strtotime($enqdate))."-".date('Y',strtotime($enqdate))."-".$update_rfq_id."_00";
		
		$sql = "INSERT INTO enquiry (rfq,rfqid,rfqno,name,location,enqdate,stage,cname,responsibility,qstatus,qdate,revision,notes,division,cid,scope,scope_type,new_status) VALUES ('$rfq','$rfqid','$last_rfqid_no','$name','$location','$enqdate','$stage','$cname','$responsibility','$qstatus','$qdate','$revision','$notes','$division','$cid','$scope','$scope_type','1')";

		if($conn->query($sql) == TRUE)
		{
			$sql1 = "SELECT * FROM enquiry WHERE rfqid='$rfqid' LIMIT 1";
			$result = $conn->query($sql1);
			$row = $result->fetch_assoc();

			$id = $row["id"];

			$sql5 = "INSERT INTO mod_details (enq_no,user_id,control,update_details,datetime) VALUES ('$id','$user','1','1','$time')";
			$conn->query($sql5);

			for($j=0;$j<$countscope;$j++)
			{
				$scope = $_POST["o_scope"][$j];   
				$gst_percentage = $_POST["gst_percentage"][$j];
				if($scope !="")
				{
					$sql4 = "INSERT INTO scope (eid,scope) VALUES ('$id','$scope')";
					$conn->query($sql4);
				}
			}
			for($i=0;$i<$totcp;$i++)
			{
				$cp = $_POST["cp"][$i];
				$cpd = $_POST["cpd"][$i];
				$pn = $_POST["pn"][$i];
				$ln = $_POST["ln"][$i];
				$email = $_POST["email"][$i];
				$add1 = $_POST["add1"][$i];

				 $sql3 = "INSERT INTO client (rfqid,cp,cpd,pn,ln,email,add1) VALUES ('$rfqid','$cp','$cpd','$pn','$ln','$email','$add1')";
				if($conn->query($sql3) === TRUE)
				{
					if($qstatus == "SUBMITTED")
					{
						header("location: revision-edit.php?id=$id&msg=Enquiry Added and Submitted");
					}
					else
					{
						header("location: view-enquiry.php?id=$id&msg=ENQURIY ADDED SUCCESSFULLY!!");
					}
				}
			}
		}
		
		else
		{
			header("location: new-enquiry.php?msg=$sql");
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
	<meta name="description" content="New Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="New Enquiry | Project Management System" />
	<meta property="og:description" content="New Enquiry | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Enquiry | Project Management System</title>
	
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
	<?php include_once("inc/header.php");
	?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");
	?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
			<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">New Enquiry</h4>
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
											<select class="form-control" name="rfq" id="rfq" required onchange="gets()">
												<option value readonly>--Select Division--</option>
												<option value="ENGINEERING">ENGINEERING </option>
												<option value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
												<option value="SUSTAINABILITY">SUSTAINABILITY</option>
												<option value="ACOUSTICS">ACOUSTICS</option>
												<option value="LASER SCANNING">LASER SCANNING</option>
												<option value="OIL & GAS">OIL & GAS</option>
											</select>
										</div>
										<label class="col-sm-2 col-form-label">Project Type</label>
										<div class="col-sm-4">
											<select class="form-control" name="division" id="div" required onchange="gets()">
												<option value readonly>--Select Project Type--</option>
												<option value="DEPUTATION">DEPUTATION</option>
												<option value="PROJECT">PROJECT</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Enq. Date</label>
										<div class="col-sm-4">
                                            <input class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>" name="enqdate" required>
										</div>
										<label class="col-sm-2 col-form-label">Location</label>
										<div class="col-sm-4">
											<select class="form-control" name="location" required>
												<!-- <option value readonly>--Select Location--</option>
												<option value="Qatar">Qatar</option>
												<option value="UAE">UAE</option>
												<option value="Canada">Canada</option>
												<option value="Singapore">Singapore</option>
												<option value="India">India</option>
												<option value="Bahrain">Bahrain</option> -->
												<option value="Saudi Arabia">Saudi Arabia</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Project Name*</label>
										<div class="col-sm-3">
                                            <input class="form-control" type="text" name="name" required>
										</div>
										<div class="col-sm-1">
                                            <input class="form-control" type="text" placeholder="abbr." name="pabre" required>
										</div>
										<label class="col-sm-2 col-form-label">Stage</label>
										<div class="col-sm-4">
											<select class="form-control" name="stage" required>
												<option value readonly>--Select Stage--</option>
												<option value="Tender">Tender</option>
												<option value="Job In Hand">Job In Hand</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="row m-b20">
											<label class="col-sm-2 col-form-label">Scope</label>
											<div class="col-sm-4">
												<select name="scope" id="scopes" class="form-control" onclick="divi()" required>
													<option value="" selected value disabled>--Select Division--</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group" id="duplicate" style="display:none">
										<div class="row m-b20">
											<label class="col-sm-2 col-form-label">Others</label>
											<div class="col-sm-4">
												<input class="form-control" type="text" name="o_scope[]">
											</div>
											<!-- <label class="col-sm-1 col-form-label">GST%</label>
											 <div class="col-sm-4"> 
												<select name="gst_percentage[]" id="gst_percentage" class="form-control" required>
													<option value="" selected value disabled>--Select GST%--</option>
													<option value="5">5%</option>
													<option value="12">12%</option>
													<option value="18">18%</option>
													<option value="28">28%</option>
												</select>
											</div> -->
											<div class="col-sm-1">
												<button type="button" name="add" id="add" class="btn btn-success">+</button>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label style="color: black;font-style:bold;font-size:20px" class="col-sm-3 col-form-label">Client Details</label>
									</div>
									<div class="form-group row">
									
										<label class="col-sm-2 col-form-label">Client Name</label>
										<div class="col-sm-4 course">
											<select class="form-control" name="cname" id ="cname" required>
												<option value selected Disabled>--Select Client--</option>
												<!-- <option value="1"><a href="add-client.php" class="btn">Add Client</a></option> -->
												<?php
													$sql6 = "SELECT * FROM main ORDER BY name ASC";
													$result6 = $conn->query($sql6);
													while($row6 = $result6->fetch_assoc())
													{
												?>
														<option value="<?php echo $row6["name"] ?>"><?php echo $row6["name"] ?></option>
												<?php
													}
												?>
											</select>
										</div>
										<div class="col-sm-1">
											<input class="form-control" type="text" placeholder="abbr." name="cabre" required>
										</div>										
									</div>
									<div class="extra-field-box" style="margin-bottom:20px">
										<div class="multi-box">	
											<div class="dublicat-box mrg-bot-40">
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Contact Person</label>
												<div class="col-sm-4 course">
													<input class="form-control" type="text" name="cp[]">
												</div>
												<label class="col-sm-2 col-form-label">Designation</label>
												<div class="col-sm-4">
													<input class="form-control" type="text" name="cpd[]">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2 col-form-label">Phone Number / landline</label>
												<div class="col-sm-4 course">
													<input class="form-control" type="text" name="pn[]">
												</div>
												<label class="col-sm-2 col-form-label">Email</label>
												<div class="col-sm-4">
													<input class="form-control" type="email" name="email[]">
												</div>
											</div>
												<button type="button" class="btn remove-field light-gray-btn" style="background: red;color: #fff;"><i class="fa fa-minus" aria-hidden="true"></i></button>
											</div>
										</div>
										<div class="text-right"><button type="button" class="btn add-field theme-btn" style="background: green;color: #fff;"><i class="fa fa-plus" aria-hidden="true"></i></button></div>
									</div>
									<div class="form-group row">
									<label class="col-sm-2 col-form-label">Responsibility</label>
										<div class="col-sm-4 course">
                                            <select class="form-control" name="responsibility" required>
												<option value readonly>Select Responsibility</option>
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
                                        <label class="col-sm-2 col-form-label">Enquiry Status</label>
										<div class="col-sm-4">
											<select class="form-control" name="qstatus" required>
												<option value readonly>Select Status</option>
												<option value="SUBMITTED">SUBMITTED</option>
												<option SELECTED value="NOT SUBMITTED">NOT SUBMITTED</option>
												<option value="DROPPED">DROPPED</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Submission Date</label>
										<div class="col-sm-4">
											<input class="form-control" type="date" name="qdate" id="qd" required>
										</div>
										<label class="col-sm-2 col-form-label">Notes</label>
										<div class="col-sm-4">
                                            <textarea style="height:100px" class="form-control" name="notes"></textarea>
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
	var i = 0;
	$('#add').click(function(){
			i++;
           $('#duplicate').append(
			   '<div class="form-group row" id="duplicate'+i+'"><div class="col-sm-2"></div><div class="col-sm-4"><input class="form-control" type="text" name="o_scope[]"></div><div class="col-sm-1"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div></div>');
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#duplicate'+button_id+'').remove();  
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
		else{
			document.getElementById("rfq").style.border = "1px solid #e1e6eb";
		}
		if(sub_divi =="")
		{
			document.getElementById("div").style.border = "1px solid red";
		}
		else{
			document.getElementById("div").style.border = "1px solid #e1e6eb";
		}
		if(others =="others")
		{
			document.getElementById("duplicate").style.display = "block";
		}
		else
		{
			document.getElementById("duplicate").style.display = "none";
		}	
	}
	// $(document).ready(function(){
	// 	$("#cname").change(function(){
	// 		var client = $("#cname").val();
	// 		if(client == 1){
	// 			window.location.href = 'add-client.php';
	// 		}
	// 	});
	// });
</script>
</body>
</html>
