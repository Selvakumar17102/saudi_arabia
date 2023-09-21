<?php
	ini_set('display_errors','off');
	include("session.php");
    include("inc/dbconn.php");
    $user = $_SESSION["user"];
    if(isset($_POST["add"]))
    {
        $name = $_POST["name"];

        $sql = "SELECT * FROM dept WHERE name='$name'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            echo '<script>alert("Name already exists!")</script>';
        }
        else
        {
            $sql1 = "INSERT INTO dept (name) VALUES ('$name')";
            if($conn->query($sql1) === TRUE)
            {
                header("Location: add-dept.php?msg=Department Added!");
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
	<meta name="description" content="All Departments | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Departments | Project Management System" />
	<meta property="og:description" content="All Departments | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Departments | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Add Department</h4>
					</div>
				</div>
			</div>	

            <div class="row" style="margin-top: 10px;margin-bottom: 50px">
                <div class="col-sm-12">
                    <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="widget-box">
                        <div class="widget-inner">
                            <form method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="text" name="name" class="form-control" placeholder="Department Name" required>
                                    </div>
                                </div>
                                <div class="row m-t10">
                                    <div class="col-sm-11"></div>
                                    <div class="col-sm-1">
                                        <input type="submit" value="Add" class="btn" name="add">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
				<!-- Data tables -->
                <div class="col-sm-12 m-b30">
                    <div class="widget-box">
                        <div class="card-header">
                            <h3>All Departments</h3>
                        </div>
                        <div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
											<th>S.NO</th>
                                            <th>Department Name</th>
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
                                    </thead>
									<tbody>
										<?php
                                            $count = 1;

                                            $sql1 = "SELECT * FROM dept ORDER BY name ASC";
                                            $result1 = $conn->query($sql1);
                                            while($row1 = $result1->fetch_assoc())
                                            {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><?php echo $row1["name"] ?></center></td>
                                                    <?php
														if($user == "conserveadmin")
														{
													?>
                                                    <td><center>
                                                    <?php 
                                                        if($row1["user"] != "")
                                                        {
                                                            echo date('d-m-Y | h:i:s a',strtotime($row1["datetime"])).'<br>'.$row1["user"]; 
                                                        }
                                                        else
                                                        {
                                                            echo "-";
                                                        }
                                                    ?></center></td>
                                                    <?php
														}
													?>
                                                    <td>
                                                        <center>
                                                            <a href="edit-dept.php?id=<?php echo $row1["id"] ?>" title="Edit"><span class="notification-icon dashbg-yellow"><i class="fa fa-pencil" aria-hidden="true"></i></span></a>
                                                        </center>
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
</script>
</body>
</html>