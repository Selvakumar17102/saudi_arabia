<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$id = $_REQUEST["id"];
	$ids = $_REQUEST["ids"];

	$test = $test1 = "";
	
	if($id == 1)
	{
		$test = "MileStone";
	}
	if($id == 2)
	{
		$test = "Monthly";
	}
	if($id == 3)
	{
		$test = "Prorata";
	}

	if($ids == 1)
	{
		$test1 = "Commercially Open";
	}
	if($ids == 2)
	{
		$test1 = "Project Closed";
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
	<meta name="description" content="Invoice Projects | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Invoice Projects | Project Management System" />
	<meta property="og:description" content="Invoice Projects | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice Projects | Project Management System</title>
	
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
				<div class="col-sm-11"><h4 class="breadcrumb-title">Project Invoice</h4></div>
				<?php
					if($ids != "")
					{
				?>
				<div class="col-sm-1"><a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a></div>
				<?php
					}
				?>
			</div>
			<?php
				if($ids == "")
				{
			?>
			<div class="row head-count m-b30">

				<div class="col-lg-6">
					<a href="invoice-projects.php?ids=1&id=<?php echo $id ?>" title="Commercially Open Projects"><div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Commercially Open
							</h4>
							<span class="wc-stats">
								<?php $tend1 = "SELECT * FROM project where status = 'Commercially Open' AND pterms='$id'";
										$tend2 = $conn->query($tend1);
										$tend = $tend2->num_rows;
										if($tend > 0)
										{
											echo $tend;
										}
										else
										{
											echo $tend = 0;
										}
										?>
							</span>		
						
						</div>				      
					</div><a>
				</div>

				<div class="col-lg-6">
					<a href="invoice-projects.php?ids=2&id=<?php echo $id ?>" title="Project Closed"><div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Project Closed
							</h4>
							<span class="wc-stats">
								<?php $jobin1 = "SELECT * FROM project where status = 'Project Closed' AND pterms='$id'";
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
			<?php
				}
			?>

			<div class="row">
				<?php
					if($ids != "")
					{
						$sql = "SELECT * FROM project WHERE pterms='$id' AND status='$test1' ORDER BY id DESC";
					}
					else
					{
						$sql = "SELECT * FROM project WHERE pterms='$id' ORDER BY id DESC";
					}
					$result = $conn->query($sql);
					$invoiced = $collected = $outstanding = 0;
					while($row = $result->fetch_assoc())
					{
						$pid = $row["proid"];

						$sql1 = "SELECT * FROM invoice WHERE pid='$pid'";
						$result1 = $conn->query($sql1);
						while($row1 = $result1->fetch_assoc())
						{
							$invoiced += $row1["demo"];

							if($row1["paystatus"] == 2)
							{
								$collected += $row1["current"];
							}
						}
					}
					$outstanding = $invoiced - $collected;
				?>
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
					<h4 style="text-align: center;padding-bottom: 20px"><?php echo $test ?> Projects</h4>
                    <div class="widget-box">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-4">
									<h4 style="text-align: left">Total Invoiced: QAR <?php echo number_format($invoiced,2) ?></h4>
								</div>
								<div class="col-sm-4">
									<h4>Total Collected: QAR <?php echo number_format($collected,2) ?></h4>
								</div>
								<div class="col-sm-4">
									<h4 style="text-align: right">Total Outstanding: QAR <?php echo number_format($outstanding,2) ?></h4>
								</div>
							</div>
						</div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="color: #C54800">S.NO</th>
											<th>Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Scope</th>
											<th>Po Value</th>
											<th>Invoiced Value</th>
											<th>Collected Value</th>
											<th>Yet To Invoice</th>
											<th>Outstanding Value</th>
											<?php
														if($user == "conserveadmin")
														{
													?>
											<th>Last Updated</th>
											<?php
														}
													?>
											<?php
												if($rowside["id"] != 2)
												{
											?>
											<th>Action</th>
											<th>Month Invoice</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											if($ids != "")
											{
												$sql = "SELECT * FROM project WHERE pterms='$id' AND status='$test1' ORDER BY id DESC";
											}
											else
											{
												$sql = "SELECT * FROM project WHERE pterms='$id' ORDER BY id DESC";
											}
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$eid = $row["eid"];
												$pid = $row["id"];
												$scope = $row["scope"];
												$proid = $row["proid"];
												$total = $row["value"];

												$sql6 = "SELECT * FROM mod_details WHERE po_no='$pid' AND control='4' ORDER BY id DESC LIMIT 1";
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

												$scopev = "";

												$sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();
												$rfqid = $row1["rfqid"];

												if($scope != 0 && $scope != "")
												{
													$sql4 = "SELECT * FROM scope WHERE id='$scope'";
													$result4 = $conn->query($sql4);
													$row4 = $result4->fetch_assoc();

													$scopev = $row4["scope"];
												}
												else
												{
													$scopev = $row1["scope"];
												}

												if($row["status"] == "Commercially Open" || $row["status"] == "Project Closed")
												{
													echo '<tr>';
													echo '<td><center>'.$count.'</center></td>';
													echo '<td><center>'.$row["divi"].'</center></td>';
													echo '<td><center>'.$row["proid"].'</center></td>';
													echo '<td><center>'.$row1["name"].'</center></td>';
													echo '<td><center>'.$row1["cname"].'</center></td>';
													echo '<td><center>'.$scopev.'</center></td>';
													echo '<td><center>QAR '.number_format($total,2).'</center></td>';

													$sql2 = "SELECT sum(demo) as current FROM invoice WHERE pid='$proid'";
													$result2 = $conn->query($sql2);
													$row2 = $result2->fetch_assoc();

													if($row2["current"] == "")
													{
														$row2["current"] = 0;
													}

													$sql3 = "SELECT sum(current) as current FROM invoice WHERE pid='$proid' AND paystatus='2'";
													$result3 = $conn->query($sql3);
													$row3 = $result3->fetch_assoc();

													if($row3["current"] == "")
													{
														$row3["current"] = 0;
													}

													echo '<td><center>QAR '.number_format($row2["current"],2).'</center></td>';
													echo '<td><center>QAR '.number_format($row3["current"],2).'</center></td>';
													echo '<td><center>QAR '.number_format($total-$row2["current"],2).'</center></td>';
													echo '<td><center>QAR '.number_format($row2["current"] - $row3["current"],2).'</center></td>';
													?>
													<?php
														if($user == "conserveadmin")
														{
													?>
														<td><center>
													<?php
															if($row6["user_id"] != "")
															{
																echo $s1.' by '.$row6["user_id"].'<br>'.date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.rtrim($row6["content"], ", ");
															}
															else
															{
																echo "-";
															}
													?>
														</center></td>
														<?php
														}
													?>
													<?php
													if($rowside["id"] != 2)
													{
													echo '<td><center><a href="invoice.php?id='.$pid.'" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>';
													$a = $b = "";
													if($row["inv"] == 0)
													{
														$a = "Selected";
													}
													else
													{
														$b = "Selected";
													}
											?>
													<td>
														<select class="form-control" onchange="update('<?php echo $row['id'] ?>',this.value)">
															<option <?php echo $a ?> value="1">Yes</option>
															<option <?php echo $b ?> value="2">No</option>
														</select>
													</td>
											<?php
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
	function update(id,value)
	{
		$.ajax({
            type: "POST",
            url: "assets/ajax/update-client.php",
            data:{'id':id,'value':value},
			success: function(data)
            {
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
	}
</script>
</body>
</html>