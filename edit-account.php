<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM account WHERE id='$id'";
    $result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$divi = $row["divi"];
	$sub = $row["sub"];
    
    if(isset($_POST["add"]))
    {
		$name = $_POST["name"];
        $type = $_POST["type"];
		
		if($sub == 6)
		{
			$divi = $_POST["divi"];
		}
		else
		{
			$divi = 0;
		}

        $sql1 = "SELECT * FROM account WHERE name='$name' AND id!='$id'";
        $result1 = $conn->query($sql1);
        if($result1->num_rows > 0)
        {
            echo '<script>alert("Account name already exists!")</script>';
        }
        else
        {
            $sql2 = "UPDATE account SET name='$name',divi='$divi',type='$type' WHERE id='$id'";
            if($conn->query($sql2) === TRUE)
            {
                if($row["sub"] == 0)
                {
                    header("location: new-account.php?msg=Account Updated!");
                }
                else
                {
                    header("location: sub-account.php?msg=Account Updated!");
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
	<meta name="description" content="Edit Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Account | Income Expense Manager" />
	<meta property="og:description" content="Edit Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Account | Income Expense Manager</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/calendar/fullcalendar.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/expense/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="assets/css/tabs.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

</head>
<body>
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
    <main class="ttr-wrapper">
        <div class="container">
            <div class="row">
                <!-- Your Profile Views Chart -->
                <div class="col-lg-12 m-b30">
                    <div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
                                <div class="col-sm-11">
                                    <h4>Edit Account</h4>
                                </div>
                                <div class="col-sm-1">
                                    <a href="new-account.php" style="color: #fff" class="bg-primary btn">Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-inner">
                            <form class="edit-profile" method="post">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="col-form-label">Name</label>
                                            <input class="form-control" type="text" name="name" value="<?php echo $row["name"] ?>" required>
                                        </div>
                                        <div class="form-group col-4">

                                        <label class="col-form-label">Type</label>
													
														<Select class="form-control" id="type" name="type" >
															<option value="" readonly>Select Mode</option>
															<option value="3">Inhouse</option>
															<option value="1">Expense</option>
															
														</Select>
													
                                             </div>
                                        </div>
                                    </div>
                                    <?php
                                        if($sub == 6)
                                        {
                                    ?>
                                    <div class="form-group col-4">
                                        <select class="form-control" style="height:45px" name="divi" >
                                            <?php
                                                $sql3 = "SELECT * FROM divi ORDER BY name ASC";
                                                $result3 = $conn->query($sql3);
                                                while($row3 = $result3->fetch_assoc())
                                                {
                                                    $s = "";
                                                    if($divi == $row3["id"])
                                                    {
                                                        $s = "SELECTED";
                                                    }
                                            ?>
                                                    <option <?php echo $s ?> value="<?php echo $row3["id"] ?>"><?php echo $row3["name"] ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    
                                   <div class="row">
                                        <div class="col-md-11"></div>
                                        <div class="form-group col-sm-1">
                                        <input  type="submit" name="add" class="btn" value="Save" />
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

<!-- External JavaScripts -->
<script src="assets/js/expense/jquery.min.js"></script>
<script src="assets/vendors/expense/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/expense/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/expense/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/expense/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/expense/counter/waypoints-min.js"></script>
<script src="assets/vendors/expense/counter/counterup.min.js"></script>
<script src="assets/vendors/expense/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/expense/masonry/masonry.js"></script>
<script src="assets/vendors/expense/masonry/filter.js"></script>
<script src="assets/vendors/expense/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/expense/scroll/scrollbar.min.js'></script>
<script src="assets/js/expense/functions.js"></script>
<script src="assets/vendors/expense/chart/chart.min.js"></script>
<script src="assets/js/expense/admin.js"></script>
<script src='assets/vendors/expense/calendar/moment.min.js'></script>
<script src='assets/vendors/expense/calendar/fullcalendar.js'></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
                "iDisplayLength": 15
            });
		function validate()
		{
			var amount = document.getElementById('amount').value;

			if (amount == "")
			{
				$("#amount").css("border", "1px solid red");
				return false;
			}
		}
	</script>
</body>
</html>