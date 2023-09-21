<?php

   session_start();
   require_once("inc/dbconn.php");
   
   if(!isset($_SESSION['username']))
   {  
      header("location:index.php");
   }

?>