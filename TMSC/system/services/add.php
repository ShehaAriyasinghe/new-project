
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add New Service Package</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/service.php" class="btn btn-sm btn-outline-secondary">View Service</a>
                
            </div>
            
        </div>
    </div>
    <?php
    extract($_GET);
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'delete') {
        $subservicecart = $_SESSION['service'];
        unset($subservicecart[$subservice]);
        $_SESSION['service'] = $subservicecart;
    }

    //Check submit
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $operate == 'submit') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $servicename = cleanInput($servicename);

        //Create array
        $messages = array();

        //required validation
        if (empty($servicename)) {
            $messages['error_sname'] = "The service name should not be empty...!";
        }
        if (empty($serviceprice)) {
            $messages['error_sprice'] = "The service price should not be empty...!";
        }

        if (empty($serviceduration)) {
            $messages['error_duration'] = "The service duration should not be empty...!";
        }
        
        if (count($_SESSION['service']) == "0") {
            $messages['error_subservice'] = "The sub service list should not be empty...!";
        }


        //advanced validaion

        if (!empty($serviceprice)) {
           
            
            if (!preg_match('/^[0-9]+$/i', $serviceprice)) {
                $messages['error_sprice'] = "Service Price is allowed numbers only.";
            }
            
            
            
        }

       


        if (!empty($servicename)) {
            
            if (!preg_match('/^[a-z ]+$/i', $servicename)) {
                $messages['error_sname'] = "Service Name is allowed letters and white spaces only.";
            }else{
            
            
            $sql = "SELECT * FROM tbl_services WHERE servicename='$servicename' AND deletestatus=1";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_sname'] = "The service Name already exsist...!";
            }
        }
        }

        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $serviceduration = $serviceduration . " " . "minute";
            $sql = "INSERT INTO tbl_services(servicename,serviceprice,duration,serviceadddate,adduser) VALUES('$servicename','$serviceprice','$serviceduration','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);
            $lasatid = $db->insert_id;

            foreach ($_SESSION['service'] as $key => $value) {
                $sql1 = "INSERT INTO tbl_servicetasks(serviceid,subserviceid,adddate,adduser) VALUES('$lasatid','$key','$adddate','$adduser')";
                $db = dbConn();
                $db->query($sql1);
            }
            showSuccMeg();
            unset($_SESSION['service']);
        }
    }



    $db = dbconn();
    $sql1 = "SELECT * FROM tbl_subservices WHERE deletestatus=1";
    $result = $db->query($sql1);
    ?>




    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="mt-2" style="border: solid #04414d 1px">

                <?= $row['subservicename'] ?>
                <?= $row['subserviceprice'] ?>
                <?= $row['duration'] ?>
                <form method="post" action="addsubservicestoform.php">
                    <input type="hidden" name="subserviceid" value="<?= $row['subserviceid'] ?>">
                    <button type="submit" name="operate" value="add"><i class="bi bi-plus-square-fill"></i></button>


                </form>
            </div>
            <?php
        }
    }
    ?>








    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <table>
            <thead>

            <th>Sub Service Name</th>
            <th>Sub Service Price</th>
            <th>Duration</th>
            <th>Action</th>

            </thead>

            <?php
            if (isset($_SESSION['service'])) {
                $total = 0;
                $totaltime = "00:00";
                foreach ($_SESSION['service'] as $key => $value) {
                    $total += $value['subserviceprice'];
                    $servicetime = "+" . $value['duration'];

                    $totaltime = date('H:i', strtotime($servicetime, strtotime($totaltime)));
                    ?> 

                    <tbody>
                        <tr>
                            <td><input type="text" name="service" value="<?= $value['subservicename']; ?>" readonly></td>
                            <td>Rs. <input type="text" name="service" value="<?= $value['subserviceprice']; ?>" readonly></td>
                            <td><input type="text" name="service" value="<?= $value['duration']; ?>" readonly></td>
                            <td><a href="add.php?subservice=<?= $key; ?>&action=delete"><i class="bi bi-x-square"></i></a></td>
                        </tr>
                    

                        <?php
                    }
                    ?>

                  
                    <tr>
                        <td>Total Price:(Rs.)<input type="text" name="serviceprice" value="<?= $total; ?>"></td>
                        <?php
                        $time = explode(':', $totaltime);
                        $totalminutes = ($time[0] * 60) + ($time[1]);
                        ?>
                        <td>Total time:<input type="text" name="service" value="<?= $totaltime; ?>" readonly></td>
                        <td>Total minutes:<input type="text" name="serviceduration" value="<?= $totalminutes; ?>"></td>

                    </tr>
                </tbody>
            </table>
            <div class="text-danger"><?php echo @$messages['error_sprice']; ?></div>
            <div class="text-danger"><?php echo @$messages['error_duration']; ?></div>
            <div class="text-danger"><?php echo @$messages['error_subservice']; ?></div>


            <?php
        }
        ?>

        <div class="mb-3">
            <label for="service_name" class="form-label">Enter Service Package Name</label>
            <input type="text" class="form-control w-75" id="service_name" name="servicename" value="<?= @$servicename; ?>" >
            <div class="text-danger"><?php echo @$messages['error_sname']; ?></div>
        </div>

        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary" name="operate" value="submit">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>services/add.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>





</main>

<?php include '../footer.php'; ?>