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
    extract($_GET);
    $sql = "SELECT * FROM tbl_suppliers WHERE deletestatus='1' && supplierid='$supplierid'";
    $db = dbConn();
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $supplierid = $row['supplierid'];
    $cname = $row['companyname'];
    $fname = $row['firstname'];
    $lname = $row['lastname'];

    
    $mobile = $row['mobile'];
    $email = $row['email'];

    $address = $row['address'];
    $creditlimit = $row['creditlimit'];
    $bname = $row['bankname'];

    $accountname = $row['accountname'];
    $accountno = $row['bankaccountno'];

    $sql = "SELECT catalogid FROM tbl_itemsofsupplier WHERE supplierid='$supplierid' && deletestatus=1";
    $db = dbConn();
    $results = $db->query($sql);

    while ($rows = $results->fetch_assoc()) {
        $catalogid = $rows['catalogid'];

        $sql = "SELECT c.catalogid,c.itemname,c.itemimage,b.brandname,sub.subcategoryname FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.deletestatus='1' && c.catalogid='$catalogid'";
        $db = dbConn();
        $result = $db->query($sql);

        while ($rowcatalog = $result->fetch_assoc()) {

            $_SESSION['items'][$rowcatalog['catalogid']] = array('itemname' => $rowcatalog['itemname'], 'brandname' => $rowcatalog['brandname'], 'subcategoryname' => $rowcatalog['subcategoryname'],'image' => $rowcatalog['itemimage']);
        }
    }
    ?>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row">
            <legend>Supplier Details:</legend>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="companyname" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="companyname" name="cname" value="<?= @$cname; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_cname']; ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="fname" value="<?= @$fname; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_fname']; ?></div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lname" value="<?php echo @$lname; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_lname']; ?></div>
                </div>
            </div>
            <legend>Contact Details:</legend>
           

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile No</label>
                    <div class="row">


                        <div class="col-md-4">
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo @$mobile; ?>" readonly>
                        </div>
                    </div>
                    <div class="text-danger"><?php echo @$messages['error_mobile']; ?></div>   

                </div>`                
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo @$email; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_email']; ?></div>
                </div>`
            </div>




            <div class="col-md-6">

                <div class="mb-3">
                    <label for="address" class="form-label">Company Address</label>
                    <textarea id="address" name="address" class="form-control" readonly><?= @$address; ?></textarea>
                    <div class="text-danger"><?php echo @$messages['error_address']; ?></div>
                </div>`
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="creditlimit" class="form-label">Credit Limit</label>
                    <input type="text" class="form-control" id="creditlimit" name="creditlimit" value="<?php echo @$creditlimit; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_creditlimit']; ?></div>
                </div>`
            </div>
            <legend>Bank Details:</legend>
            <div class="col-md-4">

                <div class="mb-3">
                    <label for="bname" class="form-label">Bank Name</label>
                    <input type="text" class="form-control" id="bname" name="bname" value="<?php echo @$bname; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_bname']; ?></div>
                </div>`
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="accountname" class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control" id="accountname" name="accountname" value="<?php echo @$accountname; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_accountname']; ?></div>
                </div>`
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="accountno" class="form-label">Bank Account No</label>
                    <input type="text" class="form-control" id="accountno" name="accountno" value="<?php echo @$accountno; ?> " readonly>
                    <div class="text-danger"><?php echo @$messages['error_accountno']; ?></div>
                </div>`
            </div>

        </div>
        <div class="row">

            <table>
                <thead>
                <th>Item Name</th>                               
                <th>Brand Name</th>
                <th>Sub category Name</th>
                <th>Image</th>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['items'])) {
                    foreach ($_SESSION['items'] as $key => $value) {
                        ?>
                   <tr>
                        
                       <td> 
                          <?= $value['itemname']; ?>
                       </td>
                      
                       <td>
                            <?= $value['brandname']; ?> 
                       </td>
                      <td>
                            <?= $value['subcategoryname']; ?>
                      </td>
                      
                       <td>
                           
                           <img class="img-fluid" width="100" height="100" src="<?= SYSTEM_PATH ?>inventory/images/<?= $value['image']; ?>">
                           
                      </td>
                      
                      
                   </tr>
                        <?php
                    }
                }
                ?>
    </tbody>
            </table>







        </div>   

       
    </form>

</main>


<?php include '../footer.php'; ?>