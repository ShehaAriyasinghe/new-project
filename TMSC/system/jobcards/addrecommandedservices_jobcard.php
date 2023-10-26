<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/completed_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all completed job cards</a>

            </div>

        </div>
    </div>

    <h6>Complete Job card</h6>

    <?php
    extract($_GET);
    extract($_POST);
    $db = dbconn();
    $messages = array();

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'complete') {

        $date = date('Y-m-d');
        $sqltbl = "SELECT j.jobcardid,j.jobcardstatus,j.testride,j.mileage,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.modelid FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid  WHERE j.jobcardstatus='completed' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();

        $modelid = $row['modelid'];
        $plateimage = $row['plateimage'];
        $servicename = $row['servicename'];
        $serviceid = $row['serviceid'];
        $plateno = $row['plateno'];
        $testride = $row['testride'];
        $vehicleid = $row['vehicleid'];
        $mileage = $row['mileage'];

        $sql2 = "SELECT modelname FROM tbl_models WHERE modelid= $modelid";
        $result2 = $db->query($sql2);
        $row2 = $result2->fetch_assoc();
        $modelname = $row2['modelname'];
    }


    // delete added subservices
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'delete') {

        $assignsubservices = $_SESSION['assignrecommandedsubservices'];
        unset($assignsubservices[$subserviceid]);
        $_SESSION['assignrecommandedsubservices'] = $assignsubservices;
    }




    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operation=='submit') {
        extract($_POST);

        if (empty($engineoil)) {
            $messages['error_engineoil'] = "The Engine oil status should not be empty...!";
        }



        if (@$engineoil == "done") {


            if (empty($nextmileage)) {
                $messages['error_mileage'] = "The Next mileage should not be empty...!";
            }




            if (!empty($nextmileage)) {
                if (!preg_match('/^[-0-9 ]+$/i', $nextmileage)) {
                    $messages['error_mileage'] = "The next mileage should be numbers only...!";
                }
            }
        }




        if (empty($messages)) {
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            //Insert to recommended tasks for next service
            if (!empty($_SESSION['assignrecommandedsubservices'])) {
                foreach ($_SESSION['assignrecommandedsubservices'] as $key => $value) {



                    $sql = "INSERT INTO tbl_nextrecommendedsubservices(vehicleid,jobcardid,subserviceid,adddate,adduser) VALUES ($vehicleid,$jobcardid,$key,'$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }


            // insert recommended mileage,next service duration

            if ($engineoil == "done") {


                $sql1 = "INSERT INTO tbl_nextrecommendedmileage(vehicleid,jobcardid,nextmileage,adddate,adduser) VALUES ($vehicleid,$jobcardid,'$nextmileage','$adddate','$adduser')";
                $db = dbConn();
                $db->query($sql1);
            }


            //insert comment 
            if (!empty($comment)) {

                $sql1 = "INSERT INTO tbl_nextrecommendation(vehicleid,jobcardid,comment,adddate,adduser) VALUES ($vehicleid,$jobcardid,'$comment','$adddate','$adduser')";
                $db = dbConn();
                $db->query($sql1);
            }



            // job card status is updated as payment

            $sql = "UPDATE tbl_jobcards SET jobcardstatus='pendingpayment',oilstatus='$engineoil' WHERE jobcardid=$jobcardid";
            $db = dbConn();
            $db->query($sql);

            unset($_SESSION['assignrecommandedsubservices']);
            showSuccMeg();
        }
    }
    ?>



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

                <legend>Service Report:</legend>  
                <div class="mb-3">
                    <label class="form-label">Service Type:</label>
                    <input type="text" class="form-control-md" name=servicename value='<?php echo @$servicename; ?>' readonly>           
                </div>
                <label class="form-label">Report of service task list:</label>
                <?php
                $db = dbconn();
                $sql = "SELECT sub.subserviceid,sub.subservicename,checkedservice.status FROM tbl_checkedservicetasks checkedservice INNER JOIN tbl_subservices sub ON sub.subserviceid=checkedservice.subserviceid WHERE checkedservice.jobcardid=$jobcardid AND sub.deletestatus='1'";
                $result = $db->query($sql);

                while ($rows = $result->fetch_assoc()) {
                    ?>
                    <div class="mb-1">
                        <label><?php echo $rows['subservicename'] . " :"; ?></label>
                        <?php echo ucfirst($rows['status']); ?>

                    </div>
                    <?php
                    if ($rows['subserviceid'] == '3') {
                        $engineoil = $rows['status'];
                    }
                }
                ?>
            </div>


            <div class="col-md-6">

                <lable class="form-label">Report of additional sub services:</lable><br>

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
                        <?php echo ucfirst($testride) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="jobcardid" class="form-control" value='<?= $jobcardid; ?>'>
        <input type="hidden" value="<?= $vehicleid; ?>" name="vehicleid">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        <input type="hidden" name="plateno" class="form-control" value='<?php echo $plateno; ?>' >
        <input type="hidden" name="modelname" class="form-control" value='<?php echo $modelname; ?>'>
        <input type="hidden" name="plateimage" class="form-control" value='<?php echo $plateimage; ?>'>
        <input type="hidden" name="testride" class="form-control" value='<?php echo $testride; ?>'>
        <input type="hidden" name="serviceid" class="form-control" value='<?php echo $serviceid; ?>'>
        <input type="hidden" name="servicename" class="form-control" value='<?php echo $servicename; ?>'>





        <div class="row">
            <div class="col-md-4 mb-5">
                <span>Select recommended services first.(optional)</span>
                <label>Recommended tasks to next service: </label>

                <?php
                if (isset($_SESSION['assignrecommandedsubservices'])) {

                    foreach ($_SESSION['assignrecommandedsubservices'] as $key => $value) {
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <td>   
                                        <input type="text"  value="<?= $value['subservicename'] ?>" name="subservice" readonly>
                                        <a href="addrecommandedservices_jobcard.php?subserviceid=<?= $key; ?>&action=delete&mode=<?= $mode ?>&jobcardid=<?= $jobcardid ?>"><i class="bi bi-x-square"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <?php
                    }
                }
                ?>


            </div>

            <div class="col-md-8">
                <label>Current mileage:(Km)</label>
                <input type="text" class="form-control-sm" name="mileage" value="<?= @$mileage ?>" readonly><span>Km</span><br>

                <?php
                if (@$engineoil == "done") {


                    $nextmileagemin = $mileage + 1000;
                    $nextmileagemax = $nextmileagemin + 250
                    ?>

                    <label class="form-label">Next service mileage range:</label>
                    <div class = "form-control">
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-radio-input" type="text" name ="nextmileage" value="<?php echo $nextmileagemin . "-" . $nextmileagemax; ?>" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="text-danger"><?php echo @$messages['error_mileage']; ?></div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Add future comments(optional):</label>
                <textarea class="form-control" name="comment"><?= @$comment ?></textarea>

            </div>

        </div>
        <div class="row">

            <div class="col-md-6">

                <label>Engine oil change status:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="engineoil" id="done" value="done" <?php if (isset($engineoil) && $engineoil == 'done') { ?> checked <?php } ?> >
                    <label class="form-check-label" for="done">
                        Done
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="engineoil" id="none" value="none" <?php if (isset($engineoil) && $engineoil == 'none') { ?> checked <?php } ?>>
                    <label class="form-check-label" for="none">
                        None
                    </label>
                    <div class="text-danger"><?php echo @$messages['error_engineoil']; ?></div>

                </div>

            </div>


        </div>





        <div class="row">
            <div class="col-md-6">
                <button type="submit" name="operation" value="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>


            </div>
        </div>

    </form>    

    <div class="card px-md-4 mb-2 my-card-bg">
        <div class="row">
            <legend>Add recommended services for next service:</legend> 


            <?php
//search sub services
            $where = null;

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$search == 'search') {
                extract($_POST);

                if (!empty($subname)) {
                    $where .= " subservicename LIKE '$subname%' AND";
                }


                if (!empty($where)) {
                    $where = substr($where, 0, -3);
                    $where = " $where AND";
                }
            }
            ?>





            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row mt-4">
                    <div class="col">
                        <input type="text" class="form-control" name="subname" placeholder="Subservice name" value="<?= @$subname; ?>">
                    </div>

                    <input type="hidden" name="jobcardid" class="form-control" value='<?= $jobcardid; ?>'>
                    <input type="hidden" value="<?= $vehicleid; ?>" name="vehicleid">
                    <input type="hidden" name="mode" value="<?= $mode ?>">
                    <input type="hidden" name="plateno" class="form-control" value='<?php echo $plateno; ?>' >
                    <input type="hidden" name="modelname" class="form-control" value='<?php echo $modelname; ?>'>
                    <input type="hidden" name="plateimage" class="form-control" value='<?php echo $plateimage; ?>'>
                    <input type="hidden" name="testride" class="form-control" value='<?php echo $testride; ?>'>
                    <input type="hidden" name="serviceid" class="form-control" value='<?php echo $serviceid; ?>'>
                    <input type="hidden" name="servicename" class="form-control" value='<?php echo $servicename; ?>'>
                     <input type="hidden" class="form-control-sm" name="mileage" value="<?= @$mileage ?>">




                    <div class="col"><button type="submit" name="search" value="search" class="btn card-btn btn-sm">Search</button></div>
                </div>
            </form>






            <?php
            $sql = "SELECT subserviceid,subservicename,subserviceprice FROM tbl_subservices WHERE $where subserviceid NOT IN(SELECT sub.subserviceid FROM tbl_servicetasks st INNER JOIN tbl_subservices sub ON sub.subserviceid=st.subserviceid WHERE st.serviceid=$serviceid)";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>

                    <div class="col-md-4">
                        <div class="mt-2" style="border: solid #04414d 1px"> 
                            <?= $row['subservicename'] ?>

                            <form method="post" action="add_recommandedsubservices.php">
                                <input type="hidden" name="subserviceid" value="<?= $row['subserviceid'] ?>">
                                <input type="hidden" name="mode" value="<?= $mode ?>">
                                <input type="hidden" name="jobcardid" value="<?= $jobcardid ?>">
                                <button type="submit" class="form-control-sm" name="operate" value="add"><i class="bi bi-plus-square-fill"></i></button>
                            </form>
                        </div>
                    </div>


                    <?php
                }
            }
            ?>
        </div>   
    </div>
</main>

<?php include '../footer.php'; ?>

