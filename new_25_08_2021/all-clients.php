<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
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
	<meta name="description" content="All Clients | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Clients | Project Management System" />
	<meta property="og:description" content="All Clients | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Clients | Project Management System</title>
	
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
	<?php include_once("inc/header.php");?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb" style="margin-bottom: 0px;padding-bottom: 0px">
				<div class="row" style="width: 100%">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">All Clients</h4>
					</div>
					<?php
						if($rowside["id"] != 2)
						{
					?>
					<div class="col-sm-1">
						<a href="add-client.php" class="btn">Add Client</a>
					</div>
					<?php
						}
					?>
				</div>
			</div>	

			<div class="row">
			
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
				<!-- Data tables -->
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 m-b30">
					<p style="text-align: center; color: green;" id="pid"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="widget-box">

                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
											<th>S.NO</th>
                                            <th style="color: #C54800">Client Name</th>
											<?php
												if($rowside["id"] != 2)
												{
											?>
                                            <th>Master Client</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php
                                            $count = 1;

                                            $sql1 = "SELECT * FROM enquiry GROUP BY cname";
                                            $result1 = $conn->query($sql1);
                                            while($row1 = $result1->fetch_assoc())
                                            {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><a href="client-solo.php?id=<?php echo $row1["id"] ?>"><?php echo $row1["cname"] ?></a></center></td>
													<?php
														if($rowside["id"] != 2)
														{
													?>
													<td>
														<select class="form-control" onchange="update('<?php echo $row1['cname'] ?>',this.value)">
															<option value selected Disabled>Select Client</option>
															<?php
																$sql = "SELECT * FROM main ORDER BY name ASC";
																$result = $conn->query($sql);
																while($row = $result->fetch_assoc())
																{
																	$s = "";
																	if($row1["cid"] == $row["id"])
																	{
																		$s = "Selected";
																	}
															?>
																	<option <?php echo $s ?> value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<?php
														}
													?>
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
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>	
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
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
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
	function update(name,id)
	{
		$.ajax({
            type: "POST",
            url: "assets/ajax/update-client.php",
            data:{'cname':name,'id':id}
        });
	}
</script>
</body>
</html>