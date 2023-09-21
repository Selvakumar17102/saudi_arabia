<?php
namespace Phppot;

use Phppot\CountryState;

include("../../inc/dbconn.php");

if (!empty($_POST["country_ids"])) 
{
    $country = $_POST["country_ids"];

    $sql = "SELECT * FROM account WHERE code='$country'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $id = $row["id"];

    $sql1 = "SELECT * FROM account WHERE sub='$id' ORDER BY name ASC";
    $result1 = $conn->query($sql1);
    if($result1->num_rows == 0)
    {
?>
    <label class="col-form-label">Sub Account</label>
    <input type="text" class="form-control" name="sub" value="No Sub Account" readonly>
<?php
    }
    else
    {
?>
        <label class="col-form-label">Sub Account</label>
        <select name="sub" class="form-control" required style="height: 40px">
            <option value Selected disabled>Select Account</option>
            <?php
                while($row1 = $result1->fetch_assoc())
                {
            ?>
                <option value="<?php echo $row1["code"] ?>"><?php echo $row1["name"] ?></option>
            <?php
                }
            ?>
        </select>
<?php
    }
?>
    
<?php 
}
?>