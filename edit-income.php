<?php
    ini_set('display_errors','off');
	include("inc/dbconn.php");
    include("inc/session.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM expence_invoice WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $mode = $row["mode"];

    if($mode != "Cash")
    {
        $bank = $row["bank"];
    }
    else
    {
        $bank = "1";
    }
    
    if(isset($_POST["add"]))
    {
        $amount = $_POST["amount"];
        $descrip = $_POST["descrip"];

        $sql1 = "UPDATE expence_invoice SET credit='$amount',descrip='$descrip' WHERE id='$id'";
        if($conn->query($sql1) === TRUE)
        {
            $sql2 = "SELECT * FROM expence_main WHERE id='$bank'";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();

            $amountmain = $row2["balance"] - $row["credit"] + $amount;

            $sql3 = "UPDATE expence_main SET balance='$amountmain' WHERE id='$bank'";
            if($conn->query($sql3) === TRUE)
            {
                $sql4 = "SELECT * FROM sector WHERE inv='$id'";
                $result4 = $conn->query($sql4);
                $totrows = $result4->num_rows;

                $sectoramount = $amount/$totrows;

                $sql5 = "UPDATE sector SET amount='$sectoramount' WHERE inv='$id'";
                if($conn->query($sql5) === TRUE)
                {
                    header("location: income.php?msg=Income Edited!");
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
	<meta name="description" content="Edit Income | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Edit Income | Income Expense Manager" />
	<meta property="og:description" content="Edit Income | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Edit Income | Income Expense Manager</title>
	
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
    
    <link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
    
</head>
<body>
	
	<!-- header start -->
	<?php include("inc/expence_header.php") ?>
	

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
                                    <h4>Edit Income</h4>
								</div>
								<div class="col-sm-1">
									<a href="income.php" style="color: #fff" class="bg-primary btn">Back</a>
								</div>
							</div>
						</div>
						<div class="widget-inner">
							<form class="edit-profile" method="post">
								<div class="row">
									<label class="col-form-label col-1">Credit</label>
									<div class="form-group col-4">
										<div>
											<input class="form-control" type="text" name="amount" value="<?php echo $row["credit"] ?>" >
										</div>
                                    </div>

									<label class="col-form-label col-1">Description</label>
									<div class="form-group col-4">
										<div>
											<input class="form-control" type="text" name="descrip" value="<?php echo $row["descrip"] ?>" >
										</div>
                                    </div>
								
                                    <div class="form-group col-sm-2">
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
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/admin.js"></script>
</body>
</html>