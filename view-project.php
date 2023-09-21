<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$id = $_REQUEST["id"];

	$sql = "SELECT * FROM project WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$eid = $row["eid"];
	$pid = $row["proid"];
	$po = $row["po"];
	$scope = $row["scope"];
	$logo = $row["logo"];
	$enq_id = $row["eid"];
	$s = "";

	if($po == "")
	{
		$po = $row["polink"];
	}

	$sql1 = "SELECT * FROM enquiry WHERE id='$eid'";
	$result1 = $conn->query($sql1);
	$row1 = $result1->fetch_assoc();

	$rfqid = $row1["rfqid"];
	$scope_type = $row1['scope_type'];
	$new_scope = $row1['scope'];
	

	// if($scope_ != "0")
	// {
	// 	$sql2 = "SELECT * FROM scope WHERE id='$scope'";
	// 	$result2 = $conn->query($sql2);
	// 	$row2 = $result2->fetch_assoc();

	// 	$s = $row2["scope"];
	// }
	// else
	// {
	// 	$s = $row1["scope"];
	// }
	// if($scope_type == 1)
	// {
	// 	$sql7 = "SELECT * FROM scope_list WHERE id='$new_scope'";
	// 	$result7 = $conn->query($sql7);
	// 	$row7 = $result7->fetch_assoc();

	// 	$s = $row7['scope'];
	// }else{
	// 	$sql7 = "SELECT * FROM scope WHERE id='$scope'";
	// 	$result7 = $conn->query($sql7);
	// 	$row7 = $result7->fetch_assoc();

	// 	$s = $row7['scope'];
	// }

	// if($scope_type == "0" || $scope_type=="2")
	// {
	// 	$sql2 = "SELECT * FROM scope WHERE id='$scope'";
	// 	$result2 = $conn->query($sql2);
	// 	if($result2->num_rows > 0)
	// 	{
	// 		$row2 = $result2->fetch_assoc();

	// 		$s = $row2["scope"];
	// 	}else{
	// 		$sql4 = "SELECT scope FROM enquiry WHERE id='$enq_id'";
	// 		$result4 = $conn->query($sql4);
	// 		$row4 = $result4->fetch_assoc();

	// 		$s = $row4['scope'];
	// 	}
		
	// }
	// else
	// {
	// 	$sql2 = "SELECT * FROM scope_list WHERE id='$scope'";
	// 	$result2 = $conn->query($sql2);
	// 	$row2 = $result2->fetch_assoc();

	// 	$s = $row2["scope"];
	// }

	if($scope_type == 0)
	{
		// $sql2 = "SELECT * FROM scope WHERE eid='$enq_id'";
		// $result2 = $conn->query($sql2);
		// if($result2->num_rows > 0)
		// {	
		// 	if($result2->num_rows == 1){
		// 		$row2 = $result2->fetch_assoc();
		// 		$s = $row2["scope"];
		// 	} else{
		// 		while($row2 = $result2->fetch_assoc())
		// 		{
		// 			$s .= $row2["scope"].",";
		// 		}
		// 	}
		// }else{
		// 	$s = $row1['scope'];
		// }
		$p_scope = $row["scope"];
		$cs_sql2 = "SELECT * FROM scope WHERE id='$p_scope'";
		$sc_result2 = $conn->query($cs_sql2);
		$cs_row2 = $sc_result2->fetch_assoc();
		$s = $cs_row2["scope"];
	}
	else
	{
		$sql2 = "SELECT * FROM scope_list WHERE id='$new_scope'";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();

		$s = $row2["scope"];
	}
	
	$demo = $cur = 0;
	$sql3 = "SELECT * FROM invoice WHERE pid='$pid'";
	$result3 = $conn->query($sql3);
	if($result3->num_rows > 0)
	{
		while($row3 =  $result3->fetch_assoc())
		{
			$demo += $row3["demo"];
			if($row3["paystatus"] == 2)
			{
				$cur += $row3["current"];
			}
		}
	}
	else
	{
		$sql3 = "SELECT * FROM invoice WHERE rfqid='$rfqid'";
		$result3 = $conn->query($sql3);
		while($row3 =  $result3->fetch_assoc())
		{
			$demo += $row3["demo"];
			if($row3["paystatus"] == 2)
			{
				$cur += $row3["current"];
			}
		}
	}

	$count = 1;
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
	<meta name="description" content="View Project | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="View Project | Project Management System" />
	<meta property="og:description" content="View Project | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>View Project | Project Management System</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
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
				<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">View Project</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>	
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						
						<div class="widget-inner">
						<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
							<form class="edit-profile m-b30" method="post" enctype="multipart/form-data">
								<div class="m-b30">

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">RFQ ID</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $rfqid ?></label>

									</div>
									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Project Id</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row["proid"] ?></label>

										<label class="col-sm-2 col-form-label">Division</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row1["rfq"] ?></label>

									</div>
									
									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Enquiry Date</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo date('d-m-Y',strtotime($row1["enqdate"])) ?></label>

										<label class="col-sm-2 col-form-label">Project Type</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row1["division"] ?></label>
											
									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Project</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row1["name"] ?></label>
										
										<label class="col-sm-2 col-form-label">Client</label>
										<label style="color: black;" class="col-sm-3 col-form-label"><?php echo $row1["cname"] ?></label>
										<div class="col-sm-1">
											<img src="<?php echo $logo ?>">
										</div>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Scope</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $s ?></label>

										<label class="col-sm-2 col-form-label">Responsibility</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row1["responsibility"] ?></label>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Submitted Date</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo date('d-m-Y',strtotime($row1["qdate"])) ?></label>

										<label class="col-sm-2 col-form-label">Awarded Date</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo date('d-m-Y',strtotime($row1["qdatec"])) ?></label>

									</div>

									<?php

										$rfqid = $row1["rfqid"];
										$rfqid1 = substr($rfqid, 0, -3);
										$sql2 = "SELECT * FROM client WHERE rfqid LIKE '$rfqid1%'";
										$result2 = $conn->query($sql2);
										while($row2 = $result2->fetch_assoc())
										{

									?>
									<div style="border: 1px solid #BD9C18;border-radius:6px;padding:10px;margin-top:20px;margin-bottom:10px;">

										<div class="form-group row">
												
											<label class="col-sm-2 col-form-label">Contact Person</label>
											<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row2["cp"] ?></label>

											<label class="col-sm-2 col-form-label">Designation</label>
											<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row2["cpd"] ?></label>

										</div>

										<div class="form-group row">
												
											<label class="col-sm-2 col-form-label">Contact Number</label>
											<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row2["pn"] ?></label>

											<label class="col-sm-2 col-form-label">Address</label>
											<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row2["add1"] ?></label>
											<!-- <label class="col-sm-2 col-form-label">Landline Number</label>
											<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row2["ln"] ?></label> -->

										</div>

										<div class="form-group row">
												
											<label class="col-sm-2 col-form-label">Email Id</label>
											<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row2["email"] ?></label>

										</div>

									</div>

									<?php

										}

									?>

									<?php

										if($row["pterms"] == 1)
										{
											$temp = "MileStone";
										}
										if($row["pterms"] == 2)
										{
											$temp = "Monthly";
										}
										if($row["pterms"] == 3)
										{
											$temp = "Prorata";
										}
									?>
										
									<div class="form-group row">

										<!-- <label class="col-sm-2 col-form-label">Project Division</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row["subdivi"] ?></label> -->

										<label class="col-sm-2 col-form-label">Payment Terms</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $temp ?></label>

										<label class="col-sm-2 col-form-label">PO Value</label>
										<label style="color: black;" class="col-sm-4 col-form-label">SAR <?php echo number_format($row["value"],2) ?></label>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label de">Number of Dues</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row["noofm"] ?></label>

										<label class="col-sm-2 col-form-label">VAT Value</label>
										<label style="color: black;" class="col-sm-4 col-form-label">SAR <?php echo number_format($row["gst_value"],2) ?></label>

									</div>

									<div class="form-group row">

										<label class="col-sm-2 col-form-label">Status</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row["status"] ?></label>
										
										<label class="col-sm-2 col-form-label">Final Quotation</label>
										<label style="color: black;" class="col-sm-4 col-form-label">
											<?php
												$finalq = $row["finalq"];

												if($finalq != "" && $finalq != "-")
												{
											?>
												<a href="<?php echo $finalq ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
											<?php
												}
												else
												{
													echo "-";
												}
											?>
										</label>
										
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label de">Payment due days</label>
										<label style="color: black;" class="col-sm-4 col-form-label"><?php echo $row["invdues"] ?></label>
										
									</div>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row m-b30">
				<div class="col-sm-12">
					<div class="widget-box">
						<div class="card-header">
							<center><h4>Communication Details</h4></center>
						</div>
						<div class="widget-inner">
							<div class="table-responsive col-lg-12">
								<table id="dataTableExample3" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Ref.No</th>
											<th>Link</th>
											<?php
														if($user == "conserveadmin" OR $user == "venkat")
														{
													?>
											<th>Last Updated</th>
											<?php
														}
													?>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql5 = "SELECT * FROM commu WHERE pid='$id'";
											$result5 = $conn->query($sql5);
											$counter = 1;
											while($row5 = $result5->fetch_assoc())
											{
												$cid = $row5["id"];

												$sql6 = "SELECT * FROM mod_details WHERE comu='$cid' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();
										?>
												<tr>
													<td><center><?php echo $counter++ ?></center></td>
													<td><center><?php echo $row5["comrefno"] ?></center></td>
													<td><center><a href="<?php echo $row5["comlink"] ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a></center></td>
													<?php
														if($user == "conserveadmin" OR $user == "venkat")
														{
													?>
													<td><center>
                                                    <?php 
                                                        if($row6["user_id"] != "")
                                                        {
                                                            echo date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.$row6["user_id"]; 
                                                        }
                                                        else
                                                        {
                                                            echo "-";
                                                        }
                                                    ?></center></td>
													<?php
														}
													?>
													<td><center><a href="edit-commu.php?id=<?php echo $row5["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
													<td><center><a href="delete-commu.php?id=<?php echo $row5["id"] ?>" onClick="return confirm('Sure to Delete!');"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td>
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
			<div class="row m-b30">
				<div class="col-sm-12">
					<div class="widget-box">
						<div class="card-header">
							<center><h4>PO Details</h4></center>
						</div>
						<div class="widget-inner">
							<div class="table-responsive col-lg-12">
								<table id="dataTableExample1" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Po Ref.No</th>
											<th>Po Link</th>
											<?php
												if($user == "conserveadmin" OR $user == "venkat")
												{
											?>	
											<th>Last Updated</th>
											<?php
												}
											?>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql4 = "SELECT * FROM poss WHERE pid='$id'";
											$result4 = $conn->query($sql4);
											$counter = 1;
											while($row4 = $result4->fetch_assoc())
											{
												$cid = $row4["id"];

												$sql6 = "SELECT * FROM mod_details WHERE po='$cid' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();
										?>
												<tr>
													<td><center><?php echo $counter++ ?></center></td>
													<td><center><?php echo $row4["po"] ?></center></td>
													<td><center><a href="<?php echo $row4["polink"] ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a></center></td>
													<?php
														if($user == "conserveadmin" OR $user == "venkat")
														{
													?>
													<td><center>
                                                    <?php 
                                                        if($row6["user_id"] != "")
                                                        {
                                                            echo date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.$row6["user_id"]; 
                                                        }
                                                        else
                                                        {
                                                            echo "-";
                                                        }
                                                    ?></center></td>
													<?php
														}
													?>
													<td><center><a href="edit-po.php?id=<?php echo $row4["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
													<td><center><a href="delete-po.php?id=<?php echo $row4["id"] ?>" onClick="return confirm('Sure to Delete this PO!');"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td>
												</tr>
										<?php
											}
											if($row["po"] != "")
											{
										?>
												<tr>
													<td><center><?php echo $counter++ ?></center></td>
													<td><center><?php echo $row["po"] ?></center></td>
													<td><center><a href="<?php echo $row["polink"] ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a></center></td>
													<td><center><a href="edit-po.php?m=1&id=<?php echo $row["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></center></td>
													<td><center><a href="delete-po.php?m=1&id=<?php echo $row["id"] ?>" onClick="return confirm('Sure to Delete this PO!');"><i class="fa fa-trash" aria-hidden="true"></i></a></center></td>
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
			<div class="row">
                <div class="col-sm-12 m-b30">
                    	<?php
							$sql = "SELECT * FROM invoice WHERE pid='$pid' AND (demo!='0' OR current!='0') AND subdate!='' ORDER BY date ASC";
							$result = $conn->query($sql);
							if($result->num_rows > 0)
							{
						?>
						<h4><center>Invoice Details</center></h4>
						<div class="widget-box" style="height: auto !important">
							<div class="card-header">
								<div class="row">
									<div class="col-sm-6">
										<label class="col-form-label">Total Invoiced value : SAR <?php echo number_format($demo,2) ?></label>
									</div>
									<div class="col-sm-6">
										<label class="col-form-label float-right">Total Recieved value : SAR <?php echo number_format($cur,2) ?></label>
									</div>
								</div>
							</div>
							<div class="widget-inner">
								<div class="table-responsive">
									<table id="dataTableExample2" class="table table-striped">
										<thead>
											<tr>
												<th>S.NO</th>
												<th>Invoice Id</th>
											<?php
												if($row1["pterms"] == 2)
												{
													echo '<th>Month</th>';
												}
												if($row1["pterms"] == 1)
												{
													echo '<th>Percentage</th>';
												}
											?>
												<th>Invoiced Value</th>	
												<th>Invoiced VAT</th>	
												<th>Invoiced Date</th>										
												<th>Recieved Value</th>											
												<th>Recieved VAT</th>											
												<!-- <th>Recieved Value</th>											 -->
												<th>Recieved Date</th>
												<th>Mode</th>
												<th>Remarks</th>
												<?php
														if($user == "conserveadmin" OR $user == "venkat")
														{
													?>
												<th>Last Updated</th>
												<?php
														}
													?>
												<th>View Invoice</th>
												<th>Cheque / Bank Transfer</th>
											</tr>
										</thead>
										<tbody>

							<?php
									while($row = $result->fetch_assoc())
									{
										$cid = $row["id"];

										$sql6 = "SELECT * FROM mod_details WHERE inv_no='$cid' ORDER BY id DESC LIMIT 1";
										$result6 = $conn->query($sql6);
										$row6 = $result6->fetch_assoc();
							?>
											<tr>
												<td><center><?php echo $count ?></center></td>
												<td><center><?php echo $row["invid"] ?></center></td>
											<?php
												if($row1["pterms"] == 2)
												{
													$test = date('F',strtotime($row["date"]));
													echo '<td><center>'.$test.'</center></td>';
												}
												if($row1["pterms"] == 1)
												{
													echo '<td><center>'.$row["percent"].'%</center></td>';
												}
												if($row["paystatus"] == 2)
												{
													$a1 = number_format($row["current"],2);
													$a2 = date('d-m-Y',strtotime($row["recdate"]));
													$a3 = $row["mode"];
													$a4 = $row["remarks"];
												}
												else
												{
													$a1 = $a2 = $a3 = $a4 = "-";
												}
												if($row["bank"] == "")
												{
													if($row["refdoc"] == "")
													{
														$a7 = "-";
													}
													else
													{
														$a7 = '<a href="'.$row["refdoc"].'" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>';
													}
												}
												else
												{
													$a7 = '<a href="'.$row["bank"].'" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>';
												}
												$a5 = '<a href="'.$row["invdoc"].'" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>';
												$a6 = '<a href="'.$po.'" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>';
											?>
												<td><center>SAR <?php echo number_format($row["demo"],2) ?></center></td>
												<td><center>SAR <?php echo number_format($row["demo_gst"],2) ?></center></td>
												<td><center><?php echo date('d-m-Y',strtotime($row["date"])) ?></center></td>
												<td><center>SAR <?php echo $a1 ?></center></td>
												<td><center>SAR <?php echo number_format($row["current_gst"],2) ?></center></td>
												<td><center><?php echo $a2 ?></center></td>
												<td><center><?php echo $a3 ?></center></td>
												<td><center><?php echo $a4 ?></center></td>
												<?php
														if($user == "conserveadmin" OR $user == "venkat")
														{
													?>
												<td><center>
												<?php
													if($row6["user_id"] != "")
													{
														echo date('d-m-Y | h:i:s a',strtotime($row6["datetime"])).'<br>'.$row6["user_id"].'<br>'.rtrim($row6["content"], ", "); 
													}
													else
													{
														echo "-";
													}
												?></center></td>
												<?php
														}
													?>
												<td><center><?php echo $a5 ?></center></td>
												<td><center><?php echo $a7 ?></center></td>
											</tr>

							<?php
										$count++;
									}
							}
							else
							{
								$sql = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND current!='0' AND paystatus='2' AND subdate!='' ORDER BY recdate DESC";
								$result = $conn->query($sql);
								$count = 1;
								if($result->num_rows > 0)
								{
							?>
						<center><h4>Invoice Details</h4></center>
						<div class="widget-box">
							<div class="card-header">
								<div class="row">
									<div class="col-sm-6">
										<label class="col-form-label">Total Invoiced value : SAR <?php echo number_format($demo,2) ?></label>
									</div>
									<div class="col-sm-6">
										<label class="col-form-label float-right">Total Recieved value : SAR <?php echo number_format($cur,2) ?></label>
									</div>
								</div>
							</div>
							<div class="widget-inner">
								<div class="table-responsive">
									<table id="dataTableExample1" class="table table-striped">
										<thead>
											<tr>
												<th>S.NO</th>
												<th>Invoice Id</th>
											<?php
												if($row1["pterms"] == 2)
												{
													echo '<th>Month</th>';
												}
												if($row1["pterms"] == 1)
												{
													echo '<th>Percentage</th>';
												}
											?>
												<th>Invoiced Value</th>											
												<th>Recieved Value</th>											
												<th>Recieved Date</th>
												<th>Mode</th>
												<th>Remarks</th>
												<th>View Invoice</th>
												<th>View PO</th>
											</tr>
										</thead>
										<tbody>

							<?php
									while($row = $result->fetch_assoc())
									{

							?>
											<tr>
												<td><center><?php echo $count ?></center></td>
												<td><center><?php echo $row["invid"] ?></center></td>
											<?php
												if($row1["pterms"] == 2)
												{
													$test = date('F',strtotime($row["date"]));
													echo '<td><center>'.$test.'</center></td>';
												}
												if($row1["pterms"] == 1)
												{
													echo '<td><center>'.$row["percent"].'%</center></td>';
												}
											?>
												<td><center>SAR <?php echo number_format($row["demo"],2) ?></center></td>
												<td><center>SAR <?php echo number_format($row["current"],2) ?></center></td>
												<td><center><?php echo date('d-m-Y',strtotime($row["recdate"])) ?></center></td>
												<td><center><?php echo $row["mode"] ?></center></td>
												<td><center><?php echo $row["remarks"] ?></center></td>
												<td><center><a href="<?php echo $row["invdoc"] ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a></center></td>
												<td><center><a href="<?php echo $po ?>" target="_blank"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a></center></td>
											</tr>

							<?php
										$count++;
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
			</div>
			<?php
				if($user == "conserveadmin" OR $user == "venkat")
				{
			?>
			<div class="row m-b30">
				<div class="col-sm-12">
					<h4><center>History</center></h4>
					<div class="widget-box" style="height: auto !important">
						<div class="widget-inner">
							<div class="table-responsive">
								<table id="dataTableExample4" class="table table-striped">
									<thead>
										<tr>
											<th><center>S.No</center></th>
											<th><center>Content</center></th>
											<th><center>Description</center></th>
											<th><center>User</center></th>
											<th><center>Time</center></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM mod_details WHERE po_no='$id' ORDER BY id DESC";
											$result = $conn->query($sql);
											$count = 1;
											while($row = $result->fetch_assoc())
											{
												$desc = "";
												if($row["update_details"] == 1)
												{
													$desc = "Created";
												}
												else if($row["update_details"] == 3)
												{
													$desc = "Deleted";
												}
												else
												{
													$desc = "Modified";
												}

												if($row["content"] != "")
												{
													$desc .= "<br>".rtrim($row["content"], ", ");
												}

												if($row["control"] != 1)
												{
													if($row["control"] == 3)
													{
														$s = "Project";
													}
													else
													{
														if($row["control"] == 4)
														{
															$s = "Invoice";
														}
														else
														{
															if($row["control"] == 5)
															{
																$s = "PO";
															}
															else
															{
																$s = "Communication";
															}
														}
													}
										?>
													<tr>
														<td><center><?php echo $count++ ?></center></td>
														<td><center><?php echo $s ?></center></td>
														<td><center><?php echo $desc ?></center></td>
														<td><center><?php echo $row["user_id"] ?></center></td>
														<td><center><?php echo date('d-m-Y | h:i:s A',strtotime($row["datetime"])) ?></center></td>
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
			<?php } ?>
		</div>
	</main>
	<div class="ttr-overlay"></div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="assets/vendors/datatables/dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
	<script src="assets/js/admin.js"></script>
	<script>
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
            $('#dataTableExample2').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
			$('#dataTableExample3').DataTable({
                dom: 'Bfrtip',
				lengthMenu: [
					[ 15, 50, 100, -1 ],
					[ '15 rows', '50 rows', '100 rows', 'Show all' ]
				],
				buttons: [
					'pageLength','excel','print'
				]
            });
			$('#dataTableExample4').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [6, 25, 50, -1],
                    [6, 25, 50, "All"]
                ],
                "iDisplayLength": 6
            });
	</script>

</body>
</html>