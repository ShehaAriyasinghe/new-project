
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Services</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>services/service.php" type="button" class="btn btn-sm btn-outline-secondary">View Services</a>
               
            </div>
            
        </div>
    </div>



    <h5>Services list</h5>
    <div class="table-responsive">
        <?php
        extract($_GET);
        $db = dbconn();
        $sql = "SELECT s.serviceid,s.servicename,c.duration,c.subserviceprice,c.subservicename,s.deletestatus,c.subserviceid FROM tbl_services s INNER JOIN tbl_servicetasks t ON s.serviceid=t.serviceid INNER JOIN tbl_subservices c ON t.subserviceid=c.subserviceid WHERE s.serviceid='$serviceid' AND s.deletestatus=1";
        $result = $db->query($sql);
        ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>


                    <th>Duration</th>
                    <th>Sub service Price</th>

                    <th>Main Tasks</th>
                     <th></th>
                    <th>Sub Tasks List</th>
                   
                    



                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        $servicename=$rows['servicename'];
                        ?>
                        <tr>




                            <td><?php echo $rows['duration']; ?></td>
                            <td><?php echo $rows['subserviceprice']; ?></td>

                            <td><?php echo $rows['subservicename']; ?></td>
                          

                            <?php
                            $subserviceid = $rows['subserviceid'];
                            //view subservice task lists

                            $sql1 = "SELECT subt.taskname FROM tbl_subservicetasks subt LEFT JOIN tbl_subservices sub ON sub.subserviceid=subt.subserviceid WHERE subt.subserviceid=$subserviceid AND subt.deletestatus='1'";
                            $result1 = $db->query($sql1);
                            while ($row = $result1->fetch_assoc()) {
                                ?>
                          <td></td>
                                <td>
                                    <?php echo $row['taskname']; ?>
                                </td>
                                <?php
                            }
                            ?>

                            

                        </tr>






                        <?php
                    }
                    echo $servicename;
                }
                ?>

            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?>

