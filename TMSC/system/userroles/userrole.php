
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job Roles</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>userroles/adduserrole.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Job Role</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>

    <?php
    //Extract inputs
    extract($_GET);
    // delete user role
    if (@$mode == 'delete') {
        $db = dbconn();
        $upsql = "UPDATE tbl_jobroles SET deletestatus='0' WHERE jobroleid='$jobroleid'";
        $result = $db->query($upsql);
    }
    ?>



    <h6>User Roles</h6>
    <div class="table-responsive">
    <?php
    $db = dbconn();
    $sql = "SELECT * FROM tbl_jobroles WHERE deletestatus=1";
    $result = $db->query($sql);
    ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Job Role</th>
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


                            <td><?php echo $rows['jobroleid']; ?></td>
                            <td><?php echo ucfirst($rows['jobrolename']); ?></td>
                            <td><?php echo $rows['adddate']; ?></td>

                            <td><a href="service_details.php?jobroleid=<?php echo $rows['jobroleid'] ?>" class="btn btn-primary btn">View</a></td>   
                            <td><a href="edituserrole.php?mode=edit&jobroleid=<?php echo $rows['jobroleid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="userrole.php?mode=delete&jobroleid=<?php echo $rows['jobroleid'] ?>" class="btn btn-danger">Delete</a></td>
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

