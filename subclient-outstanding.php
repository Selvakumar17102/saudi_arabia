<?php

	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

    $cid = $_REQUEST["id"];
    $dept = $_REQUEST["dept"];

    $today = date('Y-m-d');

    if($cid == 1)
    {
        $divi = "SUSTAINABILITY";
    }
    if($cid == 2)
    {
        $divi = "ENGINEERING";
    }
    if($cid == 3)
    {
        $divi = "SIMULATION & ANALYSIS";
    }
    if($cid == 4)
    {
        $divi = "DEPUTATION";
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
        $sql = "SELECT * FROM main ORDER BY name ASC";
        $result = $conn->query($sql);
        $total = 0;
        while($row = $result->fetch_assoc())
        {
            $cid = $row["id"];

            $sql1 = "SELECT * FROM enquiry WHERE cid='$cid'";
            $result1 = $conn->query($sql1);
            while($row1 = $result1->fetch_assoc())
            {
                $eid = $row1["id"];

                $sql2 = "SELECT * FROM project WHERE eid='$eid' AND dept='$dept' AND divi='$divi'";
                $result2 = $conn->query($sql2);
                while($row2 = $result2->fetch_assoc())
                {
                    $pid = $row2["proid"];

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
                                            <th>Client</th>
                                            <th>Outstanding Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM main ORDER BY name ASC";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $cid = $row["id"];
                                                $total = 0;

                                                $sql1 = "SELECT * FROM enquiry WHERE cid='$cid'";
                                                $result1 = $conn->query($sql1);
                                                while($row1 = $result1->fetch_assoc())
                                                {
                                                    $eid = $row1["id"];

                                                    $sql2 = "SELECT * FROM project WHERE eid='$eid' AND dept='$dept'";
                                                    $result2 = $conn->query($sql2);
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        $pid = $row2["proid"];
                                                        $demo = $current = 0;

                                                        if($row2["divi"] == $divi)
                                                        {
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
                                                    }
                                                }

                                                if($total > 0)
                                                {
                                        ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><a href="outstanding-list.php?dept=<?php echo $dept ?>&id=<?php echo $row["id"] ?>"><?php echo $row["name"] ?></a></center></td>
                                                        <td><center>QAR <?php echo number_format($total) ?></center></td>
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
    function boss(val)
	{
		if(val != "")
		{
			location.replace("https://conservesolution.com/projectmgmttool/invoice-due1.php?id="+val);
			// location.replace("http://localhost/project/invoice-due1.php?id="+val);
		}
	}
</script>
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