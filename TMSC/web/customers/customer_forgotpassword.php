
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<?php
include '../assets/phpmail/mail.php';
?>




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
                <div class="card  card-box px-2 my-card-bg mt-2" style="width: 50rem; ">
                    <div class="card-header text-center card-header">
                        <h2 class="display-6 fw-bolder text-white">Customer Forgot Password</h2>
                    </div>
                    <div class="card-body">


                        <?php
                        if (isset($_REQUEST['submit'])) {
                            extract($_POST);
                            $db = dbconn();
                            $sql = "SELECT customerid,lastname,email FROM tbl_customers WHERE email='$email'";
                            $result = $db->query($sql);
                            $count = mysqli_num_rows($result);
                            if ($count == 1) {
                                $row = $result->fetch_assoc();
                                $customerid = sha1($row['customerid']);
                                echo "Check your email address..!";
                                $body = "<h1>Tusitha service center</h1><br><a class='btn btn-primary' href='http://localhost:8080/tmsc/web/customers/customer_resetpassword.php?tokken=$customerid'>Click to reset password</a>";
                                $customer_email = $row['email'];
                                $customer = $row['lastname'];
                                $subject = "Reset password";
                                send_email($customer_email, $customer, $subject, $body, "Hello");
                            } else {
                                echo "Email address not found";
                            }
                        }
                        ?>

                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <label>Enter Your Email</label>
                            <input type="text" name="email" class="form-control"><br>
                            <input type="submit" class="btn btn-primary" value="send" name="submit">

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
