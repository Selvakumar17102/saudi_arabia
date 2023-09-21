<?php
    include("session.php");
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $ids = $_POST["ids"];
    $sdate = $_POST["sdate"];
    $today_date = date('Y/m/d');
    $due_date = date('Y/m/d',strtotime('+30 days',strtotime(str_replace('/', '-', $today_date))));
    $sql = "UPDATE invoice SET subdate='$sdate',paystatus='1',due_date = '$due_date' WHERE id='$ids'";
    if($conn->query($sql) === TRUE)
    {
        header("location: invoice.php?id=$id&msg=Invoice Submitted  Successfully!");
    }
?>