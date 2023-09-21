<?php
    ini_set('display_errors', 'off');
    include("session.php");
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
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
	<meta property=" og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="assets/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>View Project List</title>

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
    <link rel="stylesheet" href="assets/css/print.css" type="text/css" media="print" />
</head>

<body class="ttr-pinned-sidebar">

    <!-- header start -->
    <?php include_once("inc/header.php"); ?>
    <!-- header end -->
    <!-- Left sidebar menu start -->
    <?php include_once("inc/sidebar.php"); ?>
    <!-- Left sidebar menu end -->

    <!--Main container start -->
    <main class="ttr-wrapper">
        <div class="container-fluid">
            <div class="db-breadcrumb">
                <div class="row r-p100">
                    <div class="col-sm-11">
                        <h4 class="breadcrumb-title"><?php echo $id;?></h4>
                    </div>
                    <div class="col-sm-1">
                        <a onclick="history.back(1);" href="#" style="color: #fff" class="bg-primary btn">Back</a>
                    </div>
                </div>
            </div>
            <div id="printdiv">
                <div class="card-content m-b5 m-t5">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped" style="border:0px solid black;">
                            <thead>
                                <tr style="border-bottom: 1px solid #000;">
                                    <th>S.NO</th>
                                    <th>project Name</th>
                                    <th>Project Id</th>
                                    <th>Contact Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM enquiry WHERE cname='$id' AND pstatus='AWARDED'";
                                    $result = $conn->query($sql);
                                    $loop = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $s = "";
                                        $rfqid = $row["rfqid"];
                                        $name = $row["name"];
                                        $eid = $row["id"];
                                        $scope_type = $row['scope_type'];
                                        $new_scope = $row['scope'];
                                        $division = $row['division'];

                                        $fdate = $_REQUEST["fdate"];
                                        $tdate = $_REQUEST["tdate"];

                                        $sql5 = "SELECT * FROM project WHERE eid='$eid'";
                                        $result5 = $conn->query($sql5);
                                        $row5 = $result5->fetch_assoc();

                                        if($row5['status'] == "Commercially Closed"){
                                            continue;
                                        }

                                        $division = $row5['divi'];
                                        $proid = $row5['proid'];
                                        $proid = $row5['proid'];
                                        $details = $row5['contact_details'];

                                        ?>
                                            <tr>
                                                <td><center><?php echo $loop++;?></center></td>
                                                <td><center><?php echo $name;?></center></td>
                                                <td><center><?php echo $proid;?></center></td>
                                                <td>
                                                    <center>
                                                        <a target="_blank" href="add-followup-contact.php?name=<?php echo rawurlencode(urldecode($id));?>&id=<?php echo $proid;?>" class="btn btn-success">Add</a>
                                                    </center>
                                                </td>
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
            $('#dataTableExample').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [50, 150, 200, -1],
                    ['50 rows', '150 rows', '200 rows', 'Show all']
                ],
                buttons: [
                    'pageLength', 'excel'
                ]
            });
    </script>

    <script>
        function boss(val) {
            if (val != "") {
                location.replace("statement-main.php?id=<?php echo $id ?>&mid=" + val);
            }
        }

        function search() {
            var fdate = document.getElementById('fdate').value;
            var tdate = document.getElementById('tdate').value;

            if (fdate == "") {
                $("#fdate").css("border", "1px solid red");
            } else {
                if (tdate == "") {
                    $("#tdate").css("border", "1px solid red");
                } else {
                    location.replace("statement-main.php?mid=<?php echo $mid ?>&fdate=" + fdate + "&tdate=" + tdate);
                }
            }
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

    </script>
    <script>
        function demo(val) {
            //document.getElementById("action").style.display = "none";
            //document.getElementById("edit").style.display = "none";
            Popup($('<div/>').append($(val).clone()).html());
        }

        function Popup(data) {
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