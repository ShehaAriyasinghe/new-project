
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Job card Management</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php" type="button" class="btn btn-sm btn-outline-secondary">View all reservations</a>
                
            </div>
            
        </div>
    </div>

    <h6>Create Job card</h6>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);

        $reservationid = $reservationid;
        $mode = $mode;

        if ($mode == "jobcard") {

            $date = date('Y-m-d');

            $qry = "SELECT r.reservationid,r.vehicleid,r.adduser,r.serviceid,r.reservationdate,r.starttime,r.endtime,r.bay,r.deletestatus,r.jobcardstatus,s.servicename,c.firstname,c.lastname,c.email,v.plateno 
                FROM tbl_reservations r INNER JOIN tbl_services s ON s.serviceid=r.serviceid INNER JOIN tbl_vehicles v on v.vehicleid=r.vehicleid
                INNER JOIN tbl_customers c ON c.userid =r.adduser WHERE r.deletestatus='1' and r.jobcardstatus='pending' and r.reservationdate='$date' and r.reservationid=$reservationid";

            $db = dbconn();
            $result = $db->query($qry);
            $row = $result->fetch_assoc();

            $reservationid = $row['reservationid'];
            $vehicleid = $row['vehicleid'];
            $customeruserid = $row['adduser'];
            $serviceid = $row['serviceid'];
            $reservationdate = $row['reservationdate'];
            $starttime = date('H:i', strtotime($row['starttime']));
            $endtime = date('H:i', strtotime($row['endtime']));
            $plateno = $row['plateno'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
             $email = $row['email'];
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        extract($_POST);
        $db = dbconn();
        $adddate = date('Y-m-d');
        $adduser = $_SESSION['userid'];

        $messages = array();

        //required validation
        if (empty($status)) {
            $messages['error_status'] = "The service status should not be empty...!";
        }

        if (empty($mileage)) {
            $messages['error_mileage'] = "The Vehicle mileage should not be empty...!";
        }else{
             
                if (!preg_match('/^[0-9 ]+$/i', $mileage)) {

                    $messages['error_mileage'] = "This Vehicle mileage should be numbers...!";
                }
        
        }
        
       if (!empty($mileage)) {
        
          if ($mileage < "500") {
            $messages['error_mileagemin'] = "The Vehicle mileage should be greater than 500 Km...!";
        }
        
       }
        



        if (@$status == "yes") {
            if (empty($vouchercode)) {
                $messages['error_voucher'] = "The Voucher code should not be empty...!";
            } else {
                $sql = "SELECT * FROM tbl_servicevoucher WHERE vouchercode='$vouchercode'";
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
            if (empty($messages)) {
                
                if(!empty($_FILES['voucherimage']['name'])){

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
        }



        if (empty($messages)) {

            $sql = "INSERT INTO tbl_jobcards(customeruserid,vehicleid,serviceid,reservationdate,starttime,endtime,plateno,reservationid,freeservicestatus,mileage,adduser,adddate) VALUES ($customeruserid,$vehicleid,$serviceid,'$reservationdate','$starttime','$endtime','$plateno',$reservationid,'$status','$mileage',$adduser,'$adddate')";
            $db->query($sql);
            $last_id = $db->insert_id;

            //create qr code to jobcard
            
            //Qr image store path
            $qr_path = 'qr/';

            include "../assets/phpqrcode/qrlib.php";

            if (!file_exists($qr_path))
                mkdir($qr_path);

            //scanning level
            $errorCorrectionLevel = 'L';
            $matrixPointSize = 4;

            $data = $last_id;
            $filename = $qr_path . 'tmsc' . md5($data . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

            //create qrcode class object and call method png
            QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            $filename = basename($filename);
            $sql2 = "UPDATE tbl_jobcards SET qrimage='$filename' where jobcardid=$last_id";
            $db->query($sql2);

            if ($status == "yes") {


                $sql1 = "INSERT INTO tbl_servicevoucher(jobcardid,customeruserid,vehicleid,serviceid,voucherimage,vouchercode,adduser,adddate) VALUES ('$last_id',$customeruserid,$vehicleid,$serviceid,'$file_name_new','$vouchercode',$adduser,'$adddate')";
                $db->query($sql1);
            }

            $sqlupd = "UPDATE tbl_reservations SET jobcardstatus='issuedjobcard' where reservationid=$reservationid";
            $db->query($sqlupd);
            header("Location:jobcard_createdsuccess.php?plateno=$plateno&servicetime=$servicetime&customername=$fullname&servicedate=$reservationdate&filename=$filename&email=$email");
        }
    }
    
    ?>
    <div class = "row">


        <div class = "col-md-8 mt-5">
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST" enctype="multipart/form-data">

                <div class="card my-card-bg px-2" style="width: 150%">



                    <div class="text-center card-header-tabs my-card-heading mb-3">
                        <h2 class="display-6 fw-bolder">Create Job card</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-check-label">Customer Name : </label>
                                <input type="text" class="form-check border-dark" value="<?php echo @$firstname . ' ' . @$lastname; ?>" name="fullname" readonly>
                            </div>





                            <input type="hidden" value="<?php echo @$reservationid; ?>" name="reservationid">
                            <input type="hidden" value="<?php echo @$vehicleid; ?>" name="vehicleid">
                            <input type="hidden" value="<?php echo @$customeruserid; ?>" name="customeruserid">
                            <input type="hidden" value="<?php echo @$starttime; ?>" name="starttime">
                            <input type="hidden" value="<?php echo @$endtime; ?>" name="endtime">
                            <input type="hidden" value="<?php echo @$serviceid; ?>" name="serviceid">
                            <input type="hidden" value="<?php echo @$firstname ?>" name="firstname">
                            <input type="hidden" value="<?php echo @$lastname; ?>" name="lastname">
                             <input type="hidden" value="<?php echo @$email; ?>" name="email">

                            <div class="mb-3">
                                <label class="form-check-label">Reservation Time : </label>
                                <input type="text" class="form-check border-dark" value="<?php echo @$starttime . '--' . $endtime; ?>" name="servicetime" readonly>
                            </div>  


                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cname" class="form-check-label">Vehicle Plate No: </label>
                                <input type="text" class="form-check border-dark" value="<?php echo @$plateno; ?>" name="plateno" readonly>
                            </div>

                            <div class="mb-3">
                                <?php
                                $sql = "SELECT serviceid,servicename,serviceprice FROM tbl_services WHERE deletestatus=1";
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

                        <div class="col-md-4">

                            <div class="mb-3">
                                <label class="form-check-label">Reservation Date : </label>
                                <input type="date" class=" form-check border-dark" value="<?php echo @$reservationdate; ?>" name="reservationdate" readonly>
                            </div>

                            <label>Honda Free services:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="Yes" value="yes" <?php if (isset($status) && $status == 'yes') { ?> checked <?php } ?> >
                                <label class="form-check-label" for="Yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="No" value="no" <?php if (isset($status) && $status == 'no') { ?> checked <?php } ?>>
                                <label class="form-check-label" for="No">
                                    No
                                </label>
                                <div class="text-danger"><?php echo @$messages['error_status']; ?></div>

                            </div>

                            <div id="showOne" class="myDiv" id="show">
                                <div class="mb-3">   
                                    <label for="voucherimage" class="form-label">Upload Voucher Image</label>
                                    <input class="form-control" type="file" id="voucherimage" name="voucherimage">
                                    <span>If the customer has a free service, a Honda voucher should be uploaded. </span>
                                    <div class="text-danger"><?php echo @$messages['error_file']; ?></div>

                                    <label for="vouchercode" class="form-label">Voucher code:</label>
                                    <input class="form-control" type="text" id="vouchercode" name="vouchercode" value="<?= @$vouchercode; ?>">

                                </div>
                            </div> 
                            <div class="text-danger"><?php echo @$messages['error_voucher']; ?></div>
                            <div class="text-danger"><?php echo @$messages['error_voucherformat']; ?></div>


                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vehicle mileage:(km)</label>                       
                            <input class="form-control-sm" type="text" name="mileage" value="<?php echo @$mileage; ?>"> <span>km</span>
                            <div class="text-danger"><?php echo @$messages['error_mileage']; ?></div>
                            <div class="text-danger"><?php echo @$messages['error_mileagemin']; ?></div>
                        </div>

                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" name="submit" class="btn card-btn me-md-2 mt-1 mb-2">Create Job card</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>













</main>
<?php
include '../footer.php';
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