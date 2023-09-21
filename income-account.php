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
	<title>Income Account | <?php echo $monthName ?></title>
	
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
							<div class="row m-b10">
								<div class="col-sm-12">
									<h4><center>Income Account Details</center></h4>
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
										$sql3 = "SELECT sum(credit) AS credit,date FROM expence_invoice WHERE date BETWEEN '$thismonth' AND '$today' AND type='1'";
										$result3 = $conn->query($sql3);
										$row3 = $result3->fetch_assoc();

										if($row3["credit"] == "")
										{
											$row3["credit"] = 0;
										}
									?>

										<h6 class="float-right" style="color: #000">Total Income : SAR <?php echo number_format($row3["credit"],2) ?></h6>
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
											<th><center>Invoice Name</center></th>
											<th><center>Invoice Submited</center></th>
											<th><center>Invoice Value</center></th>
											<th><center>Invoice Vat</center></th>
											<th><center>Received Date</center></th>
											<th><center>Mode</center></th>
											<th><center>Cheque No</center></th>
											<th><center>Received Value</center></th>
											<th><center>Received Vat</center></th>
											<th><center>Remarks</center></th>
											<!-- <th><center>Vat Total (SAR)</center></th> -->
                                        </tr>
                                    </thead>
									<tbody>
                                        <!-- <?php
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

														$sql1 = "SELECT id,sum(credit) as credit,date,mode,descrip,chno,sum(vat) as vat FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$thismonth' AND '$today'";
														$result1 = $conn->query($sql1);
														$row1 = $result1->fetch_assoc();
														$mode = $row1['mode'];
														$descrip = $row1['descrip'];
														$chno = $row1['chno'];
														
														$mainid = $row1["id"];
														$division = "";

														$sql8 = "SELECT * FROM sector WHERE inv='$mainid'";
														$result8 = $conn->query($sql8);
														while($row8 = $result8->fetch_assoc())
														{
															$diviid = $row8["divi"];

															$sql9 = "SELECT * FROM division WHERE id='$diviid'";
															$result9 = $conn->query($sql9);
															$row9 = $result9->fetch_assoc();

															$division .= $row9["division"]."<br>";
														}

														$sql3 = "SELECT sum(amount) as credit FROM credits WHERE code='$code1' AND date BETWEEN '$thismonth' AND '$today'";
														$result3 = $conn->query($sql3);
														$row3 = $result3->fetch_assoc();

														if($row1["credit"] == "" || $row1["credit"] == "0")
														{
															$row1["credit"] = 0;															
														}
														else
														{
											?>
															<tr>
																<td><center><?php echo $count++ ?></center></td>
																<td><center><?php echo date('d/m/Y', strtotime($row1["date"])) ?></center></td>
																<td><center><?php echo $row["name"] ?></center></td>
																<td><center><?php echo $row2["name"] ?></center></td>
																<td><center><?php echo $division; ?></center></td>
																<td><center><?php echo $descrip; ?></center></td>
																<td><center><?php echo $mode; ?></center></td>
																<td><center><?php echo $chno; ?></center></td>
																<td><center><?php echo $row1["credit"] ?></center></td>
																<td><center><?php echo $row1["vat"] ?></center></td>
															</tr>
											<?php
														}
													}
												}
												else
												{

													$sql1 = "SELECT id,sum(credit) as credit,date,mode,descrip,chno FROM expence_invoice WHERE code='$code' AND date BETWEEN '$thismonth' AND '$today'";
													$result1 = $conn->query($sql1);
													$row1 = $result1->fetch_assoc();

													$mainid = $row1["id"];
													$division = "";

													$sql8 = "SELECT * FROM sector WHERE inv='$mainid'";
													$result8 = $conn->query($sql8);
													while($row8 = $result8->fetch_assoc())
													{
														$diviid = $row8["divi"];

														$sql9 = "SELECT * FROM divi WHERE id='$diviid'";
														$result9 = $conn->query($sql9);
														$row9 = $result9->fetch_assoc();

														$division .= $row9["name"]."<br>";
													}

													$sql3 = "SELECT sum(amount) as credit FROM credits WHERE code='$code' AND date BETWEEN '$thismonth' AND '$today'";
													$result3 = $conn->query($sql3);
													$row3 = $result3->fetch_assoc();

													if($row1["credit"] == "" || $row1["credit"] == "0")
													{
														$row1["credit"] = 0;
													}
													else
													{
											?>
														<tr>
															<td><center><?php echo $count++ ?></center></td>
															<td><center><?php echo date('d/m/Y', strtotime($row1["date"])) ?></center></td>
															<td><center><?php echo $row["name"] ?></center></td>
															<td><center> - </center></td>
															<td><center><?php echo $division; ?></center></td>
															<td><center><?php echo $descrip; ?></center></td>
															<td><center><?php echo $mode; ?></center></td>
															<td><center><?php echo $chno; ?></center></td>
															<td><center><?php echo $row1["credit"] ?></center></td>
														</tr>
											<?php
													}
												}
											}
                                        ?> -->
										<?php
											$sql = "SELECT * FROM account WHERE type='2' AND sub='0' ORDER BY name ASC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$id = $row["id"];
												// $sql2 = "SELECT *,a.name as name1,b.descrip as desc1,b.mode as mode1,b.chno as chno1,b.credit as cred1,b.vat as vat1,d.division as divname FROM account a
												// left outer join expence_invoice b on b.code=a.code
												// left outer join sector c on c.inv=b.id
												// left outer join division d on d.id=c.divi where sub='$id' AND b.date BETWEEN '2020-05-01' AND '2023-05-01'";
												// echo $sql2;
												$sql2 = "SELECT a.vat as pvvat,a.credit as pcval,c.pid as proid,b.name as proname,e.division as divname,c.rfqid as invname,c.total as pval,c.gst_value as pvat,c.recdate as rdate,c.subdate as subdate,c.mode as mode1,a.chno as cheque,c.current as rval,c.current_gst as rvat,c.remarks as invremark 
												FROM expence_invoice a
												left join account b on b.code= a.code 
												left join invoice c on b.account_id=c.pid
												left join sector d on d.inv=a.id
												left join division e on e.id=d.divi
												where b.sub=$id AND c.current !='' and paystatus=2 and c.recdate BETWEEN '$thismonth' AND '$today' GROUP BY a.id ";
												$result1 = $conn->query($sql2);
												// echo $sql2;
												while($row1 = $result1->fetch_assoc()){
												// echo $name = $row1['name'];
												// var_dump($row1);
												?>
													<tr>
														<td><center><?php echo $count++ ?></center></td>
														<td><center><?php echo $row1["proid"]; ?></center></td>
														<td><center><?php echo $row1["proname"]; ?></center></td>
														<td><center><?php echo $row["name"]; ?></center></td>
														<td><center><?php echo $row1["divname"] ?></center></td>
														<td><center><?php echo $row1['invname']; ?></center></td>
														<td><center><?php echo $row1['subdate']; ?></center></td>
														<td><center><?php echo $row1['pcval']; ?></center></td>
														<td><center><?php echo $row1["pvvat"] ?></center></td>
														<td><center><?php echo $row1["rdate"] ?></center></td>
														<td><center><?php echo $row1["mode1"] ?></center></td>
														<td><center><?php echo $row1["cheque"] ?></center></td>
														<td><center><?php echo $row1["rval"] ?></center></td>
														<td><center><?php echo $row1["rvat"] ?></center></td>
														<td><center><?php echo $row1["invremark"] ?></center></td>
														<!-- <td><center><?php echo date('d/m/Y', strtotime($row["date"])) ?></center></td>
														<td><center><?php echo $row["name"] ?></center></td>
														<td><center><?php echo $row["divname"] ?></center></td>
														<td><center><?php echo $row["divname"]; ?></center></td>
														<td><center><?php echo $row['descrip']; ?></center></td>
														<td><center><?php echo $row['mode']; ?></center></td>
														<td><center><?php echo $row['chno']; ?></center></td>
														<td><center><?php echo $row["credit"] ?></center></td>
														<td><center><?php echo $row["vat"] ?></center></td> -->
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
<script>
	function boss(val)
	{
		if(val != "")
		{
			
			location.replace("income-account.php?id="+val);
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
				
				location.replace("income-account.php?fdate="+fdate+"&tdate="+tdate);
				 
				

			}
		}
	}
</script>
</body>
</html>
