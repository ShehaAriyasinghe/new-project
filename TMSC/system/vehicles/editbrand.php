<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //Extract inputs
    extract($_GET);

    if (@$mode == "edit") {
        
        $sql = "SELECT * FROM tbl_brands WHERE brandid='$brandid'";
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $brandname=$row['brandname'];
        $brandid=$row['brandid'];
        
        
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Vehicle Brand</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="brand.php" class="btn btn-sm btn-outline-secondary">View Vehicle Brands</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update  Product
            </button>
        </div>
    </div>

<?php
//Check submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Extract inputs
    extract($_POST);

    //Data clean
    $brandname = cleanInput($brandname);

    //Create array
    $messages = array();

    //required validation
    if (empty($brandname)) {
        $messages['error_brand'] = "The brand name should not be empty..!";
    }



    //advaced validation
    if (!empty($brandname)) {
        if (!preg_match('/^[a-z ]+$/i', $brandname)) {
            $messages['error_brand'] = "The brand name should be letters and white spaces only";
        }
    }

    if (!empty($brandname)) {

        $sql = "SELECT * FROM tbl_brands WHERE brandname='$brandname' AND brandid!=$brandid AND deletestatus=1";
        $db = dbConn();
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $messages['error_brand'] = "The brand name already exsist...!";
        }
    }




    //check validation is completed
    if (empty($messages)) {
        //call to the db connection
        $updatedate = date('Y-m-d');
        $updateuser = $_SESSION['userid'];
        
        $sql = "UPDATE tbl_brands SET brandname='$brandname',updatedate='$updatedate',updateuser='$updateuser' WHERE brandid=$brandid";
        $db = dbConn();
        $db->query($sql);
        showEditSucc();
    }
}
?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="mb-3">
            <input type="hidden" class="form-control w-75" id="brandid" name="brandid" value="<?= @$brandid; ?>" >
            <label for="brandname" class="form-label">Brand Name</label>
            <input type="text" class="form-control w-75" id="brandname" name="brandname" value="<?= @$brandname; ?>" >
            <div class="text-danger"><?php echo @$messages['error_brand']; ?></div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>vehicles/addbrand.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>
