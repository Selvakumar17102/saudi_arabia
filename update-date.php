<?php
	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

    $sql = "SELECT id,enqdate FROM enquiry";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $enq_id = $row['id'];
        $enq_date = $row['enqdate'];

        $sql1 = "UPDATE project SET enq_date='$enq_date' WHERE eid='$enq_id'";
        $conn->query($sql1);
    }

?>