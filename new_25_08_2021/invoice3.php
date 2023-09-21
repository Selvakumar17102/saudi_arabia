<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

	$id = $_REQUEST["id"];
	
	$testing = "TRUE";

    $sql1 = "SELECT * FROM project WHERE id='$id'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

	$eid = $row1["eid"];
	$totalvalue = $row1["value"];

    $sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();

	$rfqid = $row2["rfqid"];
	
	$sql3 = "SELECT * FROM invoice";
	$result3 = $conn->query($sql3);
	$tot = $result3->num_rows;

	$invid = "INV-".strtoupper(date('M'))."-".date('Y')."-".++$tot;

	$sql4 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqid' AND paystatus='2'";
	$result4 = $conn->query($sql4);
	$row4 = $result4->fetch_assoc();

	$totcurrent = $row4["current"];

	$rem = $totalvalue - $totcurrent;

	if(isset($_POST["pay"]))
	{
		$term = $_POST["term"];
		$total = $_POST["total"];
		$invid = $_POST["invid"];
		$invdoc = $_POST["invdoc"];
		$current = $_POST["current"];
		$po = $_POST["po"];
		$month1 = $_POST["month"];
		$date = $_POST["date"];

		$sql9 = "SELECT * FROM invoice WHERE invid='$invid'";
		$result9 = $conn->query($sql9);
		if($result9->num_rows > 0)
		{
			echo '<script language="javascript">';
		    echo 'alert("Invoice Number Repeated!")';
		    echo '</script>';
		}
		else
		{	
			if($row1["pterms"] == 2)
			{
				$month = date('m',strtotime($date));
				$year = date('Y',strtotime($date));

				$start = date($year.'-'.$month.'-01');
				$end = date($year.'-'.$month.'-t');

				$sql10 = "SELECT * FROM invoice WHERE term='2' AND date BETWEEN '$start' AND '$end' AND rfqid='$rfqid'";
				$result10 = $conn->query($sql10);
				// if($result10->num_rows > 0)
				// {
				// 	header("location: invoice.php?id=$id&msg=Invoice already generated for the month!");
				// }
				// else
				// {
					if($current > $rem)
					{
						echo '<script language="javascript">';
						echo 'alert("Current Pay is greater than Remaining amount!")';
						echo '</script>';
					}
					else
					{
						$sql5 = "INSERT INTO invoice (invid,rfqid,term,total,current,date,po,invdoc,month,demo) VALUES ('$invid','$rfqid','$term','$total','$current','$date','$po','$invdoc','$month1','$current')";
						if($conn->query($sql5) === TRUE)
						{
							header("location: invoice.php?id=$id&msg=Invoice Generated Successfully!");
						}
					}
				// }
			}
			else
			{
				$pay = $current/100 * $total;
				if($pay > $rem)
				{
					echo '<script language="javascript">';
					echo 'alert("Current Pay is greater than Remaining amount!")';
					echo '</script>';
				}
				else
				{
					$sql5 = "INSERT INTO invoice (invid,rfqid,term,total,current,percent,date,po,invdoc,demo) VALUES ('$invid','$rfqid','$term','$total','$pay','$current','$date','$po','$invdoc','$pay')";
					if($conn->query($sql5) === TRUE)
					{
						header("location: invoice.php?id=$id&msg=Invoice Generated Successfully!");
					}
				}
			}
		}
	}
	$datestart = date('Y-m-01');
	$dateend = date('Y-m-t');

	$project = "";
	if($row1["pterms"] == 1)
	{
		$project = "Milestone";
	}
	if($row1["pterms"] == 2)
	{
		$project = "Monthly";
	}
	if($row1["pterms"] == 3)
	{
		$project = "Prorata";
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
	<meta name="description" content="Invoice | Project Management System" />

	<!-- OG -->
	<meta property="og:title" content="Invoice | Project Management System" />
	<meta property="og:description" content="Invoice | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">

	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice | Project Management System</title>

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

	<script>

	function validate()
	{
		var x = document.getElementById("current").value;

		if(x == "")
		{
			$("#current").css("border", "1px solid red");
        	return false;
		}
	}
</script>

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
				<h4 class="breadcrumb-title"><?php echo $project ?> Projects</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
					<li><a href="#">Invoice</a></li>
					<li><?php echo $project ?></li>
				</ul>
			</div>
			<p style="text-align:center;color:green;"><?php echo $_REQUEST['msg']; ?></p>
			<div class="row widget-box m-b30">
				<div class="col-lg-12 widget-inner">
					<form class="edit-profile" method="post" enctype="multipart/form-data">
						<div class="">

							<div class="form-group row">

								<label class="col-sm-2 col-form-label">Project Id</label>
								<input type="hidden" class="form-control" name="rfqid" value="<?php echo $rfqid ?>">
								<div class="col-sm-4">
									<input type="text" class="form-control" value="<?php echo $row1["proid"] ?>" readonly>
								</div>

							<?php
								if($row1["pterms"] == 1 || $row1["pterms"] == 2)
								{
									$due = $row1["noofm"];
									
									$sql8 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
									$result8 = $conn->query($sql8);
									$num = $result8->num_rows;

									$remain = $due - $num;
							?>

								<label class="col-sm-2 col-form-label">Pending Dues/Instalments</label>
								<div style="margin-top:5px" class="col-sm-4">
									<input type="number" class="form-control" name="remaining" value="<?php echo $remain ?>" readonly>
								</div>

							<?php
								}
							?>

								<input type="hidden" name="term" value="<?php echo $row1["pterms"] ?>">

							</div>

							<div class="form-group row" style="margin-top:30px">

								<label class="col-sm-2 col-form-label">Total</label>
								<div class="col-sm-4">
									<input type="number" class="form-control" name="total" value="<?php echo $totalvalue ?>" readonly>
								</div>

							

								<label class="col-sm-2 col-form-label">Remaining</label>
								<div class="col-sm-4">
									<input type="number" class="form-control" name="remaining" value="<?php echo $rem ?>" readonly>
								</div>

							</div>

							<?php
								if($rem <= 0)
								{
									echo '<div style="margin-top:20px" class="col-sm-12">';
									echo '<center><h4>Payment Finished for this Project</h4></center>';
									echo '</div>';
								}
								else
								{
								$sql6 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0' AND term='2' AND date BETWEEN '$datestart' AND '$dateend'";
								$result6 = $conn->query($sql6);

								if($row1["pterms"] == 1)
								{
									$sql7 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
									$result7 = $conn->query($sql7);
									$number = $result7->num_rows;
									if($number >= $row1["noofm"])
									{
										$testing = "FALSE";
									}
								}
								if($testing == "TRUE")
								{

							?>

							

							<div class="form-group row" style="margin-top:30px">
								
								<label class="col-sm-2 col-form-label">Invoice Id</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="invid" required>
								</div>
								
								<label class="col-sm-2 col-form-label">PO Number</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="po" required>
								</div>
							
								</div>

							<div class="form-group row" style="margin-top:30px">

								<label class="col-sm-2 col-form-label">Invoice Link</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="invdoc">
								</div>

							</div>

							<div class="form-group row" style="margin-top:30px">
								<?php
									if($row1["pterms"] == 2)
									{
								?>
								<label class="col-sm-1 col-form-label">Date</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>" required>
								</div>
								<label class="col-sm-1 col-form-label">Month</label>
								<div class="col-sm-3">
									<select class="form-control" name="month" required>
										<option value disabled selected>Select Month</option>
										<option value="January">January</option>
										<option value="February">February</option>
										<option value="March">March</option>
										<option value="April">April</option>
										<option value="May">May</option>
										<option value="June">June</option>
										<option value="July">July</option>
										<option value="August">August</option>
										<option value="September">September</option>
										<option value="October">October</option>
										<option value="November">November</option>
										<option value="December">December</option>
									</select>
								</div>
								<?php
									}
									if($row1["pterms"] == 1 || $row1["pterms"] == 3)
									{
								?>
								<label class="col-sm-2 col-form-label">Date</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>">
								</div>

								<?php
									}
								?>
								<?php
									if($row1["pterms"] == 1)
									{
								?>
								
								<label class="col-sm-1 col-form-label">Payment Terms</label>
								<div class="col-sm-2">
									<input type="number" step="0.001" class="form-control" name="current" id="current" onkeyup="minus()">
								</div>
								<div class="col-sm-3">
									<input type="number" step="0.001" min="1" class="form-control" name="amount" id="amount" placeholder="Amount" onkeyup="amo()">
								</div>
								<?php
									}
									else
									{
								?>

								<label class="col-sm-1 col-form-label">Current Pay</label>
								<div class="col-sm-3">
									<input type="number" min="1" class="form-control" name="current" id="current">
								</div>

								<?php
									}
								?>

							</div>

							<div class="form-group row" style="margin-top:30px">
								<div class="col-sm-10"></div>
								<div class="col-sm-2">
									<input type="submit" value="Generate Invoice" name="pay" class="btn" onclick="return validate()" style="width: 100%;">
								</div>
							</div>

							<?php
								}
								else
								{
									if($row1["pterms"] == 1)
									{
										echo '<div style="margin-top:20px" class="col-sm-12">';
										echo '<center><h4>Dues finished for this Project</h4></center>';
										echo '</div>';
									}
									// else
									// {
									// 	echo '<div style="margin-top:20px" class="col-sm-12">';
									// 	echo '<center><h4>Invoice already generated for this Month</h4></center>';
									// 	echo '</div>';
									// }	
								}
							}

							?>
							
						</div>
					</form>
				</div>
			</div>
		</div>
			

			<div class="row m-b30">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					
                    	<?php
							$sql = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0' AND paystatus='0' ORDER BY date DESC";
							$result = $conn->query($sql);
                            $count = 1;
                            
						?>
					<div class="card">
						<div class="card-header">
							<h4>List of Generated Invoices</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive col-lg-12">
								<table id="dataTableExample1" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Invoice Id</th>
											<th>PO Ref.</th>
											<th>Invoice Prepared Date</th>
											<th>Invoice Submitted Date</th>
											<th>Invoice Value</th>	
											<?php
											if($row1["pterms"] == 2 OR $row1["pterms"] == 3)
											{
												echo '<th>Payment for the Month</th>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<th>Payment Terms(%)</th>';
											}
										?>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

						<?php
								while($row = $result->fetch_assoc())
								{

                        ?>
                            			<tr>
                                    		<td><center><?php echo $count ?></center></td>
                                            <td><center><?php echo $row["invid"] ?></center></td>
											<td><center><?php echo $row["po"] ?></center></td>
										<td><center><?php echo date('d-m-Y',strtotime($row["date"])) ?></center></td>
											
											<form action="invoice-submit.php?id=<?php echo $id ?>" method="post">
											<td><input type="date" name="sdate" class="form-control" value="<?php echo date('Y-m-d') ?>" required></td>
											<td><center><?php echo $row["current"] ?></center></td>										
                                            
											<?php
											if($row1["pterms"] == 2)
											{
												echo '<td><center>'.$row["month"].'</center></td>';
											}
											if($row1["pterms"] == 3)
											{
												$thismonth = date("F" , strtotime($row["date"]));

												echo '<td><center>'.$thismonth.'</center></td>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<td><center>'.$row["percent"].'%</center></td>';
											}
										?>
											
												<input type="hidden" name="ids" value="<?php echo $row["id"] ?>">
												<td><table class="action"><tr><td><button type="submit" class="btn-link" title="Next"><span class="notification-icon dashbg-yellow"><i style="margin-left:0px" class="fa fa-arrow-right" aria-hidden="true"></i></span></button></td>
												<td><a href="delete-invoice.php?id=<?php echo $row["id"] ?>&mid=<?php echo $id ?>" title="Delete"><span class="notification-icon dashbg-red"><i class="fa fa-trash" aria-hidden="true"></i></span></a></td></tr></table></td>
											</form>
                                        </tr>

                        <?php
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
			<div class="row m-b30">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					
                    	<?php
							$sqls = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0' AND paystatus='1' ORDER BY date DESC";
							$results = $conn->query($sqls);
                            $counts = 1;
                            
						?>
					<div class="card">
						<div class="card-header">
							<h4>List of Submitted Invoices</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive col-lg-12">
								<table id="dataTableExample2" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Invoice Id</th>
											<th>PO Ref.</th>										
											<th>Invoice Prepared Date</th>
											<th>Invoice Submitted Date</th>
											<th>Invoice Value</th>	
											<?php
											if($row1["pterms"] == 2 OR $row1["pterms"] == 3)
											{
												echo '<th>Month</th>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<th>Payment Terms</th>';
												
											}
										?>
											<th>Payment Recieved Date</th>
											<th>Payment Mode</th>
											<th>Current</th>
											<th>Remarks</th>
											<th>Documents</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

						<?php
								while($rows = $results->fetch_assoc())
								{

                        ?>
                            			<tr>
                                    		<td><center><?php echo $counts++ ?></center></td>
                                            <td><center><?php echo $rows["invid"] ?></center></td>
											<td><center><?php echo $rows["po"] ?></center></td>
											<td><center><?php echo date('d-m-Y',strtotime($rows["date"])) ?></center></td>
											<td><center><?php echo date('d-m-Y',strtotime($rows["subdate"])) ?></center></td>
											<td><center><?php echo $rows["current"] ?></center></td>
										<?php
											if($row1["pterms"] == 2)
											{
												echo '<td><center>'.$rows["month"].'</center></td>';
											}
											if($row1["pterms"] == 3)
											{
												$thismonth = date("F" , strtotime($row["date"]));

												echo '<td><center>'.$thismonth.'</center></td>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<td><center>'.$rows["percent"].'%</center></td>';
											}
										?>
											
											<form action="invoice-recieve.php?id=<?php echo $id ?>" method="post">
												<td><input type="date" style="width:150px" name="rdate" class="form-control" value="<?php echo date('Y-m-d') ?>" required></td>
												<td><select name="mode" style="width:100px" class="form-control">
													<option value="Cheque">Cheque</option>
													<option value="Online">Online</option>
												</select></td>
												<td><input type="number" name="current" class="form-control" value="<?php echo $rows["current"] ?>" ></td>
												<td><textarea name="remarks" class="form-control"></textarea></td>
												<td><input type="text" name="docu" class="form-control"></td>
												<input type="hidden" name="ids" value="<?php echo $rows["id"] ?>">
												<td>
													<table class="action">
													<tr>
													<td>
													<button type="submit" class="btn-link" title="Next">
														<span class="notification-icon dashbg-yellow">
															<i style="margin-left:0px" class="fa fa-arrow-right" aria-hidden="true"></i>
														</span>
													</button>
													</td>
													<td>
													<a href="undo-submit.php?id=<?php echo $id.'&ids='.$rows["id"] ?>" class="btn-link" title="Undo">
														<span class="notification-icon dashbg-yellow">
															<i style="margin-left:0px" class="fa fa-undo" aria-hidden="true"></i>
														</span>
													</a>
													</td></tr></table>
												</td>
											</form>
                                        </tr>

                        <?php
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
			<div class="row m-b30">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					
                    	<?php
							$sql = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0' AND paystatus='2' ORDER BY date DESC";
							$result = $conn->query($sql);
                            $count = 1;
                            
						?>
					<div class="card">
						<div class="card-header">
							<h4>List of Completed Invoices</h4>
						</div>
                        <div class="card-content">
                            <div class="table-responsive col-lg-12">
								<table id="dataTableExample3" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Invoice Id</th>
											<th>PO Ref.</th>
										<?php
											if($row1["pterms"] == 2 OR $row1["pterms"] == 3)
											{
												echo '<th>Month</th>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<th>Payment Terms</th>';
											}
										?>
											<th>Received Amount</th>	
											<th>Invoice Submitted Date</th>											
											<th>Payment Recieved Date</th>
											<th>Payment Mode</th>
											<th>Remarks</th>
										</tr>
									</thead>
									<tbody>

						<?php
								while($row = $result->fetch_assoc())
								{

                        ?>
                            			<tr>
                                    		<td><center><?php echo $count ?></center></td>
                                            <td><center><?php echo $row["invid"] ?></center></td>
											<td><center><?php echo $row["po"] ?></center></td>
										<?php
											if($row1["pterms"] == 2)
											{
												echo '<td><center>'.$row["month"].'</center></td>';
											}
											if($row1["pterms"] == 3)
											{
												$thismonth = date("F" , strtotime($row["date"]));

												echo '<td><center>'.$thismonth.'</center></td>';
											}
											if($row1["pterms"] == 1)
											{
												echo '<td><center>'.$row["percent"].'%</center></td>';
											}
										?>
											<td><center><?php echo $row["current"] ?></center></td>
                                            <td><center><?php echo date('d-m-Y',strtotime($row["subdate"])) ?></center></td>
											<td><center><?php echo date('d-m-Y',strtotime($row["recdate"])) ?></center></td>
											<td><center><?php echo $row["mode"] ?></center></td>
											<td><center><?php echo $row["remarks"] ?></center></td>
                                        </tr>

                        <?php
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
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/js/admin.js"></script>
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
</script>
<script>
	function minus() 
	{
		var txt1 = document.getElementById('current').value;
		var total = <?php echo $totalvalue ?>;
		var rems = txt1/100 * total;
		if (!isNaN(rems))
		{
			document.getElementById('amount').value = rems;
		}
	}
	function amo()
	{
		var amount = document.getElementById('amount').value;
		var total = <?php echo $totalvalue ?>;
		var ads = amount/total * 100;
		if (!isNaN(ads))
		{
			document.getElementById('current').value = ads;
		}
	}
</script>

</body>
</html>