<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

    $date = date("Y-m-d");
	$month = date('m');

    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['to_date'];

    if($start_date =="" || $end_date == "")
    {
        $start_date = date("Y-m-d", strtotime("-1 day"));
        $end_date = date("Y-m-d");
    }

	$totawd == 0;
	$totpro == 0;
	$totdep == 0;

	$totawd1 = "SELECT * FROM project WHERE enq_date BETWEEN '$start_date' AND '$end_date'";
	$totawd2 = $conn->query($totawd1);
	$totawd = $totawd2->num_rows;
	
	$totpro1 = "SELECT * FROM project WHERE subdivi = 'Project' WHERE enq_date BETWEEN '$start_date' AND '$end_date'";
	$totpro2 = $conn->query($totpro1);
	$totpro = $totpro2->num_rows;
	
	$totdep1 = "SELECT * FROM project WHERE subdivi = 'Deputation' WHERE enq_date BETWEEN '$start_date' AND '$end_date'";
	$totdep2 = $conn->query($totdep1);
	$totdep = $totdep2->num_rows;

    if(isset($_POST['search']))
    {
        $from_date = $_POST['fd'];
        $to_date = $_POST['td'];

        header("location: custom-project.php?start_date=$from_date&to_date=$to_date");
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
                                        <input class="form-control" type="date" name="fd" value="<?php echo $start_date ?>" required>
                                    </div>
                                    <label class="col-sm-2 col-form-label">To Date</label>
                                    <div class="col-sm-3 course">
                                        <input class="form-control" type="date" name="td" value="<?php echo $end_date ?>" required>
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
            <div class="row head-count m-b30 mt-5">
                <div class="col-lg-3">
                    <a href="project-selected2.php?id=1&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>" title="Running Projects"><div class="widget-card widget-bg1">					 
                        <div class="wc-item">
                            <h4 class="wc-title">
                                Running
                            </h4>
                            <span class="wc-stats">
                                <?php 
                                    $tot1 = "SELECT * FROM project where status = 'Running' AND enq_date BETWEEN '$start_date' AND '$end_date'";
                                    $tot2 = $conn->query($tot1);
                                    $tot = $tot2->num_rows;
                                    if($tot > 0) {
                                        echo $tot;
                                    } else {
                                        echo $tot = 0;
                                    }
                                ?>
                            </span>
                        </div>				      
                    </div></a>
                </div>

                <div class="col-lg-3">
                    <a href="project-selected2.php?id=2&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>" title="Commercially Open Projects"><div class="widget-card widget-bg2">					 
                        <div class="wc-item">
                            <h4 class="wc-title">
                                Commercially Open
                            </h4>
                            <span class="wc-stats">
                                <?php 
                                    $tend1 = "SELECT * FROM project where status = 'Commercially Open' AND enq_date BETWEEN '$start_date' AND '$end_date'";
                                    $tend2 = $conn->query($tend1);
                                    $tend = $tend2->num_rows;
                                    if($tend > 0) {
                                        echo $tend;
                                    } else {
                                        echo $tend = 0;
                                    }
                                ?>
                            </span>		
                        
                        </div>				      
                    </div><a>
                </div>

                <div class="col-lg-3">
                    <a href="project-selected2.php?id=3&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>" title="Project Closed"><div class="widget-card widget-bg3">					 
                        <div class="wc-item">
                            <h4 class="wc-title">
                                Project Closed
                            </h4>
                            <span class="wc-stats">
                                <?php 
                                    $jobin1 = "SELECT * FROM project where status = 'Project Closed' AND enq_date BETWEEN '$start_date' AND '$end_date'";
                                    $jobin2 = $conn->query($jobin1);
                                    $jobin = $jobin2->num_rows;
                                    if($jobin > 0) {
                                        echo $jobin;
                                    } else {
                                        echo $jobin = 0;
                                    }
                                ?>
                            </span>		
                            
                        </div>				      
                    </div></a>
                </div>

                <div class="col-lg-3">
                    <a href="project-selected2.php?id=4&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>" title="Commercially Closed"><div class="widget-card widget-bg4">					 
                        <div class="wc-item">
                            <h4 class="wc-title">
                                Commercially Closed
                            </h4>
                            <span class="wc-stats">
                                <?php 	
                                    $jobin1 = "SELECT * FROM project where status = 'Commercially Closed' AND enq_date BETWEEN '$start_date' AND '$end_date'";
                                    $jobin2 = $conn->query($jobin1);
                                    $jobin = $jobin2->num_rows;
                                    if($jobin > 0) {
                                        echo $jobin;
                                    } else {
                                        echo $jobin = 0;
                                    }
                                ?>
                            </span>		
                            
                        </div>				      
                    </div></a>
                </div>

                </div>

            <div class="row">
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-striped" style="margin-bottom: 0;">
                                <thead>
                                    <tr>
                                        <th rowspan="5">Division</th>
                                        <th rowspan="5">Total Awarded Projects (<?php echo $totawd; ?>)</th>
                                        <th rowspan="5">Running</th>
                                        <th rowspan="5">Commercially Open</th>											
                                        <th colspan="2">Closed</th>
                                    </tr>
                                    <tr>
                                        <th>Project</th>
                                        <th>Commercially</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    <?php
                                        $sp = $sd = $sr = $sc = $scl = $scl1 = 0;
                                        $ep = $ed = $er = $ec = $ecl = $ecl1 = 0;
                                        $sap = $sad = $sar = $sac = $sacl = $sacl1 = 0;
                                        $lp = $ld = $lr = $lc = $lcl = $lcl1 = 0;
                                        $elp = $eld = $elr = $elc = $elcl = $elcl1 = 0;
                                        $alp = $ald = $alr = $alc = $alcl = $alcl1 = 0;
                                        $llp = $lld = $llr = $llc = $llcl = $llcl1 = 0;
                                        $sql = "SELECT * FROM project WHERE enq_date BETWEEN '$start_date' AND '$end_date'";
                                        $result = $conn->query($sql);
                                        while($row = $result->fetch_assoc())
                                        {
                                            $eid = $row["eid"];
                                            $subdivi = $row["subdivi"];
                                            $status = $row["status"];

                                            $sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
                                            $result1 = $conn->query($sql1);
                                            $row1 = $result1->fetch_assoc();

                                            $divi = $row["divi"];

                                            if($divi == "SUSTAINABILITY")
                                            {
                                                if($subdivi == "Project")
                                                {
                                                    $sp++;
                                                }
                                                else
                                                {
                                                    $sd++;
                                                }
                                                if($status == "Running")
                                                {
                                                    $sr++;
                                                }
                                                if($status == "Commercially Open")
                                                {
                                                    $sc++;
                                                }
                                                if($status == "Project Closed")
                                                {
                                                    $scl++;
                                                }
                                                if($status == "Commercially Closed")
                                                {
                                                    $scl1++;
                                                }
                                            }
                                            if($divi == "ENGINEERING")
                                            {
                                                if($subdivi == "Project")
                                                {
                                                    $ep++;
                                                }
                                                else
                                                {
                                                    $ed++;
                                                }
                                                if($status == "Running")
                                                {
                                                    $er++;
                                                }
                                                if($status == "Commercially Open")
                                                {
                                                    $ec++;
                                                }
                                                if($status == "Project Closed")
                                                {
                                                    $ecl++;
                                                }
                                                if($status == "Commercially Closed")
                                                {
                                                    $ecl1++;
                                                }
                                            }
                                            if($divi == "SIMULATION & ANALYSIS")
                                            {
                                                if($subdivi == "Project")
                                                {
                                                    $sap++;
                                                }
                                                else
                                                {
                                                    $sad++;
                                                }
                                                if($status == "Running")
                                                {
                                                    $sar++;
                                                }
                                                if($status == "Commercially Open")
                                                {
                                                    $sac++;
                                                }
                                                if($status == "Project Closed")
                                                {
                                                    $sacl++;
                                                }
                                                if($status == "Commercially Closed")
                                                {
                                                    $sacl1++;
                                                }
                                            }
                                            if($divi == "ENVIRONMENTAL")
                                            {
                                                if($subdivi == "Project")
                                                {
                                                    $elp++;
                                                }
                                                else
                                                {
                                                    $eld++;
                                                }
                                                if($status == "Running")
                                                {
                                                    $elr++;
                                                }
                                                if($status == "Commercially Open")
                                                {
                                                    $elc++;
                                                }
                                                if($status == "Project Closed")
                                                {
                                                    $elcl++;
                                                }
                                                if($status == "Commercially Closed")
                                                {
                                                    $elcl1++;
                                                }
                                            }
                                            if($divi == "ACOUSTICS")
                                            {
                                                if($subdivi == "Project")
                                                {
                                                    $alp++;
                                                }
                                                else
                                                {
                                                    $ald++;
                                                }
                                                if($status == "Running")
                                                {
                                                    $alr++;
                                                }
                                                if($status == "Commercially Open")
                                                {
                                                    $alc++;
                                                }
                                                if($status == "Project Closed")
                                                {
                                                    $alcl++;
                                                }
                                                if($status == "Commercially Closed")
                                                {
                                                    $alcl1++;
                                                }
                                            }
                                            if($divi == "LASER SCANNING")
                                            {
                                                if($subdivi == "Project")
                                                {
                                                    $llp++;
                                                }
                                                else
                                                {
                                                    $lld++;
                                                }
                                                if($status == "Running")
                                                {
                                                    $llr++;
                                                }
                                                if($status == "Commercially Open")
                                                {
                                                    $llc++;
                                                }
                                                if($status == "Project Closed")
                                                {
                                                    $llcl++;
                                                }
                                                if($status == "Commercially Closed")
                                                {
                                                    $llcl1++;
                                                }
                                            }
                                        }
                                    //    $total_sub_awarded = $sp+$sd;
                                    //    $total_eng_awarded = $ep+$ed;
                                    //    $total_simulation_awarded = $sap+$sad;
                                    //    $total_env_awarded = $elp+$eld;
                                    //    $total_aco_awarded = $alp+$ald;
                                    //    $total_laser_awarded = $llp+$lld;
                                    ?>
                                    <tr>
                                        <th>SUSTAINABILITY</th>
                                        <td><?php if($sp != 0 || $sd !=""){ ?><a href="project-selected2.php?mid=1&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sp+$sd ?></a><?php }else echo $sp ?></td>
                                        <td><?php if($sr != 0){ ?><a href="project-selected2.php?id=1&mid=1&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sr ?></a><?php }else echo $sr ?></td>
                                        <td><?php if($sc != 0){ ?><a href="project-selected2.php?id=2&mid=1&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sc ?></a><?php }else echo $sc ?></td>
                                        <td><?php if($scl != 0){ ?><a href="project-selected2.php?id=3&mid=1&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $scl ?></a><?php }else echo $scl ?></td>
                                        <td><?php if($scl1 != 0){ ?><a href="project-selected2.php?id=4&mid=1&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $scl1 ?></a><?php }else echo $scl1 ?></td>
                                    </tr>
                                    <tr>
                                        <th>ENGINEERING SERVICES</th>
                                        <td><?php if($ep != 0 || $ed !=""){ ?><a href="project-selected2.php?mid=2&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $ep+$ed ?></a><?php }else echo $ep ?></td>
                                        <td><?php if($er != 0){ ?><a href="project-selected2.php?id=1&mid=2&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $er ?></a><?php }else echo $er ?></td>
                                        <td><?php if($ec != 0){ ?><a href="project-selected2.php?id=2&mid=2&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $ec ?></a><?php }else echo $ec ?></td>
                                        <td><?php if($ecl != 0){ ?><a href="project-selected2.php?id=3&mid=2&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $ecl ?></a><?php }else echo $ecl ?></td>
                                        <td><?php if($ecl1 != 0){ ?><a href="project-selected2.php?id=4&mid=2&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $ecl1 ?></a><?php }else echo $ecl1 ?></td>
                                    </tr>
                                    <tr>
                                        <th>SIMULATION & ANALYSIS SERVICES</th>
                                        <td><?php if($sap != 0 || $sad != ""){ ?><a href="project-selected2.php?mid=3&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sap+$sad ?></a><?php }else echo $sap ?></td>
                                        <td><?php if($sar != 0){ ?><a href="project-selected2.php?id=1&mid=3&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sar ?></a><?php }else echo $sar ?></td>
                                        <td><?php if($sac != 0){ ?><a href="project-selected2.php?id=2&mid=3&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sac ?></a><?php }else echo $sac ?></td>
                                        <td><?php if($sacl != 0){ ?><a href="project-selected2.php?id=3&mid=3&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sacl ?></a><?php }else echo $sacl ?></td>
                                        <td><?php if($sacl1 != 0){ ?><a href="project-selected2.php?id=4&mid=3&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $sacl1 ?></a><?php }else echo $sacl1 ?></td>
                                    </tr>
                                    <tr>
                                        <th>ENVIRONMENTAL</th>
                                        <td><?php if($elp != 0 || $eld != 0){ ?><a href="project-selected2.php?mid=4&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $elp+$eld ?></a><?php }else echo $elp ?></td>
                                        <td><?php if($elr != 0){ ?><a href="project-selected2.php?id=1&mid=4&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $elr ?></a><?php }else echo $elr ?></td>
                                        <td><?php if($elc != 0){ ?><a href="project-selected2.php?id=2&mid=4&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $elc ?></a><?php }else echo $elc ?></td>
                                        <td><?php if($elcl != 0){ ?><a href="project-selected2.php?id=3&mid=4&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $elcl ?></a><?php }else echo $elcl ?></td>
                                        <td><?php if($elcl1 != 0){ ?><a href="project-selected2.php?id=4&mid=4&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $elcl1 ?></a><?php }else echo $elcl1 ?></td>
                                    </tr>
                                    <tr>
                                        <th>ACOUSTICS</th>
                                        <td><?php if($alp != 0 || $ald != 0){ ?><a href="project-selected2.php?mid=5&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $alp+$ald ?></a><?php }else echo $alp ?></td>
                                        <td><?php if($alr != 0){ ?><a href="project-selected2.php?id=1&mid=5&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $alr ?></a><?php }else echo $alr ?></td>
                                        <td><?php if($alc != 0){ ?><a href="project-selected2.php?id=2&mid=5&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $alc ?></a><?php }else echo $alc ?></td>
                                        <td><?php if($alcl != 0){ ?><a href="project-selected2.php?id=3&mid=5&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $alcl ?></a><?php }else echo $alcl ?></td>
                                        <td><?php if($alcl1 != 0){ ?><a href="project-selected2.php?id=4&mid=5&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $alcl1 ?></a><?php }else echo $alcl1 ?></td>
                                    </tr>
                                    <tr>
                                        <th>LASER SCANNING</th>
                                        <td><?php if($llp != 0 || $lld != 0){ ?><a href="project-selected2.php?mid=6&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $llp+$lld ?></a><?php }else echo $llp ?></td>
                                        <td><?php if($llr != 0){ ?><a href="project-selected2.php?id=1&mid=6&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $llr ?></a><?php }else echo $llr ?></td>
                                        <td><?php if($llc != 0){ ?><a href="project-selected2.php?id=2&mid=6&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $llc ?></a><?php }else echo $llc ?></td>
                                        <td><?php if($llcl != 0){ ?><a href="project-selected2.php?id=3&mid=6&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $llcl ?></a><?php }else echo $llcl ?></td>
                                        <td><?php if($llcl1 != 0){ ?><a href="project-selected2.php?id=4&mid=6&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>"><?php echo $llcl1 ?></a><?php }else echo $llcl1 ?></td>
                                    </tr>
                                    
                                    
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