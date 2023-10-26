<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Vehicle Management</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                

            </div>

        </div>
    </div>



    <?php
    
    extract($_GET);
    
    
        //search reservation
        $where = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (!empty($plateno)) {
                $where .= " v.plateno LIKE '$plateno%' AND";
            }

            if (!empty($modelname)) {
                $where .= " m.modelname LIKE '$modelname%' AND";
            }


            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = " AND $where";
            }
        }
        
?>
        
        
          <!--search bar-->
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="plateno" placeholder="Plate no" value="<?= @$plateno; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="modelname" placeholder="Model name" value="<?= @$modelname; ?>">
                </div>
                
                


                <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
            </div>
                </form>
        
        
       

    
<?php    
    //all vehicles relevent customer

    
    $sql = "SELECT v.vehicleid,v.plateno,v.plateimage,v.year,m.vehicletype,m.modelname,b.brandname FROM tbl_jobcards j LEFT JOIN tbl_vehicles v ON j.vehicleid=v.vehicleid INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus=1 AND j.jobcardstatus='finished' $where GROUP BY vehicleid";
    $db = dbconn();
    $result = $db->query($sql);
    ?>    
    <div class="card my-card-bg px-2"> 
        <div class="table-responsive">
            <!-- View of All job cards -->
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Plate No</th>
                        <th>Vehicle Image</th>
                        <th>Year</th>
                        <th>Vehicle type</th>

                        <th>Model name</th>
                        <th>Brand name</th>


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


                                <td><?php echo $rows['plateno']; ?></td>
                                <td><img width="150" height="150" src="<?= WEB_PATH ?>vehicles/images/<?= $rows['plateimage']; ?>"></td>
                                <td> <?php echo $rows['year']; ?></td>
                                <td><?php echo $rows['vehicletype']; ?></td>
                                <td><?php echo $rows['modelname']; ?></td>
                                <td><?php echo $rows['brandname']; ?></td>


                               

                                <td><a href="<?= SYSTEM_PATH ?>vehicles/view_vehiclejobcards.php?vehicleid=<?php echo $rows['vehicleid']  ?>" class="btn card-btn  btn-sm">View Jobs</a></td>
                                
                                 <td><a href="<?= SYSTEM_PATH ?>vehicles/view_vehiclerecommendation.php?vehicleid=<?php echo $rows['vehicleid']  ?>" class="btn card-btn  btn-sm">Recommendation</a></td>

                                
                            </tr>


                            <?php
                        }
                    } else {
                        echo "<div class='alert alert-danger'>" . "There are no vehicles" . "</div>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>    
</main>




<?php include '../footer.php'; ?>


