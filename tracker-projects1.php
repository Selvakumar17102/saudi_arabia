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

	if(isset($_POST['set']))
	{
		$p_status = $_POST['p_status'];

		if($division == "")
		{
			$sql = "UPDATE project SET inv='$p_status' WHERE status='Commercially Open' OR status='Running' ORDER BY id DESC";
		}else{
			$sql = "UPDATE project SET inv='$p_status' WHERE (status='Commercially Open' OR status='Running') AND divi='$division' ORDER BY id DESC";
		}
		if($conn->query($sql) == true)
		{
			header("location: tracker-projects.php?msg=update&division=$division");
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

			<form method="post">
				<div class="row">
					<div class="col-sm-6">
						<select name="division" class="form-control" onchange="get_divi(this.value)">
							<option value="" selected value disabled>Select Division</option>
							<option value="All">All </option>
							<option value="ENGINEERING">ENGINEERING </option>
							<option value="SIMULATION">SIMULATION & ANALYSIS</option>
							<option value="SUSTAINABILITY">SUSTAINABILITY</option>
							<option value="ENVIRONMENTAL">ENVIRONMENTAL</option>
							<option value="ACOUSTICS">ACOUSTICS</option>
							<option value="LASER SCANNING">LASER SCANNING</option>
						</select>
					</div>
					<div class="col-sm-6">
						<select name="p_status" id="p_status" class="form-control">
							<option selected value disabled>Select Status</option>
							<option value="0">Yes</option>
							<option value="1">No</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-10"></div>
					<div class="col-sm-2"><input type="submit" name="set" value="submit" class="btn btn-success mt-2" style="float: right"></div>
				</div>
			</form>

			<div class="row">
				<?php
					if($division == "")
                    {
                        $sql = "SELECT * FROM project ORDER BY id DESC";
                    }else{
                        $sql = "SELECT * FROM project ORDER BY id DESC";
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
											<th>Status</th>
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
											<th>Invoice Status</th>
											<th>Invoice Count</th>
											<th>Invoice Month</th>
											<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            if($division == "")
                                            {
                                                $sql = "SELECT * FROM project WHERE status='Commercially Open' OR status='Running' ORDER BY id DESC";
                                            }else{
                                                $sql = "SELECT * FROM project WHERE (status='Commercially Open' OR status='Running') AND divi='$division' ORDER BY id DESC";
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

												$sql4 = "SELECT * FROM invoice_traker WHERE proid='$pid'";
												$result4 = $conn->query($sql4);
												$row4 = $result4->fetch_assoc();

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
													echo '<tr>';
													echo '<td><center>'.$count.'</center></td>';
													echo '<td><center>'.$row["divi"].'</center></td>';
													echo '<td><center>'.$row["proid"].'</center></td>';
													echo '<td><center>'.$row1["name"].'</center></td>';
													echo '<td><center>'.$row1["cname"].'</center></td>';
													echo '<td><center>'.$s.'</center></td>';
													echo '<td><center>QAR '.number_format($total,2).'</center></td>';
													echo '<td><center>'.$row['status'].'</center></td>';

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
													$a = $b = $display = "";
													if($row["inv"] == 0)
													{
														$a = "Selected";
														$display = "display: block";
													}
													else
													{
														$b = "Selected";
														$display = "display: none";
													}
											?>
													<td>
														<select class="form-control" onchange="update('<?php echo $row['id'] ?>',this.value)">
															<option <?php echo $a ?> value="1">Yes</option>
															<option <?php echo $b ?> value="2">No</option>
														</select>
													</td>
													<td>
														<input type="number" id="<?php echo $pid;?>" class="form-control" value="<?php echo $row4['invoice_count'];?>" style="<?php echo $display;?>">
													</td>
													<td>
														<input type="date" id="date<?php echo $pid;?>" class="form-control" value="<?php echo $row4['date'];?>" style="<?php echo $display;?>">
													</td>
													<td>
														<button type="submit" class="btn" style="float: right" onclick="update_invoice(<?php echo $pid;?>)">SAVE</button>
													</td>
											<?php
													}
													echo '</tr>';
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
	function update(id,value)
	{
		if(value==1)
		{
			document.getElementById(id).style.display = "block";
			document.getElementById("date"+id).style.display = "block";
		}else{
			document.getElementById(id).style.display = "none";
			document.getElementById("date"+id).style.display = "none";
		}
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
			location.replace("tracker-projects.php?id=<?php echo $id;?>&division="+division);
		}else{
			location.replace("tracker-projects.php?id=1");
		}
	}
	function update_invoice(pid)
	{
		let invoice_count = document.getElementById(pid).value;
		let invoice_month = document.getElementById('date'+pid).value;
		$.ajax({
            type: "POST",
            url: "assets/ajax/update-client.php",
            data:{'pid':pid,'invoice_count':invoice_count,'invoice_month': invoice_month},
			success: function(data)
            {
				if(data == true)
				{
					alert("Updated!");
				}else{
					alert(data);
				}
            }
        });
	}
</script>
</body>
</html>