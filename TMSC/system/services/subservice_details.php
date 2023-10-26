
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Sub Services</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/subservice.php" type="button" class="btn btn-sm btn-outline-secondary">View Sub Services</a>
                
            </div>
            
        </div>
    </div>



    <h5>Services list</h5>
    <div class="table-responsive">
        <?php
        extract($_GET);
        $db = dbconn();
   
        $sql = "SELECT t.subserviceid,s.subservicename,s.duration,s.deletestatus,t.taskname FROM tbl_subservices s INNER JOIN tbl_subservicetasks t ON t.subserviceid=s.subserviceid WHERE t.subserviceid='$subserviceid' AND s.deletestatus=1";
        $result = $db->query($sql);
        ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    
                    <th>Duration</th>
                    <th>Task List</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                   while ($rows = $result->fetch_assoc()) {
                       $subservicename=$rows['subservicename'];
                        ?>
                        <tr>


                          
                            <td><?php echo $rows['duration']; ?></td>
                            <td><?php echo $rows['taskname']; ?></td>
                           
                            
                            
                        </tr>


                        <?php
                    
                }
                echo $subservicename;
                }
                ?>

            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?>

