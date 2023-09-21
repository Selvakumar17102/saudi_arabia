<?php

    ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");
	
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

	$sql3 = "SELECT * FROM account WHERE type='3' AND sub='0'";
	$result3 = $conn->query($sql3);
	$amount = 0;
	while($row3 = $result3->fetch_assoc())
	{
		$idmain = $row3["id"];
		$c1 = $row3["code"];

		$sql4 = "SELECT * FROM account WHERE sub='$idmain'";
		$result4 = $conn->query($sql4);
		if($result4->num_rows > 0)
		{
			while($row4 = $result4->fetch_assoc())
			{
				$c = $row4["code"];

				$sql5 = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE code='$c'";
				$result5 = $conn->query($sql5);
				$row5 = $result5->fetch_assoc();

				$amount += $row5["credit"];
				$amount -= $row5["debit"];
			}
		}
		else
		{
			$sql5 = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE code='$c1'";
			$result5 = $conn->query($sql5);
			$row5 = $result5->fetch_assoc();

			$amount += $row5["credit"];
			$amount -= $row5["debit"];
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
	<meta name="description" content="Inhouse Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Inhouse Account | Income Expense Manager" />
	<meta property="og:description" content="Inhouse Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Inhouse Account | <?php echo $monthName ?></title>
	
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
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<script>
		function datefun()
		{
			$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
		}
	</script>
    
</head>
<body onload="datefun()">
	
	<!-- header start -->
	<?php include("inc/expence_header.php") ?>
	<?php include("inc/sidebar.php") ?>
	

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container">
				
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<div class="row m-b10">
								<div class="col-sm-8">
									<h4>In-House Account Details</h4>
									<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
								</div>
								<div class="col-sm-4">
									<h6 class="float-right">Total Outstanding : SAR <?php echo number_format($amount,2) ?></h6>
								</div>
							</div>
							<div class="row m-b50">
								<div class="col-sm-3">
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
								<div class="col-sm-9">
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
							<div style="background-color: #B8F1CE;padding:10px" class="row m-b10">
								<div class="col-sm-12">
									<h4 style="color: #000"><center><?php echo $monthName ?></center></h4>
								</div>
							</div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Account Name</th>
											<th>Total Credit (SAR)</th>
											<th>Total Debit (SAR)</th>
											<th>Balance (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
											$count = 1;
											$sql = "SELECT * FROM account WHERE type='3' AND sub='0' ORDER BY name ASC";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc())
											{
												$sub = $row["id"];

												$sql2 = "SELECT * FROM account WHERE sub='$sub'";
												$result2 = $conn->query($sql2);
												if($result2->num_rows == 0)
												{
													$code = $row["code"];

													$sql1 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE code='$code' AND date BETWEEN '$thismonth' AND '$today'";
													$result1 = $conn->query($sql1);
													$row1 = $result1->fetch_assoc();

													if($row1["debit"] == "")
													{
														$row1["debit"] = 0;
													}
													if($row1["credit"] == "")
													{
														$row1["credit"] = 0;
													}
													if($row1["debit"] != 0 || $row1["credit"] != 0)
													{
											?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>
													<td><center><a href="inhouse-details.php?id=<?php echo $row["id"]; ?>&fdate=<?= $thismonth; ?>&tdate=<?=$today?>"><?php echo $row["name"] ?></a></center></td>
													<td><center><?php echo number_format($row1["credit"],2) ?></center></td>
													<td><center><?php echo number_format($row1["debit"],2) ?></center></td>
													<td><center><?php echo number_format($row1["credit"]-$row1["debit"],2) ?></center></td>
												</tr>
											<?php
													}
												}
												else
												{
													$credit = $debit = 0;
													while($row2 = $result2->fetch_assoc())
													{
														$code = $row2["code"];

														$sql1 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE code='$code' AND date BETWEEN '$thismonth' AND '$today'";
														$result1 = $conn->query($sql1);
														$row1 = $result1->fetch_assoc();

														$credit += $row1["credit"];
														$debit += $row1["debit"];
													}

													if($credit != 0 || $debit != 0)
													{
												?>
													<tr>
														<td><center><?php echo $count++ ?></center></td>
														<td><center><a href="inhouse-sub.php?ids=<?php echo $row["id"].'&fdate='.$thismonth.'&tdate='.$today ?>"><?php echo $row["name"] ?></a></center></td>
														<td><center><?php echo number_format($credit,2) ?></center></td>
														<td><center><?php echo number_format($debit,2) ?></center></td>
														<td><center><?php echo number_format($credit-$debit,2) ?></center></td>
													</tr>
												<?php
													}
												}
                                            }
                                        ?>
									</tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
            </div>
		</div>
	</main>


<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
</script>
<script>
	function boss(val)
	{
		if(val != "")
		{
			
			location.replace("inhouse-account.php?id="+val);
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
				
				location.replace("inhouse-account.php?fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
</body>
</html>
