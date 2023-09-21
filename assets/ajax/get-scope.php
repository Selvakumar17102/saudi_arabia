<?php
    include("../../inc/dbconn.php");

    if(!empty($_POST['division']))
    {
        $divi = $_POST['division'];
        $sub_divi = $_POST['sub_divi'];

        if($sub_divi =="DEPUTATION")
        {
            $sub_divi ="1";
        }
        else
        {
            $sub_divi = "2";
        }
        ?>
            <option value="" selected value disabled>Select Scope</option>
        <?php
        $sql = "SELECT * FROM scope_list WHERE divi='$divi' AND sub_divi='$sub_divi'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc())
        {
            ?>
                <option value="<?php echo $row['id'];?>"><?php echo $row['scope'];?></option>
            <?php
        }
        ?>
            <option value="others">others</option>
        <?php
    }
?>