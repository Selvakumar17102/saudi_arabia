<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
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
	<meta name="description" content="VAT Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="VAT Reports | Project Management System" />
	<meta property="og:description" content="VAT Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>VAT Reports | Project Management System</title>
	
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
		.edit-profile .col-form-label{
           color: black;
       }
       table tr {
			border-bottom: 1px solid #dee2e6;
           font-weight: 600;
           color: black;
       }
       table td {
        padding: 5px;
       }
       b{
           font-weight: 900;
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
					<div class="col-sm-12">
                        <h4 class="breadcrumb-title" style="text-align: center;color: #214597;font-size: 30px;font-weight: bold;">VAT Reports</h4>
					</div>
				</div>
				
			</div>	
			<!-- Card -->
			<div class="row head-count m-b30">
				<div class="col-md-6 col-lg-6 col-xl-6 col-sm-6 col-6">
					<div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Invoiced VAT Value
							</h4>
							<span class="wc-stats">
                            SAR <?php
                                    $total_gst_sql = "SELECT sum(demo_gst) AS total_gst FROM invoice WHERE paystatus !='0'";
                                    $total_gst_result   = $conn->query($total_gst_sql);
                                    $total_gst_row      = mysqli_fetch_array($total_gst_result);
                                    echo number_format($total_gst_row['total_gst'],2);  
                                ?>
							</span>		
						</div>				      
					</div>
				</div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-sm-6 col-6">
					<div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
                                Collected VAT Value
							</h4>
							<span class="wc-stats">
                            SAR <?php
                                    $recived_gst_sql = "SELECT sum(current_gst) AS resived_gst FROM invoice WHERE paystatus = 2";
                                    $recived_gst_result   = $conn->query($recived_gst_sql);
                                    $recived_gst_row      = mysqli_fetch_array($recived_gst_result);
                                    echo number_format($recived_gst_row['resived_gst'],2);
                                ?>
							</span>		
							
						</div>				      
					</div>
				</div>
			</div>
			<div class="row">
                <!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
					<div class="card">
                            <center><h5 class="p-1">Client wise VAT breakup</h5></center>
						<div class="card-content">
							<div class="table-responsive">
								<table id="dataTableExample1" class="table table-striped">
									<thead>
										<tr>
											<th style="color: #C54800">S.NO</th>
											<th>Client Name</th>
											<th>Invoiced VAT Value (SAR)</th>
											<th>Collected VAT Value (SAR)</th>
											<th>Outstanding VAT Value (SAR)</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$sql = "SELECT * FROM enquiry WHERE pstatus='AWARDED' GROUP BY cname";
											$result = $conn->query($sql);
											$i=0;
											while($row = mysqli_fetch_array($result)){
												$i++;
												$client_name = $row['cname'];
												$cid_sql = "SELECT * FROM main WHERE name= '$client_name'";
												$cid_result = $conn->query($cid_sql);
												$cid_row = mysqli_fetch_array($cid_result);
												$client_id = $cid_row['id'];
										?>
												<tr>
													<td><?php echo $i;?> </td>
													<td><a href="vat_client_reports.php?client=<?php echo $client_id;?>"><?php echo $client_name;?></a></td>
												
														<?php
															$c_enquiry_sql = "SELECT * FROM enquiry WHERE pstatus='AWARDED' AND cname = '$client_name'";
															$c_enquiry_result = $conn->query($c_enquiry_sql);
															$invoice_vat_value = $collected_vat_value = 0;
															while($c_enquiry_row = mysqli_fetch_array($c_enquiry_result)){
																$eid=[];
																$eid[] = $c_enquiry_row['id'];
																foreach($eid as $key=> $value)
																{
																	$project_sql = "SELECT * FROM project WHERE eid='$value'";
																	$project_result = $conn->query($project_sql);
																	$project_row = mysqli_fetch_array($project_result);
																	$project_id = $project_row['proid'];

																	$total_gst_sql = "SELECT sum(demo_gst) AS total_gst,sum(current_gst) AS resived_gst FROM invoice WHERE pid = '$project_id' AND paystatus !='0'";
																	$total_gst_result   = $conn->query($total_gst_sql);
																	$total_gst_row = mysqli_fetch_array($total_gst_result);
																	$total_gst_value =$total_gst_row['total_gst'];  
																	$total_resived_gst =$total_gst_row['resived_gst'];
																	$invoice_vat_value += $total_gst_value; 
																	$collected_vat_value += $total_resived_gst;
																}
																
															}
														?>
													<td><center>SAR <?php echo number_format($invoice_vat_value,2);?></center></td>
                                                    <td><center>SAR <?php echo number_format($collected_vat_value,2);?></center></td>
                                                    <td><center>SAR <?php echo number_format($invoice_vat_value - $collected_vat_value,2);?></center></td>
												</tr>
										<?php
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