<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="../product.php" class="btn btn-sm btn-outline-secondary">View Product</a>
                
            </div>
            
        </div>
    </div>
    <?php
    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $pName = cleanInput($pName);
        $pQty = cleanInput($pQty);
        $pPrice = cleanInput($pPrice);       
        $pDescription = cleanInput($pDescription);

        //Create array
        $messages = array();

        //required validation
        if (empty($pName)) {
            $messages['error_pName'] = "The Product Name should not be empty...!";
        }
        if (empty($pQty)) {
            $messages['error_pQty'] = "The Product Qty should not be empty...!";
        }

        if (empty($pPrice)) {
            $messages['error_pPrice'] = "The Product Price should not be empty...!";
        }

        //advanced validaion
        if (!empty($pQty)) {
            if (!is_numeric($pQty)) {
                $messages['error_pQty'] = "Invalid Qty..!";
            }
        }

        if (!empty($pName)) {
            $sql = "SELECT * FROM tbl_products WHERE ProductName='$pName'";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_pName'] = "The Product Name already exsist...!";
            }
        }

        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $AddDate=date('Y-m-d');
            $AddUser=$_SESSION['userid'];
            $sql="INSERT INTO tbl_products(ProductName,ProductQty,ProductPrice,ProductDescription,ProductStatus,AddDate,AddUser) VALUES('$pName','$pQty','$pPrice','$pDescription','$pStatus','$AddDate','$AddUser')";
            $db = dbConn();
            $db->query($sql);
            
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="mb-3">
            <label for="product_name" class="form-label">Enter Product Name</label>
            <input type="text" class="form-control" id="product_name" name="pName" value="<?= @$pName; ?>" >
            <div class="text-danger"><?php echo @$messages['error_pName']; ?></div>
        </div>
        <div class="mb-3">
            <label for="product_qty" class="form-label">Enter Product Qty</label>

            <select name="pQty" id="product_qty" class="form-control">
                <option value="">--</option>
                <?php
                for ($q = 1; $q <= 100; $q++) {
                    ?>
                    <option value="<?= $q; ?>" <?php if ($q == @$pQty) { ?> selected <?php } ?>><?= $q; ?></option>
                <?php } ?>
            </select>
            <div class="text-danger"><?php echo @$messages['error_pQty']; ?></div>
        </div>

        <div class="mb-3">
            <label for="product_price" class="form-label">Enter Product Price</label>
            <input type="text" class="form-control" id="product_price" name="pPrice" value="<?php echo @$pPrice; ?>">
            <div class="text-danger"><?php echo @$messages['error_pPrice']; ?></div>
        </div>
        <div class="mb-3">
            <label>Enter Product Description</label>
            <textarea id="description" name="pDescription" class="form-control"><?= @$pDescription; ?></textarea>
        </div>
        <label>Select Product availability</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="pStatus" id="Yes" value="1" <?php if (isset($pStatus) && $pStatus == 'Y') { ?> checked <?php } ?> >
            <label class="form-check-label" for="Yes">
                Yes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="pStatus" id="No" value="0" <?php if (isset($pStatus) && $pStatus == 'N') { ?> checked <?php } ?>>
            <label class="form-check-label" for="No">
                No
            </label>
        </div>

        <label>Select Size: </label>
        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" id="small" value="S" <?php if (isset($size) && in_array("S", $size)) { ?> checked <?php } ?>>
                <label class="form-check-label" for="inlineCheckbox1">Small(S)</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" id="medium" value="M" <?php if (isset($size) && in_array("M", $size)) { ?> checked <?php } ?>>
                <label class="form-check-label" for="inlineCheckbox2">Medium(M)</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" id="large" value="L" <?php if (isset($size) && in_array("L", $size)) { ?> checked <?php } ?>>
                <label class="form-check-label" for="inlineCheckbox2">Large(L)</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" id="exLarge" value="XL" <?php if (isset($size) && in_array("XL", $size)) { ?> checked <?php } ?>>
                <label class="form-check-label" for="inlineCheckbox2">Extra Large(XL)</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="ProductImage" class="form-label">Upload Product Image</label>
            <input class="form-control" type="file" id="ProductImage" name="ProductImage">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</main>
<?php include '../footer.php'; ?>