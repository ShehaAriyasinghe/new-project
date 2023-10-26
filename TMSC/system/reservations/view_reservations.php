
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Reservations</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php" type="button" class="btn btn-sm btn-outline-secondary">View all reservations</a>
              
            </div>
           
        </div>
    </div>



    <h6>All Today's Reservations</h6>

    <?php
    extract($_GET);
    $db = dbconn();

    if (@$mode == 'cancel') {

        $sql1 = "UPDATE tbl_reservations SET deletestatus='0',jobcardstatus='cancel' WHERE reservationid='$reservationid'";
        $result = $db->query($sql1);
    }


    // view selected reservation
    if (@$mode == 'view') {

        $date = date('Y-m-d');

        $sqltbl = "SELECT r.reservationid,r.vehicleid,r.adduser,r.serviceid,r.reservationdate,r.starttime,r.endtime,r.jobcardstatus,r.deletestatus,r.bay,s.servicename,c.firstname,c.lastname,c.mobile,v.plateno,v.brandid,v.modelid,v.year,v.plateimage 
        FROM tbl_reservations r INNER JOIN tbl_services s on s.serviceid=r.serviceid INNER JOIN tbl_vehicles v on v.vehicleid=r.vehicleid
        INNER JOIN tbl_customers c on c.userid =r.adduser WHERE r.deletestatus=1 AND r.reservationdate='$date' and r.reservationid=$reservationid and r.jobcardstatus='pending'";
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();
        $brandid = $row['brandid'];
        $modelid = $row['modelid'];

        $sql1 = "SELECT brandname FROM tbl_brands WHERE brandid= $brandid";
        $result1 = $db->query($sql1);
        $row1 = $result1->fetch_assoc();

        $sql2 = "SELECT modelname,vehicletype FROM tbl_models WHERE modelid= $modelid";
        $result2 = $db->query($sql2);
        $row2 = $result2->fetch_assoc();
        ?>



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
                    <div class="mb-3">
                        <label class="form-label">Mobile:</label>
                        <input type="text" name="mobile" class="form-control" value='<?php echo $row['mobile']; ?>' readonly>  

                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <img class="img-fluid" src="<?= WEB_PATH ?>vehicles/images/<?= $row['plateimage'] ?>">

                </div>    
            </div> 
        </div>    
        <div class="card px-md-4 mb-2 my-card-bg">
            <div class="row">

                <div class="col-md-6"> 

                    <legend>Vehicle Details:</legend>

                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="text" name="year" class="form-control" value='<?php echo $row['year']; ?>'readonly >

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Brand Name</label>
                        <input type="text" name="brand" class="form-control" value='<?php echo $row1['brandname']; ?>'readonly >

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Model Name</label>
                        <input type="text" name="model" class="form-control" value='<?php echo $row2['modelname']; ?>'readonly >

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <input type="text" name="vtype" class="form-control" value='<?php echo $row2['vehicletype']; ?>'readonly >

                    </div> 
                </div>

                <div class="col-md-6">    
                    <legend>Service Details:</legend>    

                    <div class="mb-3">
                        <label class="form-label">Selected Date:</label>
                        <input type="date" class="form-control border-dark" name="reservationdate" value="<?php echo $row['reservationdate']; ?>" readonly>           
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Service Type:</label>
                        <input type="text" name="service" class="form-control" value='<?php echo $row['servicename']; ?>' readonly>           
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Selected Time:</label>
                        <input type="text" name="time" class="form-control" value="<?php echo date('H:i', strtotime($row['starttime'])) . '-' . date('H:i', strtotime($row['endtime'])); ?>" readonly>           
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bay</label>
                        <input type="text" name="bay" class="form-control" value='<?php echo $row['bay']; ?>' readonly>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job card Status</label>
                        <input type="text" name="jobcardstatus" class="form-control" value='<?php echo $row['jobcardstatus']; ?>' readonly>

                    </div>



                </div>
            </div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <a href="<?= SYSTEM_PATH ?>jobcards/create_jobcard.php?mode=jobcard&reservationid=<?php echo $row['reservationid'] ?>" class="btn card-btn  btn-sm">Jobcard</a>
            </div>
            <div class="col-4">
                <a href="view_reservations.php" class="btn card-btn">Back</a>
            </div>
        </div>



        <?php
    } else {
        ?>
        <?php
        //search reservation
        $where = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (!empty($plateno)) {
                $where .= " plateno LIKE '$plateno%' AND";
            }

            if (!empty($bay)) {
                $where .= " bay LIKE '$bay%' AND";
            }


            if (!empty($stime) && !empty($etime)) {
                $where .= " starttime BETWEEN '$stime' AND '$etime' AND";
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
        // all reservations relavant to the date

        $date = date('Y-m-d');
        $sql = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.deletestatus,r.serviceid,r.jobcardstatus,r.vehicleid,r.bay,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage FROM tbl_reservations r INNER JOIN tbl_services s ON s.serviceid=r.serviceid INNER JOIN tbl_vehicles v on r.vehicleid=v.vehicleid WHERE r.jobcardstatus='pending' AND r.deletestatus=1 AND r.reservationdate='$date' $where";
        $result = $db->query($sql);
        ?>    
        <div class="card my-card-bg px-2"> 
            <div class="table-responsive">

                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Plate No</th>
                            <th>Reservation Date</th>
                            <th>Service Type</th>
                            <th>Service Time</th>
                            <th>Bay</th>

                            <th>Action</th>
                            <th>Action</th>
                            <th>Action</th>
                            <th>Action</th>

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
                                    <td><?php echo $rows['servicename']; ?></td>
                                    <td> <?php echo date('H:i', strtotime($rows['starttime'])) . '-' . date('H:i', strtotime($rows['endtime'])); ?></td>
                                    <td><?php echo ucfirst($rows['bay']); ?></td>


                                    <td><a href="view_reservations.php?mode=view&reservationid=<?php echo $rows['reservationid'] ?>" class="btn card-btn btn-sm">View</a></td>
                                    <td><a href="edit_reservations.php?mode=edit&reservationid=<?php echo $rows['reservationid'] ?>" class="btn card-btn  btn-sm">Edit</a></td>
                                    <td><a href="<?= SYSTEM_PATH ?>jobcards/create_jobcard.php?mode=jobcard&reservationid=<?php echo $rows['reservationid'] ?>" class="btn card-btn  btn-sm">Jobcard</a></td>
                                    <td><a onclick="return confirm('Are you sure you want to Cancel this reservation ?');" href="view_reservations.php?mode=cancel&reservationid=<?php echo $rows['reservationid'] ?>" class="btn card-btn  btn-sm">Cancel</a></td>
                                </tr>


                                <?php
                            }
                        }else{
                        
                          echo "<div class='alert alert-danger'>"."There are no more reservations"."</div>";
                        
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>    
</main>
<?php include '../footer.php'; ?>

