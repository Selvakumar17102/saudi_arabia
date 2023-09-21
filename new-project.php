<?php
	// ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	$user=$_SESSION["username"];
	$id = $_REQUEST["id"];
	$today = date('Y-m-d');

	$sql = "SELECT * FROM enquiry WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$rfqid = $row["rfqid"];
	$scope_id = $row['scope'];
	$scope_type = $row['scope_type'];
	$enq_name = $row['name'];

	$sql4 = "SELECT * FROM project WHERE eid='$id'";
	$result4 = $conn->query($sql4);
	$row4 = $result4->fetch_assoc();

	$proid = $row4["id"];

    if(isset($_POST['save']))
    {
		$logo = "";
		$status = $_POST["status"];
		$po_status = $_POST["po_status"];
		$dept = $_POST["dept"];
		$invdues = $_POST["invdues"];
		$finalq = $_POST["finalq"];
		$open_status = $_POST['open_status'];
		$exp_date = $_POST['exp_date'];
		$url = $_POST['url'];
		$time = date('y-m-d H:i:s');
		
		if($dept == ""){
			$dept = 0;
		}
		
		if($scope_type == 0)
		{
			
			$sql = "SELECT * FROM scope WHERE eid='$id'";
			$result = $conn->query($sql);
			
			$i = 0;
			$sql1 = "DELETE FROM project WHERE id='$proid'";
			if($conn->query($sql1) === TRUE)
			{
				while($row = $result->fetch_assoc())
				{
					$sql4 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
					$result4 = $conn->query($sql4);
					$row4 = $result4->fetch_assoc();
					$last_proid = $row4["proid"] ;
			        $sum = explode('-', $last_proid); 
	                $sum = explode('_', $sum[2]); 
	                $sum = $sum[0];
					$sum  = (int)$sum;
	                $sum  = $sum+=1;

					$sid = $row["id"];

					$divi = $_POST["divi"][$i];
					$value = $_POST["value"][$i];
					$gst_value = $_POST["gst_value"][$i];
					$tds_value = $_POST["value"][$i]*10/100;
					$pterm = $_POST["pterms"][$i]; 
					$type = $_POST["type"][$i];
					$po = $_POST["po"][$i];
					$link = $_POST["link"][$i];
					$noofm = $_POST["noofm"][$i];

					$first = substr($divi, 0, 3);
					$second = substr($type, 0, 3);

					if($noofm == "")
					{
						$noofm = 0;
					}
					// OIL & GAS //
					if($first == "OIL"){
						$first = "O&G";
					}
					// OIL & GAS //

					// convert number with zeros eg:00010
					$proname = sprintf('%04d',$sum);

					$projid = strtoupper($first)."-".strtoupper($second)."-".$proname;
					
							$sql2 = "INSERT INTO project (eid,logo,subdivi,finalq,value,gst_value,pterms,noofm,status,nostatus,scope,proid,divi,dept,scope_type,invdues,po_status,open_status,exp_date,inv) VALUES ('$id','$url','$type','$finalq','$value','$gst_value','$pterm','$noofm','$status','1','$sid','$projid','$divi','$dept','2','$invdues','$po_status','$open_status','$exp_date','1')";
							if($conn->query($sql2) === TRUE)
							{
								    $sql10 = "SELECT id FROM account ORDER BY id DESC LIMIT 1";
									$result10 = $conn->query($sql10);
									$row10 = $result10->fetch_assoc();
									$code = $row10['id'];
								// 
								$multisql = "SELECT * FROM enquiry WHERE id='$id'";
								$multresult = $conn->query($multisql);
								$multrow = $multresult->fetch_assoc();

							$client_name = $multrow['cname']; 
							$division_name = $multrow['rfq'];
							$project_name = $multrow['name'];

							$client_id_sql = "SELECT * FROM main WHERE name = '$client_name'";
							$client_id_result = $conn->query($client_id_sql);
							$client_id_row = mysqli_fetch_array($client_id_result);
							$client_id = $client_id_row['id'];
							
							$division_sql = "SELECT * FROM division WHERE division = '$division_name'";
							$division_result = $conn->query($division_sql);
							$division_row = mysqli_fetch_array($division_result);
							$division_id =  $division_row['id'];

							$account_sql = "SELECT * FROM account WHERE name = '$client_name'";
							$account_result = $conn->query($account_sql);
							if($account_result->num_rows > 0){
								$main_acc_id_sql = "SELECT * FROM account WHERE name = '$client_name'";
									$main_acc_id_result = $conn->query($main_acc_id_sql);
									$main_acc_id_row = mysqli_fetch_array($main_acc_id_result);
									$main_acc_id =  $main_acc_id_row['id'];

									

									$add_sub_acount = "INSERT INTO account (name,type,account_id,divi,sub,code) VALUES('$project_name',2,'$projid','$division_id','$main_acc_id','$code')";
									$conn->query($add_sub_acount);
							}else{
								$add_acount = "INSERT INTO account (name,type,account_id,divi,code) VALUES('$client_name',2,'$client_id','$division_id','$code')";
								if($conn->query($add_acount))
								{
									$sql21 = "SELECT id FROM account ORDER BY id DESC LIMIT 1";
									$result21 = $conn->query($sql21);
									$row21 = $result21->fetch_assoc();
									$code21 = $row21['id'];

									$main_acc_id_sql = "SELECT * FROM account WHERE name = '$client_name'";
									$main_acc_id_result = $conn->query($main_acc_id_sql);
									$main_acc_id_row = mysqli_fetch_array($main_acc_id_result);
									$main_acc_id =  $main_acc_id_row['id'];
									$add_sub_acount = "INSERT INTO account (name,type,account_id,divi,sub, code) VALUES('$project_name',2,'$projid','$division_id','$main_acc_id','$code21')";
									$conn->query($add_sub_acount);
								}
							}
						$sql3 = "SELECT * FROM invoice";
						$result3 = $conn->query($sql3);
						$tot = $result3->num_rows;

						$sql8 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
						$result8 = $conn->query($sql8);
						$row8 = $result8->fetch_assoc();

						$pid = $row8["id"];

						$sql8 = "INSERT INTO mod_details (enq_no,po_no,user_id,control,update_details,datetime) VALUES ('$id','$pid','$user','3','1','$time')";
						$conn->query($sql8);

						$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;

						$sql1 = "INSERT INTO invoice (invid,rfqid,term,total,gst_value,tds_value,current,date,pid,divi) VALUES ('$invid','$rfqid','$pterm','$value','$gst_value','$tds_value','0','$today','$projid','$divi')";
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
					}else{
						header("location: all-projects.php?msg=$sql2");
					}
					$i++;
				}
			}
		}
		else /*Single SCope*/
		{
			$sql1 = "DELETE FROM project WHERE id='$proid'";
			if($conn->query($sql1) === TRUE)
			{
				$sql4 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
				$result4 = $conn->query($sql4);
				$row4 = $result4->fetch_assoc();
				$last_proid = $row4["proid"] ;
			        $sum = explode('-', $last_proid); 
	                $sum = explode('_', $sum[2]); 
	                $sum = $sum[0];
					$sum = (int)$sum;
	                $sum  = $sum += 1;

				$sid = $row["id"];

				$divi = $_POST["divi"][0];
				$value = $_POST["value"][0];
				$gst_value = $_POST["gst_value"][0];
				$tds_value = $_POST["value"][0]*10/100;
				$pterm = $_POST["pterms"][0];
				$type = $_POST["type"][0];
				$po = $_POST["po"][0];
				$link = $_POST["link"][0];
				$noofm = $_POST["noofm"][0];

				$first = substr($divi, 0, 3);
				$second = substr($type, 0, 3);

				if($noofm == "")
				{
					$noofm = 0;
				}
				// OIL & GAS //
				if($first == "OIL"){
					$first = "O&G";
				}
				// OIL & GAS //
				
				// convert number with zeros eg:00010
				$proname = sprintf('%04d',$sum);

				$projid = strtoupper($first)."-".strtoupper($second)."-".$proname;
              
				$sql2 = "INSERT INTO project (eid,logo,subdivi,finalq,value,gst_value,pterms,noofm,status,nostatus,scope,proid,divi,scope_type,po_status,open_status,exp_date,inv) VALUES ('$id','$url','$type','$finalq','$value','$gst_value','$pterm','$noofm','$status','1','$scope_id','$projid','$divi','1','$po_status','$open_status','$exp_date','1')";
				if($conn->query($sql2) === TRUE)
				{
					$sql20 = "SELECT id FROM account ORDER BY id DESC LIMIT 1";
									$result20 = $conn->query($sql20);
									$row20 = $result20->fetch_assoc();
									$code = $row20['id'];

					$client_name = $row['cname'];
					$division_name = $row['rfq'];
					$project_name = $row['name'];

					

					$client_id_sql = "SELECT * FROM main WHERE name = '$client_name'";
					$client_id_result = $conn->query($client_id_sql);
					$client_id_row = mysqli_fetch_array($client_id_result);
					$client_id = $client_id_row['id'];
					
					$division_sql = "SELECT * FROM division WHERE division = '$division_name'";
					$division_result = $conn->query($division_sql);
					$division_row = mysqli_fetch_array($division_result);
					$division_id =  $division_row['id'];

					$account_sql = "SELECT * FROM account WHERE name = '$client_name'";
					$account_result = $conn->query($account_sql);
					if($account_result->num_rows > 0){
						$main_acc_id_sql = "SELECT * FROM account WHERE name = '$client_name'";
							$main_acc_id_result = $conn->query($main_acc_id_sql);
							$main_acc_id_row = mysqli_fetch_array($main_acc_id_result);
							$main_acc_id =  $main_acc_id_row['id'];


							$add_sub_acount = "INSERT INTO account (name,type,account_id,divi,sub, code) VALUES('$project_name',2,'$projid','$division_id','$main_acc_id','$code')";
							$conn->query($add_sub_acount);
					}else{
						$add_acount = "INSERT INTO account (name,type,account_id,divi, code) VALUES('$client_name',2,'$client_id','$division_id', '$code')";
						if($conn->query($add_acount))
						{
							$sql21 = "SELECT id FROM account ORDER BY id DESC LIMIT 1";
							$result21 = $conn->query($sql21);
							$row21 = $result21->fetch_assoc();
							$code21 = $row21['id'];

							$main_acc_id_sql = "SELECT * FROM account WHERE name = '$client_name'";
							$main_acc_id_result = $conn->query($main_acc_id_sql);
							$main_acc_id_row = mysqli_fetch_array($main_acc_id_result);
							$main_acc_id =  $main_acc_id_row['id'];
							$add_sub_acount = "INSERT INTO account (name,type,account_id,divi,sub, code) VALUES('$project_name',2,'$projid','$division_id','$main_acc_id', '$code21')";
							$conn->query($add_sub_acount);
						}
					}
					$sql3 = "SELECT * FROM invoice";
					$result3 = $conn->query($sql3);
					$tot = $result3->num_rows;

					$sql8 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
					$result8 = $conn->query($sql8);
					$row8 = $result8->fetch_assoc();

					$pid = $row8["id"];

					$sql8 = "INSERT INTO mod_details (enq_no,po_no,user_id,control,update_details,datetime) VALUES ('$id','$pid','$user','3','1','$time')";
					$conn->query($sql8);

					$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;

					$sql1 = "INSERT INTO invoice (invid,rfqid,term,total,gst_value,tds_value,current,date,pid,divi) VALUES ('$invid','$rfqid','$pterm','$value','$gst_value','$tds_value','0','$today','$projid','$divi')";
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
				}else{
					header("location:new-project.php?msg=Failed");
				}
			}
			else
			{
				$divi = $_POST["divi"][0];
				$value = $_POST["value"][0];
				$gst_value = $_POST["gst_value"][0];
				$tds_value = $_POST["value"][0]*10/100;
				$pterm = $_POST["pterms"][0];
				$type = $_POST["type"][0];
				$po = $_POST["po"][0];
				$link = $_POST["link"][0];
				$noofm = $_POST["noofm"][0];
	
				if($noofm == "")
				{
					$noofm = 0;
				}
	
				$sql4 = "SELECT * FROM project ORDER BY id DESC LIMIT 1";
				$result4 = $conn->query($sql4);
				$row4 = $result4->fetch_assoc();
				$sum = $row4["id"] + 1;
	
				$first = substr($divi, 0, 3);
				$second = substr($type, 0, 3);
				// OIL & GAS //
				if($first == "OIL"){
					$first = "O&G";
				}
				// OIL & GAS //
	
				$projid = strtoupper($first)."-".strtoupper($second)."-000".$sum;
	
				$sql2 = "UPDATE project SET dept='$dept',divi='$divi',eid='$id',logo='$url',subdivi='$type',value='$value',gst_value='$gst_value',status='$status',nostatus='1',pterms='$pterm',noofm='$noofm',po='$po',finalq='$link',proid='$projid' WHERE id='$proid'";
				if($conn->query($sql2) === TRUE)
				{
					$sql8 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime) VALUES ('','$proid','','$user','3','1','$time')";
					$conn->query($sql8);
								
					$sql3 = "SELECT * FROM invoice";
					$result3 = $conn->query($sql3);
					$tot = $result3->num_rows;
	
					$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;
	
					$sql1 = "INSERT INTO invoice (invid,rfqid,term,total,gst_value,tds_value,current,date,pid,divi) VALUES ('$invid','$rfqid','$pterm','$value','$gst_value',$tds_value,'0','$today','$projid','$divi')";
					if($conn->query($sql1) === TRUE)
					{	
						$sql11 = "SELECT * FROM invoice WHERE rfqid='$rfqid' LIMIT 1";
						$result11 = $conn->query($sql11);
						$row11 = $result11->fetch_assoc();
						$id11 = $row11["id"];
						
						$sql4 = "INSERT INTO poss (pid,po,polink) VALUES ('$proid','$link','$po')";
						if($conn->query($sql4) === TRUE)
						{
							$sql11 = "SELECT * FROM poss ORDER BY id DESC LIMIT 1";
							$result11 = $conn->query($sql11);
							$row11 = $result11->fetch_assoc();
							$id11 = $row11["id"];
	
							$sql8 = "INSERT INTO mod_details (enq_no,po_no,po,user_id,control,update_details,datetime) VALUES ('$id','$proid','$id11','$user','5','1','$time')";
							$conn->query($sql8);
							header("location:all-projects.php?msg=Project Registered!");
						}
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
		.read_only{
			
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
										<div class="col-sm-1">
											<center><label class="col-form-label">VAT Value</label></center>
										</div>
										<div class="col-sm-2">
											<center><label class="col-form-label">Payment Terms</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Project Type</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Po Link</label></center>
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Po Ref.No</label></center>
										</div>
										<div class="col-sm-1">
										</div>
										<div class="col-sm-1">
											<center><label class="col-form-label">Invoice Dues</label></center>
										</div>
									</div>

									<?php
										if($row['scope_type']==0){
										
										$sql1 = "SELECT * FROM scope WHERE eid='$id'";
										$result1 = $conn->query($sql1);
										$i = 1;
										
											while($row1 = $result1->fetch_assoc())
											{
									?>
										<div class="form-group row m-b30">
											<div class="col-sm-1">
												<center><label class="col-form-label"><?php echo $row1["scope"] ?></label></center>
											</div>
											<div class="col-sm-1">
												<?php
												if($row["rfq"]== "ENGINEERING"){
													$a = "selected";
												}
												if($row["rfq"]=="SIMULATION & ANALYSIS"){
													$b = "selected";
												}
												if($row["rfq"]=="SUSTAINABILITY"){
													$c = "selected";
												}
												if($row["rfq"]=="ACOUSTICS"){
													$e = "selected";
												}
												if($row["rfq"]=="LASER SCANNING"){
													$f = "selected";
												}
												if($row["rfq"]=="OIL & GAS"){
													$g = "selected";
												}
												?>
												<select class="form-control" name="divi[]" id="rfq" required onchange="gets()">
													<option value readonly>Select Division...</option>
													<option <?php echo $a; ?> value="ENGINEERING">ENGINEERING </option>
													<option <?php echo $b; ?> value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
													<option <?php echo $c; ?> value="SUSTAINABILITY">SUSTAINABILITY</option>
													<option <?php echo $e; ?> value="ACOUSTICS">ACOUSTICS</option>
													<option <?php echo $f; ?> value="LASER SCANNING">LASER SCANNING</option>
													<option <?php echo $g; ?> value="OIL & GAS">OIL & GAS</option>
												</select>
											</div>
											<div class="col-sm-1">
												<input  type="number" class="form-control read_only" name="value[]" placeholder="Value" value="<?php echo $row1["value"] ?>" id="value<?php echo $i ?>" onchange="vals(this.value)" value="<?php echo $row1['value'];?>" >
											</div>
											<div class="col-sm-1">
												<input type="number" class="form-control" name="gst_value[]" placeholder="VAT" id="gst_value<?php echo $i ?>" value="<?php echo $row1["gst_value"] ?>" >
											</div>
											<div class="col-sm-2">
												<select class="form-control" name="pterms[]" onclick="fun(this.value,<?php echo $i ?>)">
													<option value="">Select Term</option>
													<option value="1">Milestone Basis</option>
													<option value="2">Monthly Basis</option>
													<option value="3">Prorata Basis</option>
												</select>
											</div>
											<div class="col-sm-1">
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
											$sql9 = "SELECT * FROM scope_list WHERE id='$scope_id'";
											$result9 = $conn->query($sql9);
											$row9 = $result9->fetch_assoc();
											$i = 1;
									?>
										<div class="form-group row m-b30">
											<div class="col-sm-1">
												<center><label class="col-form-label"><?php echo $row9["scope"] ?></label></center>
											</div>
											<div class="col-sm-1">
												<?php
												if($row["rfq"]== "ENGINEERING"){
													$a = "selected";
												}
												if($row["rfq"]=="SIMULATION & ANALYSIS"){
													$b = "selected";
												}
												if($row["rfq"]=="SUSTAINABILITY"){
													$c = "selected";
												}
												if($row["rfq"]=="ACOUSTICS"){
													$e = "selected";
												}
												if($row["rfq"]=="LASER SCANNING"){
													$f = "selected";
												}
												?>
												<select name="divi[]" class="form-control" onchange="gets()">
													<option value readonly>Select Division...</option>
													<option <?php echo $a; ?> value="ENGINEERING">ENGINEERING </option>
													<option <?php echo $b; ?> value="SIMULATION & ANALYSIS">SIMULATION & ANALYSIS</option>
													<option <?php echo $c; ?> value="SUSTAINABILITY">SUSTAINABILITY</option>
													<option <?php echo $e; ?> value="ACOUSTICS">ACOUSTICS</option>
													<option <?php echo $f; ?> value="LASER SCANNING">LASER SCANNING</option>
												</select>
											</div>
											<div class="col-sm-1">
												<input type="number" class="form-control" name="value[]" placeholder="Value" value="<?php echo $row['price'] ?>" id="value1" onchange="vals(this.value)" >
											</div>
											<div class="col-sm-1">
												<input type="number" class="form-control" name="gst_value[]" placeholder="GST" id="gst_value1" value="<?php echo $row['gst_value'] ?>" >
											</div>
											<div class="col-sm-2">
												<select class="form-control" name="pterms[]" onclick="fun(this.value,1)">
													<option value="">Select Term</option>
													<option value="1">Milestone basis</option>
													<option value="2">Monthly basis</option>
													<option value="3">Prorata basis</option>
												</select>
											</div>
											<div class="col-sm-1">
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
												<input type="number" min="1" id="nom1" name="noofm[]" class="form-control" placeholder="Invoice Dues">
											</div>
										</div>		
									<?php
										}
									?>

									<div class="row">
									<label class="col-sm-1 col-form-label">PO Status</label>
										<div class="col-sm-3">
											<select class="form-control" name="po_status" required onchange="checK_open(this.value)">
												<option selected value disabled>Select PO Status</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</div>
										<label class="col-sm-1 col-form-label" id="open_lable" style="display: none">Open PO</label>
										<div class="col-sm-3">
											<select class="form-control" name="open_status" id="open_status" style="display: none" onchange="check_exp(this.value)">
												<option selected value disabled>Select PO Status</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</div>
										<label class="col-sm-1 col-form-label" id="exp_lable" style="display: none">Expiry Date</label>
										<div class="col-sm-3">
											<input type="date" name="exp_date" id="exp_date" style="display: none" class="form-control">
										</div>
									</div>
									</div>
									
									
									<div class="form-group row m-b30 m-t30">

										<label class="col-sm-2 col-form-label">Total PO</label>
										<div class="col-sm-2">
											<input type="Text" id="total" class="form-control" readonly>
										</div>
										<label class="col-sm-2 col-form-label">Total VAT</label>
										<div class="col-sm-2">
											<input type="Text" id="total_gst" class="form-control" readonly>
										</div>

									</div>
									
									<div class="form-group row m-b30 m-t30">
									
										<div class="col-sm-4">
											<label class="col-form-label">Select Status</label>
											<select class="form-control" name="status" required>
												<option value selected disabled>Select Status</option>
												<option value="Hold">Hold</option>
												<option value="Running">Running</option>
												<option value="Commercially Open">Commercially Open</option>
												<option value="Project Closed">Project Closed</option>
												<option value="Commercially Closed">Commercially Closed</option>
											</select>
										</div>

										<div class="col-sm-4">
											<label class="col-form-label">Logo url</label>
											<input type="text" name="url" placeholder="Logo url" class="form-control">
											<!-- <input class="custom-file-input" type="file" name="logo" id="customFile">
											<label class="custom-file-label" for="customFile">Update Client Logo</label> -->
										</div>

										<div class="col-sm-4">
										<label class="col-form-label">Payment dues</label>
											<input class="form-control" type="text" id="invdues" name="invdues" placeholder="Payment dues" value="<?php echo $invdues1 ?>">
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
	$(document).ready(function(){
		var tot = 0;
		var tgst = 0;
		var inc = <?php echo $i; ?>;
		if(inc == 1)
		{
			var z = document.getElementById("value1").value;
			tot = Number(z) + Number(tot);
			var y = document.getElementById("gst_value1").value;
			tgst = Number(y) + Number(tgst);
		}else{
			for(var j=1;j<inc;j++)
			{
				var z = document.getElementById("value"+j).value;
				tot = Number(z) + Number(tot);
				var y = document.getElementById("gst_value"+j).value;
			tgst = Number(y) + Number(tgst);
			}
		}
		document.getElementById("total").value = "₹" + String(tot);
		document.getElementById("total_gst").value = "₹" + String(tgst);
		
	});
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
		if(inc == 1)
		{
			var z = document.getElementById("value1").value;
			tot = Number(z) + Number(tot);
		}else{
			for(var j=1;j<inc;j++)
			{
				var z = document.getElementById("value"+j).value;
				tot = Number(z) + Number(tot);
			}
		}
		document.getElementById("total").value = "₹" + String(tot);
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
