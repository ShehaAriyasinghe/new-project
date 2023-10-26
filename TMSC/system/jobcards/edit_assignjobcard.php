<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Edit Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all Jobcards</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>

    <h6>Assign Investigation Task For Job card</h6>

    <?php
    extract($_GET);
    $db = dbconn();
    $messages = array();

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'edit') {

        $date = date('Y-m-d');
        $sqltbl = "SELECT j.jobcardid,j.jobcardstatus,j.vehicleid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.modelid FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid  WHERE j.jobcardstatus='pending' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();

        $modelid = $row['modelid'];
        $plateimage = $row['plateimage'];
      

        $plateno = $row['plateno'];

        $sql2 = "SELECT modelname FROM tbl_models WHERE modelid= $modelid";
        $result2 = $db->query($sql2);
        $row2 = $result2->fetch_assoc();
        $modelname = $row2['modelname'];

        $sql3 = "SELECT investigationtaskid,taskstatus FROM tbl_jobcardinvestigationtasks WHERE deletestatus='1' AND jobcardid='$jobcardid'";

        $result3 = $db->query($sql3);
        $investigationtask = array();

        while ($row3 = $result3->fetch_assoc()) {
            $key = $row3['investigationtaskid'];
            $status = $row3['taskstatus'];

            $investigationtask[$key] = $status;
        }

        $_SESSION['investigationtask'] = $investigationtask;

        $sql4 = "SELECT technicianid,technicianstatus FROM tbl_jobcardtechnician WHERE jobcardid='$jobcardid'";
        $result4 = $db->query($sql4);
        $row4 = $result4->fetch_assoc();

        $techid = $row4['technicianid'];
        $techstatus = $row4['technicianstatus'];
    }












    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        $_SESSION['investigationtask'] = @$investigationtask;

        if (empty($_SESSION['investigationtask'])) {
            $messages['error_investigationtask'] = "The investigation tasks list should not be empty...!";
        }


        //check validation is completed
        if (empty($messages)) {

           

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            if (isset($_SESSION['investigationtask'])) {

                $sql = "DELETE FROM tbl_jobcardinvestigationtasks WHERE jobcardid='$jobcardid'";
                $db->query($sql);

                foreach ($_SESSION['investigationtask'] as $key => $value) {

                    $sql = "INSERT INTO tbl_jobcardinvestigationtasks(jobcardid,investigationtaskid,taskstatus,adddate,adduser) VALUES ('$jobcardid',$key,'$value','$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }

            if(!empty($technician)){
                
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];    

            $sql = "UPDATE tbl_jobcardtechnician SET technicianid='$technician',updatedate='$updatedate',updateuser='$updateuser' WHERE jobcardid='$jobcardid'";
            //call to the db connection
            $db = dbConn();
            $db->query($sql);
            
             $_SESSION['technicianid'] = $technician;
            }

            unset($_SESSION['investigationtask']);

            header("Location:editassign_subservicesjobcard.php?jobcardid=$jobcardid&mode=$mode");
        }
    }
    ?>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="card px-md-4 mb-2 my-card-bg">
            <div class="row">
                <div class="col-md-8">
                    <legend>Vehicle Details:</legend>

                    <div class="mb-3">
                        <label class="form-label">Plate No</label>
                        <input type="text" name="plateno" class="form-control" value='<?php echo $plateno; ?>'readonly >

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vehicle Model Name</label>
                        <input type="text" name="modelname" class="form-control" value='<?php echo $modelname; ?>'readonly >

                    </div>

                </div>
                <div class="col-md-4 mb-2 mt-2">
                    <img class="img-fluid" width="350" height="350" src="<?= WEB_PATH ?>vehicles/images/<?= $plateimage; ?>">
                    <input type="hidden" name="plateimage" class="form-control" value="<?php echo $plateimage; ?>" >
                </div>    
            </div> 
        </div>    

        <div class="card px-md-4 mb-2 my-card-bg">
            <div class="row">
                <legend>Investigation Task:</legend>

                <?php
                $db = dbconn();
                $sql = "SELECT * FROM tbl_investigationtasks WHERE deletestatus='1'";
                $result = $db->query($sql);
                while ($rows = $result->fetch_assoc()) {
                    $taskname = $rows['taskname'];
                    $taskid = $rows['investigationtaskid'];
                    ?> 

                    <div class="col-md-6">
                        <label><?= $taskname; ?>: </label>
                        <div class="mb-3">


                            <div class = "form-check form-check-inline">
                                <input class = "form-check-input" type = "radio" name = "investigationtask[<?= $taskid ?>]" id = "good" value = "good" <?php if (isset($_SESSION['investigationtask'][$taskid]) && $_SESSION['investigationtask'][$taskid] == "good") { ?> checked <?php } ?>>
                                <label class="form-check-label" for="good">Good</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="investigationtask[<?= $taskid ?>]" id="replace" value="replace" <?php if (isset($_SESSION['investigationtask'][$taskid]) && $_SESSION['investigationtask'][$taskid] == "replace") { ?> checked <?php } ?>>
                                <label class="form-check-label" for="replace">Replacement</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="investigationtask[<?= $taskid ?>]" id="adjust" value="adjust" <?php if (isset($_SESSION['investigationtask'][$taskid]) && $_SESSION['investigationtask'][$taskid] == "adjust") { ?> checked <?php } ?>>
                                <label class="form-check-label" for="adjust">Adjustment</label>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="text-danger"><?php echo @$messages['error_investigationtask']; ?></div>
        </div>


        <?php
        $sql = "SELECT firstname,lastname FROM tbl_employees WHERE employeeid='$techid' AND deletestatus='1'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        ?>

        <div class="mb-2">
            <label class="label-control fs-5">Assigned Technician Name:<?php echo $row['firstname'] . " " . $row['lastname']; ?></label>
        </div>




        <?php
        $date = date('Y-m-d');

        $sql = "SELECT e.firstname,e.lastname,e.employeeid,e.designation FROM tbl_technicianattendance ta LEFT JOIN tbl_employees e ON e.employeeid=ta.technicianid  WHERE (designation='technician' OR temporarystatus='technician') AND e.deletestatus=1 AND ta.deletestatus=1 AND ta.date='$date' AND ta.attendancestatus='yes'";
        $db = dbConn();
        $result = $db->query($sql);
        ?>
        <label class="form-check-label">Select a technician :</label>

        <?php
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                ?>
                <div class="row">

                    <div class="col-md-4">


                        <?php echo $rows['firstname'] . " " . $rows['lastname']; ?>                  

                    </div>   

                    <?php
                    $date = date('Y-m-d');
                    $employeeid = $rows['employeeid'];
                    $sqltec = "SELECT t.technicianstatus,j.starttime,j.endtime FROM tbl_jobcardtechnician t INNER JOIN tbl_jobcards j ON j.jobcardid=t.jobcardid  WHERE t.technicianid='$employeeid' AND j.deletestatus=1 AND t.adddate='$date' ORDER BY jobcardtechnicianid DESC LIMIT 1";
                    $result1 = $db->query($sqltec);
                    if ($result1->num_rows > 0) {
                        $row = $result1->fetch_assoc();

                        if ($row['technicianstatus'] === "assigned") {
                            ?>
                            <div class="col-md-4 alert alert-danger">
                                <?php
                                echo "Can't assign from " . date("h:i A", strtotime($row['starttime'])) . " to " . date("h:i A", strtotime($row['endtime']));
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class='col-md-4 alert alert-success'>
                                <?php
                                echo "Can assign";
                                ?>
                            </div>
                            <div class='col-md-2'>
                                <input class="form-check-input" type="radio" name="technician" id="tname" value="<?= @$rows['employeeid']; ?>" <?php if (isset($technician) && $technician == $rows['employeeid']) { ?> checked <?php } ?> >
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class='col-md-4 alert alert-success'>
                            <?php
                            echo "Can assign";
                            ?>
                        </div>   
                        <div class='col-md-2'>
                            <input class="form-check-input" type="radio" name="technician" id="tname" value="<?= @$rows['employeeid']; ?>" <?php if (isset($technician) && $technician == $rows['employeeid']) { ?> checked <?php } ?> >
                        </div>

                        <?php
                    }
                    ?>



                </div>
                <?php
            }
        } else {

            echo "<div class='alert alert-danger'>" . "Please mark technician attendance first..!" . "</div>";
        }
        ?>



        <div class="text-danger"><?php echo @$messages['error_technician']; ?></div>














        <input type="hidden" name="jobcardid" value='<?= @$jobcardid; ?>'>

        <input type="hidden" name="mode" value="<?= @$mode ?>">

        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>
                <a href="view_jobcards.php" class="btn card-btn btn-sm mt-2 mb-2">Back</a>

            </div>
        </div>

    </form>

</main>
<?php
include '../footer.php';
?>
