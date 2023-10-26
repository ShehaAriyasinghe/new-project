<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Purchasing order</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-5">

                <a href="<?= SYSTEM_PATH; ?>inventory/purchaseorders.php" type="button" class="btn btn-sm btn-outline-secondary">View purchase orders</a>

            </div>

        </div>
    </div>

    <h5>Item purchasing Order</h5>


    <?php
    extract($_GET);
    extract($_POST);

    $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname,c.itemimage FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.catalogid='$catalogid' AND c.deletestatus='1' ";
    $db = dbconn();
    $result = $db->query($sql);
    $rows = $result->fetch_assoc();

    $itemname = $rows['itemname'];
    $brandname = $rows['brandname'];
    $subcategoryname = $rows['subcategoryname'];
    $itemimage = $rows['itemimage'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (empty($itemqty)) {
            $messages['error_qty'] = "Item Qty should not be empty...!";
        }

        if (!empty($itemqty)) {
            if (!preg_match('/^[0-9 ]+$/i', $itemqty)) {
                $messages['error_qty'] = "Quntity is allowed numbers only.";
            }
        }



        if (empty($bprice)) {
            $messages['error_bprice'] = "Buying price should not be empty...!";
        }

        if (empty($messages)) {

            if (!empty($itemqty) && !empty($supplierid) && !empty($bprice)) {

                $sql = "SELECT creditlimit,supplierid FROM tbl_suppliers WHERE supplierid='$supplierid' AND deletestatus=1";
                $db = dbConn();
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                $creditlimit = $row['creditlimit'];

                $totalprice = $bprice * $itemqty;

                $remainbalance = $creditlimit - $totalprice;

                if ($creditlimit < $totalprice) {

                    $messages['error_limit'] = "Credit limit is exceeded...!";
                }
            }
        }
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operation == 'submit') {

        if (empty($supplierid)) {
            $messages['error_supplier'] = "Supplier should not be empty...!";
        }

        if (empty($totalprice)) {
            $messages['error_total'] = "Total price should not be empty...!";
        }




        if (!empty($bprice)) {
            if (!preg_match('/^[0-9 . ]+$/i', $bprice)) {
                $messages['error_bprice'] = "Buy price is allowed numbers only.";
            }
        }


        if (!empty($itemqty)) {
            if (!preg_match('/^[0-9 ]+$/i', $itemqty)) {
                $messages['error_qty'] = "Quntity is allowed numbers only.";
            }
        }







        if (empty($messages)) {

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            $sql = "INSERT INTO tbl_purchaseorder(catalogid,supplierid,buyingprice,quntity,pendingpayment,adddate,adduser) VALUES('$catalogid','$supplierid','$bprice','$itemqty','$totalprice','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);

            $sql1 = "UPDATE tbl_suppliers SET creditlimit=creditlimit - '" . $totalprice . "'  WHERE supplierid='$supplierid'";
            $result = $db->query($sql1);

            showSuccMeg();
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">


        <input type="hidden" name="catalogid" value="<?= $catalogid ?>">



        <div class="row">


            <legend>Item Details:</legend>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="itemname" class="form-label">Item name</label>
                    <input type="text" class="form-control" id="itemname" name="itemname" value="<?= @$itemname; ?>" readonly>

                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <img src="<?= SYSTEM_PATH ?>inventory/images/<?= $itemimage ?>" width="150" height="150" alt="alt"/>


                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

                <label for="" class="form-label">Brand name</label>
                <input type="text" class="form-control" id="brandname" name="brandname" value="<?= @$brandname; ?>" readonly>


            </div>



            <div class="col-md-6">

                <label for="subcategoryname" class="form-label">Sub category name</label>
                <input type="text" class="form-control" id="subcategoryname" name="subcategoryname" value="<?= @$subcategoryname; ?>" readonly>

            </div>
        </div>
        <div class="row">



            <?php
            $sql1 = "select buyingprice from tbl_itemprice WHERE deletestatus='1' AND catalogid='$catalogid'";
            $result = $db->query($sql1);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $bprice = $row['buyingprice'];
                ?>

                <div class="col-md-6">
                    <label for="" class="form-label">Buying price:</label>
                    <input type="text" class="form-control" id="" name="bprice" value="<?= @$bprice; ?>" readonly>     
                </div>
                <div class="text-danger"><?php echo @$messages['error_bprice']; ?></div>

                <?php
            } else {
                echo"<div class='alert alert-danger mt-2 mb-2'>Please enter the buying price first</div>";
            }
            ?>    


            <div class="col-md-6">
                <label for="" class="form-label">Item Qty:</label>
                <input type="number" class="form-control" id="itemqty" name="itemqty" value="<?= @$itemqty; ?>">
                <div class="text-danger"><?php echo @$messages['error_qty']; ?></div>
            </div>
        </div>    

        <div class="row">
            <div class="col-md-6">

                <div class="input-group-md mb-3 mt-3">
                    <?php
                    $sql = "SELECT s.companyname,s.supplierid FROM tbl_itemsofsupplier ios INNER JOIN tbl_suppliers s ON s.supplierid=ios.supplierid INNER JOIN tbl_itemcatalog c ON c.catalogid=ios.catalogid WHERE ios.catalogid='$catalogid' AND s.deletestatus=1;";
                    $db = dbConn();
                    $result = $db->query($sql);
                    ?>
                    <label class="form-label">Select a Supplier  :</label>
                    <select class="form-select w-75 border-dark" name="supplierid" id="supplierid" onchange="form.submit()">
                        <option value="">--</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $row['supplierid']; ?>" <?php if (@$supplierid == $row['supplierid']) { ?> selected <?php } ?>><?php echo ucfirst($row['companyname']); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php echo @$messages['error_supplier']; ?></div>

                </div>

            </div>` 

            <legend>Total credit limit:</legend>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Available Credit :</label>
                    <input type="text" class="form-control" name="creditlimit" value="<?= @$creditlimit ?>" readonly>
                </div>

                <div class="mb-3">
                    <?php ?>
                    <label>Order total :</label>

                    <input type="text" class="form-control" name="totalprice" value="<?= @$totalprice ?>"readonly>
                    <div class="text-danger"><?php echo @$messages['error_total']; ?></div>
                </div>

                <div class="mb-3">
                    <?php ?>

                    <label>Remaining balance amount :</label>
                    <input type="text" class="form-control" name="remainbalance" value="<?php echo @$remainbalance > 0 ? $remainbalance : 0 ?>"readonly>
                </div>






                <div class="text-danger"><?php echo @$messages['error_limit']; ?></div>

            </div>



        </div>    


        <div class="row justify-content-left">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary" name="operation" value="submit">Submit</button>
            </div>

        </div>    


    </form>.


</main>
<?php include '../footer.php'; ?>