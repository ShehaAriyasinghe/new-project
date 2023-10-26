
<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer Dashboard</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
 <a href="<?= WEB_PATH; ?>customers/edit_customer.php" type="button" class="btn btn-sm btn-outline-secondary">Edit customer details</a>

            </div>

        </div>
    </div>

            <?php
            
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            $customeruserid=$_SESSION['customer_userid'];
            
            $sql = "SELECT * FROM tbl_customers WHERE userid='$customeruserid'";
            $db = dbConn();
            $result=$db->query($sql);
            $row=$result->fetch_assoc();
           

                $title = $row['title'];
                $fname = $row['firstname'];
                $lname = $row['lastname'];
                $nic = $row['nic'];
                $mobile = $row['mobile'];
                $address1 = $row['address1'];
                $address2 = $row['address2'];
                $city = $row['city'];
                $email = $row['email'];
                
            }
            ?>



            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row my-card-bg">
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

                               

                            </div>




                            <div class="mb-3 mt-3">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" name="fname" class="form-control form-control-sm" id="fname" value='<?php echo @$fname; ?>' readonly>
                                
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" name="lname" class="form-control form-control-sm" id="lname" value='<?php echo @$lname; ?>' readonly>
                                
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="nic" class="form-label">NIC:</label>
                                <input type="text" name="nic" class="form-control form-control-sm" id="nic" value='<?php echo @$nic; ?>' readonly>
                                
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset>
                            <legend>Contact Details:</legend>

                            <div class="mb-3 mt-3">
                                <label for="mobile" class="form-label">Mobile No:</label>
                                <input type="text" name="mobile" class="form-control form-control-sm" id="mobile" value='<?php echo @$mobile; ?>' readonly>
                               
                            </div>
                            <div class="mb-3">
                                <label for="address1" class="form-label">Address 1:</label>
                                <textarea name="address1" class="form-control form-control-sm" id="address1" readonly><?php echo @$address1 ?></textarea>
                                <span id="address">Ex-House name/number of P.O box</span>
                               
                            </div>
                            <div class="mb-3">
                                <label for="address2" class="form-label">Address 2:(optional)</label>
                                <textarea name="address2" class="form-control form-control-sm" id="address2" readonly><?php echo @$address2 ?></textarea>
                                <span id="address1">Ex-Street name</span>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">City:</label>
                                <input type="text" name="city" class="form-control form-control-sm" value="<?php echo @$city ?>" id="city" readonly>
                                <span id="city">Ex-Village,City</span>
                                
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset>
                            <legend>User Details:</legend>
                            <div class="mb-3 mt-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" name="email" class="form-control form-control-sm" id="email" value='<?php echo @$email; ?>' readonly>
                               
                            </div>

                            

                           



                        </fieldset>
                    </div>
                </div>
            </form>

        </div>

    </div>




</div>
</main>        
<?php include '../customerfooter.php'; ?>