<?php
    ini_set('display_errors', 'off');
    include("session.php");
    include("../../inc/dbconn.php");
?>


<?php
      if(isset($_POST['products']))
      {
       $id = $_POST['ids'];
       $products = $_POST['products'];
       $rowside["id"] = $_POST['rowside'];
       $control = $_POST['control'];
       $table_count = 0;
      foreach($products as $key => $product){
       
       $sql = "SELECT * FROM enquiry WHERE id='$products[$key]'";
       $result = $conn->query($sql);
       $num_statements = 0;
       while ($row = $result->fetch_assoc()) { 
         $s = "";
         $rfqid = $row["rfqid"];
         $name = $row["name"];
         $eid = $row["id"];
         $scope_type = $row['scope_type'];
         $new_scope = $row['scope'];
         $division = $row['division'];

         $fdate = $_REQUEST["fdate"];
         $tdate = $_REQUEST["tdate"];

         $sql5 = "SELECT * FROM project WHERE eid='$eid'";
         $result5 = $conn->query($sql5);
         $row5 = $result5->fetch_assoc();

         $division = $row5['divi'];
            if($row5['status'] == "Commercially Closed"){
               continue;
            }

            $logo = $row5['logo'];

            if ($mid == "") {
                  $today = date('Y-m-d');
                  $thismonth = date('Y-m-01');
                  $monthName = "For The Month of - " . date("F Y");
            } else {
                  if ($mid < 10) {
                     $mid = "0" . $mid;
                  }

                  $thismonth = date('Y-' . $mid . '-01');
                  $today = date("Y-m-t", strtotime($thismonth));
                  $monthName = "For The Month of - " . date('F Y', mktime(0, 0, 0, $mid, 10));
            }

            if ($fdate != "" && $tdate != "") {
                  $today = $tdate;
                  $thismonth = $fdate;
                  $monthName = "From " . date('d-m-Y', strtotime($fdate)) . " To " . date('d-m-Y', strtotime($tdate));
            }

               $sql12 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND date<='$today' AND po!='' ORDER BY date ASC";
               $result12 = $conn->query($sql12);
               if ($result12->num_rows > 0) {
                  $num_statements++;

                  $sql1 = "SELECT * FROM project WHERE eid='$eid'";
                  $result1 = $conn->query($sql1);
                  $row1 = $result1->fetch_assoc();

                  $proid = $row1["proid"];
                  $pterms = $row1["pterms"];
                  $inv = $row1["invdues"];

                  $scope_id = $row["scope"];
                  $scope_type = $row['scope_type'];

                  if ($scope_type == 0) {
                     $sql3 = "SELECT * FROM scope WHERE eid='$eid'";
                     $result3 = $conn->query($sql3);
                     if ($result3->num_rows > 0) {
                           if ($result3->num_rows == 1) {
                              $row3 = $result3->fetch_assoc();
                              $scope = $row3["scope"];
                           } else {
                              while ($row3 = $result3->fetch_assoc()) {
                                 $scope .= $row3["scope"] . ",";
                              }
                           }
                     } else {
                           $scope = $row["scope"];
                     }
                  } else {
                     $sql3 = "SELECT * FROM scope_list WHERE id='$scope_id'";
                     $result3 = $conn->query($sql3);
                     if ($result3->num_rows > 0) {
                           $row3 = $result3->fetch_assoc();
                           $scope = $row3["scope"];
                     } else {
                           $scope = $row["scope"];
                     }
                  }

                  $sql2 = "SELECT sum(current) as current,total FROM invoice WHERE rfqid='$rfqid'";
                  $result2 = $conn->query($sql2);
                  $row2 = $result2->fetch_assoc();

                  $mid = $_REQUEST["mid"];
                  $table_count++;
                  ?>
                        <div class="row m-b30 p-b30">
                           <div class="col-lg-6">
                              <h5 style="padding-left: 20px;">Project Name : <?php echo $name ?></h5>
                           </div>
                           <div class="col-lg-6">
                              <h5 style="padding-right: 20px;text-align: right;">Project ID : <?php echo $proid ?></h5>
                           </div>
                           <div class="col-lg-6">
                              <h5 style="margin-left: 20px;">Scope : <?php echo $scope ?></h5>
                           </div>
                           <div class="col-lg-6">
                              <h5 style="float: right;margin-right: 10px">Division : <?php echo $division ?></h5>
                           </div>
                        </div>
                        <div class="card-content m-b5 m-t5">
                        <div class="table-responsive">
                           <table id="filter_dataTableExample<?php echo $table_count++; ?>" class="table table-striped" style="border:0px solid black;">
                              <thead>
                                    <tr style="border-bottom: 1px solid #000;">
                                       <th rowspan="2">S.NO</th>
                                       <th rowspan="2">PO No</th>
                                       <th rowspan="2">Invoice No</th>
                                       <th rowspan="2" style="color: #C54800">Invoice Prepared Date</th>
                                       <th rowspan="2">Invoice Submitted Date</th>
                                       <th >Invoice Value (SAR)</th>
                                       <?php
                                       if ($pterms == 2) {
                                       ?>
                                          <th>Payment For The Month Of</th>
                                       <?php
                                       } else {
                                       ?>
                                          <th rowspan="2">Payment Terms</th>
                                       <?php
                                       }
                                       ?>
                                       <th rowspan="2">Received Date</th>
                                       <th>Received Amount (SAR)</th>
                                       <th rowspan="2">Remarks</th>
                                      <?php
                                         
                                       if ($rowside["id"] != 2) {
                                       ?>
                                          <?php
                                          if ($control == "1"  || $control == "3") {
                                          ?>
                                                <th rowspan="2" class="hide">Action</th>
                                          <?php
                                          }
                                          ?>
                                       <?php
                                       }
                                       ?>
                                    </tr>
                                    <tr>
                                       <th>
                                          <table>
                                                <tr>
                                                   <th style="border:none;width:100%;">&nbspValue</th>
                                                   <th style="border:none;">VAT&nbspValue</th>
                                                   <!-- <th style="border:none;">TDS&nbspValue</th> -->
                                                </tr>
                                          </table>
                                       </th>
                                       <th>
                                          <table>
                                          <tr>
                                          <th style="border:none;">&nbspValue</th>
                                                   <th style="border:none;">VAT&nbspValue</th>
                                                   <!-- <th style="border:none;">TDS&nbspValue</th> -->
                                          </tr>
                                          </table>
                                       </th>
                                    </tr>
                              </thead>
                              <tbody>

                                    <?php
                                    $sql1 = "SELECT * FROM invoice WHERE rfqid='$rfqid' AND date<='$today' AND po!='' ORDER BY date ASC";
                                    $result1 = $conn->query($sql1);
                                    $count = 1;
                                    $amo1 = $vat_amo1 = $amo2 = $vat_amo2 = $pend = $vat_pend = $tot = $vat_tot = 0;
                                    while ($row1 = $result1->fetch_assoc()) {
                                       $pid = $row1["pid"];
                                       $rem = $row1["remarks"];

                                       $sql2 = "SELECT * FROM project WHERE proid='$pid'";
                                       $result2 = $conn->query($sql2);
                                       $row2 = $result2->fetch_assoc();

                                       $invdues = $row2["invdues"];

                                       $color = "";
                                       if ($row1["paystatus"] == 0) {
                                          $term = "Generated";
                                          $recdate = $recam = "-";
                                       }
                                       if ($row1["paystatus"] == 1) {
                                          $term = "Submitted";
                                          $recdate = $recam = "-";
                                       }
                                       if ($row1["paystatus"] == 2) {
                                          $term = "Recieved";
                                          $recdate = date('d/m/Y', strtotime($row1["recdate"]));
                                          $recam = $row1["current"];
                                          $vat_recam = $row1["current_gst"];
                                       }

                                       if ($recam != '-') {
                                          $amo2 += $recam;
                                          $vat_amo2  += $vat_recam;
                                          $over_all_amo2 += $recam;
                                          $vat_over_all_amo2 += $vat_recam;
                                       }
                                       $amo1 += $row1["demo"];
                                       $vat_amo1 += $row1["demo_gst"];

                                       $over_all_amo1 += $row1["demo"];
                                       $vat_over_all_amo1 += $row1["demo_gst"];

                                       $sub = $row1["subdate"];
                                       $rec = $row1["recdate"];
                                       $newdate = date('Y-m-d', strtotime($sub . '+' . $invdues . ' days'));

                                       if (($newdate < $thismonth) || (($newdate >= $thismonth) && ($newdate <= $today))) {
                                          if ($row1["paystatus"] == 2) {
                                                $tot += $row1["demo"] - $row1["current"];
                                                $vat_tot += $row1["demo_gst"] - $row1["current_gst"];
                                                $over_all_tot += $row1["demo"] - $row1["current"];
                                                $vat_over_all_tot += $row1["demo_gst"] - $row1["current_gst"];
                                          } else {
                                                // $color = "#FF5733";
                                                $tot += $row1["demo"];
                                                $vat_tot += $row1["demo_gst"];
                                                $over_all_tot += $row1['demo'];
                                                $vat_over_all_tot += $row1['demo_gst'];
                                          }
                                       }
                                       if ($row1['subdate'] != "") {
                                          if ($row1["paystatus"] != 2) {
                                                $pend += $row1["demo"];
                                                $vat_pend += $row1["demo_gst"];
                                                $over_all_pend += $row1['demo'];
                                                $vat_over_all_pend += $row1['demo_gst'];

                                          } else {
                                                if ($row1["recdate"] > $today) {
                                                   $pend += ($row1["demo"] - $row1["current"]);
                                                   $vat_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                   $over_all_pend += ($row1["demo"] - $row1["current"]);
                                                   $vat_over_all_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                } else {
                                                   $pend += ($row1["demo"] - $row1["current"]);
                                                   $vat_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                   $over_all_pend += ($row1["demo"] - $row1["current"]);
                                                   $vat_over_all_pend += ($row1["demo_gst"] - $row1["current_gst"]);
                                                }
                                          }
                                       }
                                    ?>

                                       <tr style="border-bottom: 1px solid #000;">
                                          <td>
                                                <center><?php echo $count++ ?></center>
                                          </td>
                                          <td>
                                                <center><?php echo $row1["po"] ?></center>
                                          </td>
                                          <td>
                                                <center><?php echo $row1["invid"] ?></center>
                                          </td>
                                          <td>
                                                <center><?php echo date('d/m/Y', strtotime($row1["date"])) ?></center>
                                          </td>
                                          <td style="background-color: <?php echo $color ?>">
                                                <center>
                                                   <?php
                                                   if ($row1['subdate'] != "") {
                                                      echo date('d/m/Y', strtotime($row1["subdate"]));
                                                   } else {
                                                      echo "-";
                                                   }
                                                   ?>
                                                </center>
                                          </td>
                                          <td>
                                             <table style="margin-top:-8px;">
                                                <tr>
                                                   <td style="border:none;">SAR&nbsp<?php echo number_format($row1["demo"],2) ?></td>
                                                   <td style="border:none;">SAR&nbsp<?php echo number_format($row1["demo_gst"],2) ?></td>
                                                   <!-- <td style="border:none;">SAR<?php echo number_format($row1["demo_tds"],2) ?></td> -->
                                                </tr>
                                             </table>
                                          </td>
                                          <td>
                                                <center>
                                                   <?php
                                                   if ($pterms == 1) {
                                                      echo $row1["percent"] . "%";
                                                   } else {
                                                      echo $row1["month"];
                                                   }
                                                   ?>
                                                </center>
                                          </td>
                                          <td>
                                                <center><?php echo $recdate ?></center>
                                          </td>
                                          <td>
                                                <!-- <center><?php echo number_format($recam, 2) ?></center> -->
                                             <table style="margin-top:-8px;">
                                                <tr>
                                                   <td style="border:none;"><center>SAR<?php echo number_format($row1["current"],2) ?><center></td>
                                                   <td style="border:none;"><center>SAR<?php echo number_format($row1["current_gst"],2) ?><center></td>
                                                   <!-- <td style="border:none;"><center>SAR<?php echo number_format($row1["current_tds"],2) ?><center></td> -->
                                                </tr>
                                             </table>
                                          </td>
                                          <td>
                                                <center><?php echo $rem ?></center>
                                          </td>
                                          <?php
                                          if ($rowside["id"] != 2) {
                                          ?>
                                                <?php
                                                if ($control == "1"  || $control == "3") {
                                                ?>
                                                   <td class="hide">
                                                      <center><a href="edit-entry.php?id=<?php echo $row1["id"] . "&enq=" . $id ?>" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a></center>
                                                   </td>
                                                   <?php
                                                }
                                                   ?><?php
                                                }
                                                   ?>
                                       </tr>

                                    <?php
                                    }
                                    ?>
                              </tbody>
                           </table>
                           <table class="table table-striped" style="border:0px solid black;">
                              <thead>
                                    <tr>
                                       <th colspan="2">Total Invoiced Amount</th>
                                       <th colspan="2">Total Received Amount</th>
                                       <th colspan="2">Total Outstanding Amount</th>
                                       <th colspan="2">Total Due Amount</th>
                                    </tr>
                                    <tr>
                                       <th>Value</th>
                                       <th>VAT Value</th>
                                       <th>Value</th>
                                       <th>VAT Value</th>
                                       <th>Value</th>
                                       <th>VAT Value</th>
                                       <th>Value</th>
                                       <th>VAT Value</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <tr>
                                       <td><center>SAR <?php echo number_format($amo1, 2) ?></center></td>
                                       <td><center>SAR <?php echo number_format($vat_amo1, 2) ?></center></td>

                                       <td><center>SAR <?php echo number_format($amo2, 2) ?></center></td>
                                       <td><center>SAR <?php echo number_format($vat_amo2, 2) ?></center></td>
                                       
                                       <td><center>SAR <?php echo number_format($pend, 2) ?></center></td>   
                                       <td><center>SAR <?php echo number_format($vat_pend, 2) ?></center></td>

                                       <td><center>SAR <?php echo number_format($tot, 2) ?></center></td>
                                       <td><center>SAR <?php echo number_format($vat_tot, 2) ?></center></td>
                                    </tr>
                              </tbody>
                           </table>
                        </div>
                  </div>
                  <?php
               }
         }
      }
      if ($num_statements > 0) {
         ?>
         <div id="invoice_table" style="padding-top:50px;">
             <table class="table table-striped"  style="border:0px solid red;">
                 <thead>
                     <tr>
                        <th colspan="2"><center>Over All Invoiced</center></th>
                        <th colspan="2"><center>Over All Received</center></th>
                        <th colspan="2"><center>Over All Outstanding</center></th>
                        <th colspan="2"><center>Over All Due Amount</center></th>
                     </tr>
                     <tr>
                        <th>Value</th>
                        <th>VAT Value</th>
                        <th>Value</th>
                        <th>VAT Value</th>
                        <th>Value</th>
                        <th>VAT Value</th>
                        <th>Value</th>
                        <th>VAT Value</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                        <td><center>SAR <?php echo number_format($over_all_amo1, 2) ?></center></td>
                        <td><center>SAR <?php echo number_format($vat_over_all_amo1, 2) ?></center></td>

                        <td><center>SAR <?php echo number_format($over_all_amo2, 2) ?></center></td>
                        <td><center>SAR <?php echo number_format($vat_over_all_amo2, 2) ?></center></td>
                        
                        <td><center>SAR <?php echo number_format($over_all_pend, 2) ?></center></td> 
                        <td><center>SAR <?php echo number_format($vat_over_all_pend, 2) ?></center></td>
                           
                        <td><center>SAR <?php echo number_format($over_all_tot, 2) ?></center></td>
                        <td><center>SAR <?php echo number_format($vat_over_all_tot, 2) ?></center></td>
                     </tr>
                 </tbody>
             </table>
             
             <div class="row mt-5">
                 <div class="col-sm-11">
                 </div>
                 <div class="col-sm-1">
                     <input type="submit" name="print" value="Print" style="color: #fff" onclick="demo('#printdiv')" class="bg-primary btn">
                 </div>
             </div>
         <?php
         } else {
         ?>
             <div class="row">
                 <div class="col-sm-12">
                     <center>
                         <p style="font-size: 24px;font-weight: 600;color: red">No Invoice available!</p>
                     </center>
                 </div>
             </div>
         <?php
         }
         ?>
         </div>
     </div>
 </div>
 <?php

}  
?>
<script>
        // Start of jquery datatable
        for (let index = 1; index < <?php echo $table_count; ?>; index++) {
            $('#filter_dataTableExample' + index).DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [50, 150, 200, -1],
                    ['50 rows', '150 rows', '200 rows', 'Show all']
                ],
                buttons: [
                    'pageLength', 'excel'
                ]
            });
        }
    </script>