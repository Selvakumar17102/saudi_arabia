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
	<meta name="description" content="Expense Account Details | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Expense Account Details | Income Expense Manager" />
	<meta property="og:description" content="Expense Account Details | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Expense Account Details | Income Expense Manager</title>
	
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
        .bootstrap-select.btn-group .dropdown-toggle .filter-option 
        {
            color: blue;
        }
        body 
        {
            font-family: Rubik;font-size: 16px;
        }
        .ttr-sidebar-navi a 
        {
            text-decoration: none !important;
        }

        .bootstrap-select.btn-group .dropdown-menu li a 
        {
            color: #000;
        }
        .form-control 
        {
            border: 1px solid #c6d2d9;
			box-shadow: none;
			height: 40px !important;
			font-size: 13px;
			line-height: 20px;
			padding: 9px 12px;
			border-radius: 0;
		}
        select.selectpicker1 option
        {
            font-size: 16px;
        }
		.d
		{
			margin-top:10px;
		}
		.he
		{
			height: 100px;
		}
		.co
		{
			color: #BE882F;
		}
		.form-control
		{
			padding:0;
		}
		.hide1
		{
			display: none;
		}
		.hide2
		{
			display: none;
		}
		.hide3
		{
			display: none;
		}
		.hide4
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <div class="widget-box">
						<div class="wc-title">
							<div class="row m-b10">
								<div class="col-sm-12">
									<h4><center>Expense Account Details</center></h4>
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
									<h6><?php echo $monthName ?></h6>
								</div>
								<div class="col-sm-4">
								<?php
									$sql2 = "SELECT sum(debit) AS debt FROM expence_invoice WHERE (date BETWEEN '$thismonth' AND '$today') AND debit!='0' AND type='2' ORDER BY id DESC";
									$result2 = $conn->query($sql2);
									$row2 = $result2->fetch_assoc();
								?>
									<h6 style="float: right">Total Expense : SAR <?php echo number_format($row2["debt"], 2) ?></h6>
								</div>
							</div>
						</div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Date</th>
											<th>Account</th>
											<th>Sub Account</th>
											<th>Division</th>
											<th>Description</th>
											<th>Mode</th>
											<th>Debit</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql2 = "SELECT * FROM expence_invoice WHERE (date BETWEEN '$thismonth' AND '$today') AND debit!='0' AND type='2' ORDER BY id DESC";
                                            $result2 = $conn->query($sql2);
                                            $count = 1;
                                            while($row2 = $result2->fetch_assoc())
                                            {
												$codes = $row2["code"];
												$mainid = $row2["id"];
												$division = "";

												$sql3 = "SELECT * FROM account WHERE code='$codes'";
												$result3 = $conn->query($sql3);
												$row3 = $result3->fetch_assoc();

												$ids = $row3["sub"];
												$names = " - ";

												if($ids != 0)
												{
													$sql7 = "SELECT * FROM account WHERE id='$ids'";
													$result7 = $conn->query($sql7);
													$row7 = $result7->fetch_assoc();

													$names = $row7["name"];
												}

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
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
												<td><center><?php echo date('d/m/Y', strtotime($row2["date"])) ?></center></td>
                                                <?php
													if($names == " - ")
													{
												?>
													<td><center><?php echo $row3["name"] ?></center></td>
													<td><center><?php echo $names ?></center></td>
												<?php
													}
													else
													{
												?>
													<td><center><?php echo $names ?></center></td>
													<td><center><?php echo $row3["name"] ?></center></td>
												<?php
													}
												?>
												<td><center><?php echo $division ?></center></td>
												<td><center><?php echo $row2["descrip"] ?></center></td>
                                                <td><center>
												<?php 
													echo $row2["mode"];
													if($row2["mode"] == "Cash")
													{
														if($row2["receipt"] == "Yes")
														{
												?>
														- Receipt Given
														<?php
															if($row2["file"] != "")
															{
														?>
															- <a href="<?php echo $row2["file"] ?>" target="_blank"><img style="height: 20px" src="assets/images/receipt.svg" alt=""></a>
														<?php
															}
														?>
												<?php
														}
														else
														{
															echo " - Receipt Not Given";
														}
													}
												?>
												</center></td>
                                                <td><center><?php echo $row2["debit"]; ?></center></td>
												
                                                
												<!--  <td><center><a style="padding:10px" href="view-project.php?"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td> -->
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
		],
		"iDisplayLength": 50
	});
	function boss(val)
	{
		if(val != "")
		{
			location.replace("expense1.php?id="+val);
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
				location.replace("expense1.php?fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
<script>
	$(document).ready(function(){
		$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
	});
	function receipt(val)
		{
			if(val == "Yes")
			{
				document.getElementsByClassName('hide4')[0].style.display = 'block';
			}
			else
			{
				document.getElementsByClassName('hide4')[0].style.display = 'none';
			}
		}
		function bank12(val)
		{
			
			if(val == "Cash")
			{
				document.getElementsByClassName('hide1')[0].style.display = 'none';
				document.getElementsByClassName('hide2')[0].style.display = 'none';
				document.getElementsByClassName('hide3')[0].style.display = 'block';
			}
			else
			{
				if(val == "Cheque")
				{
					document.getElementsByClassName('hide1')[0].style.display = 'block';
					document.getElementsByClassName('hide2')[0].style.display = 'block';
					document.getElementsByClassName('hide3')[0].style.display = 'none';
				}
				else
				{
					document.getElementsByClassName('hide1')[0].style.display = 'block';
					document.getElementsByClassName('hide2')[0].style.display = 'none';
					document.getElementsByClassName('hide3')[0].style.display = 'none';
				}
			}
		}
		function validate()
	{
		
		var code = document.getElementById('code').value;
		var descrip=document.getElementById('descrip').value;
		var mode=document.getElementById('mode').value;
		var debit=document.getElementById('debit').value;
		var mselect = document.getElementsByName('divi[]')[0].value;

		if (code == "")
		{
			$("#code").css("border", "1px solid red");
			return false;
		}
		if (mselect == "") 
		{
			$(".divii .bootstrap-select").css("border", "1px solid red");
			return false;
		}
		if (descrip == "")
		{
			$("#descrip").css("border", "1px solid red");
			return false;
		}
		if (mode == "")
		{
			$("#mode").css("border", "1px solid red");
			return false;
		}
		if (debit == "")
		{
			$("#debit").css("border", "1px solid red");
			return false;
		}
	}
</script>
</body>
</html>