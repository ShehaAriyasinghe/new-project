<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<style>
    body {
        background-image: url('<?= WEB_PATH ?>assets/images/center20.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        
        
    }
</style>

    
            <div class="row mt-2">

                <div class="col-md-8">
                    

                </div>
                <div class="col-md-4 form-signin">

                    <div class="card bg-black">
                        <div class="card-body">
                            <img src="<?= WEB_PATH ?>assets/images/honda.png" class="card-img" width="250px" height="120px" alt="...">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
                            
                            
                            <h1 class="h3 mb-3 fw-normal text-white">Please sign in</h1>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                                extract($_POST);

                                //create errors array
                                $messages = array();

                                //required validation

                                if (empty($user_name)) {

                                    $messages['error_user_name'] = "The Email address should not be empty...!";
                                }

                                if (empty($password)) {

                                    $messages['error_password'] = "The Password should not be empty...!";
                                }

                                //advance validation

                                if (empty($messages)) {
                                    $db = dbconn();
                                    $password = sha1($password);
                                    $sql = "SELECT u.username,u.password,u.userid,u.userrole,c.customerid,c.title,c.firstname,c.lastname,c.email,u.userrole FROM tbl_users u INNER JOIN tbl_customers c ON u.userid=c.userid WHERE u.username='$user_name' AND u.password='$password' AND userrole='customer'";
                                    $result = $db->query($sql);
                                    if ($result->num_rows <= 0) {
                                        $messages['error_login'] = "Invalid Username or Password";
                                    } else {
                                        $row = $result->fetch_assoc();
                                        $_SESSION['customer_userid'] = $row['userid'];
                                        $_SESSION['customer_firstname'] = $row['firstname'];
                                        $_SESSION['customer_lastname'] = $row['lastname'];
                                        $_SESSION['customer_email'] = $row['email'];
                                        $_SESSION['customer_title'] = $row['title'];
                                        header("Location:../index.php");
                                    }
                                }
                            }
                            ?>
                            <div>
                                <p class="text-danger"><?php echo @$messages['error_user_name']; ?></p>
                                <p class="text-danger"><?php echo @$messages['error_password']; ?></p>
                                <p class="text-danger"><?php echo @$messages['error_login']; ?></p>
                            </div>
                            <div class="form-floating ">
                                <input type="email" class="form-control" name="user_name" id="user_name" value="<?php echo @$user_name ?>" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="checkbox mb-3">
<!--                                <a href="customer_forgotpassword.php" class="text-center text-primary">Forgot Password</a>-->
                            </div>
                            <button class=" btn btn-md card-btn mb-2" type="submit">Sign in</button>
                      
                        </form>
                    </div>
                    </div>
                </div>   
            </div>
       
<?php include '../footer.php'; ?>
