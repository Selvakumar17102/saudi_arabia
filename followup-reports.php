<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

	$date = date("Y-m-d");
	$month = date('m');

    $starting_date = date("Y-m-01");
	$ending_date = date("Y-m-t");

    $division = array('ENGINEERING','SIMULATION & ANALYSIS','SUSTAINABILITY','ACOUSTICS','LASER SCANNING','OIL & GAS');
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
    .edit-profile .col-form-label{
           color: black;
       }
       table tr{
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
					<div class="col-sm-10">
						<h4 class="breadcrumb-title">Proposal Follow Up Report</h4>
					</div>
					<div class="col-sm-2">
						<a href="custome-followup-reports.php" style="color: #fff" class="bg-primary btn">Custom Search</a>
					</div>
				</div>

			</div>	
			<!-- Card -->
			<div class="row head-count m-b30">
				<div class="col-md-1 col-lg-1 col-xl-1 col-sm-1 col-1"></div>
				<div class="col-md-6 col-lg-2 col-xl-2 col-sm-6 col-12">
					<a href="total-proposal-report.php?type=1" title="View Total Proposal"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Total Proposal
							</h4>
							<span class="wc-stats">
								<?php
									$tot1 = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND new_status='1'";
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
				<div class="col-md-6 col-lg-2 col-xl-2 col-sm-6 col-12">
					<a href="total-proposal-report.php?type=2" title="View Tender"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Tender
							</h4>
							<span class="wc-stats">
								<?php 
									$tend1 = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND new_status='1' AND stage='Tender'";
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
				<div class="col-md-6 col-lg-2 col-xl-2 col-sm-6 col-12">
					<a href="total-proposal-report.php?type=3" title="View Job In Hand"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Job In Hand
							</h4>
							<span class="wc-stats">
								<?php 
									$jobin1 = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND new_status='1' AND stage='Job In Hand'";
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
				<div class="col-md-6 col-lg-2 col-xl-2 col-sm-6 col-12">
					<a href="total-proposal-report.php?type=4" title="View Awarded"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Awarded
							</h4>
							<span class="wc-stats">
								<?php 
									$award = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED' AND new_status='1'";
									$award1 = $conn->query($award);
									$award = $award1->num_rows;
									if($award > 0) {
										echo $award;
									} else {
										echo $award = 0;
									}
								?>
							</span>
						</div>				      
					</div><a>
				</div>
				<div class="col-md-6 col-lg-2 col-xl-2 col-sm-6 col-12">
					<a href="total-proposal-report.php?type=5" title="View Lost"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Lost
							</h4>
							<span class="wc-stats">
								<?php 
									$drop = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND new_status='1'";
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
				<div class="col-md-1 col-lg-1 col-xl-1 col-sm-1 col-1"></div>
			</div>		
            <div class="row">
                <!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
                	    <div class="row" style="margin-bottom:30px;margin-left: 25px;margin-right: 25px;">
                            <div class="col-sm-12">
                            <div class="row" style="margin-bottom:30px;margin-left: 25px;margin-right: 25px;">
                                <div class="col-sm-12">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td rowspan="3"><center><b>Division</center></b></td>
                                                <td colspan="10"><center><b>Proposal</center></b></td>
                                                
                                            </tr>
                                            <tr>
                                                
                                                <td colspan="2"><center><b>Total</b></center></td>
                                                <td colspan="2"><center><b>This Month</b></center></td>
                                                <td colspan="2"><center><b>Follow Up</b></center></td>
												<td colspan="2"><center><b>Awarded</center></b></td>
                                                <td colspan="2"><center><b>Lost</center></b></td>
                                               
                                            </tr>
                                            <tr>
                                                <td><center><b>Tender</b></center></td>
                                                <td><center><b>Job In Hand</b></center></td>
                                                <td><center><b>Tender</b></center></td>
                                                <td><center><b>Job In Hand</b></center></td>
                                                <td><center><b>Tender</b></center></td>
                                                <td><center><b>Job In Hand</b></center></td>
												<td><center><b>Total</b></center></td>
                                                <td><center><b>This Month</b></center></td>
                                                <td><center><b>Total</b></center></td>
                                                <td><center><b>This Month</b></center></td>
                                            </tr>
                                            <?php
                                                for($i=0;$i < count($division);$i++)
                                                {
                                                    $my_division = $division[$i];

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_Proposal_Tenders = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Job In Hand' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_Proposal_Job_In_Hand = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Tender' AND enqdate BETWEEN '$starting_date' AND '$ending_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $This_Month_Proposal_Tenders = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND stage='Job In Hand' AND enqdate BETWEEN '$starting_date' AND '$ending_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $This_Month_Proposal_Job_In_Hand = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND  stage='Tender' AND pstatus='FOLLOW UP' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_FollowUp_Tenders = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND pstatus='FOLLOW UP' AND new_status='1' AND qstatus!='DROPPED'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_FollowUp_Job_In_Hand = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND pstatus='AWARDED' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_Award = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND pstatus='AWARDED' AND qstatus='SUBMITTED' AND enqdate BETWEEN '$starting_date' AND '$ending_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Month_Total_Award = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND pstatus='LOST' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Total_Lost = $result1->num_rows;

                                                    $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND qstatus='SUBMITTED' AND pstatus='LOST' AND qdatec BETWEEN '$starting_date' AND '$ending_date' AND new_status='1'";
                                                    $result1 = $conn->query($sql1);
                                                    $Month_Total_Lost = $result1->num_rows;

                                                    ?>
                                                        <tr>
                                                            <td><center><?php echo $my_division;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=1&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Total_Proposal_Tenders;?></a></center></td>
                                                            <td><center><a href="project-details-report.php?type=2&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Total_Proposal_Job_In_Hand;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=3&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $This_Month_Proposal_Tenders;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=4&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $This_Month_Proposal_Job_In_Hand;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=5&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Total_FollowUp_Tenders;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=6&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Total_FollowUp_Job_In_Hand;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=7&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Total_Award;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=8&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Month_Total_Award;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=9&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Total_Lost;?></center></td>
                                                            <td><center><a href="project-details-report.php?type=10&division=<?php echo rawurlencode(urldecode($my_division));?>"><?php echo $Month_Total_Lost;?></center></td>
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