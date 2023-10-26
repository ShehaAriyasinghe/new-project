<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card card-box px-5 my-card-bg" style="width: 40rem;">
                <div class="card-header text-center card-btn">
                    <h2 class="display-6 fw-bolder ">Select a suitable bay</h2>
                </div>

                <div class="card-body">

                    <?php
                    // use GET method data
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        extract($_GET);

                        $vehicle = $vehicle;
                        $service = $service;
                        $servicedate = $servicedate;

                        $sql = "SELECT adduser FROM tbl_vehicles WHERE deletestatus=1 AND vehicleid='$vehicle'";
                        $db = dbconn();
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $customer_userid = $row['adduser'];
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

                        if (empty($bay)) {
                            $messages['error_bays'] = "Please select a bay..!";
                        }



                        //advanced validaion
                        if (!empty($vehicle)) {
                            $sql = "SELECT * FROM tbl_reservations WHERE vehicleid='$vehicle' && jobcardstatus !='completed' && deletestatus ='1'";
                            $db = dbConn();
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $messages['error_vehicle'] = "A reservation already exists for this vehicle...!";
                            }
                        }



                        if (empty($messages)) {

                            // get Bay values


                            $starttime = date('H:i', strtotime(substr($bay, 0, 5)));
                            $endtime = date('H:i', strtotime(substr($bay, 6, 5)));
                            $bayno = substr($bay, 11, 4);

                            $sql3 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$bayno' AND deletestatus='1'";

                            $result3 = $db->query($sql3);
                            $row3 = $result3->fetch_assoc();

                            if ($row3['tcount'] == 0) {

                                $adddate = date('Y-m-d');

                                $sql = "INSERT INTO tbl_reservations(vehicleid,serviceid,reservationdate,starttime,endtime,bay,adddate,adduser) VALUES ('$vehicle','$service','$servicedate','$starttime','$endtime','$bayno','$adddate','$customer_userid')";
                                $db = dbconn();
                                $db->query($sql);
                                header("Location:reservation_success.php?starttime=$starttime&endtime=$endtime&servicedate=$servicedate&bay=$bayno");
                            } else {
                                $messages['error_timeslot'] = "This time slot is filled try another one..!";
                            }
                        }
                    }
                    ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">


                        <input type="hidden" name="customer_userid" value="<?= $customer_userid; ?>">

                        <div class="text-danger"><?php echo @$messages['error_timeslot']; ?></div>
                        <!-- view customer vehicles -->
                        <div class="mb-3">
                            <input type="hidden" name="vehicle" value="<?= $vehicle; ?>">

                            <?php
                            $sql = "SELECT vehicleid,plateno FROM tbl_vehicles WHERE deletestatus=1";
                            $db = dbconn();
                            $result = $db->query($sql);
                            ?>
                            <label class="form-label">Select a vehicle :</label>
                            <select class="form-select border-dark" name="vehicle" id="vehicle" disabled>
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
                            <!-- view service packages -->
                            <input type="hidden" name="service" value="<?= $service; ?>">
                            <?php
                            $sql1 = "SELECT serviceid,servicename,serviceprice,duration FROM tbl_services WHERE deletestatus=1";
                            $db = dbconn();
                            $result = $db->query($sql1);
                            ?>
                            <label class="form-label">Select a service type :</label>
                            <select class="form-select border-dark" name="service" id="serviceid" disabled>
                                <option value="">--</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        //create service time to hours
                                        $time = "+" . $row['duration'];
                                        $time = date('H:i', strtotime($time, strtotime("00:00")));
                                        ?>

                                        <option value="<?php echo $row['serviceid']; ?>" <?php if (@$service == $row['serviceid']) { ?> selected <?php } ?>><?php echo $row['servicename'] . " - Rs." . $row['serviceprice'] . '   ' . "(Time Duration" . '- ' . $time . ')'; ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?php echo @$messages['error_service']; ?></div>

                        </div>


                        <!-- reservation date -->
                        <div class="mb-3">
                            <input type="hidden" name="servicedate" value="<?= $servicedate; ?>">
                            <label for="servicedate" class="form-label">Select date:</label>
                            <input type="text" id="servicedate" class="form-control-sm border-dark" name="servicedate" value="<?= $servicedate; ?>" readonly>
                            <div class="text-danger"><?php echo @$messages['error_date']; ?></div>
                        </div>

                        <div class="row">

                            <!--Bay -->


                            <?php
                            $date = date('Y-m-d');
//Get service duration,
                            $sql1 = "SELECT serviceid,duration FROM tbl_services WHERE deletestatus=1 AND serviceid=$service";
                            $db = dbconn();
                            $result1 = $db->query($sql1);
                            $row1 = $result1->fetch_assoc();

                            $durationtime = $row1['duration'];
                            $duration = "+" . $durationtime;

//Get bay name,service center start time, lagtime,service center end time
                            $sql2 = "SELECT bayname,starttime,endtime,lagtime FROM tbl_bays WHERE baystatus='yes' AND deletestatus=1";
                            $result2 = $db->query($sql2);

                            while ($rowbay = $result2->fetch_assoc()) {

                                $bay = $rowbay['bayname'];
                                ?>

                                <div class="col-md-4">
                                    <label class="form-label"><?= $bay; ?></label><br>
                                    <img src='<?= SYSTEM_PATH; ?>assets/images/bays.png' class="form-input" width="150 height="200">
                                    <div class="form-check">



                                        <?php
                                        $lagtime = $rowbay['lagtime'];
                                        $lagtime = "+" . $lagtime;

                                        $servicestarttime = strtotime($rowbay['starttime']);
                                        $serviceendtime = strtotime($rowbay['endtime']);

                                        //convert minutes to seconds
                                        $interval = intval($durationtime) * 60;

                                        $sql3 = "SELECT starttime,endtime FROM tbl_reservations WHERE bay='$bay' AND reservationdate='$servicedate' AND deletestatus=1 ORDER BY endtime DESC LIMIT 1";
                                        $result3 = $db->query($sql3);

                                        if ($result3->num_rows == "0") {

                                            $timeslot = array();

                                            // get all timeslot starttimes by adding the serviceduration to servicestarttime
                                            for ($time = $servicestarttime; $time <= $serviceendtime; $time += $interval) {
                                                $timeslot[] = date('H:i', $time);
                                            }

                                            $t = 0;
                                            foreach ($timeslot as $stime) {

                                                //get first timeslot without adding lagtime
                                                if ($t == 0) {
                                                    $starttime = date('H:i', strtotime($stime));
                                                    $endtime = date('H:i', strtotime($duration, strtotime($starttime)));
                                                } else {

                                                    //get other timeslots adding lagtime

                                                    $starttime = date('H:i', strtotime($lagtime, strtotime($endtime)));
                                                    $endtime = date('H:i', strtotime($duration, strtotime($starttime)));
                                                }




                                                //check if slot endtime less than or equal to servicecenterclose time 

                                                if (strtotime($endtime) <= $serviceendtime) {


                                                    $selectbay = $bay;

                                                    //check the starttime and endtime already exist in the database
                                                    $sql4 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$selectbay' AND deletestatus='1'";

                                                    $result4 = $db->query($sql4);
                                                    $row4 = $result4->fetch_assoc();

                                                    if ($row4['tcount'] == 0) {
                                                        ?>

                                                        <label>  <?php echo $starttime . "-" . $endtime; ?>  </label>    
                                                        <input type="radio" name="bay" value="<?php echo $starttime . "-" . $endtime . $selectbay; ?>">

                                                        <?php
                                                    }
                                                }




                                                $t++;
                                            }
                                        } else {
                                            while ($row3 = $result3->fetch_assoc()) {


                                                $start_time = strtotime($row3['starttime']);

                                                if ($servicestarttime < $start_time) {


                                                    $timesslot = array();

                                                    // get all timeslot starttimes by adding the serviceduration to servicestarttime
                                                    for ($time = $servicestarttime; $time < $start_time; $time += $interval) {
                                                        $timesslot[] = date('H:i', $time);
                                                    }


                                                    $t = 0;
                                                    foreach ($timesslot as $stime) {

                                                        //get first timeslot without adding lagtime
                                                        if ($t == 0) {
                                                            $starttime = date('H:i', strtotime($stime));
                                                            $endtime = date('H:i', strtotime($duration, strtotime($starttime)));
                                                        } else {

                                                            //get other timeslots adding lagtime

                                                            $starttime = date('H:i', strtotime($lagtime, strtotime($endtime)));
                                                            $endtime = date('H:i', strtotime($duration, strtotime($starttime)));
                                                        }




                                                        //check if slot endtime less than or equal to servicecenterclose time 

                                                        if (strtotime($endtime) <= $start_time) {


                                                            $selectbay = $bay;

                                                            //check the starttime and endtime already exist in the database
                                                            $sql6 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$selectbay' AND deletestatus='1'";

                                                            $result6 = $db->query($sql6);
                                                            $row6 = $result6->fetch_assoc();

                                                            if ($row6['tcount'] == 0) {
                                                                ?>

                                                                <label>  <?php echo $starttime . "-" . $endtime; ?>  </label>    
                                                                <input type="radio" name="bay" value="<?php echo $starttime . "-" . $endtime . $selectbay; ?>">

                                                                <?php
                                                            }
                                                        }




                                                        $t++;
                                                    }
                                                }




                                                $end_time = $row3['endtime'];

                                                $start_time = date('H:i', strtotime($lagtime, strtotime($end_time)));

                                                $start_time = strtotime($start_time);
                                                $timeslots = array();

                                                for ($time = $start_time; $time <= $serviceendtime; $time += $interval) {

                                                    $timeslots[] = date('H:i', $time);
                                                }



                                                $y = 0;
                                                foreach ($timeslots as $stime) {

                                                    //get first timeslot without adding lagtime
                                                    if ($y == 0) {
                                                        $starttime = date('H:i', strtotime($stime));
                                                        $endtime = date('H:i', strtotime($duration, strtotime($starttime)));
                                                    } else {

                                                        //get other timeslots adding lagtime

                                                        $starttime = date('H:i', strtotime($lagtime, strtotime($endtime)));
                                                        $endtime = date('H:i', strtotime($duration, strtotime($starttime)));
                                                    }




                                                    //check if slot endtime less than or equal to servicecenterclose time 

                                                    if (strtotime($endtime) <= $serviceendtime) {


                                                        $selectbay = $bay;

                                                        //check the starttime and endtime already exist in the database
                                                        $sql4 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$selectbay' AND deletestatus='1'";

                                                        $result4 = $db->query($sql4);
                                                        $row4 = $result4->fetch_assoc();

                                                        if ($row4['tcount'] == 0) {
                                                            ?>
                                                            <label>  <?php echo $starttime . "-" . $endtime; ?>  </label>    
                                                            <input type="radio" name="bay" value="<?php echo $starttime . "-" . $endtime . $selectbay; ?>">

                                                            <?php
                                                        }
                                                    }




                                                    $y++;
                                                }
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                                <?php
                            }
                            ?>



                            <div class="text-danger"><?php echo @$messages['error_bays']; ?></div>
                        </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-4">

                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                    <div class="col-4">
                        <a href="<?= WEB_PATH; ?>reservations/customer_reservation.php?service=<?= $service ?>&servicedate=<?= $servicedate ?>&vehicle=<?= $vehicle ?>" type="submit" class="btn btn-primary">Back</a>
                    </div>
                </div>

                </form>
            </div>

        </div>
    </div>


</main>

<?php include '../footer.php'; ?>









