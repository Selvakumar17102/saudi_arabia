<?php

ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");

$month = date('m');
$thismonth = date('Y-m-01');
$today = date('Y-m-d');

$sql = "SELECT * FROM enquiry";
$result = $conn->query($sql);
$sub = $award =  $thisMonth = $thisMonthproject  = $thismonthpropsal = 0;
while ($row = $result->fetch_assoc()) {
    if ($row["qstatus"] == "SUBMITTED") {
        $sub++;
        //
        if ($row["sub_date"] >= $thismonth && $row["sub_date"] <= $today) {
            $thismonthpropsal++;
        }

        if ($row["pstatus"] == "AWARDED") {
            $award++;
            //  
            if ($row["qdatec"] >= $thismonth && $row["qdatec"] <= $today) {
                $thisMonthproject++;
            }
        }
    }
    //
    if ($row["enqdate"] >= $thismonth && $row["enqdate"] <= $today) {
        $thisMonth++;
    }
}

$sql1 = "SELECT * FROM project";
$result1 = $conn->query($sql1);
$co = $value = $inv = $coll = $datethisMonth = $currentthisMonth = 0;
while ($row1 = $result1->fetch_assoc()) {
    if ($row1["status"] == "Commercially Open") {
        $co++;
    }
    $value += $row1["value"];
}

$sql2 = "SELECT * FROM invoice";
$result2 = $conn->query($sql2);
while ($row2 = $result2->fetch_assoc()) {
    $inv += $row2["demo"];
    //
    if ($row2["date"] >= $thismonth && $row2["date"] <= $today) {
        $datethisMonth++;
    }
    if ($row2["paystatus"] == 2) {
        $coll += $row2["current"];
        //
        if ($row2["date"] >= $thismonth && $row2["date"] <= $today) {
            $currentthisMonth++;
        }
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
		<meta property=" og:image" content="" />
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
        .col-20 {
            flex: 0 0 20%;
            width: 20%;
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        g text {
            font-size: 13px;
        }
    </style>

</head>

<body class="ttr-pinned-sidebar">

    <!-- header start -->
    <?php include_once("inc/header.php"); ?>
    <!-- header end -->
    <!-- Left sidebar menu start -->
    <?php include_once("inc/sidebar.php"); ?>
    <!-- Left sidebar menu end -->

    <!--Main container start -->
    <main class="ttr-wrapper">
        <div class="container-fluid">

            <!-- Card -->
            <div class="row head-count">

                <div class="col-sm-4 m-b10">
                    <div class="widget-card widget-bg1">
                        <div class="wc-item">

                            <span class="wc-stats">
                                Total Enquiry : <?php echo $result->num_rows ?> <br>This Month Enquiry : <?php echo $thisMonth ?>
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4 m-b10">
                    <div class="widget-card widget-bg2">
                        <div class="wc-item">

                            <span class="wc-stats">
                                Total Proposal : <?php echo $sub ?><br>This Month Proposal : <?php echo $thismonthpropsal ?>
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-card widget-bg3">
                        <div class="wc-item">

                            <span class="wc-stats">
                                Total Projects : <?php echo $result1->num_rows ?><br>This Month Awarded : <?php echo $thisMonthproject ?>
                            </span>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="widget-card widget-bg5">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="wc-item text-center">

                                    <span class="wc-stats">
                                        PO Value : <br> SAR <?php echo number_format($value, 2); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="wc-item text-center">

                                    <span class="wc-stats">
                                        Invoiced Value : <br> SAR <?php echo number_format($inv, 2); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="wc-item text-center">

                                    <span class="wc-stats">
                                        Collection Value : <br> SAR <?php echo number_format($coll, 2); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="wc-item text-center">

                                    <span class="wc-stats">
                                        Yet to Invoice : <br> SAR <?php echo number_format(abs($inv - $value),2); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-t30">
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="columnchart_material" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="columnchart_material-m" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="proposal" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="proposal-m" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-t30">
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="project" style="width: 100%; height: 200px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="po" style="width: 100%; height: 200px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="widget-box m-t30" style="height: auto">
                                <div class="card-header ">
                                    <h5>Awarded Project - This Month</h5>
                                </div>
                                <div class="widget-inner table-responsive">
                                    <table id="dataTableExample2" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Division </th>
                                                <th>Sub Division</th>
                                                <th>Project Name</th>
                                                <th>Client Name</th>
                                                <th>PO Value(SAR)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql9 = "SELECT * FROM enquiry WHERE qdatec BETWEEN '$thismonth' AND '$today'";
                                            $result9 = $conn->query($sql9);
                                            while ($row9 = $result9->fetch_assoc()) {
                                                $eid = $row9['id'];

                                                $sql10 = "SELECT * FROM project WHERE eid='$eid' ";
                                                $result10 = $conn->query($sql10);
                                                $row10 = $result10->fetch_assoc();
                                            ?>
                                                <tr>
                                                    <td><?php echo $row10['divi']; ?></td>
                                                    <td><?php echo $row10['subdivi']; ?></td>
                                                    <td><?php echo $row9['name']; ?></td>
                                                    <td><?php echo $row9['cname']; ?></td>
                                                    <td><?php echo $row10['value']; ?></td>
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

            <div class="row m-t30">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="invoice" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div id="invoice-m" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>

            <div class="row">
                <!-- Data tables -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-b30 m-t30">
                    <div class="widget-box">
                        <div class="card-header">
                            <h4><?php echo date('F'); ?> Month Invoice Generated Report</h4>
                        </div>
                        <div class="widget-inner table-responsive">
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
                                    $sql1 = "SELECT * FROM invoice WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) AND current != 0 ORDER BY id DESC";
                                    $result1 = $conn->query($sql1);
                                    $count = 1;
                                    while ($row1 = $result1->fetch_assoc()) {
                                        $eid = $row1["rfqid"];
                                        $sql = "SELECT * FROM enquiry WHERE rfqid='$eid'";
                                        $result = $conn->query($sql);
                                        $row = $result->fetch_assoc();
                                        $name = $row["name"];
                                    ?>
                                        <tr>
                                            <td>
                                                <center><?php echo $count++ ?></center>
                                            </td>
                                            <td>
                                                <center><?php echo $row1["invid"] ?></center>
                                            </td>
                                            <td>
                                                <center><?php echo $name; ?></center>
                                            </td>
                                            <td>
                                                <center><?php echo date('d-m-Y', strtotime($row1["date"])) ?></center>
                                            </td>
                                            <td>
                                                <center>SAR <?php echo number_format($row1["current"], 2) ?></center>
                                            </td>
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
                    <div class="widget-box" style="height: auto">
                        <div class="card-header ">
                            <h4>Division Wise Invoice Report - Overall</h4>
                        </div>
                        <div class="widget-inner table-responsive">
                            <table id="dataTableExample2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Division Name</th>
                                        <th>Total PO Value</th>
                                        <th>Total Invoiced Value</th>
                                        <th>Total Received Value</th>
                                        <th>Total Outstanding Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $st = $sp = $sb = 0;
                                    $et = $ep = $eb = 0;
                                    $sat = $sap = $sab = 0;
                                    $lt = $lp = $lb = 0;
                                    $ent = $enp = $enb = 0;
                                    $act = $acp = $acb = 0;
                                    $sql5 = "SELECT * FROM project";
                                    $result5 = $conn->query($sql5);
                                    while ($row5 = $result5->fetch_assoc()) {
                                        $eid = $row5["eid"];
                                        $values = $row5["value"];

                                        $sql6 = "SELECT * FROM enquiry WHERE id='$eid'";
                                        $result6 = $conn->query($sql6);
                                        $row6 = $result6->fetch_assoc();

                                        $rfqs = $row6["rfqid"];

                                        $divi = $row6["rfq"];

                                        $sql7 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqs' AND paystatus='2'";
                                        $result7 = $conn->query($sql7);
                                        $row7 = $result7->fetch_assoc();

                                        $sql8 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqs'";
                                        $result8 = $conn->query($sql8);
                                        $row8 = $result8->fetch_assoc();


                                        if ($divi == "ENGINEERING") {
                                            $et = $et + $values;
                                            $ep = $ep + $row7["current"];
                                            $eb = $eb + $row8["current"];
                                        }
                                        if ($divi == "SIMULATION & ANALYSIS") {
                                            $sat = $sat + $values;
                                            $sap = $sap + $row7["current"];
                                            $sab = $sab + $row8["current"];
                                        }
                                        if ($divi == "SUSTAINABILITY") {
                                            $st = $st + $values;
                                            $sp = $sp + $row7["current"];
                                            $sb = $sb + $row8["current"];
                                        }
                                        if ($divi == "ENVIRONMENTAL") {
                                            $ent = $ent + $values;
                                            $enp = $enp + $row7["current"];
                                            $enb = $enb + $row8["current"];
                                        }
                                        if ($divi == "ACOUSTICS") {
                                            $act = $act + $values;
                                            $acp = $acp + $row7["current"];
                                            $acb = $acb + $row8["current"];
                                        }
                                        if ($divi == "LASER SCANNING") {
                                            $lt = $lt + $values;
                                            $lp = $lp + $row7["current"];
                                            $lb = $lb + $row8["current"];
                                        }
                                    }
                                    ?>

                                    <tr>
                                        <td> 1 </td>
                                        <td>ENGINEERING </td>
                                        <td>SAR <?php echo number_format($et, 2) ?></td>
                                        <td>SAR <?php echo number_format($eb, 2) ?></td>
                                        <td>SAR <?php echo number_format($ep, 2) ?></td>
                                        <td>SAR <?php echo number_format($eb - $ep, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 2 </td>
                                        <td>SIMULATION & ANALYSIS </td>
                                        <td>SAR <?php echo number_format($sat, 2) ?></td>
                                        <td>SAR <?php echo number_format($sab, 2) ?></td>
                                        <td>SAR <?php echo number_format($sap, 2) ?></td>
                                        <td>SAR <?php echo number_format($sab - $sap, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 3 </td>
                                        <td>SUSTAINABILITY</td>
                                        <td>SAR <?php echo number_format($st, 2) ?></td>
                                        <td>SAR <?php echo number_format($sb, 2) ?></td>
                                        <td>SAR <?php echo number_format($sp, 2) ?></td>
                                        <td>SAR <?php echo number_format($sb - $sp, 2) ?></td>
                                    </tr>

                                    <!-- <tr>
                                        <td> 4 </td>
                                        <td>ENVIRONMENTAL</td>
                                        <td>SAR <?php echo number_format($ent, 2) ?></td>
                                        <td>SAR <?php echo number_format($enb, 2) ?></td>
                                        <td>SAR <?php echo number_format($enp, 2) ?></td>
                                        <td>SAR <?php echo number_format($enb - $enp, 2) ?></td>
                                    </tr> -->
                                    <tr>
                                        <td> 4 </td>
                                        <td>ACOUSTICS</td>
                                        <td>SAR <?php echo number_format($act, 2) ?></td>
                                        <td>SAR <?php echo number_format($acb, 2) ?></td>
                                        <td>SAR <?php echo number_format($acp, 2) ?></td>
                                        <td>SAR <?php echo number_format($acb - $acp, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 5 </td>
                                        <td>LASER SCANNING </td>
                                        <td>SAR <?php echo number_format($lt, 2) ?></td>
                                        <td>SAR <?php echo number_format($lb, 2) ?></td>
                                        <td>SAR <?php echo number_format($lp, 2) ?></td>
                                        <td>SAR <?php echo number_format($lb - $lp, 2) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="widget-box m-t30" style="height: auto">
                        <div class="card-header ">
                            <h4>Division Wise Invoice Report - This Month</h4>
                        </div>
                        <div class="widget-inner table-responsive">
                            <table id="dataTableExample2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Division Name</th>
                                        <th>Total Amount</th>
                                        <th>Payment</th>
                                        <th>Pending</th>
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
                                    while ($row5 = $result5->fetch_assoc()) {
                                        $eid = $row5["eid"];
                                        $values = $row5["value"];

                                        $sql6 = "SELECT * FROM enquiry WHERE id='$eid'";
                                        $result6 = $conn->query($sql6);
                                        $row6 = $result6->fetch_assoc();

                                        $rfqs = $row6["rfqid"];

                                        $divi = $row6["division"];

                                        $sql7 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqs' AND date BETWEEN '$thismonth' AND '$today'";
                                        $result7 = $conn->query($sql7);
                                        $row7 = $result7->fetch_assoc();

                                        if ($divi == "SUSTAINABILITY") {
                                            $st = $st + $values;
                                            $sp = $sp + $row7["current"];
                                        }
                                        if ($divi == "ENGINEERING SERVICES") {
                                            $et = $et + $values;
                                            $ep = $ep + $row7["current"];
                                        }
                                        if ($divi == "SIMULATION & ANALYSIS SERVICES") {
                                            $sat = $sat + $values;
                                            $sap = $sap + $row7["current"];
                                        }
                                        if ($divi == "LASER SCANNING SERVICES") {
                                            $lt = $lt + $values;
                                            $lp = $lp + $row7["current"];
                                        }
                                        if ($divi == "ACOUSTICS") {
                                            $acc = $acc + $values;
                                            $accp = $accp + $row7["current"];
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td> 1 </td>
                                        <td>SUSTAINABILITY</td>
                                        <td>SAR <?php echo number_format($st, 2) ?></td>
                                        <td>SAR <?php echo number_format($sp, 2) ?></td>
                                        <td>SAR <?php echo number_format($st - $sp, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 2 </td>
                                        <td>ENGINEERING</td>
                                        <td>SAR <?php echo number_format($et, 2) ?></td>
                                        <td>SAR <?php echo number_format($ep, 2) ?></td>
                                        <td>SAR <?php echo number_format($et - $ep, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 3 </td>
                                        <td>SIMULATION & ANALYSIS </td>
                                        <td>SAR <?php echo number_format($sat, 2) ?></td>
                                        <td>SAR <?php echo number_format($sap, 2) ?></td>
                                        <td>SAR <?php echo number_format($sat - $sap, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 4 </td>
                                        <td>LASER SCANNING </td>
                                        <td>SAR <?php echo number_format($lt, 2) ?></td>
                                        <td>SAR <?php echo number_format($lp, 2) ?></td>
                                        <td>SAR <?php echo number_format($lt - $lp, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td> 5 </td>
                                        <td>ACOUSTICS</td>
                                        <td>SAR <?php echo number_format($acc, 2) ?></td>
                                        <td>SAR <?php echo number_format($accp, 2) ?></td>
                                        <td>SAR <?php echo number_format($acc - $accp, 2) ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- Card -->
                    </div>
                </div>
            </div>

            <!--add page v -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 m-b30 m-t30">
                    <div class="widget-box" style="height: auto">
                        <div class="card-header ">
                            <h4>Invoice Detail - This Month</h4>
                        </div>
                        <div class="widget-inner table-responsive">
                            <table id="dataTableExample2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Division </th>
                                        <th>No of Invoice</th>
                                        <th>Prepared</th>
                                        <th>Invoice Value</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $my_division = array('ENGINEERING', 'SIMULATION & ANALYSIS', 'SUSTAINABILITY', 'ACOUSTICS', 'LASER SCANNING');
                                    // $my_division = array('ACOUSTICS');
                                    $count_array = count($my_division);
                                    for ($k = 0; $k < $count_array; $k++) {
                                        $division = $my_division[$k];

                                        $sql11 = "SELECT * FROM project WHERE inv='0' AND (status='Commercially Open' OR status='Running') AND divi='$division'";
                                        $result11 = $conn->query($sql11);
                                        $count = 1;
                                        $de = $en = $si = $su = $pro = $inv = $sub = 0;
                                        $over_all = 0;
                                        $total_invoice_count = $total_num_invoice = $total_value_invoice = 0;
                                        $num_of_rows = $result11->num_rows;
                                        while ($row11 = $result11->fetch_assoc()) {
                                            $c1 = $c2 = "red";
                                            $pid = $row11["proid"];
                                            $eid = $row11["eid"];
                                            $proid = $row11["id"];
                                            $pro++;

                                            $sql13 = "SELECT * FROM invoice_traker WHERE proid='$proid' AND date  BETWEEN '$thismonth' AND '$today'";
                                            $result13 = $conn->query($sql13);
                                            if ($result13->num_rows > 0) {
                                                $row13 = $result13->fetch_assoc();
                                                $total_invoice_count += $row13['invoice_count'];
                                            } else {
                                                $row13["invoice_count"] = 0;
                                            }

                                            $sql12 = "SELECT * FROM invoice WHERE pid='$pid' AND demo!='0' AND date BETWEEN '$thismonth' AND '$today'";
                                            $result12 = $conn->query($sql12);
                                            if ($result12->num_rows > 0) {
                                                $total_preinvoice = 0;
                                                $num_invoice = $result12->num_rows;
                                                while ($row12 = $result12->fetch_assoc()){
                                                    $total_preinvoice += $row12["invoice_count"];
                                                    $total_value_invoice += $row12['demo1'];
                                                }
                                            }
                                            $total_num_invoice += $num_invoice;
                                        }
                                        ?>
                                            <tr>
                                                <td><?php echo $division;?></td>
                                                <td><?php echo $total_invoice_count;?></td>
                                                <td><?php echo $total_num_invoice;?></td>
                                                <td><?php echo $total_value_invoice;?></td>
                                            </tr>
                                        <?php
                                    ?>
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
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM enquiry";
                $result = $conn->query($sql);
                $sub = $not = $drop = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($row["qstatus"] == "SUBMITTED") {
                        $sub++;
                    } else {
                        if ($row["qstatus"] == "NOT SUBMITTED") {
                            $not++;
                        } else {
                            $drop++;
                        }
                    }
                }
                ?>['Submitted', <?php echo $sub ?>],
                ['Not Submitted', <?php echo $not ?>],
                ['Lost', <?php echo $drop ?>]
            ]);

            var options = {
                chart: {
                    title: 'Enquiry Comparison - Overall',
                },
                legend: {
                    position: "none"
                },
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM enquiry WHERE enqdate BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $sub = $not = $drop = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($row["qstatus"] == "SUBMITTED") {
                        $sub++;
                    } else {
                        if ($row["qstatus"] == "NOT SUBMITTED") {
                            $not++;
                        } else {
                            $drop++;
                        }
                    }
                }
                ?>['Submitted', <?php echo $sub ?>],
                ['Not Submitted', <?php echo $not ?>],
                ['Lost', <?php echo $drop ?>]
            ]);

            var options = {
                chart: {
                    title: 'Enquiry Comparison - This Month',
                },
                legend: {
                    position: "none"
                },
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material-m'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED'";
                $result = $conn->query($sql);
                $sub = $lost = $follow = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($row["pstatus"] == "AWARDED") {
                        $sub++;
                    } else {
                        if ($row["pstatus"] == "LOST") {
                            $lost++;
                        } else {
                            $follow++;
                        }
                    }
                }
                ?>['Awarded', <?php echo $sub ?>],
                ['In-Progress', <?php echo $follow ?>],
                ['Lost', <?php echo $lost ?>]
            ]);

            var options = {
                title: 'Proposal Comparison - Overall',
                legend: {
                    position: "none"
                },
                colors: ['#8CD234'],
            };

            var chart = new google.charts.Bar(document.getElementById('proposal'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND enqdate BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $sub = $lost = $follow = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($row["pstatus"] == "AWARDED") {
                        $sub++;
                    } else {
                        if ($row["pstatus"] == "LOST") {
                            $lost++;
                        } else {
                            $follow++;
                        }
                    }
                }
                ?>['Awarded', <?php echo $sub ?>],
                ['In-Progress', <?php echo $follow ?>],
                ['Lost', <?php echo $lost ?>]
            ]);

            var options = {
                title: 'Proposal Comparison - This Month',
                legend: {
                    position: "none"
                },
                colors: ['#8CD234'],
            };

            var chart = new google.charts.Bar(document.getElementById('proposal-m'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM project";
                $result = $conn->query($sql);
                $co = $run = $clos = $pc = $cc = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($row["status"] == "Commercially Open") {
                        $co++;
                    } elseif ($row["status"] == "Project Closed") {
                        $pc++;
                    } elseif ($row["status"] == "Commercially Closed") {
                        $cc++;
                    } else {
                        if ($row["status"] == "Closed") {
                            $clos++;
                        } else {
                            $run++;
                        }
                    }
                }
                ?>['Commercially Open', <?php echo $co ?>],
                ['Running', <?php echo $run ?>],
                ['Closed', <?php echo $clos ?>],
                ['Project Closed', <?php echo $pc ?>],
                ['Commercially Closed', <?php echo $cc ?>]

            ]);

            var options = {
                title: 'Project Comparison - Overall',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('project'));

            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php

                ?>['Collected Value', <?php echo $datethisMonth ?>],
                ['Invoice Value', <?php echo $currentthisMonth ?>]
            ]);

            var options = {
                title: 'Invoice & Collection Comparsion - Overall',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('po'));

            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM invoice";
                $result = $conn->query($sql);
                $demo = $coll = 0;
                while ($row = $result->fetch_assoc()) {
                    $demo += $row["demo"];
                    if ($row["paystatus"] == "2") {
                        $coll += $row["current"];
                    }
                }
                ?>['Invoice', <?php echo $demo ?>],
                ['Collection', <?php echo $coll ?>]
            ]);

            var options = {
                title: 'Invoice Comparison - Overall',
                colors: ['#BAB81D', '#e5e4e2'],
            };

            var chart = new google.charts.Bar(document.getElementById('invoice'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Type', 'Total'],
                <?php
                $sql = "SELECT * FROM invoice WHERE date BETWEEN '$thismonth' AND '$today'";
                $result = $conn->query($sql);
                $demo = $coll = 0;
                while ($row = $result->fetch_assoc()) {
                    $demo += $row["demo"];
                    if ($row["paystatus"] == "2") {
                        $coll += $row["current"];
                    }
                }
                ?>['Invoice', <?php echo $demo ?>],
                ['Collection', <?php echo $coll ?>]
            ]);

            var options = {
                title: 'Invoice Comparison - This Month',
                colors: ['#BAB81D', '#e5e4e2'],
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
                [15, 50, 100, -1],
                ['15 rows', '50 rows', '100 rows', 'Show all']
            ],
            buttons: [
                'pageLength', 'excel', 'print'
            ]
        });
    </script>
</body>

</html>