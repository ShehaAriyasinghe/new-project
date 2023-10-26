<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Materials</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            
            
        </div>
    </div>

    <h6>Service Materials All Categories</h6>

    <?php
    extract($_GET);

    $db = dbconn();
    $viewsql = "SELECT categoryid,categoryname FROM tbl_itemcategories WHERE deletestatus='1'";
    $result = $db->query($viewsql);
    ?>    
    <div class="row">

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>



                <div class="col-4">    
                    <div class="card my-card-bg">
                        <div class="card-body">
                            <h5 class="card-title"><?= ucfirst($row['categoryname']); ?></h5>

                            <a class="btn btn-primary" href="productview.php?categoryid=<?= $row['categoryid']; ?>&jobcardid=<?= $jobcardid; ?>&mode=assign">Add</a>

                        </div>
                    </div>
                </div>



                <?php
            }
        }
        ?>
        <div class="col-4">   
            <a class="btn btn-primary btn-sm" href="<?= SYSTEM_PATH?>jobcards/assign_materialsjobcard.php?jobcardid=<?= $jobcardid ?>&mode=<?= $mode ?>">Back to Job card</a>
        </div>
    </div>

</main>


<?php
include '../footer.php';
?>