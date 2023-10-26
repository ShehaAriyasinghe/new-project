<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Completed payment job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/completedpayment_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all completed payment job cards</a>
               
            </div>
            
        </div>
    </div>


    <?php
    extract($_GET);
    $db = dbconn();

    if (@$mode == 'cancel') {

        $sql1 = "UPDATE tbl_reservations SET deletestatus='0' WHERE reservationid='$reservationid'";
        $result = $db->query($sql1);
    }


    // view selected job card details
    if (@$mode == 'view') {

        $date = date('Y-m-d');

        $sqltbl = "SELECT j.reservationid,j.jobcardid,j.reservationdate,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.testride,j.freeservicestatus,j.jobcardstatus,j.vehicleid,c.firstname,c.lastname,r.bay,r.reservationid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,vou.voucherimage,vou.vouchercode FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_customers c ON c.userid=j.customeruserid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid LEFT JOIN tbl_servicevoucher vou ON vou.jobcardid=j.jobcardid WHERE j.jobcardstatus='finished' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";

        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();
        ?>


        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <legend>Person Details:</legend>


                            <label for="firstname" class="form-label">First Name:</label>
                            <input type="text" name="firstname" class="form-control" value='<?php echo $row['firstname']; ?>' readonly>  

                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name:</label>
                            <input type="text" name="lastname" class="form-control" value='<?php echo $row['lastname']; ?>' readonly>  

                        </div>


                        <legend>Vehicle Details:</legend>
                        <div class="mb-3">
                            <label class="form-label">Plate No</label>
                            <input type="text" name="brand" class="form-control" value='<?php echo $row['plateno']; ?>'readonly >

                        </div>        


                    </div>
                    <div class="col-md-4 mt-2">
                        <img class="img-fluid" src="<?= WEB_PATH ?>vehicles/images/<?= $row['plateimage'] ?>">

                    </div>



                </div> 
            </div>    

            <?php
            $servicename = $row['servicename'];
            ?>
            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-6">

                        <legend>Service Report:</legend>  
                        <div class="mb-3">
                            <label class="form-label">Service Type:</label>
                            <input type="text" class="form-control-md" name=servicename value='<?php echo @$servicename; ?>' readonly>           
                        </div>
                        <label class="form-label">Report of service task list:</label>
                        <div class = "form-control mb-2">
                            <?php
                            $db = dbconn();
                            $sql = "SELECT sub.subservicename,checkedservice.status FROM tbl_checkedservicetasks checkedservice INNER JOIN tbl_subservices sub ON sub.subserviceid=checkedservice.subserviceid WHERE checkedservice.jobcardid=$jobcardid AND sub.deletestatus='1'";
                            $result = $db->query($sql);

                            while ($rows = $result->fetch_assoc()) {
                                ?>
                                <div class="mb-1">
                                    <label><?php echo $rows['subservicename'] . " :"; ?></label>
                                    <?php echo ucfirst($rows['status']); ?>

                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>


                    <div class="col-md-6">

                        <lable class="form-label">Additional sub services:</lable><br>

                        <?php
                        $db = dbconn();
                        $sql = "SELECT sub.subserviceid,sub.subservicename,checksub.status FROM tbl_checkedsubservicetasks checksub INNER JOIN tbl_subservices sub ON sub.subserviceid=checksub.subserviceid  WHERE checksub.deletestatus='1' AND checksub.jobcardid='$jobcardid'";
                        $result = $db->query($sql);
                        $count = $result->num_rows;
                        if ($count == '0') {

                            echo "<div class='mb-2'>" . "There are no selected sub services...!" . "</div>";
                        } else {
                            while ($rows = $result->fetch_assoc()) {
                                $subservicename = $rows['subservicename'];
                                $subserviceid = $rows['subserviceid'];
                                $status = $rows['status'];
                                ?> 


                                <label class="form-label"><?= $subservicename; ?>: </label>
                                <div class="mb-3">
                                    <div class = "form-check form-check-inline">
                                        <?php echo ucfirst($status); ?>
                                    </div>

                                </div>


                                <?php
                            }
                        }
                        ?>


                        <label>Test ride: </label>
                        <div class="mb-3">
                            <div class = "form-check form-check-inline">
                                <?php echo ucfirst($row['testride']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>










            <div class="col-8">

                <a href="completedpayment_jobcards.php" class="btn card-btn">Back</a>
            </div>


        </form>

        <?php
    } else {
        
         ?>

        <?php
        //search reservation
        $where = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (!empty($plateno)) {
                $where .= " j.plateno LIKE '$plateno%' AND";
            }

            if (!empty($bay)) {
                $where .= " bay LIKE '$bay%' AND";
            }


            if (!empty($stime) && !empty($etime)) {
                $where .= " j.starttime BETWEEN '$stime' AND '$etime' AND";
            }

            if (!empty($service)) {
                $where .= " r.serviceid='$service' AND";
            }



            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = " AND $where";
            }
        }
        ?>

    
     <!--search bar-->
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="plateno" placeholder="Plate no" value="<?= @$plateno; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="bay" placeholder="bay" value="<?= @$bay; ?>">
                </div>
                <div class="col">

                    <input type="time" class="form-control" name="stime" value="">
                    <span>Start Time</span>
                </div>
                <div class="col">

                    <input type="time" class="form-control" name="etime" value="">
                    <span>End Time</span>
                </div>
                <div class="col">

                    <select name="service" class="form-select" id="service" class="form-control">
                        <option value="">--</option>
                        <?php
                        $sql1 = "SELECT serviceid,servicename from tbl_services";
                        $result1 = $db->query($sql1);
                        while ($rows = $result1->fetch_assoc()) {
                            ?>

                            <option value="<?= $rows['serviceid'] ?>" <?php if ($rows['serviceid'] == @$service) { ?> selected <?php } ?>><?= $rows['servicename'] ?></option>

                            <?php
                        }
                        ?>
                    </select>
                    <span>Service Type</span>
                </div>






                <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
            </div>
                </form>

    
    <?php
        // all Jobcards relavant to the date

        $date = date('Y-m-d');
        $sql = "SELECT j.reservationid,j.jobcardid,j.reservationdate,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.jobcardstatus,j.vehicleid,r.bay,r.reservationid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,j.freeservicestatus FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid WHERE j.jobcardstatus='finished' AND j.deletestatus=1 AND j.reservationdate='$date' $where";
        $result = $db->query($sql);
        ?>    
        <div class="card my-card-bg px-2"> 
            <div class="table-responsive">
                <!-- View of All job cards -->
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Plate No</th>
                            <th>Reservation Date</th>
                            <th>Service Time</th>
                            <th>Service Type</th>
                            <th>Bay</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) {
                                ?>
                                <tr>


                                    <td><?php echo $rows['plateno']; ?></td>
                                    <td><?php echo $rows['reservationdate']; ?></td>
                                    <td> <?php echo date('H:i', strtotime($rows['starttime'])) . '-' . date('H:i', strtotime($rows['endtime'])); ?></td>
                                    <td><?php echo $rows['servicename']; ?></td>
                                    <td><?php echo ucfirst($rows['bay']); ?></td>


                                    <td><a href="completedpayment_jobcards.php?mode=view&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn btn-sm">View Service</a></td>
                                    <?php
                                    if ($_SESSION['userrole'] == 'cashier') {
                                        ?>
                                        <td><a href="viewcompletedpayment_jobcard.php?mode=completedpayment&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn btn-sm">View Payment</a></td>
                                        <?php
                                    }
                                    ?>



                                    
                                </tr>


                                <?php
                            }
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>    
</main>
<?php include '../footer.php'; ?>

