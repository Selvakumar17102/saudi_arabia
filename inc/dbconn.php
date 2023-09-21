<?php 
    $host="localhost"; // Host name 
    $username="saudiarabia"; // Mysql username 
    $password="S3rjdf@#4dF234@#L"; // Mysql password 
    $db_name="erpsaudiarabia"; // Database name 
    $conn=mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db($conn,"$db_name")or die("cannot select DB");

   $host1="localhost"; // Host name 
   $username1="saudiarabia"; // Mysql username 
   $password1="S3rjdf@#4dF234@#L"; // Mysql password 
   $db_name1="erpsaudiarabia"; // Database name 
   $conn1=mysqli_connect("$host1", "$username1", "$password1")or die("cannot connect"); 
   mysqli_select_db($conn1,"$db_name1")or die("cannot select DB");
?>
