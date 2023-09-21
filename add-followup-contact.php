<?php
	ini_set('display_errors','off');
    include("session.php");
	include("inc/dbconn.php");
	date_default_timezone_set("Asia/Qatar");

    $id = $_REQUEST['name'];
    $project_id = $_REQUEST['id'];

    if(isset($_POST['save'])){
        $count = count($_POST['name']);

        $sql = "DELETE FROM contact_details WHERE project_id='$project_id'";
        if($conn->query($sql)==TRUE){
            for ($i=0; $i < $count; $i++) {
                $name = $_POST['name'][$i];
                $designation = $_POST['designation'][$i];
                $phone = $_POST['phone'][$i];
                $mail = $_POST['mail'][$i];
                $sql = "INSERT INTO contact_details (project_id,name,design,phone,mail) VALUES ('$project_id','$name','$designation','$phone','$mail')";
                if($conn->query($sql)==TRUE){
                    header("Location: add-followup-contact.php?id=$project_id&msg=Updated!");
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
	<meta name="description" content="New Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="New Enquiry | Project Management System" />
	<meta property="og:description" content="New Enquiry | Project Management System" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Add Followup Contact | Project Management System</title>
	
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
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
</head>
<body class="ttr-pinned-sidebar">
	
	<!-- header start -->
	<?php include_once("inc/header.php");
	?>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php include_once("inc/sidebar.php");
	?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
			<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">Add Followup Contact Details</h4>
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
                                <div id="duplicate" class="mb-3">
                                <?php
                                    $sql = "SELECT * FROM contact_details WHERE project_id='$project_id'";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0)
                                    {
                                        $i = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            if($i == 0){
                                                ?>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="text" name="name[]" id="name" class="form-control" placeholder="Employee Name" value="<?php echo $row['name'];?>">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" name="designation[]" id="designation" class="form-control" placeholder="Employee Designation" value="<?php echo $row['design'];?>">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" name="phone[]" id="phone" class="form-control" placeholder="Employee Phone" value="<?php echo $row['phone'];?>">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" name="mail[]" id="mail" class="form-control" placeholder="Employee Mail" value="<?php echo $row['mail'];?>">
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <button type="button"  name="add" id="add" class="btn btn-success">+</button>
                                                        </div>
                                                    </div>
                                                <?php
                                            }else{
                                                ?>
                                                    <div id="duplicate<?php echo $i ?>" class="m-t30">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <input type="text" name="name[]" id="name" class="form-control" placeholder="Employee Name" value="<?php echo $row['name'];?>">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="designation[]" id="designation" class="form-control" placeholder="Employee Designation" value="<?php echo $row['design'];?>">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="text" name="phone[]" id="phone" class="form-control" placeholder="Employee Phone" value="<?php echo $row['phone'];?>">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" name="mail[]" id="mail" class="form-control" placeholder="Employee Mail" value="<?php echo $row['mail'];?>">
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <button type="button" name="remove" class="btn btn-danger btn_remove" id="<?php echo $i;?>">X</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                            $i++;
                                        }
                                        ?>
                                            </div>
                                        <?php
                                    }else{
                                        ?>
                                                <div id="duplicate" class="mb-3">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <input type="text" name="name[]" id="name" class="form-control" placeholder="Employee Name">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" name="designation[]" id="designation" class="form-control" placeholder="Employee Designation">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="text" name="phone[]" id="phone" class="form-control" placeholder="Employee Phone">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" name="mail[]" id="mail" class="form-control" placeholder="Employee Mail">
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <button type="button"  name="add" id="add" class="btn btn-success">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                    }
                                ?>
                                </div>
                                <div class="row">
                                    <div class="col-sm-11"></div>
                                    <div class="col-sm-1">
                                        <input type="submit" value="SAVE" class="btn btn-success" name="save">
                                    </div>
                                </div>
							</form>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
		</div>
	</main>
	<div class="ttr-overlay"></div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/slick-slider/slick.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap-wysihtml5.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
        var i = 0;
        $('#add').click(function(){
            i++;
            $('#duplicate').append(
                '<div id="duplicate'+i+'" class="row m-t30"><div class="col-sm-3"><input type="text" name="name[]" id="name" class="form-control" placeholder="Employee Name"></div><div class="col-sm-3"><input type="text" name="designation[]" id="designation" class="form-control" placeholder="Employee Designation"></div><div class="col-sm-2"><input type="text" name="phone[]" id="phone" class="form-control" placeholder="Employee Phone"></div><div class="col-sm-3"><input type="text" name="mail[]" id="mail" class="form-control" placeholder="Employee Mail"></div><div class="col-sm-1"><button type="button" name="remove" class="btn btn-danger btn_remove" id="'+i+'">X</button></div></div>'
            );
        });
        $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#duplicate'+button_id+'').remove();  
        });
    </script>
</body>
</html>