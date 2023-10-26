<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer Dashboard</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= WEB_PATH; ?>vehicles/addvehicle.php" type="button" class="btn btn-sm btn-outline-secondary mx-4">Add new vehicle</a>

            </div>

        </div>
    </div>
    <?php
    //Extract inputs
    extract($_GET);
    ?>

    <div class="row">
        <div class="col-md-6 mt-2">
            <div class="card card-box px-5 my-card-bg" style="width: 40rem;">

                <div class="card-header my-card-heading">
                    <p class="display-6">Vehicle is successfully updated.</p>
                </div>
                <div class="card-body">
                    <h6 class="">Update Date: <?php echo $updatedate; ?></h6>
                    <h6 class="">Plate No: <?php echo $plateno; ?></h6>
                    <?php
                    $db = dbconn();
                    $sql = "SELECT plateimage from tbl_vehicles where vehicleid=$vehicleid";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    ?>
                    <img src="<?= WEB_PATH; ?>/vehicles/images/<?= $row['plateimage']; ?>" class="img-fluid" width="150" hight="50">
                </div>

                
            </div>
        </div>
    </div>
</main>





<?php
include '../customerfooter.php';
?>




