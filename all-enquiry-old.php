<?php
	session_start();
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$control = $_SESSION["control"];

	$date = date("Y-m-d");

	$r = $_REQUEST["r"];
	$s = $_REQUEST["s"];
	$from = $_REQUEST["from"];
	$to = $_REQUEST["to"];

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
		if($r == 4)
		{
			$r4 = "SELECTED";
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
	if(isset($_POST['search']))
	{
		$from = $_POST['from'];
		$to = $_POST['to'];

		header("location: all-enquiry-old.php?from=$from&to=$to");
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
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		.wrapper1{
			width: 1300px;
			overflow-x: scroll;
			overflow-y:hidden;
		}

		.wrapper1 {height: 20px; }

		.div1 {
			width:2600px;
			height: 20px;
		}
		.dt-buttons{
			float:right !important;
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
					<form action="" method="post">
						<div class="row">
							<div class="col-sm-12">
								<div class="widget-box">
									<div class="widget-inner">
										<div class="row">
											<!-- <div class="col-sm-4">
												<label class="col-form-label">Filter By Deadline</label>
												<select onchange="range(this.value)" class="form-control">
													<option value selected disabled>Select Range</option>
													<option <?php echo $r1 ?> value="1">Today</option>
													<option <?php echo $r2 ?> value="2">Within 7 Days</option>
													<option <?php echo $r3 ?> value="3">This Month</option>
													<option <?php echo $r4 ?> value="4">All</option>
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
											</div> -->
											<div class="col-sm-4">
												<input type="date" name="from" id="" class="form-control" required>
											</div>
											<div class="col-sm-4">
												<input type="date" name="to" id="" class="form-control" required>
											</div>
											<div class="col-sm-4">
												<input type="submit" value="search" class="form-control btn btn-success" name="search">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>

			</div>

			<div class="row">
			
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">
						<div class="wrapper1">
							<div class="div1"></div>
						</div>
						<!-- <div class="">
							<div class=""> -->
								<div class="card-content">
									<div class="table-responsive wrapper2">
										<table id="example" class="display div2" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>S.NO</th>
													<th>Enquiry Date</th>
													<th>RFQ Id</th>
													<th>Project Name</th>
													<th>Client Name</th>
													<th>Responsibility</th>
													<th>Scope</th>
													<th>Stage</th>
													<th>Project Type</th>
													<th>Enquiry Status</th>
													<th style="color: #C54800">Submission Deadline</th>
													<?php
														if($user == "conserveadmin")
														{
													?>
															<th>Last Updated</th>
													<?php
														}
													?>	
													<th>Action</th>
													
												</tr>
												<!-- <tr>
													<th>S.NO</th>
													<th>Enquiry Date</th>
													<th>RFQ Id</th>
													<th>Project Name</th>
													<th>Client Name</th>
													<th>Responsibility</th>
													<th>Scope</th>
													<th>Stage</th>
													<th>Division</th>
													<th>Enquiry Status</th>
													<th style="color: #C54800">Submission Deadline</th>
													<?php
														if($user == "conserveadmin" OR $user == "venkat")
														{
													?>
															<th>Last Updated</th>
													<?php
														}
														
													?>
													<th>Action</th>
												</tr> -->
											</thead>
											<tbody>
												<?php
													$award = "AWARDED";
													$qstatus = "NOT SUBMITTED";

													if($from!="" && $to!="")
													{
														$sql1 = "SELECT * FROM enquiry WHERE enqdate BETWEEN '$from' AND '$to' AND pstatus!='$award' AND qstatus='NOT SUBMITTED' AND new_status='1' ORDER BY enqdate DESC";
													}else{
														$sql1 = "SELECT * FROM enquiry WHERE pstatus!='$award' AND new_status='1' AND qstatus='NOT SUBMITTED' ORDER BY enqdate DESC";
													}
													$result1 = $conn->query($sql1);
													$count = 1;
													while($row1 = $result1->fetch_assoc())
													{
														$id = $row1["id"];
														$scope_id = $row1['scope'];
														$scope_type = $row1['scope_type'];

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

														if($scope_type == 1)
														{
															$sql = "SELECT * FROM scope_list WHERE id='$scope_id'";
															$result = $conn->query($sql);
															if($result->num_rows > 0)
															{
																$row = $result->fetch_assoc();
																$scope = $row["scope"];	
															}
														}														
														else
														{
															$sql = "SELECT * FROM scope WHERE eid='$id'";
															$result = $conn->query($sql);
															if($result->num_rows > 0)
															{
																while($row = $result->fetch_assoc())
																{
																	$scope .= $row["scope"].",";
																}
															}else{
																$scope = $row1['scope'];
															}
														}
														
														$scope = rtrim($scope, ',');

														$date = strtotime($row1["qdate"]);

														echo '<tr style="background-color:'.$tempcolor.'">';
														echo '<td>'.$count.'</td>';
														echo '<td>'.date('d-m-Y', strtotime($row1['enqdate'])).'</td>';
														echo '<td>'.$row1["rfqid"].'</td>';
														echo '<td><a href="view-enquiry.php?id='.$row1["id"].'">'.$row1["name"].'</a></center></td>';
														echo '<td>'.$row1["cname"].'</td>';
														echo '<td>'.$row1["responsibility"].'</td>';
														echo '<td>'.$scope.'</td>';
														echo '<td>'.$row1["stage"].'</td>';
														echo '<td>'.$row1["division"].'</td>';
														echo '<td>'.$row1["qstatus"].'</td>';
														echo '<td>'.date('d-m-Y', $date).'</td>';
														if($user == "conserveadmin" OR $user == "venkat")
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
														// if($rowside["id"] != 2)
														// {
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

																	<?php
																		if($control == "1" || $control == "3")
																		{
																			?>
																				<td style="border: none;">
																					<a href="edit-enquiry.php?id=<?php echo $row1["id"]; ?>" title="Edit Enquiry">
																					<span class="notification-icon dashbg-primary">
																					<i class="fa fa-edit" aria-hidden="true"></i>
																					</span>
																					</a>
																				</td>			
																			<?php
																		}
																	?>
																	
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
														// }
														echo '</tr>';
														$count++;
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							<!-- </div>
						</div> -->
                    </div>
                </div>		
			</div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
<script src='assets/vendors/calendar/moment.min.js'></script>
<script src='assets/vendors/calendar/fullcalendar.js'></script>
<script>
// Start of jquery datatable
	$(document).ready(function() {
		// $('#example').DataTable({
		// 	initComplete: function() {
		// 		this.api().columns().every(function() {
		// 			var column = this;
		// 			var select = $('<select class="mymsel" multiple><option value="">Select</option><option value="All">All</option></select>')
		// 			.appendTo($(column.header()).empty())
		// 			.on('change', function() {
		// 				var val = $('option:selected', this).map(function(index, element) {
		// 					return $.fn.dataTable.util.escapeRegex($(element).val());
		// 				})
		// 				if(val.toArray().includes('All')){
		// 					location.reload();
		// 				} else{
		// 					var vals = val.toArray().join('|');
		// 					column.search(vals.length > 0 ? '^(' + vals + ')$' : '', true, false).draw();
		// 				}
		// 			});	

		// 			column.data().unique().sort(function(a, b){return a-b}).each(function(d, j) {
		// 				select.append('<option value="' + d + '">' + d + '</option>')
		// 			});
		// 		});
		// 	},
		// 	dom: '<"dt-buttons"Bf><"clear">lirtp',
		// 	buttons: [
		// 		'excel'
		// 	]	
		// });
		$('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
    } );
          
	});
</script>
<script>
	function range(val)
	{
		<?php
			if($s != "")
			{
		?>
			location.replace("http://www.conserveacademy.com/projectmgmttool/new/all-enquiry_old.php?r="+val+"<?php echo '&s='.$s ?>");
		<?php
			}
			 else if($r == "4"){
			 	location.replace("http://www.conserveacademy.com/projectmgmttool/new/all-enquiry_old.php");
			 }
			else
			{
		?>
			 location.replace("http://www.conserveacademy.com/projectmgmttool/new/all-enquiry_old.php?r="+val);
		<?php		
			}
		?>
	}
	function stage(val)
	{
		<?php
			if($r != "")
			{
		?>
			 location.replace("http://www.conserveacademy.com/projectmgmttool/new/all-enquiry_old.php?s="+val+"<?php echo '&r='.$r ?>");
		<?php
			}
			else
			{
		?>
			 location.replace("http://www.conserveacademy.com/projectmgmttool/new/all-enquiry_old.php?s="+val);
		<?php		
			}
		?>
	}
</script>
<script>
	$(function(){
		$(".wrapper1").scroll(function(){
			$(".wrapper2").scrollLeft($(".wrapper1").scrollLeft());
		});
		$(".wrapper2").scroll(function(){
			$(".wrapper1").scrollLeft($(".wrapper2").scrollLeft());
		});
	});
</script>
</body>
</html>