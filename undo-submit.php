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
         // expence and income
         $current_sql = "SELECT * FROM invoice  WHERE id='$ids'";
         $current_result = $conn->query($current_sql);
         $current_row = mysqli_fetch_array($current_result);
         $current_value = $current_row['current'];
        //  $current_value = (int)$current_value;
         $current_gst_value = $current_row['current_gst'];
        //  $current_gst_value = (int)$current_gst_value;
         $current_mood = $current_row['mode']; 
           $bank_type = $current_row['bank_type'];
 
         if($current_mood == "Cash")
         {
             $sql_expence = "SELECT * FROM expence_main WHERE name = 'cash'";
         }else{
             $sql_expence = "SELECT * FROM expence_main WHERE name = 'Alinma'";
         }
         // Expence table entery//
 
         $result_expence = $conn->query($sql_expence);
         $row_expence = mysqli_fetch_array($result_expence);
         $balance = $row_expence['balance'];
        //  $balance = (int)$balance;
         if($current_mood == "Cash")
         {
             $update_balance  =  $balance - $current_value - $current_gst_value;
             $sql_expence_update = "UPDATE expence_main SET balance = '$update_balance' WHERE name = 'cash'";
         }else{
             $update_balance  = $balance - $current_value - $current_gst_value;
             
             $sql_expence_update = "UPDATE expence_main SET balance = '$update_balance' WHERE name = 'Alinma'";
         }
         $result_expence_update = $conn->query($sql_expence_update);
         
         $income_sql = "DELETE FROM expence_invoice WHERE invoice_id = '$ids'";
         $conn->query($income_sql);
 
         $credit_sql = "DELETE FROM credits WHERE invoice_id = '$ids'";
         $conn->query($credit_sql);
 
         $sector_sql = "DELETE FROM sector WHERE invoice_id = '$ids'";
         $conn->query($sector_sql);
         // expence and invocmr
         $sql = "UPDATE invoice SET paystatus='1' WHERE id='$ids'";
    }
    if($conn->query($sql) === TRUE)
    {
        header("location: invoice.php?id=$id");
    }
?>