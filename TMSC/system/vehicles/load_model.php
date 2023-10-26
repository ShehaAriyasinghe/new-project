<?php
include '../config.php';
include '../function.php';

$model =$_POST['modelid'];
$brand = $_POST['brandid'];

$sql = "SELECT * FROM tbl_models WHERE brandid='$brand' && deletestatus=1";
$db = dbConn();
$result = $db->query($sql);
?>

<label>Select a vehicle model</label>

<select name="model" id="model" class="form-select border-dark">
    
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row['modelid'] ?>" <?php if ($row['modelid'] == @$model) { ?> selected <?php } ?>><?php echo $row['modelname'] . "-" . $row['vehicletype']; ?></option>

            <?php
        }
    }
    ?>
</select>
