<?php
    include("session.php");
    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $ids = $_POST["ids"];
    $sdate = $_POST["sdate"];

    $sql = "UPDATE invoice SET subdate='$sdate',paystatus='1' WHERE id='$ids'";
    if($conn->query($sql) === TRUE)
    {
        header("location: invoice.php?id=$id");
    }
?>