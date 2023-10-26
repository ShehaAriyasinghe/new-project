<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
    //Extract inputs
    extract($_GET);
    // delete user role
    if (@$mode == 'delete') {
        $db = dbconn();
        $upsql = "UPDATE tbl_displaycarousel SET deletestatus='0' WHERE carouselid='$carouselid'";
        $result = $db->query($upsql);
        
    }
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage carousel</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/addcarousel.php" type="button" class="btn btn-sm btn-outline-secondary">Add New carousel</a>
                
            </div>
        </div>
    </div>
    

    <h5>Display Carousel list</h5>
    <div class="table-responsive">
        <?php
        
        $db = dbconn();
        $sql = "SELECT * FROM tbl_displaycarousel WHERE deletestatus=1";
        $result = $db->query($sql);
        ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    
                    <th scope="col">Title</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    
                   
                 
                    <th>Action</th>
                    

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>


                            <td><?php echo $rows['title']; ?></td>
                           
                            <td><img class="img-fluid" height="150" width="150" src="<?= SYSTEM_PATH ?>services/images/<?= $rows['carouselimage'] ?>"></td>
                  
                            
                            <td><?php echo $rows['description']; ?></td>
                           
                     
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="viewcarousels.php?carouselid=<?=$rows['carouselid']?>&mode=delete" class="btn btn-danger">Delete</a></td>
                        </tr>


                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?>