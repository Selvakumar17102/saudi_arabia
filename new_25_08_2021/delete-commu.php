<?php
	include("session.php");
    include("inc/dbconn.php");
	$user=$_SESSION["username"];
	date_default_timezone_set("Asia/Qatar");
    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM commu WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $ids = $row["pid"];

    $sql = "DELETE FROM commu WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        $time = date('y-m-d H:i:s');
        $sql2 = "INSERT INTO mod_details (enq_no,po_no,po,user_id,control,update_details,datetime) VALUES ('0','$ids','$id','$user','6','3','$time')";
		$conn->query($sql2);
		header("Location: view-project.php?id=$ids&msg=Communication Deleted!");
    }

?>