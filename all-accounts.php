<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

    $c1 = $c2 = $c3 = "";
    $b1 = $b2 = $b3 = "";
    
    $id = $_REQUEST["id"];

    if($id == 1)
    {
        $c1 = "#461880";
        $b1 = "#fff";
    }
    if($id == 2)
    {
        $c2 = "#461880";
        $b2 = "#fff";
    }
    if($id == 3)
    {
        $c3 = "#461880";
        $b3 = "#fff";
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
	<meta name="description" content="All Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="All Account | Income Expense Manager" />
	<meta property="og:description" content="All Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>All Account | Income Expense Manager</title>
	
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
                <!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
                    <div class="widget-box">
                        <div class="widget-inner">
                            <div class="row">
                                <div class="col-sm-8">
                                    <!-- <label style="margin-top: 5px" class="col-form-label float-right">Click to Filter</label> -->
                                </div>
                                <div class="col-sm-4">
                                    <!-- <button style="background-color: <?php echo $c1.';color:'.$b1 ?>" class="btn" onclick="run(1)">Expense</button>
                            
                                    <button style="background-color: <?php echo $c2.';color:'.$b2 ?>" class="btn" onclick="run(2)">Income</button>
                                
                                    <button style="background-color: <?php echo $c3.';color:'.$b3 ?>" class="btn" onclick="run(3)">Inhouse</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <th>Main Account</th>
                                            <th>Account Type</th>
                                            <?php
                                                if($id == 2)
                                                {
                                            ?>
                                            <th>Total Outstanding</th>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($id == "")
                                            {
                                                $sql = "SELECT * FROM account WHERE sub ='0' ORDER BY name ASC";
                                            }
                                            else
                                            {
                                                $sql = "SELECT * FROM account WHERE type='$id' AND sub='0' ORDER BY name ASC";
                                            }
                                            $result = $conn->query($sql);
                                            $count = 1;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $id1 = $row["id"];
                                                $type = $row["type"];
                                                $code = $row["code"];
                                                $test = 0;

                                                if($type == 1)
                                                {
                                                    $mode = "Expense";
                                                }
                                                elseif($type == 2)
                                                {
                                                    $mode = "Income";
                                                }
                                                else
                                                {
                                                    if($type == 3)
                                                    {
                                                        $mode = "Inhouse";
                                                    }
                                                    
                                                }

                                                $sql1 = "SELECT * FROM account WHERE sub='$id1'";
                                                $result1 = $conn->query($sql1);
                                                $amount = 0;
                                                if($result1->num_rows > 0)
                                                {
                                                    $test = 1;
                                                    while($row1 = $result1->fetch_assoc())
                                                    {
                                                        $code1 = $row1["code"];

                                                        $sql2 = "SELECT sum(amount) AS amount FROM credits WHERE code='$code1'";
                                                        $result2 = $conn->query($sql2);
                                                        $row2 = $result2->fetch_assoc();

                                                        $sql3 = "SELECT sum(credit) AS credit FROM expence_invoice WHERE code='$code1'";
                                                        $result3 = $conn->query($sql3);
                                                        $row3 = $result3->fetch_assoc();

                                                        $amount += $row2["amount"] - $row3["credit"];
                                                    }
                                                }
                                                else
                                                {
                                                    $sql2 = "SELECT sum(amount) AS amount FROM credits WHERE code='$code'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();

                                                    $sql3 = "SELECT sum(credit) AS credit FROM expence_invoice WHERE code='$code'";
                                                    $result3 = $conn->query($sql3);
                                                    $row3 = $result3->fetch_assoc();

                                                    $amount += $row2["amount"] - $row3["credit"];
                                                }
                                        ?>
                                                    <tr>
                                                        <td><center><?php echo $count++ ?></center></td>
                                                        <?php
                                                            if($test == 1)
                                                            {
                                                        ?>
                                                            <!-- <td><center><a href="subaccounts.php?id=<?php echo $row["id"] ?>"><?php echo $row["name"] ?></a></center></td> -->
                                                                <td><center><?php echo $row["name"] ?></center></td>
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                            <!-- <td><center><a href="account-details.php?id=<?php echo $row["id"] ?>"><?php echo $row["name"] ?></a></center></td> -->
                                                            <td><center><?php echo $row["name"] ?></center></td>
                                                        <?php
                                                            }
                                                        ?>
                                                        <td><center><?php echo $mode ?></center></td>
                                                        <?php
                                                            if($id == 2)
                                                            {
                                                        ?>
                                                            <td><center>SAR <?php echo number_format($amount,2) ?></center></td>
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
// Start of jquery datatable
            $('#dataTableExample1').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "lengthMenu": [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
                "iDisplayLength": 15
            });
</script>
</body>
</html>