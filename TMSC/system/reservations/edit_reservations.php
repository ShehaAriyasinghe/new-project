<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Update Reservations</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php" type="button" class="btn btn-sm btn-outline-secondary">View all reservations</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>


    <h6>Update customer reservation</h6>

    <?php
    //Extract inputs
    extract($_POST);
    extract($_GET);
    
     $reservation = $reservationid;
 if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   

    $db = dbconn();
    $sql = "SELECT * FROM tbl_reservations WHERE reservationid='$reservation'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $vehicle = $row['vehicleid'];
    $service = $row['serviceid'];
    $customer_userid = $row['adduser'];

    $reservationdate = $row['reservationdate'];
 }

    //Check submit
  extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        if (empty($vehicle)) {
            $messages['error_vehicle'] = "Please select the vehicle..!";
        }

        if (empty($service)) {
            $messages['error_service'] = "The service type should not be empty..!";
        }
        if (empty($reservationdate)) {
            $messages['error_date'] = "Please select a date..!";
        }



        //advanced validaion
        if (!empty($vehicle)) {
            $sql = "SELECT * FROM tbl_reservations WHERE vehicleid='$vehicle' && jobcardstatus !='completed' && deletestatus ='1' && reservationid != '$reservation'";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_vehicle'] = "A reservation already exists for this vehicle...!";
            }
        }


        if (empty($messages)) {

            header("Location: editbays_reservation.php?reservationid=$reservationid&&vehicle=$vehicle");
        }
    }
    ?>
    <div class="card px-md-4 mb-2 my-card-bg">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="text-danger"><?php echo @$messages['error_timeslot']; ?></div>
            
<!--            reservation id-->
            <input type="hidden" name="reservationid" value="<?= @$reservation; ?>">
<!--            customerid-->
            <input type="hidden" name="customer_userid" value="<?= $customer_userid; ?>">
            
            <div class="mb-3">

                <?php
                $customer_userid = @$customer_userid;
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
                <input type="date" id="servicedate" class="form-control-md border-dark" name="reservationdate" value="<?= $reservationdate; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_date']; ?></div>
            </div>







            <div class="row justify-content-around">
                <div class="col-4">

                    <input type="submit" class="btn card-btn" value="Next">
                </div>
                <div class="col-4 mb-2">
                    <a href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php" type="submit" class="btn card-btn">Back</a>
                </div>
            </div>

        </form>
    </div>




</main>
<?php include '../footer.php'; ?>



