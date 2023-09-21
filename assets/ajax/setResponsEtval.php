<?php
 include("../../inc/dbconn.php");
 
    if(!empty($_POST['proid'])){
        if(!empty($_POST["res"]))
        {
            $res = $_POST["res"];
    
            $proid = $_POST["proid"];
           
            $sql = "UPDATE project SET payment_responsibility='$res' WHERE proid='$proid'";
            $conn->query($sql);
        }
        if(!empty($_POST["et_value"]))
        {
            $et_value = $_POST["et_value"];
    
            $proid = $_POST["proid"];
           
            $sql = "UPDATE project SET et_value='$et_value' WHERE proid='$proid'";
        $conn->query($sql);
        }
        if(!empty($_POST["remark"]))
        {
            $remark = $_POST["remark"]; 
    
            $proid = $_POST["proid"];
           
            $sql = "UPDATE project SET remark='$remark' WHERE proid='$proid'";
        $conn->query($sql);
        } 
    }
?>