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
	<meta name="description" content="Followup Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Followup Reports | Project Management System" />
	<meta property="og:description" content="Followup Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Followup Reports | Project Management System</title>
	
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
                        <h4 class="breadcrumb-title">Custom Followup Reports</h4>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
					<div class="card-header">
							<h4 style="text-align: center;">Client Follow Up Report's</h4>
						</div>
                	    <div class="table-responsive">
                    	    <table class="table table-striped" style="margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th>DIVISION</th>
										<th>RFQ ID</th>
										<th>Tender</th>
										<th>Job In Hand</th>											
										<th>Lost</th>
                                    </tr>
                                </thead>
								<tbody>

                                    <?php

                                        $susrfq = $esrfq = $simrfq = $lssrfq = 0;
                                        $susten = $esten = $simten = $lssten = 0;
                                        $susjih = $esjih = $simjih = $lssjih = 0;
                                        $suslost = $eslost = $simlost = $lsslost = 0;

                                        $award = "AWARDED";
                                        $sql = "SELECT * FROM enquiry WHERE pstatus!='$award' AND qdatec BETWEEN '$fd' AND '$td'";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) 
                                        {
                                            $divi = $row["division"];
                                            $stage = $row["stage"];
                                            $pstatus = $row["pstatus"];

                                            if($divi == "SUSTAINABILITY")
                                            {
                                                $susrfq++;
                                                if($stage == "Tender")
                                                {
                                                    $susten++;
                                                }
                                                if($stage == "Job In Hand")
                                                {
                                                    $susjih++;
                                                }
                                                if($pstatus == "LOST")
                                                {
                                                    $suslost++;
                                                }
                                            }
                                            if($divi == "ENGINEERING SERVICES")
                                            {
                                                $esrfq++;
                                                if($stage == "Tender")
                                                {
                                                    $esten++;
                                                }
                                                if($stage == "Job In Hand")
                                                {
                                                    $esjih++;
                                                }
                                                if($pstatus == "LOST")
                                                {
                                                    $eslost++;
                                                }
                                            }
                                            if($divi == "SIMULATION & ANALYSIS SERVICES")
                                            {
                                                $simrfq++;
                                                if($stage == "Tender")
                                                {
                                                    $simten++;
                                                }
                                                if($stage == "Job In Hand")
                                                {
                                                    $simjih++;
                                                }
                                                if($pstatus == "LOST")
                                                {
                                                    $simlost++;
                                                }
                                            }
                                            if($divi == "DEPUTATION")
                                            {
                                                $lssrfq++;
                                                if($stage == "Tender")
                                                {
                                                    $lssten++;
                                                }
                                                if($stage == "Job In Hand")
                                                {
                                                    $lssjih++;
                                                }
                                                if($pstatus == "LOST")
                                                {
                                                    $lsslost++;
                                                }
                                            }
                                        }

                                    ?>
									   <tr>
                                            <td>SUSTAINABILITY</td>
                                            <td><?php echo $susrfq ?></td>
                                            <td><?php echo $susten ?></td>
                                            <td><?php echo $susjih ?></td>
                                            <td><?php echo $suslost ?></td>
                                       </tr>
									   <tr>
                                            <td>ENGINEERING SERVICES</td>
                                            <td><?php echo $esrfq ?></td>
                                            <td><?php echo $esten ?></td>
                                            <td><?php echo $esjih ?></td>
                                            <td><?php echo $eslost ?></td>
                                       </tr>
									   <tr>
                                            <td>SIMULATION & ANALYSIS SERVICES</td>
                                            <td><?php echo $simrfq ?></td>
                                            <td><?php echo $simten ?></td>
                                            <td><?php echo $simjih ?></td>
                                            <td><?php echo $simlost ?></td>
                                       </tr>
									   <tr>
                                            <td>Deputation</td>
                                            <td><?php echo $lssrfq ?></td>
                                            <td><?php echo $lssten ?></td>
                                            <td><?php echo $lssjih ?></td>
                                            <td><?php echo $lsslost ?></td>
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