<?php include '../header.php'; ?>

<!-- table styles -->
<style>
    table, th, td {
        border:1px solid black;
    }  


</style>

<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all Job cards</a>
                
            </div>
            
        </div>
    </div>

    <h6>Manage Main Service type</h6>


    <?php
    extract($_GET);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'assign') {

        $date = date('Y-m-d');
        $sqltbl = "SELECT s.servicename,s.serviceid FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid WHERE j.jobcardstatus='issuedjobcard' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
        $db = dbConn();
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();

        $servicename = $row['servicename'];
        $serviceid = $row['serviceid'];
    }



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);
        
        
        if (empty($_SESSION['servicetasks'])) {

            $messages['error_servicetask'] = "Service tasks should not be empty..!";
        }
        
        
        
        

        //check validation is completed
        if (empty($messages)) {

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            if (isset($_SESSION['servicetasks'])) {


                foreach ($_SESSION['servicetasks'] as $key => $value) {
                    $sql = "INSERT INTO tbl_jobcardassignserviceslist(jobcardid,subserviceid,adddate,adduser) VALUES ('$jobcardid',$key,'$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }

            $subservicestotalprice = $_SESSION['subservicetotalprice'];
            $technicianid = $_SESSION['technicianid'];

            $sql = "UPDATE tbl_jobcards SET jobcardstatus='pending',subservicestotalprice='$subservicestotalprice',technicianid='$technicianid' WHERE jobcardid=$jobcardid";
            //call to the db connection
            $db = dbConn();
            $db->query($sql);

            unset($_SESSION['servicetasks']);
            unset($_SESSION['subservicetotalprice']);
            unset($_SESSION['technicianid']);

            header("Location:assign_successjobcard.php?jobcardid=$jobcardid");
        }
    }


    extract($_GET);
    //service tasks delete
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$operate == 'servicetaskdelete') {

        $servicetasklist = $_SESSION['servicetasks'];
        unset($servicetasklist[$subserviceid]);
        $_SESSION['servicetasks'] = $servicetasklist;
    }
    ?>


    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'assign' && @$operate != 'servicetaskdelete') {
        $sql = "SELECT sub.subservicename,sub.subserviceprice,sub.subserviceid FROM tbl_servicetasks st INNER JOIN tbl_subservices sub ON sub.subserviceid=st.subserviceid WHERE st.serviceid=$serviceid AND sub.deletestatus='1'";
        $result = $db->query($sql);

        while ($rows = $result->fetch_assoc()) {

            $_SESSION['servicetasks'][$rows['subserviceid']] = array('subservicename' => $rows['subservicename'], 'subserviceprice' => $rows['subserviceprice']);
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row">
            <div class="col-md-6">

                <legend>Service Details:</legend>    

                <div class="mb-3">
                    <label class="form-label">Service Type:</label>
                    <input type="text" class="form-control-md" value='<?php echo @$servicename; ?>' readonly>           
                </div>
                <label class="form-label">Service task list:</label>
                <?php
// remove service tasks
                if (isset($_SESSION['servicetasks'])) {
                    foreach ($_SESSION['servicetasks'] as $key => $value) {
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <td>   
                                        <input type="text" class="form-control-md" value="<?= $value['subservicename'] . "-" . $value['subserviceprice']; ?>" name="subservice" readonly>
                                        <a href="assign_servicejobcard.php?subserviceid=<?= $key; ?>&operate=servicetaskdelete&mode=<?= $mode ?>&jobcardid=<?= $jobcardid ?>"><i class="bi bi-x-square"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <?php
                    }
                }
                ?>
                <input type="hidden" name="jobcardid" class="form-control" value='<?= @$jobcardid; ?>'>
                <input type="hidden" name="mode" value="<?= @$mode ?>">
                
                 <div class="text-danger"><?php echo @$messages['error_servicetask']; ?></div>

            </div>

            <div class="col-md-6">
                <div class="card px-md-4 mb-2">

                    <legend>Investigation Report:</legend>


                    <table class="table table-striped">
                        <thead class="card-btn">
                            <tr>
                                <th>Task</th>
                                <th>Status</th>
                            </tr>
                        </thead>

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


        </div>  


        <div class="row">
            <div class="col-md-3">
                <button type="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>
            </div>

        </div>



    </form>


</main>
<?php
include '../footer.php';
?>
