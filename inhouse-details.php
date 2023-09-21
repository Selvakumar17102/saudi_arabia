<?php

    ini_set('display_errors','off');
	include("inc/dbconn.php");
    include("inc/session.php");

    $id = $_REQUEST["id"];
    $fDate = $_REQUEST["fdate"];
    $tDate = $_REQUEST["tdate"];

    $sql = "SELECT * FROM account WHERE id='$id'";
    $result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$code1 = $row["code"];
	$amount = 0;

	$sql2 = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE code='$code1'";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	$amount += $row2["credit"];
	$amount -= $row2["debit"];
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
	<meta name="description" content="<?php echo $row["name"] ?> Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="<?php echo $row["name"] ?> Account | Income Expense Manager" />
	<meta property="og:description" content="<?php echo $row["name"] ?> Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title><?php echo $row["name"] ?> Account | <?php echo $monthName ?></title>
	
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
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
    
</head>
<body>
	
	<!-- header start -->
	<?php include("inc/expence_header.php") ?>
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container">
				
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<div class="row">
								<div class="col-sm-6">
									<h4><?php echo $row["name"] ?> Account Details</h4>
								</div>
								<div class="col-sm-5">
									<h6>Total Outstanding : SAR <?php echo number_format($amount,2) ?></h6>
								</div>
								<div class="col-sm-1">
									<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
								</div>
							</div>
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Date</th>
											<th>Mode</th>
											<th>Description</th>
											<th>Credit (SAR)</th>
											<th>Debit (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
											
											$code = $row["code"];

											$sql1 = "SELECT * FROM expence_invoice WHERE code='$code' AND date BETWEEN '$fDate' AND '$tDate' ORDER BY date DESC";
											// echo $sql1;exit();
                                            $result1 = $conn->query($sql1);
                                            $count = 1;
                                            while($row1 = $result1->fetch_assoc())
                                            {
												if($row1["debit"] == "")
                                                {
                                                    $row1["debit"] = 0;
                                                }
                                                if($row1["credit"] == "")
                                                {
                                                    $row1["credit"] = 0;
                                                }
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo date('d-m-Y',strtotime($row1["date"])) ?></center></td>
                                                <td><center>
												<?php
													echo $row1["mode"];
													if($row1["mode"] == "Cheque")
													{
												?>
														<br>(<?php echo $row1["chno"] ?>)
												<?php
													}
												?>
												</center></td>
                                                <td><center><?php echo $row1["descrip"] ?></center></td>
                                                <td><center><?php echo $row1["credit"] ?></center></td>
                                                <td><center><?php echo $row1["debit"] ?></center></td>
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
				<!-- Your Profile Views Chart END-->
            </div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
</script>
</body>
</html>