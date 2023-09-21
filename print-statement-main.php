<?php
ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");

$id = $_REQUEST["id"];

$sql = "SELECT * FROM enquiry WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$rfqid = $row["rfqid"];
$name = $row["name"];
$eid = $row["id"];

$sql1 = "SELECT * FROM project WHERE eid='$eid'";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

$proid = $row1["proid"];
$pterms = $row1["pterms"];
$logo = $row1["logo"];
$inv = $row1["invdues"];
$divi = $row1["divi"];
$eid = $row1["eid"];

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
$sql2 = "SELECT sum(current) as current,total FROM invoice WHERE rfqid='$rfqid'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$mid = $_REQUEST["mid"];

$fdate = $_REQUEST["fdate"];
$tdate = $_REQUEST["tdate"];

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
// echo $thismonth;
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
	<meta property="og:description" content="All Statement | Project Management System" />
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
        table, th, td, tr{
            border: 1px solid #000;
        }
        .tbl_exporttable_to_xls{
            display:none;
        }
        /* @media print {
            body * {
                visibility: hidden;
            }
            #DivIdToPrint{
                visibility: visible;
            }
            #DivIdToPrint {
                position: absolute;
                left: 0;
                top: 0;
            }
        } */
        @media print{
            /* table {border-collapse:collapse;} */
            table, td, th , tr{  border: 1px solid #000;}
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
				<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">Statements</h4>
					</div>
					<div class="col-sm-1">
                        <?php $print_id = $_REQUEST["id"];?>
						<!-- <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a> -->
                        <a href="statement-main.php?id=<?php echo $print_id;?>" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>
            <div class="row" id="DivIdToPrint" >  
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                        <!-- <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p> -->
                        <div class="card m-b30 p-t30" >
                            <h4 class="breadcrumb-title" style="text-align: center;color: #214597;font-size: 30px;font-weight: bold;">Statements of Accounts</h4>
                            <div class="row m-b30 p-b30">
                                <div class="col-lg-6">
                                    <img class="ttr-logo-mobile" alt="" style="padding-left: 20px;" src="assets/images/conserve-logo.png" width="200">
                                </div>
                                <div class="col-lg-6">
                                    <img class="ttr-logo-mobile" alt="" style="padding-right: 20px;float: right;" src="<?php echo $logo ?>" width="200">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <h5 style="padding-left: 20px;">Project Name : <?php echo $name ?></h5>
                                </div>
                                <div class="col-lg-6">
                                    <h5 style="padding-right: 20px;text-align: right;">Project ID : <?php echo $proid ?></h5>
                                </div>
                            </div>
                            <div class="row p-b30">
                                <div class="col-lg-6">
                                    <h5 style="padding-left: 20px;">Scope : <?php echo $scope ?></h5>
                                </div>
                                <div class="col-lg-6">
                                    <h5 style="padding-right: 20px;text-align: right;">Division : <?php echo $divi ?></h5>
                                </div>
                            </div>
                        
                            <div class="card-content m-b5 m-t5" >
                                <div class="table-responsive">
                                <table id="tbl_exporttable_to_xls">
                                <!-- <table id="dataTableExample1" class="table table-striped" style="border:0px solid black;"> -->
                                    
                                        <thead >
                                            <tr >
                                                    <th><center>S.NO</center></th>
                                                    <th><center>PO No</center></th>
                                                    <th><center>Invoice No</center></th>
                                                    <th style="color: #C54800"><center>Invoice Prepared Date</center></th>
                                                    <th><center>Invoice Submitted Date</center></th>
                                                    <th><center>Invoice Value</center></th>
                                                     <th><center>Invoice VAT Value</center></th>
                                                    <?php
                                                    if ($pterms == 2) {
                                                    ?>
                                                        <th><center>Payment For The Month Of</center></th>
                                                    <?php
                                                    }
                                                    ?>
                                                    <th><center>Received Date</center></th>
                                                    <th><center>Received Amount</center></th>
                                                    <th><center>Received VAT Value</center></th>
                                                    <th><center>Remarks</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sql1 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND date<='$today' AND po!='' ORDER BY date ASC";
                                            $result1 = $conn->query($sql1);
                                            $count = 1;
                                            $amo1 = $vat_amo1 = $amo2 = $vat_amo2= $pend = $vat_pend = $tot = $vat_tot = 0;
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
                                                    $vat_recam = $row1['current_gst'];
                                                }

                                                if ($recam != '-') {
                                                    $amo2 += $recam;
                                                    $vat_amo2 += $vat_recam;
                                                }
                                                if ($row1['subdate'] != "") {
                                                    $amo1 += $row1["demo"];
                                                    $vat_amo1 += $row1["demo_gst"];
                                                }

                                                $sub = $row1["subdate"];
                                                $rec = $row1["recdate"];
                                                $newdate = date('Y-m-d', strtotime($sub . '+' . $invdues . ' days'));

                                                if (($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today))) {
                                                    if ($row1["paystatus"] == 2) {
                                                        $tot += $row1["demo"] - $row1["current"];
                                                        $vat_tot += $row1["demo_gst"] - $row1["current_gst"];
                                                    } else {
                                                        // $color = "#FF5733";
                                                        $tot += $row1["demo"];
                                                        $vat_tot += $row1["demo_gst"];
                                                    }
                                                }
                                                if ($row1['subdate'] != "") {
                                                    if ($row1["paystatus"] != 2) {
                                                        $pend += $row1["demo"];
                                                        $vat_pend += $row1["demo_gst"];
                                                    } else {
                                                        if ($row1["recdate"] > $today) {
                                                            $pend += ($row1["demo"] - $row1["current"]);
                                                            $vat_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                        } else {
                                                            $pend += ($row1["demo"] - $row1["current"]);
                                                            $vat_pend += ($row1["demo_gst"] - $row1["current_gst"]);
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
                                                        <center>(<?php echo "".$row1["invid"] ?>)</center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo date('d/m/Y', strtotime($row1["date"])) ?></center>
                                                        
                                                    </td>
                                                    <?php
                                                    if ($row1['subdate'] != null) {
                                                    ?>
                                                        <td style="background-color: <?php echo $color ?>">
                                                            <center><?php echo date('d/m/Y', strtotime($row1["subdate"])) ?></center>
                                                        </td>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <td>
                                                            <center>-</center>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                    <td>
                                                        <center>SAR&nbsp<?php echo number_format($row1["demo"],2) ?></center>
                                                    </td>
                                                    <td>
                                                        <center>SAR&nbsp<?php echo number_format($row1["demo_gst"],2) ?></center>
                                                    </td>
                                                    <?php
                                                    if ($pterms == 2) {
                                                    ?>
                                                        <td>
                                                            <center><?php echo $row1["month"]; ?></center>
                                                        </td>
                                                    <?php
                                                    }
                                                    // else
                                                    // {
                                                    ?>
                                                    <!-- <td><center><?php echo $row1["percent"] . "%"; ?></center></td> -->
                                                    <?php
                                                    // }
                                                    ?>
                                                    </center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $recdate ?></center>
                                                    </td>
                                                    <td>
                                                        <center>SAR&nbsp<?php echo moneyFormatIndia($row1["current"]) ?></center>
                                                    </td>
                                                    <td><center>SAR&nbsp<?php echo moneyFormatIndia($row1["current_gst"]) ?></center></td>
                                                    <td>
                                                        <center><?php echo $rem ?></center>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <table >
                                        <thead>
                                            <tr>
                                                <th><center>Total Invoiced Amount</center></th>
                                                <th><center>Total Invoiced VAT Amount</center></th>
                                                <th><center>Total Received Amount</center></th>
                                                <th><center>Total Received VAT Amount</center></th>
                                                <th><center>Total Pending Amount</center></th>
                                                <th><center>Total Pending VAT Amount</center></th>
                                                <th><center>Total Due Amount</center></th>
                                                <th><center>Total Due VAT Amount</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <center>SAR <?php echo number_format($amo1,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($vat_amo1,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($amo2,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($vat_amo2,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($pend,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($vat_pend,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($tot,2) ?></center>
                                                </td>
                                                <td>
                                                    <center>SAR <?php echo number_format($vat_tot,2) ?></center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id='DivIdToPrint' class="row">
                                    <div class="col-sm-10">

                                    </div>
                                    <div class="col-sm-1">
                                        <button class="btn" id="prnt_btn" onclick="printDiv('DivIdToPrint')">PRINT</button>
                                    </div>
                                    <div class="col-sm-1">
                                        <div >
                                            <button class="btn"  id="export_btn" onclick="html_table_to_excel('xlsx')">Export</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
		// indian money formate
        function moneyFormatIndia($number) {
            $number_value = explode(".",$number);
            $num = $number_value[0];
            $dotvalue = $number_value[1];
            if($dotvalue == "")
            {
                $dotvalue = "00";
            }
            $explrestunits = "" ;
            if(strlen($num)>3) {
                $lastthree = substr($num, strlen($num)-3, strlen($num));
                $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
                $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for($i=0; $i<sizeof($expunit); $i++) {
                    // creates each of the 2's group and adds a comma to the end
                    if($i==0) {
                        $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                    } else {
                        $explrestunits .= $expunit[$i].",";
                    }
                }
                $thecash = $explrestunits.$lastthree;
            } else {
                $thecash = $num;
            }
            return $thecash.".".$dotvalue; // writes the final format where $currency is the currency symbol.
        }
	?>
	<div class="ttr-overlay"></div>
    <!-- External JavaScripts -->
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/vendors/datatables/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <script src="assets/js/admin.js"></script>
    <script>
        $('#dataTableExample1').DataTable({
			dom: 'Bfrtip',
			lengthMenu: [
				[50, 150, 200, -1],
				['50 rows', '150 rows', '200 rows', 'Show all']
			],
			buttons: [
				'pageLength','excel','print'
			]
		});
    </script>
    <script>
        function printDiv(divName)    
        {
            // document.getElementById('tbl_exporttable_to_xls').style.display='block';
            document.getElementById('export_btn').style.display='none';    
            
            document.getElementById('prnt_btn').style.display='none';

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
            document.getElementById('prnt_btn').style.display='block';
            // document.getElementById('tbl_exporttable_to_xls').style.display='none';
            document.getElementById('export_btn').style.display='block';
        }
    </script>
    <script>
        function html_table_to_excel(type)
        {
            var data = document.getElementById('tbl_exporttable_to_xls');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

            XLSX.write(file, { bookType: type, bookSST: true, type: 'binary' });

            XLSX.writeFile(file, 'file.' + type);
        }

            const export_button = document.getElementById('export_button');

            export_button.addEventListener('click', () =>  {
                html_table_to_excel('xlsx');
        });    
    </script>
</body>
</html>