<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');

	$dates = "0000-00-00";

	$id = $_REQUEST["id"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($id == "")
	{
		$today = date('Y-m-d');
        $thismonth = date('Y-m-01');
        $monthName = "For The Month of - ".date("F Y");
	}
	else
	{
		if($id < 10)
		{
			$id = "0".$id;
		}

		$thismonth = date('Y-'.$id.'-01');
		$today = date("Y-m-t", strtotime($thismonth));
		$monthName = "For The Month of - ".date('F Y', mktime(0, 0, 0, $id, 10));
	}

	if($fdate != "" && $tdate != "")
	{
		$today = $tdate;
        $thismonth = $fdate;
        $monthName = "From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));
	}

	$sql4 = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today'";
	$result4 = $conn->query($sql4);
	$mon = $mil = $pro = 0;
	while($row4 = $result4->fetch_assoc())
	{
		if($row4["term"] == 1)
		{
			$mil += $row4["demo"];
		}
		if($row4["term"] == 2)
		{
			$mon += $row4["demo"];
		}
		if($row4["term"] == 3)
		{
			$pro += $row4["demo"];
		}
	}

	$totalpo = $totalinv = 0;

	$sql4 = "SELECT * FROM project WHERE status='Commercially Open'";
	$result4 = $conn->query($sql4);
	while($row4 = $result4->fetch_assoc())
	{
		$totalpo += $row4["value"];

		$pid1 = $row4["proid"];

		$sql5 = "SELECT * FROM invoice WHERE pid='$pid1'";
		$result5 = $conn->query($sql5);
		while($row5 = $result5->fetch_assoc())
		{
			$totalinv += $row5["demo"];
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
	<meta name="description" content="Invoice Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Invoice Reports | Project Management System" />
	<meta property="og:description" content="Invoice Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice Reports | Project Management System</title>
	
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
	.table-hover tr td {text-align: center;}
	.table-hover tr td a{padding: 10px;}
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
				<h4 class="breadcrumb-title">Invoice Reports</h4>
			</div>	

			<div class="row m-b30">
				<div class="col-sm-12">
					<div class="widget-box">
						<div class="card-header">
							<h4>Commercially Open Projects</h4>
						</div>
						<div class="widget-inner">
							<div class="row">
								<div class="col-sm-4">
									<center><h5>Total PO : QAR <?php echo number_format($totalpo,2) ?></h5></center>
								</div>
								<div class="col-sm-4">
									<center><h5>Total Invoiced Value : QAR <?php echo number_format($totalinv,2) ?></h5></center>
								</div>
								<div class="col-sm-4">
									<center><h5>Yet To Invoice : QAR <?php echo number_format($totalpo - $totalinv,2) ?></h5></center>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>

			<div class="row">
			
				
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box">
						<div class="widget-inner">
							<div class="row m-b50">
								<div class="col-sm-4">
									<label class="col-form-label">Month Wise Search</label>
									<select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
										<option value disabled Selected>Select Month</option>
										<option value="1">Jan</option>
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
										<option value="12">Dec</option>
									</select>
								
								</div>
								<div class="col-sm-8">
								<label class="col-form-label">Custom Search</label>
									<div class="col-sm-12">
										<div class="row">
										
											<div class="col-sm-5">
												<input type="date" id="fdate" class="form-control">
											</div>
											<div class="col-sm-5">
												<input type="date" id="tdate" class="form-control">
											</div>
											<div class="col-sm-2">
												<input type="button" class="btn" value="Submit" onclick="search()">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="background-color: #B8F1CE;padding:10px 0">
								<div class="col-sm-12">
									<h6 style="color: #000"><center><?php echo $monthName ?></center></h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row m-t30">
				<div class="col-sm-12">
					<center><h4>Invoice Generated Report</h4></center>
				</div>
			</div>			

			<div class="row m-t30">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-8">
									<h4 class="float-left">Milestone Invoices</h4>	
								</div>
								<div class="col-sm-4">
									<h4 class="float-right">Total Invoiced Value : QAR <?php echo number_format($mil,2) ?></h4>	
								</div>
							</div>
						</div>
                	    <div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>											
											<th>Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
											<th>Client Name</th>
											<th>Invoice Date</th>
											<th>Invoice No</th>
											<th>Invoiced Value</th>
											<th>Yet To Invoice</th>
											<?php
												if($rowside["id"] != 2)
												{
											?>
											<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$sql1 = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today' AND current != 0 ORDER BY id DESC";
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{		
												$eid = $row1["rfqid"];
												$pid = $row1["pid"];
												$total = 0;

												$sql = "SELECT * FROM enquiry WHERE rfqid='$eid'";
												$result = $conn->query($sql);
												$row = $result->fetch_assoc();

												$sql2 = "SELECT * FROM project WHERE proid='$pid'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();

												$sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
												$result3 = $conn->query($sql3);
												if($result3->num_rows > 0)
												{
													while($row3 = $result3->fetch_assoc())
													{
														$total += $row3["demo"];
													}
												}
												else
												{
													$sql3 = "SELECT * FROM invoice WHERE rfqid='$eid'";
													$result3 = $conn->query($sql3);
													while($row3 = $result3->fetch_assoc())
													{
														$total += $row3["demo"];
													}
												}

												if($row2["divi"] == "")
												{
													$row2["divi"] = $row["division"];
												}

												if($row1["term"] == 1)
												{
										?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>
													<td><center><?php echo $row2["divi"] ?></center></td>
													<td><center><?php echo $row2["proid"] ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
													<td><center><?php echo $row["cname"] ?></center></td>
													<td><center><?php echo date('d/m/Y',strtotime($row1["date"])) ?></center></td>
													<td><center><?php echo $row1["invid"] ?></center></td>
													<td><center>QAR <?php echo number_format($row1["demo"],2) ?></center></td>
													<td><center>QAR <?php echo number_format($row2["value"] - $total,2) ?></center></td>
													<?php
														if($rowside["id"] != 2)
														{
													?>
													<td><center><a href="invoice.php?id=<?php echo $row2["id"] ?>" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>
													<?php
														}
													?>
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

			<div class="row m-t30">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-8">
									<h4 class="float-left">Monthly Invoices</h4>	
								</div>
								<div class="col-sm-4">
									<h4 class="float-right">Total Invoiced Value : QAR <?php echo number_format($mon,2) ?></h4>	
								</div>
							</div>
						</div>
                	    <div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>											
											<th>Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
											<th>Client Name</th>
											<th>Invoice Date</th>
											<th>Invoice No</th>
											<th>Invoiced Value</th>
											<th>Yet To Invoice</th>
											<?php
												if($rowside["id"] != 2)
												{
											?>
											<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$sql1 = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today' AND current != 0 ORDER BY id DESC";
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{		
												$eid = $row1["rfqid"];
												$pid = $row1["pid"];
												$total = 0;

												$sql = "SELECT * FROM enquiry WHERE rfqid='$eid'";
												$result = $conn->query($sql);
												$row = $result->fetch_assoc();

												$sql2 = "SELECT * FROM project WHERE proid='$pid'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();

												$sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
												$result3 = $conn->query($sql3);
												if($result3->num_rows > 0)
												{
													while($row3 = $result3->fetch_assoc())
													{
														$total += $row3["demo"];
													}
												}
												else
												{
													$sql3 = "SELECT * FROM invoice WHERE rfqid='$eid'";
													$result3 = $conn->query($sql3);
													while($row3 = $result3->fetch_assoc())
													{
														$total += $row3["demo"];
													}
												}

												if($row2["divi"] == "")
												{
													$row2["divi"] = $row["division"];
												}

												if($row1["term"] == 2)
												{
										?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>
													<td><center><?php echo $row2["divi"] ?></center></td>
													<td><center><?php echo $row2["proid"] ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
													<td><center><?php echo $row["cname"] ?></center></td>
													<td><center><?php echo date('d/m/Y',strtotime($row1["date"])) ?></center></td>
													<td><center><?php echo $row1["invid"] ?></center></td>
													<td><center>QAR <?php echo number_format($row1["demo"],2) ?></center></td>
													<td><center>QAR <?php echo number_format($row2["value"] - $total,2) ?></center></td>
													<?php
														if($rowside["id"] != 2)
														{
													?>
													<td><center><a href="invoice.php?id=<?php echo $row2["id"] ?>" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>
													<?php
														}
													?>
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

			<div class="row m-t30">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-8">
									<h4 class="float-left">Prorata Invoices</h4>	
								</div>
								<div class="col-sm-4">
									<h4 class="float-right">Total Invoiced Value : QAR <?php echo number_format($pro,2) ?></h4>	
								</div>
							</div>
						</div>
                	    <div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample3" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>											
											<th>Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
											<th>Client Name</th>
											<th>Invoice Date</th>
											<th>Invoice No</th>
											<th>Invoiced Value</th>
											<th>Yet To Invoice</th>
											<?php
												if($rowside["id"] != 2)
												{
											?>
											<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$sql1 = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today' AND current != 0 ORDER BY id DESC";
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{		
												$eid = $row1["rfqid"];
												$pid = $row1["pid"];
												$total = 0;

												$sql = "SELECT * FROM enquiry WHERE rfqid='$eid'";
												$result = $conn->query($sql);
												$row = $result->fetch_assoc();

												$sql2 = "SELECT * FROM project WHERE proid='$pid'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();

												$sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
												$result3 = $conn->query($sql3);
												if($result3->num_rows > 0)
												{
													while($row3 = $result3->fetch_assoc())
													{
														$total += $row3["demo"];
													}
												}
												else
												{
													$sql3 = "SELECT * FROM invoice WHERE rfqid='$eid'";
													$result3 = $conn->query($sql3);
													while($row3 = $result3->fetch_assoc())
													{
														$total += $row3["demo"];
													}
												}

												if($row2["divi"] == "")
												{
													$row2["divi"] = $row["division"];
												}

												if($row1["term"] == 3)
												{
										?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>
													<td><center><?php echo $row2["divi"] ?></center></td>
													<td><center><?php echo $row2["proid"] ?></center></td>
													<td><center><?php echo $row["name"] ?></center></td>
													<td><center><?php echo $row["cname"] ?></center></td>
													<td><center><?php echo date('d/m/Y',strtotime($row1["date"])) ?></center></td>
													<td><center><?php echo $row1["invid"] ?></center></td>
													<td><center>QAR <?php echo number_format($row1["demo"],2) ?></center></td>
													<td><center>QAR <?php echo number_format($row2["value"] - $total,2) ?></center></td>
													<?php
														if($rowside["id"] != 2)
														{
													?>
													<td><center><a href="invoice.php?id=<?php echo $row2["id"] ?>" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>
													<?php
														}
													?>	
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

			<?php
				$st = $sp = 0;
				$et = $ep = 0;
				$sat = $sap = 0;
				$dt = $dp = 0;
				$sql5 = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today' AND current != 0";
				$result5 = $conn->query($sql5);
				while($row5 = $result5->fetch_assoc())
				{
					$pid = $row5["pid"];
					$rfqid = $row5["rfqid"];
					$divi = "";

					if($pid != "")
					{
						$sql6 = "SELECT * FROM project WHERE proid='$pid'";
						$result6 = $conn->query($sql6);
						$row6 = $result6->fetch_assoc();

						$divi = $row6["divi"];
					}
					else
					{
						$sql6 = "SELECT * FROM enquiry WHERE rfqid='$rfqid'";
						$result6 = $conn->query($sql6);
						$row6 = $result6->fetch_assoc();

						$ida = $row6["id"];

						$sql7 = "SELECT * FROM project WHERE eid='$ida'";
						$result7 = $conn->query($sql7);
						$row7 = $result7->fetch_assoc();

						$divi = $row7["divi"];
					}

					if($divi == "SUSTAINABILITY")
					{
						$st += $row5["demo"];
					}
					if($divi == "ENGINEERING")
					{
						$et += $row5["demo"];
					}
					if($divi == "SIMULATION & ANALYSIS")
					{
						$sat += $row5["demo"];
					}
					if($divi == "DEPUTATION")
					{
						$dt += $row5["demo"];
					}
				}

				$sql5 = "SELECT * FROM invoice WHERE recdate BETWEEN '$thismonth' AND '$today' AND paystatus=2";
				$result5 = $conn->query($sql5);
				while($row5 = $result5->fetch_assoc())
				{
					$pid = $row5["pid"];
					$rfqid = $row5["rfqid"];
					$divi = "";

					if($pid != "")
					{
						$sql6 = "SELECT * FROM project WHERE proid='$pid'";
						$result6 = $conn->query($sql6);
						$row6 = $result6->fetch_assoc();

						$divi = $row6["divi"];
					}
					else
					{
						$sql6 = "SELECT * FROM enquiry WHERE rfqid='$rfqid'";
						$result6 = $conn->query($sql6);
						$row6 = $result6->fetch_assoc();

						$ida = $row6["id"];

						$sql7 = "SELECT * FROM project WHERE eid='$ida'";
						$result7 = $conn->query($sql7);
						$row7 = $result7->fetch_assoc();

						$divi = $row7["divi"];
					}

					if($divi == "SUSTAINABILITY")
					{
						$sp += $row5["current"];
					}
					if($divi == "ENGINEERING")
					{
						$ep += $row5["current"];
					}
					if($divi == "SIMULATION & ANALYSIS")
					{
						$sap += $row5["current"];
					}
					if($divi == "DEPUTATION")
					{
						$dp += $row5["current"];
					}
				}
			?>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30 m-t30">
                    <div class="widget-box">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-4">
									<h4 class="float-left">Total Invoiced Value : QAR <?php echo number_format($st + $et + $sat + $dt,2) ?></h4>
								</div>
								<div class="col-sm-4">
									<center><h4>Division Wise Invoice Report</h4></center>
								</div>
								<div class="col-sm-4">
									<h4 class="float-right">Total Collected Value : QAR <?php echo number_format($sp + $ep + $sap + $dp,2) ?></h4>
								</div>
							</div>
						</div>
						<div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample4" class="table table-striped">
                                    <thead>
                                        <tr>
                                           	<th>S.NO</th>
											<th>Division Name</th>
											<th>Total Invoiced Value</th>
											<th>Total Collected Value</th>
                                        </tr>
                                    </thead>
									<tbody>
											<tr>
												<td><center> 1 </center></td>
												<td><center>SUSTAINABILITY</center></td>
												<td><center>QAR <?php echo number_format($st,2) ?></center></td>
												<td><center>QAR <?php echo number_format($sp,2) ?></center></td>
											</tr>
											<tr>
												<td><center> 2 </center></td>
												<td><center>ENGINEERING SERVICES</center></td>
												<td><center>QAR <?php echo number_format($et,2) ?></center></td>
												<td><center>QAR <?php echo number_format($ep,2) ?></center></td>
											</tr>
											<tr>
												<td><center> 3 </center></td>
												<td><center>SIMULATION & ANALYSIS SERVICES</center></td>
												<td><center>QAR <?php echo number_format($sat,2) ?></center></td>
												<td><center>QAR <?php echo number_format($sap,2) ?></center></td>
											</tr>
											<tr>
												<td><center> 4 </center></td>
												<td><center>DEPUTATION</center></td>
												<td><center>QAR <?php echo number_format($dt,2) ?></center></td>
												<td><center>QAR <?php echo number_format($dp,2) ?></center></td>
											</tr>
										
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
			$('#dataTableExample2').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
			$('#dataTableExample3').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
			$('#dataTableExample4').DataTable({
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
<script>
	function boss(val)
	{
		if(val != "")
		{
			location.replace("http://www.conserveacademy.com/projectmgmttool/invoice-reports.php?id="+val);
		}
	}
	function search()
	{
		var fdate = document.getElementById('fdate').value;
		var tdate=document.getElementById('tdate').value;

		if(fdate == "")
		{
			$("#fdate").css("border", "1px solid red");
		}
		else
		{
			if(tdate == "")
			{
				$("#tdate").css("border", "1px solid red");
			}
			else
			{
				location.replace("http://www.conserveacademy.com/projectmgmttool/invoice-reports.php?fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
</body>
</html>