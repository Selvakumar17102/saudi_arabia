<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

    if(isset($_POST["add"]))
    {
        $name = $_POST["name"];
        $sub = $_POST["sub"];
        $type = $_POST["type"];
        $divi = $_POST["divi"];

        $sql1 = "SELECT * FROM account WHERE name='$name' AND sub='$sub'";
        $result1 = $conn->query($sql1);
        if($result1->num_rows > 0)
        {
            echo '<script>alert("Account already exists!")</script>';
        }
        else
        {
            if($sub != 6)
            {
                $divi = 0;
            }
            $sql4 = "SELECT id FROM account ORDER BY id DESC LIMIT 1";
            $result4 = $conn->query($sql4);
            $row4 = $result4->fetch_assoc();

            $code = $row4["id"];

            $sql2 = "INSERT INTO account (name,code,type,sub,divi) VALUES ('$name','$code','$type','$sub','$divi')";
            if($conn->query($sql2) === TRUE)
            {
                header("location: sub-account.php?msg=Sub Account Added!");
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
	<meta name="description" content="Add Sub Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Add Sub Account | Income Expense Manager" />
	<meta property="og:description" content="Add Sub Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Add Sub Account | Income Expense Manager</title>
	
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
    <style>
        .hide
        {
            display: none;
        }
    </style>
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
                            <h4>Add New Sub Account</h4>
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                        </div>
                        <div class="widget-inner">
                            <form class="edit-profile" method="post">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Account Type</label>
                                    <div class="form-group col-4">
                                        <div>
                                            <select style="height:45px" id="type" class="form-control" name="type">
                                                <option value Selected disabled>Select Type</option>
                                                <option value="1">Expense</option>
                                                <option value="3">Inhouse</option>
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="form-group col-sm-2">
                                        <input  type="submit" name="select" class="btn" value="Select" onclick="return validate1()">
                                    </div>
                                    
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <!-- Your Profile Views Chart END-->
            </div>

            <?php
                if(isset($_POST["select"]))
                {
                    $type = $_POST["type"];

                    $name = "";
                    if($type == 1)
                    {
                        $name = "Expense";
                    }
                    
                    else
                    {
                        if($type == "2")
                        {
                            $name = "Income";
                        }
                        else
                        {
                            $name = "Inhouse";
                        }
                    }
            ?>

            <div class="row">
                <!-- Your Profile Views Chart -->
                <div class="col-lg-12 m-b30">
                    <div class="widget-box">
                        <div class="wc-title">
                            <h4>New <?php echo $name ?> Sub Account</h4>
                        </div>
                        <div class="widget-inner">
                            <form class="edit-profile" method="post">
                                <div class="row">
                                    <label class="col-sm-1 col-form-label">Main Account</label>
                                    <div class="form-group col-3">
                                        <div>
                                            <input type="hidden" name="type" value="<?php echo $type ?>">
                                            <select id="sub" style="height:45px" class="form-control" name="sub" onchange="func(this.value)">
                                                <option value Selected disabled>Select Account</option>
                                                <?php
                                                    $sql = "SELECT * FROM account WHERE type='$type' AND sub='0'";
                                                    $result = $conn->query($sql);
                                                    while($row = $result->fetch_assoc())
                                                    {
                                                ?>
                                                    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="col-sm-1 col-form-label">Name</label>
                                    <div class="form-group col-3">
                                        <div>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Account Name" required>
                                        </div>
                                    </div>

                                    <!-- <label class="col-sm-1 col-form-label hide">Division</label>
                                    <div class="form-group col-3">
                                        <select style="height:45px" class="form-control hide" name="divi">
                                                <option value Selected disabled>Select Account</option>
                                                <?php
                                                    $sql = "SELECT * FROM division ORDER BY division ASC";
                                                    $result = $conn->query($sql);
                                                    while($row = $result->fetch_assoc())
                                                    {
                                                ?>
                                                    <option value="<?php echo $row["id"] ?>"><?php echo $row["division"] ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                    </div> -->
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-10"></div>
                                    <div class="form-group col-sm-2">
                                        <input  type="submit" name="add" class="btn" value="Add" onclick="return validate2()">
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
                        <div class="card-header">
                            <h5><?php echo $name ?> Accounts</h5>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Main Account</th>
                                            <th>Account Name</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                            $sql3 = "SELECT * FROM account WHERE type='$type' AND sub!='0' ORDER BY id DESC";
                                            $result3 = $conn->query($sql3);
                                            $count = 1;
                                            while($row3 = $result3->fetch_assoc())
                                            {
                                                $submain = $row3["sub"];
                                                $divimain = $row3["division"];

                                                $sql6 = "SELECT * FROM division WHERE id='$divimain'";
                                                $result6 = $conn->query($sql6);
                                                $row6 = $result6->fetch_assoc();



                                                $sql5 = "SELECT * FROM account WHERE id='$submain'";
                                                $result5 = $conn->query($sql5);
                                                $row5 = $result5->fetch_assoc();
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><?php echo $row5["name"] ?></center></td>
                                                    <td><center><?php echo $row3["name"] ?></center></td>
                                                    <!-- <?php
                                                        if($type == 3)
                                                        {
                                                            if($divimain != 0)
                                                            {
                                                    ?>
                                                    <td><center><?php echo $row6["name"] ?></center></td>
                                                    <?php
                                                            }
                                                            else
                                                            {
                                                                echo "<td><center> - </center></td>";
                                                            }
                                                        }
                                                    ?> -->
                                                    <td><center><a href="edit-subaccount.php?id=<?php echo $row3["id"] ?>" title="Edit"><span><i class="fa fa-pencil" aria-hidden="true"></i></span></a></center></td>
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

            <?php

                }

            ?>
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
// Start of jquery datatable
    $('#dataTableExample1').DataTable({
        "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "lengthMenu": [
            [15, 50, 100, -1],
            [15, 50, 100, "All"]
        ],
        "iDisplayLength": 15
    });
    function func(val)
    {
        if(val == 6)
        {
            document.getElementsByClassName('hide')[0].style.display = 'block';
            document.getElementsByClassName('hide')[1].style.display = 'block';
        }
        else
        {
            document.getElementsByClassName('hide')[0].style.display = 'none';
            document.getElementsByClassName('hide')[1].style.display = 'none';
        }
    }
</script>
<script>
        function validate1()
        {
            var type = document.getElementById('type').value;

			if (type == "")
			{
				$("#type").css("border", "1px solid red");
				return false;
			}
        }
        function validate2()
        {
            var name = document.getElementById('name').value;
            var sub = document.getElementById('sub').value;

			if (sub == "")
			{
				$("#sub").css("border", "1px solid red");
				return false;
			}
            if (name == "")
			{
				$("#name").css("border", "1px solid red");
				return false;
			}
        }
    </script>
</body>
</html>