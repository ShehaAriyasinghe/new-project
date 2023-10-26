<?php
include '../config.php';
include '../function.php';

$model =$_POST['modelid'];
$brand = $_POST['brandid'];

$sql = "SELECT * FROM tbl_models WHERE modelid='$model' && deletestatus=1";
$db = dbConn();
$result = $db->query($sql);
$row=$result->fetch_assoc();

$sql1 = "SELECT * FROM tbl_models WHERE brandid='$brand' && deletestatus=1";
$db = dbConn();
$results = $db->query($sql1);
?>

<label>Select a vehicle model</label>

<select name="model" id="model" class="form-select border-dark">
   
    <?php
    if ($results->num_rows > 0) {
        while ($rows = $results->fetch_assoc()) {
            ?>
    <option value="<?php echo $rows['modelid'] ?>"<?php if($rows['modelid']==@$model){?> selected<?php }?>><?php echo $rows['modelname'] . "-" . $rows['vehicletype']; ?></option>

            <?php
        }
    }
    ?>
</select>
