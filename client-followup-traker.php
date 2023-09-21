<?php

ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");

$id = $_REQUEST["id"];

$today = date('Y-m-d');
$thismonth = date('Y-m-01');
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
	<meta property=" og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>Client Followup Trakert | Project Management System</title>

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
    <?php include_once("inc/header.php"); ?>
    <!-- header end -->
    <!-- Left sidebar menu start -->
    <?php include_once("inc/sidebar.php"); ?>
    <!-- Left sidebar menu end -->

    <?php
    $sql = "SELECT * FROM dept ORDER BY name ASC";
    $result = $conn->query($sql);
    $count = 1;
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $eid = $row["id"];

        $sql2 = "SELECT * FROM project WHERE dept='$eid'";
        $result2 = $conn->query($sql2);
        while ($row2 = $result2->fetch_assoc()) {
            $pid = $row2["proid"];
            $demo = $current = 0;

            $sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
            $result3 = $conn->query($sql3);
            while ($row3 = $result3->fetch_assoc()) {
                if ($row3["paystatus"] != 2) {
                    $total += $row3["demo"];
                } else {
                    $recdate = date('Y-m-d', strtotime($row3["recdate"]));
                    if ($today < $recdate) {
                        $total += ($row3["demo"] - $row3["current"]);
                    } else {
                        $total += ($row3["demo"] - $row3["current"]);
                    }
                }
            }
        }
    }
    ?>
    <!--Main container start -->
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <div class="row r-p100">
                    <div class="col-sm-11">
                    </div>
                    <div class="col-sm-1">
                        <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
                    </div>
                </div>
            </div>
            <div class="row m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h5>Client Followup Trakert</h5>
                                </div>
                                <div class="col-sm-2">
                                    <h5 style="float: right" id="total_amt"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                                <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Department</th>
                                            <th>Outstanding Value (₹)</th>
                                            <th>Due Value (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dep_array = array('Engineering', 'Simulation & Analysis', 'Sustainability', 'Environmental', 'Acoustics', 'Laser Scanning');
                                        $array_count = count($dep_array);
                                        $over_all = 0;
                                        for ($i = 0; $i < $array_count; $i++) {
                                            $division = $dep_array[$i];
                                            $amo1 = $amo2 = $pend = $tot = 0;
                                            $sql = "SELECT * FROM project WHERE divi='$division'";
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            $Total_et_value = 0;
                                            $search_collected_value = $total = $search_invoice_value = $total_collected = $total_collected_value = $total_invoice_value = 0;
                                            $overall_invoice_value = $overall_collected_value = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $eid = $row["eid"];
                                                $pid = $row["id"];
                                                $scope = $row["scope"];
                                                $proid = $row["proid"];
                                                $total = $row["value"];
                                                $scope_type = $row['scope_type'];

                                                $sql11 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result11 = $conn->query($sql11);
                                                $row11 = $result11->fetch_assoc();

                                                $rfqid = $row11['rfqid'];

                                                $sql6 = "SELECT * FROM mod_details WHERE po_no='$pid' AND control='4' ORDER BY id DESC LIMIT 1";
                                                $result6 = $conn->query($sql6);
                                                $row6 = $result6->fetch_assoc();
                                                if ($row6["update_details"] == 1) {
                                                    $s1 = "Created";
                                                } else {
                                                    $s1 = "Edited";
                                                }

                                                $scopev = "";

                                                $sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
                                                $result1 = $conn->query($sql1);
                                                $row1 = $result1->fetch_assoc();

                                                $awarded_date = $row1['qdatec'];

                                                $sql5 = "SELECT * FROM invoice WHERE pid='$proid'";
                                                $result5 = $conn->query($sql5);
                                                $num_invoice = $result5->num_rows;

                                                $sql5 = "SELECT * FROM invoice WHERE pid='$proid'";
                                                $result5 = $conn->query($sql5);
                                                $rec_invoice = $result5->num_rows;

                                                // if($rec_invoice == 0 && $num_invoice == 0)
                                                // {
                                                // 	continue;
                                                // }



                                                $rfqid = $row1["rfqid"];

                                                if ($scope_type == 0 || $scope_type == "2") {
                                                    $sql2 = "SELECT * FROM scope WHERE eid='$eid'";
                                                    $result2 = $conn->query($sql2);
                                                    if ($result2->num_rows > 0) {
                                                        if ($result2->num_rows == 1) {
                                                            $row2 = $result2->fetch_assoc();
                                                            $s = $row2["scope"];
                                                        } else {
                                                            while ($row2 = $result2->fetch_assoc()) {
                                                                $s .= $row2["scope"] . ",";
                                                            }
                                                        }
                                                    } else {
                                                        $s = $row1['scope'];
                                                    }
                                                } else {
                                                    $scope_id = $row1['scope'];

                                                    $sql2 = "SELECT * FROM scope_list WHERE id='$scope_id'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();

                                                    $s = $row2["scope"];
                                                }
                                                
                                                // sum //
                                                $sql2 = "SELECT sum(demo) as search_invoice_value FROM invoice WHERE pid='$proid'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                $search_invoice_value = $row2['search_invoice_value'];

                                                if ($search_invoice_value == "") {
                                                    $search_invoice_value = 0;
                                                }

                                                $sql2 = "SELECT sum(current) as search_collected_value FROM invoice WHERE pid='$proid' AND recdate!=''";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                $search_collected_value = $row2['search_collected_value'];

                                                if ($search_collected_value == "") {
                                                    $search_collected_value = 0;
                                                }

                                                $sql2 = "SELECT sum(demo) as total_invoice_value FROM invoice WHERE pid='$proid'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                $total_invoice_value = $row2['total_invoice_value'];

                                                if ($total_invoice_value == "") {
                                                    $total_invoice_value = 0;
                                                }

                                                $sql2 = "SELECT sum(current) as total_collected_value FROM invoice WHERE pid='$proid' AND recdate!='' AND recdate!='0000-00-00'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                $total_collected_value = $row2['total_collected_value'];

                                                if ($total_collected_value == "") {
                                                    $total_collected_value = 0;
                                                }

                                                if ($search_invoice_value == 0 && $search_collected_value == 0) {
                                                    if ($s_date != "") {
                                                        if ($row1['qdatec'] < $s_date || $row1['qdatec'] > $e_date) {
                                                            continue;
                                                        }
                                                    }
                                                }
                                                $overall_invoice_value += $total_invoice_value;
                                                $overall_collected_value += $total_collected_value;

                                                $Total_et_value += $row['et_value'];

                                                $sql1 = "SELECT * FROM invoice WHERE pid='$proid' ORDER BY date ASC";
                                                $result1 = $conn->query($sql1);
                                                $count = 1;
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
                                               
                                            }
                                            ?>
                                                <tr>
                                                    <td>
                                                        <center><?php echo $i + 1; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><a href="client-invoice-report.php?dept=<?php echo $dep_array[$i]; ?>"><?php echo $dep_array[$i]; ?></a></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo number_format($overall_invoice_value - $overall_collected_value, 2); ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo number_format($tot, 2); ?></center>
                                                    </td>
                                                    

                                                </tr>
                                            <?php
                                                $total_amt += $overall_invoice_value - $overall_collected_value;
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
        document.getElementById('total_amt').innerHTML = "<?php echo "₹ " . number_format($total_amt, 2); ?>"
    </script>
    <script>
        function boss(val) {
            if (val != "") {
                location.replace("https://conservesolution.com/projectmgmttool/invoice-due1.php?id=" + val);
                // location.replace("http://localhost/project/invoice-due1.php?id="+val);
            }
        }
    </script>
    <script>
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