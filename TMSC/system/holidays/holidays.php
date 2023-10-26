<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
    //Extract inputs
    extract($_GET);
    // delete user role
    if (@$mode == 'delete') {
        $db = dbconn();
        $upsql = "UPDATE tbl_holidays SET deletestatus='0' WHERE holidayid='$holidayid'";
        $result = $db->query($upsql);
        
    }
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Display Services</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>holidays/addholiday.php" type="button" class="btn btn-sm btn-outline-secondary">Add holiday</a>
                
            </div>
        </div>
    </div>
    

    <h5>Display Services list</h5>
    <div class="table-responsive">
        <?php
        
        $db = dbconn();
        $sql = "SELECT holidayid,title,holidaydate FROM tbl_holidays WHERE deletestatus=1";
        $result = $db->query($sql);
        ?>    
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    
                    <th scope="col">Title</th>
                    <th scope="col">Date</th>
                    
                    
                   
                 
                   
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
                           
                            <td><?php echo $rows['holidaydate'];  ?></td>
                           
                            
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="holidays.php?holidayid=<?=$rows['holidayid']?>&mode=delete" class="btn btn-danger">Delete</a></td>
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