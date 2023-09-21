<?php
ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
$sql1 = "UPDATE project SET nostatus='1' WHERE id = '$id'";
if($conn->query($sql1) === TRUE)
{
    header("location: deleted-projects.php?msg=Project Restored!");
}
else
{
    header("location: deleted-projects.php?msg=Project Not Restored!");
}
?>