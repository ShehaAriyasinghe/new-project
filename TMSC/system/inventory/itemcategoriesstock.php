<?php
include '../header.php';
include '../menu.php';
?>


</head>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Vehicles Brands</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemcatalog.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Catalog</a>
                
            </div>
            
        </div>
    </div>

    <?php
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

                                <a class="btn btn-primary" href="itemstock.php?categoryid=<?= $row['categoryid']; ?>">Click</a>

                            </div>
                        </div>
                    </div>
                 
               
           
            <?php
        }
    }
    ?>
 </div>

</main>




<?php include '../footer.php'; ?>