<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

    $date = $_REQUEST["date"];
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
	<meta name="description" content="Day Book Inhouse | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Day Book Inhouse | Income Expense Manager" />
	<meta property="og:description" content="Day Book Inhouse | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Day Book Inhouse | Income Expense Manager</title>
	
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

	<style>
		.d
		{
			margin-top:10px;
		}
		.he
		{
			height: 100px;
		}
		.co
		{
			color: #BE882F;
		}
		.form-control
		{
			padding:0;
		}
		.btn-primary
		{
			background-color: #1654A2;
			color: #fff;
		}
	</style>

</head>
<body>
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
    <main class="ttr-wrapper">
		<div class="container">
			<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<div class="row m-b30">
						<div class="col-sm-12">
							<!-- <a href="income.php"><button class="btn btn-primary pull-right ml-5" type="button"><span><i class="fa fa-plus"></i></span> Income Day Book </button></a> -->
							<a href="expence.php"><button class="btn btn-primary pull-right ml-5" type="button"><span><i class="fa fa-plus"></i></span> Expense Day Book </button></a>
						</div>
					</div>
                    <div class="widget-box">
                        <div class="wc-title">
							<div class="row">
								<div class="col-sm-11">
									<h4>Income/Expense List - <?php echo date('d-m-Y',strtotime($date)) ?></h4>
								</div>
								<div class="col-sm-1">
									<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
								</div>
							</div>
						</div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Account</th>
											<th>Sub Account</th>
											<th>Type</th>
											<th>Mode</th>
											<th>Amount</th>
											
											<!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql2 = "SELECT code,mode,sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE date='$date' AND type!='3' AND code!='0' GROUP BY code ORDER BY id DESC";
                                            $result2 = $conn->query($sql2);
                                            $count = 1;
                                            while($row2 = $result2->fetch_assoc())
                                            {
												$codes = $row2["code"];

												$sql3 = "SELECT * FROM account WHERE code='$codes'";
												$result3 = $conn->query($sql3);
                                                $row3 = $result3->fetch_assoc();
                                                
                                                $type = "";

												if($row3["type"] == 1)
												{
													$type = "Expense";
												}
												if($row3["type"] == 2)
												{
													$type = "Income";
												}

												if($row3["sub"] == 0)
												{
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row3["name"] ?></center></td>
                                                <td><center> - </center></td>
												<td><center><?php echo $type ?></center></td>
                                                <td><center><?php echo $row2["mode"] ?></center></td>
                                        <?php
												if($row2["credit"] == 0)
												{
										?>
												<td><center>SAR <?php echo number_format($row2["debit"],2) ?></center></td>
										<?php
												}
												else
												{
										?>
												<td><center>SAR <?php echo number_format($row2["credit"],2) ?></center></td>
										<?php
												}
										?>
												<!--  <td><center><a style="padding:10px" href="view-project.php?"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td> -->
                                            </tr>
                                        <?php
												}
												else
												{
													$sub = $row3["sub"];

													$sql = "SELECT * FROM account WHERE id='$sub'";
													$result = $conn->query($sql);
													$row = $result->fetch_assoc();
												?>
													<tr>
														<td><center><?php echo $count++ ?></center></td>
														<td><center><?php echo $row["name"] ?></center></td>
														<td><center><?php echo $row3["name"] ?></center></td>
														<td><center><?php echo $type ?></center></td>
														<td><center><?php echo $row2["mode"] ?></center></td>
												<?php
														if($row2["credit"] == 0)
														{
												?>
														<td><center>SAR <?php echo number_format($row2["debit"],2) ?></center></td>
												<?php
														}
														else
														{
												?>
														<td><center>SAR <?php echo number_format($row2["credit"],2) ?></center></td>
												<?php
														}
												?>
														<!--  <td><center><a style="padding:10px" href="view-project.php?"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td> -->
													</tr>
												<?php			
												}
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
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
                "iDisplayLength": 15
            });
</script>
</body>
</html>