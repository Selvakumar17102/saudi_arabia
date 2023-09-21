<?php
    include("../../inc/dbconn.php");

    if(!empty($_POST["status"]))
    {
        $status = $_POST["status"];
        $id = $_POST["id"];

        $sql = "UPDATE invoice SET receiving_status='$status' WHERE id='$id'";
        $conn->query($sql);
    }
    if(!empty($_POST["link"]))
    {
        $link = $_POST["link"];
        $id = $_POST["id"];

        $sql = "UPDATE invoice SET invdoc='$link' WHERE id='$id'";
        $conn->query($sql);
    }
?>