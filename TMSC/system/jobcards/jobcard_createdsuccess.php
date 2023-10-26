<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php include '../assets/PHPMail/mail.php'; ?>

<?php
extract($_GET);
$filename = basename($filename);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Successfully Created job card.</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php" type="button" class="btn btn-sm btn-outline-secondary">View all reservations</a>

            </div>

        </div>
    </div>



    <h6>Created Vehicle Job card</h6>


    <div class="card card-box px-5" style="width: 50rem;">

        <div class="text-center card-header my-card-heading mb-3 px-1">
            <p class="display-6">Job card is successfully created.</p>
        </div>
        <div class="card-body">
            <div class="row">


                <div class="col-md-6">

                    <h6 class="">Customer Name: <?php echo $customername; ?> </h6>
                    <h6 class="">Vehicle Plate No: <?php echo $plateno; ?></h6>
                    <h6 class="">Service Date: <?php echo $servicedate ?></h6>
                    <h6 class="">Service Time: <?php echo $servicetime; ?></h6>

                </div>
                <!--QR display in success message-->
                <div class="col-md-6">
                    
                        <img src="qr/<?= $filename; ?>" />;
                    
                    
                </div>

            </div>






            <!--send email to customer-->

            <?php
            echo "Check Customer email address..!";
            $body = "<h1>Tusitha service center-HONDA</h1><br>"
                    . "<h6>Customer Name: $customername</h6>"
                    . "<h6>Vehicle Plate no: $plateno</h6>"
                    . "<h6>service Date: $servicedate</h6>"
                    . "<h6>service Time: $servicetime</h6>"
                    . "<a href='http://localhost:8080/tmsc/system/jobcards/qr/$filename'>Open the QR and download</a><br>"
                    . "<a class='btn btn-primary' href='http://localhost:8080/tmsc/web/qrscan.php'>Click to scan the QR</a>";
            $customer_email = $email;
            $customer = $customername;
            $subject = "Get your job card QR code";
            send_email($customer_email, $customer, $subject, $body, "Hello");
            ?>


            <div class="row">
                <div class="col-md-4">

                    <a href="<?= SYSTEM_PATH; ?>index.php" class="btn-sm btn card-btn">Dashboard</a>
                </div>
            </div>
        </div>

    </div>



</main>









<?php include '../footer.php'; ?>