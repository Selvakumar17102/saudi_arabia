<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

	$user = $_SESSION["user"];
	$date = date("Y-m-d");

    $id = $_REQUEST['id'];

    $sql = "SELECT * FROM enquiry WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(isset($_POST['edit']))
    {
        $rfq = $_POST['rfq'];

        $sql = "SELECT * FROM enquiry WHERE rfqno='$rfq' AND id!='$id'";
        $result = $conn->query($sql);
        if($result->num_rows == 0)
        {
            $sql1 = "SELECT * FROM enquiry WHERE id='$id'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $old_rfqid = $row1['rfqid'];
            $last_rfqid = $row1['rfqid'];

			$rfqid = strrev($last_rfqid);

			$last_rfqid_no1 = explode('_', $rfqid);
			$last_rfqid_no3 = explode('_', $rfqid);
			$last_rfqid_no2 = explode('-', $last_rfqid_no1[1]);
		
			$array_length = count($last_rfqid_no2);
			$new_rfq = "";
			for($i=0;$i<$array_length;$i++)
			{
				$index = $array_length-$i;
				$reverse = strrev($last_rfqid_no2[$index]);
				$new_rfq .= $reverse.'-';
			}
			$new_rfq = $new_rfq.''.$rfq.'_'.$last_rfqid_no3[0];

			$new_rfq = ltrim($new_rfq, '-');

            $sql2 = "UPDATE enquiry SET rfqid='$new_rfq',rfqno='$rfq' WHERE rfqid='$old_rfqid'";
            if($conn->query($sql2)==TRUE){

                $sql3 = "UPDATE client SET rfqid='$new_rfq' WHERE rfqid='$old_rfqid'";
                $conn->query($sql3);

                $sql3 = "UPDATE invoice SET rfqid='$new_rfq' WHERE rfqid='$old_rfqid'";
                $conn->query($sql3);

				$old_rfqid_no = strrev($last_rfqid_no2[0]);

                $sql3 = "SELECT * FROM notes WHERE rfqid LIKE '%$old_rfqid_no%' GROUP BY rfqid";
                $result3 = $conn->query($sql3);
                while ($row3 = $result3->fetch_assoc()) {

					$last_rfqid_no1 = $last_rfqid_no2 = $last_rfqid_no3 = $array_length = "";
					
                    $old_rfqid_note = $row3['rfqid'];
                    $rfqid_note = $row3['rfqid'];

					$rfqid_note = strrev($rfqid_note);

					$last_rfqid_no1 = explode('_', $rfqid_note);
					$last_rfqid_no3 = explode('_', $rfqid_note);
					$last_rfqid_no2 = explode('-', $last_rfqid_no1[1]);
					
					$array_length = count($last_rfqid_no2);
					$new_rfq = "";
					for($i=0;$i<$array_length;$i++)
					{
						$index = $array_length-$i;
						$reverse = strrev($last_rfqid_no2[$index]);
						$new_rfq .= $reverse.'-';
					}
					$new_rfq = $new_rfq.''.$rfq.'_'.strrev($last_rfqid_no3[0]);

					$new_rfq = ltrim($new_rfq, '-');
					
                    $sql3 = "UPDATE notes SET rfqid='$new_rfq' WHERE rfqid='$old_rfqid_note'";
                    if($conn->query($sql3)==TRUE)
                    {
                        header("location: entire-enquiry.php?msg=Updated!");
                    }
                }
				header("location: entire-enquiry.php?msg=Updated!");
            }

        }else{
            header("location: entire-enquiry.php?msg=Already Exist");
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
	<meta name="description" content="All Enquiry | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Enquiry | Project Management System" />
	<meta property="og:description" content="All Enquiry | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit RFQ NO | Project Management System</title>
	
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

	<style>
		.green td
		{
			background-color: #fff;
		}
		.lime td
		{
			background-color: #fff;
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
						<h4 class="breadcrumb-title">All Enquiry</h4>
					</div>
                    <div class="col-sm-1">
                        <a href="entire-enquiry.php" style="color: #fff" class="bg-primary btn">Back</a>
                    </div>
				</div>
            </div>
            <form method="post">
                <div class="row m-t10">
                    <div class="col-sm-12">
                        <div class="widget-box">
                            <div class="widget-inner">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-form-label">RFQ No</label>
                                        <input type="text" name="rfq" class="form-control" placeholder="RFQ No" value="<?php echo $row['rfqno'];?>" required>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-sm-10"></div>
                                    <div class="col-sm-2">
                                        <input type="submit" name="edit" value="UPDATE" class="btn btn-success" style="width: 100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
</body>
</html>