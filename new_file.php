<?php

	ini_set('display_errors','off');
	include("session.php");
	include("inc/dbconn.php");

    $sql = "SELECT * FROM new_table";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $proid = $row['pro_id'];

        $sql1 = "SELECT * FROM project WHERE proid='$proid'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();

        $eid = $row1['eid'];

        $sql2 = "UPDATE enquiry SET new_status='1' WHERE id='$eid'";
        $conn->query($sql2);
    }
?>