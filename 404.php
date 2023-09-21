<?php

	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
    
    $month = date('m');
    $thismonth = date('Y-m-01');
    $today = date('Y-m-d');
    
    $sql = "SELECT * FROM enquiry";
    $result = $conn->query($sql);
    $sub = $award = 0;
    while($row = $result->fetch_assoc())
    {
        if($row["qstatus"] == "SUBMITTED")
        {
            $sub++;
            if($row["pstatus"] == "AWARDED")
            {
                $award++;
            }
        }
    }

    $sql1 = "SELECT * FROM project";
    $result1 = $conn->query($sql1);
    $co = $value = $inv = $coll = 0;
    while($row1 = $result1->fetch_assoc())
    {
        if($row1["status"] == "Commercially Open")
        {
            $co++;
        }
        $value += $row1["value"];
    }

    $sql2 = "SELECT * FROM invoice";
    $result2 = $conn->query($sql2);
    while($row2 = $result2->fetch_assoc())
    {
        $inv += $row2["demo"];

        if($row2["paystatus"] == 2)
        {
            $coll += $row2["current"];
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
		<meta name="description" content="Dashboard | Project Management System" />
		
		<!-- OG -->
		<meta property="og:title" content="Dashboard | Project Management System" />
		<meta property="og:description" content="Dashboard | Project Management System />
		<meta property="og:image" content="" />
		<meta name="format-detection" content="telephone=no">
		
		<!-- FAVICONS ICON ============================================= -->
		<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
		
		<!-- PAGE TITLE HERE ============================================= -->
		<title>Dashboard | Project Management System</title>
		
		<!-- MOBILE SPECIFIC ============================================= -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
		<!-- All PLUGINS CSS ============================================= -->
		<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
		
		<!-- TYPOGRAPHY ============================================= -->
		<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
		
		<!-- SHORTCODES ============================================= -->
		
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
            .col-20
            {
                flex: 0 0 20%;
                width: 20%;
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }
            g text{font-size: 13px;}
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
				
            <div class="error-page p-t100 p-b100">
					<h3>Ooopps :(</h3>
					<h2 class="error-title">404</h2>
					<h5>The Page you were looking for, couldn't be found.</h5>
					<p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
					<div class="">
						<a href="http://conserveacademy.com/projectmgmttool/" class="btn m-r5">Back to Home</a>
					</div>
				</div>
			</div>
		</main>

		<div class="ttr-overlay"></div>

	<!-- External JavaScripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/admin.js"></script>
	<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="assets/vendors/datatables/dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM enquiry";
                $result = $conn->query($sql);
                $sub = $not = $drop = 0;
                while($row = $result->fetch_assoc())
                {
                    if($row["qstatus"] == "SUBMITTED")
                    {
                        $sub++;
                    }
                    else
                    {
                        if($row["qstatus"] == "NOT SUBMITTED")
                        {
                            $not++;
                        }
                        else
                        {
                            $drop++;
                        }
                    }
                }
            ?>
            ['Submitted',<?php echo $sub ?>],
            ['Not Submitted',<?php echo $not ?>],
            ['Dropped',<?php echo $drop ?>]
        ]);

        var options = {
          chart: {
            title: 'Enquiry Comparison - Overall',
          },
          legend: { position: "none" },
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM enquiry WHERE enqdate BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $sub = $not = $drop = 0;
                while($row = $result->fetch_assoc())
                {
                    if($row["qstatus"] == "SUBMITTED")
                    {
                        $sub++;
                    }
                    else
                    {
                        if($row["qstatus"] == "NOT SUBMITTED")
                        {
                            $not++;
                        }
                        else
                        {
                            $drop++;
                        }
                    }
                }
            ?>
            ['Submitted',<?php echo $sub ?>],
            ['Not Submitted',<?php echo $not ?>],
            ['Dropped',<?php echo $drop ?>]
        ]);

        var options = {
          chart: {
            title: 'Enquiry Comparison - This Month',
          },
          legend: { position: "none" },
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material-m'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED'";
                $result = $conn->query($sql);
                $sub = $lost = $follow = 0;
                while($row = $result->fetch_assoc())
                {
                    if($row["pstatus"] == "AWARDED")
                    {
                        $sub++;
                    }
                    else
                    {
                        if($row["pstatus"] == "LOST")
                        {
                            $lost++;
                        }
                        else
                        {
                            $follow++;
                        }
                    }
                }
            ?>
            ['Awarded',<?php echo $sub ?>],
            ['In-Progress',<?php echo $follow ?>],
            ['Dropped',<?php echo $lost ?>]
        ]);

        var options = {
            title: 'Proposal Comparison - Overall',
            legend: { position: "none" },
            colors: ['#8CD234'],
        };

        var chart = new google.charts.Bar(document.getElementById('proposal'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND enqdate BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $sub = $lost = $follow = 0;
                while($row = $result->fetch_assoc())
                {
                    if($row["pstatus"] == "AWARDED")
                    {
                        $sub++;
                    }
                    else
                    {
                        if($row["pstatus"] == "LOST")
                        {
                            $lost++;
                        }
                        else
                        {
                            $follow++;
                        }
                    }
                }
            ?>
            ['Awarded',<?php echo $sub ?>],
            ['In-Progress',<?php echo $follow ?>],
            ['Dropped',<?php echo $lost ?>]
        ]);

        var options = {
            title: 'Proposal Comparison - This Month',
            legend: { position: "none" },
            colors: ['#8CD234'],
        };

        var chart = new google.charts.Bar(document.getElementById('proposal-m'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM project";
                $result = $conn->query($sql);
                $co = $run = $clos = 0;
                while($row = $result->fetch_assoc())
                {
                    if($row["status"] == "Commercially Open")
                    {
                        $co++;
                    }
                    else
                    {
                        if($row["status"] == "Closed")
                        {
                            $clos++;
                        }
                        else
                        {
                            $run++;
                        }
                    }
                }
            ?>
            ['Commercially Open',<?php echo $co ?>],
            ['Running',<?php echo $run ?>],
            ['Closed',<?php echo $clos ?>]
        ]);

        var options = {
            title: 'Project Comparison - Overall',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('project'));

        chart.draw(data,options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM project";
                $result = $conn->query($sql);
                $co = $run = $clos = 0;
                while($row = $result->fetch_assoc())
                {
                    $eid1 = $row["eid"];

                    $sql1 = "SELECT * FROM enquiry WHERE id='$eid1' AND qdatec BETWEEN '$thismonth' AND '$today'";
                    $result1 = $conn->query($sql1);
                    if($result1->num_rows > 0)
                    {
                        if($row["status"] == "Commercially Open")
                        {
                            $co++;
                        }
                        else
                        {
                            if($row["status"] == "Closed")
                            {
                                $clos++;
                            }
                            else
                            {
                                $run++;
                            }
                        }
                    }
                }
            ?>
            ['Commercially Open',<?php echo $co ?>],
            ['Running',<?php echo $run ?>],
            ['Closed',<?php echo $clos ?>]
        ]);

        var options = {
            title: 'Project Comparison - This Month',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('project-m'));

        chart.draw(data,options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() 
      {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT sum(demo) AS demo FROM invoice";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $sql1 = "SELECT sum(value) AS value FROM project";
                $result1 = $conn->query($sql1);
                $row1 = $result1->fetch_assoc();
            ?>
            ['PO',<?php echo $row1["value"] ?>],
            ['Invoice',<?php echo $row["demo"] ?>]
        ]);

        var options = {
            title: 'PO Comparison - Overall',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('po'));

        chart.draw(data,options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() 
      {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $total = 0;
                $sql = "SELECT sum(demo) AS demo FROM invoice WHERE date BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $sql1 = "SELECT * FROM project";
                $result1 = $conn->query($sql1);
                while($row1 = $result1->fetch_assoc())
                {
                    $eid1 = $row1["eid"];

                    $sql2 = "SELECT * FROM enquiry WHERE id='$eid1' AND qdatec BETWEEN '$thismonth' AND '$today'";
                    $result2 = $conn->query($sql2);
                    if($result2->num_rows > 0)
                    {
                        $total += $row1["value"];
                    }
                }
            ?>
            ['PO',<?php echo $total ?>],
            ['Invoice',<?php echo $row["demo"] ?>]
        ]);

        var options = {
            title: 'PO Comparison - This Month',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('po-m'));

        chart.draw(data,options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM invoice";
                $result = $conn->query($sql);
                $demo = $coll = 0;
                while($row = $result->fetch_assoc())
                {
                    $demo += $row["demo"];
                    if($row["paystatus"] == "2")
                    {
                        $coll += $row["current"];
                    }
                }
            ?>
            ['Invoice',<?php echo $demo ?>],
            ['Collection',<?php echo $coll ?>]
        ]);

        var options = {
            title: 'Invoice Comparison - Overall',
            colors: ['#BAB81D','#e5e4e2'],
        };

        var chart = new google.charts.Bar(document.getElementById('invoice'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Type', 'Total'],
            <?php
                $sql = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $demo = $coll = 0;
                while($row = $result->fetch_assoc())
                {
                    $demo += $row["demo"];
                    if($row["paystatus"] == "2")
                    {
                        $coll += $row["current"];
                    }
                }
            ?>
            ['Invoice',<?php echo $demo ?>],
            ['Collection',<?php echo $coll ?>]
        ]);

        var options = {
            title: 'Invoice Comparison - This Month',
            colors: ['#BAB81D','#e5e4e2'],
        };

        var chart = new google.charts.Bar(document.getElementById('invoice-m'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
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