<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

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
	<meta name="description" content="Project Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Project Reports | Project Management System" />
	<meta property="og:description" content="Project Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Project Reports | Project Management System</title>
	
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
	.table-striped tr td {text-align: center;}
	.table-striped tr td a{padding: 10px;}
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
                <div class="row r-p100">
                    <div class="col-sm-11">
                        <h4 class="breadcrumb-title">Custom Project Report</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>

			</div>	

            <div class="row">
            
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="widget-box card">

                        <div class="card-header">
                            <h4>Custom Search</h4>
                        </div>

                        <div class="widget-inner">
                            <form method="post" class="edit-profile">
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label">From Date</label>
                                    <div class="col-sm-3 course">
                                        <input class="form-control" type="date" name="fd" value="<?php echo date("Y-m-d", strtotime("-1 day")) ?>" required>
                                    </div>

                                    <label class="col-sm-2 col-form-label">To Date</label>
                                    <div class="col-sm-3 course">
                                        <input class="form-control" type="date" name="td" value="<?php echo date("Y-m-d") ?>" required>
                                    </div>

                                    <div class="col-sm-2">
										<input type="submit" name="search" class="btn" value="Search">
									</div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <?php

                if(isset($_POST["search"]))
                {
                    $fd = $_POST["fd"];
                    $td = $_POST["td"];
            ?>

			<div class="row">
			
				
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
					<div class="card-header">
							<h4 style="text-align: center;">Project Reports</h4>
						</div>
                	    <div class="table-responsive">
                    	        <table class="table table-striped" style="margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th>DIVISION</th>
											<th>Project</th>
											<th>Deputation</th>
											<th>Running</th>
											<th>Commercially Open</th>											
											<th>Closed</th>
                                        </tr>
                                    </thead>
									<tbody>

                                        <?php

                                            $suspro = $espro = $simpro = $lsspro = 0;
                                            $susdep = $esdep = $simdep = $lssdep = 0;
                                            $susrun = $esrun = $simrun = $lssrun = 0;
                                            $suscom = $escom = $simcom = $lsscom = 0;
                                            $susclo = $esclo = $simclo = $lssclo = 0;

                                            $award = "AWARDED";
                                            $sql = "SELECT * FROM enquiry WHERE pstatus='$award' AND qdatec BETWEEN '$fd' AND '$td'";
                                            $result = $conn->query($sql);
                                            while($row = $result->fetch_assoc())
                                            {
                                                $eid = $row["id"];
                                                $divi = $row["division"];

                                                $sql1 = "SELECT * FROM project WHERE id='$eid'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

                                                if($divi == "SUSTAINABILITY")
                                                {
                                                    if($row1["subdivi"] == "Project")
                                                    {
                                                        $suspro++;
                                                    }
                                                    else
                                                    {
                                                        $susdep++;
                                                    }
                                                    if($row1["status"] == "Running")
                                                    {
                                                        $susrun++;
                                                    }
                                                    if($row1["status"] == "Commercially Open")
                                                    {
                                                        $suscom++;
                                                    }
                                                    if($row1["status"] == "Closed")
                                                    {
                                                        $susclo++;
                                                    }
                                                }
                                                if($divi == "ENGINEERING SERVICES")
                                                {
                                                    if($row1["subdivi"] == "Project")
                                                    {
                                                        $espro++;
                                                    }
                                                    else
                                                    {
                                                        $esdep++;
                                                    }
                                                    if($row1["status"] == "Running")
                                                    {
                                                        $esrun++;
                                                    }
                                                    if($row1["status"] == "Commercially Open")
                                                    {
                                                        $escom++;
                                                    }
                                                    if($row1["status"] == "Closed")
                                                    {
                                                        $esclo++;
                                                    }
                                                }
                                                if($divi == "SIMULATION & ANALYSIS SERVICES")
                                                {
                                                    if($row1["subdivi"] == "Project")
                                                    {
                                                        $simpro++;
                                                    }
                                                    else
                                                    {
                                                        $simdep++;
                                                    }
                                                    if($row1["status"] == "Running")
                                                    {
                                                        $simrun++;
                                                    }
                                                    if($row1["status"] == "Commercially Open")
                                                    {
                                                        $simcom++;
                                                    }
                                                    if($row1["status"] == "Closed")
                                                    {
                                                        $simclo++;
                                                    }
                                                }
                                                if($divi == "DEPUTATION")
                                                {
                                                    if($row1["subdivi"] == "Project")
                                                    {
                                                        $lsspro++;
                                                    }
                                                    else
                                                    {
                                                        $lssdep++;
                                                    }
                                                    if($row1["status"] == "Running")
                                                    {
                                                        $lssrun++;
                                                    }
                                                    if($row1["status"] == "Commercially Open")
                                                    {
                                                        $lsscom++;
                                                    }
                                                    if($row1["status"] == "Closed")
                                                    {
                                                        $lssclo++;
                                                    }
                                                }
                                            }
                                        ?>

										<tr>
											<th>Sustainability</th>
                                            <td><?php echo $suspro ?></td>
                                            <td><?php echo $susdep ?></td>
                                            <td><?php echo $susrun ?></td>
                                            <td><?php echo $suscom ?></td>
                                            <td><?php echo $susclo ?></td>
										</tr>
										<tr>
											<th>Engineering Services</th>
                                            <td><?php echo $espro ?></td>
                                            <td><?php echo $esdep ?></td>
                                            <td><?php echo $esrun ?></td>
                                            <td><?php echo $escom ?></td>
                                            <td><?php echo $esclo ?></td>
										</tr>
										<tr>
											<th>Simulation & Analysis Services</th>
                                            <td><?php echo $simpro ?></td>
                                            <td><?php echo $simdep ?></td>
                                            <td><?php echo $simrun ?></td>
                                            <td><?php echo $simcom ?></td>
                                            <td><?php echo $simclo ?></td>
										</tr>
										<tr>
											<th>Deputation</th>
                                            <td><?php echo $lsspro ?></td>
                                            <td><?php echo $lssdep ?></td>
                                            <td><?php echo $lssrun ?></td>
                                            <td><?php echo $lsscom ?></td>
                                            <td><?php echo $lssclo ?></td>
										</tr>

									</tbody>
                                </table>
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