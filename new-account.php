<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

    if(isset($_POST["add"]))
    {
        $name = $_POST["name"];
		$type = $_POST["type"];

		$sql4 = "SELECT id FROM account ORDER BY id DESC LIMIT 1";
		$result4 = $conn->query($sql4);
		$row4 = $result4->fetch_assoc();

		$code = $row4["id"];
        $code ; 
		if($code == "")
		{
			$code = 1;
		}

        $sql = "SELECT * FROM account WHERE name='$name'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            echo '<script>alert("Code Already Exists!")</script>';
		}
        else
        {
			if($type == "")
			{
				echo '<script>alert("Choose Type!")</script>';
			}
			else
			{
				$sql1 = "INSERT INTO account (name,code,type) VALUES ('$name','$code','$type')";
				if($conn->query($sql1) === TRUE)
				{
					header("location: new-account.php?msg=Account added!");
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
	<meta name="description" content="Add Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Add Account | Income Expense Manager" />
	<meta property="og:description" content="Add Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Add Account | Income Expense Manager</title>
	
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
                                <h4>Add New Account</h4>
                                <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                            </div>
                            <div class="widget-inner">
                                <form class="edit-profile" method="post">
                                    <div class="row">
                                        
                                        <div class="form-group col-4">
                                            <div>
                                                <input class="form-control" id="amount" type="text" name="name" placeholder="Account Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-5">
                                            <div class="form-check-inline ">
                                                <label class="form-check-label">
                                                    <input type="radio" value="1" checked class="form-check-input" name="type">Expense
                                                </label>
                                            </div>
                                            <div class="form-check-inline ">
											<label class="form-check-label">
												<input type="radio" value="3" class="form-check-input" name="type">In-House
											</label>
										</div> 
                                        </div>
                                    
                                        <div class="form-group col-sm-2">
                                            <input  type="submit" name="add" class="btn" value="Add" onclick="return validate()">
                                        </div>
                                        
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Your Profile Views Chart END-->
                </div>
                <div class="row">
                
                    <!-- Data tables -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                        <div class="card">
    
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Account Name</th>
                                                <th>Account Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                              $sql2 = "SELECT * FROM account WHERE type !='2' AND sub ='0'ORDER BY name ASC"; 
                                                $result2 = $conn->query($sql2);
                                                $count = 1;
                                                while($row2 = $result2->fetch_assoc())
                                                {
                                                    $type = "";
                                                    if($row2["type"] == 1)
                                                    {
                                                        $type = "Expense";
                                                    }
                                                    if($row2["type"] == 2)
                                                    {
                                                        $type = "Income";
                                                    }
                                                    if($row2["type"] == 3)
                                                    {
                                                        $type = "Inhouse";
                                                    }
                                            ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><?php echo $row2["name"] ?></center></td>
                                                    <td><center><?php echo $type ?></center></td>
                                                    <td><center><a href="edit-account.php?id=<?php echo $row2["id"] ?>" title="Edit"><span><i class="fa fa-pencil" aria-hidden="true"></i></span></a></center></td>
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
			<!-- Card END -->
	<!-- <div class="ttr-overlay"></div> -->

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

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
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