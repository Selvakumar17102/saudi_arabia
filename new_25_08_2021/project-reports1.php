<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');
	$totawd == 0;
	$totpro == 0;
	$totdep == 0;
		$totawd1 = "SELECT * FROM project";
		$totawd2 = $conn->query($totawd1);
		$totawd = $totawd2->num_rows;
		
		$totpro1 = "SELECT * FROM project WHERE subdivi = 'Project'";
		$totpro2 = $conn->query($totpro1);
		$totpro = $totpro2->num_rows;
		
		$totdep1 = "SELECT * FROM project WHERE subdivi = 'Deputation'";
		$totdep2 = $conn->query($totdep1);
		$totdep = $totdep2->num_rows;

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
	<meta name="description" content="Project Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Project Reports | Project Management System" />
	<meta property="og:description" content="Project Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Project Reports | Project Management System</title>
	
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
				<h4 class="breadcrumb-title">Project Report</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
					<li>Reports</li>
				</ul>
				
			</div>	
			<!-- Card -->
			<div class="row head-count m-b30">

				<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
					<a href="project-selected.php?id=1" title="Running Projects"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Running
							</h4>
							<span class="wc-stats">
								<?php $tot1 = "SELECT * FROM project where status = 'Running'";
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

				<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
					<a href="project-selected.php?id=2" title="Commercially Open Projects"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Commercially Open
							</h4>
							<span class="wc-stats">
								<?php $tend1 = "SELECT * FROM project where status = 'Commercially Open'";
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

				<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
					<a href="project-selected.php?id=3" title="Closed Projects"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Closed
							</h4>
							<span class="wc-stats">
								<?php $jobin1 = "SELECT * FROM project where status = 'Closed'";
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
				
			</div>
			

			<div class="row">
			
				
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
					<div class="card-header">
							<h4 style="text-align: center;">Project Reports</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table class="table table-striped" style="margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th rowspan="5">DIVISION</th>
											<th colspan="2">Total Awarded Projects (<?php echo $totawd; ?>)</th>
											<th rowspan="5">Running</th>
											<th rowspan="5">Commercially Open</th>											
											<th rowspan="5">Closed</th>
                                        </tr>
										<tr>
											<th>Project (<?php echo $totpro; ?>)</th>
											<th>Deputation (<?php echo $totdep; ?>)</th>
                                        </tr>
										
                                    </thead>
									<tbody>
										<?php
											$sp = $sd = $sr = $sc = $scl = 0;
											$ep = $ed = $er = $ec = $ecl = 0;
											$sap = $sad = $sar = $sac = $sacl = 0;
											$lp = $ld = $lr = $lc = $lcl = 0;
											$sql = "SELECT * FROM project";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc())
											{
												$eid = $row["eid"];
												$subdivi = $row["subdivi"];
												$status = $row["status"];

												$sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();

												$divi = $row1["division"];

												if($divi == "SUSTAINABILITY")
												{
													if($subdivi == "Project")
													{
														$sp++;
													}
													else
													{
														$sd++;
													}
													if($status == "Running")
													{
														$sr++;
													}
													if($status == "Commercially Open")
													{
														$sc++;
													}
													if($status == "Closed")
													{
														$scl++;
													}
												}
												if($divi == "ENGINEERING SERVICES")
												{
													if($subdivi == "Project")
													{
														$ep++;
													}
													else
													{
														$ed++;
													}
													if($status == "Running")
													{
														$er++;
													}
													if($status == "Commercially Open")
													{
														$ec++;
													}
													if($status == "Closed")
													{
														$ecl++;
													}
												}
												if($divi == "SIMULATION & ANALYSIS SERVICES")
												{
													if($subdivi == "Project")
													{
														$sap++;
													}
													else
													{
														$sad++;
													}
													if($status == "Running")
													{
														$sar++;
													}
													if($status == "Commercially Open")
													{
														$sac++;
													}
													if($status == "Closed")
													{
														$sacl++;
													}
												}
												if($divi == "LASER SCANNING SERVICES")
												{
													if($subdivi == "Project")
													{
														$lp++;
													}
													else
													{
														$ld++;
													}
													if($status == "Running")
													{
														$lr++;
													}
													if($status == "Commercially Open")
													{
														$lc++;
													}
													if($status == "Closed")
													{
														$lcl++;
													}
												}
											}
										?>
										<tr>
											<th>Sustainability</th>
											<td><?php if($sp != 0){ ?><a href="project-selected2.php?id=1&mid=1"><?php echo $sp ?></a><?php }else echo $sp ?></td>
											<td><?php if($sd != 0){ ?><a href="project-selected2.php?id=2&mid=1"><?php echo $sd ?></a><?php }else echo $sd ?></td>
											<td><?php if($sr != 0){ ?><a href="project-selected.php?id=1&mid=1"><?php echo $sr ?></a><?php }else echo $sr ?></td>
											<td><?php if($sc != 0){ ?><a href="project-selected.php?id=2&mid=1"><?php echo $sc ?></a><?php }else echo $sc ?></td>
											<td><?php if($scl != 0){ ?><a href="project-selected.php?id=3&mid=1"><?php echo $scl ?></a><?php }else echo $scl ?></td>
										</tr>
										<tr>
											<th>Engineering Services</th>
											<td><?php if($ep != 0){ ?><a href="project-selected2.php?id=1&mid=2"><?php echo $ep ?></a><?php }else echo $ep ?></td>
											<td><?php if($ed != 0){ ?><a href="project-selected2.php?id=2&mid=2"><?php echo $ed ?></a><?php }else echo $ed ?></td>
											<td><?php if($er != 0){ ?><a href="project-selected.php?id=1&mid=2"><?php echo $er ?></a><?php }else echo $er ?></td>
											<td><?php if($ec != 0){ ?><a href="project-selected.php?id=2&mid=2"><?php echo $ec ?></a><?php }else echo $ec ?></td>
											<td><?php if($ecl != 0){ ?><a href="project-selected.php?id=3&mid=2"><?php echo $ecl ?></a><?php }else echo $ecl ?></td>
										</tr>
										<tr>
											<th>Simulation & Analysis Services</th>
											<td><?php if($sap != 0){ ?><a href="project-selected2.php?id=1&mid=3"><?php echo $sap ?></a><?php }else echo $sap ?></td>
											<td><?php if($sad != 0){ ?><a href="project-selected2.php?id=2&mid=3"><?php echo $sad ?></a><?php }else echo $sad ?></td>
											<td><?php if($sar != 0){ ?><a href="project-selected.php?id=1&mid=3"><?php echo $sar ?></a><?php }else echo $sar ?></td>
											<td><?php if($sac != 0){ ?><a href="project-selected.php?id=2&mid=3"><?php echo $sac ?></a><?php }else echo $sac ?></td>
											<td><?php if($sacl != 0){ ?><a href="project-selected.php?id=3&mid=3"><?php echo $sacl ?></a><?php }else echo $sacl ?></td>
										</tr>
										<tr>
											<th>Laser Scanning Services</th>
											<td><?php if($lp != 0){ ?><a href="project-selected2.php?id=1&mid=4"><?php echo $lp ?></a><?php }else echo $lp ?></td>
											<td><?php if($ld != 0){ ?><a href="project-selected2.php?id=2&mid=4"><?php echo $ld ?></a><?php }else echo $ld ?></td>
											<td><?php if($lr != 0){ ?><a href="project-selected.php?id=1&mid=4"><?php echo $lr ?></a><?php }else echo $lr ?></td>
											<td><?php if($lc != 0){ ?><a href="project-selected.php?id=2&mid=4"><?php echo $lc ?></a><?php }else echo $lc ?></td>
											<td><?php if($lcl != 0){ ?><a href="project-selected.php?id=3&mid=4"><?php echo $lcl ?></a><?php }else echo $lcl ?></td>
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