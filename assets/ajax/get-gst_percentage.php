<?php
include("../../inc/dbconn.php");
if(isset($_POST['division'])){
    $division_name = $_POST['division'];

    $gst_percentage_sql = "SELECT * FROM division WHERE division = '$division_name'";
	$gst_percentage_result = $conn->query($gst_percentage_sql);
	$gst_percentage_row = mysqli_fetch_array($gst_percentage_result);
	$gst_percentage = $gst_percentage_row['gst_percentage'];
    echo $gst_percentage;
}
?>