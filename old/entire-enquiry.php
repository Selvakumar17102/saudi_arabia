<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$date = date("Y-m-d");

	// s1 -> status
	// s2 -> stage
	$s1 = $_REQUEST["s1"];
	$s2 = $_REQUEST["s2"];

	$status = $stage = "";
	$s11 = $s12 = $s13 = $s21 = $s22 = $s23 = "";

	if($s1 == 1)
	{
		$status = "SUBMITTED";
		$s11 = "selected";
	}
	else
	{
		if($s1 == 2)
		{
			$status = "NOT SUBMITTED";
			$s12 = "selected";
		}
		if($s1 == 3)
		{
			$status = "DROPPED";
			$s13 = "selected";
		}
	}
	if($s2 == 1)
	{
		$stage = "Job In Hand";
		$s21 = "selected";
	}
	else
	{
		if($s2 == 2)
		{
			$stage = "Tender";
			$s22 = "selected";
		}
		if($s2 == 3)
		{
			$stage = "Training";
			$s23 = "selected";
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
	<meta name="description" content="All Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Enquiry | Project Management System" />
	<meta property="og:description" content="All Enquiry | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Enquiry | Project Management System</title>
	
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
		.green td
		{
			background-color: #fff;
		}
		.lime td
		{
			background-color: #fff;
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
				<div class="row" style="width: 100%">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">All Enquiry</h4>
					</div>
					<?php
						if($s1 != "" || $s2 != "")
						{
					?>
						<div class="col-sm-1">
							<a href="entire-enquiry.php" style="color: #fff" class="bg-primary btn">Back</a>
						</div>
					<?php
						}
					?>
				</div>
            </div>

			<div class="row m-t10">

				<div class="col-sm-12">

					<div class="widget-box">
						<div class="widget-inner">
							<div class="row">
								<div class="col-sm-6">
									<label class="col-form-label">Filter By Enquiry Status</label>
									<select onchange="status(this.value)" class="form-control">
										<option value selected disabled>Select Status</option>
										<option <?php echo $s11 ?> value="1">Submitted</option>
										<option <?php echo $s12 ?> value="2">Not Submitted</option>
										<option <?php echo $s13 ?> value="3">Dropped</option>
									</select>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">Filter By Stage</label>
									<select onchange="stage(this.value)" class="form-control">
										<option value selected disabled>Select Status</option>
										<option <?php echo $s21 ?> value="1">Job In Hand</option>
										<option <?php echo $s22 ?> value="2">Tender</option>
										<option <?php echo $s23 ?> value="3">Training</option>
									</select>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
				
			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
											<th>S.NO</th>
											<th style="color: #C54800">RFQ Id</th>
											<th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Responsibility</th>
                                            <th>Scope</th>
                                            <th>Stage</th>
                                            <th>Enquiry Status</th>
                                            <th>Project Status</th>
                                            <th>Submission Deadline</th>
											<?php
												if($user == "conserveadmin")
												{
											?>
													<th>Last Updated</th>
											<?php
												}
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
											if($s1 != "")
											{
												if($s2 != "")
												{
													$sql1 = "SELECT * FROM enquiry WHERE qstatus='$status' AND stage='$stage'";
												}
												else
												{
													$sql1 = "SELECT * FROM enquiry WHERE qstatus='$status'";
												}
											}
											else
											{
												if($s2 != "")
												{
													$sql1 = "SELECT * FROM enquiry WHERE stage='$stage'";
												}
												else
												{
													$sql1 = "SELECT * FROM enquiry";
												}
											}
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{
												$s = $ps = "";
												$eid = $row1["id"];

												$sql6 = "SELECT * FROM mod_details WHERE enq_no='$eid' AND control='1' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();

												if($row6["update_details"] == 1)
												{
													$s = "Created";
												}
												else
												{
													$s = "Edited";
												}

												$pstatus = $row1["pstatus"];
												$qstatus = $row1["qstatus"];
												$stage = $row1["stage"];

												$scope = "";

												if($qstatus == "NOT SUBMITTED" || $qstatus == "DROPPED")
												{
													$ps = $qstatus;
													$tempcolor = "";
												}
												else
												{
													if($pstatus == "AWARDED")
													{
														$ps = "Awarded";
														$tempcolor = "green";
													}
													else
													{
														if($pstatus == "FOLLOW UP")
														{
															$ps = "In Progress";
															$tempcolor = "lime";
														}
														else
														{
															$ps = $pstatus;
															$tempcolor = "";
														}
													}
												}

												$sql = "SELECT * FROM scope WHERE eid='$eid'";
												$result = $conn->query($sql);
												if($result->num_rows > 0)
												{
													while($row = $result->fetch_assoc())
													{
														$scope .= $row["scope"]."<br>";
													}
												}
												else
												{
													$scope = $row1["scope"];
												}

												$date = strtotime($row1["qdate"]);
												echo '<tr class="'.$tempcolor.'">';
												echo '<td><center>'.$count.'</center></td>';
												echo '<td><center>'.$row1["rfqid"].'</center></td>';
												
												echo '<td><center><a href="view-enquiry.php?id='.$row1["id"].'">'.$row1["name"].'</a></center></td>';
												echo '<td><center>'.$row1["cname"].'</center></td>';
												echo '<td><center>'.$row1["responsibility"].'</center></td>';
												echo '<td><center>'.$scope.'</center></td>';
												echo '<td><center>'.$row1["stage"].'</center></td>';
												echo '<td><center>'.ucwords(strtolower($row1["qstatus"])).'</center></td>';
												echo '<td><center>'.ucwords(strtolower($ps)).'</center></td>';
												echo '<td><center>'.date('d-m-Y', $date).'</center></td>';
												if($user == "conserveadmin")
												{
											?>
													<td><center>
												<?php
														if($row6["user_id"] != "")
														{
															echo $s.' by '.$row6["user_id"].'<br>'.date('d-m-Y | h:i:s a',strtotime($row6["datetime"]));
														}
														else
														{
															echo "-";
														}
												?>
													</center></td>
											<?php	
												}
												if($rowside["id"] != 2)
												{
										?>
												<td>
													<table class="action">
														<tr>

															<td style="border: none;">
															<a href="view-enquiry.php?id=<?php echo $row1["id"]; ?>" title="View Enquiry">
															<span class="notification-icon dashbg-green">
															<i class="fa fa-eye" aria-hidden="true"></i>
															</span>
															</a>
															</td>

															<td style="border: none;">
															<a href="edit-enquiry.php?m=1&id=<?php echo $row1["id"]; ?>" title="Edit Enquiry">
															<span class="notification-icon dashbg-primary">
															<i class="fa fa-edit" aria-hidden="true"></i>
															</span>
															</a>
															</td>
															
															<td style="border: none;">
															<a href="delete-enquiry.php?id=<?php echo $row1["id"]; ?>" title="Delete Enquiry" onClick="return confirm('Sure to Delete this Enquiry !');">
															<span class="notification-icon dashbg-red">
															<i class="fa fa-trash" aria-hidden="true">
															</i>
															</span>
															</a>
															</td>

														</tr>
													</table>
												</td>
										<?php
												}
												$count++;
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
<script>
	function status(val)
	{
		<?php
			if($s2 != "")
			{
		?>
			 location.replace("entire-enquiry.php?s1="+val+"<?php echo '&s2='.$s2 ?>");
		<?php
			}
			else
			{
		?>
			location.replace("entire-enquiry.php?s1="+val);
		<?php
			}
		?>
	}
	function stage(val)
	{
		<?php
			if($s1 != "")
			{
		?>
			 location.replace("entire-enquiry.php?s2="+val+"<?php echo '&s1='.$s1 ?>");
		<?php
			}
			else
			{
		?>
			location.replace("entire-enquiry.php?s2="+val);
		<?php
			}
		?>
	}
</script>
</body>
</html>