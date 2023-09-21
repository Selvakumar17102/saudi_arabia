<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");
	// session_start();

	$user = $_SESSION["username"];

	$id = $_REQUEST["id"];
	$year = $_REQUEST['year'];

	if($id == "")
	{
		$end = date('Y-m-d');
        $start = date('Y-m-01');
		$monthName = date("F")." Month";
		$id = date("m");
	}
	else
	{
        $monthName = date('F', mktime(0, 0, 0, $id, 10))." Month";
		if($id < 10)
		{
			$id = "0".$id;
		}
		if($year!="" && $id!="")
		{
			$start = date($year.'-'.$id.'-01');
			$end = date($year."-m-t", strtotime($start));
		}
		else
		{
			$start = date('Y-'.$id.'-01');
			$end = date("Y-m-t", strtotime($start));
		}

		
	}

	// $sql8 = "SELECT sum(amount) AS amount FROM credits WHERE date BETWEEN '$start' AND '$end'";
	$sql8 = "SELECT sum(demo + demo_gst) AS invamt FROM invoice WHERE date BETWEEN '$start' AND '$end'";
	$result8 = $conn->query($sql8);
	$row8 = $result8->fetch_assoc();

	$ms = date('Y-m-01');
	$me = date('Y-m-d');
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
	<meta name="description" content="Dashboard | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Dashboard | Income Expense Manager" />
	<meta property="og:description" content="Dashboard | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Dashboard | Income Expense Manager</title>
	
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
		p
		{
			font-size : 15px;
		}
		.cls text
		{
			font-size : 14px;
			text-align : center;
			margin-bottom: 20px
		}
	</style>

</head>
<body>
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
    <main class="ttr-wrapper">
	<div class="container">
			<!-- Card -->
			<div class="row">
				
				<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
					<div class="widget-card widget-bg2">					 
						<div class="wc-item">
						<img src="assets/images/hand-sar.png" style="padding-right: 5px;">
						<span class="wc-stats">
									<!-- cash value come in to expense_heder.php -->
									<span class="counter1 text-right">SAR <?php echo number_format($cash,2) ?></span>
								</span>
							<h4 class="wc-title">
							
								<h4><b> Cash In Hand </b> </h4>
								
								</h4>							
						</div>					      
					</div>
				</div>
				<?php
					// if($user == "bazeeth@123")
					// {
						?>
							<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
								<div class="widget-card widget-bg3">					 
									<div class="wc-item">
									<img src="assets/images/bank-building-sar.png" style="padding-right: 5px;">
									<span class="wc-stats">
												<span class="counter1">SAR <?php echo number_format($bank1+$bank2+$bank3,2) ?></span>
											</span>	
										<h4 class="wc-title">
												
											<h4><b>Cash In Bank </b></h4> 
											
										</h4>	

									</div>					      
								</div>
							</div>
							<div class="col-md-6 col-lg-4 col-xl-4 col-sm-6 col-12">
					<div class="widget-card widget-bg1">					 
						<div class="wc-item">
						<img src="assets/images/coins-sar.png" style="padding-right: 5px;">
						<span class="wc-stats">
								<span class="counter1 text-end">SAR <?php echo number_format($bank1+$bank2+$bank3+$cash,2) ?></span>
							  </span>	
							<h4 class="wc-title">

								 <h4><b>Total Cash</b></h4>
								
							</h4>							
						</div>				      
					</div>
				</div>
						<?php
					// }
				?>
			</div>
			<!-- Card END -->
			
			<div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<div class="row">
								<div class="col-sm-3">
									<h4 style="margin-top: 8px">Summary</h4>
								</div>
								<div class="col-sm-3">
									<select name="year" id="year" class="form-control" onchange="year(this.value)">
										<option value disabled Selected value="">Select Year</option>
										<?php
											$this_year="";
											for($i=0;$i < 3;$i++)
											{
												$selected_year="";
												$this_year = date('Y', strtotime("$this_year-$i-13"));

												if($i !=0)
												{
													$this_year -= 1;
												}
												if($year!="")
												{
													if($year == $this_year)
													{
														$selected_year = "selected";
													}
												}
												?>
													<option <?php echo $selected_year;?> value="<?php echo $this_year;?>"><?php echo $this_year;?></option>
												<?php
											}
										?>
									</select>
								</div>
								<div class="col-sm-3">
									<select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
										<option value disabled Selected>Select Month</option>
										<?php
											for($i=1;$i<=12;$i++)
											{
												$selected_month="";
												if($i == $id)
												{
													$selected_month = "selected";
												}
												?>
													<option <?php echo $selected_month;?> value="<?php echo $i;?>"><?php echo date("F", strtotime("2020-$i-13"));?></option>
												<?php
											}
										?>
										<!-- <option value="1">Jan</option>
										<option value="2">Feb</option>
										<option value="3">Mar</option>
										<option value="4">Apr</option>
										<option value="5">May</option>
										<option value="6">Jun</option>
										<option value="7">Jul</option>
										<option value="8">Aug</option>
										<option value="9">Sep</option>
										<option value="10">Oct</option>
										<option value="11">Nov</option>
										<option value="12">Dec</option> -->
									</select>
								</div>
								<div class="col-sm-2">
									<a class="float-right btn btn-primary" href="new-account.php"><span><i class="fa fa-plus"></i></span> Add Account</a>
								</div>
							</div>
						</div>
						<div class="widget-inner">
						<div class="row">
								<?php

									$sql4 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date BETWEEN '$start' AND '$end' AND type!='3'";									$result4 = $conn->query($sql4);
									$row4 = $result4->fetch_assoc();

									if($row4["credit"] == "")
									{
										$row4["credit"] = 0;
									}
									if($row4["debit"] == "")
									{
										$row4["debit"] = 0;
									}

									$sql5 = "SELECT * FROM account WHERE type='2'";
									$result5 = $conn->query($sql5);
									$amount1 = $amount2 = 0;
									while($row5 = $result5->fetch_assoc())
									{
										$code = $row5["code"];

										$sql6 = "SELECT sum(credit) AS credit FROM expence_invoice WHERE code='$code'";
										$result6 = $conn->query($sql6);
										$row6 = $result6->fetch_assoc();

										$amount1 += $row6["credit"];

										$sql7 = "SELECT sum(amount) AS amount FROM credits WHERE code='$code'";
										$result7 = $conn->query($sql7);
										$row7 = $result7->fetch_assoc();

										$amount2 += $row7["amount"];
									}
								?>
								<div class="col-lg-3 summary">
								
								<div class="figure-section">
                                    <p><?php echo $monthName ?> Income</p>
                                    <h4 class="text-primary reports-income" style="color: #13A54E !important;">SAR <?php echo number_format($row4["credit"],2) ?></h4>
                                </div>
								
								<div class="figure-section">
                                    <p><?php echo $monthName ?> Expenses</p>
                                    <h4 class="text-danger reports-expenses" style="color: #ff1a1a !important;">SAR <?php echo number_format($row4["debit"],2) ?></h4>
                                </div>

								<div class="figure-section">
								<p><?php echo $monthName ?> Invoiced Value</p>
                                    <h4 class="reports-expenses" style="color: #46187E !important;">SAR <?php echo number_format($row8["invamt"],2) ?></h4>
                                </div>

								<div class="figure-section">
                                    <p>Total Outstanding</p>
                                    <h4 class="reports-expenses" style="color: #BB00FF !important;">SAR <?php echo number_format($amount2 - $amount1,2) ?></h4>
                                </div>
									
								</div>
								<div class="col-sm-9">
									<div class="row">
										<div class="col-sm-12">
											<center><label class="col-form-label">Income & Expense Graphs</label></center>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 cls">
											<div id="expmonth" style="width: 100%; height: 400px;"></div>	
										</div>
										<div class="col-sm-8 cls">
											<div id="expyear" style="width: 100%; height: 400px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<h4><?php echo $year;?> <?php echo $monthName ?> Division Summary</h4>
						</div>
						<div class="widget-inner">
							<div class="row">
								<div class="col-lg-6 cls">
									<div style="height: 300px" id="divinc"></div>
								</div>
								<div class="col-lg-6 cls">
									<div style="height: 300px" id="divexp"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<h4>Invoice vs Income graphs</h4>
						</div>
						<div class="widget-inner">
							<div class="row">
								<div class="col-lg-4 cls">
									<div id="invmonth" style="width: 100%; height: 400px;"></div>
								</div>
								<div class="col-lg-8 cls">
									<div id="invyear" style="width: 100%; height: 400px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Card END -->
			<div class="row">
				<!-- Your Profile Views Chart -->
				
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
						<!-- <a href="income.php"><button class="btn btn-primary pull-right ml-5" type="button"><span><i class="fa fa-plus"></i></span> Income Day Book </button></a> -->
						<!-- <a href="expence.php"><button class="btn btn-primary pull-right ml-5" type="button"><span><i class="fa fa-plus"></i></span> Expense Day Book </button></a> -->
							<h4>Income & Expense Details</h4>
						</div>
						<div class="widget-inner">
							<section id="tabs">
								<div class="container">
									<div class="row">
										<div class="col-lg-12">
											<nav>
												<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Today</a>
													<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">This Week</a>
													<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">This Month</a>
													<a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">This Year  </a>
												</div>
											</nav>
											<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
												<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
															<div class="card">

																<div class="card-content">
																	<div class="table-responsive">
																		<table id="dataTableExample1" class="table table-bordered table-striped table-hover">
																			<thead>
																				<tr>
																					<th><center>S.NO</center></th>
																					<th><center>Account</center></th>
																					<th><center>Type</center></th>
																					<th><center>Amount</center></th>
																					<th><center>Date</center></th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																					$date = date('Y-m-d');
																					$sql2 = "SELECT * FROM expence_invoice WHERE date='$date' AND type!='3' ORDER BY id DESC LIMIT 5";
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
																				?>
																					<tr>
																						<td><center><?php echo $count++ ?></center></td>
																						<td><center><?php echo $row3["name"] ?></center></td>
																						<td><center><?php echo $type ?></center></td>
																				<?php
																						if($row2["credit"] == 0)
																						{
																				?>
																						<td><center><?php echo number_format($row2["debit"],2) ?></center></td>
																				<?php
																						}
																						else
																						{
																				?>
																						<td><center><?php echo number_format($row2["credit"],2) ?></center></td>
																				<?php
																						}
																				?>
																						<td><center><?php echo date('d-m-Y',strtotime($row2["date"])) ?></center></td>
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
												<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
															<div class="card">

																<div class="card-content">
																	<div class="table-responsive">
																		<table id="dataTableExample2" class="table table-bordered table-striped table-hover">
																			<thead>
																				<tr>
																					<th><center>S.NO</center></th>
																					<th><center>Date</center></th>
																					<th><center>Expense</center></th>
																					 <th><center>Income</center></th>
																					
																				</tr>
																			</thead>
																			<tbody>
																				<?php
								
																					$day = date('w');
																					$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
																					$count1 = 1;

																					for($date = date('Y-m-d');$date >= $week_start;$date = date("Y-m-d",strtotime("-1 day", strtotime($date))))
																					{
																						$sql2 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date='$date' AND type!='3'";
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
																						<td><center><?php echo $count1++ ?></center></td>
																						<td><center><a href="day.php?date=<?php echo $date ?>"><?php echo date('d-m-Y',strtotime($date)) ?></a></center></td>
																						
																						<td><center><?php echo number_format($row2["debit"],2) ?></center></td>
																						<td><center><?php echo number_format($row2["credit"],2) ?></center></td>
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
												<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
															<div class="card">

																<div class="card-content">
																	<div class="table-responsive">
																		<table id="dataTableExample3" class="table table-bordered table-striped table-hover">
																			<thead>
																				<tr>
																					<th><center>S.NO</center></th>
																					<th><center>Date</center></th>
																					<th><center>Expense</center></th>
																					 <th><center>Income</center></th> 
																					
																				</tr>
																			</thead>
																			<tbody>
																				<?php
								
																					$day = date('w');
																					$monthstart = date('Y-m-01');
																					$count2 = 1;

																					for($date = date('Y-m-d');$date >= $monthstart;$date = date("Y-m-d",strtotime("-1 day", strtotime($date))))
																					{
																						$sql2 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date='$date' AND type!='3'";
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
																						<td><center><a href="day.php?date=<?php echo $date ?>"><?php echo date('d-m-Y',strtotime($date)) ?></a></center></td>
																						
																						<td><center><?php echo number_format($row2["debit"],2) ?></center></td>
																						<td><center><?php echo number_format($row2["credit"],2) ?></center></td>
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
												<div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
															<div class="card">

																<div class="card-content">
																	<div class="table-responsive">
																		<table id="dataTableExample4" class="table table-bordered table-striped table-hover">
																			<thead>
																				<tr>
																					<th><center>S.NO</center></th>
																					<th><center>Month</center></th>
																					
																					<th><center>Expense</center></th>
																					 <th><center>Income</center></th> 
																				</tr>
																			</thead>
																			<tbody>
																				<?php
																					$month = date('m');
																					$counts = 1;
																					for($startmonth = 1;$startmonth <= $month;$startmonth++)
																					{
																						if($startmonth < 10)
																						{
																							$startmonth = "0".$startmonth;
																						}
																						$startmonth1 = date('Y-'.$startmonth.'-01');
																						if($month == $startmonth)
																						{
																							$endmonth1 = date('Y-m-d');
																						}
																						else
																						{
																							$endmonth1 = date("Y-m-t", strtotime($startmonth1));
																						}
																						$month_name = date("F", mktime(0, 0, 0, $startmonth, 10));
																						$sql = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE date BETWEEN '$startmonth1' AND '$endmonth1' AND type!='3'"; 
																						$result = $conn->query($sql);
																						$row = $result->fetch_assoc();

																						if($row["debit"] == "")
																						{
																							$row["debit"] = 0;
																						}
																						if($row["credit"] == "")
																						{
																							$row["credit"] = 0;
																						}

																				?>
																					<tr>
																						<td><center><?php echo $counts++ ?></center></td>
																						<td><center><a href="month.php?month=<?php echo $startmonth ?>"><?php echo $month_name ?></a></center></td>
																					
																						<td><center><?php echo number_format($row["debit"],2) ?></center></td>
																						<td><center><?php echo number_format($row["credit"],2) ?></center></td>
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
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Your Profile Views Chart -->
				
				<!-- <div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
								<h4>Search By Cheque</h4>
						</div>
						<div class="widget-inner">

							<div class="row" style="padding: 30px">
								<div class="col-sm-3">
									<label class="col-form-label">Cheque Number</label>
								</div>
								<div class="col-sm-4">
									<input type="text" id="number" class="form-control">
								</div>
								<div class="col-sm-2">
									<button class="btn" onclick="getvalue()">Search</button>
								</div>
							</div>
							<div class="row" style="padding: 30px" id="details">
								
							</div>

						</div>
					</div>
				</div> -->
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
			
			$('#dataTableExample2').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
			
			$('#dataTableExample3').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
			
			$('#dataTableExample4').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
</script>

	<!-- Income Expense Pie Chart Starts -->
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
			['Type', 'Amount'],
			<?php

				$totalcollection = $totalsale = 0;
				for($startmonthchart = $start;$startmonthchart <= $end;$startmonthchart = date("Y-m-d",strtotime("+1 day", strtotime($startmonthchart))))
				{
					$sql1 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date='$startmonthchart' AND type!='3'";
					$result1 = $conn->query($sql1);
					$row1 = $result1->fetch_assoc();

					$tempdate = date("d",strtotime($startmonthchart));

					$totalsale += $row1["credit"];
					$totalcollection += $row1["debit"];
				}

				echo "['Income',".$totalsale."],";
				echo "['Expense',".$totalcollection."],";
		  	?>
        ]);

        var options = {
			title : '<?php echo $monthName ?> Activity',
			colors: ['#008000', '#FFA500'],
			is3D: true,
			legend : 'top'
		};

        var chart = new google.visualization.PieChart(document.getElementById('expmonth'));
        chart.draw(data, options);
      }
    </script>

	<!-- Income Expense Pie Chart Ends -->

	<!-- Income Expense Line Chart Starts -->

	<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() 
        {
            var data = google.visualization.arrayToDataTable([
				['Month', 'Income', 'Expense'],
			<?php
				$nowmonth = date('m');

				for($i=1;$i<=$nowmonth;$i++)
				{
					$credit = $debit = 0;
					$m = $i;
					if($m < 10)
					{
						$m = "0".$m;
					}
					$name = date('F', mktime(0, 0, 0, $m, 10));

					$st = date('Y-'.$m.'-01');
					$ed = date('Y-'.$m.'-t');
					
					for($startmonthchart = $st;$startmonthchart <= $ed;$startmonthchart = date("Y-m-d",strtotime("+1 day", strtotime($startmonthchart))))
					{
						$sql1 = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE type!='3' AND date='$startmonthchart'";
						$result1 = $conn->query($sql1);
						$row1 = $result1->fetch_assoc();
						{
							
							$credit += $row1["credit"];
							$debit += $row1["debit"];
						}
					}

					echo "['".$name."',".$credit.",".$debit."],";
				}
			?>
            ]);

            var options = 
			{
				title: 'This Year Activity',
				curveType: 'function',
				legend: { position: 'bottom' },
				colors: ['#008000', '#FFA500'],
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('expyear'));

            chart.draw(data, options);
        }
    </script>

	<!-- Income Expense Line Chart Ends -->

	<!-- Invoice Pie Chart Starts -->
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
			['Type', 'Amount'],
			<?php

				$totalcollection = $totalsale = 0;
				for($startmonthchart = $start;$startmonthchart <= $end;$startmonthchart = date("Y-m-d",strtotime("+1 day", strtotime($startmonthchart))))
				{
					$sql1 = "SELECT sum(credit) as credit FROM expence_invoice WHERE date='$startmonthchart' AND type='1'";
					$result1 = $conn->query($sql1);
					$row1 = $result1->fetch_assoc();

					$sql2 = "SELECT sum(demo + demo_gst) as amount FROM invoice WHERE date='$startmonthchart'";
					$result2 = $conn->query($sql2);
					$row2 = $result2->fetch_assoc();

					$tempdate = date("d",strtotime($startmonthchart));

					$totalsale += $row1["credit"];
					$totalcollection += $row2["amount"];
				}

				echo "['Invoice',".$totalcollection."],";
				echo "['Income',".$totalsale."]";
		  	?>
        ]);

        var options = {
			title : '<?php echo $year;?> <?php echo $monthName ?> Activity',
			colors: ['#2350F9', '#F2CF40'],
			is3D: true,
			legend : 'top'
		};

        var chart = new google.visualization.PieChart(document.getElementById('invmonth'));
        chart.draw(data, options);
      }
    </script>

	<!-- Invoice Pie Chart Ends -->

	<!-- Invoice Line Chart Starts -->

	<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() 
        {
            var data = google.visualization.arrayToDataTable([
				['Month', 'Invoice', 'Income'],
			<?php
				$nowmonth = date('m');

				for($i=1;$i<=$nowmonth;$i++)
				{
					$credit = $debit = 0;
					$m = $i;
					if($m < 10)
					{
						$m = "0".$m;
					}
					$name = date('F', mktime(0, 0, 0, $m, 10));

					$st = date('Y-'.$m.'-01');
					$ed = date('Y-'.$m.'-t');

					$totalcollection = $totalsale = 0;
					
					for($startmonthchart = $st;$startmonthchart <= $ed;$startmonthchart = date("Y-m-d",strtotime("+1 day", strtotime($startmonthchart))))
					{
						$sql1 = "SELECT sum(credit) as credit FROM expence_invoice WHERE date='$startmonthchart' AND type='1'";
						$result1 = $conn->query($sql1);
						$row1 = $result1->fetch_assoc();

						$sql2 = "SELECT sum(demo + demo_gst) as amount FROM invoice WHERE date='$startmonthchart'";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();

						$tempdate = date("d",strtotime($startmonthchart));

						$totalsale += $row1["credit"];
						$totalcollection += $row2["amount"];
					}

					echo "['".$name."',".$totalcollection.",".$totalsale."],";
				}
			?>
            ]);

            var options = 
			{
				title: 'This Year Activity',
				curveType: 'function',
				legend: { position: 'bottom' },
				colors: ['#2350F9', '#F2CF40'],
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('invyear'));

            chart.draw(data, options);
        }
    </script>

	<!-- Invoice Line Chart Ends -->

	<!-- Division Income Pie Chart Starts -->
	
	<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() 
        {
            var data = google.visualization.arrayToDataTable([
				['Division', 'Amount'],
			<?php

				$sql = "SELECT * FROM division ORDER BY id ASC LIMIT 6";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc())
				{
					$credit = $debit = 0;

                    $diviid = $row["id"];
					$name = $row["division"];
					
					for($startmonthchart = $start;$startmonthchart <= $end;$startmonthchart = date("Y-m-d",strtotime("+1 day", strtotime($startmonthchart))))
					{
						$sql1 = "SELECT * FROM sector WHERE divi='$diviid' AND date='$startmonthchart'";
						$result1 = $conn->query($sql1);
						while($row1 = $result1->fetch_assoc())
						{
							$invid = $row1["inv"];

							$sql2 = "SELECT * FROM expence_invoice WHERE id='$invid'";
							$result2 = $conn->query($sql2);
							$row2 = $result2->fetch_assoc();

							if($row2["type"] == 1)
							{
								$credit += $row1["amount"];
							}
							if($row2["type"] == 2)
							{
								$debit += $row1["amount"];
							}
						}
					}

					echo "['".$name."',".$credit."],";
				}
			?>
            ]);

            var options = 
			{
				title: 'Income Chart',
				pieHole: 0.3,
				colors: ['#F15839','#FFB34E','#8628BE','#288BF0','#300BF0','#73de3a']
            };

            var chart = new google.visualization.PieChart(document.getElementById('divinc'));

            chart.draw(data, options);
        }
    </script>

	<!-- Division Income Pie Chart Ends -->

	<!-- Division Expense Pie Chart Starts -->
	
	<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() 
        {
            var data = google.visualization.arrayToDataTable([
				['Division', 'Amount'],
			<?php

				$sql = "SELECT * FROM division ORDER BY id ASC LIMIT 6";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc())
				{
					$credit = $debit = 0;

                    $diviid = $row["id"];
					$name = $row["division"]; 
					
					for($startmonthchart = $start;$startmonthchart <= $end;$startmonthchart = date("Y-m-d",strtotime("+1 day", strtotime($startmonthchart))))
					{
						$sql1 = "SELECT * FROM sector WHERE divi='$diviid' AND date='$startmonthchart'";
						$result1 = $conn->query($sql1);
						while($row1 = $result1->fetch_assoc())
						{
							$invid = $row1["inv"];

							$sql2 = "SELECT * FROM expence_invoice WHERE id='$invid'";
							$result2 = $conn->query($sql2);
							$row2 = $result2->fetch_assoc();

							if($row2["type"] == 1)
							{
								$credit += $row1["amount"];
							}
							if($row2["type"] == 2)
							{
								$debit += $row1["amount"];
							}
						}
					}

					echo "['".$name."',".$debit."],";
				}
			?>
            ]);

            var options = 
			{
				title: 'Expense Chart',
				pieHole: 0.3,
				colors: ['#F15839','#FFB34E','#8628BE','#288BF0','#300BF0','#73de3a']
            };

            var chart = new google.visualization.PieChart(document.getElementById('divexp'));

            chart.draw(data, options);
        }
    </script>

	<!-- Division Expense Pie Chart Ends -->

	<script>
		function boss(val)
		{
			var year = document.getElementById("year").value;
			if(year =="")
			{
				year = "<?php echo date("Y", strtotime($this_year));?>";
			}
			if(val != "")
			{
				// location.replace("https://www.conservesolution.com/incomemgmt/dashboard.php?id="+val+"&year="+year);
				window.location.href = "expence_dashboard.php?id="+val+"&year="+year;
			}
		}
	</script>
	
	<script>
		function year(val)
		{
			var month = document.getElementById("date").value;
			if(val !="")
			{
				// location.replace("https://www.conservesolution.com/incomemgmt/dashboard.php?year="+val+"&id="+month);
				window.location.href = "expence_dashboard.php?year="+val+"&id="+month ;
			}
		}
	</script>

	<script>
		function getvalue()
		{
			var val = document.getElementById("number").value;

			if(val == "")
			{
				document.getElementById("number").style.border = "1px solid red";
			}
			else
			{
				document.getElementById("number").style.border = "1px solid #ced4da";
				$.ajax({
					type: "POST",
					url: "assets/ajax/get-cheque.php",
					data:'number='+val,
					beforeSend: function() 
					{
						$("#details").addClass("loader");
					},
					success: function(data)
					{
						$("#details").html(data);  
						$("#details").removeClass("loader");
					}
				});	
			}
		}
	</script>
</body>
</html>