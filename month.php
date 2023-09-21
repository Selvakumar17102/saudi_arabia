<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");
    
    $month = $_REQUEST["month"];
	$monthname="";
	if($month == "01"){
	$monthname="January";
	} else if($month == "02"){
	$monthname="February";
	} else if($month == "03"){
	$monthname="March";
	} else if($month == "04"){
	$monthname="April";
	} else if($month == "05"){
	$monthname="May";
	} else if($month == "06"){
	$monthname="June";
	} else if($month == "07"){
	$monthname="July";
	} else if($month == "08"){
	$monthname="August";
	} else if($month == "09"){
	$monthname="September";
	} else if($month == "10"){
	$monthname="October";
	} else if($month == "11"){
	$monthname="November";
	} else if($month == "12"){
	$monthname="December";
	} else {}
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
	<meta name="description" content="Month Report | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Month Report | Income Expense Manager" />
	<meta property="og:description" content="Month Report | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Month Report | Income Expense Manager</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/calendar/fullcalendar.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="assets/css/tabs.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	

</head>
<body>
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
    <main class="ttr-wrapper">
		<div class="container">
			<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Month Report</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Month Report</li>
				</ul>
			</div>	
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<div class="row">
								<div class="col-sm-11">
									<h4>Account Details</h4>
								</div>
								<div class="col-sm-1">
									<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
								</div>
							</div>
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
								<div class="card">

									<div class="card-content">
										<div class="table-responsive">
											<table id="dataTableExample1" class="table table-bordered table-striped table-hover">
												<thead>
													<tr>
														<th><center>S.NO</center></th>
														<th><center>Date</center></th>
														<th><center>Credit (SAR)</center></th>
														<th><center>Debit (SAR)</center></th>
													</tr>
												</thead>
												<tbody>
													<?php
                                                        $count2 = 1;
                                                        $tempdate = "01-".$month."-".date('Y');
                                                        
                                                        $thismonth = date('m');

                                                        if($month == $thismonth)
                                                        {
                                                            $enddate = date('Y-m-d');
                                                        }
                                                        else
                                                        {
                                                            $enddate = date('Y-m-t',strtotime($tempdate));
                                                        }

														for($startdate = date('Y-m-d',strtotime($tempdate));$startdate <= $enddate;$startdate = date("Y-m-d",strtotime("+1 day", strtotime($startdate))))
														{
															$sql2 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date='$startdate' AND type!='3'";
															$result2 = $conn->query($sql2);
															$row2 = $result2->fetch_assoc();

															if($row2["debit"] == "")
															{
																$row2["debit"] = 0;
															}
															if($row2["credit"] == "")
															{
																$row2["credit"] = 0;
															}
													?>
														<tr>
															<td><center><?php echo $count2++ ?></center></td>
															<td><center><a href="day.php?date=<?php echo $startdate ?>"><?php echo date('d-m-Y',strtotime($startdate)) ?></a></center></td>
															<td><center><?php echo number_format($row2["credit"],2) ?></center></td>
															<td><center><?php echo number_format($row2["debit"],2) ?></center></td>
																						
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
				<!-- Your Profile Views Chart END-->
            </div>
		</div>
	</main>
			<!-- Card END -->
	<!-- <div class="ttr-overlay"></div> -->

<!-- External JavaScripts -->
<script src="assets/js/expense/jquery.min.js"></script>
<script src="assets/vendors/expense/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/expense/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/expense/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/expense/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/expense/counter/waypoints-min.js"></script>
<script src="assets/vendors/expense/counter/counterup.min.js"></script>
<script src="assets/vendors/expense/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/expense/masonry/masonry.js"></script>
<script src="assets/vendors/expense/masonry/filter.js"></script>
<script src="assets/vendors/expense/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/expense/scroll/scrollbar.min.js'></script>
<script src="assets/js/expense/functions.js"></script>
<script src="assets/vendors/expense/chart/chart.min.js"></script>
<script src="assets/js/expense/admin.js"></script>
<script src='assets/vendors/expense/calendar/moment.min.js'></script>
<script src='assets/vendors/expense/calendar/fullcalendar.js'></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
</script>
</body>
</html>