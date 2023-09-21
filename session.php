<?php

   session_start();
   require_once("inc/dbconn.php");
   if(!isset($_SESSION['username']))
   {  
      header("location:index.php");
   }else{
      if(!isset($_SESSION['saudi_branch']))
      {  
         header("location:index.php");
      }else{
         $sql = "SELECT * FROM login WHERE BINARY username = '".$_SESSION['username']."'";
         $result = $conn->query($sql);
         if($result->num_rows > 0)
         { 
            $row = $result->fetch_assoc();
            if($row['location'] == $_SESSION['saudi_branch']){
               
            }else{
               header("location:index.php");
            }
         }
      }
   }
   $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   $url_session = $_SESSION['update_url'];
   
   if($actual_link != $url_session ){
       $_SESSION['page_no'] = 0; 
   }
?>
