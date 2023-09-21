<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
    
    $id = $_REQUEST["id"];
    $mid = $_REQUEST["mid"];
    $start_date = $_REQUEST["start_date"];
    $end_date = $_REQUEST["end_date"];

	$pstatus = "AWARDED";
	$divi = "";	

	if($mid == 1)
    {
        $divi = "SUSTAINABILITY";
    }
    if($mid == 2)
    {
        $divi = "ENGINEERING";
    }
    if($mid == 3)
    {
        $divi = "SIMULATION & ANALYSIS";
    }
    if($mid == 4)
    {
        $divi = "ENVIRONMENTAL";
    }
    if($mid == 5)
    {
        $divi = "ACOUSTICS";
    }
    if($mid == 6)
    {
        $divi = "LASER SCANNING";
    }
	if($mid == 7)
    {
        $divi = "OIL & GAS";
    }
	

    // if($id == 1)
    // {
    //     $subdivi = "Project";
    // }
    // if($id == 2)
    // {
    //     $subdivi = "Deputation";
	// }

	if($id == 1)
    {
        $status = "Running";
    }
    if($id == 2)
    {
        $status = "Commercially Open";
    }
    if($id == 3)
    {
        $status = "Project Closed";
    }
    if($id == 4)
    {
        $status = "Commercially Closed";
    }
	
	if($id != "" && $divi !="")
	{
		$sql = "SELECT * FROM project WHERE status='$status' AND divi='$divi'";
	}
	else
	{
		if($id != "")
		{
			$sql = "SELECT * FROM project WHERE status='$status'";
		}else{
			$sql = "SELECT * FROM project WHERE divi='$divi'";
		}
	}

	if($start_date != "" && $end_date != "")
	{
		$sql .= " AND enq_date BETWEEN '$start_date' AND '$end_date'";
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
	<meta name="description" content="All Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Enquiry | Project Management System" />
	<meta property="og:description" content="All Enquiry | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Project Report | Project Management System</title>
	
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
			<div class="db-breadcrumb">
				<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title"><?php echo $divi ?></h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
            </div>
				
			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Division</th>											
											<th>Project ID</th>
											<th>Project Name</th>
											<th>Client</th>
											<th>Scope</th>
											<th>Total PO</th>
											<th>Total VAT</th>
                                            <th>Month of Award</th>
											<th>Status of the Projects</th>
											<?php
												if($rowside["id"] != 2)
												{
											?>
											<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$proid = $row["proid"];
												$id = $row["eid"];
												$pid = $row["id"];
												$status = $row["nostatus"];
												$p_scope_id = $row["scope"];

												$scope = "";

												$sql1 = "SELECT * FROM enquiry WHERE id='$id'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

												$id = $row1["id"];
												$scope_id = $row1["scope"];
												$scope_type = $row1['scope_type'];

												if($scope_type == 0)
												{
													$sql3 = "SELECT * FROM scope WHERE id='$p_scope_id'";
													$result3 = $conn->query($sql3);
													if($result3->num_rows > 0)
													{
														if($result3->num_rows == 1){
															$row3 = $result3->fetch_assoc();
															$scope = $row3["scope"];
														} else{
															
															$row3 = $result3->fetch_assoc();
															$scope = $row3["scope"];
														}
													}else{
														$scope = $row1["scope"];
													}
												}
												else
												{
													$sql3 = "SELECT * FROM scope_list WHERE id='$scope_id'";
													$result3 = $conn->query($sql3);
													if($result3->num_rows > 0)
													{
														$row3 = $result3->fetch_assoc();
														$scope = $row3["scope"];	
													}else{
														$scope = $row1["scope"];
													}
												}

                                                if($result1->num_rows > 0)
                                                {
                                                    echo '<tr>';
                                                    echo '<td><center>'.$count.'</center></td>';
                                                    echo '<td><center>'.$row["divi"].'</center></td>';
                                                    echo '<td><center>'.$row["proid"].'</center></td>';
                                                    echo '<td><center>'.$row1["name"].'</center></td>';
                                                    echo '<td><center>'.$row1["cname"].'</center></td>';
													echo '<td><center>'.$scope.'</center></td>';
													echo '<td><center>SAR&nbsp'.number_format($row["value"],2).'</center></td>';
													echo '<td><center>SAR&nbsp'.number_format($row["gst_value"],2).'</center></td>';
                                                    $time=strtotime($row1["qdatec"]);
                                                    $month=date("F-Y",$time);
                                                    echo '<td><center>'.$month.'</center></td>';
													echo '<td><center>'.$row["status"].'</center></td>';
													if($rowside["id"] != 2)
													{
														?>
															<td><a href="view-project.php?id=<?php echo $pid; ?>" title="View"><span class="notification-icon dashbg-green"><i class="fa fa-eye" aria-hidden="true"></i></span></a></td>
														<?php
													}
													
                                                    echo '</tr>';
                                                    $count++;
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