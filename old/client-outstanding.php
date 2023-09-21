<?php

	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $today = date('Y-m-d');
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
	<meta name="description" content="Pending Invoice Projects | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Pending Invoice Projects | Project Management System" />
	<meta property="og:description" content="Pending Invoice Projects | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Client Outstanding Projects | Project Management System</title>
	
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

    <?php
        $sql = "SELECT * FROM project WHERE dept='$id'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc())
        {
            $pid = $row["proid"];
            $divi = $row["divi"];
            $demo = $current = 0;

            $sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
            $result3 = $conn->query($sql3);
            while($row3 = $result3->fetch_assoc())
            {
                if($row3["paystatus"] != 2)
                {
                    $total += $row3["demo"];
                }
                else
                {
                    $recdate = date('Y-m-d',strtotime($row3["recdate"]));
                    if($today < $recdate)
                    {
                        $total += ($row3["demo"] - $row3["current"]);
                    }
                    else
                    {
                        $total += ($row3["demo"] - $row3["current"]);
                    }
                }
            }
        }
    ?>
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
            <div class="row m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h5>Client Outstanding</h5>
                                </div>
                                <div class="col-sm-2">
                                    <h5 style="float: right">QAR <?php echo number_format($total) ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                                <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Division</th>
                                            <th>Outstanding Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $su = $en = $si = $de = 0;
                                            $count = 1;
                                            $sql = "SELECT * FROM project WHERE dept='$id'";
                                            $result = $conn->query($sql);
                                            while($row = $result->fetch_assoc())
                                            {
                                                $pid = $row["proid"];
                                                $divi = $row["divi"];
                                                $total = 0;

                                                $sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
                                                $result3 = $conn->query($sql3);
                                                while($row3 = $result3->fetch_assoc())
                                                {
                                                    if($row3["paystatus"] != 2)
                                                    {
                                                        $total += $row3["demo"];
                                                    }
                                                    else
                                                    {
                                                        $recdate = date('Y-m-d',strtotime($row3["recdate"]));
                                                        if($today < $recdate)
                                                        {
                                                            $total += ($row3["demo"] - $row3["current"]);
                                                        }
                                                        else
                                                        {
                                                            $total += ($row3["demo"] - $row3["current"]);
                                                        }
                                                    }
                                                }

                                                if($divi == 'SUSTAINABILITY')
                                                {
                                                    $su += ($total);
                                                }
                                                if($divi == 'ENGINEERING')
                                                {
                                                    $en += ($total);
                                                }
                                                if($divi == 'SIMULATION & ANALYSIS')
                                                {
                                                    $si += ($total);
                                                }
                                                if($divi == 'DEPUTATION')
                                                {
                                                    $de += ($total);
                                                }
                                            }

                                            if($su != 0)
                                            {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><a href="subclient-outstanding.php?dept=<?php echo $id ?>&id=1">Sustainability</a></center></td>
                                                    <td><center>QAR <?php echo number_format($su) ?></center></td>
                                                </tr>
                                        <?php
                                            }
                                            if($en != 0)
                                            {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><a href="subclient-outstanding.php?dept=<?php echo $id ?>&id=2">Engineering Services</a></center></td>
                                                    <td><center>QAR <?php echo number_format($en) ?></center></td>
                                                </tr>
                                        <?php
                                            }
                                            if($si != 0)
                                            {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><a href="subclient-outstanding.php?dept=<?php echo $id ?>&id=3">Simulation & Analysis Services</a></center></td>
                                                    <td><center>QAR <?php echo number_format($si) ?></center></td>
                                                </tr>
                                        <?php
                                            }
                                            if($de != 0)
                                            {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><a href="subclient-outstanding.php?dept=<?php echo $id ?>&id=4">Deputation</a></center></td>
                                                    <td><center>QAR <?php echo number_format($de) ?></center></td>
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