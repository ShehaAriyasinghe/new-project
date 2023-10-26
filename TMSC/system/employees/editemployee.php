<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Update Employee </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>employees/employee.php" class="btn btn-sm btn-outline-secondary">View employees</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update  Product
            </button>
        </div>
    </div>
    <?php
    //Check $_GET
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);

        //call to dbconnection
        $db = dbConn();
        // get values of the tbl_employees table
        $sql = "SELECT * FROM tbl_employees WHERE employeeid='$employeeid' AND deletestatus='1'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $nic = $row['nic'];
        $email = $row['email'];
        $address1 = $row['address1'];
        $address2 = $row['address2'];
        $city = $row['city'];
        $mobile = $row['mobile'];
        $jobrole = $row['designation'];
        $image = $row['image'];
        $employeeid = $row['employeeid'];
    }


    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $fname = cleanInput($fname);
        $lname = cleanInput($lname);
        $nic = cleanInput($nic);
        $mobile = cleanInput($mobile);
        $address1 = cleanInput($address1);
        $address2 = cleanInput($address2);
        $city = cleanInput($city);
        $email = cleanInput($email);

        $image = $previousname;

        //Create array
        $messages = array();

        //required validation


        if (empty($fname)) {

            $messages['error_fname'] = "The FistName should not be empty...!";
        }

        if (empty($lname)) {

            $messages['error_lname'] = "The LastName should not be empty...!";
        }

        if (empty($nic)) {

            $messages['error_nic'] = "The NIC should not be empty...!";
        }

        if (empty($mobile)) {

            $messages['error_mobile'] = "The Mobile should not be empty...!";
        }

        if (empty($address1)) {

            $messages['error_address'] = "The Address should not be empty...!";
        }

        if (empty($city)) {

            $messages['error_city'] = "The City should not be empty...!";
        }

        if (empty($email)) {

            $messages['error_email'] = "The Email should not be empty...!";
        }
        if (empty($jobrole)) {

            $messages['error_jobrole'] = "The Job Role should not be empty...!";
        }


        //advanced validaion
        //Check Email already exists

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $messages['error_email'] = "The Email is invalid..!";
            } else {
                $sql = "SELECT * FROM tbl_employees WHERE email='$email' AND employeeid!='$employeeid' AND deletestatus='1'";
                $db = dbConn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_email'] = "This email already exists...!";
                }
            }
        }
        //Check NIC already exists
        if (!empty($nic)) {
            if ($nic) {
                $sql1 = "SELECT * FROM tbl_employees WHERE nic='$nic'AND employeeid!='$employeeid' AND deletestatus='1'";
                $db = dbConn();
                $result1 = $db->query($sql1);
                if ($result1->num_rows > 0) {
                    $messages['error_nic'] = "This NIC already exists...!";
                }
            }


            if (strlen($nic) != 10 && strlen($nic) != 12) {

                $messages['error_nic_length'] = "The NIC length does not match..!";
            }

            if (strlen($nic) == 10) {

                if (!preg_match("/V$/i", $nic) || (!preg_match("/(^\d{9})/", $nic))) {
                    $messages['error_nic_format'] = "The NIC old format is invalid..!";
                }
            }

            if (strlen($nic) == 12) {

                if (!preg_match("/(\d{12})/", $nic)) {
                    $messages['error_nic_format'] = "The NIC New format is invalid..!";
                }
            }
        }

        //Check Mobile number already exists
        if (!empty($mobile)) {
            if (!preg_match('/((^(\+94|0)\d{2})-?\d{7}+$)/', $mobile)) {
                $messages['error_mobile'] = "The Mobile Number format is incorect or Mobile Number length is incorrect..!";
            } else {
                $sql1 = "SELECT * FROM tbl_employees WHERE mobile='$mobile' AND employeeid!='$employeeid' AND deletestatus='1'";
                $db = dbConn();
                $result1 = $db->query($sql1);
                if ($result1->num_rows > 0) {
                    $messages['error_mobile'] = "This Mobile number already exists...!";
                }
            }
        }
        
         if (!empty($fname)) {
            if (!preg_match('/^[a-z ]+$/i', $fname)) {
                $messages['error_fname'] = "FirstName is allowed letters and white spaces only.";
            }
        }

        if (!empty($lname)) {
            if (!preg_match('/^[a-z ]+$/i', $lname)) {
                $messages['error_lname'] = "LastName is allowed letters and white spaces only.";
            }
        }
        
        
        
        
        


        if (empty($messages) && !empty($_FILES['image']['name'])) {

            $image = $_FILES['image'];
            $file_name = $image['name'];
            $file_tmp = $image['tmp_name'];
            $file_size = $image['size'];
            $file_error = $image['error'];

            //workout the file extension
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));
            //allow file types
            $allowed = array('txt', 'pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'gif');
            //check if the file is allowed

            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= 2097152) {
                        $file_name_new = uniqid('', true) . '.' . $file_ext;
                        //file destination
                        $file_destination = 'images/' . $file_name_new;
                        //move the file
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            unlink('images/' . $previousname);
                        } else {
                            $messages['error_file'] = "There was an error uploading the file.";
                        }
                    } else {
                        $messages['error_file'] = "File size is invalid";
                    }
                } else {
                    $messages['error_file'] = "File has error";
                }
            } else {
                $messages['error_file'] = "Invalid file type";
            }
        } else {
            $file_name_new = $previousname;
        }

        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];
            $_SESSION['employeefullname'] = $fname . " " . $lname;
            $_SESSION['updatedate'] = $updatedate;

            $_SESSION['employeejobrole'] = $jobrole;

            $sql2 = "UPDATE tbl_employees SET firstname='$fname',lastname='$lname',nic='$nic',email='$email',address1='$address1',address2='$address2',city='$city',mobile='$mobile',designation='$jobrole',image='$file_name_new',updateuser='$updateuser',updatedate='$updatedate' WHERE employeeid='$employeeid'";
            $db = dbConn();
            $db->query($sql2);
            header("Location:employee_updsuccess.php");
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <div class="card px-md-4 mb-2 bg-transparent">
            <div class="row">
                <div class="col-md-6">   
                    <input type="hidden" name="employeeid" value='<?php echo @$employeeid ?>'">
                    <legend>Personal Details:</legend>
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="text" name="fname" value='<?php echo @$fname ?>' class="form-control form-control-sm" id="fname">
                        <div class="text-danger"><?php echo @$messages['error_fname']; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" name="lname" value='<?php echo @$lname ?>' class="form-control form-control-sm" id="lname">
                        <div class="text-danger"><?php echo @$messages['error_lname']; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="nic" class="form-label">NIC:</label>
                        <input type="text" name="nic" value='<?php echo @$nic ?>' class="form-control form-control-sm" id="nic">
                        <div class="text-danger"><?php echo @$messages['error_nic']; ?></div>
                        <div class="text-danger"><?php echo @$messages['error_nic_length']; ?></div>
                        <div class="text-danger"><?php echo @$messages['error_nic_format']; ?></div>
                    </div>

                    <div class="mb-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT jobroleid,jobrolename FROM tbl_jobroles WHERE jobrolename!='admin' AND deletestatus='1'";
                        $result = $db->query($sql);
                        ?>
                        <label class="form-label">Select a Designation :</label>
                        <select class="form-select border-dark" name="jobrole" id="jobrole" value="<?php echo @$jobrole; ?>">
                            <option value="">--</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>

                                    <option value="<?php echo $row['jobrolename']; ?>" <?php if (@$jobrole == $row['jobrolename']) { ?> selected <?php } ?>><?php echo ucfirst($row['jobrolename']); ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="text-danger"><?php echo @$messages['error_jobrole']; ?></div>
                    </div>`

                    <div class="mb-3">

                        <img class="img-fluid" src="<?= SYSTEM_PATH ?>employees/images/<?= !empty($image) ? $image : 'noimage.jpeg' ?>">

                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Employee Image</label>
                        <input class="form-control" type="file" id="image" name="image">
                        <input class="form-control" type="hidden" id="productimage" value="<?= @$image ?>" name="previousname">
                        <div class="text-danger"><?php echo @$messages['error_file']; ?></div>

                    </div>
                </div>

                <div class="col-md-6">


                    <legend>Contact Details</legend>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile No:</label>
                        <input type="tel" name="mobile" class="form-control form-control-sm" value="<?php echo @$mobile ?>" id="mobile">
                        <div class="text-danger"><?php echo @$messages['error_mobile']; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="address1" class="form-label">Address 1:</label>
                        <textarea name="address1" class="form-control form-control-sm" id="address1"><?php echo @$address1 ?></textarea>
                        <span id="address">Ex-House name/number and street, P.O box</span>
                        <div class="text-danger"><?php echo @$messages['error_address']; ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="address2" class="form-label">Address 2:(optional)</label>
                        <textarea name="address2" class="form-control form-control-sm" id="address2"><?php echo @$address2 ?></textarea>
                        <span id="address1">Ex-Apartment,Building,Floor</span>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City:</label>
                        <input type="text" name="city" class="form-control form-control-sm" value="<?php echo @$city ?>" id="city">
                        <span id="city">Ex-Village,City</span>
                        <div class="text-danger"><?php echo @$messages['error_city']; ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" name="email" class="form-control form-control-sm" value='<?php echo @$email ?>' id="email">
                        <div class="text-danger"><?php echo @$messages['error_email']; ?></div>
                    </div>
                </div>
            </div> 
        </div>    










        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>employees/addemployee.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>