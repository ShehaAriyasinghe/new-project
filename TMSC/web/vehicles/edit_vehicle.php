<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Edit Vehicle Details</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= WEB_PATH; ?>vehicles/addvehicle.php" type="button" class="btn btn-sm btn-outline-secondary mx-4">Add new vehicle</a>

            </div>

        </div>
    </div>



    <?php
    //Extract inputs
    extract($_POST);
    extract($_GET);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $sql = "SELECT v.vehicleid,v.modelid,v.brandid,v.plateno,v.plateimage,v.year,m.vehicletype,m.modelname,b.brandname FROM tbl_vehicles v INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus=1 AND v.vehicleid='$vehicleid'";
        $db = dbconn();
        $result = $db->query($sql);

        $row = $result->fetch_assoc();

        $plateno = $row['plateno'];
        $year = $row['year'];
        $vehicletype = $row['vehicletype'];
        $brand = $row['brandid'];
        $model = $row['modelid'];
        $previousname = $row['plateimage'];
        $vehicleid = $row['vehicleid'];
    }

    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operate == 'submit') {



        //Data clean
        $plateno = cleanInput(@$plateno);

        //Create array
        $messages = array();

        //required validation

        if (empty($plateno)) {

            $messages['error_plateno'] = "The vehicle plate number should not be empty...!";
        }


        if (empty($year)) {

            $messages['error_year'] = "The Year should not be empty...!";
        }

        if (empty($brand)) {

            $messages['error_brand'] = "The brand should not be empty...!";
        }

        if (empty($model)) {

            $messages['error_model'] = "The Model should not be empty...!";
        }


        //advanced validaion
        //Check plate no already exists.

        if (!empty($plateno)) {

            if (!preg_match('/(^([A-Z]{2}|[A-Z]{3})[-]\d{4}$)/', $plateno)) {
                $messages['error_plateno'] = "The Plate Number format is incorect or Plate Number length is incorrect..!";
            } else {
                $sql = "SELECT * FROM tbl_vehicles WHERE plateno='$plateno' AND vehicleid !='$vehicleid' AND deletestatus='1'";
                $db = dbConn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_plateno'] = "This Plate number already exists...!";
                }
            }
        }

        //validate manufacturing year format
        if (!empty($year)) {

            if (!preg_match('/^[0-9]+$/i', $year)) {
                $messages['error_year'] = "Year should be number format..!";
            }
        }


        //image validations

        if (empty($messages) && !empty($_FILES['productimage']['name'])) {



            $image = $_FILES['productimage'];
            $file_name = $image['name'];
            $file_tmp = $image['tmp_name'];
            $file_size = $image['size'];
            $file_error = $image['error'];

            //workout the file extension
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));
            //allow file types
            $allowed = array('png', 'jpg', 'jpeg');
            //check if the file is allowed

            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= 2097152) {
                        $file_name_new = uniqid('', true) . '.' . $file_ext;
                        //file destination
                        $file_destination = 'images/' . $file_name_new;
                        //move the file
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            unlink('images/' . $previousname);
                        } else {
                            $messages['error_file'] = "There was an error uploading the file.";
                        }
                    } else {
                        $messages['error_file'] = "File size is invalid";
                    }
                } else {
                    $messages['error_file'] = "File has error";
                }
            } else {
                $messages['error_file'] = "Invalid file type";
            }
        } else {
            $file_name_new = $previousname;
        }





        if (empty($messages)) {
            $updatedate = date('Y-m-d');
            $customer_userid = $_SESSION['customer_userid'];

            $sql = "UPDATE tbl_vehicles SET plateno='$plateno',year='$year',brandid='$brand',modelid='$model',plateimage='$file_name_new',updatedate='$updatedate',updateuser='$customer_userid' WHERE vehicleid='$vehicleid'";
            $db = dbconn();
            $db->query($sql);

            header("Location: vehicle_editsuccess.php?plateno=$plateno&updatedate=$updatedate&vehicleid=$vehicleid");
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

        <div class="card my-card-bg px-2">

            <input type="hidden" name="vehicleid" value='<?php echo @$vehicleid; ?>'>

            <div class="mb-3 mt-3">
                <img width="150" height="150" src="<?= WEB_PATH ?>vehicles/images/<?= $previousname; ?>" >

                <input type="hidden" name="previousname" value="<?= $previousname; ?>">

            </div>    

            <div class="mb-3 mt-3">
                <label for="plateno" class="form-label">Plate No:</label>
                <input type="text" name="plateno" class="form-control" id="plateno" value='<?php echo @$plateno; ?>'>
                <div class="text-danger"><?php echo @$messages['error_plateno']; ?></div>
                <span>Example formats: BAC-8545,BC-6545</span>
            </div>


            <div class="mb-3 mt-3">
                <label for="year" class="form-label">Manufacturing Year(YOM):</label>
                <select name="year" id="year" class="form-control">
                    <option value="">--</option>
                    <?php
                    for ($oldyear = 1990; $oldyear <= date('Y'); $oldyear++) {
                        ?>
                        <option value="<?= $oldyear; ?>" <?php if ($oldyear == @$year) { ?> selected <?php } ?>><?= $oldyear; ?></option>
                    <?php } ?>
                </select>
                <div class="text-danger"><?php echo @$messages['error_year']; ?></div>
            </div>



            <div class="mb-3 mt-3">
                <?php
                $sql = "SELECT brandid,brandname FROM tbl_brands WHERE deletestatus=1";
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <label class="form-label">Select a vehicle brand name :</label>
                <select class="form-select border-dark" name="brand" id="brandid" onchange="form.submit()">  
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

            <div class="mb-3 mt-3">
                <?php
                $sql = "SELECT * FROM tbl_models WHERE brandid='" . @$brand . "' && deletestatus=1";
                $db = dbConn();
                $result = $db->query($sql);
                ?>

                <label>Select a vehicle model</label>

                <select name="model" id="model" class="form-select border-dark"  value="<?= $model ?>">
                    <option value="">--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['modelid'] ?>"  <?php if (@$model == $row['modelid']) { ?> selected <?php } ?>><?php echo $row['modelname'] . "-" . $row['vehicletype']; ?></option>

                            <?php
                        }
                    }
                    ?>
                </select>

                <div class="text-danger"><?php echo @$messages['error_model']; ?></div>
            </div>






            <div class="mb-3 mt-3">
                <label for="productimage" class="form-label">Upload Vehicle Image</label>
                <input class="form-control" type="file" id="productimage" name="productimage">
                <div class="text-danger"><?php echo @$messages['error_file']; ?></div>



            </div>


            <div class="row justify-content-around">
                <div class="col-4">

                    <button type="submit" class="btn btn-outline-primary" name="operate" value="submit">Submit</button>
                </div>
                <div class="col-4">
                    <a href="<?= WEB_PATH; ?>vehicles/view_vehicles.php" class="btn btn-outline-primary">Back</a>
                </div>

            </div>


        </div>
    </form>
</main>




<?php
include '../customerfooter.php';
?>

