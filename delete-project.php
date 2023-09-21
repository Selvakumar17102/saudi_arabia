<?php
    ini_set('display_errors','off');
    include("session.php");
    include("inc/dbconn.php");
    $id = $_REQUEST['id'];

    // $sql1 = "UPDATE project SET nostatus='0' WHERE id = '$id'";
    // if($conn->query($sql1) === TRUE)
    // {
    //     header("location: all-projects.php?msg=Project Deleted!");
    // }
    // else
    // {
    //     header("location: all-projects.php?msg=Project Not Deleted!");
    // }

    $sql = "SELECT proid FROM project WHERE eid='$id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $project_id = $row['proid'];

        $sql1 = "DELETE FROM invoice WHERE pid='$project_id'";
        $conn->query($sql1);
        
    }
    $sql = "DELETE project WHERE eid='$id'";
    if($conn->query($sql)==TRUE)
    {
        $sql = "DELETE enquiry WHERE id='$id'";
        if($conn->query($sql)==TRUE)
        {
           header("location: all-projects.php?msg=Deleted!");
        }else{
            header("location: all-projects.php?msg=Failed!");
        }
    }else{
        header("location: all-projects.php?msg=Failed!");
    }

?>