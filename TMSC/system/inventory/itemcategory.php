
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Item Category</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemcategory.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Category</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>
<?php
    extract($_GET);
    $db = dbconn();

    // delete itemcategory record
    if (@$mode == 'delete') {
        $upsql = "UPDATE tbl_itemcategories SET deletestatus='0' WHERE categoryid='$categoryid'";
        $result = $db->query($upsql);
    }
    
    ?>


    <h5>Item Category List</h5>
    <div class="table-responsive">
        <?php
        $db = dbconn();
        $sql = "SELECT * FROM tbl_itemcategories WHERE deletestatus='1'";
        $result = $db->query($sql);
        ?> 

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Add Date</th>
                    
                    <th>Action</th>
                    <th>Action</th>
                    <th>Action</th>
                    

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>


                            <td><?php echo $rows['categoryid']; ?></td>
                            <td><?php echo $rows['categoryname']; ?></td>
                            <td><?php echo $rows['adddate']; ?></td>
                            
                            <td><a href="add_itemsubcategory.php?categoryid=<?php echo $rows['categoryid'] ?>" class="btn btn-primary">Add Sub Category</a></td>
                            
                            <td><a href="edititemcategory.php?mode=edit&categoryid=<?php echo $rows['categoryid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="itemcategory.php?mode=delete&categoryid=<?php echo $rows['categoryid'] ?>" class="btn btn-danger">Delete</a></td>
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