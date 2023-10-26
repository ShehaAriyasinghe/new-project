<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add New Supplier</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>suppliers/supplier.php" class="btn btn-sm btn-outline-secondary">View Suppliers</a>
                
            </div>
            
        </div>
    </div>
    <?php
    //Extract inputs
    extract($_POST);

    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operate == "submit") {

        //create format of phone numbers
        $mobilenum="+94".$mobile;
      
        
        
        //Data clean
        $cname = cleanInput($cname);
        $fname = cleanInput($fname);
        $lname = cleanInput($lname);
        
        $mobilenum = cleanInput($mobilenum);
        $email = cleanInput($email);
        $address = cleanInput($address);

        $creditlimit = cleanInput($creditlimit);
        $bname = cleanInput($bname);
        $accountname = cleanInput($accountname);
        $accountno = cleanInput($accountno);

        //Create array
        $messages = array();

        //required validation
        if (empty($cname)) {
            $messages['error_cname'] = "The Company Name should not be empty...!";
        }
        if (empty($fname)) {
            $messages['error_fname'] = "The First Name should not be empty...!";
        }

        if (empty($lname)) {
            $messages['error_lname'] = "The Last Name should not be empty...!";
        }

        if (empty($mobile)) {
            $messages['error_mobile'] = "The Mobile should not be empty...!";
        }
        if (empty($email)) {
            $messages['error_email'] = "The Email should not be empty...!";
        }
        if (empty($address)) {
            $messages['error_address'] = "The Address should not be empty...!";
        }

        if (empty($creditlimit)) {
            $messages['error_creditlimit'] = "The Credit Limit should not be empty...!";
        }
        if (empty($bname)) {
            $messages['error_bname'] = "The Bank Name should not be empty...!";
        }
        if (empty($accountname)) {
            $messages['error_accountname'] = "The Account Holder Name should not be empty...!";
        }
        if (empty($accountno)) {
            $messages['error_accountno'] = "The Account No should not be empty...!";
        }


          if(empty($_SESSION['items'])){
             $messages['error_items'] = "Item should not empty...!.";
        }

        //advanced validaion

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $messages['error_email'] = "The Email is invalid..!";
            } else {

                $sql = "SELECT * FROM tbl_suppliers WHERE email='$email'";
                $db = dbConn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_email'] = "This email already exists...!";
                }
            }
        }


        

        if (!empty($mobile)) {
            if (!preg_match('/((^(\+94)\d{2})[-]\d{7}+$)/', $mobilenum)) {
                $messages['error_mobile'] = "The Mobile Number format is incorect or Mobile Number length is incorrect";
            } else {
                $sql1 = "SELECT * FROM tbl_suppliers WHERE mobile='$mobilenum'";
                $db = dbConn();
                $result1 = $db->query($sql1);
                if ($result1->num_rows > 0) {
                    $messages['error_mobile'] = "This Mobile number already exists...!";
                }
            }
        }


       
        
        if (!empty($creditlimit)) {
            if (!preg_match('/^[0-9 . ]+$/i', $creditlimit)) {
                $messages['error_creditlimit'] = "Invalid Credit Format..!";
            }
        }
        
        
        
        
        


        if (!empty($cname)) {
            $sql1 = "SELECT * FROM tbl_suppliers WHERE companyname='$cname'";
            $db = dbConn();
            $result1 = $db->query($sql1);
            if ($result1->num_rows > 0) {
                $messages['error_cname'] = "The Company Name already exsist...!";
            }
        }

        if (!empty($accountno)) {


            if (!preg_match('/^[-0-9]+$/i', $accountno)) {
                $messages['error_accountno'] = "Account Number format is invalid..!";
            } else {


                $sql2 = "SELECT * FROM tbl_suppliers WHERE bankaccountno='$accountno'";
                $db = dbConn();
                $result2 = $db->query($sql2);
                if ($result2->num_rows > 0) {
                    $messages['error_accountno'] = "The Account No already exsist...!";
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

        if (!empty($cname)) {
            if (!preg_match('/^[a-z () ]+$/i', $cname)) {
                $messages['error_cname'] = "Company Name is allowed letters and white spaces only.";
            }
        }



        //check validation is completed

        if (empty($messages)) {
            //call to the db connection
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "INSERT INTO tbl_suppliers(companyname,firstname,lastname,mobile,email,address,creditlimit,bankname,accountname,bankaccountno,supplieradddate,adduser) VALUES('$cname','$fname','$lname','$mobilenum','$email','$address','$creditlimit','$bname','$accountname','$accountno','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);
            $lastid = $db->insert_id;

            if (isset($_SESSION['items'])) {
                foreach ($_SESSION['items'] as $key => $value) {


                    $sql = "INSERT INTO tbl_itemsofsupplier(supplierid,catalogid,adddate,adduser) VALUES('$lastid','$key','$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                    
                    unset($_SESSION['items']);
                }
            }

            showSuccMeg();
        }
    }



    $where = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$search == 'search') {
        extract($_POST);

        if (!empty($itemname)) {
            $where .= " c.itemname LIKE '$itemname%' AND";
        }

        if (!empty($subcategoryname)) {
            $where .= " sub.subcategoryname LIKE '$subcategoryname%' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.deletestatus='1' && c.catalogid='$itemid'";
        $db = dbConn();
        $result = $db->query($sql);

        while ($rows = $result->fetch_assoc()) {

            $_SESSION['items'][$rows['catalogid']] = array('itemname' => $rows['itemname'], 'brandname' => $rows['brandname'], 'subcategoryname' => $rows['subcategoryname']);
        }
    }
    

    extract($_GET);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$operate == 'delete') {

        $items = $_SESSION['items'];
        unset($items[$catalogid]);
        $_SESSION['items'] = $items;
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row">
            <legend>Supplier Details:</legend>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="companyname" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="companyname" name="cname" value="<?= @$cname; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_cname']; ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="fname" value="<?= @$fname; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_fname']; ?></div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lname" value="<?php echo @$lname; ?>">
                    <div class="text-danger"><?php echo @$messages['error_lname']; ?></div>
                </div>
            </div>
            <legend>Contact Details:</legend>
            

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile No</label>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="mobile" name="code" value="<?php echo "+94"; ?>" readonly>
                          
                        </div>
                       
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo @$mobile; ?>">
                        </div>
                    </div>
                    <div class="text-danger"><?php echo @$messages['error_mobile']; ?></div>   
                    <span>Using format:+94 77-5004516</span>
                </div>`                
            </div>
             <div class="col-md-6">
             <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo @$email; ?>">
                    <div class="text-danger"><?php echo @$messages['error_email']; ?></div>
                </div>`
             </div>
            
            
            
            
            <div class="col-md-6">
            
                <div class="mb-3">
                    <label for="address" class="form-label">Company Address</label>
                    <textarea id="address" name="address" class="form-control"><?= @$address; ?></textarea>
                    <div class="text-danger"><?php echo @$messages['error_address']; ?></div>
                </div>`
            </div>
       
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="creditlimit" class="form-label">Credit Limit</label>
                    <input type="text" class="form-control" id="creditlimit" name="creditlimit" value="<?php echo @$creditlimit; ?>">
                    <div class="text-danger"><?php echo @$messages['error_creditlimit']; ?></div>
                </div>`
            </div>
            <legend>Bank Details:</legend>
            <div class="col-md-4">

                <div class="mb-3">
                    <label for="bname" class="form-label">Bank Name</label>
                    <input type="text" class="form-control" id="bname" name="bname" value="<?php echo @$bname; ?>">
                    <div class="text-danger"><?php echo @$messages['error_bname']; ?></div>
                </div>`
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="accountname" class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control" id="accountname" name="accountname" value="<?php echo @$accountname; ?>">
                    <div class="text-danger"><?php echo @$messages['error_accountname']; ?></div>
                </div>`
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="accountno" class="form-label">Bank Account No</label>
                    <input type="text" class="form-control" id="accountno" name="accountno" value="<?php echo @$accountno; ?>">
                    <div class="text-danger"><?php echo @$messages['error_accountno']; ?></div>
                </div>`
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 mb-5">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" name="itemname" placeholder="Item name" value="<?= @$itemname; ?>">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="subcategoryname" placeholder="subcategory" value="<?= @$subcategoryname; ?>">
                    </div>
                    <div class="col">
                        <button type="submit" name="search" value="search" class="btn btn-primary">Search</button>
                    </div>    

                </div>


                <?php
                $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.deletestatus='1' $where";
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <label class="form-label" for="item">Select items:</label>
                <select name="itemid" id="item" class="form-select border-dark" onchange="form.submit();">
                    <option>--</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?= $row['catalogid'] ?>"><?php echo $row['itemname'] . "-" . $row['brandname'] . "-" . $row['subcategoryname'] ?></option>



                    <?php } ?>
                </select>
                <div class="text-danger"><?php echo @$messages['error_items']; ?></div>


            </div>

            <div class="col-md-8">

                <?php
                if (isset($_SESSION['items'])) {
                    foreach ($_SESSION['items'] as $key => $value) {
                        ?>


                <input type="text"  class="form-control-sm w-75 mb-2" value="<?= $value['itemname'] . "-" . $value['brandname'] . "-" . $value['subcategoryname']; ?>" name="subservice" readonly>
                        <a href="addsupplier.php?catalogid=<?= @$key; ?>&operate=delete&cname=<?= @$cname ?>&fname=<?= @$fname ?>&lname=<?= @$lname ?>&telephone=<?php echo @$telephone ?>&mobile=<?php echo @$mobile ?>&email=<?= @$email ?>&address=<?= @$address ?>&creditlimit=<?= @$creditlimit ?>&bname=<?= @$bname ?>&accountname=<?= @$accountname ?>&accountno=<?= @$accountno ?>"><i class="bi bi-x-square"></i></a>


                        <?php
                    }
                }
                ?>

            </div>







        </div>   

        <button type="submit" name="operate" value="submit" class="btn btn-primary">Submit</button>
    </form>

</main>


<?php include '../footer.php'; ?>