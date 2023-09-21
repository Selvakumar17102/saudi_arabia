<?php

	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($id == "")
	{
		$today = date('Y-m-d');
		$thismonth = date('Y-m-d',strtotime('-60 days'));
		$monthName = "For The Past 60 Days";
	}
	else
	{
		if($id < 10)
		{
			$id = "0".$id;
		}

		$thismonth = date('Y-'.$id.'-01');
		$today = date("Y-m-t", strtotime($thismonth));
		$monthName = "For The Month of - ".date('F Y', mktime(0, 0, 0, $id, 10));
	}

	if($fdate != "" && $tdate != "")
	{
		$today = $tdate;
		$thismonth = $fdate;
		$monthName = "From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));
    }
    
    $s = date('Y-m-d',strtotime($thismonth));
    $e = date('Y-m-d',strtotime($today));
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
				<div class="col-sm-11"><h4 class="breadcrumb-title">Project Alerts</h4></div>
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
                                <div class="col-sm-3">
                                    <center><label class="col-form-label">Month Wise Search</label></center>
                                    <select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
                                        <option value disabled Selected>Select Month</option>
                                        <option value="1">Jan</option>
                                        <option value="2">Feb</option>
                                        <option value="3">Mar</option>
                                        <option value="4">Apr</option>
                                        <option value="5">May</option>
                                        <option value="6">Jun</option>
                                        <option value="7">Jul</option>
                                        <option value="8">Aug</option>
                                        <option value="9">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                                
                                </div>
                                <div class="col-sm-9">
                                    <center><label class="col-form-label">Custom Search</label></center>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="date" id="fdate" class="form-control" max="<?php echo date('Y-m-d') ?>">
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="date" id="tdate" class="form-control" max="<?php echo date('Y-m-d') ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="button" class="btn" value="Submit" onclick="search()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                        <div class="card-header">
                            <center><h6>Monthly Project</h6></center>
                        </div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Division</th>
                                            <th>Project Id</th>
                                            <th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>PO Value</th>
                                            <th>Invoiced Value</th>
											<th>Collected Value</th>
											<th>Yet To Invoice</th>
											<th>Outstanding Value</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            $sql = "SELECT * FROM project WHERE pterms='2'";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $eid = $row["eid"];
                                                $pid = $row["proid"];
                                                $test = $current = $demo = 0;

                                                $sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

                                                $rfqid = $row1["rfqid"];

                                                $sql2 = "SELECT * FROM invoice WHERE pid='$pid' AND current!='0'";
                                                $result2 = $conn->query($sql2);
                                                if($result2->num_rows > 0)
                                                {
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        $date = date('Y-m-d',strtotime($row2["date"]));
                                                        if($date >= $s && $date <= $e)
                                                        {
                                                            
                                                        }
                                                        else
                                                        {
                                                            $test = 1;
                                                        }
                                                        $demo += $row2["demo"];

                                                        if($row2["paystatus"] == 2)
                                                        {
                                                            $current += $row2["current"];
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $sql2 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
                                                    $result2 = $conn->query($sql2);
                                                    if($result2->num_rows > 0)
                                                    {
                                                        while($row2 = $result2->fetch_assoc())
                                                        {
                                                            $date = date('Y-m-d',strtotime($row2["date"]));
                                                            if($date >= $s && $date <= $e)
                                                            {
                                                                
                                                            }
                                                            else
                                                            {
                                                                $test = 1;
                                                            }
                                                            $demo += $row2["demo"];

                                                            if($row2["paystatus"] == 2)
                                                            {
                                                                $current += $row2["current"];
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $test = 1;
                                                    }
                                                }
                                                if($test == 1)
                                                {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++ ?></td>
                                                    <td><?php echo $row["divi"] ?></td>
                                                    <td><?php echo $pid ?></td>
                                                    <td><?php echo $row1["name"] ?></td>
                                                    <td><?php echo $row1["cname"] ?></td>
                                                    <td>QAR <?php echo number_format($row["value"]) ?></td>
                                                    <td>QAR <?php echo number_format($demo) ?></td>
                                                    <td>QAR <?php echo number_format($current) ?></td>
                                                    <td>QAR <?php echo number_format($row["value"] - $demo) ?></td>
                                                    <td>QAR <?php echo number_format($demo - $current) ?></td>
                                                    <td><center><a href="invoice.php?id=<?php echo $pid ?>" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>
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

            <div class="row m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
                            <center><h6>Milestone Project</h6></center>
                        </div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample2" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Division</th>
                                            <th>Project Id</th>
                                            <th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>PO Value</th>
                                            <th>Invoiced Value</th>
											<th>Collected Value</th>
											<th>Yet To Invoice</th>
											<th>Outstanding Value</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql = "SELECT * FROM project WHERE pterms='1'";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $eid = $row["eid"];
                                                $pid = $row["proid"];
                                                $test = $current = $demo = 0;

                                                $sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

                                                $rfqid = $row1["rfqid"];

                                                $sql2 = "SELECT * FROM invoice WHERE pid='$pid' AND current!='0'";
                                                $result2 = $conn->query($sql2);
                                                if($result2->num_rows > 0)
                                                {
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        $date = date('Y-m-d',strtotime($row2["date"]));
                                                        if($date >= $s && $date <= $e)
                                                        {
                                                            
                                                        }
                                                        else
                                                        {
                                                            $test = 1;
                                                        }
                                                        $demo += $row2["demo"];

                                                        if($row2["paystatus"] == 2)
                                                        {
                                                            $current += $row2["current"];
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $sql2 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
                                                    $result2 = $conn->query($sql2);
                                                    if($result2->num_rows > 0)
                                                    {
                                                        while($row2 = $result2->fetch_assoc())
                                                        {
                                                            $date = date('Y-m-d',strtotime($row2["date"]));
                                                            if($date >= $s && $date <= $e)
                                                            {
                                                                
                                                            }
                                                            else
                                                            {
                                                                $test = 1;
                                                            }
                                                            $demo += $row2["demo"];

                                                            if($row2["paystatus"] == 2)
                                                            {
                                                                $current += $row2["current"];
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $test = 1;
                                                    }
                                                }
                                                if($test == 1)
                                                {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++ ?></td>
                                                    <td><?php echo $row["divi"] ?></td>
                                                    <td><?php echo $pid ?></td>
                                                    <td><?php echo $row1["name"] ?></td>
                                                    <td><?php echo $row1["cname"] ?></td>
                                                    <td>QAR <?php echo number_format($row["value"]) ?></td>
                                                    <td>QAR <?php echo number_format($demo) ?></td>
                                                    <td>QAR <?php echo number_format($current) ?></td>
                                                    <td>QAR <?php echo number_format($row["value"] - $demo) ?></td>
                                                    <td>QAR <?php echo number_format($demo - $current) ?></td>
                                                    <td><center><a href="invoice.php?id=<?php echo $pid ?>" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>
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

            <div class="row m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
                            <center><h6>Prorata Project</h6></center>
                        </div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample3" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Division</th>
                                            <th>Project Id</th>
                                            <th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>PO Value</th>
                                            <th>Invoiced Value</th>
											<th>Collected Value</th>
											<th>Yet To Invoice</th>
											<th>Outstanding Value</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql = "SELECT * FROM project WHERE pterms='3'";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $eid = $row["eid"];
                                                $pid = $row["proid"];
                                                $test = $current = $demo = 0;

                                                $sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

                                                $rfqid = $row1["rfqid"];

                                                $sql2 = "SELECT * FROM invoice WHERE pid='$pid' AND current!='0'";
                                                $result2 = $conn->query($sql2);
                                                if($result2->num_rows > 0)
                                                {
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        $date = date('Y-m-d',strtotime($row2["date"]));
                                                        if($date >= $s && $date <= $e)
                                                        {
                                                            
                                                        }
                                                        else
                                                        {
                                                            $test = 1;
                                                        }
                                                        $demo += $row2["demo"];

                                                        if($row2["paystatus"] == 2)
                                                        {
                                                            $current += $row2["current"];
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $sql2 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0'";
                                                    $result2 = $conn->query($sql2);
                                                    if($result2->num_rows > 0)
                                                    {
                                                        while($row2 = $result2->fetch_assoc())
                                                        {
                                                            $date = date('Y-m-d',strtotime($row2["date"]));
                                                            if($date >= $s && $date <= $e)
                                                            {
                                                                
                                                            }
                                                            else
                                                            {
                                                                $test = 1;
                                                            }
                                                            $demo += $row2["demo"];

                                                            if($row2["paystatus"] == 2)
                                                            {
                                                                $current += $row2["current"];
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $test = 1;
                                                    }
                                                }
                                                if($test == 1)
                                                {
                                        ?>
                                                <tr>
                                                    <td><?php echo $count++ ?></td>
                                                    <td><?php echo $row["divi"] ?></td>
                                                    <td><?php echo $pid ?></td>
                                                    <td><?php echo $row1["name"] ?></td>
                                                    <td><?php echo $row1["cname"] ?></td>
                                                    <td>QAR <?php echo number_format($row["value"]) ?></td>
                                                    <td>QAR <?php echo number_format($demo) ?></td>
                                                    <td>QAR <?php echo number_format($current) ?></td>
                                                    <td>QAR <?php echo number_format($row["value"] - $demo) ?></td>
                                                    <td>QAR <?php echo number_format($demo - $current) ?></td>
                                                    <td><center><a href="invoice.php?id=<?php echo $pid ?>" title="Next"><span class="notification-icon dashbg-yellow"><i class="fa fa-arrow-right" aria-hidden="true"></i></span></a></center></td>
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
			location.replace("http://www.conserveacademy.com/projectmgmttool/pending.php?id="+val);
		}
	}
    function search()
	{
		var fdate = document.getElementById('fdate').value;
		var tdate=document.getElementById('tdate').value;

		if(fdate == "")
		{
			$("#fdate").css("border", "1px solid red");
		}
		else
		{
			if(tdate == "")
			{
				$("#tdate").css("border", "1px solid red");
			}
			else
			{
				location.replace("http://www.conserveacademy.com/projectmgmttool/pending.php?fdate="+fdate+"&tdate="+tdate);
			}
		}
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
            $('#dataTableExample2').DataTable({
               dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
            $('#dataTableExample3').DataTable({
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