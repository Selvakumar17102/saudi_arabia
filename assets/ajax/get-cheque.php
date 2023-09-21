<?php
namespace Phppot;

use Phppot\CountryState;

include("../../inc/dbconn.php");

if (!empty($_POST["number"])) 
{
    $country = $_POST["number"];

    $sql = "SELECT * FROM expence_invoice WHERE chno='$country'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
?>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td><center><label class="col-form-label">Account</label></center></td>
                    <td><center><label class="col-form-label">Type</label></center></td>
                    <td><center><label class="col-form-label">Amount</label></center></td>
                    <td><center><label class="col-form-label">Date</label></center></td>
                </tr>
            </thead>
            <tbody>
<?php
        while($row = $result->fetch_assoc())
        {

            $code = $row["code"];
            $type = "";

            $amount = 0;

            if($row["credit"] == 0)
            {
                $amount = $row["debit"];
            }
            else
            {
                $amount = $row["credit"];
            }

            if($row["type"] == "1")
            {
                $type = "Income";
            }
            if($row["type"] == "2")
            {
                $type = "Expence";
            }
            if($row["type"] == "3")
            {
                if($row["code"] == "")
                {
                    $type = "Transfer";
                }
                else
                {
                    $type = "Inhouse";
                }
            }

            $sql1 = "SELECT * FROM account WHERE code='$code' ORDER BY name ASC";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();
        
?>
    
            <tr>
                <td><center><label class="col-form-label"><?php echo $row1["name"] ?></label></center></td>
                <td><center><label class="col-form-label"><?php echo $type ?></label></center></td>
                <td><center><label class="col-form-label">QAR <?php echo number_format($amount,2) ?></label></center></td>
                <td><center><label class="col-form-label"><?php echo date('d-m-Y',strtotime($row["date"])) ?></label></center></td>
            </tr>
        
<?php
        }
?>
        </tbody>
    </table>
<?php
    }
    else
    {
?>
        <h6 style="width:100%"><center>No data Available</center></h6>
<?php
    }
}
?>