<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Payment of job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/view_paymentsjobcard.php" type="button" class="btn btn-sm btn-outline-secondary">View all payment of job cards</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>



    <h6>All Today's payments of job cards</h6>

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

        $sqltbl = "SELECT j.reservationid,j.jobcardid,j.reservationdate,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.freeservicestatus,j.jobcardstatus,j.vehicleid,c.firstname,c.lastname,r.bay,r.reservationid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.brandid,v.modelid,j.freeservicestatus FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_customers c ON c.userid=j.customeruserid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid WHERE j.jobcardstatus='issuedjobcard' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";

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
                            <label class="form-label">Plate No</label>
                            <input type="text" name="brand" class="form-control" value='<?php echo $row['plateno']; ?>'readonly >

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
                            <label class="form-label">Free Service Available</label>
                            <input type="text" name="jobcardstatus" class="form-control" value='<?php echo ucfirst($row['freeservicestatus']); ?>' readonly>

                        </div>
                        <?php
                        if ($row['freeservicestatus'] == 'yes') {
                            ?>
                            <div class="col-md-4 mt-2 mb-2">
                                <img class="img-fluid" src="<?= SYSTEM_PATH ?>jobcards/images/<?= !empty($row['voucherimage']) ? $row['voucherimage'] : 'noimage.jpg' ?>">
                            </div> 

                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-8">         
                <a href="view_paymentsjobcard.php" class="btn card-btn">Back</a>
            </div>


        </form>

        <?php
    } else {
        // all Jobcards relavant to the date

        $date = date('Y-m-d');
        $sql = "SELECT j.jobcardid,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.vehicleid,r.bay,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,j.freeservicestatus FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid WHERE j.jobcardstatus='payment' AND j.deletestatus=1 AND j.reservationdate='$date'";
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
                                    <td> <?php echo date('H:i', strtotime($rows['starttime'])) . '-' . date('H:i', strtotime($rows['endtime'])); ?></td>
                                    <td><?php echo $rows['servicename']; ?></td>


                                    <td><?php echo ucfirst($rows['bay']); ?></td>


                                    <td><a href="view_paymetsjobcard.php?mode=view&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn btn-sm">View</a></td>
                                   
                                        <td><a href="payment_jobcard.php?mode=payment&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn btn-sm">payments</a></td>
                                  
                                        
                                        
                                        
                                    <td><a href="edit_paymentjobcards.php?mode=edit&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn  btn-sm">Edit</a></td>
                                    
                                    <td><a onclick="return confirm('Are you sure you want to Cancel this jobcard ?');" href="view_paymentsjobcard.php?mode=cancel&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn  btn-sm">Cancel</a></td>
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

