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
	<title>Pending Invoice Projects | Project Management System</title>
	
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
				<div class="col-sm-11"><h4 class="breadcrumb-title">Invoice Dues</h4></div>
                <?php
                    if($id != "" || $fdate != "")
                    {
                ?>
                <div class="col-sm-1">
                    <a href="pending.php" style="color: #fff" class="bg-primary btn">Back</a>
                </div>
                <?php
                    }
                ?>
			</div>

            <div class="row m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-12">
                                    <center><label class="col-form-label">Due Date Filter</label></center>
                                    <select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
                                        <option value disabled Selected>Select Date Filter</option>
                                        <?php
                                            $a1 = $a2 = $a3 = $a4 = "";
                                            if($id == 1)
                                            {
                                                $a1 = "Selected";
                                            }
                                            if($id == 2)
                                            {
                                                $a2 = "Selected";
                                            }
                                            if($id == 3)
                                            {
                                                $a3 = "Selected";
                                            }
                                            if($id == 4)
                                            {
                                                $a4 = "Selected";
                                            }
                                        ?>
                                        <option <?php echo $a1 ?> value="1">1 - 30 Days</option>
                                        <option <?php echo $a2 ?> value="2">31 - 45 Days</option>
                                        <option <?php echo $a3 ?> value="3">46 - 60 Days</option>
                                        <option <?php echo $a4 ?> value="4">60 Days & Above</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                if($id != "")
                {
                    $f1 = $f2 = 0;
                    if($id == 1)
                    {
                        $monthName = "Due : From 1 to 30 Days";
                        $f1 = 1;
                        $f2 = 30;
                    }
                    else
                    {
                        if($id == 2)
                        {
                            $monthName = "Due : From 31 to 45 Days";
                            $f1 = 31;
                            $f2 = 45;
                        }
                        else
                        {
                            if($id == 3)
                            {
                                $monthName = "Due : From 46 to 60 Days";
                                $f1 = 46;
                                $f2 = 60;
                            }
                            else
                            {
                                $monthName = "Due : From 46 to 60 Days";
                                $f1 = 61;
                                $f2 = 10000;
                            }
                        }
                    }
            ?>
                    <div class="row m-b10">
                        <div class="col-sm-12">
                            <div class="widget-box">
                                <div style="background-color: #78FDE1;padding:10px" class="widget-inner">
                                    <center><h5><?php echo $monthName ?></h5></center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-b30">
                        <div class="col-sm-12">
                            <div class="widget-box">
                                <div class="widget-inner">
                                    <div class="table-responsive">
                                        <table id="dataTableExample1" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Division</th>
                                                    <th>Project Name</th>
                                                    <th>Invoice Id</th>
                                                    <th>Invoiced Date</th>
                                                    <th>Invoice Submitted Date</th>
                                                    <th>Invoiced Value<br>(QAR)</th>
                                                    <th>Due Date Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql = "SELECT * FROM invoice WHERE paystatus='1'";
                                                    $result = $conn->query($sql);
                                                    $count = 1;
                                                    while($row = $result->fetch_assoc())
                                                    {
                                                        $i = 0;
                                                        $date = date('Y-m-d',strtotime($row["subdate"]));
                                                        while($date<=$today)
                                                        {
                                                            $i++;
                                                            $date = date('Y-m-d',strtotime($date.' +1 day'));
                                                        }
                                                        if($i >= $f1 && $i <= $f2)
                                                        {
                                                            $pid = $row["pid"];

                                                            $sql1 = "SELECT * FROM project WHERE proid='$pid'";
                                                            $result1 = $conn->query($sql1);
                                                            $row1 = $result1->fetch_assoc();

                                                            $pdue = $row1["invdues"];

                                                            $eid = $row1["eid"];

                                                            $sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                            $result2 = $conn->query($sql2);
                                                            $row2 = $result2->fetch_assoc();

                                                            if($pdue >= $f1 && $pdue <= $f2)
                                                            {
                                                    ?>
                                                            <tr>
                                                                <td><center><?php echo $count++ ?></center></td>
                                                                <td><center><?php echo $row1["divi"] ?></center></td>
                                                                <td><center><?php echo $row2["name"] ?></center></td>
                                                                <td><center><?php echo $row["invid"] ?></center></td>
                                                                <td><center><?php echo date('d-m-Y',strtotime($row["date"])) ?></center></td>
                                                                <td><center><?php echo date('d-m-Y',strtotime($row["subdate"])) ?></center></td>
                                                                <td><center><?php echo number_format($row["demo"],2) ?></center></td>
                                                                <td><center><?php echo number_format($i) ?> Days</center></td>
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
                    </div>
            <?php
                }
            ?>

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
			location.replace("invoice-due1.php?id="+val);
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