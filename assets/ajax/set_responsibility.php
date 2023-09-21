<?php
    include("../../inc/dbconn.php");

    if(!empty($_POST["val"]))
    {
        $val = $_POST["val"];
        $proid = $_POST["proid"];

        $sql = "UPDATE project SET payment_responsibility='$val' WHERE proid='$proid'";
        $conn->query($sql);
    }
?>