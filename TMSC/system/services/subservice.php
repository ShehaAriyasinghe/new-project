
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<?php
    //Extract inputs
    extract($_GET);
    
    // delete user role
    if (@$mode == 'delete') {
        $db = dbconn();
        $upsql = "UPDATE tbl_subservices SET deletestatus='0' WHERE subserviceid='$subserviceid'";
        $result = $db->query($upsql);
        
        
        $upsql1 = "UPDATE tbl_subservicetasks SET deletestatus='0' WHERE subserviceid='$subserviceid'";
        $result = $db->query($upsql1);
        
    }
    ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Sub Services</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/addsub.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Sub Service</a>
                
            </div>
            
        </div>
    </div>



    <h5>Sub Services list</h5>
    <div class="table-responsive">
        <?php
        //unset subservicetask session array
        unset($_SESSION['subservicetask']);
        $db = dbconn();
        $sql = "SELECT s.subserviceid,s.subservicename,s.subserviceprice,s.duration,s.deletestatus,t.taskname FROM tbl_subservices s INNER JOIN tbl_subservicetasks t ON t.subserviceid=s.subserviceid WHERE s.deletestatus=1 GROUP BY s.subserviceid";
        $result = $db->query($sql);
        ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Sub Service Name</th>
                    <th scope="col">Service Price(Rs.)</th>
                    <th scope="col">Duration</th>
                  
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


                            <td><?php echo $rows['subserviceid']; ?></td>
                            <td><?php echo $rows['subservicename']; ?></td>
                            <td><?php echo $rows['subserviceprice']; ?></td>
                            <td><?php echo $rows['duration']; ?></td>
                            
                            <td><a href="subservice_details.php?subserviceid=<?php echo $rows['subserviceid'] ?>" class="btn btn-primary btn">View</a></td>   
                            <td><a href="editsub.php?mode=edit&subserviceid=<?php echo $rows['subserviceid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="subservice.php?mode=delete&subserviceid=<?php echo $rows['subserviceid'] ?>" class="btn btn-danger">Delete</a></td>
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

