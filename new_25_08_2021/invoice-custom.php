<?php

	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

    $fd = $_REQUEST["fd"];
    $td = $_REQUEST["td"];
    $id = $_REQUEST["id"];
    $set = $_REQUEST["set"];

    $divi = "";

    if($id == 1)
    {
        $divi = "SUSTAINABILITY";
    }
    if($id == 2)
    {
        $divi = "ENGINEERING SERVICES";
    }
    if($id == 3)
    {
        $divi = "SIMULATION & ANALYSIS SERVICES";
    }
    if($id == 4)
    {
        $divi = "LASER SCANNING SERVICES";
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
	<title>Invoice Reports | Project Management System</title>
	
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
				<h4 class="breadcrumb-title">Custom Invoice Reports</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
					<li>Reports</li>
				</ul>

			</div>	
		
			<div class="row">
			
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30 m-t30">
                    <div class="card">
					<div class="card-header">
							<h4><?php echo $divi ?> Invoice Report</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                           	<th>S.NO</th>
											<th>Project Name</th>
                                            <?php
                                                if($set == 1)
                                                {
                                            ?>
                                                <th>Total Amount</th>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                <th>Payment</th>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql = "SELECT * FROM enquiry WHERE division='$divi'";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $rfqid = $row["rfqid"];

                                                $sql1 = "SELECT total,sum(current) AS current FROM invoice WHERE rfqid='$rfqid' AND recdate BETWEEN '$fd' AND '$td'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

                                                if($row1["current"] != 0)
                                                {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++ ?></td>
                                                    <td><?php echo $row["name"] ?></td>
                                                    <?php
                                                        if($set == 1)
                                                        {
                                                    ?>
                                                    <td><?php echo $row1["total"] ?></td>
                                                    <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <td><?php echo $row1["current"] ?></td>
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
</script>
</body>
</html>