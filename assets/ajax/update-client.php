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
            $value = 0;
        }
        else
        {
            $value = 1;
        }

        $sql = "UPDATE project SET inv='$value' WHERE id='$id'";
        $conn->query($sql);
    }
    if(!empty($_POST['pid']))
    {
        $pid = $_POST['pid'];
        $invoice_count = $_POST['invoice_count'];
        $invoice_month = $_POST['invoice_month'];

        $month = date('m', strtotime($invoice_month));
        $year = date('Y', strtotime($invoice_month));
        
        $sql = "SELECT * FROM invoice_traker WHERE proid='$pid' AND invoice_month='$month' AND invoice_year='$year'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $sql = "UPDATE invoice_traker SET invoice_count='$invoice_count',invoice_month='$month',invoice_year='$year',date='$invoice_month' WHERE proid='$pid'";
            if($conn->query($sql)==TRUE)
            {
                echo true;
            }else{
                echo false;
            }
        }else{
            $sql = "INSERT INTO invoice_traker (proid,invoice_count,invoice_month,invoice_year,date) VALUES ('$pid','$invoice_count','$month','$year','$invoice_month')";
            if($conn->query($sql)==TRUE)
            {
                echo true;
            }else{
                echo false;
            }
        }
    }
?>