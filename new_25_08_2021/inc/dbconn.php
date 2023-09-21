<?php 
$host="localhost"; // Host name 
$username="erpqatar"; // Mysql username 
$password="x4Tv7@E&@9R9%Wnc"; // Mysql password 
$db_name="erpqatar"; // Database name 
$conn=mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn,"$db_name")or die("cannot select DB");
?>