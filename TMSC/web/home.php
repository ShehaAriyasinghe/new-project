<div class="row">

    <!--resposive div start-->
    <div class="image_slider">

        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

            <?php
            //carosel in home page code
            $db = dbconn();
            $sql = "SELECT * FROM tbl_displaycarousel WHERE deletestatus=1";
            $result = $db->query($sql);
            ?>    

            <div class="carousel-indicators">
                <?php
                $x = 0;
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>



                        <?php
                        if ($x == 0) {
                            ?>

                            <button type = "button" data-bs-target = "#carouselExampleCaptions" data-bs-slide-to = "<?php echo $x ?>" class="active" aria-current = "true" aria-label = "Slide <?php echo ++$x ?>"></button>
                            <?php
                        }
                        if (1 <= $x && $x < 5) {
                            ?>

                            <button type = "button" data-bs-target = "#carouselExampleCaptions" data-bs-slide-to = "<?php echo $x ?>" aria-current = "true" aria-label = "Slide <?php echo ++$x ?>"></button>
                            <?php
                        }
                        ?>

                        <?php
                    }
                }
                ?>

            </div>





            <div class="carousel-inner">

                <?php
                $db = dbconn();
                $sql1 = "SELECT * FROM tbl_displaycarousel WHERE deletestatus=1";
                $result1 = $db->query($sql1);
                ?>    


                <?php
                $x = 0;
                if ($result1->num_rows > 0) {
                    while ($rows1 = $result1->fetch_assoc()) {

                        if ($x == 0) {
                            ?>

                            <div class="carousel-item active">
                                <img src="<?= SYSTEM_PATH; ?>/services/images/<?= $rows1['carouselimage'] ?>" class="d-block w-100" style="width:100; height:600px;">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?php echo $rows1['title']; ?></h5>
                                    <p><?php echo $rows1['description']; ?></p>
                                </div>
                            </div>

                            <?php
                            ++$x;
                        } else {
                            ?>

                            <div class="carousel-item">
                                <img src="<?= SYSTEM_PATH; ?>/services/images/<?= $rows1['carouselimage'] ?>" class="d-block w-100" style="width:100; height:600px;">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?php echo $rows1['title']; ?></h5>
                                    <p><?php echo $rows1['description']; ?></p>
                                </div>
                            </div>






                            <?php
                        }
                    }
                }
                ?>
           




            <?php if (isset($_SESSION['reservation_date']) && isset($_SESSION['customer_userid'])) { ?>
                <div class="card banner my-card-bg">

                    <h4>Confirmation Of Reservation.</h4>
                    <p>Reservation Date: <?= $_SESSION['reservation_date']; ?></p>
                    <p>Reservation Time: <?php echo $_SESSION['reservation_stime'] . "-" . $_SESSION['reservation_etime']; ?></p>
                    <p>Bay: <?= ucfirst($_SESSION['bay']); ?></p>
                    <div class="row">

                        <div class="col-md-6">
                            <a href="<?= WEB_PATH; ?>vehicles/addvehicle.php" class="btn btn-button me-md-2 mt-2" >Add Your Vehicle</a>
                        </div>
                    </div>

                </div>
            <?php } ?>

            <!--responsive div end-->
        </div>  
             </div>    
    </div>

</div>





<?php
//Display main services
if (!isset($_SESSION['customer_userid'])) {

    $db = dbconn();
    $sql = "SELECT s.serviceid,s.servicename,s.duration,ds.serviceimage FROM tbl_displayservices ds INNER JOIN tbl_services s ON s.serviceid=ds.serviceid WHERE ds.deletestatus=1";
    $result = $db->query($sql);
    ?>    

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

        <?php
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
                ?>
                <div class="col">
                    <div class="card">
                        <img src="<?= SYSTEM_PATH ?>services/images/<?= $rows['serviceimage'] ?>" class="card-img-top" alt="..." width="300" height="200">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $rows['servicename']; ?></h5>
                            <a href="<?= WEB_PATH ?>reservations/checkavailable_reservation.php?serviceid=<?php echo $rows['serviceid']; ?>" class="btn btn-button me-md-2 mt-2">Book Now</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } else {
// relevent customer all vehicles
        $customeruserid = $_SESSION['customer_userid'];
        $db = dbconn();

        $sql = "SELECT v.vehicleid,v.plateno,v.plateimage,b.brandname,m.modelname,nm.nextmileage,COUNT(j.jobcardid) as numofservices FROM tbl_vehicles v INNER JOIN tbl_brands b ON b.brandid=v.brandid INNER JOIN tbl_models m ON m.modelid=v.modelid LEFT JOIN tbl_jobcards j ON j.vehicleid=v.vehicleid LEFT JOIN tbl_nextrecommendedmileage nm ON nm.vehicleid=v.vehicleid WHERE v.adduser=$customeruserid  AND v.deletestatus=1 GROUP BY v.vehicleid ORDER BY nm.adddate DESC";
        $result = $db->query($sql);
        ?>    

        <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

            <?php
            
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?= WEB_PATH ?>vehicles/images/<?= $rows['plateimage'] ?>" class="card-img-top" alt="..." width="300" height="200">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $rows['plateno']; ?></h6>
                                <p><?php echo $rows['brandname'] . "  " . $rows['modelname']; ?></p>

                                <p>Next service mileage: <?php echo $rows['nextmileage']; ?></p>
                                <?php
                                $sql = "SELECT COUNT(jobcardid) AS servicecount from tbl_jobcards WHERE vehicleid='" . $rows['vehicleid'] . "' AND deletestatus='1';";
                                $jobcardcount = $db->query($sql);
                                $rowjobcardcount = $jobcardcount->fetch_assoc();
                                ?>
                                <p>Num of services: <?php echo $rowjobcardcount['servicecount']; ?></p>


                                <a href="<?= WEB_PATH ?>reservations/customer_reservation.php?vehicle=<?php echo $rows['vehicleid']; ?>" class="btn btn-button me-md-2 mt-2">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>    

    </div>




<!--Scanning QR-->
    <div class="row">
        <div class="col-md-4 mt-1">



            <div class="card" style="width: 18rem;">
                <img src="<?= WEB_PATH ?>assets/images/qr.jpg" height="150" class="card-img-top" alt="...">
                <div class="card-body">
                    <h6 class="card-title">You can get your vehicle service ongoing status by scanning QR</h6>

                    <a href="<?= WEB_PATH ?>qrscan.php" class='btn btn-button' >Scan</a>
                </div>
            </div>

        </div>
        <div class="col-md-4 mt-1">


        </div>



        <div class="col-md-4 mt-1">
            <?php
            if (isset($_SESSION['customer_userid'])) {
                ?>

                <div class="card">
                    <div class="card-header">
                        Reservations
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Place your reservation online and get your services without having to wait!</h6>



                        <a class="btn btn-button" href="<?= WEB_PATH; ?>reservations/customer_reservation.php">
                            Submit Reservation
                        </a>



                    </div>
                </div>

                <?php
            } else {
                ?>

                <div class="card">
                    <div class="card-header my-nav-bg">
                        Customer Registration
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Now customer can register and get the valuable services</h6>



                        <a class="btn btn-button" href="<?= WEB_PATH; ?>customers/customer_registration.php">
                            Customer Registration
                        </a>



                    </div>
                </div>

                <?php
            }
            ?>


        </div>
    </div>


  <?php
            if (!isset($_SESSION['customer_userid'])) {
                ?>


    <section>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8 text-center">
                <h3 class="mb-4 text-white">Our Customer Feedbacks</h3>
               
            </div>
        </div>

        <div class="row text-center d-flex align-items-stretch">
            <?php
            $sql="SELECT customername,feedback,image FROM tbl_feedbacks WHERE deletestatus='1' AND displaystatus='show' LIMIT 3";
            $result = $db->query($sql);
            if($result->num_rows > 0){
           while($row=$result->fetch_assoc()){
            
            ?>
            <div class="col-md-4 mb-5 mb-md-0 d-flex align-items-stretch">
                <div class="card testimonial-card my-card-bg">
                    <div class="card-up" style="background-color: #9d789b;"></div>
                    <div class="avatar mx-auto bg-transparent">
                        <img src="<?= WEB_PATH ?>feedback/images/<?= $row['image'] ?>"
                             class="rounded-circle img-fluid w-50" />
                    </div>
                    <div class="card-body">
                        <h6 class="mb-4 text-light"><?= $row['customername'] ?></h6>
                        <hr />
                        <p class="text-light mt-4">
                            <i class="fas fa-quote-left pe-2"></i><?= $row['feedback'] ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <?php
            }
            
           }
            ?>
            
            
        </div>
    </section>

<?php

           }

?>

