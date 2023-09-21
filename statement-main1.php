<?php
	ini_set('display_errors','off');
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
	$logo = $row["logo"];

	$sql2 = "SELECT sum(current) as current,total FROM invoice WHERE rfqid='$rfqid'";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
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
	<meta property="og:description" content="All Statement | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Statement | Project Management System</title>
	
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
				<h4 class="breadcrumb-title">Statements</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="dashboard.php"><i class="fa fa-home"></i>Home</a></li>
					<li><a href="statement.php">All Statement</a></li>
					<li>Statement Of Accounts</li>
				</ul>
				
			</div>	
			<!-- Card -->
			

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div id="print" class="card m-b30 p-t30">

						<div style="margin: 20px 50px">
							<img style="float:left" class="ttr-logo-mobile" alt="" src="assets/images/logo.svg" width="150">
					
							<img style="float:right" class="ttr-logo-mobile" alt="" src="<?php echo $logo ?>" width="150">
						</div>

						<table style="width:100%;margin-top: 20px">
							<thead>
								<tr>
									<th><center>Project Name</center></th>
									<th><center>Project ID</center></th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td><center><?php echo $name ?></center></td>
									<td><center><?php echo $proid; ?></center></td>
								</tr>
							</tbody>

						</table>

                        <div class="card-content" style="margin-top:20px">
                            <div class="table-responsive">
                    	        <table class="table table-striped">

                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>PO No</th>
											<th>Invoice No</th>
											<th>Invoice Prepared Date</th>
                                            <th>Invoice Submitted Date</th>
											<th>Invoice Value</th>
											<th>Invoice Status</th>
											<?php
												if($pterms == 2)
												{
											?>
											<th>Payment For The Month Of</th>
											<?php
												}
												else
												{
											?>
											<th>Payment Terms</th>
											<?php
												}
											?>
											<th>Recieved Date</th>
											<th>Recieved Amount</th>
											<th>Remarks</th>
											<th>Action</th>
                                        </tr>
                                    </thead>

									<tbody>
										<?php
											$sql1 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0' ORDER BY date ASC";
											$result1 = $conn->query($sql1);
											$count = 1;
											$amo1 = 0;
											$amo2 = 0;
											while($row1 = $result1->fetch_assoc())
											{
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
												$amo1 += $row1["demo"];
												
										?>
												<tr>
													<td><center><?php echo $count++ ?></center></td>	
													<td><center><?php echo $row1["po"] ?></center></td>
													<td><center><?php echo $row1["invid"] ?></center></td>													
													<td><center><?php echo date('d/m/Y',strtotime($row1["date"])) ?></center></td>
													<td><center><?php echo date('d/m/Y',strtotime($row1["subdate"])) ?></center></td>
													<td><center><?php echo $row1["demo"] ?></center></td>
													<td><center><?php echo $term ?></center></td>
													<td><center><?php echo $row1["month"] ?></center></td>
													<td><center><?php echo $recdate ?></center></td>
													<td><center><?php echo $recam ?></center></td>
													<td><center><?php echo $rem ?></center></td>
													<td><center><a href="edit-entry.php?id=<?php echo $row1["id"]."&enq=".$id ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
												</tr>
										<?php
											}
										?>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td colspan="2" style="text-align: right;"><b>Total Generated Amount</b></td>
												<td><b><center><?php echo $amo1 ?></center></b></td>
												<td></td>
												<td colspan="2" style="text-align: right;"><b>Total Recieved Amount</b></td>
												<td><b><center><?php echo $amo2 ?></center></b></td>
												<td></td>
											</tr>
											
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td colspan="3" style="text-align: right;"><b>Total Pending Amount</b></td>
												<td><b><center> <?php echo $amo1-$amo2 ?></center></b></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											
									</tbody>
                                </table>
                            </div>
                        </div>
						
                    </div>

					<div class="row">
						<div class="col-sm-10">
						</div>
						<div class="col-sm-2">
							<!-- <input type="submit" name="print" value="Print" onclick="printDiv()" class="bg-default btn btn-lg"> -->
							<a href="soaprint.php?id=<?php echo $id; ?>" class="bg-default btn btn-lg" target="_blank">Print</a>
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
<!-- <script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [6, 25, 50, -1],
                    [6, 25, 50, "All"]
                ],
                "iDisplayLength": 6
            });
</script> -->

<script> 
        function printDiv() { 
            var divContents = document.getElementById("print").innerHTML; 
            var a = window.open('', '', 'height=500, width=500'); 
            a.document.write('<html>'); 
            a.document.write('<body > <h1 style="text-align:center">Statement of Accounts </h1>'); 
            a.document.write(divContents); 
            a.document.write('</body></html>'); 
            a.document.close(); 
            a.print(); 
        } 
</script> 
</body>
</html>