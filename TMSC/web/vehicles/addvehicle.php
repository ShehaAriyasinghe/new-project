
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
if (!isset($_SESSION['customer_userid'])) {
    header("Location:../customers/customer_login.php");
}
?>

<style>
    body {
        background-image: url('<?= SYSTEM_PATH; ?>assets/images/center27.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;

    }
</style>




<body>
    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card my-card-bg card-box px-5 " style="width: 50rem;">
                <div class="card-header text-center card-header">
                    <h2 class="display-6 fw-bolder text-white">Vehicle Registration</h2>
                </div>

                <div class="card-body">





                    <?php
                    //Extract inputs
                    extract($_POST);

                    //Check submit
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operate == 'submit') {



                        //Data clean
                        $plateno = cleanInput(@$plateno);
                        $year = cleanInput(@$year);

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
                                $sql = "SELECT * FROM tbl_vehicles WHERE plateno='$plateno' AND deletestatus='1'";
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

                        if (empty($messages)) {
                            
                            if(!empty($_FILES['productimage']['name'])){

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
                        }else{
                            $messages['error_file'] = "Image should not be empty..!";
                        }
                        
                            }

                        if (empty($messages)) {
                            $adddate = date('Y-m-d');
                            $customer_userid = $_SESSION['customer_userid'];

                            $sql = "INSERT INTO tbl_vehicles(plateno,year,brandid,modelid,plateimage,adddate,adduser) VALUES('$plateno','$year','$brand','$model','$file_name_new','$adddate','$customer_userid') ";
                            $db = dbconn();
                            $db->query($sql);
                            $lastid = $db->insert_id;
                            header("Location: vehicle_regsuccess.php?plateno=$plateno&regdate=$adddate&lastid=$lastid");
                        }
                    }
                    ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

                        <div class="mb-3 mt-3">
                            <label for="plateno" class="form-label">Plate No:</label>
                            <input type="text" name="plateno" class="form-control form-control-sm" id="plateno" value='<?php echo @$plateno; ?>'>
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
                                <a href="<?= WEB_PATH; ?>vehicles/addvehicle.php" class="btn btn-outline-primary">Reset</a>
                            </div>

                        </div>



                    </form>
                </div>

            </div>
        </div>
    </div>
</body>


<?php include '../footer.php'; ?>