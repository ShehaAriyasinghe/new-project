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
                    <p class="display-6">Reservation is successfully Created.</p>
                </div>
                <div class="card-body">
                    <h6 class="">Reservation Date: <?php echo $servicedate; ?></h6>
                    <h6 class="">Bay: <?php echo ucfirst($bay); ?></h6>

                    <h6 class="">Reservation Time: <?php echo $starttime . "-" . $endtime; ?></h6>

                    <a href="<?= WEB_PATH; ?>index.php" class="btn card-btn">Home</a>
                </div>

            </div>
            
            
        </div>

    </div>

</main>


<?php include '../footer.php'; ?>







