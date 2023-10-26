<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card my-card-bg card-box px-5 " style="width: 40rem;">
                <div class="card-header text-center card-btn">
                    <h2 class="display-6 fw-bolder">Service Reservation</h2>
                </div>

                <div class="card-body">
                    <?php
                    //Extract inputs
                    extract($_POST);
                    extract($_GET);

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


                        if (empty($vehicle)) {
                            $messages['error_vehicle'] = "Please select a vehicle..!";
                        }

                        if (empty($service)) {
                            $messages['error_service'] = "The service type should not be empty..!";
                        }
                        if (empty($servicedate)) {
                            $messages['error_date'] = "Please select a date..!";
                        }



                        //Advance validation



                        if (!empty($servicedate)) {
                            $sql = "SELECT * FROM tbl_holidays WHERE holidaydate='$servicedate' AND deletestatus ='1'";
                            $db = dbConn();
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $title = $row['title'];
                                $messages['error_date'] = "This Date is a $title.Try another date...!";
                            }
                        }





                        if (!empty($vehicle)) {
                            $sql = "SELECT * FROM tbl_reservations WHERE vehicleid='$vehicle' AND jobcardstatus !='completed' && deletestatus ='1'";
                            $db = dbConn();
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $messages['error_vehicle'] = "A reservation already exists for this vehicle...!";
                            }
                        }



                        if (empty($messages)) {

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

                                $lagtime = $rowbay['lagtime'];
                                $lagtime = "+" . $lagtime;

                                $servicestarttime = strtotime($rowbay['starttime']);
                                $serviceendtime = strtotime($rowbay['endtime']);

                                //convert minutes to seconds
                                $interval = intval($durationtime) * 60;

                                $sql3 = "SELECT starttime,endtime FROM tbl_reservations WHERE bay='$bay' AND reservationdate='$servicedate' AND deletestatus=1 ORDER BY endtime DESC LIMIT 1";
                                $result3 = $db->query($sql3);

                                if ($result3->num_rows == "0") {

                                    $day = "You can get reservations in this date..!";
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
                                                    $sql6 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$selectbay'";

                                                    $result6 = $db->query($sql6);
                                                    $row6 = $result6->fetch_assoc();

                                                    if ($row6['tcount'] == 0) {

                                                        $day = "You can get reservations in this date..!";
                                                    }
                                                }
                                            }




                                            $t++;
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
                                                $sql4 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$selectbay'";

                                                $result4 = $db->query($sql4);
                                                $row4 = $result4->fetch_assoc();

                                                if ($row4['tcount'] == 0) {
                                                    $day = "You can get reservations in this date..!";
                                                }
                                            }
                                            $y++;
                                        }
                                    }
                                }
                            }

                            if (empty($day)) {

                                echo "<div class='alert alert-danger'>All bays time slots are filled up.Try another date</div>";
                                $messages['error_date'] = "This date is filled try another date..!";
                            } else {


                                echo "<div class='alert alert-success'>" . @$day . "</div>";
                            }
                        }
                    }








                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$option == "Next") {



                        if (empty($messages)) {


                            header("Location:bays_reservation.php?vehicle=$vehicle&service=$service&servicedate=$servicedate");
                        }
                    }
                    ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">


                        <div class="mb-3">

                            <?php
                            extract($_GET);
                           
                            $sql = "SELECT vehicleid,plateno FROM tbl_vehicles WHERE deletestatus=1";
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

                        <div class="mb-3">
                            <label for="servicedate" class="form-label">Select date:</label>
                            <input type="date" id="servicedate" class="form-control-sm border-dark" name="servicedate" min="<?php echo date("Y-m-d"); ?>" value="<?= @$servicedate; ?>" onchange="form.submit()">
                            <div class="text-danger"><?php echo @$messages['error_date']; ?></div>
                        </div>



                        <div class="row justify-content-around">
                            <div class="col-4">

                                <input type="submit" class="btn btn-primary" name="option" value="Next">
                            </div>
                            <div class="col-4">
                                <a href="<?= SYSTEM_PATH; ?>reservations/customer_reservation.php" type="submit" class="btn btn-primary">Reset</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</main>    

<?php include '../footer.php'; ?>

