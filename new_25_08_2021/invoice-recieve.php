<?php
    include("session.php");
    include("inc/dbconn.php");
    date_default_timezone_set("Asia/Qatar");
    $user=$_SESSION["username"];

    $time = date('y-m-d H:i:s');

    $id = $_REQUEST["id"];

    $sql1 = "SELECT * FROM project WHERE id='$id'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

	$eid = $row1["eid"];

    $ids = $_POST["ids"];
    $rdate = $_POST["rdate"];
    $mode = $_POST["mode"];
    $cur = $_POST["current"];
    $remarks = $_POST["remarks"];
    $docu = $_POST["docu"];

    $mode1 = $mode.',';

    $sql = "UPDATE invoice SET current='$cur',recdate='$rdate',paystatus='2',mode='$mode',remarks='$remarks',refdoc='$docu' WHERE id='$ids'";
    if($conn->query($sql) === TRUE)
    {
        $sql1 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime,content) VALUES ('$eid','$id','$ids','$user','4','2','$time','$mode1')";
        if($conn->query($sql1) === TRUE)
        {
            header("location: invoice.php?id=$id");
        }
    }
?>