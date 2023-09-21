<?php

ini_set('display_errors','off');
include("session.php");
include("inc/dbconn.php");
$id = $_REQUEST['id'];
// 
$pro_id = $_REQUEST['pro_id'];

// Account Cheking
$cheeck_acc_sql = "SELECT * FROM account WHERE account_id='$pro_id'";
$cheeck_acc_result = $conn->query($cheeck_acc_sql);

if($cheeck_acc_result == TRUE){
    $cheeck_acc_row = mysqli_fetch_array($cheeck_acc_result);
    $sub_account = $cheeck_acc_row['sub'];
    // Sub ACCOUNT Cheking
    $cheek_sub_account_sql = "SELECT * FROM account WHERE sub='$sub_account'";
    $cheek_sub_account_result = $conn->query($cheek_sub_account_sql);
    
    if($cheek_sub_account_result->num_rows == 1){

       $sub_delete = "DELETE FROM account WHERE sub='$sub_account'";
       $conn->query($sub_delete);

       $main_delete = "DELETE FROM account WHERE code='$sub_account'";
       $conn->query($main_delete);
    }else{

        $sub_delete = "DELETE FROM account WHERE account_id='$pro_id'";
        $conn->query($sub_delete);
    }
}
// 
$sql = "SELECT * FROM enquiry WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$rfq = $row["rfqid"];

$sql1 = "DELETE FROM project WHERE eid='$id'";
if($conn->query($sql1) === TRUE)
{
    $sql2 = "DELETE FROM invoice WHERE rfqid='$rfq'";
    if($conn->query($sql2) === TRUE)
    {
        // $sql3 = "DELETE FROM enquiry WHERE id='$id'";
        // if($conn->query($sql3) === TRUE)
        // {
            header("location: all-projects.php?msg=Project Deleted!");
        // }
    }
}
?>