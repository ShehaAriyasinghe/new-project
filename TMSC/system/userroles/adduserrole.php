<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add user role </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>userroles/userrole.php" class="btn btn-sm btn-outline-secondary">View user roles</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update  Product
            </button>
        </div>
    </div>
    <?php
    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $jobrole = cleanInput(@$jobrole);
        $jstatus = cleanInput(@$jstatus);
        
        //Create array
        $messages = array();

        //required validation
        if (empty($jobrole)) {
            $messages['error_jobrole'] = "The Job Role should not be empty...!";
        }
        if (empty($jstatus)) {
            $messages['error_jstatus'] = "The Job role status should not be empty...!";
        }

        //advanced validaion

        if (!empty($jobrole)) {
            $sql = "SELECT * FROM tbl_jobroles WHERE jobrolename='$jobrole'";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_jobrole'] = "This Job Role already exists...!";
            }
        }
        
        
        if (!empty($jobrole)) {
            if (!preg_match('/^[a-z ]+$/i', $jobrole)) {
                $messages['error_jobrole'] = "Jobrole is allowed letters and white spaces only.";
            }
        }

        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql1 = "INSERT INTO tbl_jobroles(jobrolename,jobavailability,adddate,adduser) VALUES('$jobrole','$jstatus','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql1);
            showSuccMeg();
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="mb-3">
            <label for="jobrole" class="form-label">Enter Job Role</label>
            <input type="text" class="form-control w-75" id="jobrole" name="jobrole" value="<?= @$jobrole; ?>" >
            <div class="text-danger"><?php echo @$messages['error_jobrole']; ?></div>
        </div>
        
        <div class="mb-3">
        <label>Select User Account Availability</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jstatus" id="Yes" value="y" <?php if (isset($jstatus) && $jstatus == 'y') { ?> checked <?php } ?> >
            <label class="form-check-label" for="Yes">
                Yes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="jstatus" id="No" value="n" <?php if (isset($jstatus) && $jstatus == 'n') { ?> checked <?php } ?>>
            <label class="form-check-label" for="No">
                No
            </label>
        </div>
         <div class="text-danger"><?php echo @$messages['error_jstatus']; ?></div>
        </div>
         
        
        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>userroles/adduserrole.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>