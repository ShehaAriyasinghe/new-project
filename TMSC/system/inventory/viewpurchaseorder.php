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

    $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname,c.itemimage FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.catalogid='$catalogid' AND c.deletestatus='1' ";
    $db = dbconn();
    $result = $db->query($sql);
    $rows = $result->fetch_assoc();

    $itemname = $rows['itemname'];
    $brandname = $rows['brandname'];
    $subcategoryname = $rows['subcategoryname'];
    $itemimage = $rows['itemimage'];

    $sql1 = "SELECT catalogid,supplierid,buyingprice,sellingprice,quntity FROM tbl_purchaseorder WHERE purchaseorderid='$purchaseorderid' ";
    $db = dbConn();
    $result1 = $db->query($sql1);
    $row = $result1->fetch_assoc();

    $supplierid = $row['supplierid'];
    $bprice = $row['buyingprice'];
    $sprice = $row['sellingprice'];
    $itemqty = $row['quntity'];
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
            $sql1 = "select buyingprice from tbl_itemstock WHERE deletestatus='1' AND catalogid='$catalogid' ORDER BY catalogid DESC LIMIT 1";
            $result = $db->query($sql1);
            if ($result->num_rows < 0) {
                $row = $result->fetch_assoc();

                $previousbprice = $row['buyingprice'];
                ?>

                <div class="col-md-6">
                    <label for="" class="form-label">Previous Buying price:</label>
                    <input type="text" class="form-control" id="" name="previousbprice" value="<?= @$previousbprice; ?>" readonly>     
                </div>

                <?php
            }
            ?>    



            <div class="col-md-6">
                <label for="" class="form-label">Buying price:</label>
                <input type="text" class="form-control" id="" name="bprice" value="<?= @$bprice; ?>">  
                <div class="text-danger"><?php echo @$messages['error_bprice']; ?></div>
            </div>

            <div class="text-danger"><?php echo @$messages['error_price']; ?></div>

            <div class="col-md-6">
                <label for="" class="form-label">Selling price:</label>
                <input type="text" class="form-control" id="" name="sprice" value="<?= @$sprice; ?>">     
                <div class="text-danger"><?php echo @$messages['error_sprice']; ?></div>
            </div>



            <div class="col-md-6">
                <label for="" class="form-label">Item Qty:</label>
                <input type="number" class="form-control" id="itemqty" name="itemqty" value="<?= @$itemqty; ?>">
                <div class="text-danger"><?php echo @$messages['error_qty']; ?></div>
            </div>
        </div>    

        <div class="row">
            <div class="col-md-6 mt-4">
                <label>Supplier Details:</label>
                <?php
                $sql2 = "SELECT * FROM tbl_suppliers WHERE supplierid='$supplierid'";
                $db = dbConn();
                $result = $db->query($sql2);

                while ($row = $result->fetch_assoc()) {
                    $companyname = $row['companyname'];
                    $email = $row['email'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                }
                ?>
                <h6><?= $companyname ?></h6>
                <p><?php echo $firstname." ".$lastname ?></p>
                <p><?php echo $email ?></p>
            </div>
        </div>` 






    </form>.


</main>
<?php include '../footer.php'; ?>