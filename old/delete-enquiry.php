<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
$sql1 = "DELETE FROM enquiry WHERE id = '$id'";
if($conn->query($sql1) === TRUE)
{
    header("location: all-enquiry.php?msg=Enquiry Deleted!");
}
else
{
    header("location: all-enquiry.php?msg=Enquiry Not Deleted!");
}
?>