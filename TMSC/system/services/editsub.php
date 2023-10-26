<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add New Sub Service</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/subservice.php" class="btn btn-sm btn-outline-secondary">View Sub Service</a>
                
            </div>
           
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        //Extract inputs
        extract($_GET);

        if (@$mode == "edit") {
            
            $sql = "SELECT * FROM tbl_subservices WHERE subserviceid='$subserviceid'";
            $db = dbConn();
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            $_SESSION['editsubserviceid'] = $row['subserviceid'];
            $_SESSION['editsname'] = $row['subservicename'];
            $_SESSION['editsprice'] = $row['subserviceprice'];
            $_SESSION['editduration'] = $row['duration'];

            $sql = "SELECT * FROM tbl_subservicetasks WHERE subserviceid=$subserviceid";
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc()) {
                $_SESSION['subservicetask'][] = $row['taskname'];
            }
        }
    }

    extract($_GET);
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'delete') {
        $subservicetask = $_SESSION['subservicetask'];
        unset($subservicetask[$subservice]);
        $_SESSION['subservicetask'] = $subservicetask;
    }

    //Extract inputs
    extract($_POST);

    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operate == "submit") {



        //Data clean
        $sname = cleanInput($sname);
        $sprice = cleanInput($sprice);

        //Create array
        $messages = array();

        //required validation
        if (empty($sname)) {
            $messages['error_sname'] = "The sub service name should not be empty...!";
        }
        if (empty($sprice)) {
            $messages['error_sprice'] = "The sub service price should not be empty...!";
        }

        if (empty($duration)) {
            $messages['error_duration'] = "The sub service duration should not be empty...!";
        }
        if (empty($_SESSION['subservicetask'])) {
            $messages['error_tasks'] = "The task list should not be empty...!";
        }



        //advanced validaion

       
        
        
        if (!empty($sprice)) {
            if (!preg_match('/^[0-9 . ]+$/i', $sprice)) {
                $messages['error_sprice'] = "Only allows numbers..!";
            }
        }
        
        
        
        
        
        
if(!empty($_SESSION['subservicetask'])){
        //validate subservicetask array data
        foreach ($_SESSION['subservicetask'] as $value) {
            $task = cleanInput($value);

            if (empty($task)) {
                $messages['error_tasks'] = "The task should not be empty...!";
            }

            if (!empty($task)) {
                if (!preg_match('/^[a-z ]+$/i', $task)) {
                    $messages['error_tasks'] = "Task name should be letters and white spaces only.";
                }
            }
        }
}


        if (!empty($sname)) {
            if (!preg_match('/^[a-z ]+$/i', $sname)) {
                $messages['error_sname'] = "The sub service name should be letters and white spaces only";
            }
        }


        if (!empty($sname)) {

            $sql = "SELECT * FROM tbl_subservices WHERE subservicename='$sname' AND subserviceid!=$subserviceid";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_sname'] = "The sub service Name already exsist...!";
            }
        }


        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];

            $sql = "UPDATE tbl_subservices SET subservicename='$sname',subserviceprice='$sprice',duration='$duration',updatedate='$updatedate',updateuser='$updateuser' WHERE subserviceid=$subserviceid";
            $db = dbConn();
            $db->query($sql);

            $sql1 = "DELETE FROM tbl_subservicetasks WHERE subserviceid=$subserviceid";
            $db->query($sql1);

            foreach ($_SESSION['subservicetask'] as $value) {
                $adddate = date('Y-m-d');
                $adduser = $_SESSION['userid'];

                $sql1 = "INSERT INTO tbl_subservicetasks(subserviceid,taskname,adddate,adduser) VALUES('$subserviceid','$value','$adddate','$adduser')";
                $db->query($sql1);
            }
            showEditSucc();
            unset($_SESSION['subservicetask']);
            unset($_SESSION['editsname']);
            unset($_SESSION['editduration']);
            unset($_SESSION['editsprice']);
            unset($_SESSION['editsubserviceid']);
        }
    }
    ?>
    <div class="row">
        <div class="col-md-6">

            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" class="form-control w-75" id="subserviceid" name="subserviceid" value="<?= @$_SESSION['editsubserviceid']; ?>" >`
                <div class="mb-3">

                    <label for="service_name" class="form-label">Enter Sub Service Name</label>
                    <input type="text" class="form-control w-75" id="service_name" name="sname" value="<?= @$_SESSION['editsname']; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_sname']; ?></div>
                </div>

                <div class="mb-3">
                    <label for="sprice" class="form-label">Sub Service Price(Rs.)</label>

                    <input type="text" class="form-control w-75" id="sprice" name="sprice" value="<?= @$_SESSION['editsprice']; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_sprice']; ?></div>
                </div>

                <label for="duration" class="form-label">Duration</label>
                <div class="mb-3">

                    <select name="duration" id="duration" class="form-control-sm w-50">
                        <option value="<?php echo @$_SESSION['editduration'] ?>"><?php echo @$_SESSION['editduration'] ?></option>
                        <option value="5 minute">00:05</option>
                        <option value="10 minute">00:10</option>
                        <option value="15 minute">00:15</option>
                        <option value="30 minute">00:30</option>
                        <option value="45 minute">00:45</option>
                        <option value="60 minute">01:00</option>
                        <option value="75 minute">01:15</option>
                        <option value="90 minute">01:30</option>
                        <option value="105 minute">01:45</option>
                        <option value="120 minute">02:00</option>

                    </select>

                    <div class="text-danger"><?php echo @$messages['error_duration']; ?></div>
                </div>

                <div class="row justify-content-around">
                    <div class="col-4">
                        <button type="submit" class="btn btn-outline-primary" name="operate" value="submit">Submit</button>
                    </div>
                    <div class="col-4">
                        <a href="<?= SYSTEM_PATH; ?>services/addsub.php" class="btn btn-outline-primary ">Reset</a>
                    </div>
                </div>       


            </form>
        </div>
        <div class="col-md-6">
            <form method="POST" action="edittasktoform.php">
                <label>Enter Tasks List</label>
                <div class="mb-3">

                    <input type="text" class="form-control w-75" id="task" name="task" onchange="form.submit()" >
                    <div class="text-danger"><?php echo @$messages['error_tasks']; ?></div>
                </div>


            </form>

<?php
if (isset($_SESSION['subservicetask'])) {
    foreach (@$_SESSION['subservicetask'] as $key => $value) {
        ?>
                    <table>
                        <tbody>
                            <tr>
                                <td>   
                                    <input type="text" class="" id="subservice" value="<?= $value; ?>" name="subservice">
                                </td>
                                <td>  
                                    <a href="editsub.php?subservice=<?= $key; ?>&action=delete"><i class="bi bi-x-square"></i></a>
                                </td>        
                            </tr>
                        </tbody>
                    </table>
        <?php
    }
}
?>   
        </div>
    </div>

</main>

            <?php include '../footer.php'; ?>