<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Successfully Updated.</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php" type="button" class="btn btn-sm btn-outline-secondary">View all reservations</a>
                
            </div>
            
        </div>
    </div>


    <h6>Updated customer reservation</h6>



    <div class="row">
        <div class="col-md-6">
            <div class="card card-box px-5" style="width: 40rem;">

                <div class="card-header">
                    <p class="display-6">Reservation is successfully updated.</p>
                </div>
                <div class="card-body">
                    <h6 class="">Reservation Date: <?php echo $_SESSION['reservation_date']; ?></h6>
                    <h6 class="">Bay: <?php echo ucfirst($_SESSION['bay']); ?></h6>

                    <h6 class="">Reservation Time: <?php echo $_SESSION['reservation_stime'] . "-" . $_SESSION['reservation_etime']; ?></h6>

                    <a href="<?= SYSTEM_PATH; ?>index.php" class="btn btn-primary">Dashboard</a>
                </div>

            </div>

        </div>
    </div>







</main>
<?php include '../footer.php'; ?>