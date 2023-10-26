<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer feed backs</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">


            </div>

        </div>
    </div>
    <?php
    extract($_GET);

    if (@$mode == 'delete') {
        $sql1 = "UPDATE tbl_feedbacks SET deletestatus='0' WHERE feedbackid='$feedbackid'";
        $db = dbConn();
        $result = $db->query($sql1);
    }

    if (@$mode == 'show') {
        $sql1 = "UPDATE tbl_feedbacks SET displaystatus='show' WHERE feedbackid='$feedbackid'";
        $db = dbConn();
        $result = $db->query($sql1);
    }

    
    if (@$mode == 'none') {
        $sql2 = "UPDATE tbl_feedbacks SET displaystatus='none' WHERE feedbackid='$feedbackid'";
        $db = dbConn();
        $result = $db->query($sql2);
    }




 
  

    $sql = "SELECT customername,feedback,feedbackid,displaystatus,adddate FROM tbl_feedbacks WHERE deletestatus='1'";
    $db = dbConn();
    $result = $db->query($sql);
    ?>

    <div class="card my-card-bg px-2"> 
        <div class="table-responsive">
            <!-- View of All job cards -->
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Customer name</th>
                        <th>feedback</th>
                        <th>Display status</th>                        
                        <th>Date</th>


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


                                <td><?php echo $rows['customername']; ?></td>

                                <td> <?php echo $rows['feedback']; ?></td>
                                <td> <?php echo $rows['displaystatus']; ?></td>
                                <td><?php echo $rows['adddate']; ?></td>


                                <td><a href="<?= SYSTEM_PATH ?>feedbacks/viewfeedbacks.php?mode=show&feedbackid=<?php echo $rows['feedbackid'] ?>" class="btn card-btn  btn-sm">Show</a></td>
                                 <td><a href="<?= SYSTEM_PATH ?>feedbacks/viewfeedbacks.php?mode=none&feedbackid=<?php echo $rows['feedbackid'] ?>" class="btn card-btn  btn-sm">None</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this vehicle ?');" href="<?= SYSTEM_PATH ?>feedbacks/viewfeedbacks.php?mode=delete&feedbackid=<?php echo $rows['feedbackid'] ?>" class="btn card-btn  btn-sm">Cancel</a></td>
                            </tr>


                            <?php
                        }
                    }
                    ?>



                </tbody>
            </table>

            </main>    




            <?php include '../footer.php'; ?>

            ?>

