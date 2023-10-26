<?php
session_start();
include '../system/config.php';
include '../system/function.php';

if (!isset($_SESSION['customer_userid'])) {
header("Location:../customers/customer_login.php");
}
?>

<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->

        <link href="<?= SYSTEM_PATH; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= SYSTEM_PATH; ?>assets/css/webpage_style.css" rel="stylesheet" type="text/css" />


        <title>ThusithaServiceCentre-HONDA</title>

        <style>
            body {
                background-image: url('<?= SYSTEM_PATH; ?>assets/images/center30.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;

            }




        </style>

    </head>

    <body>


        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <div class="card my-nav-bg card-box px-5 " style="width: 40rem;">
                        <div class="card-header text-center card-header">
                            <h2 class="display-6 fw-bolder text-white">Select a suitable bay</h2>
                        </div>

                        <div class="card-body">

                            <?php
                            // use GET method data
                            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                            extract($_GET);

                            $vehicle = $vehicle;
                            $serviceid = $service;
                            $servicedate = $servicedate;
                            }

                            //Check submit
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                            //Extract inputs
                            extract($_POST);

                            if (empty($vehicle)) {
                            $messages['error_vehicle'] = "Please select the vehicle..!";
                            }

                            if (empty($service)) {
                            $messages['error_service'] = "The service type should not be empty..!";
                            }
                            if (empty($servicedate)) {
                            $messages['error_date'] = "Please select a date..!";
                            }
                            if (empty($selecttime)) {
                            $messages['error_time'] = "Please select a time slot";
                            }


                            //advanced validaion
                            if (!empty($vehicle)) {
                            $sql = "SELECT * FROM tbl_reservations WHERE vehicleid='$vehicle' && jobcardstatus='pending'";
                            $db = dbConn();
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                            $messages['error_vehicle'] = "A reservation already exists for this vehicle...!";
                            }
                            }

                            if (empty($message)) {
                            $starttime = date('H:i', strtotime(substr($selecttime, 0, 5)));

                            $endtime = date('H:i', strtotime(substr($selecttime, 7, 12)));

                            $adddate = date('Y-m-d');
                            $customer_userid = $_SESSION['customer_userid'];
                            
                            $_SESSION['reservation_stime']=$starttime;
                            $_SESSION['reservation_etime']=$endtime;
                            $_SESSION['reservation_date']=$servicedate;
                            $_SESSION['bay']=$bay;

                            $sql = "INSERT INTO tbl_reservations(vehicleid,serviceid,reservationdate,starttime,endtime,bay,adddate,adduser) VALUES ('$vehicle','$service','$servicedate','$starttime','$endtime','$bay','$adddate','$customer_userid')";
                            $db = dbconn();
                            $db->query($sql);
                            header("Location:reservation_regsuccess.php");
                            }







//                                if (empty($messages)) {
//
//                                    $stime = date('H:i', strtotime(substr($selecttime, 0, 5)));
//                                    //$stime = date('H:i', strtotime('-1 minute', strtotime($stime)));
//
//                                    $etime = date('H:i', strtotime(substr($selecttime, 7, 12)));
//                                    //$etime = date('H:i', strtotime('+1 minute', strtotime($etime)));
//
//                                    $sql2 = "SELECT count(*) as tcount from tbl_reservations WHERE   
//                                    (starttime <= '$stime' AND endtime >='$etime') AND reservationdate= '$servicedate' OR
//                                    (starttime >= '$stime' AND  endtime >= '$etime' AND starttime BETWEEN '$stime' AND '$etime') AND reservationdate= '$servicedate' OR
//                                    (starttime <= '$stime' AND  endtime <= '$etime' AND endtime BETWEEN '$stime' AND '$etime') AND reservationdate= '$servicedate' OR
//                                    (starttime >= '$stime' AND  endtime <= '$etime') AND reservationdate= '$servicedate'";
//                                    $db = dbconn();
//                                    $result2 = $db->query($sql2);
//                                    $row1 = $result2->fetch_assoc();
//
//                                    if ($row1['tcount'] >= 3) {
//                                        @$messages['error_timeslot'] = "This time slot is full try another one..!";
//                                    } else {
//                                        $starttime = date('H:i', strtotime(substr($selecttime, 0, 5)));
//
//                                        $endtime = date('H:i', strtotime(substr($selecttime, 7, 12)));
//
//                                        $adddate = date('Y-m-d');
//                                        $customer_userid = $_SESSION['customer_userid'];
//
//                                        $sql = "INSERT INTO tbl_reservations(vehicleid,serviceid,reservationdate,starttime,endtime,adddate,adduser) VALUES ('$vehicle','$service','$servicedate','$starttime','$endtime','$adddate','$customer_userid')";
//                                        $db = dbconn();
//                                        $db->query($sql);
//                                    }
//                                }
                            }
                            ?>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                                <div class="text-danger"><?php echo @$messages['error_timeslot']; ?></div>
                                <div class="mb-3">

                                    <?php
                                    $customer_userid = $_SESSION['customer_userid'];
                                    $sql = "SELECT vehicleid,plateno FROM tbl_vehicles WHERE adduser='$customer_userid' AND deletestatus=1";
                                    $db = dbconn();
                                    $result = $db->query($sql);
                                    ?>
                                    <label class="form-label">Select a vehicle :</label>
                                    <select class="form-select border-dark" name="vehicle" id="vehicle">
                                        <option value="">--</option>
                                        <?php
                                        if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row['vehicleid']; ?>" <?php if (@$vehicle == $row['vehicleid']) { ?> selected <?php } ?>><?php echo $row['plateno']; ?></option>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?php echo @$messages['error_vehicle']; ?></div>
                                </div>   

                                <div class="mb-3">

                                    <?php
                                    $sql1 = "SELECT serviceid,servicename,serviceprice,duration FROM tbl_services WHERE deletestatus=1";
                                    $db = dbconn();
                                    $result = $db->query($sql1);
                                    ?>
                                    <label class="form-label">Select a service type :</label>
                                    <select class="form-select border-dark" name="service" id="serviceid">
                                        <option value="">--</option>
                                        <?php
                                        if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?php echo $row['serviceid']; ?>" <?php if (@$service == $row['serviceid']) { ?> selected <?php } ?>><?php echo $row['servicename'] . " - Rs." . $row['serviceprice'] . '   ' . "(Time Duration" . '- ' . $row['duration'] . ')'; ?></option>

                                        <?php
                                        }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?php echo @$messages['error_service']; ?></div>

                                </div>

                                <div class="mb-3">

                                    <label for="servicedate" class="form-label">Select date:</label>
                                    <input type="date" id="servicedate" class="form-control-sm border-dark" name="servicedate" value="<?= $servicedate; ?>">
                                    <div class="text-danger"><?php echo @$messages['error_date']; ?></div>
                                </div>

                                <div class="row">

                                    <?php
                                    //Get service duration
                                     $sql = "SELECT serviceid,duration,servicestarttime FROM tbl_services WHERE deletestatus=1 AND serviceid=$service";
                                    $db = dbconn();
                                    $result = $db->query($sql);
                                    $row = $result->fetch_assoc();
                                    $duration = $row['duration'];
                                    $starttime=$row['servicestarttime'];
                                    $duration = "+" . $duration;
                                    ?>

                                    <!--Bay A-->


                                    <div class="col-md-4">
                                        <label class="form-label">BAY - A</label><br>
                                        <img src='<?= SYSTEM_PATH; ?>assets/images/bays.png' class="form-input" width="150 height="200">
                                        <div class="form-check">
                                            <?php
                                            $sql = "SELECT bay FROM tbl_reservations WHERE bay='bayA' AND deletestatus=1";
                                            $result = $db->query($sql);
                                            $row = $result->fetch_assoc();

                                            if($row['bay']=="bayA"){
                                            ?>
                                            <input type="hidden" name="bay" value="bayA">

                                            <?php
                                          




                                            $sql1 = "SELECT starttime,endtime,bay FROM tbl_reservations WHERE bay='bayA' AND deletestatus=1";
                                            $result1 = $db->query($sql1);

                                            while ($row1 = $result1->fetch_assoc()) {
                                            $starttime = date('H:i', strtotime($row1['starttime']));
                                            $endtime = date('H:i', strtotime($row1['endtime']));
                                            
                                            $timeslot=array();
                                            $timeslot[0]="08:00:00-11:00:00";

                                            if ("true" ==!($starttime <= date('H:i', strtotime("08:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("08:00"))) && date('H:i', strtotime("08:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "08:00" . "--" . date('H:i', strtotime($duration, strtotime("08:00"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "08:00" . "--" . date('H:i', strtotime($duration, strtotime("08:00"))); ?>">

                                            <?php
                                            }
                                            ?>


                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("08:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("08:30"))) && date('H:i', strtotime("08:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "08:30" . "--" . date('h:i', strtotime($duration, strtotime("08:30"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "08:30" . "--" . date('H:i', strtotime($duration, strtotime("08:30"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("09:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("09:00"))) && date('H:i', strtotime("09:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "09:00" . "--" . date('h:i', strtotime($duration, strtotime("09:00"))); ?>  </label>     
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "09:00" . "--" . date('H:i', strtotime($duration, strtotime("09:00"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("09:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("09:30"))) && date('H:i', strtotime("09:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "09:30" . "--" . date('h:i', strtotime($duration, strtotime("09:30"))); ?>  </label>     
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "09:30" . "--" . date('H:i', strtotime($duration, strtotime("09:30"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("10:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("10:00"))) && date('H:i', strtotime("10:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "10:00" . "--" . date('h:i', strtotime($duration, strtotime("10:00"))); ?>  </label>     
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "10:00" . "--" . date('H:i', strtotime($duration, strtotime("10:00"))); ?>">
                                            <?php
                                            }
                                            ?>


                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("10:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("10:30"))) && date('H:i', strtotime("10:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "10:30" . "--" . date('h:i', strtotime($duration, strtotime("10:30"))); ?>  </label>     
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "10:30" . "--" . date('H:i', strtotime($duration, strtotime("10:30"))); ?>">
                                            <?php
                                            }
                                            ?>





                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("11:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("11:00"))) && date('H:i', strtotime("11:00")) < $endtime )) {
                                            ?>    
                                            <label for="time">  <?php echo "11:00" . "--" . date('h:i', strtotime($duration, strtotime("11:00"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "11:00" . "--" . date('H:i', strtotime($duration, strtotime("11:00"))); ?>">
                                            <?php
                                            }
                                            ?>






                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("11:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("11:30"))) && date('H:i', strtotime("11:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "11:30" . "--" . date('h:i', strtotime($duration, strtotime("11:30"))); ?>  </label>     
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "11:30" . "--" . date('H:i', strtotime($duration, strtotime("11:30"))); ?>">
                                            <?php
                                            }
                                            ?>





                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("12:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("12:00"))) && date('H:i', strtotime("12:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "12:00" . "--" . date('h:i', strtotime($duration, strtotime("12:00"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "12:00" . "--" . date('H:i', strtotime($duration, strtotime("12:00"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("12:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("12:30"))) && date('H:i', strtotime("12:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "12:30" . "--" . date('h:i', strtotime($duration, strtotime("12:30"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "12:30" . "--" . date('H:i', strtotime($duration, strtotime("12:30"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("13:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("13.00"))) && date('H:i', strtotime("13:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "01:00" . "--" . date('h:i', strtotime($duration, strtotime("01:00"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "13:00" . "--" . date('H:i', strtotime($duration, strtotime("13:00"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("13:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("13:30"))) && date('H:i', strtotime("13:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "01:30" . "--" . date('h:i', strtotime($duration, strtotime("01:30"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "13:30" . "--" . date('H:i', strtotime($duration, strtotime("13:30"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("14:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("14:00"))) && date('H:i', strtotime("14:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "02:00" . "--" . date('h:i', strtotime($duration, strtotime("02:00"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "14:00" . "--" . date('H:i', strtotime($duration, strtotime("14:00"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("14:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("14:30"))) && date('H:i', strtotime("14:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "02:30" . "--" . date('h:i', strtotime($duration, strtotime("02:30"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "14:30" . "--" . date('H:i', strtotime($duration, strtotime("14:30"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("15:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("15:00"))) && date('H:i', strtotime("15:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "03:00" . "--" . date('h:i', strtotime($duration, strtotime("03:00"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "15:00" . "--" . date('H:i', strtotime($duration, strtotime("15:00"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("15:30")) && $endtime <= date('H:i', strtotime($duration, strtotime("15:30"))) && date('H:i', strtotime("15:30")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "03:30" . "--" . date('h:i', strtotime($duration, strtotime("03:30"))); ?>  </label>    
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "15:30" . "--" . date('H:i', strtotime($duration, strtotime("15:30"))); ?>">
                                            <?php
                                            }
                                            ?>

                                            <?php
                                            if ("true" ==!($starttime <= date('H:i', strtotime("16:00")) && $endtime <= date('H:i', strtotime($duration, strtotime("16:00"))) && date('H:i', strtotime("16:00")) < $endtime)) {
                                            ?>    
                                            <label for="time">  <?php echo "04:00" . "--" . date('h:i', strtotime($duration, strtotime("04:00"))); ?>  </label>   
                                            <input type="checkbox" id="time" name="selecttime" value="<?php echo "16:00" . "--" . date('H:i', strtotime($duration, strtotime("16:00"))); ?>">
                                            <?php
                                            }
                                            ?>



                                            <?php
                                            }
                                            }
                                            ?>



                                        </div>
                                    </div>










                                </div>




                                <div class="row justify-content-around">
                                    <div class="col-4">

                                        <input type="submit" class="btn btn-primary" value="submit">
                                    </div>
                                    <div class="col-4">
                                        <a href="<?= WEB_PATH; ?>reservations/customer_reservation.php" type="submit" class="btn btn-primary">Reset</a>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>







</html>





