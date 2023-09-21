<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$date = date("Y-m-d");

	$r = $_REQUEST["r"];
	$s = $_REQUEST["s"];

	$start = $end = "";
	$r1 = $r2 = $r3 = $s1 = $s2 = $s3 = $stage = "";

	if($r == 1)
	{
		$start = $end = date('Y-m-d');
		$r1 = "SELECTED";
	}
	else
	{
		if($r == 2)
		{
			$start = date('Y-m-d', strtotime('-7 days'));
			$end = date('Y-m-d');
			$r2 = "SELECTED";
		}
		if($r == 3)
		{
			$start = date('Y-m-01');
			$end = date('Y-m-d');
			$r3 = "SELECTED";
		}
	}
	if($s == 1)
	{
		$stage = "Job In Hand";
		$s1 = "selected";
	}
	else
	{
		if($s == 2)
		{
			$stage = "Tender";
			$s2 = "selected";
		}
		if($s == 3)
		{
			$stage = "Training";
			$s3 = "selected";
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
	<meta name="description" content="Enquiry Followup | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Enquiry Followup | Project Management System" />
	<meta property="og:description" content="Enquiry Followup | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Enquiry Followup | Project Management System</title>
	
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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		td{
			text-align: center !important;
		}
		.fa-caret-down:before {
			display: none;
		}
	</style>
	
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
				<div class="row" style="width: 100%">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">Enquiry Followup</h4>
					</div>
					<?php
						if($r != "" || $s != "")
						{
					?>
						<div class="col-sm-1">
							<a href="all-enquiry.php" style="color: #fff" class="bg-primary btn">Back</a>
						</div>
					<?php
						}
					?>
				</div>
			</div>	
			<!-- Card -->
			<div class="row head-count">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="widget-box">
								<div class="widget-inner">
									<div class="row">
										<div class="col-sm-4">
											<label class="col-form-label">Filter By Deadline</label>
											<select onchange="range(this.value)" class="form-control">
												<option value selected disabled>Select Range</option>
												<option <?php echo $r1 ?> value="1">Today</option>
												<option <?php echo $r2 ?> value="2">Within 7 Days</option>
												<option <?php echo $r3 ?> value="3">This Month</option>
											</select>
										</div>
										<div class="col-sm-4">
											<label class="col-form-label">Filter By Stage</label>
											<select onchange="stage(this.value)" class="form-control">
												<option value selected disabled>Select Status</option>
												<option <?php echo $s1 ?> value="1">Job In Hand</option>
												<option <?php echo $s2 ?> value="2">Tender</option>
												<option <?php echo $s3 ?> value="3">Training</option>
											</select>
										</div>
										<div class="col-sm-4">
											<label class="col-form-label">&nbsp</label>
											<a href="selected-enquiry.php?id=5" style="width: 100%" title="View Lapsed Enquiry" class="btn">Lapsed Enquiry</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="example1" class="display" cellspacing="0" width="100%">
                                    <thead>
                                       
                                        <tr>
											<th>S.NO</th>
											<th>RFQ Id</th>
											<th>Project Name</th>
											<th>Project Location</th>
											<th>Enquiry Date</th>
											<th>Stage</th>
											<th>Division</th>
											<th>Scope Of Work</th>
                                            <th>Client Name</th>
                                            <th>Responsibility</th>
											<th>Stage</th>
                                            <th>Enquiry Status</th>
                                            <th>Notes</th>
                                            <th style="color: #C54800">Submission Deadline</th>
											<?php
												if($user == "conserveadmin")
												{
											?>
													<th>Last Updated</th>
											<?php
												}
												if($rowside["id"] != 2)
												{
											?>
													<th>Action</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
											$award = "AWARDED";
											$qstatus = "NOT SUBMITTED";

											if($r != "")
											{
												if($s != "")
												{
													$sql1 = "SELECT * FROM enquiry WHERE pstatus!='$award' AND qstatus='$qstatus' AND stage='$stage' AND qdate BETWEEN '$start' AND '$end' ORDER BY qdate ASC";
												}
												else
												{
													$sql1 = "SELECT * FROM enquiry WHERE pstatus!='$award' AND qstatus='$qstatus' AND qdate BETWEEN '$start' AND '$end' ORDER BY qdate ASC";
												}
											}
											else
											{
												if($s != "")
												{
													$sql1 = "SELECT * FROM enquiry WHERE pstatus!='$award' AND qstatus='$qstatus' AND stage='$stage' ORDER BY qdate ASC";
												}
												else
												{
													$sql1 = "SELECT * FROM enquiry WHERE pstatus!='$award' AND qstatus='$qstatus' ORDER BY qdate ASC";
												}
											}
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{
												$id = $row1["id"];

												$abbr = (explode("-",$row1['rfqid']));

												$sql6 = "SELECT * FROM mod_details WHERE enq_no='$id' AND control='1' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();
												if($row6["update_details"] == 1)
												{
													$s = "Created";
												}
												else
												{
													$s = "Edited";
												}
												$scope = "";

												$sql = "SELECT * FROM scope WHERE eid='$id'";
												$result = $conn->query($sql);
												if($result->num_rows > 0)
												{
													if($result->num_rows == 1){
														$row = $result->fetch_assoc();
														$scope = $row["scope"];
													} else{
														while($row = $result->fetch_assoc())
														{
															$scope .= $row["scope"].",";
														}
													}
												}
												else
												{
													$scope = $row1["scope"];
												}
												$date = strtotime($row1["qdate"]);
												echo '<tr style="background-color:'.$tempcolor.'">';
												echo '<td>'.$count.'</td>';
												echo '<td>'.$row1["rfqid"].'</td>';
												echo '<td>'.$abbr[1].'</td>';
												echo '<td>'.$row1["location"].'</td>';
												echo '<td>'.date('d-m-Y', strtotime($row1["enqdate"])).'</td>';
												echo '<td>'.$row1["stage"].'</td>';
												echo '<td>'.$row1["division"].'</td>';
												echo '<td>'.$row1["scope"].'</td>';
												echo '<td>'.$row1["cname"].'</td>';
												echo '<td>'.$row1["responsibility"].'</td>';
												echo '<td>'.$row1["qstatus"].'</td>';
												echo '<td>'.$row1["stage"].'</td>';
												echo '<td>'.$row1["notes"].'</td>';
												echo '<td>'.date('d-m-Y', $date).'</td>';
												if($user == "conserveadmin")
												{
											?>
													<td><center>
												<?php
														if($row6["user_id"] != "")
														{
															echo $s.' by '.$row6["user_id"].'<br>'.date('d-m-Y | h:i:s a',strtotime($row6["datetime"]));
														}
														else
														{
															echo "-";
														}
												?>
													</center></td>
											<?php	
												}
												if($rowside["id"] != 2)
												{
											?>
												<td>
													<table class="action">
														<tr>

															<td style="border: none;">
															<a href="revision-edit.php?id=<?php echo $row1["id"]; ?>" title="Next">
															<span class="notification-icon dashbg-yellow">
															<i class="fa fa-arrow-right" aria-hidden="true"></i>
															</span>
															</a>
															</td>

															<td style="border: none;">
															<a href="view-enquiry.php?id=<?php echo $row1["id"]; ?>" title="View Enquiry">
															<span class="notification-icon dashbg-green">
															<i class="fa fa-eye" aria-hidden="true"></i>
															</span>
															</a>
															</td>

															<td style="border: none;">
															<a href="edit-enquiry.php?id=<?php echo $row1["id"]; ?>" title="Edit Enquiry">
															<span class="notification-icon dashbg-primary">
															<i class="fa fa-edit" aria-hidden="true"></i>
															</span>
															</a>
															</td>
															
															<td style="border: none;">
															<a href="delete-enquiry.php?id=<?php echo $row1["id"]; ?>" title="Delete Enquiry" onClick="return confirm('Sure to Delete this Enquiry !');">
															<span class="notification-icon dashbg-red">
															<i class="fa fa-trash" aria-hidden="true">
															</i>
															</span>
															</a>
															</td>

														</tr>
													</table>
												</td>
										<?php
												}
												echo '</tr>';
												$count++;
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
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
<script src="assets/js/admin.js"></script>

<script>
 $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
    $('#example1 thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#example1').DataTable( {      
		dom: 'Bfrtip',
        lengthMenu: [
            [ 15, 50, 100, -1 ],
            [ '15 rows', '50 rows', '100 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','excel','print'
        ]
    } );
	
} );
</script>
</body>
</html>