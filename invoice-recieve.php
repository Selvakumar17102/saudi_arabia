<?php
    include("session.php");
    include("inc/dbconn.php");
    date_default_timezone_set("Asia/Qatar");
    $user=$_SESSION["username"];

    $time = date('y-m-d H:i:s');

    $id = $_REQUEST["id"];

    $sql1 = "SELECT * FROM project WHERE id='$id'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();

	$eid = $row1["eid"];

    $ids = $_POST["ids"];
    $rdate = $_POST["rdate"];
    $mode = $_POST["mode"];
    $cur = $_POST["current"];
    $current_gst = $_POST["current_gst"];
    $current_tds = $_POST["current_tds"];
    $remarks = $_POST["remarks"];
    $docu = $_POST["docu"];

    $division = $row1['divi'];
    $mode1 = $mode.',';

    $sql = "UPDATE invoice SET current='$cur',current_gst='$current_gst',recdate='$rdate',paystatus='2',mode='$mode',remarks='$remarks',refdoc='$docu',current_tds='$current_tds' WHERE id='$ids'";
    if($conn->query($sql) === TRUE)
    {
        $main_acc_id_sql = "SELECT * FROM account WHERE account_id = '".$row1['proid']."'";
        $main_acc_id_result = $conn->query($main_acc_id_sql);
        $main_acc_id_row = mysqli_fetch_array($main_acc_id_result);
        $main_acc_id =  $main_acc_id_row['code']; 

        $division_sql = "SELECT * FROM division WHERE division = '$division'";
        $division_result = $conn->query($division_sql);
        $division_row = mysqli_fetch_array($division_result);
        $division_id = $division_row['id'];

        $account_sql = "INSERT INTO expence_invoice(invoice_id,date,mode,code,credit,descrip,type,vat,divi) VALUES('$ids','$rdate','$mode','$main_acc_id','$cur','$remarks','1','$current_gst','$division_id')";
        $account_result = $conn->query($account_sql);

        $credit_sql = "INSERT INTO credits(code,date,amount,descrip,invoice_id,divi,vat) VALUES('$main_acc_id','$rdate','$cur','$remarks','$ids','$division_id','$current_gst')";
        $credit_result = $conn->query($credit_sql);

        $expense_invice_sql = "SELECT id FROM expence_invoice ORDER BY id DESC";
        $expense_invice_result = $conn->query($expense_invice_sql);
        $expense_invice_row = mysqli_fetch_array($expense_invice_result);
        $expense_invice_id =  $expense_invice_row['id'];
         
        $sector_sql = "INSERT INTO sector(inv,divi,amount,date,invoice_id) VALUES('$expense_invice_id','$division_id','$cur','$rdate','$ids')";
        $conn->query($sector_sql); 
        // expence 
       
        if($mode == "Cash")
        {
            $bank_type = "";
            $sql_expence = "SELECT * FROM expence_main WHERE name = 'cash'";
        }else{
            $sql_expence = "SELECT * FROM expence_main WHERE name = 'Alinma'";
        }
            // Expence table entery//
            // $sql_expence;
            $result_expence = $conn->query($sql_expence);
            $row_expence = mysqli_fetch_array($result_expence);
            $balance = $row_expence['balance'];
            // $balance = (int)$balance;
            if($mode == "Cash")
            {
                $update_balance  = $cur + $balance;
                $sql_expence_update = "UPDATE expence_main SET balance = '$update_balance' WHERE name = 'cash'";
            }else{
                $update_balance  = $cur + $current_gst + $balance;
                $sql_expence_update = "UPDATE expence_main SET balance = '$update_balance' WHERE name = 'Alinma'";
            }
            $result_expence_update = $conn->query($sql_expence_update);
        // expence and income

        $sql1 = "INSERT INTO mod_details (enq_no,po_no,inv_no,user_id,control,update_details,datetime,content) VALUES ('$eid','$id','$ids','$user','4','2','$time','$mode1')";
        if($conn->query($sql1) === TRUE)
        {
            header("location: invoice.php?id=$id&msg=Invoice Recieved Successfully!");
        }
    }
?>