<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	$user = $_SESSION["user"];
	$date = date("Y-m-d");

    $start_date = $_REQUEST['sdate'];
	$end_date = $_REQUEST['edate'];

	$r = $_REQUEST["r"];
	$s = $_REQUEST["s"];
	$from = $_REQUEST["from"];
	$to = $_REQUEST["to"];

	$start = $end = "";
	$r1 = $r2 = $r3 = $s1 = $s2 = $s3 = $stage = "";

    $type = $_REQUEST["type"];
    $my_division = $_REQUEST["division"];

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

		header("location: all-enquiry_old.php?from=$from&to=$to");
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
												</tr>
												<tr>
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
														if($user == "conserveadmin")
														{
													?>
															<th>Last Updated</th>
													<?php
														}
													?>
												</tr>
											</thead>
											<tbody>
												<?php
													switch ($type) {
                                                        case '1':
                                                            $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Tender' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                            $result1 = $conn->query($sql1);
                                                            $Total_tenders = $result1->num_rows;
                                                            break;
                                                
                                                        case '2':
                                                            $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                            $result1 = $conn->query($sql1);
                                                            $Total_Job_In_Hand = $result1->num_rows;
                                                            break;
                                                
                                                        case '3':
                                                            $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Tender' AND qstatus='NOT SUBMITTED' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                            $result1 = $conn->query($sql1);
                                                            $Not_Total_tenders = $result1->num_rows;
                                                            break;
                                                
                                                        case '4':
                                                            $sql1 = "SELECT * FROM enquiry WHERE rfq='$my_division' AND stage='Job In Hand' AND qstatus='NOT SUBMITTED' AND qdatec BETWEEN '$start_date' AND '$end_date' AND new_status='1'";
                                                            $result1 = $conn->query($sql1);
                                                            $Not_Total_Job_In_Hand = $result1->num_rows;
                                                            break;
                                                    }
													$count = 1;
													while($row1 = $result1->fetch_assoc())
													{
														$id = $row1["id"];
														$scope_id = $row1['scope'];

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

														$sql = "SELECT * FROM scope_list WHERE id='$scope_id'";
														$result = $conn->query($sql);
														if($result->num_rows > 0)
														{
															$row = $result->fetch_assoc();
															$scope = $row["scope"];	
														}
														else
														{
															$sql = "SELECT * FROM scope WHERE eid='$id'";
															$result = $conn->query($sql);
															while($row = $result->fetch_assoc())
															{
																$scope .= $row["scope"].",";
															}
														}
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
		$('#example').DataTable({
			initComplete: function() {
				this.api().columns().every(function() {
					var column = this;
					var select = $('<select class="mymsel" multiple><option value="">Select</option><option value="All">All</option></select>')
					.appendTo($(column.header()).empty())
					.on('change', function() {
						var val = $('option:selected', this).map(function(index, element) {
							return $.fn.dataTable.util.escapeRegex($(element).val());
						})
						if(val.toArray().includes('All')){
							location.reload();
						} else{
							var vals = val.toArray().join('|');
							column.search(vals.length > 0 ? '^(' + vals + ')$' : '', true, false).draw();
						}
					});	

					column.data().unique().sort(function(a, b){return a-b}).each(function(d, j) {
						select.append('<option value="' + d + '">' + d + '</option>')
					});
				});
			},
			dom: '<"dt-buttons"Bf><"clear">lirtp',
			buttons: [
				'excel'
			]	
		});
          
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