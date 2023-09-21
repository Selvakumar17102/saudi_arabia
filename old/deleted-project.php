<?php

ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];

$sql = "SELECT * FROM enquiry WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$rfq = $row["rfqid"];

$sql1 = "DELETE FROM project WHERE eid='$id'";
if($conn->query($sql1) === TRUE)
{
    $sql2 = "DELETE FROM invoice WHERE rfqid='$rfq'";
    if($conn->query($sql2) === TRUE)
    {
        $sql3 = "DELETE FROM enquiry WHERE id='$id'";
        if($conn->query($sql3) === TRUE)
        {
            header("location: all-projects.php?msg=Project Deleted!");
        }
    }
}
?>