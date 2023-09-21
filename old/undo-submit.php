<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
    $idm = $_REQUEST["idm"];
    $ids = $_REQUEST["ids"];

    if($idm == "")
    {
        $sql = "UPDATE invoice SET paystatus='0' WHERE id='$ids'";
    }
    else
    {
        $sql = "UPDATE invoice SET paystatus='1' WHERE id='$ids'";
    }
    if($conn->query($sql) === TRUE)
    {
        header("location: invoice.php?id=$id");
    }
?>