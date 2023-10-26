<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Vehicle Model</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="model.php" class="btn btn-sm btn-outline-secondary">View Vehicle Models</a>
               
            </div>
            
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
        $message = array();
        // required validation
        if (empty($modelname)) {
            $message['error_modelname'] = "The ModelName should not be empty..!";
        }

        if (empty($vtype)) {
            $message['error_vtype'] = "The VehicleType should not be empty..!";
        }
        if (empty($brand)) {
            $message['error_brand'] = "The BrandName should not be empty..!";
        }

        //advanced validation
        if (!empty($modelname)) {

            $sql = "SELECT * FROM tbl_models WHERE modelname='$modelname' AND deletestatus=1";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_modelname'] = "The brand name already exsist...!";
            }
        }



        //check validation is completed
        if (empty($message)) {
            //call to the db connection
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "INSERT INTO tbl_models(modelname,vehicletype,brandid,adddate,adduser) VALUES ('$modelname','$vtype','$brand','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="input-group-md mb-3 mt-3">
            <label for="modelname" class="form-label">Model Name : </label>
            <input type="text" class="form-control w-75" value="<?php echo @$modelname; ?>" id="modelname" name="modelname">
            <div class="text-danger"><?php echo @$message['error_modelname']; ?></div>
        </div>
        <div class="input-group-md mb-3 mt-3">
            <label for="">Bike type :</label><br>

            <input type="radio" id="stype" name="vtype" value="Scooter" <?php echo (@$vtype == "Scooter") ? "checked" : ""; ?>>
            <label for="stype">Scooter</label><br>

            <input type="radio" id="mtype" name="vtype" value="Motorbike" <?php echo (@$vtype == "Motorbike") ? "checked" : ""; ?>>
            <label for="mtype">Motorbike</label><br>
            <div class="text-danger"><?php echo @$message['error_vtype']; ?></div>
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
            <div class="text-danger"><?php echo @$message['error_brand']; ?></div>

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
