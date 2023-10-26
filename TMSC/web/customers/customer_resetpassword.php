

<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php


include '../assets/phpmail/mail.php';
?>


<!doctype html>

        <style>
            body {
                background-image: url('<?= SYSTEM_PATH; ?>assets/images/center20.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
    </head>

    <body>


        <div class="container">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-box px-2 my-card-bg mt-2" style="width: 50rem;">
                        <div class="card-header text-center card-header">
                            <h2 class="display-6 fw-bolder text-white">Customer Forgot Password</h2>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                                $tokken = $_GET['tokken'];
                                $qry = "SELECT customerid,email FROM tbl_customers WHERE sha1(customerid)='$tokken'";
                                $db = dbconn();
                                $result = $db->query($qry);
                                //get number of records and check number of records equal to 1
                                if ($result->num_rows == 1) {
                                    //if record 1 get customer id and email    
                                    $row = $result->fetch_assoc();
                                    $customerid = $row['customerid'];
                                    $email = $row['email'];
                                } else {
                                    //if record not equal 1 display not found message
                                    echo 'Not found..!';
                                }
                            }


                            //check form submit
                            extract($_POST);
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                

                                $password = cleanInput($password);
                                $cpassword = cleanInput($cpassword);

                                if (empty($password)) {

                                    $messages['error_password'] = "The Password should not be empty...!";
                                }
                                if (empty($cpassword)) {

                                    $messages['error_cpword'] = "The Confirm Password should not be empty...!";
                                }

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



                                if (empty($messages)) {

                                    $password = sha1($password);
                                    $updqry = "UPDATE tbl_users SET password='$password' WHERE username='$email'";
                                    $db = dbconn();
                                    $resupdate = $db->query($updqry);
                                    echo "Password is changed sucessfully..!";
                                }
                            }
                            ?>    
                           <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                               <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" value="<?= @$email; ?>">  <br> 

                                    <label class="form-label">password</label>
                                    <input type="password" name="password" class="form-control" ><br>
                                
                                <div class="text-danger"><?php echo @$messages['error_password']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_upper']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_lower']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_special']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_password_digit']; ?></div>
                                
                                
                                

                                <label class="form-label">Confirm password</label>
                                <input type="password" name="cpassword" class="form-control"><br>
                                  <div class="text-danger"><?php echo @$messages['error_cpword']; ?></div>
                                
                                
                                <input type="submit" name="submit" value="submit" class="btn btn-primary">
                                
                               

                                
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
