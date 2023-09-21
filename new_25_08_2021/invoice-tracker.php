<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');

    $dates = "0000-00-00";
    
    $today = date('Y-m-d');
    $thismonth = date('Y-m-01');
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
	<meta name="description" content="Invoice Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Invoice Reports | Project Management System" />
	<meta property="og:description" content="Invoice Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Invoice Tracker | Project Management System</title>
	
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
				<h4 class="breadcrumb-title">Invoice Tracker</h4>
			</div>
			<div class="row m-t30 m-b30">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box">
                	    <div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>											
											<th>Division</th>
											<th>Project Id</th>
											<th>Project Name</th>
											<th>Invoiced</th>
											<th>Invoiced Date</th>
											<th>Submitted</th>
											<th>Submitted Date</th>
											<th>Invoice Value</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            $sql = "SELECT * FROM project WHERE inv='0' AND status='Commercially Open' ORDER BY divi ASC";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            $de = $en = $si = $su = $pro = $inv = $sub = 0;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $c1 = $c2 = "red";
                                                $pid = $row["proid"];
                                                $eid = $row["eid"];
                                                $pro++;

                                                $sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                $sql1 = "SELECT * FROM invoice WHERE pid='$pid' AND demo!='0' AND date BETWEEN '$thismonth' AND '$today'";
                                                $result1 = $conn->query($sql1);
                                                if($result1->num_rows > 0)
                                                {
                                                    while($row1 = $result1->fetch_assoc())
                                                    {
                                                        $i = "Yes";
                                                        $s = $sd = "";
                                                        $c1 = "green";
                                                        $inv++;

                                                        if($row1["subdate"] != "")
                                                        {
                                                            $sub++;
                                                            $s = "Yes";
                                                            $c2 = "green";
                                                            $sd = date('d-m-Y',strtotime($row1["subdate"]));
                                                        }
                                                        else
                                                        {
                                                            $s = "No";
                                                            $sd = "-";
                                                        }

                                                        if($row["divi"] == "DEPUTATION")
                                                        {
                                                            $de += $row1["demo"];
                                                        }
                                                        else
                                                        {
                                                            if($row["divi"] == "ENGINEERING")
                                                            {
                                                                $en += $row1["demo"];
                                                            }
                                                            else
                                                            {
                                                                if($row["divi"] == "SIMULATION & ANALYSIS")
                                                                {
                                                                    $si += $row1["demo"];
                                                                }
                                                                else
                                                                {
                                                                    if($row["divi"] == "SUSTAINABILITY")
                                                                    {
                                                                        $su += $row1["demo"];
                                                                    }
                                                                }
                                                            }
                                                        }
                                        ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><?php echo $row["divi"] ?></center></td>
                                                        <td style="width: 15% !important"><center><?php echo $pid ?></center></td>
                                                        <td><center><?php echo $row2["name"] ?></center></td>
                                                        <td style="color:white;background-color: <?php echo $c1 ?>" ><center><?php echo $i ?></center></td>
                                                        <td><center><?php echo date('d-m-Y',strtotime($row1["date"])) ?></center></td>
                                                        <td style="color:white;background-color: <?php echo $c2 ?>" ><center><?php echo $s ?></center></td>
                                                        <td><center><?php echo $sd ?></center></td>
                                                        <td><center>QAR <?php echo number_format($row1["demo"],2) ?></center></td>
                                                    </tr>
                                        <?php
                                                    }
                                                }
                                                else
                                                {
                                        ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><?php echo $row["divi"] ?></center></td>
                                                        <td style="width: 15% !important"><center><?php echo $pid ?></center></td>
                                                        <td><center><?php echo $row2["name"] ?></center></td>
                                                        <td style="color:white;background-color: <?php echo $c1 ?>"><center>No</center></td>
                                                        <td><center> - </center></td>
                                                        <td style="color:white;background-color: <?php echo $c1 ?>"><center>No</center></td>
                                                        <td><center> - </center></td>
                                                        <td><center> - </center></td>
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

            <div class="row m-t30 m-b30">
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>Deputation</h5>
                                </div>
                                <div class="col-sm-12">
                                    <h6>QAR <?php echo number_format($de,2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>Engineering</h5>
                                </div>
                                <div class="col-sm-12">
                                    <h6>QAR <?php echo number_format($en,2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>Simulation</h5>
                                </div>
                                <div class="col-sm-12">
                                    <h6>QAR <?php echo number_format($si,2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>Sustainability</h5>
                                </div>
                                <div class="col-sm-12">
                                    <h6>QAR <?php echo number_format($su,2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-t30 m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
                            <h4>Summary</h4>
                        </div>
                	    <div class="widget-inner">
                	    	<div class="table-responsive">
                    	        <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>											
											<th>Total</th>
											<th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><center>1</center></td>
                                            <td><center>Invoice</center></td>
                                            <td><center><?php echo number_format($pro) ?></center></td>
                                        </tr>
                                        <tr>
                                            <td><center>2</center></td>
                                            <td><center>Prepared Invoice</center></td>
                                            <td><center><?php echo number_format($inv) ?></center></td>
                                        </tr>
                                        <tr>
                                            <td><center>3</center></td>
                                            <td><center>Submitted Invoice</center></td>
                                            <td><center><?php echo number_format($sub) ?></center></td>
                                        </tr>
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