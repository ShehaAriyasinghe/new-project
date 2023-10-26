<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Job card Management</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all jobcards</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>

    <h6>Update Job card</h6>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $date = date('Y:m:d');
        $qry = "SELECT j.reservationid,j.jobcardid,j.reservationdate,j.customeruserid,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.freeservicestatus,j.jobcardstatus,j.vehicleid,j.mileage,c.firstname,c.lastname,r.bay,r.reservationid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.year,v.brandid,v.modelid,j.freeservicestatus,vou.voucherimage,vou.vouchercode,vou.servicevoucherid FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_customers c ON c.userid=j.customeruserid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid LEFT JOIN tbl_servicevoucher vou ON vou.jobcardid=j.jobcardid WHERE j.jobcardstatus='issuedjobcard' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";

        $db = dbconn();
        $result = $db->query($qry);
        $row = $result->fetch_assoc();

        $jobcardid = $row['jobcardid'];
        $reservationid = $row['reservationid'];
        $vehicleid = $row['vehicleid'];
        $customeruserid = $row['customeruserid'];
        $serviceid = $row['serviceid'];

        $reservationdate = $row['reservationdate'];
        $freeservicestatus = $row['freeservicestatus'];
        $starttime = date('h:i', strtotime($row['starttime']));
        $endtime = date('h:i', strtotime($row['endtime']));
        $plateno = $row['plateno'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $mileage = $row['mileage'];
        $voucherimage = $row['voucherimage'];
        $servicevoucherid = $row['servicevoucherid'];
        $vouchercode = $row['vouchercode'];
        $fullname = $firstname . " " . $lastname;
        $servicetime = $starttime . "-" . $endtime;
    }
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {



        $messages = array();

        //required validation
        if (empty($freeservicestatus)) {
            $messages['error_status'] = "The service status should not be empty...!";
        }


        if (empty($mileage)) {
            $messages['error_mileage'] = "The Vehicle mileage should not be empty...!";
        } else {

            if (!preg_match('/^[0-9 ]+$/i', $mileage)) {

                $messages['error_mileage'] = "This Vehicle mileage should be numbers...!";
            }
        }





        if ($freeservicestatus == "yes" && empty($servicevoucherid)) {






            if (empty($vouchercode)) {
                $messages['error_voucher'] = "The Voucher code should not be empty...!";
            } else {
                $sql = "SELECT * FROM tbl_servicevoucher WHERE vouchercode='$vouchercode' AND jobcardid!='$jobcardid'";
                $db = dbConn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_voucher'] = "This voucher code already exists...!";
                }
            }

            if (!empty($vouchercode)) {
                if (!preg_match("/(^#\d{9}$)/", $vouchercode)) {

                    $messages['error_voucherformat'] = "This voucher code format is invalid...!";
                }
            }





            //image validation.
            $file_name_new = null;
            if (empty($messages) && !empty($_FILES['voucherimage']['name'])) {

                $vimage = $_FILES['voucherimage'];
                $file_name = $vimage['name'];
                $file_tmp = $vimage['tmp_name'];
                $file_size = $vimage['size'];
                $file_error = $vimage['error'];

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
                $messages['error_file'] = "The voucher image should not be empty...!";
            }
        }









        if ($freeservicestatus == "yes" && !empty($servicevoucherid)) {


            if (empty($vouchercode)) {
                $messages['error_voucher'] = "The Voucher code should not be empty...!";
            } else {
                $sql = "SELECT * FROM tbl_servicevoucher WHERE vouchercode='$vouchercode' AND jobcardid!='$jobcardid'";
                $db = dbConn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_voucher'] = "This voucher code already exists...!";
                }
            }

            if (!empty($vouchercode)) {
                if (!preg_match("/(^#\d{9})/", $vouchercode)) {

                    $messages['error_voucherformat'] = "This voucher code format is invalid...!";
                }
            }




            //image validation.

            if (empty($messages) && !empty($_FILES['voucherimage']['name'])) {

                $vimage = $_FILES['voucherimage'];
                $file_name = $vimage['name'];
                $file_tmp = $vimage['tmp_name'];
                $file_size = $vimage['size'];
                $file_error = $vimage['error'];

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
        }









        if (empty($messages)) {


            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            if ($freeservicestatus == "yes" && empty($servicevoucherid)) {


                $sql1 = "INSERT INTO tbl_servicevoucher(jobcardid,customeruserid,vehicleid,serviceid,voucherimage,vouchercode,adduser,adddate) VALUES ('$jobcardid',$customeruserid,$vehicleid,$serviceid,'$file_name_new','$vouchercode',$adduser,'$adddate')";
                $db = dbconn();
                $db->query($sql1);

                $sql1 = "UPDATE tbl_jobcards SET freeservicestatus='yes' WHERE jobcardid='$jobcardid'";

                $db->query($sql1);
            }





            if ($freeservicestatus == "yes" && !empty($servicevoucherid)) {


                $sql1 = "UPDATE tbl_servicevoucher SET customeruserid='$customeruserid',vehicleid='$vehicleid',serviceid='$serviceid',voucherimage='$file_name_new',vouchercode='$vouchercode',updateuser='$updateuser',updatedate='$updatedate' WHERE jobcardid='$jobcardid'";
                $db = dbconn();
                $db->query($sql1);

                $sql1 = "UPDATE tbl_jobcards SET freeservicestatus='yes' WHERE jobcardid='$jobcardid'";
                $db = dbconn();
                $db->query($sql1);
            }

            if ($freeservicestatus == "no" && !empty($servicevoucherid)) {
                unlink('images/' . $previousname);

                $sql1 = "DELETE FROM tbl_servicevoucher WHERE jobcardid='$jobcardid'";
                $db = dbconn();
                $db->query($sql1);

                $sql1 = "UPDATE tbl_jobcards SET freeservicestatus='no' WHERE jobcardid='$jobcardid'";
                $db = dbconn();
                $db->query($sql1);
            }


            $sql = "UPDATE tbl_jobcards SET mileage='$mileage',updatedate='$updatedate',updateuser='$updateuser' WHERE jobcardid='$jobcardid'";

            $db = dbconn();
            $db->query($sql);

            header("Location:jobcard_updatedsuccess.php?customername=$fullname&plateno=$plateno&servicedate=$reservationdate&servicetime=$servicetime");
        }
    }
    ?>
    <div class = "row">


        <div class = "col-md-8 mt-5">
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" enctype="multipart/form-data">

                <div class="card my-card-bg px-2" style="width: 150%">



                    <div class="text-center card-header-tabs my-card-heading mb-3">
                        <h2 class="display-6 fw-bolder">Update Job card</h2>
                    </div>

                    <input type="hidden" name="jobcardid" value="<?php echo @$jobcardid ?>">
                    <input type="hidden" name="servicevoucherid" value="<?php echo @$servicevoucherid ?>">
                    <input type="hidden" value="<?php echo @$customeruserid; ?>" name="customeruserid">
                    <input type="hidden" value="<?php echo @$vehicleid; ?>" name="vehicleid">


                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-check-label">Customer Name : </label>
                                <input type="text" class="form-check border-dark" value="<?php echo @$firstname . ' ' . @$lastname; ?>" name="fullname" readonly>
                                <input type="hidden" class="form-check border-dark" value="<?php echo @$firstname ?>" name="firstname" readonly>
                                <input type="hidden" class="form-check border-dark" value="<?php echo @$lastname ?>" name="lastname" readonly>
                            </div>


                            <div class="mb-3">
                                <label class="form-check-label">Reservation Time : </label>
                                <input type="text" class="form-check border-dark" value="<?php echo @$starttime . '--' . $endtime; ?>" name="servicetime" readonly>
                                <input type="hidden" class="form-check border-dark" value="<?php echo @$starttime ?>" name="starttime" readonly>
                                <input type="hidden" class="form-check border-dark" value="<?php echo @$endtime ?>" name="endtime" readonly>

                            </div>  




                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cname" class="form-check-label">Vehicle PlateNo: </label>
                                <input type="text" class="form-check border-dark" value="<?php echo @$plateno; ?>" name="plateno" readonly>
                            </div>

                            <div class="mb-3">
                                <?php
                                $sql = "SELECT serviceid,servicename,serviceprice FROM tbl_services WHERE deletestatus=1";
                                $db = dbconn();
                                $result = $db->query($sql);
                                ?>
                                <label class="form-check-label">Select a service type :</label>
                                <select class="form-check form-select-sm border-dark" name="serviceid" id="serviceid">
                                    <option value="">--</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value="<?php echo $row['serviceid']; ?>" <?php if (@$serviceid == $row['serviceid']) { ?> selected <?php } ?> disabled><?php echo $row['servicename']; ?></option>

                                            <?php
                                        }
                                    }
                                    ?>
                                </select>

                            </div>

                        </div>
                        <input type="hidden" class="form-check border-dark" value="<?php echo @$serviceid ?>" name="serviceid" readonly>
                        <div class="col-md-4">

                            <div class="mb-3">
                                <label class="form-check-label">Reservation Date : </label>
                                <input type="date" class=" form-check border-dark" value="<?php echo @$reservationdate; ?>" name="reservationdate" readonly>
                            </div>


                            <label>Honda Free services:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freeservicestatus" id="Yes"  value="yes" <?php if (isset($freeservicestatus) && $freeservicestatus == 'yes') { ?> checked <?php } ?> >
                                <label class="form-check-label" for="Yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="freeservicestatus" id="No" value="no" <?php if (isset($freeservicestatus) && $freeservicestatus == 'no') { ?> checked <?php } ?> >
                                <label class="form-check-label" for="No">
                                    No
                                </label>
                                <div class="text-danger"><?php echo @$messages['error_status']; ?></div>
                            </div>

                            <?php
                            if ($freeservicestatus == 'yes') {
                                ?>
                                <div id="showOne" class="myDiv" id="show">
                                    <div class="mb-3">
                                        <img class="img-fluid" src="<?= SYSTEM_PATH ?>jobcards/images/<?= !empty($voucherimage) ? $voucherimage : 'noimage.jpg' ?>">
                                    </div>


                                    <div class="mb-3">   

                                        <label for="voucherimage" class="form-label">Upload Voucher Image</label>
                                        <input class="form-control" type="file" id="voucherimage" name="voucherimage">
                                        <input class="form-control" type="hidden" id="productimage" value="<?= @$voucherimage ?>" name="previousname">
                                        <span>If the customer has a free service, a Honda voucher should be uploaded.</span>
                                        <div class="text-danger"><?php echo @$messages['error_file']; ?></div>

                                        <label for="vouchercode" class="form-label">Voucher code:</label>
                                        <input class="form-control" type="text" id="vouchercode" name="vouchercode" value="<?= @$vouchercode; ?>">

                                    </div>
                                </div>
                                <div class="text-danger"><?php echo @$messages['error_voucher']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_voucherformat']; ?></div>



                                <?php
                            } else {
                                ?>

                                <div id="showOne" class="myDiv" id="show">
                                    <div class="mb-3">   
                                        <label for="voucherimage" class="form-label">Upload Voucher Image</label>
                                        <input class="form-control" type="file" id="voucherimage" name="voucherimage">
                                        <input class="form-control" type="hidden" id="productimage" value="<?= @$voucherimage ?>" name="previousname">
                                        <span>If the customer has a free service, a Honda voucher should be uploaded.
                                        </span>
                                        <div class="text-danger"><?php echo @$messages['error_file']; ?></div>


                                        <label for="vouchercode" class="form-label">Voucher code:</label>
                                        <input class="form-control" type="text" id="vouchercode" name="vouchercode" value="<?= @$vouchercode; ?>">
                                    </div>
                                </div>  
                                <div class="text-danger"><?php echo @$messages['error_voucher']; ?></div>
                                <div class="text-danger"><?php echo @$messages['error_voucherformat']; ?></div>

                                <?php
                            }
                            ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vehicle mileage:(km)</label>                       
                            <input class="form-control-sm" type="text" name="mileage" value="<?php echo @$mileage; ?>"> <span>km</span>
                            <div class="text-danger"><?php echo @$messages['error_mileage']; ?></div>
                        </div>






                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" name="submit" class="btn card-btn me-md-2 mt-1">Update Job card</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>

</div>


</main>
<?php include '../footer.php';
?>

<script>

    $(document).ready(function () {
        $("#Yes").click(function () {

            $(".myDiv").show();
        });
    });


    $(window).on("load", function () {
        $(".myDiv").show();
    });


    $(document).ready(function () {
        $("#No").click(function () {
            $("div.myDiv").hide();

        });
    });


</script>
