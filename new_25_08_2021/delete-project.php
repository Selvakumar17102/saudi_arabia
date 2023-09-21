<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
$sql1 = "UPDATE project SET nostatus='0' WHERE id = '$id'";
if($conn->query($sql1) === TRUE)
{
    header("location: all-projects.php?msg=Project Deleted!");
}
else
{
    header("location: all-projects.php?msg=Project Not Deleted!");
}
?>