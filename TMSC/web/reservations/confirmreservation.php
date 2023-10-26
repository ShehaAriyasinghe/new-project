<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
if (!isset($_SESSION['customer_userid'])) {
    header("Location:../customers/customer_login.php");
}
?>

<main>
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card my-card-bg card-box px-5 " style="width: 40rem;">
                <div class="card-header text-center card-header">
                    <h2 class="display-6 fw-bolder text-white">Service Reservation</h2>
                </div>

                <div class="card-body">


                    <?php
                    //Check submit
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        //Extract inputs
                        extract($_POST);

                        if (empty($vehicle)) {
                            $messages['error_vehicle'] = "Please select the vehicle..!";
                        }



                        //advanced validaion
                        if (!empty($vehicle)) {
                            $sql = "SELECT * FROM tbl_reservations WHERE vehicleid='$vehicle' && jobcardstatus !='completed'";
                            $db = dbConn();
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $messages['error_vehicle'] = "A reservation already exists for this vehicle...!";
                            }
                        }


                        if (empty($messages)) {


                            $sql3 = "SELECT count(*) as tcount FROM tbl_reservations WHERE ((starttime BETWEEN '$starttime' AND '$endtime' OR endtime BETWEEN '$starttime' AND '$endtime') AND reservationdate='$servicedate' OR (starttime <='$starttime' AND endtime >= '$endtime') AND reservationdate='$servicedate') AND bay='$selectbay'";

                            $result3 = $db->query($sql3);
                            $row3 = $result3->fetch_assoc();

                            if ($row3['tcount'] == 0) {

                                $adddate = date('Y-m-d');
                                $customer_userid = $_SESSION['customer_userid'];

                                $sql = "INSERT INTO tbl_reservations(vehicleid,serviceid,reservationdate,starttime,endtime,bay,adddate,adduser) VALUES ('$vehicle','$service','$servicedate','$starttime','$endtime','$selectbay','$adddate','$customer_userid')";

                                $db->query($sql);

                                header("Location:reservation_regsuccess.php?starttime=$starttime&endtime=$endtime&servicedate=$servicedate&bay=$selectbay");
                                unset($_SESSION['reservation_service']);
                                unset($_SESSION['reservation_stime']);
                                unset($_SESSION['reservation_etime']);
                                unset($_SESSION['reservation_date']);
                                unset($_SESSION['bay']);
                            } else {
                                $messages['error_timeslot'] = "This time slot is full try another one..!";
                            }
                        }
                    }
                    ?>




                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                        <div class="text-danger"><?php echo @$messages['error_timeslot']; ?></div>
                        <div class="mb-3">

                            <?php
                            //get all session verible values
                            $customer_userid = $_SESSION['customer_userid'];
                            $starttime = $_SESSION['reservation_stime'];
                            $endtime = $_SESSION['reservation_etime'];
                            $servicedate = $_SESSION['reservation_date'];
                            $bay = $_SESSION['bay'];
                            $service = $_SESSION['reservation_service'];

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
                            <select class="form-select border-dark" name="service" id="serviceid">
                                <option value="">--</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $time = "+" . $row['duration'];
                                        $time = date('H:i', strtotime($time, strtotime("00:00")));
                                        ?>

                                        <option value="<?php echo $row['serviceid']; ?>" <?php if (@$service == $row['serviceid']) { ?> selected <?php } ?> disabled><?php echo $row['servicename'] . " - Rs." . $row['serviceprice'] . '   ' . "(Time Duration" . '- ' . $time . ')'; ?></option>

                                        <?php
                                    }
                                }
                                ?>
                            </select>


                        </div>

                        <div class="mb-3">
                            <input type="hidden" name="servicedate" value="<?= $servicedate; ?>">
                            <label for="servicedate" class="form-label">Select date:</label>
                            <input type="text" class="form-control" value="<?= $servicedate; ?>" readonly>


                        </div>

                        <div class="mb-3">
                            <input type="hidden" name="starttime" value="<?= $starttime; ?>">
                            <input type="hidden" name="endtime" value="<?= $endtime; ?>">
                            <label for="servicetime" class="form-label">Service time:</label>
                            <input type="text" class="form-control" name="servicetime" value="<?php echo $starttime . " - " . $endtime; ?>" readonly>


                        </div>

                        <div class="mb-3">
                            <input type="hidden" name="selectbay" value="<?= $bay; ?>">
                            <label for="bay" class="form-label">Bay:</label>
                            <input type="text" class="form-control" value="<?= ucfirst($bay); ?>" readonly>


                        </div>




                        <div class="row justify-content-left">
                            <div class="col-4">

                                <input type="submit" class="btn card-btn" value="Submit">
                            </div>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</main>    

<?php include '../footer.php'; ?>

