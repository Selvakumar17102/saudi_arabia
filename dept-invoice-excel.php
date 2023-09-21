<?php

	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");

    $start_date = date("Y-m-01");
    $end_date = date("Y-m-t");

    $dep_array = array('Engineering','Sustainability','Environmental','Acoustics','Laser Scanning');

    $dep_name = $_REQUEST["dept"];
    $res = $_REQUEST["res"];

    if(!in_array($dep_name, $dep_array))
    {
        $dep_name = "Simulation & Analysis";
    }

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
	<title>Client Outstanding Projects | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Client Outstanding Project Details</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <select name="res" id="res" class="form-control" onchange="get(this.value)">
                        <option selected value disabled>Select Responsibility</option>
                        <?php
                            switch ($res) {
                                case 'NAGARAJAN NEHRUJI':
                                    $NAGARAJAN ="selected";
                                    break;
                                case 'VENKATESH':
                                    $VENKATESH ="selected";
                                    break;
                                case 'NAVEEN KUMAR':
                                    $NAVEEN ="selected";
                                    break;
                                case 'VISWANATHAN':
                                    $VISWANATHAN ="selected";
                                    break;
                                case 'BALAMURUGAN':
                                    $BALAMURUGAN ="selected";
                                    break;
                                case 'SABIR':
                                    $SABIR ="selected";
                                    break;
                                case 'AJMAL':
                                    $AJMAL ="selected";
                                    break;
                                case 'BAZEETH AHAMED':
                                    $BAZEETH ="selected";
                                    break;
                                case 'KARTHIKEYAN':
                                    $KARTHIKEYAN ="selected";
                                    break;
                                case 'GOPALAKRISHNAN':
                                    $GOPALAKRISHNAN ="selected";
                                    break;
                                case 'MADHAN KUMAR':
                                    $MADHAN ="selected";
                                    break;
                                case 'SHEIKH ABDULLAH':
                                    $SHEIKH ="selected";
                                    break;
                                case 'RAMESH':
                                    $RAMESH ="selected";
                                    break;
                                default:
                                    $VAISHALI = "selected";
                                    break;
                            }
                        ?>
                        <option value="NAGARAJAN NEHRUJI" <?php echo $NAGARAJAN;?>>NAGARAJAN NEHRUJI</option>
                        <option value="VENKATESH" <?php echo $VENKATESH;?>>VENKATESH</option>
                        <option value="NAVEEN KUMAR" <?php echo $NAVEEN;?>>NAVEEN KUMAR</option>
                        <option value="VISWANATHAN" <?php echo $VISWANATHAN;?>>VISWANATHAN</option>
                        <option value="BALAMURUGAN" <?php echo $BALAMURUGAN;?>>BALAMURUGAN</option>
                        <option value="SABIR" <?php echo $SABIR;?>>SABIR</option>
                        <option value="AJMAL" <?php echo $AJMAL;?>>AJMAL</option>
                        <option value="BAZEETH AHAMED" <?php echo $BAZEETH;?>>BAZEETH AHAMED</option>
                        <option value="KARTHIKEYAN" <?php echo $KARTHIKEYAN;?>>KARTHIKEYAN</option>
                        <option value="GOPALAKRISHNAN" <?php echo $GOPALAKRISHNAN;?>>GOPALAKRISHNAN</option>
                        <option value="MADHAN KUMAR" <?php echo $MADHAN;?>>MADHAN KUMAR</option>
                        <option value="SHEIKH ABDULLAH" <?php echo $SHEIKH;?>>SHEIKH ABDULLAH</option>
                        <option value="RAMESH" <?php echo $RAMESH;?>>RAMESH</option>
                    </select>
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
                                            <th>Project Id</th>
                                            <th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Responsibility</th>
                                            <th>Estimate Value</th>
                                            <th>Collected Value</th>
                                            <th>Outstanding Value (QAR)</th>
                                            <th>Due Value (QAR)</th>
                                            <th>Contact Details</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql12 = "SELECT * FROM project WHERE divi='$dep_name'";
                                            if($res !=""){
                                                $sql12 .= " AND payment_responsibility='$res'";
                                            }
                                            $result12 = $conn->query($sql12);
                                            while ($row12 = $result12->fetch_assoc()) {
                                                $proid = $row12['proid'];
                                                $project_id = $row12['id'];
                                                $eid = $row12['eid'];
                                                $payment_responsibility = $row12['payment_responsibility'];
                                                $et_value = $row12['et_value'];
                                                $remark = $row12['remark'];
                                                $details = "";

                                                $sql5 = "SELECT * FROM contact_details WHERE project_id='$proid'";
                                                $result5 = $conn->query($sql5);
                                                if($result5->num_rows > 0){
                                                    while ($row5 = $result5->fetch_assoc()) {
                                                        $details .= $row5['name'].' - '.$row5['phone'].'<br>';
                                                    }
                                                }

                                                $sql4 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result4 = $conn->query($sql4);
                                                $row4 = $result4->fetch_assoc();

                                                $sql1 = "SELECT * FROM invoice WHERE pid='$proid' ORDER BY date ASC";
                                                $result1 = $conn->query($sql1);
                                                $count = 1;
                                                $amo1 = $amo2 = $pend = $tot = $total_collected = 0;
                                                while($row1 = $result1->fetch_assoc())
                                                {
                                                    $pid = $row1["pid"];

                                                    $sql2 = "SELECT * FROM project WHERE proid='$pid'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();

                                                    $invdues = $row2["invdues"];

                                                    $color = "";
                                                    if($row1["paystatus"] == 0)
                                                    {
                                                        $term = "Generated";
                                                        $recdate = $recam = $rem = "-";
                                                    }
                                                    if($row1["paystatus"] == 1)
                                                    {
                                                        $term = "Submitted";
                                                        $recdate = $recam = $rem = "-";
                                                    }
                                                    if($row1["paystatus"] == 2)
                                                    {
                                                        $term = "Recieved";
                                                        $recdate = date('d/m/Y',strtotime($row1["recdate"]));
                                                        $recam = $row1["current"];
                                                        $rem = $row1["remarks"];
                                                    }

                                                    if($recam != '-')
                                                    {
                                                        $amo2 += $recam;
                                                    }
                                                    if($row1['subdate'] !="")
                                                    {
                                                        $amo1 += $row1["demo"];
                                                    }

                                                    $sub = $row1["subdate"];
                                                    $rec = $row1["recdate"];
                                                    $newdate = date('Y-m-d',strtotime($sub.'+'.$invdues.' days'));

                                                    if($row1['recdate'] !=""){
                                                        if($row1['recdate'] >= $start_date && $row1['recdate'] <= $end_date){
                                                            $total_collected += $row1['current'];
                                                        }
                                                    }
                                    
                                                    if(($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today)))
                                                    {
                                                        if($row1["paystatus"] == 2)
                                                        {
                                                            $tot += $row1["demo"] - $row1["current"];
                                                        }
                                                        else
                                                        {
                                                            // $color = "#FF5733";
                                                            $tot += $row1["demo"];
                                                        }
                                                    }
                                                    // if($row1['subdate'] !="")
                                                    // {
                                                        if($row1["paystatus"] != 2)
                                                        {
                                                            $pend += $row1["demo"];
                                                        }
                                                        else
                                                        {
                                                            if($row1["recdate"] > $today)
                                                            {
                                                                $pend += ($row1["demo"] - $row1["current"]);
                                                            }
                                                            else
                                                            {
                                                                $pend += ($row1["demo"] - $row1["current"]);
                                                            }
                                                        }
                                                    // }
                                                }
                                                if($payment_responsibility ==""){
                                                    $payment_responsibility = "Vaishali Ladole";
                                                }
                                                if($et_value == ""){
                                                    $et_value = 0;
                                                }
                                                if($remark == ""){
                                                    $remark = "N/A";
                                                }
                                               
                                                if($pend != 0)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><center><?php echo $row2['proid'];?></center></td>
                                                            <td><center><a href="statement-main.php?id=<?php echo $eid;?>"><?php echo $row4['name'];?></a></center></td>
                                                            <td><center><?php echo $row4['cname'];?></center></td>
                                                            <td><center><?php echo $payment_responsibility;?></center></td>
                                                            <td><center><?php echo number_format($et_value, 2);?> </center></td>
                                                            <td><center><?php echo number_format($total_collected, 2);?></center></td>
                                                            <td><center><?php echo number_format($pend, 2);?></center></td>
                                                            <td><center><?php echo number_format($tot, 2);?></center></td>
                                                            <td>
                                                                <center>
                                                                        <?php echo $details;?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                        <?php echo $remark;?>
                                                                </center>
                                                            </td>
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
			location.replace("https://conservesolution.com/projectmgmttool/invoice-due1.php?id="+val);
			// location.replace("http://localhost/project/invoice-due1.php?id="+val);
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
<script>
    function setValue(val,proid){
        $.ajax({
            type: "POST",
            url: "assets/ajax/outstanding_page.php",
            data:{'val':val,'proid':proid},
			success: function(data)
            {
                console.log(data);
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
    }
    function setRemark(remark,proid){
        $.ajax({
            type: "POST",
            url: "assets/ajax/outstanding_page.php",
            data:{'remark':remark,'proid':proid},
			success: function(data)
            {
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
    }
    function get(val)
    {
        location.replace("dept-invoice-report.php?res="+val);
    }
    function set(val,proid) {
        $.ajax({
            type: "POST",
            url: "assets/ajax/set_responsibility.php",
            data:{'val':val,'proid':proid},
			success: function(data)
            {
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
    }
</script>
</body>
</html>