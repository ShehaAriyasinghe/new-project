<?php
include '../header.php';
include '../menu.php';
?>


</head>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add New Display service </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/display_services.php" class="btn btn-sm btn-outline-secondary">View All Display services</a>

            </div>

        </div>
    </div>


    <?php
//Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Create array
        $messages = array();

        //required validation



        if (empty($service)) {

            $messages['error_service'] = "The service should not be empty...!";
        } else {

            $sql = "SELECT * FROM tbl_displayservices WHERE serviceid='$service'";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_service'] = "This service already exists...!";
            }
        }




            //image validations


            if (empty($messages)) {

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
                    $messages['error_file'] = "Invalid file type or empty image";
                }
            }

            if (empty($messages)) {
                $adddate = date('Y-m-d');
                $adduser = $_SESSION['userid'];

                $sql = "INSERT INTO tbl_displayservices(serviceid,serviceimage,description,adddate,adduser) VALUES('$service','$file_name_new','$description','$adddate','$adduser') ";
                $db = dbconn();
                $db->query($sql);
                showSuccMeg();
            }
        }
        ?>



        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

            <div class="mb-3">

    <?php
    $sql1 = "SELECT serviceid,servicename,serviceprice,duration FROM tbl_services WHERE deletestatus=1";
    $db = dbconn();
    $result = $db->query($sql1);
    ?>
                <label class="form-label">Select a service type :</label>
                <select class="form-select border-dark" name="service" id="serviceid">
                    <option value="">--</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $time = "+" . $row['duration'];
                        $time = date('H:i', strtotime($time, strtotime("00:00")));
                        ?>

                            <option value="<?php echo $row['serviceid']; ?>" <?php if (@$service == $row['serviceid']) { ?> selected <?php } ?>><?php echo $row['servicename'] . " - Rs." . $row['serviceprice'] . '   ' . "(Time Duration" . '- ' . $time . ')'; ?></option>

                            <?php
                        }
                    }
                    ?>
                </select>
                <div class="text-danger"><?php echo @$messages['error_service']; ?></div>

            </div>


            <div class="mb-3 mt-3">
                <label for="productimage" class="form-label">Upload Service Image</label>
                <input class="form-control" type="file" id="productimage" name="productimage">
                <div class="text-danger"><?php echo @$messages['error_file']; ?></div>

            </div>

            <div class="mb-3 mt-3">
                <label for="description" class="form-label">Description(optional)</label>
                <textarea class="form-control" id="description" name="description"><?= @$description ?></textarea>

            </div>




            <div class="row justify-content-around">
                <div class="col-4">

                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
                <div class="col-4">
                    <a href="<?= SYSTEM_PATH; ?>services/adddisplay_service.php" class="btn btn-outline-primary">Reset</a>
                </div>
            </div>

        </form>
    </main>
    <?php include '../footer.php'; ?>











