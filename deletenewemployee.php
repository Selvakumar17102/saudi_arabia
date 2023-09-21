<?php
   ini_set('display_errors','off');
   include("session.php");
   include("inc/dbconn.php");
    
    $id = $_REQUEST["id"];

    $sql = "DELETE FROM login WHERE id='$id'";
    if($conn->query($sql) === TRUE)
    {
        header("location: newemployees.php?msg=Deleted!");
    }
?>