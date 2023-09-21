<?php
	include("session.php");
    include("inc/dbconn.php");
	$user=$_SESSION["username"];
	date_default_timezone_set("Asia/Qatar");

    $id = $_REQUEST["id"];
    $mid = $_REQUEST["mid"];

    $sql = "DELETE FROM invoice WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        $time = date('y-m-d H:i:s');
        $sql2 = "INSERT INTO mod_details (enq_no,po_no,po,user_id,control,update_details,datetime) VALUES ('0','$mid','0','$user','4','3','$time')";
		$conn->query($sql2);
		header("location: invoice.php?id=$mid&msg=Invoice Deleted!");
    }

?>