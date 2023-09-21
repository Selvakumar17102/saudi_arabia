<?php

    include("inc/dbconn.php");

    $id = $_REQUEST["id"];

    $sql = "SELECT * FROM expence_invoice WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row["mode"] == "Cash")
    {
        $sql1 = "SELECT * FROM expence_main WHERE id='1'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();

        $cash = $row1["balance"];

        $cash = $cash + $row["debit"] - $row["credit"];

        $sql2 = "UPDATE expence_main SET balance='$cash' WHERE id='1'";
        if($conn->query($sql2) === TRUE)
        {
            $sql3 = "DELETE FROM expence_invoice WHERE id='$id'";
            if($conn->query($sql3) === TRUE)
            {
                header("location: income.php?msg=Entry Deleted!");
            }
        }
    }
    else
    {
        $bank = $row["bank"];

        $sql1 = "SELECT * FROM expence_main WHERE id='$bank'";
        $result1 = $conn->query($sql1);
        $row1 = $result1->fetch_assoc();

        $cash = $row1["balance"];

        $cash = $cash + $row["debit"] - $row["credit"];

        $sql2 = "UPDATE expence_main SET balance='$cash' WHERE id='$bank'";
        if($conn->query($sql2) === TRUE)
        {
            $sql3 = "DELETE FROM expence_invoice WHERE id='$id'";
            if($conn->query($sql3) === TRUE)
            {
                header("location: income.php?msg=Entry Deleted!");
            }
        }

    }
?>