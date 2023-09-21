<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

	$user = $_SESSION["user"];
	$id = $_REQUEST["id"];
	$ids = $_REQUEST["ids"];

	$division = $_REQUEST["division"];
    $s_date = $_REQUEST["s_date"];
	$e_date = $_REQUEST["e_date"];
	$status = $_REQUEST["status"];
	$type = $_REQUEST["type"];

	if($e_date=='' || $s_date==''){
		$s_date = date('Y-m-01');
		$e_date = date('Y-m-t');
	}

	if($division == "SIMULATION")
	{
		$division = "SIMULATION & ANALYSIS";
	}
	if($division == "All")
	{
		$division = "";
	}

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

	if(isset($_POST['set']))
	{
		$p_status = $_POST['p_status'];

		if($ids != "")
		{
			if($division == "")
			{
				$sql = "UPDATE project SET inv='$p_status' WHERE pterms='$id' AND status='$test1'";
			}else{
				$sql = "UPDATE project SET inv='$p_status' WHERE pterms='$id' AND status='$test1' AND divi='$division'";
			}
		}
		else
		{
			if($division == "")
			{
				$sql = "UPDATE project SET inv='$p_status' WHERE pterms='$id'";
			}else{
				$sql = "UPDATE project SET inv='$p_status' WHERE pterms='$id' AND divi='$division'";
			}
		}
		if($conn->query($sql)==TRUE)
		{
			header("Location: invoice-projects.php?msg=Updated!&id=$id&ids=$ids&division=$division");
		}
	}

    if(isset($_POST['submit']))
    {
        $divi = $_POST['division'];
        $s_date = $_POST['s_date'];
        $e_date = $_POST['e_date'];
        $status = $_POST['status'];
        $type = $_POST['type'];
		$count = count($status);

		$filltered_status = "";
		for ($i=0; $i < $count; $i++) { 
			$filltered_status .= $_POST['status'][$i].',';
		}
		rtrim(',', $filltered_status);
		$_SESSION['project_status'] = $filltered_status;

        header("Location: consolidate.php?division=$divi&s_date=$s_date&e_date=$e_date&type=$type");
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
	<title>Consolidate Report | Project Management System</title>
	
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
				<div class="col-sm-11"><h4 class="breadcrumb-title">Consolidate Report</h4></div>
				<div class="col-sm-1"><a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a></div>
			</div>
			<div class="widget-box">
                <div class="widget-inner">
					<form method="post">
						<div class="row m-b30">
							<div class="col-sm-4">
								<select name="division" class="form-control">
									<option value="" selected value disabled>Select Division</option>
									<option value="All">All </option>
									<?php
										switch ($division) {
											case 'ENGINEERING':
												$eng = "selected";
												break;
											case 'SIMULATION':
												$sim = "selected";
												break;
											case 'SUSTAINABILITY':
												$sust = "selected";
												break;
											case 'ENVIRONMENTAL':
												$env = "selected";
												break;
											case 'ACOUSTICS':
												$aco = "selected";
												break;
											case 'LASER SCANNING':
												$laser = "selected";
												break;
										}
									?>
									<option value="ENGINEERING" <?php echo $eng;?>>ENGINEERING </option>
									<option value="SIMULATION" <?php echo $sim;?>>SIMULATION & ANALYSIS</option>
									<option value="SUSTAINABILITY" <?php echo $sust;?>>SUSTAINABILITY</option>
									<option value="ENVIRONMENTAL" <?php echo $env;?>>ENVIRONMENTAL</option>
									<option value="ACOUSTICS" <?php echo $aco;?>>ACOUSTICS</option>
									<option value="LASER SCANNING" <?php echo $laser;?>>LASER SCANNING</option>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="date" name="s_date" id="s_date" class="form-control" value="<?php echo $s_date;?>">
							</div>
							<div class="col-sm-4">
								<input type="date" name="e_date" id="e_date" class="form-control" value="<?php echo $e_date;?>">
							</div>
						</div>
						<div class="row m-b30">
							<div class="col-sm-6">
								<select class="form-control" name="status[]" multiple>
									<option selected value disabled>Select Status</option>
									<option value="Running">Running</option>
									<option value="Commercially Open">Commercially Open</option>
									<option value="Project Closed">Project Closed</option>
									<option value="Commercially Closed">Commercially Closed</option>
								</select>
							</div>
							<div class="col-sm-6">
								<?php echo $type;?>
								<select class="form-control" name="type">
									<option value="" selected value disabled>Select Type</option>
									<?php
										if($type !="")
										{
											if($type == "Deputation"){
												$dep = "selected";
											}else{
												$pro = "selected";
											}
										}
									?>
									<option value="Deputation" <?php echo $dep;?>>Deputation</option>
									<option value="Project" <?php echo $pro;?>>Project</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-10"></div>
							<div class="col-sm-2">
								<input type="submit" value="Search" class="btn btn-success" name="submit" style="width: 100%">
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="row">
				<?php
					// if($ids != "")
					// {
					// 	if($division == "")
					// 	{
					// 		$sql = "SELECT * FROM project WHERE pterms='$id' AND status='$test1' ORDER BY id DESC";	
					// 	}else{
					// 		$sql = "SELECT * FROM project WHERE pterms='$id' AND status='$test1' AND divi='$division' ORDER BY id DESC";
					// 	}
					// }
					// else
					// {
					// 	if($division == "")
					// 	{
					// 		$sql = "SELECT * FROM project WHERE pterms='$id' ORDER BY id DESC";
					// 	}else{
					// 		$sql = "SELECT * FROM project WHERE pterms='$id' AND divi='$division' ORDER BY id DESC";
					// 	}
					// }
					$sql = "SELECT * FROM project WHERE proid!=''";
					if($division !="")
					{
						$sql .= " AND divi='$division'";
					}
					
					// $result = $conn->query($sql);
					// $invoiced = $collected = $outstanding = 0;
					// while($row = $result->fetch_assoc())
					// {
					// 	$pid = $row["proid"];

					// 	$sql1 = "SELECT * FROM invoice WHERE pid='$pid'";
					// 	$result1 = $conn->query($sql1);
					// 	while($row1 = $result1->fetch_assoc())
					// 	{
					// 		$invoiced += $row1["demo"];

					// 		if($row1["paystatus"] == 2)
					// 		{
					// 			$collected += $row1["current"];
					// 		}
					// 	}
					// }
					// $outstanding = $invoiced - $collected;
				?>
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
					<h4 style="text-align: center;padding-bottom: 20px">Consolidate Report</h4>
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="color: #C54800">S.NO</th>
											<th>Division</th>
											<th>Status</th>
											<th>Sub Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
                                            <th>Scope</th>
                                            <th>Responsibility</th>                                            
                                            <th>Month of Award</th>
											<th>Po Value</th>
											<th>Invoiced Value</th>
											<th>Collected Value</th>
											<th>Yet To Invoice</th>
											<th>Outstanding Value</th>
											<th>Project Status</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            $sql = "SELECT * FROM project WHERE proid!=''";
                                            if($division !="")
                                            {
                                                $sql .= " AND divi='$division'";
                                            }
											if($_SESSION['project_status'] !="")
											{
												$my_status = explode(',', $_SESSION['project_status']);
												$count_my_status = count($my_status);
												for ($i=0; $i < $count_my_status; $i++) {
													$pro_status = $my_status[$i];
													if($i == 0)
													{
														$sql .= " AND (status='$pro_status' OR";
													}else{
														if($pro_status !="")
														{
															if($i == $count_my_status)
															{
																$sql .= " status='$pro_status'";
															}else{
																$sql .= " status='$pro_status' OR";
															}
														}
													}
												}
												$sql = rtrim($sql, 'OR');
												$sql.=')';
											}
											
											if($type !="")
											{
												$sql .= " AND subdivi='$type'";
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
												$scope_type = $row['scope_type'];

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

												$sql5 = "SELECT * FROM invoice WHERE date BETWEEN '$s_date' AND '$e_date' AND pid='$proid'";
												$result5 = $conn->query($sql5);
												if($result5->num_rows == 0)
												{
													continue;
												}

                                                // if($s_date != "")
                                                // {
                                                //     if($row1['qdatec'] < $s_date || $row1['qdatec'] > $e_date)
                                                //     {
                                                //         continue;
                                                //     }
                                                // }
                                                
												$rfqid = $row1["rfqid"];

												if($scope_type == 0 || $scope_type=="2")
												{
													$sql2 = "SELECT * FROM scope WHERE eid='$eid'";
													$result2 = $conn->query($sql2);
													if($result2->num_rows > 0)
													{	
														if($result2->num_rows == 1){
															$row2 = $result2->fetch_assoc();
															$s = $row2["scope"];
														} else{
															while($row2 = $result2->fetch_assoc())
															{
																$s .= $row2["scope"].",";
															}
														}
													}else{
														$s = $row1['scope'];
													}
												}
												else
												{
													$scope_id = $row1['scope'];

													$sql2 = "SELECT * FROM scope_list WHERE id='$scope_id'";
													$result2 = $conn->query($sql2);
													$row2 = $result2->fetch_assoc();

													$s = $row2	["scope"];
												}

												$sql2 = "SELECT sum(demo) as current FROM invoice WHERE pid='$proid' AND date BETWEEN '$s_date' AND '$e_date'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();

												if($row2["current"] == "")
												{
													$row2["current"] = 0;
												}
												
												$sql3 = "SELECT sum(current) as current FROM invoice WHERE pid='$proid' AND date BETWEEN '$s_date' AND '$e_date'";
												$result3 = $conn->query($sql3);
												$row3 = $result3->fetch_assoc();

												if($row3["current"] == "")
												{
													$row3["current"] = 0;
												}

												$sql7 = "SELECT * FROM invoice WHERE pid='$proid' AND date BETWEEN '$s_date' AND '$e_date'";
												$result7 = $conn->query($sql7);
												$num_rows = $result7->num_rows;
												$current_amt = $total_po = $collected_value = 0;
												while ($row7 = $result7->fetch_assoc()) {

													if($s_date != "")
													{
														if($row7['date'] < $s_date || $row7['date'] > $e_date)
														{
															continue;
														}else{
															$invoiced_amt = $row7['demo'];
															$total_po = $row7['total'];
															$collected_value += $row7['current'];
														}
													}
												}

												// if($row["status"] == "Commercially Open" || $row["status"] == "Project Closed")
												// {
													echo '<tr>';
													echo '<td><center>'.$count.'</center></td>';
													echo '<td><center>'.$row["divi"].'</center></td>';
													echo '<td><center>'.$row["status"].'</center></td>';
													echo '<td><center>'.$row['subdivi'].'</center></td>';
													echo '<td><center>'.$row["proid"].'</center></td>';
													echo '<td><center>'.$row1["name"].'</center></td>';
													echo '<td><center>'.$s.'</center></td>';
													echo '<td><center>'.$row1['responsibility'].'</center></td>';
													$time=strtotime($row1["qdatec"]);
													$month=date("F'y",$time);
													echo '<td><center>'.$month.'</center></td>';
													echo '<td><center>₹ '.number_format($total_po,2).'</center></td>';
													echo '<td><center>₹ '.number_format($invoiced_amt,2).'</center></td>';

													
													echo '<td><center>₹ '.number_format($collected_value,2).'</center></td>';
													echo '<td><center>₹ '.number_format($total_po - $invoiced_amt,2).'</center></td>';
													echo '<td><center>₹ '.number_format($invoiced_amt - $collected_value,2).'</center></td>';
													echo '<td><center>'.$row["status"].'</center></td>';
													echo '</tr>';
													$count++;
												// }
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
	function get_divi(division)
	{
		if(division !="All")
		{
			location.replace("invoice-projects.php?id=<?php echo $id;?>&division="+division);
		}else{
			location.replace("invoice-projects.php?id=1");
		}
	}
</script>
</body>
</html>