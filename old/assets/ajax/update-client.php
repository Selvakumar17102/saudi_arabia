<?php

    include("../../inc/dbconn.php");

    if(!empty($_POST["cname"]))
    {
        $cname = $_POST["cname"];
        $id = $_POST["id"];

        $sql = "UPDATE enquiry SET cid='$id' WHERE cname='$cname'";
        $conn->query($sql);
    }
    if(!empty($_POST["value"]))
    {
        $value = $_POST["value"];
        $id = $_POST["id"];
        
        if($value == 1)
        {
            $value = "0";
        }
        else
        {
            $value = 1;
        }

        $sql = "UPDATE project SET inv='$value' WHERE id='$id'";
        $conn->query($sql);
    }
?>