<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

	$user = $_SESSION["user"];
	$date = date("Y-m-d");

	$type = $_REQUEST['type'];
	$sdate = $_REQUEST['start_date'];
	$end_date = $_REQUEST['end_date'];

	$start = $end = "";
	$r1 = $r2 = $r3 = $s1 = $s2 = $s3 = $stage = "";

    switch ($type) {
        case '1':
            $sql1 = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND new_status='1'";
            $title = "Total Proposal";
            break;

        case '2':
            $sql1 = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND new_status='1' AND stage='Tender'";
            $title = "Total Tender";
            break;

        case '3':
            $sql1 = "SELECT * FROM enquiry WHERE qstatus='SUBMITTED' AND new_status='1' AND stage='Job In Hand'";
            $title = "Total Job in hand";
            break;

        case '4':
            $sql1 = "SELECT * FROM enquiry WHERE pstatus = 'AWARDED' AND new_status='1'";
            $title = "Total Awarded";
            break;

        case '5':
            $sql1 = "SELECT * FROM enquiry WHERE pstatus = 'LOST' AND new_status='1'";
            $title = "Total Lost";
            break;
    }

    if($sdate !="" && $end_date !="")
    {
		if($type != 5){
			$sql1 .= " AND enqdate BETWEEN '$sdate' AND '$end_date'";
		}else{
			$sql1 .= " AND qdatec BETWEEN '$sdate' AND '$end_date'";
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
	<meta name="description" content="Enquiry Followup | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Enquiry Followup | Project Management System" />
	<meta property="og:description" content="Enquiry Followup | Project Management System />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Proposal Report | Project Management System</title>
	
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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">

	<style>
		td{
			text-align: center !important;
		}
		.fa-caret-down:before {
			display: none;
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
						<h4 class="breadcrumb-title"><?php echo $title;?></h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
					<?php
						if($r != "" || $s != "")
						{
					?>
						<div class="col-sm-1">
							<a href="all-enquiry.php" style="color: #fff" class="bg-primary btn">Back</a>
						</div>
					<?php
						}
					?>
				</div>
			</div>	
			<div class="row">
				<!-- Data tables -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b30">
					<p style="text-align: center; color: green;"><?php echo $_REQUEST['msg']; ?></p>
                    <div class="card">

                        <div class="card-content">
                            <div class="table-responsive">
                    	        <table id="example1" class="display" cellspacing="0" width="100%">
                                    <thead>
                                       
                                        <tr>
											<th>S.NO</th>
											<th>Enquiry Date</th>
											<th>RFQ Id</th>
											<th>Project Name</th>
											<th>Project Location</th>
											<th>Division</th>
											<th>Stage</th>
											<th>Project Type</th>
											<th>Scope Of Work</th>
                                            <th>Client Name</th>
                                            <th>Responsibility</th>
                                            <th>Enquiry Status</th>
                                            <th>Notes</th>
                                            <th style="color: #C54800">Submission Deadline</th>
											<?php
												if($type == 5)
												{
											?>
													<th>Lost Date</th>
											<?php
												}
											?>
											<?php
												if($user == "conserveadmin")
												{
											?>
													<th>Last Updated</th>
											<?php
												}
											?>
                                        </tr>
                                    </thead>
									<tbody>
										<?php											
											$result1 = $conn->query($sql1);
											$count = 1;
											while($row1 = $result1->fetch_assoc())
											{
												$id = $row1["id"];
												$scope_id = $row1["scope"];
												$scope_type = $row1['scope_type'];

												$abbr = (explode("-",$row1['rfqid']));

												$sql6 = "SELECT * FROM mod_details WHERE enq_no='$id' AND control='1' ORDER BY id DESC LIMIT 1";
												$result6 = $conn->query($sql6);
												$row6 = $result6->fetch_assoc();
												if($row6["update_details"] == 1)
												{
													$s = "Created";
												}
												else
												{
													$s = "Edited";
												}
												$scope = "";

												if($scope_type == 0)
												{
													$sql = "SELECT * FROM scope WHERE eid='$id'";
													$result = $conn->query($sql);
													if($result->num_rows > 0)
													{
														if($result->num_rows == 1){
															$row = $result->fetch_assoc();
															$scope = $row["scope"];
														} else{
															while($row = $result->fetch_assoc())
															{
																$scope .= $row["scope"].",";
															}
														}
													}
												}
												else
												{
													$sql = "SELECT * FROM scope_list WHERE id='$scope_id'";
													$result = $conn->query($sql);
													if($result->num_rows > 0)
													{
														$row = $result->fetch_assoc();
														$scope = $row["scope"];	
													}
												}
												$date = strtotime($row1["qdate"]);
												echo '<tr style="background-color:'.$tempcolor.'">';
												echo '<td>'.$count.'</td>';
												echo '<td>'.date('d-m-Y', strtotime($row1["enqdate"])).'</td>';
												echo '<td>'.$row1["rfqid"].'</td>';
												echo '<td>'.$row1['name'].'</td>';
												echo '<td>'.$row1["location"].'</td>';
												echo '<td>'.$row1["rfq"].'</td>';
												echo '<td>'.$row1["stage"].'</td>';
												echo '<td>'.$row1["division"].'</td>';
												echo '<td>'.$scope.'</td>';
												echo '<td>'.$row1["cname"].'</td>';
												echo '<td>'.$row1["responsibility"].'</td>';
												echo '<td>'.$row1["qstatus"].'</td>';
												echo '<td>'.$row1["notes"].'</td>';
												echo '<td>'.date('d-m-Y', $date).'</td>';
												if($type == 5){
													if($row1['qdatec'] !="")
													{
														echo '<td>'.date('d-m-Y', strtotime($row1["qdatec"])).'</td>';
													}else{
														echo '<td>N/A</td>';
													}
												}
												if($user == "conserveadmin")
												{
											?>
													<td><center>
												<?php
														if($row6["user_id"] != "")
														{
															echo $s.' by '.$row6["user_id"].'<br>'.date('d-m-Y | h:i:s a',strtotime($row6["datetime"]));
														}
														else
														{
															echo "-";
														}
												?>
													</center></td>
											<?php	
												}
												echo '</tr>';
												$count++;
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
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendors/datatables/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js"></script>
<script src="assets/js/admin.js"></script>

<script>
 $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example1 thead tr').clone(true).appendTo( '#example1 thead' );
    $('#example1 thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#example1').DataTable( {      
		dom: 'Bfrtip',
        lengthMenu: [
            [ 15, 50, 100, -1 ],
            [ '15 rows', '50 rows', '100 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength','excel','print'
        ]
    } );
	
} );
</script>
</body>
</html>