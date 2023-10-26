<?php
ob_start();
?>

<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php
//Extract inputs
extract($_GET);
extract($_POST);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update item stocks</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="itemstock.php?categoryid=<?= $categoryid ?>" class="btn btn-sm btn-outline-secondary">View All item stock</a>

            </div>

        </div>
    </div>
    <?php
    extract($_GET);

    $db = dbconn();
    $sql = "SELECT c.catalogid,b.brandname,c.itemname,c.itemimage,c.modelno,c.deletestatus FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid  WHERE c.catalogid='$catalogid' AND c.deletestatus='1'";
    $result = $db->query($sql);
    $rows = $result->fetch_assoc();
    $catalogid = $rows['catalogid'];
    $itemimage = $rows['itemimage'];
    $brandname = $rows['brandname'];
    $itemname = $rows['itemname'];
    $modelname = $rows['modelno'];

    $sqlst = "SELECT purchasedate,quntity,buyingprice,sellingprice,discount FROM tbl_itemstock WHERE itemstockid='$itemstockid' AND deletestatus='1'";
    $resultst = $db->query($sqlst);
    $row = $resultst->fetch_assoc();
    $purchasedate = $row['purchasedate'];
    $quntity = $row['quntity'];
    $bprice = $row['buyingprice'];
    $sprice = $row['sellingprice'];
    $discount = $row['discount'] * 100;

//Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Create array
        $messages = array();

        // empty validations
        if (empty($quntity)) {
            $messages['error_quntity'] = "The Quntity should not be empty..!";
        }

        if (empty($bprice)) {

            $messages['error_bprice'] = "The Buying price should not be empty...!";
        }

        if (empty($sprice)) {

            $messages['error_sprice'] = "The Selling price should not be empty...!";
        }

        if (empty($purchasedate)) {

            $messages['error_date'] = "The Purchase Date should not be empty...!";
        }



        if (!empty($quntity)) {


            if (!preg_match('/^[0-9]+$/i', $quntity)) {
                $messages['error_quntity'] = "Quntity is allowed numbers only.";
            }
        }


        if (!empty($bprice)) {


            if (!preg_match('/^[0-9 .]+$/i', $bprice)) {
                $messages['error_bprice'] = "The Buying price is allowed numbers only.";
            }
        }

        if (!empty($sprice)) {


            if (!preg_match('/^[0-9 .]+$/i', $sprice)) {
                $messages['error_sprice'] = "The Selling price is allowed numbers only.";
            }
        }

        if (!empty($discount)) {


            if (!preg_match('/^[0-9 .]+$/i', $discount)) {
                $messages['error_discount'] = "The Discount is allowed numbers only.";
            }
        }




        //check validation is completed
        if (empty($messages)) {
            
            if(!empty($discount)){
            // calculate discount
            $discount = $discount / 100;
            }else{
                $discount=0;
            }

            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];
            $sqlupd = "UPDATE tbl_itemstock SET purchasedate='$purchasedate',quntity='$quntity',buyingprice='$bprice',sellingprice='$sprice',discount='$discount',updatedate='$updatedate',updateuser='$updateuser' WHERE itemstockid='$itemstockid'";
            $db = dbConn();
            $db->query($sqlupd);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="catalogid" value="<?= @$catalogid ?>" >
        <input type="hidden" name="itemstockid" value="<?= @$itemstockid ?>" >
        <input type="hidden" name="categoryid" value="<?= @$categoryid ?>" >

        <div class="mb-3">
            <img class="img-fluid w-25 h-25" src="<?= SYSTEM_PATH ?>inventory/images/<?= $itemimage ?>">
            <input type="hidden" name="itemimage" value="<?= $itemimage ?>" >
        </div>
        <div class="row">
            <div class="col-md-6">
                <legend>Item Details</legend>
                <div class="mb-3">
                    <label for="Brandname" class="form-label">Brand Name</label>
                    <input type="text" class="form-control w-75" id="brandname" name="brandname" value="<?= @$brandname ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_brand']; ?></div>
                </div>


                <div class="mb-3">
                    <label for="itemname" class="form-label">Item Name</label>
                    <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$itemname ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_item']; ?></div>
                </div>

                <div class="mb-3">
                    <label for="modelname" class="form-label">Model</label>
                    <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$modelname ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['modelname']; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <legend>Catalog Details</legend>
                <div class="mb-3">
                    <label for="" class="form-label">Received date</label>
                    <input type="date" class="form-control w-75" id="purchasedate" name="purchasedate" value="<?= @$purchasedate ?>" >
                    <div class="text-danger"><?php echo @$messages['error_date']; ?></div>
                </div>



                <div class="mb-3">
                    <label for="" class="form-label">Number of quntity</label>
                    <input type="number" class="form-control w-75" id="quntity" name="quntity" value="<?= @$quntity; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_quntity']; ?></div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label">Buying price(Rs.)</label>
                    <input type="text" class="form-control w-75" id="bprice" name="bprice" value="<?= @$bprice; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_bprice']; ?></div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Selling price(Rs.)</label>
                    <input type="text" class="form-control w-75" id="sprice" name="sprice" value="<?= @$sprice; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_sprice']; ?></div>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Discount</label>
                    <input type="text" class="form-control w-75" id="discount" name="discount" value="<?= @$discount; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_discount']; ?></div>
                </div>
            </div>
        </div>



        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/viewitemstock.php?categoryid=<?= $categoryid ?>&catalogid=<?= $catalogid ?>" class="btn btn-outline-primary ">Back</a>
            </div>
        </div>

    </form>

</main>    


<?php
ob_flush();
?>

<?php include '../footer.php'; ?>

