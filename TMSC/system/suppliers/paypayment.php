<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Supplier Payments</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            </div>

        </div>
    </div>




    <?php
    extract($_GET);
    extract($_POST);
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

    $sql1 = "SELECT * FROM tbl_stationdetails";
    $db = dbConn();
    $result1 = $db->query($sql1);
    $row1 = $result1->fetch_assoc();

    $stationname = $row1['name'];
    $stationaddress = $row1['address'];
    $stationemail = $row1['email'];

    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$opration == 'pay') {


        if (empty($payamount)) {
            $messages['error_payment'] = "Payment should not be empty...!";
        }


        if (empty($method)) {
            $messages['error_method'] = "Payment method should not be empty...!";
        }


        if ($payamount == '0') {
            $messages['error_payment'] = "Payment should not be Zero...!";
        }
        
         if ($payamount < 1) {
            $messages['error_payment'] = "Payment should not less than Rs.1";
        }
        
        

        if (!empty($payamount)) {
            if (!preg_match('/^[0-9 . ]+$/i', $payamount)) {
                $messages['error_payment'] = "Total Payments is allowed numbers only.";
            }
        }


        if ($payamount > $totalamount) {
            $messages['error_total'] = "Pay payment should be less than or equal to total amount.";
        }



        if (empty($messages)) {


            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            $sql1 = "INSERT INTO tbl_supplierpayments(supplierid,purchaseorderid,totalpayment,method,adddate,adduser) VALUES('$supplierid','$purchaseorderid','$payamount','$method','$adddate','$adduser')";
            $db->query($sql1);

            $sql3 = "UPDATE tbl_suppliers SET creditlimit=creditlimit + '" . $payamount . "'  WHERE supplierid='$supplierid'";
            $result = $db->query($sql3);

            if ($payamount == $totalamount) {
                $adddate = date('Y-m-d');
                $sql2 = "UPDATE tbl_purchaseorder SET payment='done',paymentdate='$adddate',pendingpayment='0'  WHERE purchaseorderid='$purchaseorderid'";
                $result = $db->query($sql2);
            }


            if ($payamount < $totalamount) {

                $arrears = $totalamount - $payamount;
                $adddate = date('Y-m-d');

                $sql2 = "UPDATE tbl_purchaseorder SET payment='pending',paymentdate='$adddate',pendingpayment='$arrears'  WHERE purchaseorderid='$purchaseorderid'";
                $result = $db->query($sql2);
            }







            showSuccMeg();
        }
    }
    ?>


    <div class="row">

        <div class="col-md-4">

            <div class="mb-3">
                <h6>FROM:</h6>
                <h6 class="display-7"><?= $stationname; ?></h6>

                <p><?php echo $stationaddress; ?></p>

                <p><?php echo $stationemail; ?></p>

            </div>



            <div class="mb-3">
                <h6>TO:</h6>
                <h6 class="display-7"><?= $cname; ?></h6>
                <p><?php echo $fname . " " . $lname; ?></p>
                <p><?php echo $address; ?></p>

                <p><?php echo $email; ?></p>

            </div>
        </div>
        <div class="col-md-4">
        </div>    

        <div class="col-md-4">
            <?php echo date("l jS \of F Y") ?>



        </div>


    </div>

    <div class='row'>
        <div class='col-md-8 mb-2 mt-2'>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">


                <div class="col-sm">
                    <label>Payment method:</label>
                    <select name="method" class='form-select-sm' onchange="form.submit()">

                        <option value="<?php echo @$method; ?>"><?php echo @$method; ?></option>

                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="deposit">Deposit</option>


                    </select>
                </div>
                <div class="text-danger"><?php echo @$messages['error_method']; ?></div>



                <input type="hidden" name="supplierid" value="<?= @$supplierid ?>" >
                <input type="hidden" name="purchaseorderid" value="<?= @$purchaseorderid ?>" >


            </form>
        </div>
        <div class='col-md-4'>
            <?php
            if (@$method == 'deposit') {
                ?>


                <h6>Bank Details:</h6>
                <p><?= $bname ?>

                <p><?php echo $accountname ?></p>
                <p><?php echo $accountno ?></p>





                <?php
            }
            ?>

        </div>




    </div>






    <?php
    extract($_GET);
    $db = dbconn();
    $sql = "SELECT p.buyingprice,p.quntity,p.adddate,s.companyname,s.creditlimit,p.supplierid,c.itemname,p.pendingpayment FROM tbl_purchaseorder p LEFT JOIN tbl_suppliers s ON s.supplierid=p.supplierid INNER JOIN tbl_itemcatalog c ON c.catalogid=p.catalogid WHERE p.deletestatus='1' AND payment='pending' AND p.purchaseorderid='$purchaseorderid'";
    $result = $db->query($sql);
    ?>    



    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Date</th>

                    <th>Item Name</th>
                    <th>Buying Price</th>
                    <th>Quantity</th>
                    <th>Order Total</th>
                    <th>Pending payment</th>



                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>

                <?php
                $totalamount = 0;
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                        <tr>


                            <td><?php echo $rows['adddate']; ?></td>

                            <td><?php echo $rows['itemname']; ?></td>
                            <td><?php echo $rows['buyingprice']; ?></td>

                            <td><?php echo $rows['quntity']; ?></td>

                            <td><?php echo $total = $rows['quntity'] * $rows['buyingprice'] ?></td>

                            <td><?php echo $pending = $rows['pendingpayment']; ?></td>



                            <?php
                            $companyname = $rows['companyname'];

                            $totalamount += $pending;
                            ?>

                        </tr>

                        <?php
                    }
                    echo $companyname;
                }
                ?>
                <tr>
                    <td colspan="2">Total due payment (Rs:)</td>

                    <td> <?php echo number_format($totalamount, 2) ?></td>

                </tr>
            </tbody>
        </table>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class='row'>
            <div class='col-md-4'>
                <label class="form-label-sm">Payment Rs:</label>
                <input type="text" class="form-control-sm" name="payamount" value="<?= @$payamount ?>"> 
                <div class="text-danger"><?php echo @$messages['error_payment']; ?></div>
            </div>
            <div class='col-md-4'>
                <label class="form-label-sm">Total Amount Rs:</label>
                <input type="text" class="form-control-sm" name="totalamount" value="<?= @$totalamount ?>" readonly> 
                <div class="text-danger"><?php echo @$messages['error_total']; ?></div>

            </div>
        </div>    
        <input type="hidden" name="supplierid" value="<?= @$supplierid ?>" >
        <input type="hidden" name="purchaseorderid" value="<?= @$purchaseorderid ?>" >
        <input type="hidden" name="method" value="<?= @$method ?>" >

        <input type="submit" name="opration" class="btn btn-primary md-2" value="pay">  

    </form>




</main>
<?php include '../footer.php'; ?>


