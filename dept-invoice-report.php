<?php

	ini_set('display_errors','off');
	session_start();
    $_SESSION['update_url'] = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
	include("session.php");
    include("inc/dbconn.php");
    $start_date = date("Y-m-01");
    $end_date = date("Y-m-t");
    $user_name  = $_SESSION["username"]; 
    
    $dep_array = array('Engineering','Sustainability','Acoustics','Laser Scanning');

    $dep_name = $_REQUEST["dept"]; 
    $res = $_REQUEST["res"];
    
    $page_num    = $_SESSION['page_no'];
    if(!in_array($dep_name, $dep_array))
    {
        $dep_name = "Simulation & Analysis";
    }
    $today = date('Y-m-d');
?>
<?php
    if(isset($_POST['save'])){
     $page_no = $_POST['page_number']; 
     $_SESSION['page_no'] = $page_no;
     $res = $_POST['res']; 
     $et_value = $_POST['et_value']; 
     $remark = $_POST['remark'];
     $pro_id = $_POST['pro_id'];    
     if($user_name == "Kavya" || $user_name == "vignesh" || $user_name == "venkat" || $user_name == "VaishaliLadole" || $user_name == "bazeeth" || $user_name == "femina" ||$user_name == "conserveadmin"){
        foreach ($pro_id as $key => $value) {
            $sql = "UPDATE project SET remark='$remark[$key]',payment_responsibility='$res[$key]',et_value='$et_value[$key]' WHERE proid='$value'";
            $conn->query($sql);
        }
    }else{
        foreach ($pro_id as $key => $value) {
            $sql = "UPDATE project SET remark='$remark[$key]',et_value='$et_value[$key]' WHERE proid='$value'";
            $conn->query($sql);
    }
}
       echo "<script>window.location.href = 'dept-invoice-report.php?dept=".$dep_name."&msg=Updated successfully'</script>";
    //    echo "<script>window.location.href = 'dept-invoice-report.php?dept=Engineering'</script>";
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
	<meta name="description" content="Pending Invoice Projects | Project Management System" />
	
	<!-- OG -->
	<meta property="og:title" content="Pending Invoice Projects | Project Management System" />
	<meta property="og:description" content="Pending Invoice Projects | Project Management System"/>
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Client Outstanding Projects | Project Management System</title>
	
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
					<div class="col-sm-10">
						<h4 class="breadcrumb-title">Projectwise Outstanding</h4>
					</div>
					<div class="col-sm-1">
						<a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
					</div>
					<div class="col-sm-1">
                        <a href="dept-invoice-excel.php?dept=<?php echo $dep_name;?>" class="btn btn-success">EXCEL</a>
					</div>
				</div>
			</div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <select name="res" id="res" class="form-control" onchange="get(this.value, '<?php echo $dep_name;?>')">
                        <option selected value disabled>Select Responsibility</option>
                        <?php
                            switch ($res) {
                                // case 'NAGARAJAN NEHRUJI':
                                //     $NAGARAJAN ="selected";
                                //     break;
                                case 'VENKATESH':
                                    $VENKATESH ="selected";
                                    break;
                                // case 'NAVEEN KUMAR':
                                //     $NAVEEN ="selected";
                                //     break;
                                // case 'VISWANATHAN':
                                //     $VISWANATHAN ="selected";
                                //     break;
                                // case 'BALAMURUGAN':
                                //     $BALAMURUGAN ="selected";
                                //     break;
                                // case 'SABIR':
                                //     $SABIR ="selected";
                                //     break;
                           
                                // case 'BAZEETH AHAMED':
                                //     $BAZEETH ="selected";
                                //     break;
                                // case 'KARTHIKEYAN':
                                //     $KARTHIKEYAN ="selected";
                                //     break;
                                // case 'GOPALAKRISHNAN':
                                //     $GOPALAKRISHNAN ="selected";
                                //     break;
                                // case 'MADHAN KUMAR':
                                //     $MADHAN ="selected";
                                //     break;
                                // case 'SHEIKH ABDULLAH':
                                //     $SHEIKH ="selected";
                                //     break;
                                // case 'RAMESH':
                                //     $RAMESH ="selected";
                                //     break;
                                // case 'Vaishali Ladole':
                                //     $VAISHALI ="selected";
                                //     break;
                                //     case 'Femina':
                                //         $Femina ="selected";
                                //         break;
                            }
                        ?>
                        <!-- <option value="NAGARAJAN NEHRUJI" <?php echo $NAGARAJAN;?>>NAGARAJAN NEHRUJI</option> -->
                        <option value="VENKATESH" <?php echo $VENKATESH;?>>VENKATESH</option>
                        <!-- <option value="NAVEEN KUMAR" <?php echo $NAVEEN;?>>NAVEEN KUMAR</option>
                        <option value="VISWANATHAN" <?php echo $VISWANATHAN;?>>VISWANATHAN</option>
                        <option value="BALAMURUGAN" <?php echo $BALAMURUGAN;?>>BALAMURUGAN</option> -->

                        <!-- <option value="BAZEETH AHAMED" <?php echo $BAZEETH;?>>BAZEETH AHAMED</option>
                        <option value="KARTHIKEYAN" <?php echo $KARTHIKEYAN;?>>KARTHIKEYAN</option>
                        <option value="MADHAN KUMAR" <?php echo $MADHAN;?>>MADHAN KUMAR</option>
                        <option value="SHEIKH ABDULLAH" <?php echo $SHEIKH;?>>SHEIKH ABDULLAH</option>
                        <option value="RAMESH" <?php echo $RAMESH;?>>RAMESH</option>
                        <option value="Vaishali Ladole" <?php echo $VAISHALI;?>>Vaishali Ladole</option>
                        <option value="Femina" <?php echo $Femina;?>>Femina</option> -->
                    </select>
                </div>
            </div>
            <div class="row m-b30">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="widget-inner">

                            <div class="table-responsive">
                            <form action="" method="post">
                                <div class="row" style="margin-bottom:5px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <?php
                                        if($_REQUEST['msg'] != "")
                                        {
                                         ?>  
                                         <div id="mymsg" style="background-color:#d1e7dd; border:1px solid #0f5132; border-radius: 15px;" >
                                            <p  style="text-align: center; color:#0f5132; margin-top: 10px;"><?php echo $_REQUEST['msg']; ?></p>
                                        </div>
                                       <?php }
                                        ?>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-1">
                                            <input type="hidden" id ="page_number" name="page_number">
                                        <button class="btn" type="submit" name="save" id="update" style="margin-bottom:5px;">Update</button>

                                    </div>
                                </div>
                                <table id="dataTableExample1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan = "2">Project Id</th>
                                            <th rowspan = "2">Project Name</th>
                                            <th rowspan = "2">Client Name</th>
                                            <th rowspan = "2">Responsibility</th>
                                            <th rowspan = "2">Estimate Value</th>
                                            <th>Collected(SAR)</th>
                                            <th>Outstanding(SAR)</th>
                                            <th>Due(SAR)</th>
                                            <th rowspan = "2">Contact Details</th>
                                            <th rowspan = "2">Remark</th>
                                        </tr>
                                        <tr>
                                            <th>
												<table>
													<td style="border:none;"><center>Value</center></td>
													<td style="border:none;"><center>VAT</center></td>
												</table>
											</th>
                                            <th>
												<table>
													<td style="border:none;"><center>Value</center></td>
													<td style="border:none;"><center>VAT</center></td>
												</table>
											</th>
                                            <th>
												<table>
													<td style="border:none;"><center>Value</center></td>
													<td style="border:none;"><center>VAT</center></td>
												</table>
											</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                            $sql12 = "SELECT * FROM project WHERE divi='$dep_name' AND status!='Commercially Closed'";
                                            
                                            if($res !=""){
                                                $sql12 .= " AND payment_responsibility='$res'";
                                            }
                                            $result12 = $conn->query($sql12);
                                            $total_estimated = 0;
                                            while ($row12 = $result12->fetch_assoc()) {
                                                $proid = $row12['proid'];
                                                $project_id = $row12['id'];
                                                $eid = $row12['eid'];
                                                $_responsibility = $row12['payment_responsibility'];
                                                $payment_responsibility = $row12['payment_responsibility'];
                                                $et_value = $row12['et_value'];
                                                $remark = $row12['remark'];
                                                $responsibility =  $row12['payment_responsibility']; 
                                                $details = "";
                                                
                                                $sql5 = "SELECT * FROM contact_details WHERE project_id='$proid'";  
                                                $result5 = $conn->query($sql5);
                                                if($result5->num_rows > 0){
                                                    while ($row5 = $result5->fetch_assoc()) {
                                                        $details .= $row5['name'].' - '.$row5['phone'].'<br>';
                                                    }
                                                }

                                                $sql4 = "SELECT * FROM enquiry WHERE id='$eid'";  
                                                $result4 = $conn->query($sql4);
                                                $row4 = $result4->fetch_assoc();

                                                $sql1 = "SELECT * FROM invoice WHERE pid='$proid' AND subdate!='' ORDER BY date ASC";
                                                
                                                $result1 = $conn->query($sql1);
                                                $count = 1;
                                                $amo1 = $amo2 = $pend = $pend_vat= $tot = $tot_vat = $total_collected = $total_collected_vat = 0;
                                                while($row1 = $result1->fetch_assoc())
                                                {
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

                                                    if($row1['recdate'] !=""){
                                                        if($row1['recdate'] >= $start_date && $row1['recdate'] <= $end_date){
                                                            $total_collected += $row1['current'];
                                                            $total_collected_vat += $row1['current_gst'];
                                                        }
                                                    }
                                    
                                                    if(($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today)))
                                                    {
                                                        if($row1["paystatus"] == 2)
                                                        {
                                                            $tot += $row1["demo"] - $row1["current"]; 
                                                            $tot_vat += $row1["demo_gst"] - $row1["current_gst"]; 
                                                        }
                                                        else
                                                        {
                                                            // $color = "#FF5733";
                                                            $tot += $row1["demo"];
                                                            $tot_vat += $row1["demo_gst"];
                                                        }                                                       
                                                    }
                                                     
                                                    // if($row1['subdate'] !="")
                                                    // {
                                                        if($row1["paystatus"] != 2)
                                                        {
                                                            $pend += $row1["demo"];
                                                            $pend_vat += $row1["demo_gst"];
                                                        }
                                                        else
                                                        {
                                                            if($row1["recdate"] > $today)
                                                            {
                                                                $pend += ($row1["demo"] - $row1["current"]);
                                                                $pend_vat += ($row1["demo_gst"] - $row1["current_gst"]);
                                                            }
                                                            else
                                                            {
                                                                $pend += ($row1["demo"] - $row1["current"]);
                                                                $pend_vat += ($row1["demo_gst"] - $row1["current_gst"]);
                                                            }
                                                        }
                                                        
                                                    // }
                                                }
                                               
                                                if($pend != 0 || $pend_vat !=0)
                                                {
                                                    ?>
                                                    
                                                        <tr>
                                                            <td><center><?php echo $row2['proid']?></center></td>

                                                            <td><center><a href="statement-main.php?id=<?php echo $eid;?>"><?php echo $row4['name'];?></a></center></td>
                                                            <td><center><?php echo $row4['cname'];?></center></td>
                                                           
                                                            <td>
                                                            <?php  
                                                                if($user_name == "Kavya" || $user_name == "vignesh" || $user_name == "venkat" || $user_name == "VaishaliLadole" || $user_name == "bazeeth" || $user_name == "femina" ||$user_name == "conserveadmin"){
                                                                   ?>
                                                                   <center>
                                                                    <select name="res[]" id="res1" class="form-control">
                                                                        <!-- onchange="set(this.value,'<>?php echo $proid;?>')" -->
                                                                        <option selected value disabled>Select Responsibility</option>
                                                                        <?php
                                                                            $NAGARAJAN = $VENKATESH = $NAVEEN = $VISWANATHAN = $BALAMURUGAN = $SABIR =  $BAZEETH = $KARTHIKEYAN = $MADHAN = $SHEIKH = $RAMESH = $VAISHALI = $Femina="";
                                                                            switch ($payment_responsibility) {
                                                                                // case 'NAGARAJAN NEHRUJI':
                                                                                //     $NAGARAJAN ="selected";
                                                                                //     break;
                                                                                case 'VENKATESH':
                                                                                    $VENKATESH ="selected";
                                                                                    break;
                                                                                // case 'NAVEEN KUMAR':
                                                                                //     $NAVEEN ="selected";
                                                                                //     break;
                                                                                // case 'VISWANATHAN':
                                                                                //     $VISWANATHAN ="selected";
                                                                                //     break;
                                                                                // case 'BALAMURUGAN':
                                                                                //     $BALAMURUGAN ="selected";
                                                                                //     break;
                                                                                // case 'SABIR':
                                                                                //     $SABIR ="selected";
                                                                                //     break;
                                                                                // case 'AJMAL':
                                                                                //     $AJMAL ="selected";
                                                                                //     break;
                                                                               
                                                                                // case 'KARTHIKEYAN':
                                                                                //     $KARTHIKEYAN ="selected";
                                                                                //     break;
                                                                                // case 'GOPALAKRISHNAN':
                                                                                //     $GOPALAKRISHNAN ="selected";
                                                                                //     break;
                                                                                // case 'MADHAN KUMAR':
                                                                                //     $MADHAN ="selected";
                                                                                //     break;
                                                                                // case 'SHEIKH ABDULLAH':
                                                                                //     $SHEIKH ="selected";
                                                                                //     break;
                                                                                // case 'RAMESH':
                                                                                //     $RAMESH ="selected";
                                                                                //     break;

                                                                                // case 'Vaishali Ladole':
                                                                                //     $VAISHALI ="selected";
                                                                                //     break;
                                                                                // default:
                                                                                //     $VAISHALI = "selected";
                                                                                //     break;
                                                                                //     case 'Femina':
                                                                                //         $Femina ="selected";
                                                                                //         break;
                                          
                                                                            }
                                                                        ?>
                                                                        <!-- <option value="NAGARAJAN NEHRUJI" <?php echo $NAGARAJAN;?>>NAGARAJAN NEHRUJI</option> -->
                                                                        <option value="VENKATESH" <?php echo $VENKATESH;?>>VENKATESH</option>
                                                                        <!-- <option value="NAVEEN KUMAR" <?php echo $NAVEEN;?>>NAVEEN KUMAR</option>
                                                                        <option value="VISWANATHAN" <?php echo $VISWANATHAN;?>>VISWANATHAN</option>
                                                                        <option value="BALAMURUGAN" <?php echo $BALAMURUGAN;?>>BALAMURUGAN</option>
                                                                        <option value="BAZEETH AHAMED" <?php echo $BAZEETH;?>>BAZEETH AHAMED</option>
                                                                        <option value="KARTHIKEYAN" <?php echo $KARTHIKEYAN;?>>KARTHIKEYAN</option>
                                                                        <option value="MADHAN KUMAR" <?php echo $MADHAN;?>>MADHAN KUMAR</option>
                                                                        <option value="SHEIKH ABDULLAH" <?php echo $SHEIKH;?>>SHEIKH ABDULLAH</option>
                                                                        <option value="RAMESH" <?php echo $RAMESH;?>>RAMESH</option>
                                                                        <option value="Vaishali Ladole" <?php echo $VAISHALI;?>>Vaishali Ladole</option>
                                                                        <option value="Femina" <?php echo $Femina;?>>Femina</option> -->
                                                                    </select>
                                                                </center>
                                                                   <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <center><?php echo $_responsibility;?>
                                                                    <?php
                                                                }
                                                            ?>
                                                            </td>
                                                            <td><center><div class="input-group mb-3">
 
                                                                <input class="form-control" type="text" name="et_value[]" id="et_value" value="<?php echo $et_value;?>" >
                                                                </div></center></td>
                                                              
                                                                <td>
                                                                    <table style="margin-top:-9px;">
                                                                        <td><center><?php echo number_format($total_collected, 2);?></center></td>
                                                                        <td><center><?php echo number_format($total_collected_vat, 2);?></center></td>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table style="margin-top:-9px;">
                                                                        <td><center><?php echo number_format($pend, 2);?></center></td>
                                                                        <td><center><?php echo number_format($pend_vat, 2);?></center></td>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table style="margin-top:-9px;">
                                                                        <td><center><?php echo number_format($tot, 2);?></center></td>
                                                                        <td><center><?php echo number_format($tot_vat, 2);?></center></td>
                                                                    </table>
                                                                </td>
                                                            <td><center><?php echo $details;?></center></td>
                                                            <td>
                                                                <center>
                                                                    <textarea name="remark[]" id="remark" class="form-control">
                                                                        <?php echo $remark;?>
                                                                    </textarea>
                                                                </center>
                                                                <input type="hidden" name="pro_id[]" value="<?php echo $row2['proid'];?>">   
                                                            </td>
                                                        </tr>
                                                        </form>
                                                    <?php
                                                    $total_estimated += $et_value;
                                                }
                                            }                                       
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <center>
                        Total Estimated Value <?php echo number_format($total_estimated, 2);?>
                    </center>
                    <div id="tableInfo">

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
    // alert("test");
    function boss(val)
	{
		if(val != "")
		{
			location.replace("https://conservesolution.com/projectmgmttool/invoice-due1.php?id="+val);
			// location.replace("http://localhost/project/invoice-due1.php?id="+val);
		}
	}
</script>
<script>
    $('#dataTableExample1').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [ 25, -1 ],
            [ '25 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength'
        ]          
    });
</script>
<script>
//     console.log("trst"); 
//      var table = $("#dataTableExample1").dataTable(); 
//         console.log(table.data);
//             table.on('draw', function (data) {
//                 console.log("table"); 
//                 // console.log(table.page.info().recordsDisplay);
//             });
// </script>
<script>
    function setValue(proid){
       // alert(proid)
        let val =$('#et_value'+proid).val();
      //  alert(val)
        $.ajax({
            type: "POST",
            url: "assets/ajax/outstanding_page.php",
            data:{'val':val,'proid':proid},
			success: function(data)
            {
                $("#none").html(data);
                $("#none").removeClass("loader");
                window.location.href='window.location.href'+'&msg=Estimate Value Updated'
            }
        });
    }
    function setRemark(remark,proid){
        $.ajax({
            type: "POST",
            url: "assets/ajax/outstanding_page.php",
            data:{'remark':remark,'proid':proid},
			success: function(data)
            {
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
    }
    function setContactDetails(details,proid){
        $.ajax({
            type: "POST",
            url: "assets/ajax/outstanding_page.php",
            data:{'details':details,'proid':proid},
			success: function(data)
            {
                console.log(data);
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
    }
    function get(val,dept)
    {
        location.replace("dept-invoice-report.php?res="+val+"&dept="+dept);
    }
    function set(val,proid) {
        $.ajax({
            type: "POST",
            url: "assets/ajax/set_responsibility.php",
            data:{'val':val,'proid':proid},
			success: function(data)
            {
                $("#none").html(data);
                $("#none").removeClass("loader");
            }
        });
    }
    function setResponsEtval(proid){
        var res = $('#res1').val();
        var et_value = $('#et_value').val();
        var remark = $('#remark').val();
        $.ajax({
            type: "POST",
            url: "assets/ajax/setResponsEtval.php",
            data:{'res':res,'et_value':et_value,'remark':remark,'proid':proid},
			success: function(data)
             {
                
            }
        });
    }
</script>
<script>
    $('#dataTableExample1_paginate').on('click', function(){
        var table = $('#dataTableExample1').DataTable();
            var info = table.page.info();
            var page = info.page;
            document.getElementById("page_number").value =page;
        });
    $('#update').on('click', function(){
    var table = $('#dataTableExample1').DataTable();
        var info = table.page.info();
        var page = info.page;
        document.getElementById("page_number").value =page;
    });
    $(document).ready(function(){

        var table_page = '<?php echo $page_num;?>';
        
        if(table_page != ""){

            var table1 = $('#dataTableExample1').dataTable();
           
            table1.fnPageChange(parseInt(table_page),true);
        }else{
            var table1 = $('#dataTableExample1').dataTable();
           
           table1.fnPageChange(0,true);
       }
        setTimeout(function() {
            $('#mymsg').fadeOut('fast');
        }, 2000);
    });
</script>

</body>
</html>
