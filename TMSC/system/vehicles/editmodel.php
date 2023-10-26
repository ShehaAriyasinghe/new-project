<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //Extract inputs
    extract($_GET);

    if (@$mode == "edit") {

        $sql = "SELECT * FROM tbl_models WHERE modelid='$modelid'";
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $modelname = $row['modelname'];
        $modelid = $row['modelid'];
        $vtype = $row['vehicletype'];
        $brand = $row['brandid'];
    }
}
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Vehicle Model</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="model.php" class="btn btn-sm btn-outline-secondary">View Vehicle Models</a>
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
        $modelname = cleanInput($modelname);

        //Create array
        $messages = array();

        if (empty($modelname)) {
            $messages['error_modelname'] = "The ModelName should not be empty..!";
        }

        if (empty($vtype)) {
            $messages['error_vtype'] = "The VehicleType should not be empty..!";
        }
        if (empty($brand)) {
            $messages['error_brand'] = "The BrandName should not be empty..!";
        }

        //advanced validation
        if (!empty($modelname)) {

            $sql = "SELECT * FROM tbl_models WHERE modelname='$modelname' AND modelid!=$modelid AND deletestatus=1";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_modelname'] = "The brand name already exsist...!";
            }
        }



        //check validation is completed
        if (empty($messages)) {


            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];

            $sql = "UPDATE tbl_models SET modelname='$modelname',vehicletype='$vtype',brandid='$brand',updatedate='$updatedate',updateuser='$updateuser' WHERE modelid=$modelid";
            //call to the db connection
            $db = dbConn();

            $db->query($sql);
            showEditSucc();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" class="form-control w-75" value="<?php echo @$modelid; ?>" id="modelid" name="modelid">
        <div class="input-group-md mb-3 mt-3">
            <label for="modelname" class="form-label">Model Name : </label>
            <input type="text" class="form-control w-75" value="<?php echo @$modelname; ?>" id="modelname" name="modelname">
            <div class="text-danger"><?php echo @$messages['error_modelname']; ?></div>
        </div>
        <div class="input-group-md mb-3 mt-3">
            <label for="">Bike type :</label><br>

            <input type="radio" id="stype" name="vtype" value="Scooter" <?php echo (@$vtype == "Scooter") ? "checked" : ""; ?>>
            <label for="stype">Scooter</label><br>

            <input type="radio" id="mtype" name="vtype" value="Motorbike" <?php echo (@$vtype == "Motorbike") ? "checked" : ""; ?>>
            <label for="mtype">Motorbike</label><br>
            <div class="text-danger"><?php echo @$messages['error_vtype']; ?></div>
        </div>

        <div class="input-group-md mb-3 mt-3">
            <?php
            $sql = "SELECT brandid,brandname FROM tbl_brands WHERE deletestatus=1";
            $db = dbConn();
            $result = $db->query($sql);
            ?>
            <label class="form-label">Select a Brand Name :</label>
            <select class="form-select w-75 border-dark" name="brand" id="brand">
                <option value="">--</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <option value="<?php echo $row['brandid']; ?>" <?php if (@$brand == $row['brandid']) { ?> selected <?php } ?>><?php echo $row['brandname']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <div class="text-danger"><?php echo @$messages['error_brand']; ?></div>

        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>vehicles/addmodel.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>
