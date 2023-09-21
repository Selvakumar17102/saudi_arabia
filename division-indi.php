<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

    $id = $_REQUEST["id"];
    $divi = $_REQUEST["divi"];
	$fdate = $_REQUEST["fdate"];
    $tdate = $_REQUEST["tdate"];

    $monthName = "From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));
    
    $sql = "SELECT * FROM account WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $code = $row["code"];
    $type = $row["type"];
    $mai = "";
    $test = 0;
    if($type == 1)
    {
        $mai = "Expense";
    }
    else
    {
        $mai = "Income";
    }
    $total = 0;

    $sql1 = "SELECT * FROM division WHERE id='$divi'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

    $sql4 = "SELECT * FROM account WHERE sub='$id'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows > 0)
    {
        $test = 1;
        while($row4 = $result4->fetch_assoc())
        {
            $code1 = $row4["code"];
            $sql2 = "SELECT * FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$fdate' AND '$tdate'";
            $result2 = $conn->query($sql2);
            while($row2 = $result2->fetch_assoc())
            {
                $invid = $row2["id"];

                $sql3 = "SELECT * FROM sector WHERE inv='$invid' AND divi='$divi'";
                $result3 = $conn->query($sql3);
                $row3 = $result3->fetch_assoc();

                $total += $row3["amount"];
            }
        }    
    }
    else
    {
        $sql2 = "SELECT * FROM expence_invoice WHERE code='$code' AND date BETWEEN '$fdate' AND '$tdate'";
        $result2 = $conn->query($sql2);
        while($row2 = $result2->fetch_assoc())
        {
            $invid = $row2["id"];

            $sql3 = "SELECT * FROM sector WHERE inv='$invid' AND divi='$divi'";
            $result3 = $conn->query($sql3);
            $row3 = $result3->fetch_assoc();

            $total += $row3["amount"];
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
	<meta name="description" content="Division Reports | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Division Reports | Income Expense Manager" />
	<meta property="og:description" content="Division Reports | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Division Reports | Income Expense Manager</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/calendar/fullcalendar.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="assets/css/tabs.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	<style>
        .hide1, .dataTables_info, .dataTables_paginate
        {
            display: none;
        }
    </style>
</head>
<body style="background-color: #f8f8f8;">
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
    <main class="ttr-wrapper">
		<div class="container-fluid">
            <div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4><?php echo $row["name"] ?> Reports - <?php echo $row1["division"] ?> Division</h4>
                                </div>
                                <div class="col-sm-5">
                                    <h4>Total <?php echo $mai.' : SAR '.number_format($total,2) ?></h4>
                                </div>
                                <div class="col-sm-1">
                                    <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Account Name</th>
                                            <?php
                                                if($test != 1)
                                                {
                                            ?>
                                            <th>Mode</th>
											<th>Description</th>
                                            <?php
                                                }
                                            ?>
											<th>Amount (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql4 = "SELECT * FROM account WHERE sub='$id'";
                                            $result4 = $conn->query($sql4);
                                            $count = 1;
                                            if($result4->num_rows > 0)
                                            {
                                                while($row4 = $result4->fetch_assoc())
                                                {
                                                    $code1 = $row4["code"];

                                                    $amount = 0;

                                                    $sql2 = "SELECT * FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$fdate' AND '$tdate'";
                                                    $result2 = $conn->query($sql2);
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        $invid = $row2["id"];
                                        
                                                        $sql3 = "SELECT * FROM sector WHERE inv='$invid' AND divi='$divi'";
                                                        $result3 = $conn->query($sql3);
                                                        $row3 = $result3->fetch_assoc();

                                                        $amount += $row3["amount"];

                                                    }
                                                    if($amount > 0)
                                                    {
                                            ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><a href="division-sub.php?id=<?php echo $row4["id"].'&divi='.$divi.'&fdate='.$fdate.'&tdate='.$tdate ?>"><?php echo $row4["name"] ?></a></center></td>
                                                        <td><center><?php echo number_format($amount,2) ?></center></td>
                                                    </tr>
                                            <?php
                                                    }
                                                }    
                                            }
                                            else
                                            {
                                                $sql2 = "SELECT * FROM expence_invoice WHERE code='$code' AND date BETWEEN '$fdate' AND '$tdate'";
                                                $result2 = $conn->query($sql2);
                                                while($row2 = $result2->fetch_assoc())
                                                {
                                                    $invid = $row2["id"];
                                        
                                                    $sql3 = "SELECT * FROM sector WHERE inv='$invid' AND divi='$divi'";
                                                    $result3 = $conn->query($sql3);
                                                    $row3 = $result3->fetch_assoc();

                                                    if($row3["amount"] > 0)
                                                    {
                                            ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><?php echo $row["name"] ?></center></td>
                                                        <td><center><?php echo $row2["mode"] ?></center></td>
                                                        <td><center><?php echo $row2["descrip"] ?></center></td>
                                                        <td><center><?php echo number_format($row3["amount"],2) ?></center></td>
                                                    </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                        ?>
									</tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
            </div>
		</div>
	</main>
			<!-- Card END -->
	<!-- <div class="ttr-overlay"></div> -->

<!-- External JavaScripts -->
<script src="assets/js/expense/jquery.min.js"></script>
<script src="assets/vendors/expense/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/expense/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/expense/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/expense/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/expense/counter/waypoints-min.js"></script>
<script src="assets/vendors/expense/counter/counterup.min.js"></script>
<script src="assets/vendors/expense/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/expense/masonry/masonry.js"></script>
<script src="assets/vendors/expense/masonry/filter.js"></script>
<script src="assets/vendors/expense/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/expense/scroll/scrollbar.min.js'></script>
<script src="assets/js/expense/functions.js"></script>
<script src="assets/vendors/expense/chart/chart.min.js"></script>
<script src="assets/js/expense/admin.js"></script>
<script src='assets/vendors/expense/calendar/moment.min.js'></script>
<script src='assets/vendors/expense/calendar/fullcalendar.js'></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				]
            });
</script>

</body>
</html>