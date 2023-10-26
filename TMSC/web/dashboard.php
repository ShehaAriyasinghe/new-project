<?php include 'customerheader.php'; ?>
<?php include 'customermenu.php'; ?>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer Dashboard</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= WEB_PATH; ?>index.php" type="button" class="btn btn-sm btn-outline-secondary mx-4">Home</a>

            </div>

        </div>
    </div>
    <?php
    extract($_GET);
    $db = dbconn();

    if (@$mode == 'cancel') {

        $sql1 = "UPDATE tbl_reservations SET jobcardstatus='cancel',deletestatus='0' WHERE reservationid='$reservationid'";
        $result = $db->query($sql1);
    }




    if (@$mode == 'complete') {
        ?>

        <div class='row'>
            <div class='col-md-11'>
                <div class="card">
                    <div class="card-btn fs-4">
                        completed reservations.
                    </div>
                    <div class="card-body">

                        <table class="w-75">                               
                            <thead>
                                <tr>  
                                    <th>Plate Num</th>
                                    <th>Date</th>                      
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Service Name</th>
                                    <th>Action</th>


                                </tr>
                                <?php
                                $userid = $_SESSION['customer_userid'];
                                $db = dbconn();
                                $sql = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.bay,s.servicename,v.plateno FROM tbl_reservations r INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE r.jobcardstatus='completed' AND r.adduser='$userid'";
                                $result = $db->query($sql);
                                ?>

                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>  
                                    <tr>
                                        <td><?= $row['plateno']; ?></td>
                                        <td><?= $row['reservationdate']; ?></td>
                                        <td><?= $row['starttime']; ?></td>
                                        <td><?= $row['endtime']; ?></td>
                                        <td><?= $row['servicename']; ?></td>

                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=view&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">View</a></td>



                                    </tr>



                                    <?php
                                }
                                ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>




        <?php
    }
    ?>

    <?php
    if (@$mode == 'pending') {
        ?>

        <div class='row'>
            <div class='col-md-11'>
                <div class="card">
                    <div class="card-btn fs-4">
                        Pending reservations.
                    </div>
                    <div class="card-body">

                        <table class="w-75">                               
                            <thead>
                                <tr>  
                                    <th>Plate Num</th>
                                    <th>Date</th>                      
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Service Name</th>
                                    <th>Action</th>
                                    <th>Action</th>

                                </tr>
                                <?php
                                $userid = $_SESSION['customer_userid'];
                                $db = dbconn();

                                $sql = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.bay,s.servicename,v.plateno FROM tbl_reservations r INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE r.jobcardstatus='pending' AND r.adduser='$userid'";
                                $result = $db->query($sql);
                                ?>

                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>  
                                    <tr>
                                        <td><?= $row['plateno']; ?></td>
                                        <td><?= $row['reservationdate']; ?></td>
                                        <td><?= $row['starttime']; ?></td>
                                        <td><?= $row['endtime']; ?></td>
                                        <td><?= $row['servicename']; ?></td>

                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=view&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">View</a></td>
                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=cancel&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">Cancel</a></td>


                                    </tr>



                                    <?php
                                }
                                ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>



    <?php
    if (@$mode == 'cancelreservation') {
        ?>

        <div class='row'>
            <div class='col-md-11'>
                <div class="card">
                    <div class="card-btn fs-4">
                        Cancel reservations.
                    </div>
                    <div class="card-body">

                        <table class="w-75">                               
                            <thead>
                                <tr>  
                                    <th>Plate Num</th>
                                    <th>Date</th>                      
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Service Name</th>
                                    <th>Action</th>


                                </tr>
                                <?php
                                $userid = $_SESSION['customer_userid'];
                                $db = dbconn();
                                $sql = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.bay,s.servicename,v.plateno FROM tbl_reservations r INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE r.jobcardstatus='cancel' AND r.adduser='$userid'";
                                $result = $db->query($sql);
                                ?>

                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>  
                                    <tr>
                                        <td><?= $row['plateno']; ?></td>
                                        <td><?= $row['reservationdate']; ?></td>
                                        <td><?= $row['starttime']; ?></td>
                                        <td><?= $row['endtime']; ?></td>
                                        <td><?= $row['servicename']; ?></td>

                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=view&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">View</a></td>



                                    </tr>



                                    <?php
                                }
                                ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>




        <?php
    }

    if (@$mode == 'view') {

        $date = date('Y-m-d');

        $sqltbl = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.serviceid,r.jobcardstatus,r.vehicleid,c.firstname,c.lastname,r.bay,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.year,v.brandid,v.modelid FROM tbl_reservations r INNER JOIN tbl_services s ON s.serviceid=r.serviceid INNER JOIN tbl_customers c ON c.userid=r.adduser INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid WHERE r.reservationid='$reservationid'";

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

                <div class="col-md-6"> 

                    <img class="img-fluid" src="<?= WEB_PATH ?>vehicles/images/<?= $row['plateimage'] ?>">

                    <legend>Vehicle Details:</legend>
                    <div class="mb-3">
                        <label class="form-label">Plate No</label>
                        <input type="text" name="brand" class="form-control" value='<?php echo $row['plateno']; ?>'readonly >

                    </div>

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



                </div>


            </div>
            <div class='col-md-4 mb-2'>
                <a href="<?= WEB_PATH ?>dashboard.php" class="btn card-btn">Back</a>
            </div>

        </div>






        <?php
    } else {
        ?>
    
    <!--Today completed reservations-->
    <div class='row'>
            <div class='col-md-11'>
                <div class="card">
                    <div class="card-btn fs-4">
                        Today Completed reservations.
                    </div>
                    <div class="card-body">

                        <table class="w-75">                               
                            <thead>
                                <tr>  
                                    <th>Plate Num</th>
                                    <th>Date</th>                      
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Service Name</th>
                                    <th>Action</th>
                                    

                                </tr>
                                <?php
                                $userid = $_SESSION['customer_userid'];
                                $db = dbconn();
                                $date = date('Y-m-d');
                                $sql = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.bay,s.servicename,v.plateno FROM tbl_reservations r INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE r.jobcardstatus='completed' AND r.adduser='$userid' AND reservationdate='$date'";
                                $result = $db->query($sql);
                                ?>

                                <?php
                                if($result->num_rows > 0){
                                while ($row = $result->fetch_assoc()) {
                                    
                                    ?>  
                                    <tr>
                                        <td><?= $row['plateno']; ?></td>
                                        <td><?= $row['reservationdate']; ?></td>
                                        <td><?= $row['starttime']; ?></td>
                                        <td><?= $row['endtime']; ?></td>
                                        <td><?= $row['servicename']; ?></td>

                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=view&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">View</a></td>
                                       


                                    </tr>



                                    <?php
                                }
                                }else{
                                    echo "There are no today completed reservations yet.";
                                }
                                ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    
    
    <!--Today pending reservation-->

        <div class='row'>
            <div class='col-md-11'>
                <div class="card">
                    <div class="card-btn fs-4">
                        Today Pending reservations.
                    </div>
                    <div class="card-body">

                        <table class="w-75">                               
                            <thead>
                                <tr>  
                                    <th>Plate Num</th>
                                    <th>Date</th>                      
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Service Name</th>
                                    <th>Action</th>
                                    <th>Action</th>

                                </tr>
                                <?php
                                $userid = $_SESSION['customer_userid'];
                                $db = dbconn();
                                $date = date('Y-m-d');
                                $sql = "SELECT r.reservationid,r.reservationdate,r.starttime,r.endtime,r.bay,s.servicename,v.plateno FROM tbl_reservations r INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE r.jobcardstatus='pending' AND r.adduser='$userid' AND reservationdate='$date'";
                                $result = $db->query($sql);
                                 if($result->num_rows > 0){
                                ?>

                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>  
                                    <tr>
                                        <td><?= $row['plateno']; ?></td>
                                        <td><?= $row['reservationdate']; ?></td>
                                        <td><?= $row['starttime']; ?></td>
                                        <td><?= $row['endtime']; ?></td>
                                        <td><?= $row['servicename']; ?></td>

                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=view&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">View</a></td>
                                        <td><a href="<?= WEB_PATH ?>dashboard.php?mode=cancel&reservationid=<?= $row['reservationid'] ?>" class="btn card-btn">Cancel</a></td>


                                    </tr>



                                    <?php
                                }
                                 }else{
                                     echo "There are no today pending reservations.";
                                 }
                                ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            <div class="col-md-11">
                <div class="card">
                    <div class="card-body">
                        <div class='row'>
                            <div class='col-md-4'>
                                <h5 class="card-title">Cancel reservations</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Number of Cancels:</h6>

                                <h2 class="display-6">
                                    <?php
                                    $db = dbconn();
                                    $sql = "SELECT COUNT(reservationid) AS cancelres FROM tbl_reservations WHERE deletestatus='0' AND jobcardstatus='cancel' AND adduser='$userid'";
                                    $result = $db->query($sql);
                                    $row = $result->fetch_assoc();
                                    echo $row['cancelres'];
                                    ?>
                                </h2>
                                <a href="<?= WEB_PATH; ?>dashboard.php?mode=cancelreservation&userid=<?= $userid ?>" class="card-link">View cancels</a>
                            </div>

                            <div class='col-md-4'>
                                <h5 class="card-title">Today Pending reservations</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Number of pendings:</h6>

                                <h2 class="display-6">
                                    <?php
                                    $db = dbconn();
                                    $sql2 = "SELECT COUNT(reservationid) AS pendingres FROM tbl_reservations WHERE deletestatus='1' AND jobcardstatus='pending' AND adduser='$userid'";
                                    $result2 = $db->query($sql2);
                                    $row1 = $result2->fetch_assoc();
                                    echo $row1['pendingres'];
                                    ?>
                                </h2>
                                <a href="<?= WEB_PATH; ?>dashboard.php" class="card-link">View Today pendings</a>
                            </div>

                            <div class='col-md-4'>
                                <h5 class="card-title">Completed reservations</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Number of Completed:</h6>

                                <h2 class="display-6">
                                    <?php
                                    $db = dbconn();
                                    $sql2 = "SELECT COUNT(reservationid) AS completedres FROM tbl_reservations WHERE deletestatus='1' AND jobcardstatus='completed' AND adduser='$userid'";
                                    $result2 = $db->query($sql2);
                                    $row1 = $result2->fetch_assoc();
                                    echo $row1['completedres'];
                                    ?>
                                </h2>
                                <a href="<?= WEB_PATH; ?>dashboard.php?mode=complete&userid=<?= $userid ?>" class="card-link">View completed</a>
                            </div>




                            <div class='col-md-4'>
                                <h5 class="card-title">Pending reservations</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Number of Pendings:</h6>

                                <h2 class="display-6">
                                    <?php
                                    $db = dbconn();
                                    $sql3 = "SELECT COUNT(reservationid) AS pendingres FROM tbl_reservations WHERE deletestatus='1' AND jobcardstatus='pending' AND adduser='$userid'";
                                    $result3 = $db->query($sql3);
                                    $row3 = $result3->fetch_assoc();
                                    echo $row3['pendingres'];
                                    ?>
                                </h2>
                                <a href="<?= WEB_PATH; ?>dashboard.php?mode=pending&userid=<?= $userid ?>" class="card-link">View pendings</a>
                            </div>


                        </div>



                    </div>
                </div>

            </div>


            <div class="row">

                <div class="col-md-4 mt-1">



                    <div class="card" style="width: 18rem;">
                        <img src="<?= WEB_PATH ?>assets/images/qr.jpg" height="150" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title">You can get your vehicle service ongoing status by scanning QR</h6>

                            <a href="<?= WEB_PATH ?>qrscan.php" class='btn card-btn' >Scan</a>
                        </div>
                    </div>

                </div>









            </div>









            <?php
        }
        ?>




























</main>
<?php
include 'customerfooter.php';
?>

