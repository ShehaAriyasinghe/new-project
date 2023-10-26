<?php
include '../header.php';
include '../menu.php';
?>

<script src="<?= SYSTEM_PATH; ?>assets/js/jquery-3.6.1.min.js"></script>
</head>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Vehicles Brands</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>vehicles/addvehicle.php" class="btn btn-sm btn-outline-secondary">Add New vehicle</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update  Product
            </button>
        </div>
    </div>

    <?php
    $db = dbconn();
    $viewsql = "SELECT brandid,brandname FROM tbl_brands WHERE deletestatus='1'";
    $result = $db->query($viewsql);
   
    ?>    


    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>

           
                <div class="row">
                    <div class="col-4">    
                        <div class="card my-card-bg">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['brandname']; ?></h5>

                                <a class="btn btn-primary" href="vehiclemodelcards.php?brandid=<?= $row['brandid']; ?>">Click</a>

                            </div>
                        </div>
                    </div>
                 
                </div>
           
            <?php
        }
    }
    ?>


</main>




<?php include '../footer.php'; ?>