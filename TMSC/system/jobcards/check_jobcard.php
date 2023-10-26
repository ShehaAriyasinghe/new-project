
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<style>
    table, th, td {
        border:1px solid black;
    }  
</style>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/pending_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all pending job cards</a>

            </div>

        </div>
    </div>

    <h6>Check services for Job card</h6>

    <?php
    extract($_GET);
    $db = dbconn();

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'check') {

        $date = date('Y-m-d');
        $sqltbl = "SELECT j.jobcardid,j.jobcardstatus,j.vehicleid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.modelid,j.reservationid FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid  WHERE j.jobcardstatus='pending' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();

        $modelid = $row['modelid'];
        $plateimage = $row['plateimage'];
        $servicename = $row['servicename'];
        $serviceid = $row['serviceid'];
        $plateno = $row['plateno'];
        $reservationid = $row['reservationid'];

        $sql2 = "SELECT modelname FROM tbl_models WHERE modelid= $modelid";
        $result2 = $db->query($sql2);
        $row2 = $result2->fetch_assoc();
        $modelname = $row2['modelname'];

        $sql3 = "SELECT firstname,lastname,employeeid,designation FROM tbl_employees e INNER JOIN tbl_jobcardtechnician jt ON jt.technicianid=e.employeeid WHERE jobcardid=$jobcardid AND jt.deletestatus=1";
        $result3 = $db->query($sql3);
        $row3 = $result3->fetch_assoc();
        $technicianname = $row3['firstname'] . " " . $row3['lastname'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (empty($checkedservicetasks)) {

            $messages['error_checkedservice'] = "The service task status should not be empty...!";
        }

        if (empty($testride)) {

            $messages['error_testride'] = "The test ride should not be empty...!";
        }

        if ($issuestatus == 'none') {

            $messages['error_issuestatus'] = "The items should be issue...!";
        }


        if (!empty($checkedservicetasks)) {

            if (count($checkedservicetasks) < 5) {
                $messages['error_checkedservice'] = "The all check tasks should be complete...!";
            }
        }




        if (empty($messages)) {

            //insert checked service tasks
            if (!empty($checkedservicetasks)) {
                foreach ($checkedservicetasks as $key => $value) {

                    $adddate = date('Y-m-d');
                    $adduser = $_SESSION['userid'];

                    $sql = "INSERT INTO tbl_checkedservicetasks(jobcardid,serviceid,subserviceid,status,adddate,adduser) VALUES ($jobcardid,$serviceid,$key,'$value','$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }

            // insert checked recommended sub services

            if (!empty($checkedsubtasks)) {

                foreach ($checkedsubtasks as $key => $value) {

                    $adddate = date('Y-m-d');
                    $adduser = $_SESSION['userid'];

                    $sql = "INSERT INTO tbl_checkedsubservicetasks(jobcardid,subserviceid,status,adddate,adduser) VALUES ('$jobcardid','$key','$value','$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }
            // status change in jobcard and testride

            if (!empty($testride)) {

                $sql1 = "UPDATE tbl_jobcards SET jobcardstatus='completed',testride='$testride' WHERE jobcardid='$jobcardid'";
                $db = dbConn();
                $db->query($sql1);
            }


            $sql2 = "UPDATE tbl_reservations SET jobcardstatus='completed' WHERE reservationid='$reservationid'";
            $db = dbConn();
            $db->query($sql2);

            $date = date('Y-m-d');
            $sql2 = "UPDATE tbl_jobcardtechnician SET technicianstatus='released' WHERE jobcardid='$jobcardid' AND adddate='$date'";
            $db = dbConn();
            $db->query($sql2);

            showSuccMeg();
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
                    <input type="hidden" name="plateimage" class="form-control" value='<?php echo $plateimage; ?>'readonly >

                    <div class="mt-4">
                        <label class="form-label">Technician Name:</label>
                        <input type="text" name="technicianname" class="form-control" value='<?php echo @$technicianname; ?>'readonly >

                    </div>


                </div>    
            </div> 
        </div>    

        <div class="card px-md-4 mb-2 my-card-bg">

            <legend>Investigation Report:</legend>

            <div class="row">
                <table>
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                    </tr>


                    <?php
                    $db = dbconn();
                    $sql = "SELECT i.taskname,ji.taskstatus,ji.investigationtaskid FROM tbl_investigationtasks i INNER JOIN tbl_jobcardinvestigationtasks ji ON i.investigationtaskid=ji.investigationtaskid WHERE ji.jobcardid=$jobcardid AND ji.deletestatus='1'";
                    $result = $db->query($sql);
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td>
                                <?php echo $rows['taskname'] . ":"; ?>
                            </td>    
                            <td>
                                <?php echo ucfirst($rows['taskstatus']) ?>
                            </td>


                        </tr>

                        <?php
                    }
                    ?>   
                </table>   
            </div>


        </div>


        <div class="card px-md-4 mb-2 my-card-bg">
            <div class="row">



                <div class="col-md-6">

                    <legend>Service Details:</legend>  
                    <div class="mb-3">
                        <label class="form-label">Service Type:</label>
                        <input type="text" class="form-control-md" name=servicename value='<?php echo @$servicename; ?>' readonly>           
                    </div>
                    <label class="form-label">Check Service task list:</label>
                    <?php
                    $db = dbconn();
                    $sql = "SELECT sub.subservicename,sub.subserviceid FROM tbl_jobcardassignserviceslist st INNER JOIN tbl_subservices sub ON sub.subserviceid=st.subserviceid WHERE st.jobcardid=$jobcardid AND sub.deletestatus='1'";
                    $result = $db->query($sql);

                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <div class="mb-1">
                            <label><?= $rows['subservicename']; ?></label>
                            <?php
                            $subserviceid = $rows['subserviceid'];
                            ?>

                            <?php
                            //view subservice task lists

                            $sql1 = "SELECT subt.taskname FROM tbl_subservicetasks subt LEFT JOIN tbl_subservices sub ON sub.subserviceid=subt.subserviceid WHERE subt.subserviceid=$subserviceid AND subt.deletestatus='1'";
                            $result1 = $db->query($sql1);
                            while ($row = $result1->fetch_assoc()) {
                                ?>
                                <ul>
                                    <li>    
                                        <?php echo $row['taskname']; ?>
                                    </li>    
                                </ul>
                                <?php
                            }
                            ?>

                            <div class = "form-control">
                                <div class = "form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name ="checkedservicetasks[<?= $subserviceid ?>]" id="done" value="done" <?php if (isset($checkedservicetasks[$subserviceid]) && $checkedservicetasks[$subserviceid] == "done") { ?> checked <?php } ?>>
                                    <label class="form-check-label" for="done">Done</label>
                                </div>

                            </div>


                        </div>
                        <?php
                    }
                    ?>
                    <div class="text-danger"><?php echo @$messages['error_checkedservice']; ?></div>
                    <div class="text-danger"><?php echo @$messages['error_checkservicetasks']; ?></div>
                </div>



                <div class="col-md-6">

                    <label>Additional sub services:</lable><br>

                        <?php
                        $db = dbconn();
                        $sql = "SELECT sub.subserviceid,sub.subservicename FROM tbl_jobcardassignsubservices assigned INNER JOIN tbl_subservices sub ON sub.subserviceid=assigned.subserviceid  WHERE assigned.deletestatus='1' AND assigned.jobcardid='$jobcardid'";
                        $result = $db->query($sql);
                        $count = $result->num_rows;
                        if ($count == '0') {

                            echo "<div class='mb-2'>" . "There are no selected sub services...!" . "</div>";
                        } else {
                            while ($rows = $result->fetch_assoc()) {
                                $subservicename = $rows['subservicename'];
                                $subserviceid = $rows['subserviceid'];
                                ?> 


                                <label><?= $subservicename; ?>: </label>
                                <div class="mb-3">
                                    <div class = "form-check form-check-inline">
                                        <input class = "form-check-input" type = "checkbox" name = "checkedsubtasks[<?= $subserviceid ?>]" id="done" value="done" <?php if (isset($checkedsubtasks[$subserviceid]) && $checkedsubtasks[$subserviceid] == "done") { ?> checked <?php } ?>>
                                        <label class="form-check-label" for="done">Done</label>
                                    </div>




                                </div>


                                <?php
                            }
                        }
                        ?>


                        <label>Test ride: </label>
                        <div class="mb-3">
                            <div class = "form-check form-check-inline">
                                <input class = "form-check-input" type = "checkbox" name ="testride" id="passed" value="passed" <?php if (isset($testride) && $testride == "passed") { ?> checked <?php } ?>>
                                <label class="form-check-label" for="passed">passed</label>
                            </div>

                            <div class="text-danger"><?php echo @$messages['error_testride']; ?></div>
                        </div>


                        <label class="fs-5">Job card assigned items: </label>

                        <div class="mb-3">
                            <div class = "form-check form-check-inline">
                                <table>
                                    <thead>

                                    <th>Item Name</th>
                                    <th>Item Qty</th>
                                    <th>Issue Status</th>

                                    </thead> 
                                    <tbody>


                                        <?php
                                        $sqlitem = "SELECT a.issueqty,a.issuestatus,c.itemname,c.itemimage FROM tbl_jobcardassignitems a LEFT JOIN tbl_itemcatalog c ON c.catalogid=a.catalogid  WHERE a.deletestatus='1' AND a.jobcardid='$jobcardid'";
                                        $resultitem = $db->query($sqlitem);
                                        $countitem = $resultitem->num_rows;
                                        if ($countitem > "0") {
                                            while ($rowitem = $resultitem->fetch_assoc()) {
                                                ?>
                                            <input type="hidden" name="issuestatus" value="<?= $rowitem['issuestatus'] ?>" >
                                            <tr>

                                                <td> <?php echo $rowitem['itemname'] ?></td>
                                                <td>  <?php echo $rowitem['issueqty'] ?></td>
                                                <td>  <?php echo $rowitem['issuestatus'] ?></td>




                                            </tr>    

                                            <?php
                                        }
                                    } else {
                                        echo "There are no items to issue in this job card.";
                                    }
                                    ?>
                                    </tbody>
                                </table>



                            </div>
                        </div>



                        <div class="text-danger"><?php echo @$messages['error_issuestatus']; ?></div>

                </div>





            </div>
            <input type="hidden" name="jobcardid" class="form-control" value='<?= @$jobcardid; ?>'>
            <input type="hidden" class="form-control-md" name="serviceid" value='<?php echo @$serviceid; ?>'>
            <input type="hidden" name="reservationid" class="form-control" value='<?= @$reservationid; ?>'>


        </div>

        <div class="row">
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>


            </div>
        </div>




    </form>


    <?php include '../footer.php'; ?>