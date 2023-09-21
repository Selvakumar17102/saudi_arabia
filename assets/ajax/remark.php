<?php
    include("../../inc/dbconn.php");
    
    
    // $id = $_POST['id'];
    // $value = $_POST['value'];
    // $type = $_POST['type'];

    // if($type == 1){
    //     $sql = "UPDATE invoice SET remrk='$value' WHERE id='$id'";
    //     $conn->query($sql);
    // }else{
    //     $sql = "UPDATE project SET inv_remrk='$value' WHERE id='$id'";
    //     $conn->query($sql);
    // }

    
    $output = array();

    if(!empty($_POST['id'])){
        $id = $_POST['id'];
        $value = $_POST['value'];
        $type = $_POST['type'];

        if($type == 1){
            $sql = "UPDATE invoice SET remrk='$value' WHERE id='$id'";
            if($conn->query($sql) == TRUE){
                $output['sql'] = "$sql";
                $output['status'] = 'success';
                $output['message'] = 'Status updated';
            } else{
                $output['sql'] = "$sql";
                $output['status'] = 'fail';
                $output['message'] = 'Status failed';
            }
        }else{
            $sql = "UPDATE project SET inv_remrk='$value' WHERE id='$id'";
            if($conn->query($sql) == TRUE){
                $output['sql'] = "$sql";
                $output['status'] = 'success';
                $output['message'] = 'Status updated';
            } else{
                $output['sql'] = "$sql";
                $output['status'] = 'fail';
                $output['message'] = 'Status failed';
            }
        }
    }
    echo json_encode($output);
?>