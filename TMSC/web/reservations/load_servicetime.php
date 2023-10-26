<?php
include '../system/config.php';
include '../system/function.php';

//Check submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Extract inputs
    extract($_POST);

    $sql = "SELECT serviceid,duration FROM tbl_services WHERE deletestatus=1 AND serviceid=$serviceid";
    $db = dbconn();
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $duration = $row['duration'];
    $duration = "+" . $duration;
}
?>

<div class="mb-3">

    <label for="stime">Select service time : </label>
    <select name="selecttime" id="stime" class="form-control-mb">
    <option value="">--</option>
        
    <option value="<?php echo "08:00"."--".date('H:i',strtotime($duration,strtotime("08:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("08:00"))) <= date('H:i',strtotime("17:00"))){ echo "08:00"."--".date('h:i',strtotime($duration,strtotime("08:00"))) ;}?>    </option>
    <option value="<?php  echo "08:30"."--".date('H:i',strtotime($duration,strtotime("08:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("08:30"))) <= date('H:i',strtotime("17:00"))){ echo "08:30"."--".date('h:i',strtotime($duration,strtotime("08:30"))) ;}?>    </option>

    <option value="<?php  echo "09:00"."--".date('H:i',strtotime($duration,strtotime("09:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("09:00"))) <= date('H:i',strtotime("17:00"))){ echo "09:00"."--".date('h:i',strtotime($duration,strtotime("09:00"))) ;}?>    </option>
    <option value="<?php  echo "09:30"."--".date('H:i',strtotime($duration,strtotime("09:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("09:30"))) <= date('H:i',strtotime("17:00"))){ echo "09:30"."--".date('h:i',strtotime($duration,strtotime("09:30"))) ;}?>    </option>

    <option value="<?php  echo "10:00"."--".date('H:i',strtotime($duration,strtotime("10:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("10:00"))) <= date('H:i',strtotime("17:00"))){echo "10:00"."--".date('h:i',strtotime($duration,strtotime("10:00"))) ;}?>     </option>
    <option value="<?php  echo "10:30"."--".date('H:i',strtotime($duration,strtotime("10:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("10:30"))) <= date('H:i',strtotime("17:00"))){echo "10:30"."--".date('h:i',strtotime($duration,strtotime("10:30"))) ;}?>     </option>


    <option value="<?php  echo "11:00"."--".date('H:i',strtotime($duration,strtotime("11:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("11:00"))) <= date('H:i',strtotime("17:00"))){echo "11:00"."--".date('h:i',strtotime($duration,strtotime("11:00"))) ;}?>     </option>
    
    <option value="<?php  echo "13:30"."--".date('H:i',strtotime($duration,strtotime("13:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("13:30"))) <= date('H:i',strtotime("17:00"))){ echo "01:30"."--".date('h:i',strtotime($duration,strtotime("01:30"))) ;}?>    </option>
    
    <option value="<?php  echo "14:00"."--".date('H:i',strtotime($duration,strtotime("14:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("14:00"))) <= date('H:i',strtotime("17:00"))){ echo "02:00"."--".date('h:i',strtotime($duration,strtotime("02:00"))) ;}?>    </option>
    <option value="<?php  echo "14:30"."--".date('H:i',strtotime($duration,strtotime("14:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("14:30"))) <= date('H:i',strtotime("17:00"))){ echo "02:30"."--".date('h:i',strtotime($duration,strtotime("02:30"))) ;}?>    </option>
    
    
    <option value="<?php  echo "15:00"."--".date('H:i',strtotime($duration,strtotime("15:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("15:00"))) <= date('H:i',strtotime("17:00"))){ echo "03:00"."--".date('h:i',strtotime($duration,strtotime("03:00"))) ;}?>    </option>
    <option value="<?php  echo "15:30"."--".date('H:i',strtotime($duration,strtotime("15:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("15:30"))) <= date('H:i',strtotime("17:00"))){ echo "03:30"."--".date('h:i',strtotime($duration,strtotime("03:30"))) ;}?>    </option>

    <option value="<?php  echo "16:00"."--".date('H:i',strtotime($duration,strtotime("16:00"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("16:00"))) <= date('H:i',strtotime("17:00"))){ echo "04:00"."--".date('h:i',strtotime($duration,strtotime("04:00"))) ;}?>    </option>
    <option value="<?php  echo "16:30"."--".date('H:i',strtotime($duration,strtotime("16:30"))) ; ?>"><?php  if (date('H:i',strtotime($duration,strtotime("16:30"))) <= date('H:i',strtotime("17:00"))){ echo "04:30"."--".date('h:i',strtotime($duration,strtotime("04:30"))) ;}?>    </option> 
    </select>

 <div class="text-danger"><?php echo @$messages['error_time']; ?></div>
</div>