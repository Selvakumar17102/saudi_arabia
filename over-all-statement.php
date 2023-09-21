<?php
    ini_set('display_errors', 'off');
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
    <meta name="description" content="All Statement | Project Management System" />

    <!-- OG -->
    <meta property="og:title" content="All Statement | Project Management System" />
    <meta property="og:description" content="All Statement | Project Management System /">
	<meta property=" og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title><?php echo $name ?></title>

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
    <link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print" />
    <style>
      li{
  line-height: 1.5;
    border: 1px solid #ccc;
                    padding :5px;
}
          .dropdown-check-list {
                display: inline-block;
                }
                .filter{
                    border: 1px solid #ccc;
                    padding :5px;
                    width:90px;
                }
                #list1 {
                    margin-top : -50px;
                    position: absolute;
                    left: 0px;
                    top: 0px;
                    z-index: 1;
                    background-color:#ffff;
                }
                .dropdown-check-list .anchor {
                z-index: 1;
                position: relative;
                cursor: pointer;
                display: inline-block;
                padding: 5px 75px 5px 85px;
                border: 1px solid #ccc;
                }

                .dropdown-check-list .anchor:after {
                   
                position: absolute;
                content: "";
                border-left: 2px solid black;
                border-top: 2px solid black;
                padding: 5px;
                right: 10px;
                top: 20%;
                -moz-transform: rotate(-135deg);
                -ms-transform: rotate(-135deg);
                -o-transform: rotate(-135deg);
                -webkit-transform: rotate(-135deg);
                transform: rotate(-135deg);
                }

                .dropdown-check-list .anchor:active:after {
                right: 8px;
                top: 21%;
                }

                .dropdown-check-list ul.items { 
                padding: 2px;
                width:348px;
                display: none;
                margin: 0;
                border: 1px solid #ccc;
                border-top: 1px solid #ccc;
                }

                .dropdown-check-list ul.items li {
                list-style: none;
                }

                .dropdown-check-list.visible .anchor {
                color: #0094ff;
                }

                .dropdown-check-list.visible .items {
                display: block;
                }
                #filter_div{
                    display:none;
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
                <?php  $id = urldecode($_REQUEST["id"]);  ?>
    <!--Main container start -->
   
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <div class="row r-p100">
                    <div class="col-sm-11">
                        <h4 class="breadcrumb-title">Statements</h4>
                    </div>
                    <div class="col-sm-1">
                        <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
                    </div>
                </div>
            </div>
            <!-- <div id="printdiv"> -->
            <div class="row" id="printdiv">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card m-b30 p-t30" >
                    <?php
                    // echo $id; exit();
                    ?>
                        <!-- hidden input for $control && $_POST[''] -->
                        <input type="hidden" name="ids" id="ids" value="<?php echo $id;?>">
                        
                        <input type="hidden" name="control" id="control" value="<?php echo $control;?>">
                        <input type="hidden" name="rowside" id="rowside" value="<?php echo $rowside["id"];?>">
                    <?php
                            // $id = UCC-UrbaCon Trading & Contracting WLL;
                            $img_sql = "SELECT * FROM enquiry WHERE cname='$id' AND pstatus='AWARDED'";
                            $img_result = $conn->query($img_sql);
                            $loop = 1;
                            while ($img_row = $img_result->fetch_assoc()){
                                $img_eid    = $img_row['id']; 
                                $img_rfqid    = $img_row['rfqid']; 
                                $img_sql5 = "SELECT * FROM project WHERE eid='$img_eid'";
                                $img_result5 = $conn->query($img_sql5);
                                $img_row5 = $img_result5->fetch_assoc();
                              $img_logo = $img_row5['logo']; 
                               
                              $division = $img_row5['divi'];
                                    
                                if($img_row5['status'] == "Commercially Closed"){
                                    continue;
                                }
                                if ($mid == "") {
                                    $today = date('Y-m-d');
                                    $thismonth = date('Y-m-01');
                                    $monthName = "For The Month of - " . date("F Y");
                                } else {
                                    if ($mid < 10) {
                                        $mid = "0" . $mid;
                                    }
                                    $thismonth = date('Y-' . $mid . '-01');
                                    $today = date("Y-m-t", strtotime($thismonth));
                                    $monthName = "For The Month of - " . date('F Y', mktime(0, 0, 0, $mid, 10));
                                }

                                if ($fdate != "" && $tdate != "") {
                                    $today = $tdate;
                                    $thismonth = $fdate;
                                    $monthName = "From " . date('d-m-Y', strtotime($fdate)) . " To " . date('d-m-Y', strtotime($tdate));
                                }

                                $f_sql12 = "SELECT * FROM invoice WHERE rfqid='$img_rfqid' AND date<='$today' AND po!='' ORDER BY date ASC";
                                $f_result12 = $conn->query($f_sql12);
                                if ($f_result12->num_rows > 0) {
                                    if($loop==1 && $loop++){
                                  
                            ?>     
                            <h4 class="breadcrumb-title" style="text-align: center;color: #214597;font-size: 30px;font-weight: bold;">Statements of Accounts</h4>
                            <div class="row m-b30 p-b30">
                                <div class="col-lg-6">
                                    <img class="ttr-logo-mobile" alt="" style="padding-left: 20px;" src="assets/images/conserve-logo.png" width="200">
                                </div>
                                <div class="col-lg-6">
                                    <img class="ttr-logo-mobile" alt="" style="padding-right: 20px;float: right;" src="<?php echo $img_logo;?>" width="200">
                                </div>
                            </div>
                           <?php   
                                }
                           }
                        }?>
                            <div class="row drop">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                        <div id="list1" class="dropdown-check-list" tabindex="100">
                                            <span class="selectpicker anchor" id="arrow">Select Project</span><button class="filter" id ="filter_project">Filter</button>
                                            <ul class="items" id="ul_items">
                                            <?php 
                                                $filter_sql = "SELECT * FROM enquiry WHERE cname='$id' AND pstatus='AWARDED'";
                                                $filter_result = $conn->query($filter_sql);
                                                    while ($filter_row = $filter_result->fetch_assoc()) { 
                                                        $i=+1;
                                                        $s              = "";
                                                        $f_name         = $filter_row['name'];
                                                        $f_eid          = $filter_row['id'];
                                                        $f_rfqid        = $filter_row["rfqid"];
                                                        $f_scope_type   = $filter_row['scope_type'];
                                                        $f_new_scope    = $filter_row['scope'];
                                                        $f_division     = $filter_row['division'];

                                                        $fdate = $_REQUEST["fdate"];
                                                        $tdate = $_REQUEST["tdate"];

                                                        $f_sql5 = "SELECT * FROM project WHERE eid='$f_eid'";
                                                        $f_result5 = $conn->query($f_sql5);
                                                        $f_row5 = $f_result5->fetch_assoc();
                                    
                                                        $division = $f_row5['divi'];
                                                        $f_proid = $f_row5['proid'];
                                                        if($f_row5['status'] == "Commercially Closed"){
                                                            continue;
                                                        }
                                    
                                                        $logo = $f_row5['logo'];
                                    
                                                        if ($mid == "") {
                                                            $today = date('Y-m-d');
                                                            $thismonth = date('Y-m-01');
                                                            $monthName = "For The Month of - " . date("F Y");
                                                        } else {
                                                            if ($mid < 10) {
                                                                $mid = "0" . $mid;
                                                            }
                                    
                                                            $thismonth = date('Y-' . $mid . '-01');
                                                            $today = date("Y-m-t", strtotime($thismonth));
                                                            $monthName = "For The Month of - " . date('F Y', mktime(0, 0, 0, $mid, 10));
                                                        }
                                    
                                                        if ($fdate != "" && $tdate != "") {
                                                            $today = $tdate;
                                                            $thismonth = $fdate;
                                                            $monthName = "From " . date('d-m-Y', strtotime($fdate)) . " To " . date('d-m-Y', strtotime($tdate));
                                                        }

                                                        $f_sql12 = "SELECT * FROM invoice WHERE rfqid='$f_rfqid' AND date<='$today' AND po!='' ORDER BY date ASC";
                                                        $f_result12 = $conn->query($f_sql12);
                                                        if ($f_result12->num_rows > 0) {

                                            ?>
                                                <li><input type="checkbox" id="product_lists<?php echo $i; ?>" name= "product_lists[]" value="<?php echo $filter_row['id'];?>" style="margin-left:10px;"><lable for="product_lists<?php echo $i; ?>"  style="margin-left:10px;"><?php echo $filter_row['name'];?><?php echo $f_proid;?></lable></li>
                                                <input type="hidden" id="all_products_id" name = "all_products_id" value="<?php echo $filter_row['id'];?>">
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                </div>
                            </div> 
                            <div id="filter_div"></div>
                <div id="normal_div"> 
                <?php
                // session_start();
                // $_SESSION['soa_eid'] = $id;
                $sql = "SELECT * FROM enquiry WHERE cname='$id' AND pstatus='AWARDED'";
                $result = $conn->query($sql);
                $loop = 1;
                $num_statements = 0;
                $over_all_amo1 = $vat_over_all_amo1 = $over_all_amo2 = $vat_over_all_amo2 = $over_all_pend = $vat_over_all_pend= $over_all_tot = $vat_over_all_tot= $table_count = 0;
                while ($row = $result->fetch_assoc()) { 
                    $s = "";
                    $rfqid = $row["rfqid"];
                    $name = $row["name"];
                    $eid = $row["id"];
                    $scope_type = $row['scope_type'];
                    $new_scope = $row['scope'];
                    $division = $row['division'];

                    $fdate = $_REQUEST["fdate"];
                    $tdate = $_REQUEST["tdate"];

                    $sql5 = "SELECT * FROM project WHERE eid='$eid'";
                    $result5 = $conn->query($sql5);
                    $row5 = $result5->fetch_assoc();

                    $division = $row5['divi'];

                    if($row5['status'] == "Commercially Closed"){
                        continue;
                    }

                    $logo = $row5['logo'];

                    if ($mid == "") {
                        $today = date('Y-m-d');
                        $thismonth = date('Y-m-01');
                        $monthName = "For The Month of - " . date("F Y");
                    } else {
                        if ($mid < 10) {
                            $mid = "0" . $mid;
                        }

                        $thismonth = date('Y-' . $mid . '-01');
                        $today = date("Y-m-t", strtotime($thismonth));
                        $monthName = "For The Month of - " . date('F Y', mktime(0, 0, 0, $mid, 10));
                    }

                    if ($fdate != "" && $tdate != "") {
                        $today = $tdate;
                        $thismonth = $fdate;
                        $monthName = "From " . date('d-m-Y', strtotime($fdate)) . " To " . date('d-m-Y', strtotime($tdate));
                    }

                    $sql12 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND date<='$today' AND po!='' ORDER BY date ASC";
                    $result12 = $conn->query($sql12);
                    if ($result12->num_rows > 0) {
                        $num_statements++;

                        $sql1 = "SELECT * FROM project WHERE eid='$eid'";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();

                        $proid = $row1["proid"];
                        $pterms = $row1["pterms"];
                        $inv = $row1["invdues"];

                        $scope_id = $row["scope"];
                        $scope_type = $row['scope_type'];

                        if ($scope_type == 0) {
                            $sql3 = "SELECT * FROM scope WHERE eid='$eid'";
                            $result3 = $conn->query($sql3);
                            if ($result3->num_rows > 0) {
                                if ($result3->num_rows == 1) {
                                    $row3 = $result3->fetch_assoc();
                                    $scope = $row3["scope"];
                                } else {
                                    while ($row3 = $result3->fetch_assoc()) {
                                        $scope .= $row3["scope"] . ",";
                                    }
                                }
                            } else {
                                $scope = $row["scope"];
                            }
                        } else {
                            $sql3 = "SELECT * FROM scope_list WHERE id='$scope_id'";
                            $result3 = $conn->query($sql3);
                            if ($result3->num_rows > 0) {
                                $row3 = $result3->fetch_assoc();
                                $scope = $row3["scope"];
                            } else {
                                $scope = $row["scope"];
                            }
                        }

                        $sql2 = "SELECT sum(current) as current FROM invoice WHERE rfqid='$rfqid'";
                        $result2 = $conn->query($sql2);
                        $row2 = $result2->fetch_assoc();

                        $mid = $_REQUEST["mid"];
                ?>

                                   
                                    <div class="row m-b30 p-b30">
                                        <div class="col-lg-6">
                                            <h5 style="padding-left: 20px;">Project Name : <?php echo $name ?></h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 style="padding-right: 20px;text-align: right;">Project ID : <?php echo $proid ?></h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 style="margin-left: 20px;">Scope : <?php echo $scope ?></h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h5 style="float: right;margin-right: 10px">Division : <?php echo $division ?></h5>
                                        </div>
                                    </div>
                                    <div class="card-content m-b5 m-t5">
                                        
                                        <div class="table-responsive">
                                            <table id="dataTableExample<?php echo $table_count++; ?>" class="table table-striped" style="border:0px solid black;">
                                                <thead>
                                                    <tr style="border-bottom: 1px solid #000;">
                                                        <th rowspan="2">S.NO</th>
                                                        <th rowspan="2">PO No</th>
                                                        <th rowspan="2">Invoice No</th>
                                                        <th rowspan="2" style="color: #C54800">Invoice Prepared Date</th>
                                                        <th rowspan="2">Invoice Submitted Date</th>
                                                        <th>Invoiced Amount (SAR)</th>
                                                        <?php
                                                        if ($pterms == 2) {
                                                        ?>
                                                            <th rowspan="2">Payment For The Month Of</th>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <th rowspan="2">Payment Terms</th>
                                                        <?php
                                                        }
                                                        ?>
                                                        <th rowspan="2">Received Date</th>
                                                        <th>Received Amount (SAR)</th>
                                                        <th rowspan="2">Remarks</th>
                                                        <?php
                                                       
                                                        if ($rowside["id"] != 2) {
                                                        ?>
                                                            <?php
                                                            if ($control == "1"  || $control == "3") {
                                                            ?>
                                                                <th class="hide" rowspan="2">Action</th>
                                                            <?php
                                                            }
                                                            ?>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                           <table>
                                                                <tr>
                                                                    <th style="border:none;width:100%;">&nbspValue</th>
                                                                    <th style="border:none;">VAT&nbspValue</th>
                                                                    <!-- <th style="border:none;">TDS&nbspValue</th> -->
                                                                </tr>
                                                           </table>
                                                        </th>
                                                        <th>
                                                           <table>
                                                            <tr>
                                                            <th style="border:none;">&nbspValue</th>
                                                                    <th style="border:none;">VAT&nbspValue</th>
                                                                    <!-- <th style="border:none;">TDS&nbspValue</th> -->
                                                            </tr>
                                                           </table>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                     $rfqid; 
                                                    $sql1 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND date<='$today' AND po!='' ORDER BY date ASC"; 
                                                    $result1 = $conn->query($sql1);
                                                    $count = 1;
                                                    $amo1 = $vat_amo1 = $amo2 = $vat_amo2 = $pend = $vat_pend = $tot = $vat_tot = $gst_amo1 = $gst_amo2 = $gst_pend = $gst_tot = 0; /*every thing ok */
                                                    while ($row1 = $result1->fetch_assoc()) {
                                                        $pid = $row1["pid"];
                                                        $rem = $row1["remarks"];

                                                        $sql2 = "SELECT * FROM project WHERE proid='$pid'";
                                                        $result2 = $conn->query($sql2);
                                                        $row2 = $result2->fetch_assoc();

                                                        $invdues = $row2["invdues"];

                                                        $color = "";
                                                        if ($row1["paystatus"] == 0) {
                                                            $term = "Generated";
                                                            $recdate = $recam = "-";
                                                        }
                                                        if ($row1["paystatus"] == 1) {
                                                            $term = "Submitted";
                                                            $recdate = $recam = "-";
                                                        }
                                                        if ($row1["paystatus"] == 2) {
                                                            $term = "Recieved";
                                                            $recdate = date('d/m/Y', strtotime($row1["recdate"]));
                                                            $recam = $row1["current"];
                                                            $vat_recam = $row1["current_gst"];
                                                        }

                                                        if ($recam != '-') {
                                                            $amo2 += $recam;
                                                            $vat_amo2 += $vat_recam;
                                                            $over_all_amo2 += $recam;
                                                            $vat_over_all_amo2 += $vat_recam;
                                                        }
                                                        $amo1 += $row1["demo"];
                                                        $vat_amo1 += $row1["demo_gst"];

                                                        $over_all_amo1 += $row1["demo"];
                                                        $vat_over_all_amo1 += $row1["demo_gst"];

                                                        $sub = $row1["subdate"];
                                                        $rec = $row1["recdate"];
                                                        $newdate = date('Y-m-d', strtotime($sub . '+' . $invdues . ' days'));

                                                        if (($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today))) {
                                                            if ($row1["paystatus"] == 2) {
                                                                $tot += $row1["demo"] - $row1["current"];
                                                                $vat_tot += $row1["demo_gst"] - $row1["current_gst"];

                                                                $over_all_tot += $row1["demo"] - $row1["current"];
                                                                $vat_over_all_tot += $row1["demo_gst"] - $row1["current_gst"];
                                                            } else {
                                                                // $color = "#FF5733";
                                                                $tot += $row1["demo"];
                                                                $vat_tot += $row1["demo_gst"];
                                                                $over_all_tot += $row1['demo'];
                                                                $vat_over_all_tot += $row1['demo_gst'];
                                                            }
                                                        }
                                                        if ($row1['subdate'] != "") {
                                                            if ($row1["paystatus"] != 2) {
                                                                $pend += $row1["demo"];
                                                                $vat_pend += $row1["demo_gst"];

                                                                $over_all_pend += $row1['demo'];
                                                                $vat_over_all_pend += $row1['demo_gst'];
                                                            } else {
                                                                if ($row1["recdate"] > $today) {
                                                                    $pend += ($row1["demo"] - $row1["current"]);
                                                                    $vat_pend += ($row1["demo_gst"] - $row1["current_gst"]);

                                                                    $over_all_pend += ($row1["demo"] - $row1["current"]);
                                                                    $vat_over_all_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                                } else {
                                                                    $vat_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                                    $over_all_pend += ($row1["demo"] - $row1["current"]);
                                                                    $vat_over_all_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                        <tr style="border-bottom: 1px solid #000;">
                                                            <td>
                                                                <center><?php echo $count++ ?></center>
                                                            </td>
                                                            <td>
                                                                <center><?php echo $row1["po"] ?></center>
                                                            </td>
                                                            <td>
                                                                <center><?php echo $row1["invid"] ?></center>
                                                            </td>
                                                            <td>
                                                                <center><?php echo date('d/m/Y', strtotime($row1["date"])) ?></center>
                                                            </td>
                                                            <td style="background-color: <?php echo $color ?>">
                                                                <center>
                                                                    <?php
                                                                    if ($row1['subdate'] != "") {
                                                                        echo date('d/m/Y', strtotime($row1["subdate"]));
                                                                    } else {
                                                                        echo "-";
                                                                    }
                                                                    ?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <table style="margin-top:-8px;">
                                                                    <tr>
                                                                        <td style="border:none;">SAR&nbsp<?php echo number_format($row1["demo"],2) ?></td>
                                                                        <td style="border:none;">SAR&nbsp<?php echo number_format($row1["demo_gst"],2) ?></td>
                                                                        <!-- <td style="border:none;">SAR <?php echo number_format($row1["demo_tds"],2) ?></td> -->
                                                                    </tr>
                                                                </table>
                                                                <center></center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <?php
                                                                    if ($pterms == 1) {
                                                                        echo $row1["percent"] . "%";
                                                                    } else {
                                                                        echo $row1["month"];
                                                                    }
                                                                    ?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center><?php echo $recdate ?><center>
                                                            </td>
                                                            <td>
                                                                <!-- <center><?php echo number_format($recam, 2); ?></center>  ======with out GST and TDS======= -->
                                                                <table style="margin-top:-8px;">
                                                                    <tr>
                                                                        <td style="border:none;"><center>SAR&nbsp<?php $current_row1 = $row1["current"]; if($current_row1 == " "){$current_row1 = 0;} echo number_format($current_row1,2) ?><center></td>
                                                                        <td style="border:none;"><center>SAR&nbsp<?php echo number_format($row1["current_gst"],2) ?><center></td>
                                                                        <!-- <td style="border:none;"><center>₹<?php echo number_format($row1["current_tds"],2) ?><center></td> -->
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <center><?php echo $rem ?></center>
                                                            </td>
                                                            <?php
                                                            if ($rowside["id"] != 2) {
                                                            ?>
                                                                <?php
                                                                if ($control == "1"  || $control == "3") {
                                                                ?>
                                                                    <td class="hide">
                                                                        <center><a href="edit-entry.php?id=<?php echo $row1["id"] . "&enq=" . $id ?>" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a></center>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                    ?><?php
                                                                }
                                                                    ?>
                                                        </tr>

                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <table class="table table-striped" style="border:0px solid black;">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Total Invoiced Amount</th>
                                                        <th colspan="2">Total Received Amount</th>
                                                        <th colspan="2">Total Outstanding Amount</th>
                                                        <th colspan="2">Total Due Amount</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Value</th>
                                                        <th>VAT Value</th>
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
                                                        <td><center>SAR <?php echo number_format($amo1, 2) ?></center></td>
                                                        <td><center>SAR <?php echo number_format($vat_amo1, 2) ?></center></td>

                                                        <td><center>SAR <?php echo number_format($amo2, 2) ?></center></td>
                                                        <td><center>SAR <?php echo number_format($vat_amo2, 2) ?></center></td>
                                                        
                                                        <td><center>SAR <?php echo number_format($pend, 2) ?></center></td>   
                                                        <td><center>SAR <?php echo number_format($vat_pend, 2) ?></center></td>

                                                        <td><center>SAR <?php echo number_format($tot, 2) ?></center></td>
                                                        <td><center>SAR <?php echo number_format($vat_tot, 2) ?></center></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
               
                
                <?php
                if ($num_statements > 0) {
                ?>
                <div id="invoice_table" style="padding-top:60px;">
                    <table class="table table-striped"  style="border:0px solid black; ">
                        <thead>
                            <tr>
                                <th colspan="2"><center>Over All Invoiced</center></th>
                                <th colspan="2"><center>Over All Received</center></th>
                                <th colspan="2"><center>Over All Outstanding</center></th>
                                <th colspan="2"><center>Over All Due Amount</center></th>
                            </tr>
                            <tr>
                                <th>Value</th>
                                <th>VAT Value</th>
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
                                <td><center>SAR <?php echo number_format($over_all_amo1, 2) ?></center></td>
                                <td><center>SAR <?php echo number_format($vat_over_all_amo1, 2) ?></center></td>

                                <td><center>SAR <?php echo number_format($over_all_amo2, 2) ?></center></td>
                                <td><center>SAR <?php echo number_format($vat_over_all_amo2, 2) ?></center></td>
                                
                                <td><center>SAR <?php echo number_format($over_all_pend, 2) ?></center></td> 
                                <td><center>SAR <?php echo number_format($vat_over_all_pend, 2) ?></center></td>
                                   
                                <td><center>SAR <?php echo number_format($over_all_tot, 2) ?></center></td>
                                <td><center>SAR <?php echo number_format($vat_over_all_tot, 2) ?></center></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="row mt-5 " id="invoice_table">
                        <div class="col-sm-11">
                        </div>
                        <div class="col-sm-1">
                            <!-- <input type="submit" name="print" value="Print" style="color: #fff" onclick="demo('#printdiv')" class="bg-primary btn"> -->
                            <a href="print-over-all-stmt.php?id=<?php echo $id;?>"><button class="btn">Print</button></a>
                        </div>
                    </div>
                    <?php
                    } else {
                    ?>
                    <div class="row" id="invoice_table">
                        <div class="col-sm-12">
                            <center>
                                <p style="font-size: 24px;font-weight: 600;color: red">No Invoice available!</p>
                            </center>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                     </div> 
                <!-- normal div -->
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
        // Start of jquery datatable
        for (let index = 0; index < <?php echo $table_count; ?>; index++) {
            $('#dataTableExample' + index).DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [50, 150, 200, -1],
                    ['50 rows', '150 rows', '200 rows', 'Show all']
                ],
                buttons: [
                    'pageLength', 'excel'
                ]
            });
        }
    </script>
    <script>
        function boss(val) {
            if (val != "") {
                location.replace("statement-main.php?id=<?php echo $id ?>&mid=" + val);
            }
        }

        function search() {
            var fdate = document.getElementById('fdate').value;
            var tdate = document.getElementById('tdate').value;

            if (fdate == "") {
                $("#fdate").css("border", "1px solid red");
            } else {
                if (tdate == "") {
                    $("#tdate").css("border", "1px solid red");
                } else {
                    location.replace("statement-main.php?mid=<?php echo $mid ?>&fdate=" + fdate + "&tdate=" + tdate);
                }
            }
        }
    </script>
    <script>
        function demo(val) {
            //document.getElementById("action").style.display = "none";
            //document.getElementById("edit").style.display = "none";
 document.getElementById("list1").style.display = "none";
            Popup($('<div/>').append($(val).clone()).html());
               document.getElementById("list1").style.display = "block";
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
    </script>
    <!-- Filter Drop Down -->
    <script>
         var checkList = document.getElementById('list1');
            checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
            if (checkList.classList.contains('visible'))
                checkList.classList.remove('visible');
            else
                checkList.classList.add('visible');
            }
    </script>
    <script>
        $(document).ready(function(){  
            // var session_product = document.getElementById("session_product").value;
            // alert(session_product);
            // if(session_product == ""){
            //     document.getElementById('normal_div').style.display="block";  
            //     document.getElementById('filter_div').style.display="none";
            // }
            // else{
            //     document.getElementById('normal_div').style.display="none";
            //     document.getElementById('filter_div').style.display="block"; 
            // }
            // $.ajax({
            //         type: "POST",
            //         url: "assets/ajax/filter_product.php",
            //         data:{'session_product':session_product},

            //         success: function(data)
            //         {
            //             $("#filter_div").html(data)
            //         }
            //     });                    
            




            $('#filter_project').click(function(){ 
                

                var myButtonClasses = document.getElementById("list1").classList;
                        if (myButtonClasses.contains("visible")) {
                        myButtonClasses.remove("visible");
                        }
                        
                var count_checked = $("[name='product_lists[]']:checked").length; // count the checked rows rowside control
                var rowside = $("#rowside").val();
                var control = $("#control").val();
                var ids = $("#ids").val();
                
                    if(count_checked == 0) 
                    {
                        document.getElementById('normal_div').style.display="block";  
                        document.getElementById('filter_div').style.display="none";
                    }
                    else
                    {
                        document.getElementById('normal_div').style.display="none";
                        document.getElementById('filter_div').style.display="block"; 
                            var myCheckboxes = new Array();
                                $("input:checked").each(function() {
                                    myCheckboxes.push($(this).val());
                                });
                                $.ajax({
                                    type: "POST",
                                    url: "assets/ajax/filter_product.php",
                                    data:{'products':myCheckboxes, 'rowside':rowside, 'control':control, 'ids':ids},

                                    success: function(data)
                                    {
                                        $("#filter_div").html(data)
                                    }
                                });                      
                    }
            });
        });
    </script>
</body>
</html>
