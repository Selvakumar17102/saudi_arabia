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
	<meta name="description" content="Expence Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Expence Account | Income Expense Manager" />
	<meta property="og:description" content="Expence Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Expence Account | Income Expense Manager</title>
	
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

</head>
<body style="background-color: #f8f8f8;">
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
				
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<div class="row m-b10">
								<div class="col-sm-12">
									<h4><center>Expense Account Details</center></h4>
									<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
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
							<div class="row" style="background-color: #B8F1CE;padding:10px 0">
								<div class="col-sm-8">
									<h6><?php echo $monthName ?></h6>
								</div>
								<div class="col-sm-4">
									<?php
										$sql3 = "SELECT sum(debit) AS debit FROM expence_invoice WHERE date BETWEEN '$thismonth' AND '$today' AND type='2'";
										$result3 = $conn->query($sql3);
										$row3 = $result3->fetch_assoc();

										if($row3["debit"] == "")
										{
											$row3["debit"] = 0;
										}
									?>

										<h6 class="float-right" style="color: #000">Total Expense : SAR <?php echo number_format($row3["debit"],2) ?></h6>
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
											<th>Sub Account</th>
											<th>Total Expenses (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
											$count = 1;
											$sql = "SELECT * FROM account WHERE type='1' AND sub='0'  ORDER BY name ASC";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc())
											{
												$id = $row["id"];
												$code = $row["code"];

												$debit = 0;

												$cus = 0;
												$count1 = 0;

												$sql2 = "SELECT * FROM account WHERE sub='$id' ORDER BY name ASC";
												$result2 = $conn->query($sql2);

												if($result2->num_rows > 0)
												{
													$cus = 1;
													while($row2 = $result2->fetch_assoc())
													{
														$code1 = $row2["code"];
                                                        
														$sql1 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$thismonth' AND '$today'";
														$result1 = $conn->query($sql1);
														$row1 = $result1->fetch_assoc();

														if($row1["debit"] == "")
														{
															$row1["debit"] = 0;
														}
														$debit += $row1["debit"];
												       
														$count1++;
													}
												}
												else
												{
                                      
													$sql1 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE code='$code' AND date BETWEEN '$thismonth' AND '$today'";
													$result1 = $conn->query($sql1);
													$row1 = $result1->fetch_assoc();
													
                                                     
													if($row1["debit"] == "")
													{
														$row1["debit"] = 0;
													}
													
													$debit += $row1["debit"];
													
												}
											?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>
											<?php
											
													if($cus == 0)
													{
														?>
															<td><center><a href="account-details.php?id=<?php echo $row["id"] ?>"><?php echo $row["name"] ?></a></center></td>
															<td><center> 0 </center></td>
														<?php
													}
													else
													{
														?>
															<td><center><a href="subaccounts.php?id=<?php echo $row["id"]."&fdate=".$thismonth."&tdate=".$today ?>"><?php echo $row["name"] ?></a></center></td>
															<td><center> <?php echo $count1 ?> </center></td>
														<?php
													}
											?>      
													<td><center><?php echo number_format($debit,2) ?></center></td>
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
				<!-- Your Profile Views Chart END-->
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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	$(document).ready(function(){
		$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
	});
</script>
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
			location.replace("expence-account.php?id="+val);
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
				location.replace("expence-account.php?fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
<script>
    </script>
</body>
</html>