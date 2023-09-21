<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$date = date("Y-m-d");

	$id = $_REQUEST["id"];
	$div = $_REQUEST["div"];
	$division = $_REQUEST["division"];

	$s_date = $_REQUEST["s_date"];
	$e_date = $_REQUEST["e_date"];

	$divi = "";

	if($div == "Sustainability")
	{
		$divi = "SUSTAINABILITY";
	}
	if($div == "Engineering" || $div == "ENGINEERING SERVICES")
	{
		$divi = "ENGINEERING SERVICES";
	}
	if($div == "SIMULATION")
	{
		$division = "SIMULATION & ANALYSIS";
		$divi = "SIMULATION & ANALYSIS SERVICES";
	}
	if($div == "DEPUTATION")
	{
		$divi = "DEPUTATION";
	}

	if($division == "SIMULATION")
	{
		$division = "SIMULATION & ANALYSIS";
		$divi = "SIMULATION & ANALYSIS";
	}
	if($division == "OIL")
	{
		$division = "OIL & GAS";
		$divi = "OIL & GAS";
	}

	if($s_date =="")
	{
		$s_date = date('Y-m-01');
		$e_date = date('Y-m-d');

	}

	
    if(isset($_POST['submit']))
    {
        $divi = $_POST['division'];
        $s_date = $_POST['s_date'];
        $e_date = $_POST['e_date'];

        header("Location: po_tracker.php?division=$divi&s_date=$s_date&e_date=$e_date");
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
	<meta name="description" content="All Projects | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Projects | Project Management System" />
	<meta property="og:description" content="All Projects | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>PO Tracker | Project Management System</title>
	
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
			<div class="row m-b30">
				<div class="col-sm-11">
					<h4 class="breadcrumb-title">PO Tracker</h4>
				</div>
				<div class="col-sm-1">
					<a href="all-projects.php" style="color: #fff" class="bg-primary btn">Back</a>			
				</div>
			</div>
            <form method="post">
                <div class="row m-b30">
                    <div class="col-sm-4">
                        <select name="division" class="form-control">
                            <option value="" selected value disabled>Select Division</option>
                            <option value="All">All </option>
                            <option value="ENGINEERING">ENGINEERING </option>
                            <option value="SIMULATION">SIMULATION & ANALYSIS</option>
                            <option value="SUSTAINABILITY">SUSTAINABILITY</option>
                            <option value="ACOUSTICS">ACOUSTICS</option>
                            <option value="LASER SCANNING">LASER SCANNING</option>
							<option value="OIL">OIL & GAS</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <input type="date" name="s_date" id="s_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                    </div>
                    <div class="col-sm-3">
                        <input type="date" name="e_date" id="e_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" value="Search" class="btn btn-success" name="submit">
                    </div>
                </div>
            </form>

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
                                            <th rowspan="2" style="color: #C54800">S.NO</th>
											<th rowspan="2">Client Name</th>
											<th rowspan="2">Division</th>
											<th rowspan="2">Project ID</th>
											<th rowspan="2">Project Name</th>
											<th rowspan="2">Scope</th>
											<th rowspan="2">Responsibility</th>
											<th>Total PO(SAR)</th>
                                            <th rowspan="2">Month of Award</th>
											<th rowspan="2">Status of the Projects</th>
                                            <th rowspan="2">Po Status</th>
                                            <th rowspan="2">Open Status</th>
                                            <th rowspan="2">Expiry Date</th>
                                        </tr>
										<tr>
											<th>
												<table>
													<td style="border:none;"><center>Value</center></td>
													<td style="border:none;"><center>VAT</center></td>
												</table>
											</th>
										</tr>
                                    </thead>
									<tbody>
										<?php
                                            $sql = "SELECT * FROM project WHERE (status='Commercially Open' OR status='Running') AND open_status='No'";
                                            if($division !='')
                                            {
                                                $sql .= " AND divi='$division'";
                                            }
                                            if($s_date !="")
                                            {
                                                $sql .= " AND exp_date BETWEEN '$s_date' AND '$e_date'";
                                            }
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$s = "";
												$id = $row["id"];
												$enq_id = $row["eid"];
												$status = $row["nostatus"];

												$sql6 = "SELECT * FROM mod_details WHERE po_no='$id' AND control='3' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();
												if($row6["update_details"] == 1)
												{
													$s1 = "Created";
												}
												else
												{
													$s1 = "Edited";
												}
												
												if($status == 0)
												{
													$tempcolor = "#f98585";
												}
												$id = $row["eid"];
												$pid = $row["id"];
                                                
												if($div == "")
												{
													$sql1 = "SELECT * FROM enquiry WHERE id='$id'";
												}
												else
												{
													$sql1 = "SELECT * FROM enquiry WHERE id='$id' AND division='$divi'";
												}
												
												$result1 = $conn->query($sql1);
												if($result1->num_rows > 0)
												{
													$divimain = $row["divi"];													

													if($divimain == "")
													{
														$divimain = $row1["division"];
													}
													$row1 = $result1->fetch_assoc();

													$scope_type = $row1['scope_type'];
													$scope_id = $row1['scope'];
													$rfqid = $row1["rfqid"];
													$client_name = $row1["cname"];

													$scope = "";

													if($scope_type == 0 || $scope_type=="2")
													{
														$sql2 = "SELECT * FROM scope WHERE eid='$enq_id'";
														$result2 = $conn->query($sql2);
														if($result2->num_rows > 0)
														{	
															if($result2->num_rows == 1){
																$row2 = $result2->fetch_assoc();
																$scope = $row2["scope"];
															} else{
																while($row2 = $result2->fetch_assoc())
																{
																	$scope .= $row2["scope"].",";
																}
															}
														}else{
															$scope = $row1['scope'];
														}
													}
													else
													{
														$sql2 = "SELECT * FROM scope_list WHERE id='$scope_id'";
														$result2 = $conn->query($sql2);
														$row2 = $result2->fetch_assoc();

														$scope = $row2	["scope"];
													}

													echo '<tr style="background-color:'.$tempcolor.'">';
													echo '<td><center>'.$count.'</center></td>';
													echo '<td><center>'.$client_name.'</center></td>';
													echo '<td><center>'.$divimain.'</center></td>';
													echo '<td><center>'.$row["proid"].'</center></td>';
													echo '<td><center>'.$row1["name"].'</center></td>';
													echo '<td><center>'.$scope.'</center></td>';
													echo '<td><center>'.$row1['responsibility'].'</center></td>';
													echo '<td>
															<table style="margin-top:-7px;">
																<td style="border:none;"><center>'.number_format($row["value"],2).'</center></td>
																<td style="border:none;"><center>'.number_format($row["gst_value"],2).'</center></td>
															</table>
														</td>';
													$time=strtotime($row1["qdatec"]);
													$month=date("F'y",$time);
													echo '<td><center>'.$month.'</center></td>';
													echo '<td><center>'.$row["status"].'</center></td>';
                                                    echo '<td><center>'.$row['po_status'].'</center></td>';
                                                    echo '<td><center>'.$row['open_status'].'</center></td>';
                                                    if($row['open_status'] == "No")
                                                    {
                                                        echo '<td><center>'.date('d-m-Y', strtotime($row['exp_date'])).'</center></td>';
                                                    }else{
                                                        echo '<td><center>-</center></td>';
                                                    }
													echo '</tr>';
													$count++;
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