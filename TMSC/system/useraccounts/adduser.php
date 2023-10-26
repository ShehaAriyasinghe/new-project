<?php ob_start(); ?>

<?php
extract($_GET);
extract($_POST);
if (empty(@$employeeid)) {
    header("Location:selectuser.php");
}
?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add User account </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>useraccounts/user.php" class="btn btn-sm btn-outline-secondary">View User Accounts</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        //Extract inputs
        extract($_GET);

        $sql = "SELECT * FROM tbl_employees WHERE employeeid='$employeeid' AND deletestatus=1";
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $employeeid = $row['employeeid'];

        $nic = $row['nic'];
        $mobile = $row['mobile'];
        $image = $row['image'];

        $jobrole = $row['designation'];
    }


    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean

        $password = cleanInput($password);
        $cpassword = cleanInput($cpassword);

        //Create array
        $messages = array();

        if (empty($password)) {

            $messages['error_password'] = "The Password should not be empty...!";
        }
        if (empty($cpassword)) {

            $messages['error_cpword'] = "The Confirm Password should not be empty...!";
        }

        if (empty($accountstatus)) {

            $messages['error_status'] = "The Account status should not be empty...!";
        }

        //advanced validaion


        if ($password !== $cpassword && !empty($cpassword) && !empty($password)) {
            $messages['error_cpword'] = "The Confirm Password is not matched...!";
        }


        if (!empty($password)) {


            if (strlen($password) < 8) {
                $messages['error_password'] = "The password should be minimum eight characters";
            }


            if (!preg_match("#[A-Z]+#", $password)) {

                $messages['error_password_upper'] = "The password should be minimum one upper case letter";
            }

            if (!preg_match("#[a-z]+#", $password)) {

                $messages['error_password_lower'] = "The password should be minimum one lower case letter";
            }
            if (!preg_match("#[0-9]+#", $password)) {

                $messages['error_password_digit'] = "The password should be minimum one digit";
            }
            if (!preg_match("@[^\w]@", $password)) {

                $messages['error_password_special'] = "The password should be minimum one special character";
            }
        }




        //check validation is completed
        if (empty($messages)) {

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            $password = sha1($password);
            $sql1 = "INSERT INTO tbl_users(username,password,userrole,accountstatus,adduser,adddate) VALUES('$email','$password','$jobrole','$accountstatus','$adduser','$adddate')";
            $db = dbConn();
            $db->query($sql1);
            $userid = $db->insert_id;

            $sql = "UPDATE tbl_employees SET userid='$userid' WHERE employeeid=$employeeid";
            $db->query($sql);

            $_SESSION['accountusername'] = $email;
            $_SESSION['useraccountrole'] = $jobrole;
            header("Location:user_regsuccess.php");
        }
    }
    ?>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="employeeid" value='<?= @$employeeid; ?>'>  
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="firstname" class="form-label">FirstName:</label>
                    <input type="text" name="firstname" class="form-control form-control-sm" value='<?php echo @$firstname; ?>' id="firstname" readonly>  

                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">LastName:</label>
                    <input type="text" name="lastname" class="form-control form-control-sm" value='<?php echo @$lastname; ?>' id="lastname" readonly>  

                </div>
                <div class="mb-3">
                    <label for="nic" class="form-label">NIC:</label>
                    <input type="text" name="nic" class="form-control form-control-sm" value='<?php echo @$nic; ?>' id="nic" readonly>           
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile:</label>
                    <input type="text" name="mobile" class="form-control form-control-sm" value='<?php echo @$mobile; ?>' id="mobile" readonly>           
                </div>

            </div>
            <div class="col-md-4">
                <img class="img-fluid" src="<?= SYSTEM_PATH ?>employees/images/<?= @$image ?>"> 
                <input type="hidden" name="image"  value='<?php echo @$image ?>'>

            </div>    
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="email" class="form-label">Username:</label>
                    <input type="text" name="email" class="form-control form-control-sm" value='<?php echo @$email ?>' id="email" readonly>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="pword" class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control form-control-sm" id="pword">
                            <div class="text-danger"><?php echo @$messages['error_password']; ?></div>
                            
                            
                            <div class="text-danger"><?php echo @$messages['error_password_upper']; ?></div>
                            <div class="text-danger"><?php echo @$messages['error_password_lower']; ?></div>
                            <div class="text-danger"><?php echo @$messages['error_password_special']; ?></div>
                            <div class="text-danger"><?php echo @$messages['error_password_digit']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="cpword" class="form-label">Confirm Password:</label>
                            <input type="password" name="cpassword" class="form-control form-control-sm" id="cpword">
                            <div class="text-danger"><?php echo @$messages['error_cpword']; ?></div>
                        </div>
                    </div>    
                </div>  
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <?php
                    $db = dbConn();
                    $sql = "SELECT jobroleid,jobrolename FROM tbl_jobroles WHERE jobavailability='y' AND deletestatus='1'";
                    $result = $db->query($sql);
                    ?>
                    <label class="form-label">Jobrole :</label>
                    <select class="form-select border-dark" name="jobrole" id="jobrole" value="<?php echo @$jobrole; ?>">
                        <option value="">--</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $row['jobrolename']; ?>" <?php if (@$jobrole == $row['jobrolename']) { ?> selected <?php } ?> disabled><?php echo ucfirst($row['jobrolename']); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>

                    <input type="hidden" name="jobrole" value="<?php echo @$jobrole; ?>">
                </div>

                <div class="mb-3">
                    <label>Account status:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountstatus" id="active" value="active" <?php if (isset($accountstatus) && $accountstatus == 'active') { ?> checked <?php } ?> >
                        <label class="form-check-label" for="active">
                            Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountstatus" id="inactive" value="inactive" <?php if (isset($accountstatus) && $accountstatus == 'inactive') { ?> checked <?php } ?>>
                        <label class="form-check-label" for="inactive">
                            Inactive
                        </label>
                    </div>

                    <div class="text-danger"><?php echo @$messages['error_status']; ?></div>
                </div>

            </div>
        </div>

        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn card-btn">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>useraccounts/selectuser.php" type="submit" class="btn card-btn">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>
<?php ob_flush(); ?>




