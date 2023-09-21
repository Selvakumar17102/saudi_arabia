<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

    $divi = $_REQUEST["divi"];

    $id = $_REQUEST["id"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($id == "")
	{
		$date = date('Y-m-d');
        $start = date('Y-m-01');
        $monthName = " - ".date("F")." Month Report";
	}
	else
	{
        $monthName = " - ".date('F', mktime(0, 0, 0, $id, 10))." Month Report";
		if($id < 10)
		{
			$id = "0".$id;
		}

		$start = date('Y-'.$id.'-01');
		$date = date("Y-m-t", strtotime($start));
	}

	if($fdate != "" && $tdate != "")
	{
        $monthName = " From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));
		$date = $tdate;
		$start = $fdate;
	}
    
    $sqldivi = "SELECT * FROM division WHERE id='$divi'";
    $resultdivi = $conn->query($sqldivi);
    $rowdivi = $resultdivi->fetch_assoc();

    $cred = $debi = 0;

    $sq1 = "SELECT * FROM sector WHERE divi='$divi' AND date BETWEEN '$start' AND '$date'";
    $res1 = $conn->query($sq1);
    while($ro1 = $res1->fetch_assoc())
    {
        $inv = $ro1["inv"];

        $sq2 = "SELECT * FROM expence_invoice WHERE id='$inv'";
        $res2 = $conn->query($sq2);
        $ro2 = $res2->fetch_assoc();

        if($ro2["type"] == 1)
        {
            $cred += $ro1["amount"];
        }
        if($ro2["type"] == 2)
        {
            $debi += $ro1["amount"];
        }
    }

    $sql8 = "SELECT * FROM account WHERE type='2' AND sub='0'";
    $result8 = $conn->query($sql8);
    $tot = 0;
    while($row8 = $result8->fetch_assoc())
    {
        $idmain = $row8["id"];
        $c = $row8["code"];

        $sql9 = "SELECT * FROM account WHERE sub='$idmain'";
        $result9 = $conn->query($sql9);
        if($result9->num_rows > 0)
        {
            while($row9 = $result9->fetch_assoc())
            {
                $codemain = $row9["code"];

                $sql10 = "SELECT sum(amount) AS amount FROM credits WHERE code='$codemain' AND divi='$divi' AND date BETWEEN '$start' AND '$date'";
                $result10 = $conn->query($sql10);
                $row10 = $result10->fetch_assoc();

                $tot += $row10["amount"];
            }
        }
        else
        {
            $sql10 = "SELECT sum(amount) AS amount FROM credits WHERE code='$c' AND divi='$divi' AND date BETWEEN '$start' AND '$date'";
            $result10 = $conn->query($sql10);
            $row10 = $result10->fetch_assoc();

            $tot += $row10["amount"];
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
	<meta name="description" content="Division Reports | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Division Reports | Income Expense Manager" />
	<meta property="og:description" content="Division Reports | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Division Reports | Income Expense Manager</title>
	
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
        .hide1
        {
            display: none;
        }
    </style>
</head>
<body style="background-color: #f8f8f8;">
	<?php include("inc/expence_header.php") ?>
	<?php include_once("inc/sidebar.php"); ?>
	<!--Main container start -->
    <main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
                            <div class="row">
								<div class="col-sm-11">
                                    <h4><center><?php echo $rowdivi["name"]." Details".$monthName ?></center></h4>
									<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
								</div>
                                <div class="col-sm-1">
                                    <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
                                </div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<label class="col-form-label">Month Wise Search</label>
									<select style="height: 40px" id="date" class="form-control" onchange="boss(this.value)">
										<option value disabled Selected>Select Month</option>
										<option value="1">Jan</option>
										<option value="2">Feb</option>
										<option value="3">Mar</option>
										<option value="4">Apr</option>
										<option value="5">May</option>
										<option value="6">Jun</option>
										<option value="7">Jul</option>
										<option value="8">Aug</option>
										<option value="9">Sep</option>
										<option value="10">Oct</option>
										<option value="11">Nov</option>
										<option value="12">Dec</option>
									</select>
								
								</div>
								<div class="col-sm-9">
								<label class="col-form-label">Custom Search</label>
									<div class="col-sm-12">
										<div class="row">
										
											<div class="col-sm-5">
												<input type="date" id="fdate" class="form-control">
											</div>
											<div class="col-sm-5">
												<input type="date" id="tdate" class="form-control">
											</div>
											<div class="col-sm-2">
												<input type="button" class="btn" value="Submit" onclick="search()">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>

          <!--  <div class="row">
				<!-- Your Profile Views Chart -->
				<!-- <div class="col-lg-12 m-b30">
					<div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>Income Accounts</h4>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="float-right">Total Income : <?php echo number_format($cred,2) ?> SAR</h4>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Account Name</th>
											<th>Amount (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>

                                    <?php
                                        $sql = "SELECT * FROM account WHERE type='2' AND sub='0'";
                                        $count1 = 1;
                                        $result = $conn->query($sql);
                                        while($row = $result->fetch_assoc())
                                        {
                                            $name1 = $row["name"];
                                            $id1 = $row["id"];

                                            $amount1 = 0;

                                            $sql1 = "SELECT * FROM account WHERE sub='$id1'";
                                            $result1 = $conn->query($sql1);
                                            if($result1->num_rows > 0)
                                            {
                                                while($row1 = $result1->fetch_assoc())
                                                {
                                                    $code1 = $row1["code"];

                                                    $sql2 = "SELECT * FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$start' AND '$date'";
                                                    $result2 = $conn->query($sql2);
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        $invid1 = $row2["id"];

                                                        $sql3 = "SELECT * FROM sector WHERE inv='$invid1' AND divi='$divi'";
                                                        $result3 = $conn->query($sql3);
                                                        $row3 = $result3->fetch_assoc();

                                                        $amount1 += $row3["amount"];
                                                    }
                                                }
                                                if($amount1 != 0)
                                                {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count1++ ?></center></td>
                                                    <td><center><a href="division-indi.php?id=<?php echo $id1.'&divi='.$divi.'&fdate='.$start.'&tdate='.$date ?>"><?php echo $name1 ?></a></center></td>
                                                    <td><center><?php echo number_format($amount1,2) ?></center></td>
                                                </tr>
                                        <?php
                                                }
                                            }
                                            else
                                            {
                                                $code1 = $row["code"];

                                                $sql2 = "SELECT * FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$start' AND '$date'";
                                                $result2 = $conn->query($sql2);
                                                while($row2 = $result2->fetch_assoc())
                                                {
                                                    $invid1 = $row2["id"];

                                                    $sql3 = "SELECT * FROM sector WHERE inv='$invid1' AND divi='$divi'";
                                                    $result3 = $conn->query($sql3);
                                                    $row3 = $result3->fetch_assoc();

                                                    $amount1 += $row3["amount"];
                                                }
                                                if($amount1 != 0)
                                                {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count1++ ?></center></td>
                                                    <td><center><a href="division-indi.php?id=<?php echo $id1.'&divi='.$divi.'&fdate='.$start.'&tdate='.$date ?>"><?php echo $name1 ?></a></center></td>
                                                    <td><center><?php echo number_format($amount1,2) ?></center></td>
                                                </tr>
                                        <?php
                                                }
                                            }
                                        }
                                    ?>
                                        
									</tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div> -->

				<div class="col-lg-12 m-b30">
					<div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>Expense Accounts</h4>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="float-right">Total Expense : <?php echo number_format($debi,2) ?> SAR</h4>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Account Name</th>
											<th>Amount (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
                                    <?php

                                        $sql4 = "SELECT * FROM account WHERE type='1' AND sub='0'";
                                        $count2 = 1;
                                        $result4 = $conn->query($sql4);
                                        while($row4 = $result4->fetch_assoc())
                                        {
                                            $name2 = $row4["name"];
                                            $id2 = $row4["id"];

                                            $amount2 = 0;

                                            $sql5 = "SELECT * FROM account WHERE sub='$id2'";
                                            $result5 = $conn->query($sql5);
                                            if($result5->num_rows > 0)
                                            {
                                                while($row5 = $result5->fetch_assoc())
                                                {
                                                    $code2 = $row5["code"];

                                                    $sql6 = "SELECT * FROM expence_invoice WHERE code='$code2' AND date BETWEEN '$start' AND '$date'";
                                                    $result6 = $conn->query($sql6);
                                                    while($row6 = $result6->fetch_assoc())
                                                    {
                                                        $invid2 = $row6["id"];

                                                        $sql7 = "SELECT * FROM sector WHERE inv='$invid2' AND divi='$divi'";
                                                        $result7 = $conn->query($sql7);
                                                        $row7 = $result7->fetch_assoc();

                                                        $amount2 += $row7["amount"];
                                                    }
                                                }
                                                if($amount2 != 0)
                                                {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count2++ ?></center></td>
                                                    <td><center><a href="division-indi.php?id=<?php echo $id2.'&divi='.$divi.'&fdate='.$start.'&tdate='.$date ?>"><?php echo $name2 ?></a></center></td>
                                                    <td><center><?php echo number_format($amount2,2) ?></center></td>
                                                </tr>
                                        <?php
                                                }
                                            }
                                            else
                                            {
                                                $code2 = $row4["code"];

                                                $sql6 = "SELECT * FROM expence_invoice WHERE code='$code2' AND date BETWEEN '$start' AND '$date'";
                                                $result6 = $conn->query($sql6);
                                                while($row6 = $result6->fetch_assoc())
                                                {
                                                    $invid2 = $row6["id"];

                                                    $sql7 = "SELECT * FROM sector WHERE inv='$invid2' AND divi='$divi'";
                                                    $result7 = $conn->query($sql7);
                                                    $row7 = $result7->fetch_assoc();

                                                    $amount2 += $row7["amount"];
                                                }
                                                if($amount2 != 0)
                                                {
                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count2++ ?></center></td>
                                                    <td><center><a href="division-indi.php?id=<?php echo $id2.'&divi='.$divi.'&fdate='.$start.'&tdate='.$date ?>"><?php echo $name2 ?></a></center></td>
                                                    <td><center><?php echo number_format($amount2,2) ?></center></td>
                                                </tr>
                                        <?php
                                                }
                                            }
                                        }
                                    ?>
									</tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
                <!-- <div class="col-lg-12 m-b30">
					<div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>Total Invoice</h4>
                                </div>
                                <div class="col-sm-6">
                                    <h4 class="float-right">Total Invoiced Value : <?php echo number_format($tot,2) ?> SAR</h4>
                                </div>
                            </div>
						</div>
						<div class="widget-inner">
                            <div class="table-responsive">
                    	        <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
											<th>Account Name</th>
											<th>Amount (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        <?php
                                            $sql = "SELECT * FROM account WHERE type='2' AND sub='0'";
                                            $result = $conn->query($sql);
                                            $count3 = 1;
                                            $t = 0;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $accid = $row["id"];
                                                $maincode = $row["code"];
                                                $total = 0;
                                                $subs = 0;

                                                $sql1 = "SELECT * FROM account WHERE sub='$accid'";
                                                $result1 = $conn->query($sql1);
                                                if($result1->num_rows > 0)
                                                {
                                                    $subs = 1;
                                                    while($row1 = $result1->fetch_assoc())
                                                    {
                                                        $code = $row1["code"];

                                                        $sql2 = "SELECT sum(amount) AS amount FROM credits WHERE code='$code' AND divi='$divi' AND date BETWEEN '$start' AND '$date'";
                                                        $result2 = $conn->query($sql2);
                                                        $row2 = $result2->fetch_assoc();

                                                        $total += $row2["amount"];
                                                    }
                                                }
                                                else
                                                {
                                                    $sql2 = "SELECT sum(amount) AS amount FROM credits WHERE code='$maincode' AND divi='$divi' AND date BETWEEN '$start' AND '$date'";
                                                    $result2 = $conn->query($sql2);
                                                    $row2 = $result2->fetch_assoc();

                                                    $total += $row2["amount"];
                                                }

                                                $t += $total;

                                                if($total != 0)
                                                {
                                                    if($subs == 0)
                                                    {
                                                    ?>
                                                        <tr>
                                                            <td><center><?php echo $count3++ ?></center></td>
                                                            <td><center><a href="divi-credit1.php?id=<?php echo $row["id"].'&divi='.$divi.'&fdate='.$start.'&tdate='.$date ?>"><?php echo $row["name"] ?></a></center></td>
                                                            <td><center><?php echo number_format($total,2) ?></center></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                    <tr>
                                                        <td><center><?php echo $count3++ ?></center></td>
                                                        <td><center><a href="divi-credit.php?id=<?php echo $row["id"].'&divi='.$divi.'&fdate='.$start.'&tdate='.$date ?>"><?php echo $row["name"] ?></a></center></td>
                                                        <td><center><?php echo number_format($total,2) ?></center></td>
                                                    </tr>
                                                <?php
                                                    }
                                                }
                                            }
                                            // echo $t;
                                        ?>
									</tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
            </div>
		</div> -->
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
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
            $('#dataTableExample2').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
            $('#dataTableExample3').DataTable({
                "dom": 'Bfrtip',
				"buttons": [
					'excel'
				],
				"iDisplayLength": 50
            });
</script>
<script>
	function boss(val)
	{
		if(val != "")
		{
			// location.replace("https://www.conservesolution.com/incomemgmt/division-report.php?id="+val+"&divi=<?php echo $divi ?>");
            window.location.href ="division-report.php?id="+val+"&divi=<?php echo $divi; ?>";
        }
	}
	function search()
	{
		var fdate = document.getElementById('fdate').value;
		var tdate=document.getElementById('tdate').value;

		if(fdate == "")
		{
			$("#fdate").css("border", "1px solid red");
		}
		else
		{
			if(tdate == "")
			{
				$("#tdate").css("border", "1px solid red");
			}
			else
			{
				// location.replace("https://www.conservesolution.com/incomemgmt/division-report.php?fdate="+fdate+"&tdate="+tdate+"&divi=<?php echo $divi ?>");
                window.location.href = "division-report.php?fdate="+fdate+"&tdate="+tdate+"&divi=<?php echo $divi ?>";
            }
		}
	}
</script>
<script>
    $(document).ready(function(){
		$('[type="date"]').prop('max', function(){
			return new Date().toJSON().split('T')[0];
		});
	});
    </script>
</body>
</html>