<?php
	ini_set('display_errors','off');
    include("inc/dbconn.php");

    $sql = "SELECT * FROM enquiry";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $rfqid = $row['rfqid'];
        $rfqid = strrev($rfqid);
        $rfqid_no = explode('_', $rfqid);
		$rfqid_no = explode('-', $rfqid_no[1]);
        $rfqid_no = $rfqid_no[0];

        $rfqid = strrev($rfqid);
        $rfqid_no = strrev($rfqid_no);
        
        $sql1 = "UPDATE enquiry SET rfqno='$rfqid_no' WHERE rfqid='$rfqid'";
        if($conn->query($sql1)==TRUE){
            header("location: set-rfq.php?msg=Updated");
        }else{
            header("location: set-rfq.php?msg=Updated");
        }
    }
?>