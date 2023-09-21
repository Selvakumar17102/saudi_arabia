<?php
ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");
$date = date("Y-m-d");
$month = date('m');

$dates = "0000-00-00";

$today = date('Y-m-t');
$thismonth = date('Y-m-01');

$month = $_REQUEST['month'];
$fdate = $_REQUEST['fdate'];
$ldate = $_REQUEST['ldate'];

if ($month != "") {
    $thismonth = date("Y-" . $month . '-01');
    $today = date("Y-" . $month . "-t");
} else {
    if ($fdate != "" && $ldate != "") {
        $thismonth = $fdate;
        $today = $ldate;
    }
}

if ($_POST['submit']) {
    $month = $_POST['month'];
    $fdate = $_POST['fdate'];
    $ldate = $_POST['tdate'];

    header("Location: invoice-tracker.php?month=$month&fdate=$fdate&ldate=$ldate");
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
    <meta name="description" content="Invoice Reports | Project Management System" />

    <!-- OG -->
    <meta property="og:title" content="Invoice Reports | Project Management System" />
    <meta property="og:description" content="Invoice Reports | Project Management System />
	<meta property=" og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>Invoice Tracker | Project Management System</title>

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
        .table-hover tr td {
            text-align: center;
        }

        .table-hover tr td a {
            padding: 10px;
        }

        .customized_table {
            border: 1px solid black;
        }

        .customized_table .customized_head .customized_tr {
            border: 1px solid black;
        }

        .customized_tr {
            border: 1px solid black;
        }

        .customized_td {
            border: 1px solid black;
            background: #D9E1F2;
        }

        .divi_name {
            border: 1px solid black;
            background: #FFC000;
        }

        .customized_data {
            border: 1px solid black;
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
            <div class="db-breadcrumb">
                <h4 class="breadcrumb-title">Invoice Tracker</h4>
            </div>
            <form method="POST">
                <div class="row">
                    <!-- Data tables -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                        <div class="widget-box">
                            <div class="widget-inner">
                                <div class="row m-b50">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Month Wise Search</label>
                                        <select style="height: 40px" name="month" class="form-control">
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
                                    <div class="col-sm-8">
                                        <label class="col-form-label">Custom Search</label>
                                        <div class="col-sm-12">
                                            <div class="row">

                                                <div class="col-sm-5">
                                                    <input type="date" name="fdate" class="form-control">
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="date" name="tdate" class="form-control">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="submit" class="btn" value="Submit" name="submit">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="printdiv">
                <div class="row m-t30 m-b30">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b0">
                        <div class="widget-box">
                            <div class="widget-inner">
                                <div class="row">
                                    <div class="col-sm-11">
                                        <h1>Invoice Tracker</h1>
                                    </div>
                                    <div class="col-sm-1">
                                        <button id="button" class="btn" onclick="tableToExcel('excel-table', 'W3C Excel Table')">EXCEL</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id='excel-table' style="border: 1px solid black;">
                                        <tbody>

                                            <?php
                                            $my_division = array('ENGINEERING', 'SIMULATION & ANALYSIS', 'SUSTAINABILITY', 'ACOUSTICS', 'LASER SCANNING','OIL & GAS');
                                            $count_array = count($my_division);
                                            $grand = 0;
                                            $total_invoice = 0;
                                            $total_project = $total_deputation = $total_not_submit = $total_not_submit_count = $total_submit = $total_submit_vat = $total_submit_count = $total_prepared = $total_prepared_vat = $total_prepared_count = 0;
                                            for ($k = 0; $k < $count_array; $k++) {
                                                $Project_type = array('Project', 'Deputation');
                                                $division = $my_division[$k];

                                            ?>
                                                <tr>
                                                    <td colspan="13" style="border: 1px solid black; background: #FFC000;">
                                                        <center><?php echo $division; ?></center>
                                                    </td>
                                                </tr>
                                                <?php

                                                if (($count_array) != $k) {
                                                ?>
                                                    <tr style="border: 1px solid black;">
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">S.No</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Project Type</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Project Name</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Client</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">No of Invoice Count</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Date of Preparation</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center; ">Prepared Status</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Date of submission</td>
                                                        <td colspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Submitted Status</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Invoice Value<br>SAR</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Invoice VAT Value<br>SAR</td>
                                                        <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Remarks</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black; background: #D9E1F2;">Delivered</td>
                                                        <td style="border: 1px solid black; background: #D9E1F2;">Receiving Copy</td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                $Project_total = $Deputation_total = $Project_total_vat = $Deputation_total_vat = 0;
                                                for ($j = 0; $j < count($Project_type); $j++) {
                                                    $my_project_type = $Project_type[$j];
                                                ?>

                                                    <?php
                                                    $sql = "SELECT * FROM project WHERE inv='0' AND (status='Commercially Open' OR status='Running') AND divi='$division' AND subdivi='$my_project_type' ORDER BY divi ASC";
                                                    $result = $conn->query($sql);
                                                    $count = 1;
                                                    $de = $en = $si = $su = $pro = $inv = $sub = 0;
                                                    $over_all = 0;
                                                    $my_id == "";
                                                    $num_of_rows = $result->num_rows;
                                                    while ($row = $result->fetch_assoc()) {
                                                        $c1 = $c2 = "red";
                                                        $pid = $row["proid"];
                                                        $eid = $row["eid"];
                                                        $proid = $row["id"];
                                                        $pro++;

                                                        $sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                        $result2 = $conn->query($sql2);
                                                        $row2 = $result2->fetch_assoc();

                                                        $sql3 = "SELECT * FROM invoice_traker WHERE proid='$proid' AND date  BETWEEN '$thismonth' AND '$today'";
                                                        $result3 = $conn->query($sql3);
                                                        if ($result3->num_rows > 0) {
                                                            $row3 = $result3->fetch_assoc();
                                                        } else {
                                                            $row3["invoice_count"] = 0;
                                                        }

                                                        $sql1 = "SELECT * FROM invoice WHERE pid='$pid' AND demo!='0' AND date BETWEEN '$thismonth' AND '$today'";
                                                        $result1 = $conn->query($sql1);
                                                        if ($result1->num_rows > 0) {
                                                            $num_invoice = $result1->num_rows;
                                                            while ($row1 = $result1->fetch_assoc()) {
                                                                $i = "Yes";
                                                                $s = $sd = "";
                                                                $c1 = "green";
                                                                $inv++;
                                                                $my_id = $row1['id'];

                                                                if ($row1["subdate"] != "") {
                                                                    $sub++;
                                                                    $s = "Yes";
                                                                    $c2 = "green";
                                                                    $sd = date('d-m-Y', strtotime($row1["subdate"]));
                                                                } else {
                                                                    $s = "No";
                                                                    $sd = "-";
                                                                }

                                                                if ($row1['paystatus'] == "2") {
                                                                    $pay_status = "Yes";
                                                                    $pay_c = "green";
                                                                } else {
                                                                    $pay_status = "No";
                                                                    $pay_c = "red";
                                                                }

                                                                if ($row1['invdoc'] != "") {
                                                                    $delivered = "Yes";
                                                                } else {
                                                                    $delivered = "No";
                                                                }

                                                                if ($i == "Yes" && $delivered == "Yes") {
                                                                    $total_submit_count++;
                                                                    $total_submit += $row1['demo'];
                                                                    $total_submit_vat += $row1['demo_gst'];
                                                                }

                                                                if ($i == "Yes" && $delivered == "No") {
                                                                    $total_not_submit_count++;
                                                                    $total_not_submit += $row1['demo'];
                                                                    $total_not_submit_vat += $row1['demo_gst'];
                                                                }

                                                                if ($i == "Yes" && ($s == "No" || $s == "Yes")) {
                                                                    $total_prepared_count++;
                                                                    $total_prepared += $row1['demo'];
                                                                    $total_prepared_vat += $row1['demo_gst'];
                                                                }
                                                    ?>
                                                                <tr>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php echo $count++ ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php echo $row["subdivi"] ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php echo $row2["name"] ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php echo $row2["cname"] ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php echo $row3["invoice_count"] . ':' . $num_invoice ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php echo date('d-m-Y', strtotime($row1["date"])) ?></center>
                                                                    </td>
                                                                    
                                                                 
                                                                    <td style="border: 1px solid black;background-color: #90EE90;<?php echo $c1 ?>">
                                                                        <center><?php echo $i ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center><?php if ($row1['subdate'] != "" || $row1['subdate'] != null) {
                                                                                    echo date('d-m-Y', strtotime($row1["subdate"]));
                                                                                } else {
                                                                                    echo "N/A";
                                                                                } ?></center>
                                                                    </td>
                                                                    <?php
                                                                        if($delivered=="Yes")
                                                                        {
                                                                            $color="#90EE90";
                                                                        }else{
                                                                                $color="#FF7F7F";
                                                                        }
                                                                    ?>
                                                                    <td style="border: 1px solid black; background-color:<?php echo $color; ?>"<?php echo $pay_c ?>>
                                                                        <center><?php echo $delivered ?></center>
                                                                    </td>
                                                                    <?php
                                                                        if($row1['receiving_status']=="Yes")
                                                                        {
                                                                            $color1="#90EE90";
                                                                        }else{
                                                                                $row1['receiving_status'] = "No";
                                                                                $color1="#FF7F7F";
                                                                        }
                                                                    ?>
                                                                    <td style="border: 1px solid black; background-color:<?php echo $color1; ?>"<?php echo $pay_c ?>>
                                                                        <center><?php echo $row1['receiving_status'] ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center> <?php echo number_format($row1["demo"], 2) ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;">
                                                                        <center> <?php echo number_format($row1["demo_gst"], 2) ?></center>
                                                                    </td>
                                                                    <td style="border: 1px solid black;width: 200px;">
                                                                        <center>
                                                                            <input type="text" class="form-control" value="<?php echo $row1['remrk']; ?>" onpaste="return false" onchange="update_remark(this.value, <?php echo $my_id;?>, 1)">
                                                                            <!-- <input type="text" onpaste="return false" onchange="update_remark(this.value, <?php echo $row1['id']; ?>)" value="<?php echo $row1['remrk']; ?>"> -->
                                                                        </center>
                                                                    </td>
                                                                </tr>

                                                            <?php
                                                                if ($row['subdivi'] == "Project") {
                                                                    $Project_total += $row1["demo"];
                                                                    $Project_total_vat += $row1["demo_gst"];
                                                                } else {
                                                                    $Deputation_total += $row1["demo"];
                                                                    $Deputation_total_vat += $row1["demo_gst"];
                                                                }

                                                                $over_all += $row1["demo"];
                                                                $over_all_vat += $row1["demo_gst"];
                                                                $total_project + $Project_total;
                                                                $total_project_vat  + $Project_total_vat;
                                                                $total_deputation + $Deputation_total;
                                                                $total_deputation_vat + $Deputation_total_vat;
                                                                // $grand += $over_all;
                                                                $total_invoice++;
                                                            }
                                                        } else {
                                                            $num_invoice = 0;
                                                            ?>

                                                            <tr>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php echo $count++ ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php echo $row["subdivi"] ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php echo $row2["name"] ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php echo $row2["cname"] ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php echo $row3["invoice_count"] . ':' . $num_invoice ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php echo $row1["date"] ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;background-color: #FF7F7F;<?php echo $c1 ?>">
                                                                    <center>No</center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center><?php if ($row1['subdate'] != "" || $row1['subdate'] != null) {
                                                                                echo date('d-m-Y', strtotime($row1["subdate"]));
                                                                            } else {
                                                                                echo "N/A";
                                                                            } ?></center>
                                                                </td>
                                                                <td style="border: 1px solid black;">-</td>
                                                                <td style="border: 1px solid black;">-</td>
                                                                <td style="border: 1px solid black;">
                                                                    <center> - </center>
                                                                </td>
                                                                <td style="border: 1px solid black;">
                                                                    <center> - </center>
                                                                </td>
                                                                <td style="border: 1px solid black;width: 200px;">
                                                                    <center>
                                                                        <input type="text" class="form-control" value="<?php echo $row['inv_remrk']; ?>" onpaste="return false" onchange="update_remark(this.value, <?php echo $proid;?>,2)">
                                                                        <!-- <input type="text" onpaste="return false" onchange="update_remark(this.value, <?php echo $row1['id']; ?>)" value="<?php echo $row1['remrk']; ?>"> -->
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            $total_invoice++;
                                                        }
                                                    }


                                                    if ($my_project_type == "Project") {

                                                        ?>

                                                        <tr style="background: #FFF2CC">
                                                            <td colspan="10">Project Sub Total</td>
                                                            <td>
                                                                <center>SAR <?php echo number_format($Project_total, 2) ?></center>
                                                            </td>
                                                            <td><center>SAR <?php echo number_format($Project_total_vat, 2) ?></center></td>
                                                            <td style="background: #FFF2CC"></td>
                                                        </tr>
                                                        <tr style="border: 1px solid black;">
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">S.No</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Project Type</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Project Name</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Client</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">No of Invoice Count</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Date of Preparation</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center; ">Prepared Status</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Date of submission</td>
                                                            <td colspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Submitted Status</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Invoice Value<br>SAR</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Invoice VAT<br>SAR</td>
                                                            <td rowspan="2" style="border: 1px solid black; background: #D9E1F2; text-align:center;">Remarks</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: 1px solid black; background: #D9E1F2;">Delivered</td>
                                                            <td style="border: 1px solid black; background: #D9E1F2;">Receiving Copy</td>
                                                        </tr>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <tr style="background: #FFF2CC">
                                                            <td colspan="10">Deputation Sub Total</td>
                                                            <td>
                                                                <center>SAR <?php echo number_format($Deputation_total, 2) ?></center>
                                                            </td>
                                                            <td><center>SAR <?php echo number_format($Deputation_total_vat, 2) ?></center></td>
                                                            <td style="background: #FFF2CC"></td>
                                                        </tr>
                                                <?php
                                                    }
                                                }

                                                ?>

                                                <tr style="background: #92D050">
                                                    <td colspan="10">Total</td>
                                                    <!-- <td><center>SAR <?php echo number_format($over_all, 2) ?></center></td> -->
                                                    <td>
                                                        <center>SAR <?php echo number_format($Project_total + $Deputation_total, 2) ?></center>
                                                    </td>
                                                    <td><center>SAR <?php echo number_format($Project_total_vat + $Deputation_total_vat, 2) ?></center></td>
                                                    <td style="background: #92D050"></td>
                                                </tr>


                                            <?php
                                            }

                                            ?>
                                            <tr>
                                            <tr style="background: #6AF1F4">
                                                <td colspan="10"><?php echo "Grand Total"; ?></td>
                                                <td>
                                                    <center>SAR <?php echo number_format($total_prepared, 2) ?></center>
                                                </td>
                                                <td><center>SAR <?php echo number_format($total_prepared_vat, 2) ?></center></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-inner">
                    <div class="table-responsive">
                        <table id="dataTableExample4" class="table table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2">Total</th>
                                    <th rowspan="2">Prepared</th>
                                    <th rowspan="2">Submitted</th>
                                    <th rowspan="2">Not Submitted</th>
                                    <th rowspan="2">Not Prepared</th>
                                    <th colspan="2">Prepared</th>
                                    <th colspan="2">Submitted</th>
                                    <th colspan="2">Not Submitted</th>
                                </tr>
                                <tr>
                                    <th>Value</th>
                                    <th>VAT Value</th>
                                    <th>Value</th>
                                    <th>VAT Value</th>
                                    <th>Value</th>
                                    <th>VAT Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <center><?php echo $total_invoice; ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo $total_prepared_count; ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo $total_submit_count; ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo $total_not_submit_count; ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo $total_invoice - $total_prepared_count; ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo 'SAR&nbsp' . number_format($total_prepared, 2); ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo 'SAR&nbsp' . number_format($total_prepared_vat, 2); ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo 'SAR&nbsp' . number_format($total_submit, 2); ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo 'SAR&nbsp' . number_format($total_submit_vat, 2); ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo 'SAR&nbsp' . number_format($total_not_submit, 2); ?></center>
                                    </td>
                                    <td>
                                        <center><?php echo 'SAR&nbsp' . number_format($total_not_submit_vat, 2); ?></center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-10"></div>
                <div class="col-sm-2">
                    <input type="submit" name="print" value="Print" style="color: #fff" onclick="demo('#printdiv')" class="bg-primary btn" style="width: 100%">
                </div>
            </div>
        </div>
    </main>
    <div class="ttr-overlay"></div>

    <!-- External JavaScripts -->
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

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
                [15, 50, 100, -1],
                ['15 rows', '50 rows', '100 rows', 'Show all']
            ],
            buttons: [
                'pageLength', 'excel', 'print'
            ]
        });
    </script>
    <script>
        function demo(val) {
            //document.getElementById("action").style.display = "none";
            //document.getElementById("edit").style.display = "none";
            Popup($('<div/>').append($(val).clone()).html());
        }

        function Popup(data) {
            var mywindow = window.open('', 'my div', 'height=400,width=700');
            mywindow.document.write('<style>@page{size:landscape;}</style><html><head><title></title>');
            mywindow.document.write('<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />');
            mywindow.document.write('<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/assets.css">');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/vendors/calendar/fullcalendar.css">');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/style.css">');
            mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>');
            mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">');
            mywindow.document.write('<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">');
            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');
            mywindow.print();
            return true;
        }

        // function update_remark(value, id, type) {
        //     $.ajax({
        //         type: "POST",
        //         url: "assets/ajax/remark.php",
        //         data: {
        //             'value': value,
        //             "id": id,
        //             "type": type
        //         },
        //         success: function(data) {
        //             console.log(data);
        //         }
        //     });
        // }

        function update_remark(value, id, type) {
            $.ajax({
                type: "POST",
                url: "assets/ajax/remark.php",
                data: {
                    'value': value,
                    "id": id,
                    "type": type
                },
                success: function (data) {
                    let responce = JSON.parse(data)
                    // console.log(responce.sql);
                    // if (responce.status == 'success') {
                    //     console.log(responce.sql);
                    // } else {
                        
                    // }
                }
            })
        }

    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
      
      <script type="text/javascript">
      var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>

</body>

</html>