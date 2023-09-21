<?php

ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");

$month_no = $_REQUEST['month'];
$year_no = $_REQUEST['year'];

if($month_no ==NULL){
  $month_no = date('m');
}
if($year_no ==NULL){
    $year_no = date('Y');
}
    $start_date_string = $month_no.'/01/'.$year_no;
    $start_time = strtotime($start_date_string);
    $start_date = date('Y-m-d',$start_time);

    $end_day = cal_days_in_month(CAL_GREGORIAN, $month_no, $year_no);
    
    $end_date_string = ''.$month_no.'/'.$end_day.'/'.$year_no;
    $end_time = strtotime($end_date_string);
    $end_date = date('Y-m-d',$end_time);

    $monthNum  = $month_no;
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March

    //======================Expenses Value=================================//
        $sql = "SELECT sum(debit) AS demo_debit FROM expence_invoice WHERE date BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $expence = $row['demo_debit'];
        if($expence == NULL){
            $expence = 0;
        } 
    //=======================PO Value======================================//
        $po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
        $po_result = $conn->query($po_sql);
        $po_row = $po_result->fetch_assoc();
        $po_value = $po_row['price_amount'];
        if($po_value == NULL){
            $po_value = 0;
        }
    //=======================Collection Value======================================//
        $collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
        $collection_result = $conn->query($collection_sql);
        $collection_row = $collection_result->fetch_assoc();
        $collection_value = $collection_row['current_amount'];
        if($collection_value == NULL){
            $collection_value = 0;
        } 
    //=======================Invoice Value======================================//
        $invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
        $invoice_result = $conn->query($invoice_sql);
        $invoice_row = $invoice_result->fetch_assoc();
        $invoice_value = $invoice_row['invoive_amount'];
        if($invoice_value == NULL){
            $invoice_value = 0;
        } 
    //======================ENGINEERING Expenses Value=================================//
    // $engineering_sql = "SELECT sum(amount) AS eng_amount FROM sector WHERE divi = 1 AND (date BETWEEN '$start_date' AND '$end_date')";
    $engineering_sql = "SELECT SUM(sector.amount) AS eng_amount FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='1') AND ( expence_invoice.date BETWEEN '$start_date' AND '$end_date')";
    $engineering_result = $conn->query($engineering_sql);
    $engineering_row = $engineering_result->fetch_assoc();
    $engineering_expence = $engineering_row['eng_amount'];
    $engineering_expence = number_format((float)$engineering_expence, 2, '.', '');
    if($engineering_expence == NULL){
        $engineering_expence = 0;
    }
    // echo number_format((float)$engineering_expence, 2, '.', ''); exit(); 
    //=======================ENGINEERING PO Value======================================//
    $eng_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE rfq = 'ENGINEERING' AND pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
    $eng_po_result = $conn->query($eng_po_sql);
    $eng_po_row = $eng_po_result->fetch_assoc();
    $eng_po_value = $eng_po_row['price_amount'];
    if($eng_po_value == NULL){
        $eng_po_value = 0;
    }
    //======================ENGINEERING COllections Value=================================//
    $eng_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'ENGINEERING' AND paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
    $eng_collection_result = $conn->query($eng_collection_sql);
    $eng_collection_row = $eng_collection_result->fetch_assoc();
    $eng_collection_value = $eng_collection_row['current_amount'];
    if($eng_collection_value == NULL){
        $eng_collection_value = 0;
    } 
    //======================ENGINEERING Invoice Value=================================//
    $eng_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE divi = 'ENGINEERING' AND paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
    $eng_invoice_result = $conn->query($eng_invoice_sql);
    $eng_invoice_row = $eng_invoice_result->fetch_assoc();
    $eng_invoice_value = $eng_invoice_row['invoive_amount'];
    if($eng_invoice_value == NULL){
        $eng_invoice_value = 0;
    } 
    //======================SIMULATION & ANALYSIS Expenses Value=================================//
    // $sum_sql = "SELECT sum(amount) AS eng_amount FROM sector WHERE divi = 2 AND (date BETWEEN '$start_date' AND '$end_date')";
    $sum_sql = "SELECT SUM(sector.amount) AS sim_amount FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='2') AND ( expence_invoice.date BETWEEN '$start_date' AND '$end_date')";
    $sum_result = $conn->query($sum_sql);
    $sum_row = $sum_result->fetch_assoc();
    $sum_expence = $sum_row['sim_amount'];
    $sum_expence = number_format((float)$sum_expence, 2, '.', '');
    if($sum_expence == NULL){
        $sum_expence = 0;
    }
    //=======================SIMULATION & ANALYSIS PO Value======================================//
    $sum_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE rfq = 'SIMULATION & ANALYSIS' AND pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
    $sum_po_result = $conn->query($sum_po_sql);
    $sum_po_row = $sum_po_result->fetch_assoc();
    $sum_po_value = $sum_po_row['price_amount'];
    if($sum_po_value == NULL){
        $sum_po_value = 0;
    }
    //======================SIMULATION & ANALYSIS COllections Value=================================//
    $sum_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'SIMULATION & ANALYSIS' AND paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
    $sum_collection_result = $conn->query($sum_collection_sql);
    $sum_collection_row = $sum_collection_result->fetch_assoc();
    $sum_collection_value = $sum_collection_row['current_amount'];
    if($sum_collection_value == NULL){
        $sum_collection_value = 0;
    } 
    //======================SIMULATION & ANALYSIS Invoice Value=================================//
    $sum_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE divi = 'SIMULATION & ANALYSIS' AND paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
    $sum_invoice_result = $conn->query($sum_invoice_sql);
    $sum_invoice_row = $sum_invoice_result->fetch_assoc();
    $sum_invoice_value = $sum_invoice_row['invoive_amount'];
    if($sum_invoice_value == NULL){
        $sum_invoice_value = 0;
    } 
    //======================SUSTAINABILITY Expenses Value=================================//
    // $sus_sql = "SELECT sum(amount) AS eng_amount FROM sector WHERE divi = 3 AND (date BETWEEN '$start_date' AND '$end_date')";
    $sus_sql = "SELECT SUM(sector.amount) AS eng_amount FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='3') AND ( expence_invoice.date BETWEEN '$start_date' AND '$end_date')";

    $sus_result = $conn->query($sus_sql);
    $sus_row = $sus_result->fetch_assoc();
    $sus_expence = $sus_row['eng_amount'];
    $sus_expence = number_format((float)$sus_expence, 2, '.', '');
    if($sus_expence == NULL){
        $sus_expence = 0;
    }
    //=======================SUSTAINABILITY PO Value======================================//
    $sus_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE rfq = 'SUSTAINABILITY' AND pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
    $sus_po_result = $conn->query($sus_po_sql);
    $sus_po_row = $sus_po_result->fetch_assoc();
    $sus_po_value = $sus_po_row['price_amount'];
    if($sus_po_value == NULL){
        $sus_po_value = 0;
    }
    //======================SUSTAINABILITY COllections Value=================================//
    $sus_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'SUSTAINABILITY' AND paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
    $sus_collection_result = $conn->query($sus_collection_sql);
    $sus_collection_row = $sus_collection_result->fetch_assoc();
    $sus_collection_value = $sus_collection_row['current_amount'];
    if($sus_collection_value == NULL){
        $sus_collection_value = 0;
    } 
    //======================SUSTAINABILITY Invoice Value=================================//
    $sus_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE divi = 'SUSTAINABILITY' AND paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
    $sus_invoice_result = $conn->query($sus_invoice_sql);
    $sus_invoice_row = $sus_invoice_result->fetch_assoc();
    $sus_invoice_value = $sus_invoice_row['invoive_amount'];
    if($sus_invoice_value == NULL){
        $sus_invoice_value = 0;
    } 
    //======================ACOUSTICS  Expenses Value=================================//
    // $acc_sql = "SELECT sum(amount) AS acc_expence_amount FROM sector WHERE divi = 4 AND (date BETWEEN '$start_date' AND '$end_date')";
    $acc_sql = "SELECT SUM(sector.amount) AS acc_expence_amount FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='4') AND ( expence_invoice.date BETWEEN '$start_date' AND '$end_date')";

    $acc_result = $conn->query($acc_sql);
    $acc_row = $acc_result->fetch_assoc();
    $acc_expence = $acc_row['acc_expence_amount'];
    $acc_expence = number_format((float)$acc_expence, 2, '.', '');
    if($acc_expence == NULL){
        $acc_expence = 0;
    }
    //=======================ACOUSTICS  PO Value======================================//
    $acc_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE rfq = 'ACOUSTICS' AND pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
    $acc_po_result = $conn->query($acc_po_sql);
    $acc_po_row = $acc_po_result->fetch_assoc();
    $acc_po_value = $acc_po_row['price_amount'];
    if($acc_po_value == NULL){
        $acc_po_value = 0;
    }
    //======================ACOUSTICS  COllections Value=================================//
    $acc_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'ACOUSTICS' AND paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
    $acc_collection_result = $conn->query($acc_collection_sql);
    $acc_collection_row = $acc_collection_result->fetch_assoc();
    $acc_collection_value = $acc_collection_row['current_amount'];
    if($acc_collection_value == NULL){
        $acc_collection_value = 0;
    } 
    //======================ACOUSTICS  Invoice Value=================================//
    $acc_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE divi = 'ACOUSTICS' AND paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
    $acc_invoice_result = $conn->query($acc_invoice_sql);
    $acc_invoice_row = $acc_invoice_result->fetch_assoc();
    $acc_invoice_value = $acc_invoice_row['invoive_amount'];
    if($acc_invoice_value == NULL){
        $acc_invoice_value = 0;
    }
    //======================LASER SCANNING  Expenses Value=================================//
    // $las_sql = "SELECT sum(amount) AS acc_expence_amount FROM sector WHERE divi = 5 AND (date BETWEEN '$start_date' AND '$end_date')";
    $las_sql = "SELECT SUM(sector.amount) AS acc_expence_amount FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='5') AND ( expence_invoice.date BETWEEN '$start_date' AND '$end_date')";

    $las_result = $conn->query($las_sql);
    $las_row = $las_result->fetch_assoc();
    $las_expence = $las_row['acc_expence_amount'];
    $las_expence = number_format((float)$las_expence, 2, '.', '');
    if($las_expence == NULL){
        $las_expence = 0;
    }
    //=======================LASER SCANNING  PO Value======================================//
    $las_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE rfq = 'LASER SCANNING' AND pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
    $las_po_result = $conn->query($las_po_sql);
    $las_po_row = $las_po_result->fetch_assoc();
    $las_po_value = $las_po_row['price_amount'];
    if($las_po_value == NULL){
        $las_po_value = 0;
    }
    //======================LASER SCANNING  COllections Value=================================//
    $las_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'LASER SCANNING' AND paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
    $las_collection_result = $conn->query($las_collection_sql);
    $las_collection_row = $las_collection_result->fetch_assoc();
    $las_collection_value = $las_collection_row['current_amount'];
    if($las_collection_value == NULL){
        $las_collection_value = 0;
    } 
    //======================LASER SCANNING  Invoice Value=================================//
    $las_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE divi = 'LASER SCANNING' AND paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
    $las_invoice_result = $conn->query($las_invoice_sql);
    $las_invoice_row = $las_invoice_result->fetch_assoc();
    $las_invoice_value = $las_invoice_row['invoive_amount'];
    if($las_invoice_value == NULL){
        $las_invoice_value = 0;
    }
    //======================OIL & GAS  Expenses Value=================================//
    // $las_sql = "SELECT sum(amount) AS acc_expence_amount FROM sector WHERE divi = 5 AND (date BETWEEN '$start_date' AND '$end_date')";
    $oil_sql = "SELECT SUM(sector.amount) AS acc_expence_amount FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='6') AND ( expence_invoice.date BETWEEN '$start_date' AND '$end_date')";

    $oil_result = $conn->query($oil_sql);
    $oil_row = $oil_result->fetch_assoc();
    $oil_expence = $oil_row['acc_expence_amount'];
    $oil_expence = number_format((float)$oil_expence, 2, '.', '');
    if($oil_expence == NULL){
        $oil_expence = 0;
    }
    //=======================OIL & GAS  PO Value======================================//
    $oil_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE rfq = 'OIL & GAS' AND pstatus = 'AWARDED' AND (qdatec BETWEEN '$start_date' AND '$end_date')";
    $oil_po_result = $conn->query($oil_po_sql);
    $oil_po_row = $oil_po_result->fetch_assoc();
    $oil_po_value = $oil_po_row['price_amount'];
    if($oil_po_value == NULL){
        $oil_po_value = 0;
    }
    //======================OIL & GAS COllections Value=================================//
    $oil_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'OIL & GAS' AND paystatus != 0 AND (recdate BETWEEN '$start_date' AND '$end_date')";
    $oil_collection_result = $conn->query($oil_collection_sql);
    $oil_collection_row = $oil_collection_result->fetch_assoc();
    $oil_collection_value = $oil_collection_row['current_amount'];
    if($oil_collection_value == NULL){
        $oil_collection_value = 0;
    } 
    //======================OIL & GAS  Invoice Value=================================//
    $oil_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE divi = 'OIL & GAS' AND paystatus != 0 AND (subdate BETWEEN '$start_date' AND '$end_date')";
    $oil_invoice_result = $conn->query($oil_invoice_sql);
    $oil_invoice_row = $oil_invoice_result->fetch_assoc();
    $oil_invoice_value = $oil_invoice_row['invoive_amount'];
    if($oil_invoice_value == NULL){
        $oil_invoice_value = 0;
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

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
            <!--  -->
        <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal -->
<!-- </button> -->
            
            
            <!-- Card -->
            <div class="row">
                <div class="col-sm-12" >
                    <div class="widget-box" style="border-radius:10px;background:#006eb3;color:#ffff;">
                        <div class="widget-inner">
                            <div id="columnchart_material" style="width: 100%; height: 40px;">
                                <div class=" row form-group">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-6 ttr-header-right ttr-with-seperator">
                                            <!-- <p style="font-size:27px;margin-top:-13px;"><?php echo $monthName."-".$year_no;?> Summary-Overall</p> -->
                                            <p style="font-size:27px;margin-top:-13px;color:#ffff;">Dashboard Summary</p>
                                    </div>
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="widget-box pt-1" style="border-radius:20px;height:30px;background:#fff;color:#144799;margin-top:6px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <center><p style="margin-top:-4px;"><b>Filter</b></p></center>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Filter</h5>
                            <!-- <button type="button"  data-bs-dismiss="modal" aria-label="Close">X</button> -->
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <select style="height: 40px" id="month" class="form-control">
										<option value disabled Selected>Select Month</option>
										<?php
                                            $id = date('m');
											for($i=1;$i<=12;$i++)
											{
												$selected_month="";
												if($i == $id)
												{
													$selected_month = "selected";
												}
                                                $yearrr_no = sprintf('%02d',$i);
												?>
													<option <?php echo $selected_month;?> value="<?php echo $yearrr_no; ?>"><?php echo date("F", strtotime("2020-$i-13"));?></option>
												<?php
											}
										?>
									</select>
                                </div>
                                <div class="col-6">
                                    <select style="height: 40px" id="year" class="form-control">
                                        <option value disabled Selected>Select Year</option>
                                        <?php
                                            $this_year_no = date('Y');
                                            $year_count = $this_year_no - 2022;
                                            
                                            for($i=0;$i <= $year_count; $i++){
                                            ?>
                                               <option value="<?php echo $this_year_no-$i;?>" <?php if($this_year_no-$i == $this_year_no){ echo "selected";}?> ><?php echo $this_year_no-$i;?></option> 
                                            <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                            <button type="button" class="btn btn-primary" id="filter_button" data-bs-dismiss="modal">Submit</button>
                        </div>
                        </div>
                    </div>
                    </div>
            <!--  -->
            <div class="row m-t30">
                <div class="col-sm-8">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="chart_div" style="margin-top:-40px;margin-left:-45px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="donutchart"  style =" background:transparent;margin-left:-65px;height:350px;width:450px;margin-top:-15px;" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t30">
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="over_all_report" style="width: 110%; height:400px;margin-top:-50px;margin-left:-25px;">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <p>OVERALL COMPARISON OF LAST 5 MONTHS</p> -->
                <div class="col-sm-8">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="chart_div_test" style="width: 110%; height:400px;margin-top:-50px;margin-left:-40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--======================================ENGINEERING=================================================== -->
            <!-- <div class="row m-t30">
                <div class="col-sm-12" >
                    <div class="widget-box" style="border-radius:20px;background:#006eb3;color:#ffff;">
                        <div class="widget-inner" >
                            <div id="columnchart_material" style="width: 100%; height: 30px;">
                                <div class="row">
                                    <div class=" ttr-header-right ttr-with-seperator">
                                        <p class="text-left" style="font-size:20px;margin-top:-13px;margin-right:100px;padding-left:20px;color:#ffff;"><?php echo $monthName." ".$year_no;?> Summary - Division Wise</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row m-t30">
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="expenses_vs_po_div" style="width: 110%; height:400px;margin-top:-50px;margin-left:-25px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="expenses_vs_invoice_div" style="width: 110%; height:400px;margin-top:-50px;margin-left:-25px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5" style="height:400px;">
                            <div id="expenses_vs_collections_div" style="width: 110%; height:400px;margin-top:-50px;margin-left:-25px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--======================================SIMULATION & ANALYSIS=================================================== -->
            <!-- <div class="row m-t30">
                <div class="col-sm-12" >
                    <div class="widget-box" style="border-radius:20px;">
                        <div class="widget-inner" >
                            <div id="columnchart_material" style="width: 100%; height: 30px;">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class=" ttr-header-right ttr-with-seperator">
                                        <center><p style="font-size:27px;margin-top:-13px;"><?php echo $monthName."-".$year_no;?> Summary - SIMULATION & ANALYSIS Division</p></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t30">
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="sim_expense_vs_po" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="sim_expense_vs_collection" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="sim_expense_vs_invoice" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--======================================SUSTAINABILITY=================================================== -->
            <!-- <div class="row m-t30">
                <div class="col-sm-12" >
                    <div class="widget-box" style="border-radius:20px;">
                        <div class="widget-inner" >
                            <div id="columnchart_material" style="width: 100%; height: 30px;">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class=" ttr-header-right ttr-with-seperator">
                                        <center><p style="font-size:27px;margin-top:-13px;"><?php echo $monthName."-".$year_no;?> Summary - SUSTAINABILITY Division</p></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t30">
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="sus_expense_vs_po" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="sus_expense_vs_collection" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="sus_expense_vs_invoice" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--======================================ACOUSTICS=================================================== -->
            <!-- <div class="row m-t30">
                <div class="col-sm-12" >
                    <div class="widget-box" style="border-radius:20px;">
                        <div class="widget-inner" >
                            <div id="columnchart_material" style="width: 100%; height: 30px;">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class=" ttr-header-right ttr-with-seperator">
                                        <center><p style="font-size:27px;margin-top:-13px;"><?php echo $monthName."-".$year_no;?> Summary - ACOUSTICS Division</p></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t30">
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="acc_expense_vs_po" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="acc_expense_vs_collection" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="acc_expense_vs_invoice" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--======================================LASER SCANNING=================================================== -->
            <!-- <div class="row m-t30">
                <div class="col-sm-12" >
                    <div class="widget-box" style="border-radius:20px;">
                        <div class="widget-inner" >
                            <div id="columnchart_material" style="width: 100%; height: 30px;">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class=" ttr-header-right ttr-with-seperator">
                                        <center><p style="font-size:27px;margin-top:-13px;"><?php echo $monthName."-".$year_no;?> Summary - LASER SCANNING Division</p></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-t30">
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="las_expense_vs_po" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="las_expense_vs_collection" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget-box pt-1" style="border-radius:20px;">
                        <div class="widget-inner p-5">
                            <center><div id="las_expense_vs_invoice" class="px-2" style="width: 80%; height: 300px;"></div></center>
                        </div>
                    </div>
                </div>
            </div> -->
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
    
    <!-- ============================EXP vs PO=============================== -->
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawMultSeries);

        function drawMultSeries() {
            var data = google.visualization.arrayToDataTable([
                ['Division', 'Exp', 'PO'],
                ['Eng', <?php echo $engineering_expence;?>, <?php echo $eng_po_value;?>],
                ['Sim', <?php echo $sum_expence;?>, <?php echo $sum_po_value;?>],
                ['Sus', <?php echo $sus_expence;?>, <?php echo $sus_po_value;?>],
                ['Acc', <?php echo $acc_expence;?>, <?php echo $acc_po_value;?>],
                ['Las', <?php echo $las_expence;?>, <?php echo $las_po_value;?>],
                ['O&g', <?php echo $oil_expence;?>, <?php echo $oil_po_value;?>]
            ]);

            var options = {
                title: 'EXPENSES VS PO VALUE',
                chartArea: {width: '60%'},
                colors: ['#4285f4', '#db4437'],
                hAxis: {
                title: '',
                minValue: 0
                },
                vAxis: {
                    title: 'Division Wise'
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('expenses_vs_po_div'));
            chart.draw(data, options);
            }
    </script>
    <!-- ============================EXP vs Collections=============================== -->
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawMultSeries);

        function drawMultSeries() {
            var data = google.visualization.arrayToDataTable([
                ['Division', 'Exp', 'Col'],
                ['Eng', <?php echo $engineering_expence;?>, <?php echo $eng_collection_value;?>],
                ['Sim', <?php echo $sum_expence;?>, <?php echo $sum_collection_value;?>],
                ['Sus', <?php echo $sus_expence;?>, <?php echo $sus_collection_value;?>],
                ['Acc', <?php echo $acc_expence;?>, <?php echo $acc_collection_value;?>],
                ['Las', <?php echo $las_expence;?>, <?php echo $las_collection_value;?>],
                ['O&g', <?php echo $oil_expence;?>, <?php echo $oil_collection_value;?>]
            ]);

            var options = {
                title: 'EXPENSES VS COLLECTION VALUE',
                chartArea: {width: '60%'},
                colors: ['#4285f4', '#8cd234'],
                hAxis: {
                title: '',
                minValue: 0
                },
                vAxis: {
                title: 'Division Wise'
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('expenses_vs_collections_div'));
            chart.draw(data, options);
            }
    </script>
    <!-- ============================EXP vs Invoice=============================== -->
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawMultSeries);

        function drawMultSeries() {
            var data = google.visualization.arrayToDataTable([
                ['Division', 'Exp', 'Inv'],
                ['Eng', <?php echo $engineering_expence;?>, <?php echo $eng_invoice_value;?>],
                ['Sim', <?php echo $sum_expence;?>, <?php echo $sum_invoice_value;?>],
                ['Sus', <?php echo $sus_expence;?>, <?php echo $sus_invoice_value;?>],
                ['Acc', <?php echo $acc_expence;?>, <?php echo $acc_invoice_value;?>],
                ['Las', <?php echo $las_expence;?>, <?php echo $las_invoice_value;?>],
                ['O&g', <?php echo $oil_expence;?>, <?php echo $oil_invoice_value;?>]
            ]);

            var options = {
                title: 'EXPENSES VS INVOICE VALUE',
                chartArea: {width: '60%'},
                colors: ['#4285f4', '#ff9900'],
                hAxis: {
                title: '',
                minValue: 0
                },
                vAxis: {
                title: 'Division Wise'
                }
            };
            var chart = new google.visualization.BarChart(document.getElementById('expenses_vs_invoice_div'));
            chart.draw(data, options);
            }
    </script>
    <!-- =============================================LAst 5 Months================================================== -->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Expenses', 'Po Value', 'Invoice', 'Collection'],
          <?php 
            $tie=date('d/m/Y', strtotime($date));
            $month = date("Y/m/15");
            for($i=6;$i >=1 ; $i--){
                $month_names = date('F', strtotime($month.'+'.-$i." month"));
                $month_years = date('Y', strtotime("-$i month"));
                $month_Numbers = date('m', strtotime($month.'+'.-$i." month"));

                $last_mon_short = $month_years.$month_Numbers;
                $last_month_short_name = date('M', strtotime($last_mon_short . $month_Numbers));
                
                $last_start_date_string = $month_Numbers.'/01/'.$month_years;
                $last_start_time = strtotime($last_start_date_string);
                $last_start_date = date('Y-m-d',$last_start_time);
                
                $lat_end_day = cal_days_in_month(CAL_GREGORIAN, $month_Numbers, $month_years);
    
                $last_end_date_string = ''.$month_Numbers.'/'.$lat_end_day.'/'.$month_years;
                $last_end_time = strtotime($last_end_date_string);
                $last_end_date = date('Y-m-d',$last_end_time);

                $last_sql = "SELECT sum(debit) AS demo_debit FROM expence_invoice WHERE date BETWEEN '$last_start_date' AND '$last_end_date'";
                $last_result = $conn->query($last_sql);
                $last_row = $last_result->fetch_assoc();
                $last_expence = $last_row['demo_debit'];
                if($last_expence == NULL){
                    $last_expence = 0;
                } 

                $last_po_sql = "SELECT sum(price) AS price_amount FROM enquiry WHERE pstatus = 'AWARDED' AND (qdatec BETWEEN '$last_start_date' AND '$last_end_date')";
                $last_po_result = $conn->query($last_po_sql);
                $last_po_row = $last_po_result->fetch_assoc();
                $last_po_value = $last_po_row['price_amount'];
                if($last_po_value == NULL){
                    $last_po_value = 0;
                }
                //==========Invoice Value============//
                $last_invoice_sql = "SELECT sum(demo) AS invoive_amount FROM invoice WHERE paystatus != 0 AND (subdate BETWEEN '$last_start_date' AND '$last_end_date')";
                $last_invoice_result = $conn->query($last_invoice_sql);
                $last_invoice_row = $last_invoice_result->fetch_assoc();
                $last_invoice_value = $last_invoice_row['invoive_amount'];
                if($last_invoice_value == NULL){
                    $last_invoice_value = 0;
                } 
                //=======================Collection Value======================================//
                $last_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE paystatus != 0 AND (recdate BETWEEN '$last_start_date' AND '$last_end_date')";
                $last_collection_result = $conn->query($last_collection_sql);
                $last_collection_row = $last_collection_result->fetch_assoc();
                $last_collection_value = $last_collection_row['current_amount'];
                if($last_collection_value == NULL){
                    $last_collection_value = 0;
                } 
        ?>
                    ['<?php echo $last_month_short_name."-".$month_years ?>',  <?php echo $last_expence;?>,<?php echo $last_po_value; ?>,<?php echo $last_invoice_value; ?>,<?php echo $last_collection_value; ?>],
            <?php
            }
          ?>
        ]);

        var options = {
          title : 'OVERALL COMPARISON OF LAST 6 MONTHS',
          colors: ['#4285f4', '#db4437','#ff9900','#8cd234'],  
        //   vAxis: {title: 'Cups'},
        //   hAxis: {title: 'Month'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div_test'));
        chart.draw(data, options);
      }
    </script>
    <!-- ==================================================Over all Summary ============================-->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month','exp', 'Po', 'Inv', 'Col'],
          ['<?php echo $monthName ?>',<?php echo $expence;?>,<?php echo $po_value; ?>,<?php echo $invoice_value; ?>,<?php echo $collection_value; ?>],
        ]);

        var options = {
          title : '<?php echo strtoupper($monthName)." ".$year_no;?> OVERALL SUMMARY',
          colors: ['#4285f4', '#db4437','#ff9900','#8cd234'],
          vAxis: {title: ''},
          hAxis: {title: ''},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('over_all_report'));
        chart.draw(data, options);
      }
    </script>
    <script>
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Overall','ENG','SIM','SUB','ACC','LAS','O&G'],
          <?php 
            $month = date("Y/m/15");
            for($k=6;$k >= 1; $k--){
                $pl_month_names = date('F', strtotime($month.'+'.-$k." month"));
                $pl_month_years = date('Y', strtotime("-$k month"));
                $pl_month_Numbers = date('m', strtotime($month.'+'.-$k." month"));
                $pl_mon_short = $pl_month_years.$pl_month_Numbers;
                $pl_month_short_name = date('M', strtotime($pl_mon_short . $pl_month_Numbers));

                $pl_start_date_string = $pl_month_Numbers.'/01/'.$pl_month_years;
                $pl_start_time = strtotime($pl_start_date_string);
                $pl_start_date = date('Y-m-d',$pl_start_time);

                $pl_end_day = cal_days_in_month(CAL_GREGORIAN, $pl_month_Numbers, $pl_month_years);

                $pl_end_date_string = ''.$pl_month_Numbers.'/'.$pl_end_day.'/'.$pl_month_years;
                $pl_end_time = strtotime($pl_end_date_string);
                $pl_end_date = date('Y-m-d',$pl_end_time);

                $pl_sql = "SELECT sum(debit) AS demo_debit FROM expence_invoice WHERE date BETWEEN '$pl_start_date' AND '$pl_end_date'";
                $pl_result = $conn->query($pl_sql);
                $pl_row = $pl_result->fetch_assoc();
                $pl_expence = $pl_row['demo_debit'];
                if($pl_expence == NULL){
                    $pl_expence = 0;
                } 

                $pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $pl_collection_result = $conn->query($pl_collection_sql);
                $pl_collection_row = $pl_collection_result->fetch_assoc();
                $pl_collection_value = $pl_collection_row['current_amount'];
                if($pl_collection_value == NULL){
                    $pl_collection_value = 0;
                } 
                // $pl_amount = ($pl_collection_value - $pl_expence)/$pl_collection_value;
                $pl_amount = ($pl_collection_value - $pl_expence)/$pl_collection_value;
                $pl_val = (float)sprintf("%.2f", $pl_amount); 


                // ENGINERRING 
                $eng_pl_sql = "SELECT SUM(sector.amount) AS amounts FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='1') AND ( expence_invoice.date BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $eng_pl_result = $conn->query($eng_pl_sql);

                $eng_pl_row = $eng_pl_result->fetch_assoc();
                $eng_pl_value = $eng_pl_row['amounts'];
                if($eng_pl_value == NULL){
                    $eng_pl_value = 0;
                } 

                $eng_pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'ENGINEERING' AND paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $eng_pl_collection_result = $conn->query($eng_pl_collection_sql);
                $eng_pl_collection_row = $eng_pl_collection_result->fetch_assoc();
                $eng_pl_collection_value = $eng_pl_collection_row['current_amount'];
                if($eng_pl_collection_value == NULL){
                    $eng_pl_collection_value = 0;
                } 

                $eng_pl_amount = ($eng_pl_collection_value - $eng_pl_value)/$eng_pl_collection_value;
                $eng_pl_val = (float)sprintf("%.2f", $eng_pl_amount); 

                // SIMULATION & ANALYSIS	 
                $sim_pl_sql = "SELECT SUM(sector.amount) AS amounts FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='2') AND ( expence_invoice.date BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $sim_pl_result = $conn->query($sim_pl_sql);

                $sim_pl_row = $sim_pl_result->fetch_assoc();
                $sim_pl_value = $sim_pl_row['amounts'];
                if($sim_pl_value == NULL){
                    $sim_pl_value = 0;
                } 

                $sim_pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'SIMULATION & ANALYSIS' AND paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $sim_pl_collection_result = $conn->query($sim_pl_collection_sql);
                $sim_pl_collection_row = $sim_pl_collection_result->fetch_assoc();
                $sim_pl_collection_value = $sim_pl_collection_row['current_amount'];
                if($sim_pl_collection_value == NULL){
                    $sim_pl_collection_value = 0;
                } 

                $sim_pl_amount = ($sim_pl_collection_value - $sim_pl_value)/$sim_pl_collection_value;
                $sim_pl_val = (float)sprintf("%.2f", $sim_pl_amount);

                // SUSTAINABILITY 
                $sus_pl_sql = "SELECT SUM(sector.amount) AS amounts FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='3') AND ( expence_invoice.date BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $sus_pl_result = $conn->query($sus_pl_sql);

                $sus_pl_row = $sus_pl_result->fetch_assoc();
                $sus_pl_value = $sus_pl_row['amounts'];
                if($sus_pl_value == NULL){
                    $sus_pl_value = 0;
                } 

                $sus_pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'SUSTAINABILITY' AND paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $sus_pl_collection_result = $conn->query($sus_pl_collection_sql);
                $sus_pl_collection_row = $sus_pl_collection_result->fetch_assoc();
                $sus_pl_collection_value = $sus_pl_collection_row['current_amount'];
                if($sus_pl_collection_value == NULL){
                    $sus_pl_collection_value = 0;
                } 

                $sus_pl_amount = ($sus_pl_collection_value - $sus_pl_value)/$sus_pl_collection_value;
                $sus_pl_val = (float)sprintf("%.2f", $sus_pl_amount);

                // ACOUSTICS 
                $acc_pl_sql = "SELECT SUM(sector.amount) AS amounts FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='4') AND ( expence_invoice.date BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $acc_pl_result = $conn->query($acc_pl_sql);

                $acc_pl_row = $acc_pl_result->fetch_assoc();
                $acc_pl_value = $acc_pl_row['amounts'];
                if($acc_pl_value == NULL){
                    $acc_pl_value = 0;
                } 

                $acc_pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'ACOUSTICS' AND paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $acc_pl_collection_result = $conn->query($acc_pl_collection_sql);
                $acc_pl_collection_row = $acc_pl_collection_result->fetch_assoc();
                $acc_pl_collection_value = $acc_pl_collection_row['current_amount'];
                if($acc_pl_collection_value == NULL){
                    $acc_pl_collection_value = 0;
                } 

                $acc_pl_amount = ($acc_pl_collection_value - $acc_pl_value)/$acc_pl_collection_value;
                $acc_pl_val = (float)sprintf("%.2f", $acc_pl_amount);

                // LASER SCANNING 
                $las_pl_sql = "SELECT SUM(sector.amount) AS amounts FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='5') AND ( expence_invoice.date BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $las_pl_result = $conn->query($las_pl_sql);

                $las_pl_row = $las_pl_result->fetch_assoc();
                $las_pl_value = $las_pl_row['amounts'];
                if($las_pl_value == NULL){
                    $las_pl_value = 0;
                } 

                $las_pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'LASER SCANNING' AND paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $las_pl_collection_result = $conn->query($las_pl_collection_sql);
                $las_pl_collection_row = $las_pl_collection_result->fetch_assoc();
                $las_pl_collection_value = $las_pl_collection_row['current_amount'];
                if($las_pl_collection_value == NULL){
                    $las_pl_collection_value = 0;
                } 

                $las_pl_amount = ($las_pl_collection_value - $las_pl_value)/$las_pl_collection_value;
                $las_pl_val = (float)sprintf("%.2f", $las_pl_amount);

                // OIL & GAS 
                $oil_pl_sql = "SELECT SUM(sector.amount) AS amounts FROM sector INNER JOIN expence_invoice ON sector.inv = expence_invoice.id WHERE (expence_invoice.type = '2') AND (sector.divi='6') AND ( expence_invoice.date BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $oil_pl_result = $conn->query($oil_pl_sql);

                $oil_pl_row = $oil_pl_result->fetch_assoc();
                $oil_pl_value = $oil_pl_row['amounts'];
                if($oil_pl_value == NULL){
                    $oil_pl_value = 0;
                } 

                $oil_pl_collection_sql = "SELECT sum(current) AS current_amount FROM invoice WHERE divi = 'OIL & GAS' AND paystatus != 0 AND (recdate BETWEEN '$pl_start_date' AND '$pl_end_date')";
                $oil_pl_collection_result = $conn->query($oil_pl_collection_sql);
                $oil_pl_collection_row = $oil_pl_collection_result->fetch_assoc();
                $oil_pl_collection_value = $oil_pl_collection_row['current_amount'];
                if($oil_pl_collection_value == NULL){
                    $oil_pl_collection_value = 0;
                } 

                $oil_pl_amount = ($oil_pl_collection_value - $oil_pl_value)/$oil_pl_collection_value;
                $oil_pl_val = (float)sprintf("%.2f", $oil_pl_amount);
                ?>              

            ['<?php echo $pl_month_short_name."-".$pl_month_years;?>' ,<?php echo $pl_val;?>, <?php echo $eng_pl_val;?> ,<?php echo $sim_pl_val;?>, <?php echo $sus_pl_val;?>, <?php echo $acc_pl_val;?>, <?php echo $las_pl_val;?>,<?php echo $oil_pl_val;?>],
<?php
            }
          
          ?>
        // [1,  37.8, 80.8, 41.8,  37.8, 80.8, 41.8],
        // [<?php echo $k;?>,  37.8, 80.8, 41.8,  37.8, 80.8, 41.8],
        // [2,  -30.9, 69.5, 32.4,  37.8, 80.8, 41.8],
        // [3,  25.4,   57, 25.7,  37.8, 80.8, 41.8],
        // [4,  11.7, -18.8, 10.5,  370.8, -80.8, 41.8],
        // [5,  11.9, 17.6, 10.4,  37.8, 80.8, 410.8],
        // [6,   8.8, 13.6,  7.7,  37.8, 80.8, 41.8]
        ]);

        var options = {
          title: 'LAST SIX MONTHS P & L',
          width: 850,
          height: 350,
          curveType: 'function',
          legend: { position: 'bottom' },
          backgroundColor: 'transparent'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Division', 'Collected Value'],
            ['ENG', <?php echo $eng_collection_value;?>],
            ['SIM', <?php echo $sum_collection_value;?>],
            ['SUS', <?php echo $sus_collection_value;?>],
            ['ACC', <?php echo $acc_collection_value;?>],
            ['LAS', <?php echo $las_collection_value;?>],
            ['O&G', <?php echo $oil_collection_value;?>],
        ]);

        var options = {
          title: ' COLLECTED VALUE BREAKDOWN <?php echo strtoupper($monthName)." ".$year_no;?>',
          pieHole: 0.4,
          backgroundColor: 'transparent',
          width: 500,
          height: 350,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    <!-- FIlter -->
    <script>
        $(document).ready(function(){
            $("#filter_button").click(function(){
                var month = $("#month").val();   
                var year = $("#year").val();
                window.location.href = 'dashboard.php?month='+month+'&year='+year+'';
            })
        });
    </script>
</body>

</html>