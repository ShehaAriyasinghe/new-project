<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer Feedback</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= WEB_PATH; ?>feedback/viewfeedback.php" type="button" class="btn btn-sm btn-outline-secondary mx-4">View feedback</a>

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

        // empty validations



        $feedback = cleanInput($feedback);
        $customername = cleanInput($customername);

        if (empty($feedback)) {

            $messages['error_feedback'] = "The feedback should not be empty...!";
        }



        if (empty($customername)) {

            $messages['error_cname'] = "The customer name should not be empty...!";
        }


        if (!empty($customername)) {
            if (!preg_match('/^[a-z . ]+$/i', $customername)) {
                $messages['error_cname'] = "Customer name is allowed letters only.";
            }
        }







        if (empty($messages)) {

            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image'];
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
                    $messages['error_file'] = "Invalid file type";
                }
            } else {
                $messages['error_file'] = "Image should not be empty";
            }
        }







        //check validation is completed
        if (empty($messages)) {


            $adddate = date('Y-m-d');
            $adduser = $_SESSION['customer_userid'];
            $sql = "INSERT INTO tbl_feedbacks(userid,customername,feedback,image,adddate,adduser) VALUES ('$adduser','$customername','$feedback','$file_name_new','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">


        <div class="row">
            <div class="col-md-6">
                <legend>Customer Feedback</legend>
                <div class="mb-3">
                    <label for="" class="form-label">Customer Name:</label>
                    <input type="text" class="form-control w-75" id="" name="customername" value="<?= @$customername ?>">
                    <div class="text-danger"><?php echo @$messages['error_cname']; ?></div>
                </div>


                <div class="mb-3">
                    <label for="" class="form-label">Feedback:</label><br>
                    <textarea type='text' name='feedback' rows="4" cols="50" ><?= @$feedback ?></textarea>
                    <div class="text-danger"><?php echo @$messages['error_feedback']; ?></div>
                </div>


                <div class="mb-3">
                    <label for="image" class="form-label">Upload Customer Image</label>
                    <input class="form-control" type="file" id="image" name="image">
                    <div class="text-danger"><?php echo @$messages['error_file']; ?></div>

                </div>


            </div>

        </div>



        <div class="row justify-content-left">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>

        </div>

    </form>

</main>    




<?php
include '../customerfooter.php';
?>

