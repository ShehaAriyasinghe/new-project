<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer Feedback</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= WEB_PATH; ?>feedback/addfeedback.php" type="button" class="btn btn-sm btn-outline-secondary mx-4">Add feedback</a>

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


    $adddate = date('Y-m-d');
    $adduser = $_SESSION['customer_userid'];

    $sql = "SELECT customername,feedback,feedbackid,adddate FROM tbl_feedbacks WHERE userid='$adduser' AND deletestatus='1'";
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
                        <th>Date</th>


                        <th>Action</th>


                    </tr>
                </thead>
                <tbody>



                    <?php
                    
                    if($result->num_rows > 0){
                    
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>


                            <td><?php echo $rows['customername']; ?></td>

                            <td> <?php echo $rows['feedback']; ?></td>
                            <td><?php echo $rows['adddate']; ?></td>



                            <td><a onclick="return confirm('Are you sure you want to delete this vehicle ?');" href="<?= WEB_PATH ?>feedback/viewfeedback.php?mode=delete&feedbackid=<?php echo $rows['feedbackid'] ?>" class="btn card-btn  btn-sm">Cancel</a></td>
                        </tr>


                        <?php
                    }
                    }
                    ?>



                </tbody>
            </table>

            </main>    




            <?php
            include '../customerfooter.php';
            ?>

