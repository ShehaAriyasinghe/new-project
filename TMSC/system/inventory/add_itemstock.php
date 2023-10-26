<?php
ob_start();
?>

<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php
extract($_GET);
extract($_POST);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add item stocks</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="itemstock.php?categoryid=<?= $categoryid ?>" class="btn btn-sm btn-outline-secondary">View item stock</a>

            </div>

        </div>
    </div>
    <?php
    extract($_GET);

    $db = dbconn();
    $sql = "SELECT c.catalogid,b.brandname,c.itemname,c.itemimage,c.modelno,c.deletestatus FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid  WHERE c.catalogid='$catalogid' AND c.deletestatus='1'";
    $result = $db->query($sql);
    $rows = $result->fetch_assoc();

    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Create array
        $messages = array();

        // empty validations


        if (empty($purchasedate)) {

            $messages['error_purchasedate'] = "The Purchase date should not be empty...!";
        }

        if (empty($quantity)) {

            $messages['error_quantity'] = "The Item quantity should not be empty...!";
        }

        if (empty($bprice)) {

            $messages['error_bprice'] = "The Item buying price should not be empty...!";
        }

        if (empty($sprice)) {

            $messages['error_sprice'] = "The Item selling price should not be empty...!";
        }



        if (!empty($quantity)) {
            if (!preg_match('/^[0-9 ]+$/i', $quantity)) {
                $messages['error_quantity'] = "Quntity is allowed numbers only.";
            }
        }

        if (!empty($sprice)) {
            if (!preg_match('/^[0-9 . ]+$/i', $sprice)) {
                $messages['error_sprice'] = "Selling price is allowed numbers only.";
            }
        }

        if (!empty($bprice)) {
            if (!preg_match('/^[0-9 . ]+$/i', $bprice)) {
                $messages['error_bprice'] = "Buying price is allowed numbers only.";
            }
        }


       

        if ($bprice > $sprice) {

            $messages['error_sprice'] = "The Item selling price should not less than buying price...!";
        }




        //check validation is completed
        if (empty($messages)) {
            if (!empty($discount)) {
                // calculate discount
                $discount = $discount / 100;
            } else {
                $discount = 0;
            }

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "INSERT INTO tbl_itemstock(catalogid,purchasedate,quntity,buyingprice,sellingprice,discount,adddate,adduser) VALUES ('$catalogid','$purchasedate','$quantity','$bprice','$sprice','$discount','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);

            if(!empty($purchaseorderid)){
            $delsql = "UPDATE tbl_purchaseorder SET deliverystatus='done' WHERE purchaseorderid='$purchaseorderid'";
            $result = $db->query($delsql);
            }

            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="catalogid" value="<?= @$rows['catalogid']; ?>" >
        <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>" >
        <input type="hidden" name="purchaseorderid" value="<?= @$purchaseorderid; ?>" >




        <div class="mb-3">
            <img class="img-fluid w-25 h-25" src="<?= SYSTEM_PATH ?>inventory/images/<?= @$rows['itemimage'] ?>">
        </div>
        <div class="row">
            <div class="col-md-6">
                <legend>Item Details</legend>
                <div class="mb-3">
                    <label for="Brandname" class="form-label">Brand Name</label>
                    <input type="text" class="form-control w-75" id="brandname" name="brandname" value="<?= @ucfirst($rows['brandname']); ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_brand']; ?></div>
                </div>


                <div class="mb-3">
                    <label for="itemname" class="form-label">Item Name</label>
                    <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$rows['itemname']; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_item']; ?></div>
                </div>

                <div class="mb-3">
                    <label for="modelname" class="form-label">Model</label>
                    <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$rows['modelno']; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['modelname']; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <legend>Catalog Details</legend>
                <div class="mb-3">
                    <label for="" class="form-label">Received date</label>
                    <?php $date = date('Y-m-d'); ?>
                    <input type="date" class="form-control w-75" id="purchasedate" name="purchasedate" value="<?= @$purchasedate ?>" max="<?= $date ?>" >
                    <div class="text-danger"><?php echo @$messages['error_purchasedate']; ?></div>
                </div>



                <div class="mb-3">
                    <label for="" class="form-label">Number of quantity</label>
                    <input type="number" class="form-control w-75" id="quantity" name="quantity" value="<?= @$quantity; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_quantity']; ?></div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label">Buying price(Rs.)</label>
                    <input type="text" class="form-control w-75" id="bprice" name="bprice" value="<?= @$bprice; ?>" readonly>
                    <div class="text-danger"><?php echo @$messages['error_bprice']; ?></div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">selling price(Rs.)</label>
                    <input type="text" class="form-control w-75" id="sprice" name="sprice" value="<?= @$sprice; ?>">
                    <div class="text-danger"><?php echo @$messages['error_sprice']; ?></div>
                </div>

                
            </div>
        </div>



        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemstock.php?categoryid=<?= $categoryid ?>&catalogid=<?= $catalogid ?>" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>    


<?php
ob_flush();
?>

<?php include '../footer.php'; ?>

