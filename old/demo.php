<?php
    $thismonth = date('Y-m-d',strtotime("1-10-2020"));
    $today = date('Y-m-d',strtotime("12-10-2020"));
    $recdate = date('Y-m-d',strtotime("10-10-2020"));

    if (($recdate <= $thismonth) && ($recdate >= $today))
    {
        
    }
?>