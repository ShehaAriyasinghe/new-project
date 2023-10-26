<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main>

    <?php
    //Extract inputs
    extract($_GET);
    ?>

    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card my-card-bg px-5" style="width: 40rem;">

                <div class="card-header">
                    <p class="display-6">Vehicle is successfully Registered.</p>
                </div>
                <div class="card-body">
                    <h6 class="">Registered Date: <?php echo $regdate; ?></h6>
                    <h6 class="">Plate No: <?php echo $plateno; ?></h6>
                    <?php
                    $db = dbconn();
                    $sql = "SELECT plateimage from tbl_vehicles where vehicleid=$lastid";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <img src="<?= WEB_PATH; ?>/vehicles/images/<?= $row['plateimage']; ?>" class="img-fluid" width="150" hight="50">
                </div>


                <div class="col-md-3">
                    <?php if (isset($_SESSION['reservation_date'])) { ?>

                        <a href="<?= WEB_PATH; ?>reservations/confirmreservation.php" class="btn btn-button btn-sm">Confirm Reservation.</a>

                        <?php
                    } else {
                        ?>

                        <a href = "<?= WEB_PATH; ?>index.php" class = "btn btn-button me-md-2 mt-2">Home</a>
                        <?php
                    }
                    ?>
                </div>

            </div>

        </div>
    </div>

</main>


<?php include '../footer.php'; ?>







