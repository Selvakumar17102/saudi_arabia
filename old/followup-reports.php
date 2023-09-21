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
	<meta name="description" content="Client Follow Up Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Client Follow Up Reports | Project Management System" />
	<meta property="og:description" content="Client Follow Up Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Client Follow Up Reports | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Proposal Follow Up Report</h4>
					</div>
					<div class="col-sm-2">
						<a href="custom-followup.php" style="color: #fff" class="bg-primary btn">Custom Search</a>
					</div>
				</div>

			</div>	
			<!-- Card -->
			<div class="row head-count m-b30">
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a href="client.php" title="View Today Quatation"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Today Follow Up
							</h4>
							<span class="wc-stats">
								<?php $tot1 = "SELECT * FROM enquiry where pstatus = 'FOLLOW UP' AND qdatec = '$date'";
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
					<a href="client.php" title="View Week Quatation"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Weekly Follow Up
							</h4>
							<span class="wc-stats">
								<?php $tend1 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qdatec BETWEEN '$date' AND '$date' + interval 7 day";
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
					<a href="lost.php" title="View Lost"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Lost
							</h4>
							<span class="wc-stats">
								<?php $jobin1 = "SELECT * FROM enquiry WHERE pstatus = 'LOST'";
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
				<!-- <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a href="selected-enquiry.php?id=4" title="View Tender Stage"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Tender Stage
							</h4>
							<span class="wc-stats">
								
							</span>		
						
						</div>				      
					</div><a>
				</div> -->
				<!-- <div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a href="selected-enquiry.php?id=5" title="View Lost Status"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Lost Status
							</h4>
							<span class="wc-stats">
								
							</span>		
							
						</div>				      
					</div></a>
				</div> -->
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<a href="all-projects.php" title="View Awarded"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Awarded
							</h4>
							<span class="wc-stats">
								<?php 
										$drop = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED'";
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
							<h4 style="text-align: center;">Client Follow Up Report's</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table class="table table-striped" style="margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th rowspan="5">DIVISION</th>
											<th rowspan="5">RFQ ID</th>
											<th rowspan="5">Tender</th>
											<th rowspan="5">Job In Hand</th>											
											<th colspan="2">Lost</th>
											<th rowspan="5">Awarded Projects</th>
                                        </tr>
										<tr>
											<th>Tender</th>
											<th>Job In Hand</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php 
										$susfollowup == 0;
										$sustender == 0;
										$susjob == 0;						
										$engfollowup == 0;
										$engtender == 0;
										$engjob == 0;
										$simfollowup == 0;
										$simtender == 0;
										$simjob == 0;
										$lasfollowup == 0;
										$lastender == 0;
										$lasjob == 0;
										$susawd == 0;
										$engawd == 0;
										$simawd == 0;
										$lasawd == 0;
										$suslostender == 0;
										$suslostjob == 0;
										$englostender == 0;
										$englostjob == 0;
										$simlostender == 0;
										$simlostjob == 0;
										$laslostender == 0;
										$laslostjob == 0;										
										
										//SUSTAINABILITY										
										$sql1 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'SUSTAINABILITY'";
										$result1 = $conn->query($sql1);
										$susfollowup = $result1->num_rows;
										
										$sql2 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'SUSTAINABILITY' AND stage = 'Tender'";
										$result2 = $conn->query($sql2);
										$sustender = $result2->num_rows;
										
										$sql3 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'SUSTAINABILITY' AND stage = 'Job In Hand'";
										$result3 = $conn->query($sql3);
										$susjob = $result3->num_rows;
										
										$sql4 = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED' AND division = 'SUSTAINABILITY'";
										$result4 = $conn->query($sql4);
										$susawd = $result4->num_rows;
										
										$sql5 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'SUSTAINABILITY' AND stage = 'Tender'";
										$result5 = $conn->query($sql5);
										$suslostender = $result5->num_rows;
										
										$sql10 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'SUSTAINABILITY' AND stage = 'Job In Hand'";
										$result10 = $conn->query($sql10);
										$suslostjob = $result10->num_rows;
										
										//Engineering
										$sql6 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'ENGINEERING SERVICES'";
										$result6 = $conn->query($sql6);
										$engfollowup = $result6->num_rows;
										
										$sql7 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'ENGINEERING SERVICES' AND stage = 'Tender'";
										$result7 = $conn->query($sql7);
										$engtender = $result7->num_rows;
										
										$sql8 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'ENGINEERING SERVICES' AND stage = 'Job In Hand'";
										$result8 = $conn->query($sql8);
										$engjob = $result8->num_rows;
										
										$sql9 = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED' AND division = 'ENGINEERING SERVICES'";
										$result9 = $conn->query($sql9);
										$engawd = $result9->num_rows;
										
										$sql11 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'ENGINEERING SERVICES' AND stage = 'Tender'";
										$result11 = $conn->query($sql11);
										$englostender = $result11->num_rows;
										
										$sql16 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'ENGINEERING SERVICES' AND stage = 'Job In Hand'";
										$result16 = $conn->query($sql16);
										$englostjob = $result16->num_rows;
										
										//SIMULATION & ANALYSIS SERVICES
										$sql12 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'SIMULATION & ANALYSIS SERVICES'";
										$result12 = $conn->query($sql12);
										$simfollowup = $result12->num_rows;
										
										$sql13 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Tender'";
										$result13 = $conn->query($sql13);
										$simtender = $result13->num_rows;
										
										$sql14 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Job In Hand'";
										$result14 = $conn->query($sql14);
										$simjob = $result14->num_rows;
										
										$sql15 = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED' AND division = 'SIMULATION & ANALYSIS SERVICES'";
										$result15 = $conn->query($sql15);
										$simawd = $result15->num_rows;
										
										$sql17 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Tender'";
										$result17 = $conn->query($sql17);
										$simlostender = $result17->num_rows;
										
										$sql22 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'SIMULATION & ANALYSIS SERVICES' AND stage = 'Job In Hand'";
										$result22 = $conn->query($sql22);
										$simlostjob = $result22->num_rows;
										
										//DEPUTATION
										$sql18 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'DEPUTATION'";
										$result18 = $conn->query($sql18);
										$lasfollowup = $result18->num_rows;
										
										$sql19 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'DEPUTATION' AND stage = 'Tender'";
										$result19 = $conn->query($sql19);
										$lastender = $result19->num_rows;
										
										$sql20 = "SELECT * FROM enquiry WHERE pstatus = 'FOLLOW UP' AND qstatus='SUBMITTED' AND division = 'DEPUTATION' AND stage = 'Job In Hand'";
										$result20 = $conn->query($sql20);
										$lasjob = $result20->num_rows;
										
										$sql121 = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED' AND division = 'DEPUTATION'";
										$result121 = $conn->query($sql121);
										$lasawd = $result121->num_rows;
										
										$sql23 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'DEPUTATION' AND stage = 'Tender'";
										$result23 = $conn->query($sql23);
										$laslostender = $result23->num_rows;
										
										$sql24 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND division = 'DEPUTATION' AND stage = 'Job In Hand'";
										$result24 = $conn->query($sql24);
										$laslostjob = $result24->num_rows;
										?>
										<tr>
											<th>Sustainability</th>
											<?php if($susfollowup != 0) { ?>
											<td><a href="client.php?div=Sustainability" title="View Details"><?php echo $susfollowup ?></a></td>
											<?php } else { ?>
											<td><?php echo $susfollowup ?></td>
											<?php } ?>
											
											<?php if($sustender != 0) { ?>
											<td><a href="client.php?div=Sustainability&stage=tender" title="View Details"><?php echo $sustender ?></a></td>
											<?php } else { ?>
											<td><?php echo $sustender ?></td>
											<?php } ?>
											
											<?php if($susjob != 0) { ?>
											<td><a href="client.php?div=Sustainability&stage=Job In Hand" title="View Details"><?php echo $susjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $susjob ?></td>
											<?php } ?>
											
											<?php if($suslostender != 0) { ?>
											<td><a href="lost.php?div=Sustainability&stage=tender" title="View Details"><?php echo $suslostender ?></a></td>
											<?php } else { ?>
											<td><?php echo $suslostender ?></td>
											<?php } ?>
											
											<?php if($suslostjob != 0) { ?>
											<td><a href="lost.php?div=Sustainability&stage=Job In Hand" title="View Details"><?php echo $suslostjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $suslostjob ?></td>
											<?php } ?>
											
											<?php if($susawd != 0) { ?>
											<td><a href="all-projects.php?div=Sustainability" title="View Details"><?php echo $susawd ?></a></td>
											<?php } else { ?>
											<td><?php echo $susawd ?></td>
											<?php } ?>
											
											
											
											
										</tr>
										<tr>
											<th>Engineering Services</th>
											<?php if($engfollowup != 0) { ?>
											<td><a href="client.php?div=ENGINEERING SERVICES" title="View Details"><?php echo $engfollowup ?></a></td>
											<?php } else { ?>
											<td><?php echo $engfollowup ?></td>
											<?php } ?>
											
											<?php if($engtender != 0) { ?>
											<td><a href="client.php?div=ENGINEERING SERVICES&stage=Tender" title="View Details"><?php echo $engtender ?></a></td>
											<?php } else { ?>
											<td><?php echo $engtender ?></td>
											<?php } ?>
											
											<?php if($engjob != 0) { ?>
											<td><a href="client.php?div=ENGINEERING SERVICES&stage=Job In Hand" title="View Details"><?php echo $engjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $engjob ?></td>
											<?php } ?>
											
											<?php if($englostender != 0) { ?>
											<td><a href="lost.php?div=ENGINEERING SERVICES&stage=Tender" title="View Details"><?php echo $englostender ?></a></td>
											<?php } else { ?>
											<td><?php echo $englostender ?></td>
											<?php } ?>
											
											<?php if($englostjob != 0) { ?>
											<td><a href="lost.php?div=ENGINEERING SERVICES&stage=Job In Hand" title="View Details"><?php echo $englostjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $englostjob ?></td>
											<?php } ?>
											
											<?php if($engawd != 0) { ?>
											<td><a href="all-projects.php?div=ENGINEERING SERVICES" title="View Details"><?php echo $engawd ?></a></td>
											<?php } else { ?>
											<td><?php echo $engawd ?></td>
											<?php } ?>
											
											

											
										</tr>
										<tr>
											<th>Simulation & Analysis Services</th>
											<?php if($simfollowup != 0) { ?>
											<td><a href="client.php?div=Simulation" title="View Details"><?php echo $simfollowup ?></a></td>
											<?php } else { ?>
											<td><?php echo $simfollowup ?></td>
											<?php } ?>
											
											<?php if($simtender != 0) { ?>
											<td><a href="client.php?div=Simulation&stage=Tender" title="View Details"><?php echo $simtender ?></a></td>
											<?php } else { ?>
											<td><?php echo $simtender ?></td>
											<?php } ?>
											
											<?php if($simjob != 0) { ?>
											<td><a href="client.php?div=Simulation&stage=Job in hand" title="View Details"><?php echo $simjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $simjob ?></td>
											<?php } ?>
											
											<?php if($simlostender != 0) { ?>
											<td><a href="lost.php?div=Simulation&stage=Tender" title="View Details"><?php echo $simlostender ?></a></td>
											<?php } else { ?>
											<td><?php echo $simlostender ?></td>
											<?php } ?>
											
											<?php if($simlostjob != 0) { ?>
											<td><a href="lost.php?div=Simulation&stage=Job In Hand" title="View Details"><?php echo $simlostjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $simlostjob ?></td>
											<?php } ?>
											
											<?php if($simawd != 0) { ?>
											<td><a href="all-projects.php?div=Simulation" title="View Details"><?php echo $simawd ?></a></td>
											<?php } else { ?>
											<td><?php echo $simawd ?></td>
											<?php } ?>
											
											
											
										</tr>
										<tr>
											<th>Deputation</th>
											<?php if($lasfollowup != 0) { ?>
											<td><a href="client.php?div=DEPUTATION" title="View Details"><?php echo $lasfollowup ?></a></td>
											<?php } else { ?>
											<td><?php echo $lasfollowup ?></td>
											<?php } ?>
											
											<?php if($lastender != 0) { ?>
											<td><a href="client.php?div=DEPUTATION&stage=Tender" title="View Details"><?php echo $lastender ?></a></td>
											<?php } else { ?>
											<td><?php echo $lastender ?></td>
											<?php } ?>
											
											<?php if($lasjob != 0) { ?>
											<td><a href="client.php?div=DEPUTATION&stage=Job in hand" title="View Details"><?php echo $lasjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $lasjob ?></td>
											<?php } ?>
											
											<?php if($laslostender != 0) { ?>
											<td><a href="lost.php?div=DEPUTATION&stage=tender" title="View Details"><?php echo $laslostender ?></a></td>
											<?php } else { ?>
											<td><?php echo $laslostender ?></td>
											<?php } ?>
											
											<?php if($laslostjob != 0) { ?>
											<td><a href="lost.php?div=DEPUTATION&stage=Job In Hand" title="View Details"><?php echo $laslostjob ?></a></td>
											<?php } else { ?>
											<td><?php echo $laslostjob ?></td>
											<?php } ?>
											
											<?php if($lasawd != 0) { ?>
											<td><a href="all-projects.php?div=DEPUTATION" title="View Details"><?php echo $lasawd ?></a></td>
											<?php } else { ?>
											<td><?php echo $lasawd ?></td>
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