<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");
	$user=$_SESSION["username"];

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM main WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(isset($_POST["add"]))
    {
        $name = $_POST["name"];

        $sql = "SELECT * FROM main WHERE name='$name' AND id!='$id'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            echo '<script>alert("Name already exists!")</script>';
        }
        else
        {
			$time = date('y-m-d H:i:s');
            $sql1 = "UPDATE main SET name='$name',datetime='$time',user='$user' WHERE id='$id'";
            if($conn->query($sql1) === TRUE)
            {
                header("Location: add-client.php?msg=Client Saved!");
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
	<meta name="description" content="Edit Client | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Client | Project Management System" />
	<meta property="og:description" content="Edit Client | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Client | Project Management System</title>
	
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
						<h4 class="breadcrumb-title">Edit Client</h4>
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
                                        <input type="text" name="name" class="form-control" placeholder="Client Name" value="<?php echo $row["name"] ?>" required>
                                    </div>
                                </div>
                                <div class="row m-t10">
                                    <div class="col-sm-11"></div>
                                    <div class="col-sm-1">
                                        <input type="submit" value="Save" class="btn" name="add">
                                    </div>
                                </div>
                            </form>
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