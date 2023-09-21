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
	<meta name="description" content="Division Reports | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Division Reports | Income Expense Manager" />
	<meta property="og:description" content="Division Reports | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Division Reports | Income Expense Manager</title>
	
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
	<style>
        .hide1, .dataTables_info, .dataTables_paginate
        {
            display: none;
        }
    </style>
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
                                    <h4><center>Division Reports</center></h4>
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
								<div class="col-sm-12">
									<h6 style="color: #000"><center><?php echo $monthName ?></center></h6>
								</div>
							</div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Division</th>
                                            <th>Expense For The Month (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>

                                    <?php
                                        $sql = "SELECT * FROM division ORDER BY division ASC"; 
                                        $result = $conn->query($sql);
										$count = 1;
										$totcre = $totdeb = $totout = $t = 0;
                                        while($row = $result->fetch_assoc())
                                        {

											$credit = $invoice = $debit = $it = 0;
											$a1 = $a2 = 0;

                                            $diviid = $row["id"];
											$name = $row["division"];
											
											$sql1 = "SELECT * FROM credits WHERE divi='$diviid' AND date BETWEEN '$thismonth' AND '$today'";
											$result1 = $conn->query($sql1);
											while($row1 = $result1->fetch_assoc())
											{
												$invoice += $row1['amount'];
											}

                                            $sql1 = "SELECT * FROM sector WHERE divi='$diviid' AND date BETWEEN '$thismonth' AND '$today'";
                                            $result1 = $conn->query($sql1);
                                            while($row1 = $result1->fetch_assoc())
                                            {
                                                $invid = $row1["inv"];

                                                $sql2 = "SELECT * FROM expence_invoice WHERE id='$invid'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                if($row2["type"] == 1)
                                                {
                                                    $credit += $row1["amount"];
                                                }
                                                if($row2["type"] == 2)
                                                {
                                                    $debit += $row1["amount"];
												}
											}

											$sql4 = "SELECT * FROM sector WHERE divi='$diviid'";
											$result4 = $conn->query($sql4);
											while($row4 = $result4->fetch_assoc())
											{
												$inv = $row4["inv"];

												$sql5 = "SELECT * FROM expence_invoice WHERE id='$inv'";
												$result5 = $conn->query($sql5);
												$row5 = $result5->fetch_assoc();

												if($row5["type"] == 1)
												{
													$a1 += $row4["amount"];
												}
											}

											$sql6 = "SELECT sum(amount) AS amount FROM credits WHERE divi='$diviid'";
											$result6 = $conn->query($sql6);
											$row6 = $result6->fetch_assoc();

											$a2 = $row6["amount"];

											$totcre += $credit;
											$totout += $a2;
											$t += $a1;
											$totdeb += $debit;
											$total_invoice += $invoice;
                                    ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><a href="division-report.php?divi=<?php echo $diviid.'&fdate='.$thismonth.'&tdate='.$today ?>"><?php echo $name ?></a></center></td>
                                                <td><center><?php echo number_format($debit,2) ?></center></td>
												                          
                                            </tr>
                                    <?php
                                        }
                                    ?>
									</tbody>
                                </table>
								<table class="table table-bordered table-striped table-hover" style="margin-top: 20px;">
									<tr>
										<th colspan=2></th>
										<th>Expense For The Month</th>
									</tr>
									<tr style="background-color: #88F2B2">
										<td style="text-align: right" colspan=2>Total</td>
										<td><center>SAR <?php echo number_format($totdeb,2) ?></center></td>
									</tr>
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
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				]
            });
</script>
<script>
	$(document).ready(function(){
		$('[type="date"]').prop('max', function(){
			return new Date().toJSON().split('T')[0];
		});
	});
</script>
<script>
        function changing(val)
        {
			if(val == "3")
			{
				document.getElementsByClassName('hide1')[0].style.display = 'block';
				document.getElementsByClassName('hide1')[1].style.display = 'block';
			}
			else
			{
				document.getElementsByClassName('hide1')[0].style.display = 'none';
				document.getElementsByClassName('hide1')[1].style.display = 'none';
			}
        }
        function datefun()
		{
			$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
		}
    </script>
	<script>
	function boss(val)
	{
		if(val != "")
		{
			window.location.href ="division-report1.php?id="+val;
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
				window.location.href ="division-report1.php?fdate="+fdate+"&tdate="+tdate;
			}
		}
	}
</script>
</body>
</html>