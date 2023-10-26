<?php include '../header.php'; ?>

<!-- table styles -->
<style>
    table, th, td {
        border:1px solid black;
    }  


</style>

<?php include '../menu.php'; ?>

<main class="col-md-12 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
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



    <h6>Assign Sub services for Job card</h6>

    <?php
    extract($_GET);
    $messages = array();

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'edit' && @$action != 'delete') {

        $date = date('Y-m-d');
        $sqltbl = "SELECT j.serviceid FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid WHERE j.jobcardstatus='pending' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
        $db = dbConn();
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();
        $serviceid = $row['serviceid'];

        $sql1 = "SELECT jas.subserviceid,sub.subservicename,sub.subserviceprice FROM tbl_jobcardassignsubservices jas INNER JOIN tbl_subservices sub ON sub.subserviceid=jas.subserviceid WHERE sub.deletestatus='1' AND jobcardid='$jobcardid'";
        $db = dbConn();
        $result1 = $db->query($sql1);

        while ($rows = $result1->fetch_assoc()) {

            $subserviceid = $rows['subserviceid'];
            $subservicename = $rows['subservicename'];
            $subserviceprice = $rows['subserviceprice'];

            $_SESSION['assignsubservices'][$subserviceid] = array('subservicename' => $subservicename, 'subserviceprice' => $subserviceprice);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (empty($_SESSION['assignsubservices'])) {
            $messages['error_subservice'] = "The subservice should not be empty...!";
        }

        if (empty($messages)) {
            $_SESSION['subservicetotalprice'] = $subservicestotalprice;
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            //add recommended sub services into jobcard.
            if (isset($_SESSION['assignsubservices'])) {
                $sql = "DELETE FROM tbl_jobcardassignsubservices WHERE jobcardid='$jobcardid'";
                $db = dbConn();
                $db->query($sql);

                foreach ($_SESSION['assignsubservices'] as $key => $value) {
                    $sql = "INSERT INTO tbl_jobcardassignsubservices(jobcardid,subserviceid,adddate,adduser) VALUES ('$jobcardid',$key,'$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }
            unset($_SESSION['assignsubservices']);
            
            header("Location:editassign_materialsjobcard.php?jobcardid=$jobcardid&mode=edit");
        }
    }


    extract($_GET);
    //sub services delete
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'delete') {

        $assignsubservices = $_SESSION['assignsubservices'];
        unset($assignsubservices[$subserviceid]);
        $_SESSION['assignsubservices'] = $assignsubservices;
    }
    ?>



    <div class="row">


        <div class="col-md-6">

            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                <label class="form-label fs-5">Additional sub service list</label><br>
                <div class="text-danger"><?php echo @$messages['error_subservice']; ?></div>
                <?php
                if (isset($_SESSION['assignsubservices'])) {
                    $totalprice = 0;
                    foreach ($_SESSION['assignsubservices'] as $key => $value) {
                        $totalprice += $value['subserviceprice'];
                        ?>

                        <table>
                            <tbody>
                                <tr>
                                    <td>   
                                        <input type="text"  value="<?= $value['subservicename'] . "-" . $value['subserviceprice']; ?>" name="subservice">
                                        <a href="editassign_subservicesjobcard.php?subserviceid=<?= $key; ?>&action=delete&jobcardid=<?= $jobcardid ?>&serviceid=<?= $serviceid ?>"><i class="bi bi-x-square"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <?php
                    }

                    echo "Rs" . " " . number_format($totalprice, 2);
                }
                ?>
                <input type="hidden"  value="<?= @$totalprice; ?>" name="subservicestotalprice">
                <input type="hidden"  value="<?= @$serviceid; ?>" name="serviceid">
                <input type="hidden" name="jobcardid" class="form-control" value="<?= @$jobcardid; ?>">
               

                </div>










                <div class="col-md-6">
                    <legend>Investigation Report:</legend>
                    <table class="" width="50%">
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
                </div>`


        </div>
        <div class="row">
            <div class="col-md-3">
                <button type="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>
            </div>
            <div class="col-md-3">
                <a class="btn card-btn btn-sm mt-2 mb-2" href="editassign_materialsjobcard.php?jobcardid=<?= $jobcardid ?>&mode='edit'">Next</a>
            </div>
        </div>

        </form>



        <div class="row">


            <legend>Add Recommended Sub Services:</legend> 

            <?php
            $sql = "SELECT subserviceid,subservicename,subserviceprice FROM tbl_subservices WHERE subserviceid NOT IN"
                    . "(SELECT sub.subserviceid FROM tbl_servicetasks st INNER JOIN tbl_subservices sub ON sub.subserviceid=st.subserviceid WHERE st.serviceid=$serviceid)";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>

                    <div class="col-md-4">
                        <div class="mt-2" style="border: solid #04414d 1px"> 
                            <?= $row['subservicename'] . "-" . $row['subserviceprice'] ?>

                            <form method="post" action="edit_additionalsubservices.php">
                                <input type="hidden" name="subserviceid" value="<?= $row['subserviceid'] ?>">
                                <input type="hidden" name="serviceid" value="<?= $serviceid ?>">

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









</main>
<?php
include '../footer.php';
?>
