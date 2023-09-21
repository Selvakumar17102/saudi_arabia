<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');

	$dates = "0000-00-00";

	$id = $_REQUEST["id"];
	$mid = $_REQUEST["mid"];

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

	$totalpo = $totalinv = 0;

	$sql4 = "SELECT * FROM project WHERE status='Commercially Open'";
	$result4 = $conn->query($sql4);
	while($row4 = $result4->fetch_assoc())
	{
		$totalpo += $row4["value"];

		$pid1 = $row4["proid"];

		$sql5 = "SELECT * FROM invoice WHERE pid='$pid1'";
		$result5 = $conn->query($sql5);
		while($row5 = $result5->fetch_assoc())
		{
			$totalinv += $row5["demo"];
		}
    }
    
    if($mid == 1)
    {
        $div1 = "SUSTAINABILITY";
        $div2 = "SUSTAINABILITY";
    }
    if($mid == 2)
    {
        $div1 = "ENGINEERING";
        $div2 = "ENGINEERING SERVICES";
    }
    if($mid == 3)
    {
        $div1 = "SIMULATION & ANALYSIS";
        $div2 = "SIMULATION & ANALYSIS SERVICES";
    }
    if($mid == 4)
    {
        $div1 = "DEPUTATION";
        $div2 = "DEPUTATION";
	}
	
	$sql = "SELECT * FROM invoice WHERE date < '$today' AND paystatus!=0 GROUP BY pid DESC";
	$result = $conn->query($sql);
	$count = 1;
	$tot = 0;
	while($row = $result->fetch_assoc())
	{
		$pid = $row["pid"];

		$sql1 = "SELECT * FROM project WHERE proid='$pid'";
		$result1 = $conn->query($sql1);
		$row1 = $result1->fetch_assoc();

		$divi = $row1["divi"];
		$eid = $row1["eid"];
		$invdues = $row1["invdues"];

		$sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();

		$name = $row2["name"];

		$amo = 0;
		if($divi == $div1)
		{
			$sql3 = "SELECT * FROM invoice WHERE date<'$today' AND paystatus!=0 AND pid='$pid'";
			$result3 = $conn->query($sql3);
			while($row3 = $result3->fetch_assoc())
			{
				$sub = $row3["subdate"];
				$rec = $row3["recdate"];
				$newdate = date('Y-m-d',strtotime($sub.'+'.$invdues.' days'));

				if(($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today)))
				{
					if($row3["paystatus"] == 2)
					{
						$amo += $row3["demo"] - $row3["current"];
					}
					else
					{
						$amo += $row3["demo"];
					}
				}
			}
		}
		$tot += $amo;
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
	<meta name="description" content="Consolidate Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Consolidate Reports | Project Management System" />
	<meta property="og:description" content="Consolidate Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Consolidate Dues Reports | Project Management System</title>
	
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
	.table-hover tr td {text-align: center;}
	.table-hover tr td a{padding: 10px;}
    table.dataTable thead .sorting_asc:before,.sorting_asc:after,.sorting:before,.sorting:after,.sorting_desc:after,.sorting_desc:before
    {
        content: "" !important;
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
				<h4 class="breadcrumb-title">Consolidate Due Reports</h4>
			</div>
            
			<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box">
						<div class="widget-inner">
							<div class="row m-b50">
								<div class="col-sm-4">
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
								<div class="col-sm-8">
								<label class="col-form-label">Custom Search</label>
									<div class="col-sm-12">
										<div class="row">
										
											<div class="col-sm-5">
												<input type="date" id="fdate" class="form-control" value="<?php echo $fdate ?>">
											</div>
											<div class="col-sm-5">
												<input type="date" id="tdate" class="form-control" value="<?php echo $tdate ?>">
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
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30 m-t30">
                    <div class="widget-box">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-8">
									<h4 style="float: left !important"><?php echo ucfirst(strtolower($div2)) ?> - Invoice Due Reports</h4>
								</div>
								<div class="col-sm-4">
									<h4 style="float: right !important">Total Due : QAR <?php echo number_format($tot) ?></h4>
								</div>
							</div>
						</div>
						<div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Project Name</th>
											<th>Due Value (QAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            $sql = "SELECT * FROM invoice WHERE date < '$today' AND paystatus!=0 GROUP BY pid DESC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$pid = $row["pid"];
										
												$sql1 = "SELECT * FROM project WHERE proid='$pid'";
												$result1 = $conn->query($sql1);
												$row1 = $result1->fetch_assoc();
										
												$divi = $row1["divi"];
												$eid = $row1["eid"];
												$invdues = $row1["invdues"];
										
												$sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();
										
												$name = $row2["name"];
										
												$amo = 0;
												if($divi == $div1)
												{
													$sql3 = "SELECT * FROM invoice WHERE date<'$today' AND paystatus!=0 AND pid='$pid'";
													$result3 = $conn->query($sql3);
													while($row3 = $result3->fetch_assoc())
													{
														$sub = $row3["subdate"];
														$rec = $row3["recdate"];
														$newdate = date('Y-m-d',strtotime($sub.'+'.$invdues.' days'));
										
														if(($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today)))
														{
															if($row3["paystatus"] == 2)
															{
																$amo += $row3["demo"] - $row3["current"];
															}
															else
															{
																$amo += $row3["demo"];
															}
														}
													}
												}

												if($amo != 0)
												{
										?>
													<tr>
														<td><center><?php echo $count++ ?></center></td>
														<td><center><a href="statement-main.php?id=<?php echo $row2["id"] ?>&fdate=<?php echo $thismonth ?>&tdate=<?php echo $today ?>"><?php echo $name ?></a></center></td>
														<td><center><?php echo number_format($amo) ?></center></td>
													</tr>
										<?php
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
            $('#dataTableExample').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel'
				]
            });
</script>
<script>
	function boss(val)
	{
		if(val != "")
		{
			location.replace("consolidate-dues.php?mid=<?php echo $mid ?>&id="+val);
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
				location.replace("consolidate-dues.php?mid=<?php echo $mid ?>&fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
</body>
</html>