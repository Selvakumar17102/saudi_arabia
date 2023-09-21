<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");

$id = $_REQUEST['id'];

$sql1 = "DELETE FROM enquiry WHERE id = '$id'";
if($conn->query($sql1) === TRUE)
{
    $sql = "SELECT * FROM project WHERE eid='$id'";
    $result = $conn->query($sql);
    if($result->num_rows > 0)
    {
        $sql1 = "DELETE FROM project WHERE eid = '$id'";
        if($conn->query($sql1) === TRUE)
        {
            header("location: entire-enquiry.php?msg=Enquiry Deleted!");        
        }else{
            header("location: entire-enquiry.php?msg=Project Not Deleted!");
        }
    }else{
        header("location: entire-enquiry.php?msg=Enquiry Deleted!");
    }
}
else
{
    header("location: entire-enquiry.php?msg=Enquiry Not Deleted!");
}
?>