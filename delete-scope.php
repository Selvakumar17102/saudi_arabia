<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];
    $m = $_REQUEST["m"];

    $sql1 = "SELECT * FROM scope WHERE id='$id'";
    $result1 = $conn->query($sql1);
    if($result1->num_rows > 1)
    {
        $sql = "DELETE FROM scope WHERE id='$id'";
        if($conn->query($sql) === TRUE)
        {
            header("Location: new-project.php?id=$m");
        }
    }
    else
    {
        header("Location: new-project.php?id=$m&msg=Final scope can not be deleted!");
    }
?>