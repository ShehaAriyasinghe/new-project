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


            </div>

        </div>
    </div>



    <h6>Assign Sub services for Job card</h6>

    <?php
    extract($_GET);
    extract($_POST);
    $messages = array();

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'assign') {
        $date = date('Y-m-d');

        $sqltbl = "SELECT j.serviceid,s.servicename FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid WHERE j.jobcardstatus='issuedjobcard' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
        $db = dbConn();
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();
        $serviceid = $row['serviceid'];
        $servicename = $row['servicename'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operate == 'submit') {
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
                foreach ($_SESSION['assignsubservices'] as $key => $value) {
                    $sql = "INSERT INTO tbl_jobcardassignsubservices(jobcardid,subserviceid,adddate,adduser) VALUES ('$jobcardid',$key,'$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }
            unset($_SESSION['assignsubservices']);
            header("Location:assign_materialsjobcard.php?jobcardid=$jobcardid&mode=$mode");
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
            <div class="mb-2">
                <label>Service Name:</label>
                <input type="text" class="form-control" value="<?= @$servicename; ?>" name="servicename" readonly="">
            </div>


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
                                        <a href="assign_subservicesjobcard.php?subserviceid=<?= $key; ?>&action=delete&mode=<?= $mode ?>&jobcardid=<?= $jobcardid ?>"><i class="bi bi-x-square"></i></a>
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
                <input type="hidden" name="mode" value="<?= @$mode ?>">

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
                <button type="submit" name="operate" value="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>
            </div>
            <div class="col-md-3">
                <a class="btn card-btn btn-sm mt-2 mb-2" href="assign_materialsjobcard.php?jobcardid=<?= $jobcardid; ?>&mode=<?= $mode ?>">Next</a>
            </div>
        </div>


        </form>



        <div class="row">

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
            
            
            
            <legend>Add Recommended Sub Services:</legend> 

            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row mt-4">
                    <div class="col">
                        <input type="text" class="form-control" name="subname" placeholder="Subservice name" value="<?= @$subname; ?>">
                    </div>

                    <input type="hidden" name="jobcardid" class="form-control" value="<?= @$jobcardid; ?>">


                    <input type="hidden"  value="<?= @$serviceid; ?>" name="serviceid">

                    <input type="hidden" name="mode" value="<?= @$mode ?>">

                    <div class="col"><button type="submit" name="search" value="search" class="btn card-btn btn-sm">Search</button></div>
                </div>
            </form>







            <?php
            $sql = "SELECT subserviceid,subservicename,subserviceprice FROM tbl_subservices WHERE $where subserviceid NOT IN"
                    . "(SELECT sub.subserviceid FROM tbl_servicetasks st INNER JOIN tbl_subservices sub ON sub.subserviceid=st.subserviceid WHERE st.serviceid=$serviceid)";
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>

                    <div class="col-md-4">
                        <div class="mt-2" style="border: solid #04414d 1px"> 
                            <?= $row['subservicename'] . "-" . $row['subserviceprice'] ?>

                            <form method="post" action="add_additionalsubservices.php">
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









</main>
<?php
include '../footer.php';
?>
