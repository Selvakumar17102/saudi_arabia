<?php
	ini_set('display_errors','off');
	include("inc/dbconn.php");
	include("session.php");

    $id = $_REQUEST["id"];

    $ids = $_REQUEST["ids"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($ids == "")
	{
		$today = date('Y-m-d');
        $thismonth = date('Y-m-01');
        $monthName = "For The Month of - ".date("F Y");
	}
	else
	{
		if($ids < 10)
		{
			$ids = "0".$ids;
		}

		$thismonth = date('Y-'.$ids.'-01');
        $today = date("Y-m-t", strtotime($thismonth));
        $monthName = "For The Month of - ".date('F Y', mktime(0, 0, 0, $ids, 10));
	}

	if($fdate != "" && $tdate != "")
	{
		$today = $tdate;
        $thismonth = $fdate;
        $monthName = "From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));

        if($fdate == date('Y-m-01') && $tdate == date('Y-m-d'))
		{
			$monthName = "For The Month of - ".date('F Y');
		}
	}

    $sql = "SELECT * FROM account WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $type = $amount = $temp = $amount1=  "";

    if($row["type"] == 1)
    {
        $type = "Expenses";
        $type1 = "Expenses";
    }
    else
    {
        if($row["type"] == 2)
        {
            $type = "Income";
            $type1 = "Income";
        }
        else
        {
            $type = "Advance Cash Paid";
            $type1 = "Balance";
        }
    }

    $sql3 = "SELECT * FROM account WHERE sub='$id'";
    $result3 = $conn->query($sql3);
    while($row3 = $result3->fetch_assoc())
    {
        $code1 = $row3["code"];

        $sql4 = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE code='$code1' AND date BETWEEN '$thismonth' AND '$today'";
        $result4 = $conn->query($sql4);
        $row4 = $result4->fetch_assoc();
        
        if($row["type"] == 1)
        {
            // $amount1 = (int)$amount;
            $amount1 += (float)$row4["debit"];
            // $amount1 += $debit1;
            // echo var_dump($amount1)."<br>";
        }
        else
        {
            
            if($row["type"] == 2)
            {
                $amount += $row4["credit"];
            }
            else
            {
                
                $amount += ($row4["credit"] - $row4["debit"]);
            }
        }

        // $sql4 = "SELECT sum(credit) AS credit,sum(debit) AS debit FROM expence_invoice WHERE code='$code1'";
        // $result4 = $conn->query($sql4);
        // $row4 = $result4->fetch_assoc();

        // if($row["type"] == 1)
        // {
        //     $amount1 += $row4["debit"];
        // }
        // else
        // {
        //     if($row["type"] == 2)
        //     {
        //         $amount1 += $row4["credit"];
        //     }
        //     else
        //     {
        //         $amount1 += ($row4["credit"] - $row4["debit"]);
        //     }
        // }

        // $sql5 = "SELECT sum(amount) AS amount FROM credits WHERE code='$code1'";
        // $result5 = $conn->query($sql5);
        // $row5 = $result5->fetch_assoc();
         
        // $temp1 = (int)$temp;
        // $amount2 = (int)$row5["amount"];
        // $temp1 += $amount2;
    }
    // echo $amount1;
    // exit();
    $sql6 = "SELECT * FROM account WHERE sub='$id' ORDER BY name ASC";
    $result6 = $conn->query($sql6);
    $amo = 0;
    while($row6 = $result6->fetch_assoc())
    {
        $code2 = $row6["code"];

        $sql7 = "SELECT sum(amount) as amount FROM credits WHERE code='$code2' AND date BETWEEN '$thismonth' AND '$today'";
        $result7 = $conn->query($sql7);
        $row7 = $result7->fetch_assoc();

        $amo += $row7["amount"];
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
	<meta name="description" content="Sub Account | Income Expense Manager" />
	
	<!-- OG -->
	<meta property="og:title" content="Sub Account | Income Expense Manager" />
	<meta property="og:description" content="Sub Account | Income Expense Manager" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Sub Account | Income Expense Manager</title>
	
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
								<div class="col-sm-5">
                                    <h4>Sub Account Details - <?php echo $row["name"] ?></h4>
								</div>
                                <div class="col-sm-5">
                                <?php
                                    if($row["type"] == 2)
                                    {
                                        echo "<h4 style='margin-bottom: 10px'>Total Outstanding : SAR ".number_format($temp - $amount1,2)."</h4>";
                                    }
                                ?>
                                </div>
								<div class="col-sm-1">
									<!-- <a onclick="printing()" id="printer" style="color: #fff" class="bg-primary btn">Print</a> -->
								</div>
								<div class="col-sm-1">
									<a href="#" onclick="history.back(1);" id="back" style="color: #fff" class="bg-primary btn">Back</a>
								</div>
							</div>
                            <p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
						</div>
                    </div>
                </div>
            </div>

            <div id="divid" class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
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
                            <div class="row" style="background-color: #B8F1CE;padding:10px 0;margin-top:10px">
								<div class="col-sm-12">
									<h6 style="color: #000">
                                    <center><?php echo $monthName ?></center>
                                    </h6>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>

            <div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
                        <div class="wc-title">
                            <div class="row">
                                <div class="col-sm-7">
                                <?php
                                    if($row["type"] != 3)
                                    {
                                ?>
                                    <h6><?php echo $type ?> Details</h6>
                                <?php
                                    }
                                ?>
                                </div>
                                <div class="col-sm-5">
                                    <h6 class="float-right">Total <?php echo $type ?> : SAR <?php echo number_format($amount1,2) ?></h6>
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
											<th>Total <?php echo $type1 ?> (SAR)</th>
                                        </tr>
                                    </thead>
									<tbody>

                                        <?php
                                            $sql1 = "SELECT * FROM account WHERE sub='$id'";
                                            $result1 = $conn->query($sql1);
                                            $count = 1;
                                            while($row1 = $result1->fetch_assoc())
                                            {
                                                $code = $row1["code"];

                                                $sql2 = "SELECT sum(credit) as credit,sum(debit) as debit FROM expence_invoice WHERE code='$code' AND date BETWEEN '$thismonth' AND '$today'";
                                                $result2 = $conn->query($sql2);
                                                $row2 = $result2->fetch_assoc();

                                                if($row2["debit"] == "")
                                                {
                                                    $row2["debit"] = 0;
                                                }
                                                if($row2["credit"] == "")
                                                {
                                                    $row2["credit"] = 0;
                                                }

                                        ?>
                                                <tr>
                                                    <td><center><?php echo $count++ ?></center></td>
                                                    <td><center><a href="account-details.php?id=<?php echo $row1["id"]."&fdate=".$thismonth."&tdate=".$today ?>"><?php echo $row1["name"] ?></a></center></td>
                                        <?php
                                                    if($row["type"] == 1)
                                                    {
                                                        echo '<td><center>'.number_format($row2["debit"],2).'</center></td>';
                                                    }
                                                    else
                                                    {
                                                        if($row["type"] == 2)
                                                        {
                                                            echo '<td><center>'.number_format($row2["credit"],2).'</center></td>';
                                                        }
                                                        else
                                                        {
                                                            echo '<td><center>'.number_format($row2["credit"]-$row2["debit"],2).'</center></td>';
                                                        }
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
				<!-- Your Profile Views Chart END-->
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
</script>
<script>
	function boss(val)
	{
		if(val != "")
		{
			// location.replace("https://www.conservesolution.com/incomemgmt/subaccounts.php?ids="+val+"&id=<?php echo $id ?>");
            window.location.href ="subaccounts.php?ids="+val+"&id=<?php echo $id ?>";
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
                window.location.href = "subaccounts.php?fdate="+fdate+"&tdate="+tdate+"&id=<?php echo $id ?>"
				// location.replace("https://www.conservesolution.com/incomemgmt/subaccounts.php?fdate="+fdate+"&tdate="+tdate+"&id=<?php echo $id ?>");
			}
		}
	}
</script>
</body>
</html>