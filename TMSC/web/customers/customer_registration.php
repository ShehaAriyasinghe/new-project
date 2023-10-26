
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<style>
    main {
        background-image: url('<?= SYSTEM_PATH; ?>assets/images/center14.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }
</style>





<main>




    <div class="card my-card-bg card-box px-5" mt-4>
        <div class="card-header text-center card-header">
            <h2 class="display-6 fw-bolder text-white">Customer Registration</h2>
        </div>

        <div class="card-body">


            <?php
            //Check submit
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                //Extract inputs
                extract($_POST);
                
                
                
                

                $mobile = "+94" . $mobilenum;

                //Data clean
                $fname = cleanInput($fname);
                $lname = cleanInput($lname);
                $nic = cleanInput($nic);
                $mobile = cleanInput($mobile);
                $address1 = cleanInput($address1);
                $address2 = cleanInput($address2);
                $city = cleanInput($city);
                $email = cleanInput($email);
                $password = cleanInput($password);
                $cpassword = cleanInput($cpassword);

                //Create array
                $messages = array();

                //required validation

                if (empty($title)) {

                    $messages['error_title'] = "The Title should not be empty...!";
                }


                if (empty($fname)) {

                    $messages['error_firstname'] = "The FistName should not be empty...!";
                }

                if (empty($lname)) {

                    $messages['error_lastname'] = "The LastName should not be empty...!";
                }

                if (empty($nic)) {

                    $messages['error_nic'] = "The NIC should not be empty...!";
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

                if (empty($password)) {

                    $messages['error_password'] = "The Password should not be empty...!";
                }
                if (empty($cpassword)) {

                    $messages['error_cpword'] = "The Confirm Password should not be empty...!";
                }


                if (empty($mobilenum)) {

                    $messages['error_mobile'] = "The Mobile should not be empty...!";
                }
                
                


                //advanced validaion

                if ($password !== $cpassword && !empty($cpassword) && !empty($password)) {
                    $messages['error_cpword'] = "The Confirm Password is not matched...!";
                }




                if (!empty($email)) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $messages['error_email'] = "The Email is invalid..!";
                    } else {

                        $sql = "SELECT * FROM tbl_customers WHERE email='$email'";
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $messages['error_email'] = "This email already exists...!";
                        }
                    }
                }

                if (!empty($nic)) {



                    if ($nic) {
                        $sql1 = "SELECT * FROM tbl_customers WHERE nic='$nic'";
                        $db = dbConn();
                        $result1 = $db->query($sql1);
                        if ($result1->num_rows > 0) {
                            $messages['error_nic'] = "This NIC already exists...!";
                        }
                    }


                    if (strlen($nic) != 10 && strlen($nic) != 12) {

                        $messages['error_nic'] = "The NIC length does not match..!";
                    }

                    if (strlen($nic) == 10) {

                        if (!preg_match("/V$/", $nic) || (!preg_match("/(^\d{9})/", $nic))) {
                            $messages['error_nic'] = "The NIC old format is invalid..!";
                        }
                    }

                    if (strlen($nic) == 12) {

                        if (!preg_match("/(\d{12})/", $nic)) {
                            $messages['error_nic'] = "The NIC New format is invalid..!";
                        }
                    }
                }


                //advance validation for password format

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


                if (!empty($mobilenum)) {
                     if (!preg_match('/((^(\+94)\d{2})[-]\d{7}+$)/', $mobile)) {
                        $messages['error_mobile'] = "The Mobile Number format is incorect or Mobile Number length is incorrect";
                    } else {
                        $sql1 = "SELECT * FROM tbl_customers WHERE mobile='$mobile'";
                        $db = dbConn();
                        $result1 = $db->query($sql1);
                        if ($result1->num_rows > 0) {
                            $messages['error_mobile'] = "This Mobile number already exists...!";
                        }
                    }
                }

                if (!empty($fname)) {
                    if (!preg_match('/^[a-z ]+$/i', $fname)) {
                        $messages['error_firstname'] = "FirstName is allowed letters and white spaces only.";
                    }
                }

                if (!empty($lname)) {
                    if (!preg_match('/^[a-z ]+$/i', $lname)) {
                        $messages['error_lastname'] = "LastName is allowed letters and white spaces only.";
                    }
                }
                
                
//                if (!empty($address1)) {
//                    if ($address1<1) {
//                        $messages['error_address'] = "Invalid format of address.";
//                    }
//                }
                
                
                if (!empty($city)) {
                    if (!preg_match('/^[a-z0-9 ]+$/i', $city)) {
                        $messages['error_city'] = "Allowed only letters and numbers..!";
                    }
                }




                //check validation is completed
                if (empty($messages)) {
                    //call to the db connection
                    $db = dbConn();
                    $adddate = date('Y-m-d');
                    $password = sha1($password);
                    $jobrole = "customer";
                    $accountstatus = "active";
                    $sql2 = "INSERT INTO tbl_users(username,password,userrole,accountstatus,adddate) VALUES('$email','$password','$jobrole','$accountstatus','$adddate')";
                    $db->query($sql2);
                    $userlastid = $db->insert_id;

                    // Create customer registration number


                    $regnumber = date('Y') . date('m') . date('d') . $userlastid;
                    $_SESSION['RegNumber'] = $regnumber;

                    $sql1 = "INSERT INTO tbl_customers(title,firstname,lastname,nic,mobile,address1,address2,city,email,regnumber,userid,adddate) VALUES('$title','$fname','$lname','$nic','$mobile','$address1','$address2','$city','$email','$regnumber','$userlastid','$adddate')";
                    $db->query($sql1);
                    header("Location:customer_regsuccess.php");
                }
            }
            ?>



            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <fieldset>
                            <legend>Personal Details:</legend>
                            <div class="mb-3">
                                <label>Title:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="title" id="title" value="Mr." <?php if (isset($title) && $title == 'Mr.') { ?> checked <?php } ?> >
                                    <label class="form-check-label" for="title">
                                        Mr.
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="title" id="title" value="Mrs." <?php if (isset($title) && $title == 'Mrs.') { ?> checked <?php } ?>>
                                    <label class="form-check-label" for="title">
                                        Mrs.
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="title" id="title" value="Miss." <?php if (isset($title) && $title == 'Miss.') { ?> checked <?php } ?>>
                                    <label class="form-check-label" for="title">
                                        Miss.
                                    </label>
                                </div>

                                <div class="text-danger"><?php echo @$messages['error_title']; ?></div>

                            </div>




                            <div class="mb-3 mt-3">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" name="fname" class="form-control form-control-sm" id="fname" value='<?php echo @$fname; ?>'>
                                <div class="text-danger"><?php echo @$messages['error_firstname']; ?></div>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" name="lname" class="form-control form-control-sm" id="lname" value='<?php echo @$lname; ?>'>
                                <div class="text-danger"><?php echo @$messages['error_lastname']; ?></div>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="nic" class="form-label">NIC:</label>
                                <input type="text" name="nic" class="form-control form-control-sm" id="nic" value='<?php echo @$nic; ?>'>
                                <div class="text-danger"><?php echo @$messages['error_nic']; ?></div>

                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset>
                            <legend>Contact Details:</legend>


                            <div class="mb-3 mt-3">
                                <label for="mobile" class="form-label">Mobile No:</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" name="" class="form-control-sm" id="mobile" value='<?php echo "+94"; ?>'>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="mobilenum" class="form-control-sm" id="mobile" value='<?php echo @$mobilenum; ?>'>
                                    </div>
                                </div>    
                                <div class="text-danger"><?php echo @$messages['error_mobile']; ?></div>
                                <span>Example format 77-5004156</span>
                            </div>




                            <div class="mb-3">
                                <label for="address1" class="form-label">Address 1:</label>
                                <textarea name="address1" class="form-control form-control-sm" id="address1"><?php echo @$address1 ?></textarea>
                                <span id="address">Ex-House name/number of P.O box</span>
                                <div class="text-danger"><?php echo @$messages['error_address']; ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="address2" class="form-label">Address 2:(optional)</label>
                                <textarea name="address2" class="form-control form-control-sm" id="address2"><?php echo @$address2 ?></textarea>
                                <span id="address1">Ex-Street name</span>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">City:</label>
                                <input type="text" name="city" class="form-control form-control-sm" value="<?php echo @$city ?>" id="city">
                                <span id="city">Ex-Village,City</span>
                                <div class="text-danger"><?php echo @$messages['error_city']; ?></div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset>
                            <legend>User Details:</legend>
                            <div class="mb-3 mt-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" name="email" class="form-control form-control-sm" id="email" value='<?php echo @$email; ?>'>
                                <div class="text-danger"><?php echo @$messages['error_email']; ?></div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="pword" class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control form-control-sm" id="pword">
                                <div class="text-danger"><?php echo @$messages['error_password']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_upper']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_lower']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_special']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_digit']; ?></div>
                                
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="cpword" class="form-label">Confirm Password:</label>
                                <input type="password" name="cpassword" class="form-control form-control-sm" id="cpword">
                                <div class="text-danger"><?php echo @$messages['error_cpword']; ?></div>
                            </div>  




                            <div class="row justify-content-around">
                                <div class="col-4">

                                    <button type="submit" class="btn card-btn">Submit</button>
                                </div>
                                <div class="col-4">
                                    <a href="<?= WEB_PATH; ?>customers/customer_registration.php" type="submit" class="btn card-btn">Reset</a>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>

        </div>

    </div>




</div>
</main>        
<?php include '../footer.php'; ?>