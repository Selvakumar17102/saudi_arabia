<?php
        
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
    
   if(isset($_GET['month']))
   {
        $month = $_GET['month'];
   }
   else
   {
        $month = date('F');     
   }   
        if($_REQUEST['division'] == 1) {
            $division = "SUSTAINABILITY";
        }
        if($_REQUEST['division'] == 2) {
            $division = "ENGINEERING";
        }
        if($_REQUEST['division'] == 3) {
            $division = "SIMULATION & ANALYSIS";
        }
        if($_REQUEST['division'] == 4) {
            $division = "ENVIRONMENTAL";
        }
        if($_REQUEST['division'] == 5) {
            $division = "ACOUSTICS";
        }
        if($_REQUEST['division'] == 6) {
            $division = "LASER SCANNING";
        }
        $date = date('Y/m/d');
        $url_division = $_REQUEST['division'];
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
	<meta name="description" content="TDS Reports | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="TDS Reports | Project Management System" />
	<meta property="og:description" content="TDS Reports | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>TDS Reports | Project Management System</title>
	
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
						<h4 class="breadcrumb-title"><h5><?php echo $division;?>- TDS Reports </h5></h4>
					</div>
					<div class="col-sm-1">
						<a  href="tds-reports.php" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
                    <div class="col-sm-8"><h5 style="margin-left:480px;"> <center><?php echo $month;?></center> </h5><br></div>
                    <div class="col-sm-3" style="margin-top:20px;margin-right:-30px;">
                    <?php
                        if($month == "January"){
                            $January = "SELECTED";
                        }
                        if($month == "February"){
                            $February = "SELECTED";
                        }
                        if($month == "March"){
                            $March = "SELECTED";
                        }
                        if($month == "April"){
                            $April = "SELECTED";
                        }
                        if($month == "May"){
                            $May = "SELECTED";
                        }
                        if($month == "June"){
                            $June = "SELECTED";
                        }
                        if($month == "July"){
                            $July = "SELECTED";
                        }
                        if($month == "August"){
                            $August = "SELECTED";
                        }
                        if($month == "September"){
                            $September = "SELECTED";
                        }
                        if($month == "October"){
                            $October = "SELECTED";
                        }
                        if($month == "November"){
                            $November = "SELECTED";
                        }
                        if($month == "December"){
                            $December = "SELECTED";
                        }
                    ?>
                         <form action="tds_reports_details.php?division='<?php echo $url_division;?>'" method="get">
                            <select name="month" class="form-control" onchange="get_month(this.value)">
                                <option value="" selected value disabled>Select Month</option>
                                <option value="All" >All</option>
                                <option value="January" <?php echo $January;?>>January</option>
                                <option value="February" <?php echo $February;?>>February</option>
                                <option value="March" <?php echo $March;?>>March</option>
                                <option value="April" <?php echo $April;?>>April</option>
                                <option value="May" <?php echo $May;?>>May</option>
                                <option value="June" <?php echo $June;?>>June</option>
                                <option value="July" <?php echo $July;?>>July</option>
                                <option value="August" <?php echo $August;?>>August</option>
                                <option value="September" <?php echo $September;?>>September</option>
                                <option value="October" <?php echo $October;?>>October</option>
                                <option value="November" <?php echo $November;?>>November</option>
                                <option value="December"<?php echo $December;?>>December</option>
                            </select>
                            <input type="hidden" name="division" value="<?php echo $_REQUEST['division'];?>">
                        </div>
                    <div class="col-sm-1">
                        <input type="submit" class="btn" value="filter" style="margin-top:20px;">
                    </div>
                    </form>
				</div>
            </div>
            <!--  -->
                        
            <div class="row head-count m-b30">
				<div class="col-lg-4">
					<div class="widget-card widget-bg1">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Invoice Generate Value
							</h4>
							<span class="wc-stats">
                            <?php 
                                $i_gst_sql = "SELECT sum(demo_tds) AS demo_tds  FROM invoice WHERE monthname(subdate)='$month' AND divi = '$division' AND paystatus != ''";
                                $i_gst_result = $conn->query($i_gst_sql);
                                $i_gst_row = mysqli_fetch_array($i_gst_result);
                                echo number_format($i_gst_row['demo_tds'],2)."₹";
                                ?>
							</span>		
						</div>				      
					</div>
				</div>
                <div class="col-lg-4">
					<div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title">
								 Total Recived Value
							</h4>
							<span class="wc-stats">
                            <?php 
                                $t_gst_sql = "SELECT sum(current_tds) AS current_tds  FROM invoice WHERE monthname(recdate)='$month' AND divi = '$division' AND paystatus != 0";
                                $t_gst_result = $conn->query($t_gst_sql);
                                $t_gst_row = mysqli_fetch_array($t_gst_result);
                                echo number_format($t_gst_row['current_tds'],2)."₹";
                                ?>
							</span>		
						
						</div>				      
					</div>
				</div>
                <div class="col-lg-4">
					<div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title">
								Total Due Amount
							</h4>
							<span class="wc-stats">
                                <?php 
                                // echo $date; 
                                    // echo $d_gst_sql = "SELECT sum(demo_value) AS total_gst,sum(current_gst) AS collect_gst FROM invoice WHERE  divi = '$division' AND DATE(due_date) > DATE(NOW())";
                                    $d_gst_sql = "SELECT SUM(demo_tds) AS total,SUM(current_tds) AS collected  FROM invoice WHERE (divi = '$division') AND (monthname(due_date)='$month') AND (DATE(due_date) < DATE(NOW()));";
                                    $d_gst_result = $conn->query($d_gst_sql);
                                    $d_gst_row = mysqli_fetch_array($d_gst_result);
                                    echo number_format($d_gst_row['total']-$d_gst_row['collected'],2)."₹";
                                ?>
							</span>		
						</div>				      
					</div>
				</div>
			</div>
            <!--  -->
			<div class="row">
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<!-- <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p> -->
                    <div class="card">
                        <div class="card-content">
                            <div class="table-responsive">
                            <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><center>S.NO</center></th>
											<th> <center>Project Id</center> </th>
											<th><center>Project Name</center></th>
                                            <th><center>Client Name</center></th>
                                            <th><center>Scope</center></th>
											<th><center>Recived TDS Value</center></th>
                                        </tr>	
                                    </thead>
									<tbody>
                                            <?php
                                                $sql0 = "SELECT * FROM invoice WHERE monthname(recdate)='$month' AND divi = '$division';";
                                                $result0 = $conn->query($sql0);
                                                while($row0 = mysqli_fetch_array($result0))
                                                {
                                                        $sql = "SELECT * FROM project WHERE proid ='".$row0['pid']."'";
                                                        $result = $conn->query($sql);
                                                        $row = mysqli_fetch_array($result);
                                                // {
                                                    $s_no+=1;
                                            ?>
                                        <tr>
                                            <td><center><?php echo $s_no;?></center></td> <!--S No--->
                                            <td><center><?php echo $row['proid'];?></center></td> <!--Project ID --->
                                            <!--==================Project Name ===========================--->
                                                    <?php
                                                        $sql1 = "SELECT * FROM enquiry WHERE id ='".$row['eid']."'";
                                                        $result1 = $conn->query($sql1);
                                                        $row1 = mysqli_fetch_array($result1);
                                                    ?> 
                                            <td><center><?php echo $row1['name'];?></center></td> <!--Project name --->
                                            <td><center><?php echo $row1['cname'];?></center></td> <!--Client Name --->
                                             <!--==================Scope Name ===========================--->
                                                    <?php
                                                    if($row['scope_type']==2){
                                                        $sql3 = "SELECT * FROM scope WHERE id='".$row['scope']."'";
													    $result3 = $conn->query($sql3);
                                                        $row3 = mysqli_fetch_array($result3);
                                                    }
                                                    else{
                                                        $sql3 = "SELECT * FROM scope_list WHERE id='".$row['scope']."'";
                                                        $result3 = $conn->query($sql3);
                                                        $row3 = mysqli_fetch_array($result3);
                                                    }
                                                    ?>
                                            <td><center><?php echo $row3['scope'];?></center></td> <!--Scope Name --->
                                           
                                            <!--==================Recived Name ===========================--->
                                                    <?php

                                                    ?>
                                            <td><center><?php echo number_format($row0['current_tds'],2);?>₹</center></td> <!-- Gst Value  --->
                                            
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