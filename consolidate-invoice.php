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
	
	$sql = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today' AND current != 0 ORDER BY date ASC";
	$result = $conn->query($sql);
	$tot = 0;
	while($row = $result->fetch_assoc())
	{
		$pid = $row["pid"];
		$rfqid = $row["rfqid"];
		
		if($pid != "")
		{
			$sql1 = "SELECT * FROM project WHERE proid='$pid'";
			$result1 = $conn->query($sql1);
			$row1 = $result1->fetch_assoc();

			$divi = $row1["divi"];
		}
		else
		{
			$sql1 = "SELECT * FROM enquiry WHERE rfqid='$rfqid'";
			$result1 = $conn->query($sql1);
			$row1 = $result1->fetch_assoc();

			$ida = $row1["id"];

			$sql2 = "SELECT * FROM project WHERE eid='$ida'";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();

			$divi = $row2["divi"];
		}

		if($divi == $div1)
		{
			$tot += $row["demo"];
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
	<title>Consolidate Invoiced Reports | Project Management System</title>
	
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
				<h4 class="breadcrumb-title">Consolidate Invoiced Reports</h4>
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
									<h4 style="float: left !important"><?php echo ucfirst(strtolower($div2)) ?> - Invoice Reports</h4>
								</div>
								<div class="col-sm-4">
									<h4 style="float: right !important">Total Due : ₹ <?php echo number_format($tot) ?></h4>
								</div>
							</div>
						</div>
						<div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Invoice No</th>
											<th>Invoice Prepared Date</th>
                                            <th>Invoice Submitted Date</th>
											<th>Invoice Value (₹)</th>
											<th>Recieved Date</th>
											<th>Recieved Amount (₹)</th>
											<th>Remarks</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            $sql = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today' AND current != 0 ORDER BY date ASC";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $pid = $row["pid"];
                                                $rfqid = $row["rfqid"];
                                                
                                                if($pid != "")
                                                {
                                                    $sql1 = "SELECT * FROM project WHERE proid='$pid'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();

                                                    $divi = $row1["divi"];
                                                }
                                                else
                                                {
                                                    $sql1 = "SELECT * FROM enquiry WHERE rfqid='$rfqid'";
                                                    $result1 = $conn->query($sql1);
                                                    $row1 = $result1->fetch_assoc();

                                                    $ida = $row1["id"];

                                                    $sql2 = "SELECT * FROM project WHERE eid='$ida'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();

                                                    $divi = $row2["divi"];
                                                }

                                                if($divi == $div1)
                                                {
                                        ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><?php echo $row["invid"] ?></center></td>
                                                        <td><center><?php echo date('d-m-Y',strtotime($row["date"])) ?></center></td>
                                                        <td><center><?php echo date('d-m-Y',strtotime($row["subdate"])) ?></center></td>
                                                        <td><center><?php echo number_format($row["demo"]) ?></center></td>
                                                        <?php
                                                            if($row["recdate"] != "")
                                                            {
                                                        ?>
                                                                <td><center><?php echo date('d-m-Y',strtotime($row["subdate"])) ?></center></td>
                                                                <td><center><?php echo number_format($row["current"]) ?></center></td>
                                                                <td><center><?php echo $row["remarks"] ?></center></td>
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                                <td><center> - </center></td>
                                                                <td><center> - </center></td>
                                                                <td><center> - </center></td>
                                                        <?php
                                                            }
                                                        ?>
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
			location.replace("consolidate-invoice.php?mid=<?php echo $mid ?>&id="+val);
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
				location.replace("consolidate-invoice.php?mid=<?php echo $mid ?>&fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
</body>
</html>