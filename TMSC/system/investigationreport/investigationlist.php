<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Investigation report Management</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>investigationreport/create_investigationreport.php" type="button" class="btn btn-sm btn-outline-secondary">Create investigation task</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>

    <h6>Investigation Task List</h6>

    <?php
    //Extract inputs
    extract($_GET);
    // delete tasks
    if (@$mode == 'delete') {
        $db = dbconn();
        $upsql = "UPDATE tbl_investigationtasks SET deletestatus='0' WHERE investigationtaskid='$investigationtaskid'";
        $result = $db->query($upsql);
    }
    ?>



    <div class="table-responsive">
        <?php
        $db = dbconn();
        $sql = "SELECT * FROM tbl_investigationtasks WHERE deletestatus='1'";
        $result = $db->query($sql);
        ?> 

        <table class="table table-striped table-sm">
            <thead>
                <tr>

                    <th scope="col">Task Name</th>


                    <th scope="col">Add Date</th>

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


                            <td><?php echo $rows['taskname']; ?></td>            
                            <td><?php echo $rows['adddate']; ?></td>
                            <td><a href="editinvestigationlist.php?mode=edit&investigationtaskid=<?php echo $rows['investigationtaskid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="investigationlist.php?mode=delete&investigationtaskid=<?php echo $rows['investigationtaskid'] ?>" class="btn btn-danger">Delete</a></td>
                        </tr>


                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>

</main>
<?php
include '../footer.php';
?>