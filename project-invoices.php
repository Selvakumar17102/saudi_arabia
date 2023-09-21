<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");
	
	$id = $_REQUEST["id"];
	
	$sql = "SELECT * FROM enquiry WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$rfqid = $row["rfqid"];
	$name = $row["name"];
	$eid = $row["id"];

	$sql1 = "SELECT * FROM project WHERE eid='$eid'";
	$result1 = $conn->query($sql1);
	$row1 = $result1->fetch_assoc();

	$proid = $row1["proid"];
	$pterms = $row1["pterms"];
	$logo = $row1["logo"];
	$inv = $row1["invdues"];
	$divi = $row1["divi"];
	$eid = $row1["eid"];

	$scope_id = $row["scope"];
	$scope_type = $row['scope_type'];

	if($scope_type == 0)
	{
		$sql3 = "SELECT * FROM scope WHERE eid='$eid'";
		$result3 = $conn->query($sql3);
		if($result3->num_rows > 0)
		{
			if($result3->num_rows == 1){
				$row3 = $result3->fetch_assoc();
				$scope = $row3["scope"];
			} else{
				while($row3 = $result3->fetch_assoc())
				{
					$scope .= $row3["scope"].",";
				}
			}
		}else{
			$scope = $row["scope"];
		}
	}
	else
	{
		$sql3 = "SELECT * FROM scope_list WHERE id='$scope_id'";
		$result3 = $conn->query($sql3);
		if($result3->num_rows > 0)
		{
			$row3 = $result3->fetch_assoc();
			$scope = $row3["scope"];	
		}else{
			$scope = $row["scope"];
		}
	}


	// $sql2 = "SELECT * FROM scope WHERE eid='$eid'";
	// $result2 = $conn->query($sql2);
	// if($result2->num_rows > 0)
	// {
	// 	while($row2 = $result2->fetch_assoc())
	// 	{
	// 		$scope .= $row2["scope"]."<br>";
	// 	}
	// }
	// else
	// {
	// 	$sql2 = "SELECT * FROM enquiry WHERE id='$eid'";
	// 	$result2 = $conn->query($sql2);
	// 	$row2 = $result2->fetch_assoc();

	// 	$scope = $row2["scope"];
	// }

	$sql2 = "SELECT sum(current) as current,total FROM invoice WHERE rfqid='$rfqid'";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();

	$mid = $_REQUEST["mid"];

	$fdate = $_REQUEST["fdate"];
	$tdate = $_REQUEST["tdate"];

	if($mid == "")
	{
		$today = date('Y-m-d');
        $thismonth = date('Y-m-01');
        $monthName = "For The Month of - ".date("F Y");
	}
	else
	{
		if($mid < 10)
		{
			$mid = "0".$mid;
		}

		$thismonth = date('Y-'.$mid.'-01');
		$today = date("Y-m-t", strtotime($thismonth));
		$monthName = "For The Month of - ".date('F Y', mktime(0, 0, 0, $mid, 10));
	}

	if($fdate != "" && $tdate != "")
	{
		$today = $tdate;
        $thismonth = $fdate;
        $monthName = "From ".date('d-m-Y',strtotime($fdate))." To ".date('d-m-Y',strtotime($tdate));
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
	<meta name="description" content="All Statement | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="All Statement | Project Management System" />
	<meta property="og:description" content="All Statement | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title><?php echo $name ?></title>
	
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
	<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>
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
				<div class="row r-p100">
					<div class="col-sm-11">
						<h4 class="breadcrumb-title">Statements</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
				</div>
			</div>

			<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30" >
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>						
                    <div id="printdiv" class="card m-b30 p-t30">
						<h4 class="breadcrumb-title" style="text-align: center;color: #214597;font-size: 30px;font-weight: bold;">Statements of Accounts</h4>
						<div class="row m-b30 p-b30">
							<div class="col-lg-6" >
								<img class="ttr-logo-mobile" alt="" style="padding-left: 20px;" src="assets/images/conserve-logo.png" width="200">
							</div>
							<div class="col-lg-6">
								<img class="ttr-logo-mobile" alt="" style="padding-right: 20px;float: right;" src="<?php echo $logo ?>" width="200">
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-6">
								<h5 style="padding-left: 20px;" >Project Name : <?php echo $name ?></h5>						
							</div>
							<div class="col-lg-6">
								<h5 style="padding-right: 20px;text-align: right;" >Project ID : <?php echo $proid ?></h5>						
							</div>
						</div>	
						<div class="row p-b30">
							<div class="col-lg-6">
								<h5 style="padding-left: 20px;" >Scope : <?php echo $scope ?></h5>
							</div>
							<div class="col-lg-6">
								<h5 style="padding-right: 20px;text-align: right;" >Division : <?php echo $divi ?></h5>						
							</div>
						</div>	

                        <div class="card-content" >
                            <div class="table-responsive">
                    	        <table id="dataTableExample1" class="table table-striped" style="border:0px solid black;">
                                    <thead>
                                        <tr style="border-bottom: 1px solid #000;">
                                            <th>S.NO</th>
											<th>PO No</th>
											<th>Invoice No</th>
											<th style="color: #C54800">Invoice Prepared Date</th>
                                            <th>Invoice Submitted Date</th>
											<th>Invoice Value (QAR)</th>
											<?php
												if($pterms == 2)
												{
											?>
											<th>Payment For The Month Of</th>
											<?php
												}
												// else
												// {
											?>
											<!-- <th>Payment Terms</th> -->
											<?php
												// }
											?>
											<th>Received Date</th>
											<th>Received Amount (QAR)</th>
											<th>Remarks</th>
                                        </tr>
                                    </thead>
									<tbody>
									
										<?php
											$sql1 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND po!='' ORDER BY date ASC";
											$result1 = $conn->query($sql1);
											$count = 1;
											$amo1 = $amo2 = $pend = $tot = 0;
											while($row1 = $result1->fetch_assoc())
											{
												
                                                if($row1['current'] == $row1['demo'])
                                                {
                                                    continue;
                                                }
												$pid = $row1["pid"];

												$sql2 = "SELECT * FROM project WHERE proid='$pid'";
												$result2 = $conn->query($sql2);
												$row2 = $result2->fetch_assoc();

												$invdues = $row2["invdues"];

												$color = "";
												if($row1["paystatus"] == 0)
												{
													$term = "Generated";
													$recdate = $recam = $rem = "-";
												}
												if($row1["paystatus"] == 1)
												{
													$term = "Submitted";
													$recdate = $recam = $rem = "-";
												}
												if($row1["paystatus"] == 2)
												{
													$term = "Recieved";
													$recdate = date('d/m/Y',strtotime($row1["recdate"]));
													$recam = $row1["current"];
													$rem = $row1["remarks"];
												}

												if($recam != '-')
												{
													$amo2 += $recam;
												}
												if($row1['subdate'] !="")
												{
													$amo1 += $row1["demo"];
												}

												$sub = $row1["subdate"];
												$rec = $row1["recdate"];
												$newdate = date('Y-m-d',strtotime($sub.'+'.$invdues.' days'));
								
												if(($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today)))
												{
													if($row1["paystatus"] == 2)
													{
														$tot += $row1["demo"] - $row1["current"];
													}
													else
													{
														// $color = "#FF5733";
														$tot += $row1["demo"];
													}
												}
												if($row1['subdate'] !="")
												{
													if($row1["paystatus"] != 2)
													{
														$pend += $row1["demo"];
													}
													else
													{
														if($row1["recdate"] > $today)
														{
															$pend += ($row1["demo"] - $row1["current"]);
														}
														else
														{
															$pend += ($row1["demo"] - $row1["current"]);
														}
													}
												}
										?>
										
												<tr style="border-bottom: 1px solid #000;">
													<td><center><?php echo $count++ ?></center></td>	
													<td><center><?php echo $row1["po"] ?></center></td>
													<td><center><?php echo $row1["invid"] ?></center></td>													
													<td><center><?php echo date('d/m/Y',strtotime($row1["date"])) ?></center></td>
													<?php
													if($row1['subdate'] != null)
													{
														?>
															<td style="background-color: <?php echo $color ?>"><center><?php echo date('d/m/Y',strtotime($row1["subdate"])) ?></center></td>
														<?php
													}else{
														?>
															<td><center>-</center></td>
														<?php
													}
													?>
													<td><center><?php echo number_format($row1["demo"],2) ?></center></td>
													<?php 
														if($pterms == 2)
														{
															?>
																<td><center><?php echo $row1["month"];?></center></td>
															<?php
														}
														// else
														// {
															?>
																<!-- <td><center><?php echo $row1["percent"]."%";?></center></td> -->
															<?php
														// }
													?>
													</center></td>
													<td><center><?php echo $recdate ?></center></td>
													<td><center><?php echo number_format($recam,2) ?></center></td>
													<td><center><?php echo $rem ?></center></td>
												</tr>
												
										<?php
											}
										?>
								</tbody>
                            </div>
                        </div>
						
                    </div>

					<div class="row">
						<div class="col-sm-11">
						</div>
						<div class="col-sm-1">
							<input type="submit" name="print" value="Print" style="color: #fff" onclick="demo('#printdiv')" class="bg-primary btn">
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
<script src="assets/js/admin.js"></script>
 <script>
// Start of jquery datatable
	$('#dataTableExample1').DataTable({
		dom: 'Bfrtip',
		lengthMenu: [
			[ 50, 150, 200, -1 ],
			[ '50 rows', '150 rows', '200 rows', 'Show all' ]
		],
		buttons: [
			'excel'
		]
	});
</script> 

<script>
	function boss(val)
	{
		if(val != "")
		{
			location.replace("statement-main.php?id=<?php echo $id ?>&mid="+val);
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
				location.replace("statement-main.php?mid=<?php echo $mid ?>&fdate="+fdate+"&tdate="+tdate);
			}
		}
	}
</script>
<script> 
       function demo(val)
    {
		//document.getElementById("action").style.display = "none";
		//document.getElementById("edit").style.display = "none";
        Popup($('<div/>').append($(val).clone()).html());
    } 
    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=700');
        mywindow.document.write('<style>@page{size:landscape;}</style><html><head><title></title>');
        mywindow.document.write('<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />');
        mywindow.document.write('<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/assets.css">');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/vendors/calendar/fullcalendar.css">');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/bootstrap.css">');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/dataTables.bootstrap4.min.css">');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/style.css">');
		mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print"/>');
        mywindow.document.write('<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">');
        mywindow.document.write('<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        return true;
    }
</script>
</body>
</html>