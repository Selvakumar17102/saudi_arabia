<?php
	include("session.php");
    include("inc/dbconn.php");
	$user=$_SESSION["username"];
	date_default_timezone_set("Asia/Qatar");
    $id = $_REQUEST["id"];
    $m = $_REQUEST["m"];

    if($m == "")
    {
        $sql = "SELECT * FROM poss WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $ids = $row["pid"];

        $sql = "DELETE FROM poss WHERE id='$id'";
    }
    else
    {
        $sql = "UPDATE project SET po='',polink='' WHERE id='$id'";
        $ids = $id;
    }
    if($conn->query($sql) === TRUE)
    {
		$time = date('y-m-d H:i:s');
        $sql2 = "INSERT INTO mod_details (enq_no,po_no,po,user_id,control,update_details,datetime) VALUES ('0','$ids','$id','$user','5','3','$time')";
		$conn->query($sql2);
		header("Location: view-project.php?id=$ids&msg=Po Deleted!");
    }

?>