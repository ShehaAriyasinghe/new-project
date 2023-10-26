
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
    //Extract inputs
    extract($_GET);
    // delete user role
    if (@$mode == 'delete') {
        $db = dbconn();
        $upsql = "UPDATE tbl_services SET deletestatus='0' WHERE serviceid='$serviceid'";
        $result = $db->query($upsql);
        
        $upsql1 = "UPDATE tbl_servicetasks SET deletestatus='0' WHERE serviceid='$serviceid'";
        $result = $db->query($upsql1);
    }
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Services</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/add.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Service</a>
                
            </div>
            
        </div>
    </div>
    

    <h5>Services list</h5>
    <div class="table-responsive">
        <?php
        //unset service session array
        unset($_SESSION['service']);
        
        $db = dbconn();
        $sql = "SELECT * FROM tbl_services WHERE deletestatus=1";
        $result = $db->query($sql);
        ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Service Name</th>
                    <th scope="col">Service Price(Rs.)</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Minute</th>
                   
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


                            <td><?php echo $rows['serviceid']; ?></td>
                            <td><?php echo $rows['servicename']; ?></td>
                            <td><?php echo $rows['serviceprice']; ?></td>
                            <td> <?php
                            $time="+".$rows['duration'];
                            echo $time=date('H:i',strtotime($time,strtotime("00:00")));
                   
                            ?></td>
                            <td><?php echo $rows['duration'];  ?></td>
                            
                            
                           
                            <td><a href="service_details.php?serviceid=<?php echo $rows['serviceid'] ?>" class="btn btn-primary btn">View</a></td>   
                            <td><a href="editservice.php?mode=edit&serviceid=<?php echo $rows['serviceid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="service.php?mode=delete&serviceid=<?php echo $rows['serviceid'] ?>" class="btn btn-danger">Delete</a></td>
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

