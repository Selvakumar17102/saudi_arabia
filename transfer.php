<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

	$dateid = $_REQUEST["date"];
	
	if(isset($_POST["submit"]))
	{
		$amount = $_POST["amount"];
		$type = $_POST["type"];
		$date = $_POST["date"];
		$banktype = $_POST["bank"];
		$banktype2 = $_POST["tobank"];
		$chno = $_POST["chno"];
		$transfer = 0;

		if($type == "")
		{
			echo '<script>alert("Choose Type!")</script>';
		}
		else
		{
			$sql = "SELECT * FROM expence_main WHERE id='1'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();

			$cash = $row["balance"];

			$sql1 = "SELECT * FROM expence_main WHERE id='$banktype'";
			$result1 = $conn->query($sql1);
			$row1= $result1->fetch_assoc();

			$bank = $row1["balance"];

			if($banktype2 == '')
			{
				$banktype2 = 0;
				$bank2 = 0;
			}
			else
			{
				$sql1 = "SELECT * FROM expence_main WHERE id='$banktype2'";
				$result1 = $conn->query($sql1);
				$row1= $result1->fetch_assoc();

				$bank2 = $row1["balance"];
			}
			
			$b1 = $b2 = 0;

			$credit = $debit = 0;
			if($type == 1)
			{
				$debit = $amount;

				$chno = "";

				$cash = $cash - $amount;
				$bank = $bank + $amount;

				$b1 = $banktype;
			}
			else
			{
				if($type == 2)
				{
					$credit = $amount;

					$cash = $cash + $amount;
					$bank = $bank - $amount;

					$b1 = $banktype;
				}
				else
				{
					$credit = $amount;

					$transfer = 1;

					$bank2 = $bank2 + $amount;
					$bank = $bank - $amount;

					$b1 = $banktype;
					$b2 = $banktype2;
				}
			}

			$sql4 = "INSERT INTO expence_invoice (date,credit,debit,type,chno,transfer,b1,b2) VALUES ('$date','$credit','$debit','3','$chno','$transfer','$b1','$b2')";
			if($conn->query($sql4) === TRUE)
			{
				$sql5 = "UPDATE expence_main SET balance='$cash' WHERE id='1'";
				if($conn->query($sql5) === TRUE)
				{
					$sql6 = "UPDATE expence_main SET balance='$bank' WHERE id='$banktype'";
					if($conn->query($sql6) === TRUE)
					{
						$sql6 = "UPDATE expence_main SET balance='$bank2' WHERE id='$banktype2'";
						if($conn->query($sql6) === TRUE)
						{
							header("location: transfer.php?msg=Transfer Successful!");
						}
					}
				}
			}
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
	<meta name="description" content="Day Book Transfer | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Day Book Transfer | Income Expense Manager" />
	<meta property="og:description" content="Day Book Transfer | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Day Book Transfer | Income Expense Manager</title>
	
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

	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		.d
		{
			margin-top:10px;
		}
		.d1
		{
			margin-top:15px;
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
		.hide
		{
			display: none;
		}
	</style>
	
	<script>
		function datefun()
		{
			$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
		}
		function validate()
		{
			var amount = document.getElementById('amount').value;

			if (amount == "")
			{
				$("#amount").css("border", "1px solid red");
				return false;
			}
		}
	</script>
	
</head>
<body onload="datefun()">
	
	<?php include("inc/expence_header.php"); ?>
	<?php include_once("inc/sidebar.php"); ?>
	
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container">
			
			<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
			<?php
				if($dateid == "")
				{
			?>
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<h4>Day Book : Transfer Entry</h4>
						</div>
						<div class="widget-inner">
								

								<div class="row">
									<div class="col-5" style="background: #f8f8f8;border-radius:4px;padding:20px;">
									<center><h5 class="m-b30">Day Book</h5></center>
										<form class="edit-profile" method="post">
											<div class="row">
												<div class="col-sm-8">
													<label class="col-form-label">Select Date</label>
													<input class="form-control" type="date" name="date" value="<?php echo date('Y-m-d') ?>" required>
												</div>
												<div class="col-sm-4" style="margin-top: 23px">
													<button type="submit" class="btn btn-primary" name="choose"><i class="fa fa-arrow-right"></i></button>
												</div>
											</div>
										</form>
									</div>

									<div class="col-1"></div>
									<div class="col-6" style="background: #f8f8f8;border-radius:4px;padding:20px;">
									<center><h5 class="m-b30">Custom Search</h5></center>
										<form class="edit-profile" method="post">
											<div class="row" >
												<div class="col-sm-5">
													<label class="col-form-label">From Date</label>
													<input class="form-control" type="date" name="fdate" required>
												</div>
												<div class="col-sm-5">
													<label class="col-form-label">To Date</label>
													<input class="form-control" type="date" name="tdate" required>
												</div>
												<div class="col-sm-1">
													<label class="col-form-label">&nbsp;</label>
													<button type="submit" class="btn btn-primary" name="search"><i class="fa fa-arrow-right"></i></button>
												</div>
											</div>

											
										</form>
									</div>
								</div>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
			<?php
				if(isset($_POST["search"]))
				{
					$fdate = $_POST["fdate"];
					$tdate = $_POST["tdate"];

					if($fdate == "" || $tdate == "")
					{
						echo '<script>alert("Choose Date!")</script>';
					}
					else
					{
			?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
						<div class="card">

							<div class="card-content">
								<div class="table-responsive">
									<table id="dataTableExample1" class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th><center>S.NO</center></th>
												<th><center>Date</center></th>
												<th><center>Debit</center></th>
												<th><center>Credit</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$count1 = 1;
												for(;$fdate <= $tdate;$fdate = date("Y-m-d",strtotime("+1 day", strtotime($fdate))))
												{
													$sql2 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date='$fdate' AND type='3' AND code=''";
													$result2 = $conn->query($sql2);
													$row2 = $result2->fetch_assoc();

													if($row2["debit"] == "")
                                                    {
                                                        $row2["debit"] = 0;
                                                    }
                                                    if($row2["credit"] == "")
                                                    {
                                                        $row2["credit"] = 0;
                                                    }
											?>
												<tr>
													<td><center><?php echo $count1++ ?></center></td>
													<td><center><a href="transfer.php?date=<?php echo $fdate ?>" target="_blank"><?php echo date('d-m-Y',strtotime($fdate)) ?></a></center></td>
													<td><center><?php echo number_format($row2["debit"],2) ?></center></td>
													<td><center><?php echo number_format($row2["credit"],2) ?></center></td>
																						
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
			<?php
					}
				}
			?>
			<?php
				if(isset($_POST["choose"]))
				{
					$date1 = $_POST["date"];
				}
			}
			else
			{
		?>
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<div class="row">
								<div class="col-sm-11">
									<h4>Day Book : Transfer Entry</h4>
								</div>
								<div class="col-sm-1">
									<a href="#" onclick="history.back(1);" style="color: #fff" class="bg-primary btn">Back</a>
								</div>
							</div>
						</div>
						<div class="widget-inner">
							<form class="edit-profile" method="post">
								<div class="row">

									<div class="col-12">

										<div class="row" style="margin-bottom:20px;">
											<div class="col-sm-2">
												<label class="col-form-label">Entry Date</label>
											</div>
											<div class="col-sm-3">
													<input class="form-control" type="date" name="date" value="<?php echo $dateid ?>" readonly>
											</div>
										</div>

										<div class="row" style="margin-bottom:20px;">
											
											<div class="col-sm-3">
												<label class="col-form-label">Amount</label>
												<input type="text" id="amount" name="amount" class="form-control" placeholder="Amount" required>
											</div>
											<div class="col-md-2">
												<label class="col-form-label">Bank</label>
												<div>
													<Select class="form-control" name="bank">
														<option value="2">Alinma</option>
														<!-- <option value="2">MHQ</option>
														<option value="3">QNB</option>
														<option value="4">DOHA</option> -->
													</Select>
												</div>
											</div>
											<div class="form-group col-3 d1">
												<div class="form-check-inline ">
													<label class="form-check-label">
														<input type="radio" value="1" checked class="form-check-input" name="type" onchange="change(this.value)">Cash to Bank
													</label>
												</div>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="2" class="form-check-input" name="type" onchange="change(this.value)">Bank to Cash
													</label>
												</div>
												<!-- <div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="3" class="form-check-input" name="type" onchange="change(this.value)">Bank to Bank
													</label>
												</div> -->
											</div>
											
											<div class="col-sm-2 hide">
												<label class="col-form-label">To Bank</label>
												<div>
													<Select class="form-control" name="tobank">
														<option value selected disabled>Select Bank</option>
														<option value="2">Alinma</option>
														<!-- <option value="2">MHQ</option>
														<option value="3">QNB</option>
														<option value="4">DOHA</option> -->
													</Select>
												</div>
											</div>

											<div class="col-sm-2 hide">
												<label class="col-form-label">Cheque Number</label>
												<input type="text" name="chno" class="form-control" placeholder="Cheque Number">
											</div>
										</div>
										<center><input type="submit" style="background-color: #134094;color: white" value="Submit" class="btn" name="submit" onclick="return validate()"></center>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Date</th>
											<th>Cash to Bank</th>
											<th>Bank to Cash</th>
											<th>Bank to Bank</th>
											<th>Edit</th>
											<th>Delete</th>
			
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql2 = "SELECT * FROM expence_invoice WHERE date='$dateid' AND type='3' ORDER BY id DESC";
                                            $result2 = $conn->query($sql2);
                                            $count = 1;
                                            while($row2 = $result2->fetch_assoc())
                                            {
												if($row2["code"] == "")
												{
													$tob = $toc = 0;

													$b1 = $row2["b1"];
													$b2 = $row2["b2"];

													if($row2["transfer"] == 1)
													{
														$tob = $row2["credit"];
													}
													else
													{
														$toc = $row2["credit"];
													}

													$sql3 = "SELECT * FROM expence_main WHERE id='$b1'";
													$result3 = $conn->query($sql3);
													$row3 = $result3->fetch_assoc();

													$sql4 = "SELECT * FROM expence_main WHERE id='$b2'";
													$result4 = $conn->query($sql4);
													$row4 = $result4->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo date('d-m-Y',strtotime($row2["date"])) ?></center></td>
                                                <td><center>
														QAR
														<?php
															echo number_format($row2["debit"],2);
															if($row2["debit"] != 0)
															{
																echo "<br>".$row3["name"];
															}
														?>
												</center></td>
                                                <td><center>
													QAR
													<?php
														echo number_format($toc,2);
														if($toc != 0)
														{
															echo "<br>".$row3["name"];
														}
													?>
												</center></td>
                                                <td><center>
												QAR
													<?php
														echo number_format($tob,2);
														if($tob != 0)
														{
															echo "<br>".$row3["name"]." - ".$row4["name"];
														}
													?>
												</center></td>
                                                
												<td><center><a href="edit_transfer.php?id=<?php echo $row2['id'];?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
												
												<td><center><a href="delete_transfer.php?id=<?php echo $row2['id'];?>"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td>
												
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
			</div>
		<?php
			}
			?>
		</div>
	</main>
	<!-- <div class="ttr-overlay"></div> -->

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/slick-slider/slick.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap-wysihtml5.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
$('.extra-field-box').each(function() {
	var $wrapp = $('.multi-box', this);
	$(".add-field", $(this)).on('click', function() {
		$('.dublicat-box:first-child', $wrapp).clone(true).appendTo($wrapp).find('input').val('').focus();
	});
	$('.dublicat-box .remove-field', $wrapp).on('click', function() {
		if ($('.dublicat-box', $wrapp).length > 1)
			$(this).parent('.dublicat-box').remove();
		});
	});
</script>
<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
                "iDisplayLength": 15
            });
</script>
<script>
	function change(x)
	{
		if(x == "2")
		{
			document.getElementsByClassName('hide')[1].style.display = 'block';
			document.getElementsByClassName('hide')[0].style.display = 'none';
		}
		else
		{
			if(x == 3)
			{
				document.getElementsByClassName('hide')[1].style.display = 'block';
				document.getElementsByClassName('hide')[0].style.display = 'block';
			}
			else
			{
				document.getElementsByClassName('hide')[1].style.display = 'none';
				document.getElementsByClassName('hide')[0].style.display = 'none';
			}
		}
	}
</script>
</body>
</html>