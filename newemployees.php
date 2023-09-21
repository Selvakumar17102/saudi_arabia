<?php
ini_set('display_errors', 'off');
include("session.php");
include("inc/dbconn.php");

if (isset($_POST['save_select'])) {

	$name 			= $_POST['name'];
	$username 		= $_POST['username'];
	$password 		= $_POST['password'];
	$designation 	= $_POST['designation'];
	$email 			= $_POST['email']; 
	$responsibility = $_POST['responsibility'];
	$responsibility = $_POST['responsibility'];
	$location = "saudi-arabia";
	$sql = "INSERT INTO login (  name, username, password, designation, email, responsibility, location ) VALUES ('$name','$username', '$password', '$designation', '$email', '$responsibility','$location')";
	$result = mysqli_query($conn, $sql);
	if ($result == true) {
		echo "Register successfully";
	} else {
		echo "user not successful";
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
	<meta name="description" content="Proposal Followup | Project Management System" />
	<!-- OG -->
	<meta property="og:title" content="Proposal Followup | Project Management System" />
	<meta property="og:description" content="Proposal Followup | Project Management System" />
	<meta property=" og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	<!-- PAGE TITLE HERE ============================================= -->
	<title>New Employees Followup | Project Management System</title>
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
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
</head>
<body class="ttr-pinned-sidebar">
	<!-- header start -->
	<?php include_once("inc/header.php"); ?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php"); ?>
	<!-- Left sidebar menu end -->
	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
				<div class="row" style="width: 100%">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">New Employee </h4>
					</div>
				</div>
			</div>

			<div class="row m-t10">
				<div class="col-sm-12">
					<div class="widget-box">
						<div class="widget-inner">
							<form action="" method="post" role="form" autocomplete = "off">

								<div class="row">
									<div class="col-sm-6">
										<label class="col-form-label">Name</label>
										<input name="name" type="name" placeholder="Name" class="form-control" required>
									</div>
									<div class="col-sm-6">
										<label class="col-form-label">Designation</label>
										<select class="form-control" name="designation"  required>
											<option selected value disabled>Select Designation</option>}
											<option value="1">Directors/ Leader Team</option>
											<option value="2">Domain Leads</option>
											<option value="3">Admin and accounts</option>
											<option value="4">Finance</option>
											<option value="5">Business Development</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<label class="col-form-label">Username</label>
										<input name="username" type="username" placeholder="Username" class="form-control" required>
									</div>
									<div class="col-sm-6">
										<label class="col-form-label">Password</label>
										<input name="password" type="password" placeholder="Password" class="form-control" required>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<label class="col-form-label">Email</label>
										<input name="email" type="email" placeholder="Email" class="form-control" required>
									</div>
									<div class="col-sm-6">
										<label class="col-form-label">Responsibility</label>
										<select name="responsibility" id="responsibility" required class="form-control">
											<option value readonly>-- Select Responsibility --</option>
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-10"></div>
									<div class="col-sm-2">
										<br><button style="width: 100%;" type="submit" name="save_select" class="btn btn-primary">Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
					<div class="card">

						<div class="card-content">
							<div class="table-responsive">
								<table id="dataTableExample1" class="table table-striped">
									<thead>
										<tr>
											<th>S.NO</th>
											<th>Name</th>
											<th>Email</th>
											<th>Designation</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;

										$sql1 = "SELECT * FROM login";
										$result1 = $conn->query($sql1);
										while ($row1 = $result1->fetch_assoc()) {
											$value = $row1['designation'];
										?>
											<tr>
												<td>
													<center><?php echo $count++ ?></center>
												</td>
												<td>
													<center>
														<a href="client-solo.php?id=<?php echo $row1["id"] ?>"><?php echo $row1["name"] ?></a>
													</center>
												</td>
												<td>
													<center>
														<a href="client-solo.php?id=<?php echo $row1["id"] ?>"><?php echo $row1["email"] ?></a>
													</center>
												</td>
												<td>
													<center>
														<?php
														switch ($value) {
															case "1":
																$my_design = "Directors/ Leader Team";
																break;
															case "2":
																$my_design = "Domain Leads";
																break;
															case "3":
																$my_design = "Admin and accounts";
																break;
															case "4":
																$my_design = "Finance";
																break;
															case "5":
																$my_design = "Business Development";
																break;
															default:
																$my_design = "N/A";
														}
														?>
														<?php echo $my_design; ?>
													</center>
												</td>
												<td>
													<table class="action">
														<tr>
															<td>
																<a href="editnewemployee.php?id=<?php echo $row1["id"]; ?>" title="Edit New Employee">
																	<span class="notification-icon dashbg-primary">
																		<i class="fa fa-edit" aria-hidden="true"></i>
																	</span>
																</a>
															</td>
															<td>
																<a href="deletenewemployee.php?id=<?php echo $row1["id"]; ?>" title="Delete New Employee" onClick="return confirm('Sure to Delete this newemployee !');">
																	<span class="notification-icon dashbg-red">
																		<i class="fa fa-trash" aria-hidden="true">
																		</i>
																	</span>
																</a>
															</td>
														</tr>
													</table>
												</td>
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

	<div class="ttr-overlay"></div>
	<script>
		function direct(val) {
			if (val == 1) {
				location.replace("job-in-hand.php");
			} else {
				location.replace("job-in-hand.php?ch=1");
			}
		}

		function divi(val) {
			if (val == "SIMULATION & ANALYSIS") {
				val = "SIMULATION+%26+ANALYSIS";
			}
			location.replace("client.php?div=" + val);
		}
	</script>
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
		$('#dataTableExample1').DataTable({
			dom: 'Bfrtip',
			lengthMenu: [
				[15, 50, 100, -1],
				['15 rows', '50 rows', '100 rows', 'Show all']
			],
			buttons: [
				'pageLength', 'excel', 'print'
			]
		});
	</script>
</body>

</html>