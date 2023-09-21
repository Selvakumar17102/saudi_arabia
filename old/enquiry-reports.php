<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');

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
	<meta name="description" content="Enquiry Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Enquiry Reports | Project Management System" />
	<meta property="og:description" content="Enquiry Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Enquiry Reports | Project Management System</title>
	
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
	.table-striped tr td {text-align: center;}
	.table-striped tr td a{padding: 10px;}
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
					<div class="col-sm-10">
						<h4 class="breadcrumb-title">Enquiry Reports</h4>
					</div>
					<div class="col-sm-2">
						<a href="custom-enquiry.php" style="color: #fff" class="bg-primary btn">Custom Search</a>
					</div>
				</div>
				
			</div>	
			<!-- Card -->
			<div class="row head-count m-b30">
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a href="all-enquiry.php" title="View Total Quatation"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Total Enquiry
							</h4>
							<span class="wc-stats">
								<?php $tot1 = "SELECT * FROM enquiry";
										$tot2 = $conn->query($tot1);
										$tot = $tot2->num_rows;
										if($tot > 0) {
											echo $tot;
										} else {
											echo $tot = 0;
										}
										?>
							</span>		
							
						</div>				      
					</div></a>
				</div>
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a title="Tender Enquiry"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Tender Enquiry
							</h4>
							<span class="wc-stats">
								<?php $tend1 = "SELECT * FROM enquiry WHERE stage = 'Tender'";
										$tend2 = $conn->query($tend1);
										$tend = $tend2->num_rows;
										if($tend > 0) {
											echo $tend;
										} else {
											echo $tend = 0;
										}
										?>
							</span>		
						
						</div>				      
					</div><a>
				</div>
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a title="Job in Hand Enquiry"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Job in Hand Enquiry
							</h4>
							<span class="wc-stats">
								<?php $jobin1 = "SELECT * FROM enquiry WHERE stage = 'Job In Hand'";
										$jobin2 = $conn->query($jobin1);
										$jobin = $jobin2->num_rows;
										if($jobin > 0) {
											echo $jobin;
										} else {
											echo $jobin = 0;
										}
										?>
							</span>		
							
						</div>				      
					</div></a>
				</div>

				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a href="dropped-enquiry.php" title="Dropped Enquiry"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Dropped Enquiry
							</h4>
							<span class="wc-stats">
								<?php 
										$drop = "SELECT * FROM enquiry WHERE qstatus = 'DROPPED'";
										$drop1 = $conn->query($drop);
										$dropp = $drop1->num_rows;
										if($dropp > 0) {
											echo $dropp;
										} else {
											echo $dropp = 0;
										}
										?>
							</span>		
						
						</div>				      
					</div><a>
				</div>
			</div>
			

			<div class="row">
			
				
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
					<div class="card-header">
							<h4 style="text-align: center;">Enquiry Report's</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table class="table table-striped" style="margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">DIVISION</th>
											<th colspan="2">RFQ</th>
											<th colspan="2">Tender Projects</th>
											<th colspan="2">Job In Hand</th>
											<th colspan="2">Not Submitted</th>
                                        </tr>
										<tr>                                           
											<th>Today</th>
											<th><?php echo date('F'); ?></th>
                                                                                  
											<th>Today</th>
											<th><?php echo date('F'); ?></th>
                                                                                   
											<th>Today</th>
											<th><?php echo date('F'); ?></th>
											
											<th>Tender</th>
											<th>Job In Hand</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php 
										$sustoday == 0;
										$sustendertoday == 0;
										$susjobtoday == 0;						
										$engtoday == 0;
										$engtendertoday == 0;
										$engjobtoday == 0;
										$simtoday == 0;
										$simtendertoday == 0;
										$simjobtoday == 0;
										$lastoday == 0;
										$lastendertoday == 0;
										$lasjobtoday == 0;
										$notsubten == 0;
										$notsubjob == 0;
											
										
										//SUSTAINABILITY
										$sql = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'SUSTAINABILITY'";
										$result = $conn->query($sql);
										$sustoday = $result->num_rows;
										
										$sql1 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'SUSTAINABILITY' AND stage = 'Tender'";
										$result1 = $conn->query($sql1);
										$sustendertoday = $result1->num_rows;
										
										$sql2 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'SUSTAINABILITY' AND stage = 'Job In Hand'";
										$result2 = $conn->query($sql2);
										$susjobtoday = $result2->num_rows;
										
										$sql3 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'SUSTAINABILITY'";
										$result3 = $conn->query($sql3);
										$susmon1 = $result3->num_rows;
										if($susmon1 > 0) {										
											$susmon = $susmon1;
										} else {
											$susmon = 0;
										}
										
										$sql4 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'SUSTAINABILITY' AND stage = 'Tender'";
										$result4 = $conn->query($sql4);
										$sustendermon1 = $result4->num_rows;
										if($sustendermon1 > 0) {
											$sustendermon = $sustendermon1;
										} else {
											$sustendermon = 0;
										}
										
										$sql5 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'SUSTAINABILITY' AND stage = 'Job In Hand'";
										$result5 = $conn->query($sql5);
										$susjobmon1 = $result5->num_rows;
										if($susjobmon1 > 0) {
											$susjobmon = $susjobmon1;
										} else {
											$susjobmon = 0;
										}
										
										//Engineering
										$sql6 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'ENGINEERING SERVICES'";
										$result6 = $conn->query($sql6);
										$engtoday = $result6->num_rows;
										
										$sql7 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'ENGINEERING SERVICES' AND stage = 'Tender'";
										$result7 = $conn->query($sql7);
										$engtendertoday = $result7->num_rows;
										
										$sql8 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'ENGINEERING SERVICES' AND stage = 'Job In Hand'";
										$result8 = $conn->query($sql8);
										$engjobtoday = $result8->num_rows;
										
										$sql9 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'ENGINEERING SERVICES'";
										$result9 = $conn->query($sql9);
										$engmon1 = $result9->num_rows;
										if($engmon1 > 0) {
											$engmon = $engmon1;
										} else {
											$engmon = 0;
										}
										
										$sql10 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'ENGINEERING SERVICES' AND stage = 'Tender'";
										$result10 = $conn->query($sql10);
										$engtendermon1 = $result10->num_rows;
										if($engtendermon1 > 0) {
											$engtendermon = $engtendermon1;
										} else {
											$engtendermon = 0;
										}
										
										$sql11 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'ENGINEERING SERVICES' AND stage = 'Job In Hand'";
										$result11 = $conn->query($sql11);
										$engjobmon1 = $result11->num_rows;
										if($engjobmon1 > 0) {
											$engjobmon = $engjobmon1;
										} else {
											$engjobmon = 0;
										}
										
										//SIMULATION & ANALYSIS SERVICES
										$sql12 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'SIMULATION & ANALYSIS SERVICES'";
										$result12 = $conn->query($sql12);
										$simtoday = $result12->num_rows;
										
										$sql13 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Tender'";
										$result13 = $conn->query($sql13);
										$simtendertoday = $result13->num_rows;
										
										$sql14 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Job In Hand'";
										$result14 = $conn->query($sql14);
										$simjobtoday = $result14->num_rows;
										
										$sql15 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'SIMULATION & ANALYSIS SERVICES'";
										$result15 = $conn->query($sql15);
										$simmon1 = $result15->num_rows;
										if($simmon1 > 0) {
											$simmon = $simmon1;
										} else {
											$simmon = 0;
										}
										
										$sql16 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Tender'";
										$result16 = $conn->query($sql16);
										$simtendermon1 = $result16->num_rows;
										if($simtendermon1 > 0) {
											$simtendermon = $simtendermon1;
										} else {
											$simtendermon = 0;
										}
										
										$sql17 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Job In Hand'";
										$result17 = $conn->query($sql17);
										$simjobmon1 = $result17->num_rows;
										if($simjobmon1 > 0) {
											$simjobmon = $simjobmon1;
										} else {
											$simjobmon = 0;
										}
										
										//DEPUTATION
										$sql18 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'DEPUTATION'";
										$result18 = $conn->query($sql18);
										$lastoday = $result18->num_rows;
										
										$sql19 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'DEPUTATION' AND stage = 'Tender'";
										$result19 = $conn->query($sql19);
										$lastendertoday = $result19->num_rows;
										
										$sql20 = "SELECT * FROM enquiry WHERE enqdate = '$date' AND division = 'DEPUTATION' AND stage = 'Job In Hand'";
										$result20 = $conn->query($sql20);
										$lasjobtoday = $result20->num_rows;
										
										$sql21 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'DEPUTATION'";
										$result21 = $conn->query($sql21);
										$lasmon1 = $result21->num_rows;
										if($lasmon1 > 0) {
											$lasmon = $lasmon1;
										} else {
											$lasmon = 0;
										}
										
										$sql22 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'DEPUTATION' AND stage = 'Tender'";
										$result22 = $conn->query($sql22);
										$lastendermon1 = $result22->num_rows;
										if($lastendermon1 > 0) {
											$lastendermon = $lastendermon1;
										} else {
											$lastendermon = 0;
										}
										
										$sql23 = "SELECT * FROM enquiry WHERE MONTH(enqdate) = MONTH(CURRENT_DATE()) AND YEAR(enqdate) = YEAR(CURRENT_DATE()) AND division = 'DEPUTATION' AND stage = 'Job In Hand'";
										$result23 = $conn->query($sql23);
										$lasjobmon1 = $result23->num_rows;
										if($lasjobmon1 > 0) {
											$lasjobmon = $lasjobmon1;
										} else {
											$lasjobmon = 0;
										}
										
										//NOT SUBMITTED ENQUIRY
										$sql24 = "SELECT * FROM enquiry WHERE division = 'SUSTAINABILITY' AND stage = 'Tender' AND qstatus = 'NOT SUBMITTED'";
										$result24 = $conn->query($sql24);
										$notsubsusten = $result24->num_rows;
										
										$sql25 = "SELECT * FROM enquiry WHERE division = 'ENGINEERING SERVICES' AND stage = 'Tender' AND qstatus = 'NOT SUBMITTED'";
										$result25 = $conn->query($sql25);
										$notsubengten = $result25->num_rows;
										
										$sql26 = "SELECT * FROM enquiry WHERE division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Tender' AND qstatus = 'NOT SUBMITTED'";
										$result26 = $conn->query($sql26);
										$notsubsimten = $result26->num_rows;
										
										$sql27 = "SELECT * FROM enquiry WHERE division = 'DEPUTATION' AND stage = 'Tender' AND qstatus = 'NOT SUBMITTED'";
										$result27 = $conn->query($sql27);
										$notsublasten = $result27->num_rows;
										
										$sql28 = "SELECT * FROM enquiry WHERE division = 'SUSTAINABILITY' AND stage = 'Job In Hand' AND qstatus = 'NOT SUBMITTED'";
										$result28 = $conn->query($sql28);
										$notsubsusjob = $result28->num_rows;
										
										$sql29 = "SELECT * FROM enquiry WHERE division = 'ENGINEERING SERVICES' AND stage = 'Job In Hand' AND qstatus = 'NOT SUBMITTED'";
										$result29 = $conn->query($sql29);
										$notsubengjob = $result29->num_rows;
										
										$sql30 = "SELECT * FROM enquiry WHERE division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Job In Hand' AND qstatus = 'NOT SUBMITTED'";
										$result30 = $conn->query($sql30);
										$notsubsimjob = $result30->num_rows;
										
										$sql31 = "SELECT * FROM enquiry WHERE division = 'DEPUTATION' AND stage = 'Job In Hand' AND qstatus = 'NOT SUBMITTED'";
										$result31 = $conn->query($sql31);
										$notsublasjob = $result31->num_rows;
										
										?>
										<tr>
											<th>Sustainability</th>
											<?php if($sustoday != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&date=today" title="View Enquiry Details"><?php echo $sustoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $sustoday ?></td>
											<?php } ?>
											
											<?php if($susmon != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $susmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $susmon ?></td>
											<?php } ?>
											
											<?php if($sustendertoday != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&stage=Tender&date=today" title="View Enquiry Details"><?php echo $sustendertoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $sustendertoday ?></td>
											<?php } ?>
											
											<?php if($sustendermon != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&stage=Tender&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $sustendermon ?></a></td>
											<?php } else { ?>
											<td><?php echo $sustendermon ?></td>
											<?php } ?>
											
											<?php if($susjobtoday != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&stage=Job In Hand&date=today" title="View Enquiry Details"><?php echo $susjobtoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $susjobtoday ?></td>
											<?php } ?>
											
											<?php if($susjobmon != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&stage=Job In Hand&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $susjobmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $susjobmon ?></td>
											<?php } ?>
											
											<?php if($notsubsusten != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&stage=Tender" title="View Enquiry Details"><?php echo $notsubsusten ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsubsusten ?></td>
											<?php } ?>
											
											<?php if($notsubsusjob != 0) { ?>
											<td><a href="enquiry.php?div=Sustainability&stage=Job In Hand" title="View Enquiry Details"><?php echo $notsubsusjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsubsusjob ?></td>
											<?php } ?>
											
										</tr>
										<tr>
											<th>Engineering Services</th>
											<?php if($engtoday != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&date=today" title="View Enquiry Details"><?php echo $engtoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $engtoday ?></td>
											<?php } ?>
											
											<?php if($engmon != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $engmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $engmon ?></td>
											<?php } ?>
											
											<?php if($engtendertoday != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&stage=Tender&date=today" title="View Enquiry Details"><?php echo $engtendertoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $engtendertoday ?></td>
											<?php } ?>
											
											<?php if($engtendermon != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&stage=Tender&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $engtendermon ?></a></td>
											<?php } else { ?>
											<td><?php echo $engtendermon ?></td>
											<?php } ?>
											
											<?php if($engjobtoday != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&stage=Job In Hand&date=today" title="View Enquiry Details"><?php echo $engjobtoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $engjobtoday ?></td>
											<?php } ?>
											
											<?php if($engjobmon != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&stage=Job In Hand&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $engjobmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $engjobmon ?></td>
											<?php } ?>
											
											<?php if($notsubengten != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&stage=Tender" title="View Enquiry Details"><?php echo $notsubengten ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsubengten ?></td>
											<?php } ?>
											
											<?php if($notsubengjob != 0) { ?>
											<td><a href="enquiry.php?div=Engineering&stage=Job In Hand" title="View Enquiry Details"><?php echo $notsubengjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsubengjob ?></td>
											<?php } ?>
											
										</tr>
										<tr>
											<th>Simulation & Analysis Services</th>
											<?php if($simtoday != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&date=today" title="View Enquiry Details"><?php echo $simtoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $simtoday ?></td>
											<?php } ?>
											
											<?php if($simmon != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $simmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $simmon ?></td>
											<?php } ?>
											
											<?php if($simtendertoday != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&stage=Tender&date=today" title="View Enquiry Details"><?php echo $simtendertoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $simtendertoday ?></td>
											<?php } ?>
											
											<?php if($simtendermon != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&stage=Tender&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $simtendermon ?></a></td>
											<?php } else { ?>
											<td><?php echo $simtendermon ?></td>
											<?php } ?>
											
											<?php if($simjobtoday != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&stage=Job In Hand&date=today" title="View Enquiry Details"><?php echo $simjobtoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $simjobtoday ?></td>
											<?php } ?>
											
											<?php if($simjobmon != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&stage=Job In Hand&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $simjobmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $simjobmon ?></td>
											<?php } ?>
											
											<?php if($notsubsimten != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&stage=Tender" title="View Enquiry Details"><?php echo $notsubsimten ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsubsimten ?></td>
											<?php } ?>
											
											<?php if($notsubsimjob != 0) { ?>
											<td><a href="enquiry.php?div=Simulation&stage=Job In Hand" title="View Enquiry Details"><?php echo $notsubsimjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsubsimjob ?></td>
											<?php } ?>
											
										</tr>
										<tr>
											<th>Deputation</th>
											<?php if($lastoday != 0) { ?>
											<td><a href="enquiry.php?div=Depu&date=today" title="View Enquiry Details"><?php echo $lastoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $lastoday ?></td>
											<?php } ?>
											
											<?php if($lasmon != 0) { ?>
											<td><a href="enquiry.php?div=Depu&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $lasmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $lasmon ?></td>
											<?php } ?>
											
											<?php if($lastendertoday != 0) { ?>
											<td><a href="enquiry.php?div=Depu&stage=Tender&date=today" title="View Enquiry Details"><?php echo $lastendertoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $lastendertoday ?></td>
											<?php } ?>
											
											<?php if($lastendermon != 0) { ?>
											<td><a href="enquiry.php?div=Depu&stage=Tender&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $lastendermon ?></a></td>
											<?php } else { ?>
											<td><?php echo $lastendermon ?></td>
											<?php } ?>
											
											<?php if($lasjobtoday != 0) { ?>
											<td><a href="enquiry.php?div=Depu&stage=Job In Hand&date=today" title="View Enquiry Details"><?php echo $lasjobtoday ?></a></td>
											<?php } else { ?>
											<td><?php echo $lasjobtoday ?></td>
											<?php } ?>
											
											<?php if($lasjobmon != 0) { ?>
											<td><a href="enquiry.php?div=Depu&stage=Job In Hand&date=<?php echo date('F'); ?>" title="View Enquiry Details"><?php echo $lasjobmon ?></a></td>
											<?php } else { ?>
											<td><?php echo $lasjobmon ?></td>
											<?php } ?>
											
											<?php if($notsublasten != 0) { ?>
											<td><a href="enquiry.php?div=Depu&stage=Tender" title="View Enquiry Details"><?php echo $notsublasten ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsublasten ?></td>
											<?php } ?>
											
											<?php if($notsublasjob != 0) { ?>
											<td><a href="enquiry.php?div=Depu&stage=Job In Hand" title="View Enquiry Details"><?php echo $notsublasjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $notsublasjob ?></td>
											<?php } ?>

										</tr>
									   
										
									</tbody>
                                </table>
                            </div>
							
                        
                    </div>
                </div>
				
			</div>
			
                   
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
<script src='assets/vendors/calendar/moment.min.js'></script>
<script src='assets/vendors/calendar/fullcalendar.js'></script>
<script>
// Start of jquery datatable
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
</script>
</body>
</html>