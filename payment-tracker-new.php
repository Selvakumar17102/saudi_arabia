<?php

    ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

	$id = $_REQUEST["id"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($id == "")
	{
		$today = date('Y-m-d');
		$thismonth = date('Y-m-01');
		$monthName = "For The Month of - ".date("F Y");
	}
	else
	{
		if($id < 10)
		{
			$id = "0".$id;
		}

		$thismonth = date('Y-'.$id.'-01');
		$today = date("Y-m-t", strtotime($thismonth));
		$monthName = "For The Month of - ".date('F Y', mktime(0, 0, 0, $id, 10));
	}

	if($fdate != "" && $tdate != "")
	{
		$today = $tdate;
		$thismonth = $fdate;
		$monthName = "From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));

		if($fdate == date('Y-m-01') && $tdate == date('Y-m-d'))
		{
			$monthName = "For The Month of - ".date('F Y');
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
	<meta name="description" content="Income Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Income Account | Income Expense Manager" />
	<meta property="og:description" content="Income Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Payment Tracker | <?php echo $monthName ?></title>
	
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
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
	
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
							<div class="row m-b10">
								<div class="col-sm-12">
									<h4><center>Payment Tracker</center></h4>
									<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
								</div>
								
							</div>
							<div class="row m-b50">
								<div class="col-sm-3">
									<label class="col-form-label">Month Wise Search</label>
									<select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
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
								<div class="col-sm-9">
								<label class="col-form-label">Custom Search</label>
									<div class="col-sm-12">
										<div class="row">
										
											<div class="col-sm-5">
												<input type="date" id="fdate" class="form-control">
											</div>
											<div class="col-sm-5">
												<input type="date" id="tdate" class="form-control">
											</div>
											<div class="col-sm-2">
												<input type="button" class="btn" value="Submit" onclick="search()">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="background-color: #B8F1CE;padding:10px 0">
								<div class="col-sm-8">
									<h6 style="color: #000"><?php echo $monthName ?></h6>
								</div>
								<div class="col-sm-4">
									<?php
										$sql3 = "SELECT sum(current+current_gst) as total, sum(current_gst) as vatamount FROM account a
                                        left outer join invoice b on b.pid=a.account_id
                                        left outer join division c on c.id=a.divi 
                                        where  (b.recdate BETWEEN '$thismonth' AND '$today') AND (b.paystatus = '2')";
										$result3 = $conn->query($sql3);
										$row3 = $result3->fetch_assoc();

										if($row3["total"] == "")
										{
											$row3["total"] = 0;
										}
									?>

										<h6 class="float-right" style="color: #000">Total Income : SAR <?php echo number_format($row3["total"],2) ?></h6>
								</div>
							</div>
                            
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
											<th><center>S.NO</center></th>
											<th><center>Project Id</center></th>
											<th><center>Project Name</center></th>
											<th><center>Client Name</center></th>
											<th><center>Division</center></th>											
											<th><center>Invoice No</center></th>
											<th><center>Invoice Date</center></th>
											<th><center>Invoice Value</center></th>
											<th><center>Invoice VAT Value</center></th>
											<th><center>Received Date</center></th>
											<th><center>Payment Mode</center></th>
											<th><center>Received Value</center></th>
											<th><center>Received VAT Value</center></th>
											<th><center>Remarks</center></th>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$count = 1;
											// $sql = "SELECT * FROM account WHERE type='2' AND sub='0' ORDER BY name ASC";
											// $result = $conn->query($sql);
											// while($row = $result->fetch_assoc())
											// {
												// $id = $row["id"];
												// $sql2 = "SELECT *,a.name as proname,b.mode as paymode FROM account a
												// left outer join invoice b on b.pid=a.account_id
												// left outer join division c on c.id=a.divi
												// where a.sub=$id AND b.recdate BETWEEN '$thismonth' AND '$today'";
												$sql2 = "SELECT *,b.name as proname,c.mode as paymode FROM project a 
												LEFT JOIN enquiry b on a.eid=b.id
												LEFT JOIN invoice c on c.pid=a.proid
												WHERE (c.recdate BETWEEN '$thismonth' AND '$today') AND (c.paystatus = '2')";
												$result1 = $conn->query($sql2);
												while($row1 = $result1->fetch_assoc()){

												?>
													<tr>
														<td><center><?php echo $count++ ?></center></td>
														<td><center><?php echo $row1["pid"]; ?></center></td>
														<td><center><?php echo $row1["proname"]; ?></center></td>
														<td><center><?php echo $row1["cname"]; ?></center></td>
														<td><center><?php echo $row1["rfq"] ?></center></td>
														<td><center><?php echo $row1['invid']; ?></center></td>
														<td><center><?php echo $row1['subdate']; ?></center></td>
														<td><center><?php echo number_format($row1['demo'],2) ?></center></td>
														<td><center><?php echo number_format($row1["demo_gst"],2) ?></center></td>
														<td><center><?php echo $row1["recdate"] ?></center></td>
														<td><center><?php echo $row1["paymode"]?></center></td>
														<?php 
															if($row1["paystatus"] == "2"){
														?>
															<td><center><?php echo number_format($row1["current"],2) ?></center></td>
															<td><center><?php echo number_format($row1["current_gst"],2) ?></center></td>
														<?php
															}else{
														?>
															<td><center> </center></td>
															<td><center> </center></td>
														<?php
															}
														?>
														<td><center><?php echo $row1["remarks"] ?></center></td>
													</tr>
												<?php
												}
											// }
										?>
										</tbody>
										<tfoot hidden="hidden">
											<tr>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td></td>
                                        	    <td align="right">Total Invoice Amount :</td>
                                        	    <td>SAR <?php echo number_format($row3["total"],2) ?></td>
												<td align="right">Total Invoice VAT Amount :</td>
                                        	    <td>SAR <?php echo number_format($row3["vatamount"],2) ?></td>
                                        	</tr>
										</tfoot>
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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/js/admin.js"></script>

sc
<script>
// Start of jquery datatable
            // $('#dataTableExample1').DataTable({
            //     "dom": 'Bfrtip',
			// 	"buttons": [
			// 		'excel'
			// 	],
			// 	"iDisplayLength": 50
            // });
</script>
<script>
	$(document).ready(function() {
    $('#dataTableExample1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            // { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            // { extend: 'csvHtml5', footer: true },
            // { extend: 'pdfHtml5', footer: true }
        ]
    } );
} );
</script>
<script>
	function boss(val)
	{
		if(val != "")
		{
			
			location.replace("payment_tracker.php?id="+val);
		}
	}
	function search()
	{
		var fdate = document.getElementById('fdate').value;
		var tdate=document.getElementById('tdate').value;

		if(fdate == "")
		{
			$("#fdate").css("border", "1px solid red");
		}
		else
		{
			if(tdate == "")
			{
				$("#tdate").css("border", "1px solid red");
			}
			else
			{
				location.replace("payment_tracker.php?fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
</body>
</html>
