<?php 
$host="localhost"; // Host name 
$username="prjmgmtqatar"; // Mysql username 
$password="flXO#b20&Qry"; // Mysql password 
$db_name="prjmgmtqatar"; // Database name 
$conn=mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db($conn,"$db_name")or die("cannot select DB");
?>