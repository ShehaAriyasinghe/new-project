<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Successfully updated job card.</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all reservations</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>


    <h6>Updated Vehicle Jobcard</h6>
<?php

extract($_GET);

?>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-box px-5" style="width: 40rem;">

                <div class="text-center card-header my-card-heading mb-3 px-1">
                    <p class="display-6">Job card is successfully Updated.</p>
                </div>
                <div class="card-body">
                    <h6 class="">Customer Name: <?php echo $customername; ?> </h6>
                    <h6 class="">Vehicle Plate No: <?php echo $plateno; ?></h6>
                    <h6 class="">Service Date: <?php echo $servicedate;?></h6>
                    

                    <h6 class="">Service Time: <?php echo $servicetime; ?></h6>
                    

                    <a href="<?= SYSTEM_PATH; ?>index.php" class="btn btn-primary">Dashboard</a>
                </div>

            </div>

        </div>
    </div>







</main>
<?php include '../footer.php'; ?>