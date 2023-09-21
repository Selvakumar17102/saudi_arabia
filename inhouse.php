<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

	$editor = $_SESSION["username"];

	$dateid = $_REQUEST["date"];
	
	if(isset($_POST["submit"]))
	{
		$totcode = count($_POST["code"]);
		$date = $_POST["date"];
		if($totcode < 1)
		{
			echo '<script>alert("Select Account!")</script>';
		}
		else
		{
			for($i=0;$i<$totcode;$i++)
			{
				$sub = $_POST["sub"];
				$code = $_POST["code"][$i];
				$mode = $_POST["mode"][$i];
				$credit = $_POST["credit"][$i];
				$debit = $_POST["debit"][$i];
				$chno = $_POST["chno"][$i];
				$descrip = mysqli_real_escape_string($conn,$_POST["decsrip"][$i]);

				if($sub != "No Sub Account")
				{
					$code = $sub;
				}

				if($mode == "")
				{
					echo '<script>alert("Select mode!")</script>';
				}
				else
				{
					if($credit == "" && $debit == "")
					{
						echo '<script>alert("Enter Any Amount!")</script>';
					}
					else
					{
						
						if($mode == "Cash")
						{
							$sql1 = "SELECT * FROM expence_main WHERE id='1'";
							$result1 = $conn->query($sql1);
							$row1 = $result1->fetch_assoc();
                         
							$cashbalance = $row1["balance"] + $credit - $debit;

							$sql2 = "UPDATE expence_main SET balance='$cashbalance' WHERE id='1'";
							if($conn->query($sql2) === TRUE)
							{
								$sql1 = "INSERT INTO expence_invoice (code,mode,credit,debit,descrip,date,type,chno) VALUES ('$code','$mode','$credit','$debit','$descrip','$date','3','$chno')";
								if($conn->query($sql1) === TRUE)
								{
									header("location: inhouse.php?date=$date&msg=Day Book Updated!");
								}
							}
						}
						else
						{
							$banktype = $_POST["bank"];

							$sql1 = "SELECT * FROM expence_main WHERE id='$banktype'";
							$result1 = $conn->query($sql1);
							$row1 = $result1->fetch_assoc();

							$cashbalance = $row1["balance"] + $credit - $debit;

							$sql2 = "UPDATE expence_main SET balance='$cashbalance' WHERE id='$banktype'";
							if($conn->query($sql2) === TRUE)
							{
								$sql1 = "INSERT INTO expence_invoice (code,mode,credit,debit,descrip,date,type,chno,bank) VALUES ('$code','$mode','$credit','$debit','$descrip','$date','3','$chno','$banktype')";
								if($conn->query($sql1) === TRUE)
								{
									header("location: inhouse.php?date=$date&msg=Day Book Updated!");
								}
							}
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
	<meta name="description" content="Day Book Inhouse | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Day Book Inhouse | Income Expense Manager" />
	<meta property="og:description" content="Day Book Inhouse | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Day Book Inhouse | Income Expense Manager</title>
	
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
	</style>
	<script>
		function datefun()
		{
			$('[type="date"]').prop('max', function(){
				return new Date().toJSON().split('T')[0];
			});
		}
		function bank12(val)
		{
			
			if(val == "Cash")
			{
				document.getElementsByClassName('hide1')[0].style.display = 'none';
				document.getElementsByClassName('hide2')[0].style.display = 'none';
			}
			else
			{
				if(val == "Cheque")
				{
					document.getElementsByClassName('hide1')[0].style.display = 'block';
					document.getElementsByClassName('hide2')[0].style.display = 'block';
				}
				else
				{
					document.getElementsByClassName('hide1')[0].style.display = 'block';
					document.getElementsByClassName('hide2')[0].style.display = 'none';
				}
			}
		}
	</script>

<script>
	function validate()
	{
		
		var code = document.getElementById('code').value;
		var descrip = document.getElementById('descrip').value;
		var mode = document.getElementById('mode').value;
		var debit = document.getElementById('debit').value;
		var credit = document.getElementById('credit').value;

		if (code == "")
		{
			$("#code").css("border", "1px solid red");
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
		if (debit == "" && credit == "")
		{
			$("#credit").css("border", "1px solid red");
			return false;
		}
	}
</script>
	
</head>
<body onload="datefun()">
	
	<?php include("inc/expence_header.php") ?>
		<?php include("inc/sidebar.php") ?>
	
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
							<h4>Day Book : Inhouse Entry</h4>
						</div>
						<div class="widget-inner">
								

								<div class="row">
									<div class="col-5" style="background: #f8f8f8;border-radius:4px;padding:20px;">
									<center><h5 class="m-b30">Day Book</h5></center>
										<form class="edit-profile" action ="inhouse.php" method="post">
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
													$sql2 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE date='$fdate' AND type='3'";
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
													<td><center><a href="inhouse.php?date=<?php echo $fdate ?>" target="_blank"><?php echo date('d-m-Y',strtotime($fdate)) ?></a></center></td>
													<td><center>SAR <?php echo number_format($row2["debit"],2) ?></center></td>
													<td><center>SAR <?php echo number_format($row2["credit"],2) ?></center></td>
																						
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
									<h4>Day Book : Inhouse Entry</h4>
								</div>
								<div class="col-sm-1">
									<a href="inhouse.php" style="color: #fff" class="bg-primary btn">Back</a>
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
										<!-- <div class="extra-field-box" style="margin-bottom:20px;">
											<div class="multi-box">	
												<div class="dublicat-box mrg-bot-40"> -->
													<div class="row">
														<div class="col-md-4 d">
															<label class="col-form-label">Account</label>
															<div>
																<select class="form-control" id="code" name="code[]" onchange="gets(this.value)">
																	<option value selected disabled>Select Account</option>
																	<?php
																		$sql = "SELECT * FROM account WHERE type='3' AND sub='0'";
																		$result = $conn->query($sql);
																		while($row = $result->fetch_assoc())
																		{
																	?>
																			<option value="<?php echo $row["code"] ?>"><?php echo $row["name"] ?></option>
																	<?php
																		}
																	?>
																</select>
															</div>
														</div>
														<div class="col-sm-4 d" id="state-list">
															<label class="col-form-label">Sub Account</label>
															<input type="text" class="form-control" readonly value="Select Main Account">
														</div>
														<div class="col-md-4 d">
															<label class="col-form-label">Mode</label>
															<div>
																<Select class="form-control" id="mode" name="mode[]" onchange="bank12(this.value)">
																	<option value="" readonly>Select Mode</option>
																	<option value="Cash">Cash</option>
																	<option value="Cheque">Cheque</option>
																	<option value="Online Bank">Online Bank</option>
																</Select>
															</div>
														</div>
													</div>
													<div class="row">

														<div class="col-md-2 d hide1">
															<label class="col-form-label">Bank</label>
															<div>
																<Select class="form-control" name="bank">
																	<option value="2">Alinma Bank</option>
																	
																</Select>
															</div>
														</div>
														<div class="col-md-2 d hide2">
															<label class="col-form-label">Cheque No</label>
															<div>
																<Input type="text" class="form-control" id="chno" name="chno[]">
															</div>
														</div>
														<div class="col-md-4 d">
															<label class="col-form-label">Description</label>
															<div>
																<textarea style="height:40px" id="descrip" class="form-control" name="decsrip[]" placeholder="Description"></textarea>
															</div>
														</div>
														<div class="col-md-2 d">
															<label class="col-form-label">Debit</label>
															<div>
																<input class="form-control" id="debit" type="text" name="debit[]" placeholder="Debit">
															</div>
														</div>
														<div class="col-md-2 d">
															<label class="col-form-label">Credit</label>
															<div>
																<input class="form-control" id="credit" type="text" name="credit[]" placeholder="Credit">
															</div>
														</div>
													</div>
													<!-- <button style="margin-top:10px;background: red;color: #fff;" type="button" class="btn remove-field light-gray-btn" ><i class="fa fa-minus" aria-hidden="true"></i></button>
												</div>
											</div>
											<div class="text-right"><button type="button" class="btn add-field theme-btn" style="background: green;color: #fff;"><i class="fa fa-plus" aria-hidden="true"></i></button></div>
										</div> -->
										<center><input type="submit" style="background-color: #134094;color: white;margin-top:40px" value="Submit" class="btn" name="submit" onclick="return validate()"></center>
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
											<th>Account</th>
											<th>Sub Account</th>
											<th>Description</th>
											<th>Mode</th>
											<th>Debit</th>
											<th>Credit</th>
											<th>Action</th>
											
											<!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql2 = "SELECT * FROM expence_invoice WHERE date='$dateid' AND type='3' AND mode!='' ORDER BY id DESC";
                                            $result2 = $conn->query($sql2);
											$count = 1;
											$today = date('Y-m-d');
											$week = date('Y-m-d', strtotime('-7 days'));
                                            while($row2 = $result2->fetch_assoc())
                                            {
												$codes = $row2["code"];

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

												$datemain = date('Y-m-d',strtotime($dateid));
                                        ?>
                                            <tr>
                                                <td><center><?php echo $count++ ?></center></td>
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
												<td><center><?php echo $row2["descrip"] ?></center></td>
                                                <td><center><?php echo $row2["mode"] ?></center></td>
												<?php
                                                 if($row2["debit"]== null)
												{ ?>
													<td><center>SAR 0.00</center></td>
													<?php 
												}
												else{ 
												?>
                                                <td><center>SAR <?php echo number_format($row2["debit"],2) ?></center></td>
												<?php
												}
												?>
												<?php
												if($row2["credit"]== null)
												{ ?>
												<td><center>SAR 0.00</center></td>
												<?php 
												}
												else{ 
												?>

                                                <td><center>SAR <?php echo number_format($row2["credit"],2) ?></center></td>

												<?php
												}
												?>


											<?php
													if($editor == "editor")
													{
											?>
												<td>
													<center>
											<?php
													if(($datemain >= $week) && ($datemain <= $today))
													{
											?>
														<a href="edit-inhouse.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php
													}
													else
													{
											?>
														<a><i class="fa fa-pencil" aria-hidden="true"></i></a>
											<?php
													}
											?>
													</center>
												</td>
											<?php
													}
													else
													{
											?>
													<td>
														<center>
															<a href="edit-inhouse.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
															<a href="delete-inhouse.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
														</center>
													</td>
											<?php
													}
											?>
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
		<?php
			}
			?>
		</div>
	</main>


<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/slick-slider/slick.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap-wysihtml5.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="assets/js/admin.js"></script>
<script>
    function gets(val) 
    {
        $.ajax({
            type: "POST",
            url: "assets/ajax/get-state-ep.php",
            data:'country_ids='+val,
            beforeSend: function() 
            {
                $("#state-list").addClass("loader");
            },
            success: function(data)
            {
                $("#state-list").html(data);  
                $("#state-list").removeClass("loader");
            }
        });
	}
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
</body>
</html>
