<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$date = date("Y-m-d");
	$month = date('m');
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
					<h4 class="breadcrumb-title">Dashboard</h4>
					<ul class="db-breadcrumb-list">
						<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
						<li>Dashboard</li>
					</ul>
				</div>	
				<h2><center><b>Welcome To Project Management System</b></center></h2>
				<?php
					$today = date('Y-m-d');

					$sql3 = "SELECT sum(current) as current FROM invoice WHERE recdate='$today'";
					$result3 = $conn->query($sql3);
					$row3 = $result3->fetch_assoc();

					$todaycollection = $row3["current"];
					$todaysales = $monthsales = 0;

					$sql4 = "SELECT * FROM enquiry WHERE qdatec='$today'";
					$result4 = $conn->query($sql4);
					while($row4 = $result4->fetch_assoc())
					{
						$eid = $row4["id"];

						$sql5 = "SELECT * FROM project WHERE eid='$eid'";
						$result5 = $conn->query($sql5);
						$row5 = $result5->fetch_assoc();

						$todaysales += $row5["value"];
					}

					$todaychart = "['Today',".$todaysales.",".$todaycollection."],";

					$monthstart = date('Y-m-01');

					$sql6 = "SELECT sum(current) as current FROM invoice WHERE recdate BETWEEN '$monthstart' AND '$today'";
					$result6 = $conn->query($sql6);
					$row6 = $result6->fetch_assoc();

					$monthcollection = $row6["current"];

					$sql7 = "SELECT * FROM enquiry WHERE qdatec BETWEEN '$monthstart' AND '$today'";
					$result7 = $conn->query($sql7);
					while($row7 = $result7->fetch_assoc())
					{
						$eid1 = $row7["id"];

						$sql8 = "SELECT * FROM project WHERE eid='$eid'";
						$result8 = $conn->query($sql8);
						$row8 = $result8->fetch_assoc();

						$monthsales += $row8["value"];
					}

					$monthchart = "['This Month',".$monthsales.",".$monthcollection."],";
				?>
				<div class="row m-t30">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-6 m-b30">
							<div class="card">
								<div id="chart_div" style="width: 100%;height: 300px;box-shadow: 0px 0px 15px #ddd;"></div>
							</div>
							</div>
							<div class="col-lg-6 m-b30">
							<div class="card">
								<div id="donutchart" style="width: 100%; height: 300px;box-shadow: 0px 0px 15px #ddd;"></div>
							</div>
							</div>
							<div class="col-lg-12 m-b30">
							<div class="card">
								<div id="curve_chart" style="height:400px;box-shadow: 0px 0px 15px #ddd;"></div>
							</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
			
				
				<!-- Data tables -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-b30 m-t30">
                    <div class="card">
					<div class="card-header">
							<h4><?php echo date('F'); ?> Month Invoice Generated Report</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>											
											<th>Invoice No</th>
											<th>Project Name</th>
											<th>Invoice Date</th>
											<th>Value</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$sql1 = "SELECT * FROM invoice WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) AND current != 0 AND subdate = 0 ORDER BY id DESC";
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{		
												$eid = $row1["rfqid"];
												$sql = "SELECT * FROM enquiry WHERE rfqid='$eid'";
												$result = $conn->query($sql);
												$row = $result->fetch_assoc();	
												$name = $row["name"];
										?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>	
													<td><center><?php echo $row1["invid"] ?></center></td>	
													<td><center><?php echo $name; ?></center></td>													
													<td><center><?php echo date('d-m-Y',strtotime($row1["date"])) ?></center></td>
													<td><center><?php echo $row1["current"] ?></center></td>
												</tr>
										<?php
											}
										?>
										
									</tbody>
                                </table>
                            </div>
							
                        
                    </div>
                </div>
				
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-b30 m-t30">
                    <div class="card">
					<div class="card-header">
							<h4>Division Wise Invoice Report</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table id="dataTableExample2" class="table table-striped">
                                    <thead>
                                        <tr>
                                           	<th>S.NO</th>
											<th>Division Name</th>
											<th>Total Amount</th>
											<th>Payment</th>
											<th>Bending</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$st = $sp = $sb = 0;
											$et = $ep = $eb = 0;
											$sat = $sap = $sab = 0;
											$lt = $lp = $lb = 0;
											$sql5 = "SELECT * FROM project";
											$result5 = $conn->query($sql5);
											while($row5 = $result5->fetch_assoc())
											{
												$eid = $row5["eid"];
												$values = $row5["value"];

												$sql6 = "SELECT * FROM enquiry WHERE id='$eid'";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();

												$rfqs = $row6["rfqid"];

												$divi = $row6["division"];

												$sql7 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqs'";
												$result7 = $conn->query($sql7);
												$row7 = $result7->fetch_assoc();

												if($divi == "SUSTAINABILITY")
												{
													$st = $st + $values;
													$sp = $sp + $row7["current"];
												}
												if($divi == "ENGINEERING SERVICES")
												{
													$et = $et + $values;
													$ep = $ep + $row7["current"];
												}
												if($divi == "SIMULATION & ANALYSIS SERVICES")
												{
													$sat = $sat + $values;
													$sap = $sap + $row7["current"];
												}
												if($divi == "LASER SCANNING SERVICES")
												{
													$lt = $lt + $values;
													$lp = $lp + $row7["current"];
												}
										
											}
										?>
											<tr>
												<td> 1 </td>
												<td>SUSTAINABILITY</td>
												<td><?php echo $st ?></td>
												<td><?php echo $sp ?></td>
												<td><?php echo $st-$sp ?></td>
											</tr>
											<tr>
												<td> 2 </td>
												<td>ENGINEERING SERVICES</td>
												<td><?php echo $et ?></td>
												<td><?php echo $ep ?></td>
												<td><?php echo $et-$ep ?></td>
											</tr>
											<tr>
												<td> 3 </td>
												<td>SIMULATION & ANALYSIS SERVICES</td>
												<td><?php echo $sat ?></td>
												<td><?php echo $sap ?></td>
												<td><?php echo $sat-$sap ?></td>
											</tr>
											<tr>
												<td> 4 </td>
												<td>LASER SCANNING SERVICES</td>
												<td><?php echo $lt ?></td>
												<td><?php echo $lp ?></td>
												<td><?php echo $lt-$lp ?></td>
											</tr>
										
									</tbody>
                                </table>
                            </div>
							
                        
                    </div>
                </div>
				
				
			</div>
			
				<!-- Card -->
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
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() 
	  {
        var data = google.visualization.arrayToDataTable([
			['Date', 'Sales', 'Collection'],
		<?php
			
			$enddate = date('Y-m-t');
			for($startdate = date('Y-m-01');$startdate <= $enddate;$startdate = date("Y-m-d",strtotime("+1 day", strtotime($startdate))))
			{
				$totalsale = $totalcollection = 0;
				$sql = "SELECT * FROM enquiry WHERE qdatec='$startdate'";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc())
				{
					$id = $row["id"];

					$sql1 = "SELECT * FROM project WHERE eid='$id'";
					$result1 = $conn->query($sql1);
					$row1 = $result1->fetch_assoc();

					$totalsale += $row1["value"];
				}
				$sql2 = "SELECT sum(current) as current FROM invoice WHERE recdate='$startdate'";
				$result2 = $conn->query($sql2);
				$row2 = $result2->fetch_assoc();
				$totalcollection = $row2["current"];
				
				if($totalcollection == "")
				{
					$totalcollection = 0;
				}
				$tempdate = date("d-m",strtotime($startdate));

				echo "['".$tempdate."',".$totalsale.",".$totalcollection."],";
			}
		?>
        ]);

        var options = {
          title: 'Sales and Collection Reports of This Month',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Sales', 'Collection'],
          <?php echo $todaychart ?>
          <?php echo $monthchart ?>
        ]);

        var options = {
          title : 'Sales and Collection Reports',
          vAxis: {title: 'Amount'},
          hAxis: {title: ''},
          seriesType: 'bars',
          series: {5: {type: 'line'}}        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Division', 'No. of Projects Awarded'],
		  	<?php
				$pstatus = "AWARDED";

				$sqls = "SELECT count(id) as id,division FROM enquiry WHERE pstatus='$pstatus' GROUP BY division";
				$results = $conn->query($sqls);
				while($rows = $results->fetch_assoc())
				{
					echo "['".$rows["division"]."',".$rows["id"]."],";
				}
			?>
        ]);

        var options = {
          title: 'Awarded Projects based on Division',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
	<script>
	// Start of jquery datatable
		$('#dataTableExample1').DataTable(
		{
			dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
		}
		);
		$('#dataTableExample2').DataTable(
		{
			dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
		}
		);
	</script>
	</body>
</html>