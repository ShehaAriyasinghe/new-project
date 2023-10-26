<?php
include '../header.php';
include '../menu.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //Extract inputs
    extract($_GET);
    if (@$mode == "edit") {

        $sql = "SELECT * FROM tbl_centervehicles WHERE vehicleid='$vehicleid'";
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $color = $row['color'];
        $brand = $row['brandid'];
        $model = $row['modelid'];
        $previousproductimage = $row['vehicleimage'];
        $vehicleid = $row['vehicleid'];
        
    }
}
?>

<script src="<?= SYSTEM_PATH; ?>assets/js/jquery-3.6.1.min.js"></script>
</head>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add New Vehicles </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>vehicles/vehiclebrandcards.php" class="btn btn-sm btn-outline-secondary">View All Vehicle Brands</a>
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
        $color = cleanInput($color);
       

        //Create array
        $messages = array();

        //required validation



        if (empty($color)) {

            $messages['error_color'] = "The Color should not be empty...!";
        }


        if (empty($brand)) {

            $messages['error_brand'] = "The Brand should not be empty...!";
        }
        if (empty($model)) {

            $messages['error_model'] = "The Model should not be empty...!";
        }
        
        
        
        //advaced validation
        
        
        if (!empty($color)) {
            if (!preg_match('/^[a-z ]+$/i', $color)) {
                $messages['error_color'] = "The color name should be letters and white spaces only";
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
            $allowed = array('txt', 'pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'gif');
            //check if the file is allowed

            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size <= 2097152) {
                        $file_name_new = uniqid('', true) . '.' . $file_ext;
                        //file destination
                        $file_destination = 'images/' . $file_name_new;
                        //move the file
                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            unlink('images/' . $previousproductimage);
                            
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
            $file_name_new=$previousproductimage;
        }
        

        if (empty($messages)) {
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];

            
            $sql = "UPDATE tbl_centervehicles SET color='$color',brandid='$brand',modelid='$model',vehicleimage='$file_name_new',updatedate='$updatedate',updateuser='$updateuser' WHERE vehicleid=$vehicleid";
            $db = dbconn();
            $db->query($sql);
            showEditSucc();
        }
    }
    ?>



    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
         <input type="hidden" value="<?= $vehicleid;?>" name="vehicleid" id="vehicleid">
        <div class="col-md-4">

                <img class="img-fluid" src="<?= SYSTEM_PATH ?>vehicles/images/<?= !empty($previousproductimage)?$previousproductimage:'noimage.jpeg' ?>">

            </div>

        <div class="mb-3 mt-3">
            <label for="color" class="form-label">Color:</label>
            <input type="text" name="color" class="form-control form-control-sm" id="color" value='<?php echo @$color; ?>'>
            <div class="text-danger"><?php echo @$messages['error_color']; ?></div>
        </div>
        
        <div class="mb-3 mt-3">
            <label for="productimage" class="form-label">Upload Vehicle Image</label>
            <input class="form-control" type="file" id="productimage" name="productimage">
            <div class="text-danger"><?php echo @$messages['error_file']; ?></div>
        </div>
        <input type="hidden" value="<?= @$previousproductimage;?>" name="previousproductimage" >

        <div class="mb-3 mt-3">
            <?php
            $sql = "SELECT brandid,brandname FROM tbl_brands WHERE deletestatus=1";
            $db = dbConn();
            $result = $db->query($sql);
            ?>
            <label class="form-label">Select a vehicle brand name :</label>
            <select class="form-select border-dark" name="brand" id="brandid" onload=loadModel();>  
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
        <input type="hidden" value="<?= $model;?>" name="modelid" id="modelid">
        
        <div class="mb-3 mt-3">
            <div id="modellist"></div>
        </div>

        <div class="row justify-content-around">
            <div class="col-4">

                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>vehicles/addvehicle.php" type="submit" class="btn btn-outline-primary">Reset</a>
            </div>
        </div>

    </form>
</main>
<?php include '../footer.php'; ?>


<script>

    function loadModel() {

        $.post("editload_model.php", {
            brandid: $("#brandid").val(),
            modelid: $("#modelid").val()
        }, function (data, status) {


            $("#modellist").html(data);
        });

    }
    
    $(window).on("load",function (e){
        loadModel();
    });


</script>









