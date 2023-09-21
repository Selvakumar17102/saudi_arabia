<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

	$user = $_SESSION["user"];

	$division = $_REQUEST["division"];

	if($division == "SIMULATION")
	{
		$division = "SIMULATION & ANALYSIS";
	}
	if($division == "OIL")
	{
		$division = "OIL & GAS";
	}

	$start_date = $_REQUEST['sdate'];
    $end_date = $_REQUEST['ldate'];
	$stage = $_REQUEST['stage'];

	if($start_date == "")
    {
        $start_date = date("Y-m-01");
        $end_date = date("Y-m-d");
    }

	if(isset($_POST['search']))
    {
        $division = $_POST['division'];
        $fd = $_POST['fd'];
        $td = $_POST['td'];
		$stage = $_POST['stage'];

        header("Location: deadline-report.php?sdate=$fd&ldate=$td&division=$division&stage=$stage");
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
	<title>Late Submitted Proposal Report | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Late Submitted Proposal Report</h4>
					</div>
                    <div class="col-sm-1">
                        <a href="entire-enquiry.php" style="color: #fff" class="bg-primary btn">Back</a>
                    </div>
				</div>
            </div>

			<div class="row mb-3">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">

                    <div class="widget-box card">

                        <div class="card-header">
                            <h4>Custom Search</h4>
                        </div>
                        <div class="widget-inner">
                            <form method="post" class="edit-profile">
								
                                <div class="form-group row">
									<div class="col-sm-3">
										<label class="col-form-label">Division</label>
										<select name="division" id="division" class="form-control">
											<option value="" selected value disabled>Select Division</option>
											<option value="ENGINEERING">ENGINEERING </option>
											<option value="SIMULATION">SIMULATION & ANALYSIS</option>
											<option value="SUSTAINABILITY">SUSTAINABILITY</option>
											<option value="ENVIRONMENTAL">ENVIRONMENTAL</option>
											<option value="ACOUSTICS">ACOUSTICS</option>
											<option value="LASER SCANNING">LASER SCANNING</option>
											<option value="OIL">OIL & GAS</option>
										</select>
									</div>

									<div class="col-sm-3">
										<label>Project Type</label>
										<select name="stage" id="stage" class="form-control">
											<option value="" selected value disabled>Select Project Type</option>
											<option value="Tender">Tender</option>
											<option value="Job In Hand">Job In Hand</option>
										</select>
									</div>

                                    <div class="col-sm-2 course">
										<label class="col-form-label">From Date</label>
                                        <input class="form-control" type="date" name="fd" value="<?php echo $start_date ?>" required>
                                    </div>

                                    <div class="col-sm-2 course">
										<label class="col-form-label">To Date</label>
                                        <input class="form-control" type="date" name="td" value="<?php echo $end_date ?>" required>
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="submit" name="search" class="btn" value="Search" style="margin-top: 30px">
                                    </div>
                                </div>
                            </form>
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
											<th>Enquiry Date</th>
											<th style="color: #C54800">RFQ Id</th>
											<th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Responsibility</th>
                                            <th>Division</th>
                                            <th>Scope</th>
                                            <th>Stage</th>
                                            <th>Project Type</th>
                                            <th>Enquiry Status</th>
                                            <th>Project Status</th>
                                            <th>Submission Deadline</th>
                                            <th>Submitted Date</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
										
											$sql1 = "SELECT * FROM enquiry WHERE sub_date BETWEEN '$start_date' AND '$end_date'";
											if($division !="")
											{
												$sql1 .= " AND rfq='$division'";
											}
											if($stage !="")
											{
												$sql1 .= " AND stage='$stage'";
											}
											$sql1 .= " ORDER BY id DESC";
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{
                                                $qdate = $row1['qdate'];

                                                if($row1['sub_date'] == null)
                                                {
                                                    $sub_date = $qdate;
                                                }else{
                                                    $sub_date = $row1['sub_date'];
                                                }

                                                if($sub_date <= $qdate)
                                                {
                                                    continue;
                                                }

												$s = $ps = "";
												$eid = $row1["id"];
												$scope_id = $row1['scope'];
												$scope_type = $row1['scope_type'];

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

												if($scope_type == 1 && $scope_id != 0)
												{
													$sql = "SELECT * FROM scope_list WHERE id='$scope_id'";
													$result = $conn->query($sql);
													if($result->num_rows > 0)
													{
														$row = $result->fetch_assoc();
														$scope = $row["scope"];	
													}
												}														
												else
												{
													$sql = "SELECT * FROM scope WHERE eid='$eid'";
													$result = $conn->query($sql);
													if($result->num_rows > 0)
													{
														while($row = $result->fetch_assoc())
														{
															$scope .= $row["scope"].",";
														}
													}else{
														$scope = $row1['scope'];
													}
												}

												$scope = rtrim($scope, ',');

												$date = strtotime($row1["qdate"]);
												echo '<tr class="'.$tempcolor.'">';
												echo '<td><center>'.$count.'</center></td>';
												echo '<td><center>'.date('d-m-Y', strtotime($row1["enqdate"])).'</center></td>';	
												echo '<td><center>'.$row1["rfqid"].'</center></td>';
												
												echo '<td><center><a href="view-enquiry.php?id='.$row1["id"].'">'.$row1["name"].'</a></center></td>';
												echo '<td><center>'.$row1["cname"].'</center></td>';
												echo '<td><center>'.$row1["responsibility"].'</center></td>';
												echo '<td><center>'.$row1["rfq"].'</center></td>';
												echo '<td><center>'.$scope.'</center></td>';
												echo '<td><center>'.$row1["stage"].'</center></td>';
												echo '<td><center>'.$row1["division"].'</center></td>';
												echo '<td><center>'.ucwords(strtolower($row1["qstatus"])).'</center></td>';
												echo '<td><center>'.ucwords(strtolower($ps)).'</center></td>';
												echo '<td><center>'.date('d-m-Y', $date).'</center></td>';
												if($row1['sub_date'] != null)
												{
													echo '<td><center>'.date('d-m-Y', strtotime($row1["sub_date"])).'</center></td>';
												}else{
													echo '<td><center>'.date('d-m-Y', strtotime($row1["qdate"])).'</center></td>';
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