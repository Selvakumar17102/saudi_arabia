<?php

    ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

?>
<?php
		$sql = "SELECT * FROM account WHERE type='2' AND sub='0' ORDER BY name ASC";
		$result = $conn->query($sql);
		$total = 0;
		while($row = $result->fetch_assoc())
		{
			$id = $row["id"];
			$code = $row["code"];

			$credit = "";

			$cus = 0;
			$count1 = "";

			$sql2 = "SELECT * FROM account WHERE sub='$id' ORDER BY name ASC";
			$result2 = $conn->query($sql2);

			if($result2->num_rows > 0)
			{
				$cus = 1;
				while($row2 = $result2->fetch_assoc())
				{
					$code1 = $row2["code"];

					$sql1 = "SELECT sum(credit) as credit FROM expence_invoice WHERE code='$code1'";
					$result1 = $conn->query($sql1);
					$row1 = $result1->fetch_assoc();

					$sql3 = "SELECT sum(amount) as credit FROM credits WHERE code='$code1'";
					$result3 = $conn->query($sql3);
					$row3 = $result3->fetch_assoc();

					if($row1["credit"] == "" || $row1["credit"] == "0")
					{
						$row1["credit"] = 0;
					}
					if($row3["credit"] == "" || $row3["credit"] == "0")
					{
						$row3["credit"] = 0;
					}
					$total += $row3["credit"] - $row1["credit"];
				}
			}
			else
			{

				$sql1 = "SELECT sum(credit) as credit FROM expence_invoice WHERE code='$code'";
				$result1 = $conn->query($sql1);
				$row1 = $result1->fetch_assoc();

				$sql3 = "SELECT sum(amount) as credit FROM credits WHERE code='$code'";
				$result3 = $conn->query($sql3);
				$row3 = $result3->fetch_assoc();

				if($row1["credit"] == "" || $row1["credit"] == "0")
				{
					$row1["credit"] = 0;
				}
				if($row3["credit"] == "" || $row3["credit"] == "0")
				{
					$row3["credit"] = 0;
				}
				$total += $row3["credit"] - $row1["credit"];
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
	<meta name="description" content="Income Outstanding Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Income Outstanding Account | Income Expense Manager" />
	<meta property="og:description" content="Income Outstanding Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Income Outstanding Account | <?php echo $monthName ?></title>
	
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

	<script>
		function datefun()
		{
			$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
		}
	</script>
    
</head>
<body onload="datefun()">
	
	<!-- header start -->
	<?php include("inc/expence_header.php") ?>
		<?php include("inc/sidebar.php") ?>
	
	

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
									<h4>Income Account Outstanding Details</h4>
									<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
								</div>
								<div class="col-sm-6">
									<h4 style="float: right">SAR <?php echo number_format($total,2) ?></h4>
								</div>
							</div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><center>S.NO</center></th>
											<th><center>Account Name</center></th>
											<th><center>Sub Account</center></th>
											<th><center>Total Outstanding (SAR)</center></th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
											$count = 1;
											$sql = "SELECT * FROM account WHERE type='2' AND sub='0' ORDER BY name ASC";
											$result = $conn->query($sql);
											while($row = $result->fetch_assoc())
											{
												$id = $row["id"];
												$code = $row["code"];

												$credit = "";

												$cus = 0;
												$count1 = "";

												$sql2 = "SELECT * FROM account WHERE sub='$id' ORDER BY name ASC";
												$result2 = $conn->query($sql2);

												if($result2->num_rows > 0)
												{
													$cus = 1;
													while($row2 = $result2->fetch_assoc())
													{
														$code1 = $row2["code"];

														$sql1 = "SELECT sum(credit) as credit FROM expence_invoice WHERE code='$code1'";
														$result1 = $conn->query($sql1);
														$row1 = $result1->fetch_assoc();

														$sql3 = "SELECT sum(amount) as credit FROM credits WHERE code='$code1'";
														$result3 = $conn->query($sql3);
                                                        $row3 = $result3->fetch_assoc();

														if($row1["credit"] == "" || $row1["credit"] == "0")
														{
															$row1["credit"] = 0;
                                                        }
                                                        if($row3["credit"] == "" || $row3["credit"] == "0")
                                                        {
                                                            $row3["credit"] = 0;
                                                        }
											?>
                                                        <tr>
                                                            <td><center><?php echo $count++ ?></center></td>
                                                            <td><center><?php echo $row["name"] ?></center></td>
                                                            <td><center><?php echo $row2["name"] ?></center></td>
                                                            <td><center><?php echo round($row3["credit"] - $row1["credit"],2) ?></center></td>
                                                        </tr>
											<?php
													}
												}
												else
												{

													$sql1 = "SELECT sum(credit) as credit FROM expence_invoice WHERE code='$code'";
													$result1 = $conn->query($sql1);
													$row1 = $result1->fetch_assoc();

													$sql3 = "SELECT sum(amount) as credit FROM credits WHERE code='$code'";
													$result3 = $conn->query($sql3);
													$row3 = $result3->fetch_assoc();

													if($row1["credit"] == "" || $row1["credit"] == "0")
													{
														$row1["credit"] = 0;
													}
													if($row3["credit"] == "" || $row3["credit"] == "0")
													{
														$row3["credit"] = 0;
													}
											?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <td><center><?php echo $row["name"] ?></center></td>
                                                        <td><center> - </center></td>
                                                        <td><center><?php echo round($row3["credit"] - $row1["credit"],2) ?></center></td>
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
				<!-- Your Profile Views Chart END-->
            </div>
		</div>
	</main>


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
