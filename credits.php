<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("inc/session.php");

    $dateid = $_REQUEST["date"];
    
    if(isset($_POST["submit"]))
    {
        $code = $_POST["code"];
        $date = $_POST["date"];
        $sub = $_POST["sub"];
        $divi = $_POST["divi"];
        $invno = $_POST["invno"];
        $credit = $_POST["credit"];
        $descrip = mysqli_real_escape_string($conn,$_POST["descrip"]);

        if($sub != "No Sub Account")
		{
			$code = $sub;
        }
        
        $sql1 = "INSERT INTO credits (code,date,amount,descrip,invno,divi) VALUES ('$code','$date','$credit','$descrip','$invno','$divi')";
        if($conn->query($sql1) === TRUE)
        {
            header("location: credits.php?date=$date&msg=Day Book Updated!");
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
	<meta name="description" content="Day Book Credits | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Day Book Credits | Income Expense Manager" />
	<meta property="og:description" content="Day Book Credits | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Day Book Credits | Income Expense Manager</title>
	
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

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	

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
			}
			else
			{
				document.getElementsByClassName('hide1')[0].style.display = 'block';
			}
		}
	</script>

<script>
	function validate()
	{
		
		var code = document.getElementById('code').value;
		var credit=document.getElementById('credit').value;
		
		if (code == "")
		{
			$("#code").css("border", "1px solid red");
			return false;
		}
		if (credit == "")
		{
			$("#credit").css("border", "1px solid red");
			return false;
		}
	}
</script>
	
</head>
<body onload="datefun()">
	
	<?php include("inc/expence_header.php") ?>
	
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
							<h4>Day Book : Credits Entry</h4>
						</div>
						<div class="widget-inner">
								
								<div class="row">
                                    <div class="col-3"></div>
									<div class="col-6" style="background: #f8f8f8;border-radius:4px;padding:20px;">
									<center><h5 class="m-b30">Day Book</h5></center>
										<form class="edit-profile" method="post">
											<div class="row">
												<div class="col-sm-8">
													<label class="col-form-label">Select Date</label>
													<input class="form-control" type="date" id="sdate" name="date" value="<?php echo date('Y-m-d') ?>" required>
												</div>
												<div class="col-sm-4" style="margin-top: 23px">
													<button type="submit" class="btn btn-primary" name="choose"><i class="fa fa-arrow-right"></i></button>
												</div>
											</div>
										</form>
									</div>
                                    <div class="col-3"></div>
								</div>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
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
									<h4>Day Book : Credits Entry</h4>
								</div>
								<div class="col-sm-1">
									<a href="credits.php" style="color: #fff" class="bg-primary btn">Back</a>
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
										<div class="row" style="margin-bottom:10px">
											<div class="col-sm-4 d">
												<label class="col-form-label">Main Account</label>
												<div>
													<select class="form-control" id="code" name="code" onchange="gets(this.value)">
														<option value selected disabled>Select Account</option>
														<?php
															$sql = "SELECT * FROM account WHERE type='2' AND sub='0' ORDER BY name ASC";
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
											<div class="col-sm-4 d">
												<label class="col-form-label">Division</label>
												<div>
													<select class="form-control" name="divi">
														<option value selected disabled>Select Division</option>
														<?php
															$sql = "SELECT * FROM division ORDER BY division ASC";
															
															$result = $conn->query($sql);
															while($row = $result->fetch_assoc())
															{
														?>
																<option value="<?php echo $row["id"] ?>"><?php echo $row["division"] ?></option>
														<?php
															}
														?>
													</select>
												</div>
											</div>
										</div>
										
										<div class="row d" style="margin-bottom:10px">
											<div class="col-md-4 d">
												<label class="col-form-label">Description</label>
												<div>
													<textarea style="height:40px" id="descrip" class="form-control" name="descrip" placeholder="Description"></textarea>
												</div>
											</div>
											<div class="col-md-4 d">
												<label class="col-form-label">Invoice Number</label>
												<div>
													<input class="form-control" type="text" name="invno" placeholder="Invoice Number">
												</div>
											</div>
											<div class="col-md-4 d">
												<label class="col-form-label">Amount</label>
												<div>
													<input class="form-control" id="credit" type="text" name="credit" placeholder="Amount">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-10"></div>
											<div class="col-sm-2">
												<input type="submit" style="background-color: #134094;color: white" value="Submit" class="btn" name="submit" onclick="return validate()">
											</div>
										</div>
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
                    <div class="widget-box">

                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Main Account</th>
											<th>Sub Account</th>
											<th>Division</th>
											<th>Invoice Number</th>
											<th>Value</th>
											<th>Action</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql2 = "SELECT * FROM credits WHERE date='$dateid' ORDER BY id DESC";
                                            $result2 = $conn->query($sql2);
                                            $count = 1;
                                            while($row2 = $result2->fetch_assoc())
                                            {
												$date = $row2['date'];
												$codes = $row2["code"];
												$divistion_id = $row2['divi'];

												$sql3 = "SELECT * FROM account WHERE code='$codes'";
												$result3 = $conn->query($sql3);
												$row3 = $result3->fetch_assoc();

												$sub1 = $row3["sub"];

												$sql5 = "SELECT * FROM division WHERE id='$divistion_id'";
												$result5 = $conn->query($sql5);
												$row5 = $result5->fetch_assoc();
												{
													$divistion_name = $row5['name'];
												}

												if($sub1 == 0)
												{
										?>
											<tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row3["name"] ?></center></td>
                                                <td><center> - </center></td>
                                                <td><center><?php echo $divistion_name;?> </center></td>
                                                <td><center><?php echo $row2["invno"] ?></center></td>
                                                <td><center>SAR <?php echo number_format($row2["amount"],2) ?></center></td>
                                                <td>
													<center>
														<table style="margin-bottom: 0px">
															<tr>
																<td><center><a href="edit-credit.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
																<td><center><a onClick="return confirm('Sure to Delete this Credit!')" href="delete-credit.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td>
															</tr>
														</table>
													</center>
												</td>
                                                
												<!--  <td><center><a style="padding:10px" href="view-project.php?"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td> -->
                                            </tr>
										<?php
												}
												else
												{
													$sql4 = "SELECT * FROM account WHERE id='$sub1'";
													$result4 = $conn->query($sql4);
													$row4 = $result4->fetch_assoc();
										?>
											<tr>
                                                <td><center><?php echo $count++ ?></center></td>
                                                <td><center><?php echo $row4["name"] ?></center></td>
                                                <td><center><?php echo $row3["name"] ?></center></td>
												<td><center><?php echo $divistion_name;?> </center></td>
                                                <td><center><?php echo $row2["invno"] ?></center></td>
                                                <td><center>SAR <?php echo number_format($row2["amount"],2) ?></center></td>												
                                                <td>
													<center>
														<table style="margin-bottom: 0px">
															<tr>
																<td><center><a href="edit-credit.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
																<td><center><a onClick="return confirm('Sure to Delete this Credit!')" href="delete-credit.php?id=<?php echo $row2["id"] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td>
															</tr>
														</table>
													</center>
												</td>
												<!--  <td><center><a style="padding:10px" href="view-project.php?"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td> -->
                                            </tr>
										<?php
												}
                                        ?>
                                            
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
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
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