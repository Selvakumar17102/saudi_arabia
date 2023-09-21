<?php
    include("../../inc/dbconn.php");

    if(!empty($_POST['proid']))
    {
        $proid = $_POST['proid'];
        $val = $_POST['val'];

        $sql = "UPDATE project SET et_value='$val' WHERE proid='$proid'";
        $conn->query($sql);
    }
    if(!empty($_POST['remark']))
    {
        $proid = $_POST['proid'];
        $remark = $_POST['remark'];

        $sql = "UPDATE project SET remark='$remark' WHERE proid='$proid'";
        $conn->query($sql);
    }
    if(!empty($_POST['details']))
    {
        $proid = $_POST['proid'];
        $details = $_POST['details'];

        $sql = "UPDATE project SET contact_details='$details' WHERE proid='$proid'";
        $conn->query($sql);
    }
?>