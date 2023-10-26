
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Vehicles</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>vehicles/addvehicle.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Vehicles</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>
    <h6>Vehicles</h6>

    <?php
    extract($_GET);
    $db = dbconn();

    // delete vehicle record
    if (@$mode == 'delete') {
        $delsql = "UPDATE tbl_centervehicles SET deletestatus='0' WHERE vehicleid='$vehicleid'";
        
        $result = $db->query($delsql);
        
        
    }




    //View user record
    if (@$mode == 'view') {
        
        $viewsql = "SELECT v.vehicleid,v.color,v.brandid,v.modelid,v.vehicleimage,v.deletestatus,b.brandid,b.brandname,m.modelid,m.modelname,m.vehicletype FROM tbl_centervehicles v INNER JOIN tbl_brands b ON B.brandid=v.brandid INNER JOIN tbl_models m ON m.modelid=v.modelid WHERE v.vehicleid='$vehicleid' AND v.deletestatus=1";
        $result = $db->query($viewsql);
        $row = $result->fetch_assoc();

       
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="row">
                <div class="col-md-8">
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Model Name:</label>
                        <input type="text" name="modelname" class="form-control form-control-sm" value='<?php echo @$row['modelname']; ?>'  readonly>  
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Name:</label>
                        <input type="text" name="brandname" class="form-control form-control-sm" value='<?php echo @$row['brandname']; ?>'  readonly>  
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Vehicle Type:</label>
                        <input type="text" name="vehicletype" class="form-control form-control-sm" value='<?php echo @$row['vehicletype']; ?>' readonly>           
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="img-fluid" src="<?= SYSTEM_PATH ?>vehicles/images/<?= !empty($row['vehicleimage']) ? @$row['vehicleimage'] : 'noimage.jpeg' ?>">
                </div>    
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Color:</label>
                        <input type="text" name="color" class="form-control form-control-sm" value='<?php echo @$row['color'] ?>' readonly>
                        
                    </div>
                    

                </div>
                
            </div>
            <a href="vehiclebrandcards.php" class="btn btn-primary">View all vehicles</a>
        </form>

        <?php
    } else {
        ?>
        <div class="table-responsive">
            <?php
            $db = dbconn();
            $sql = "SELECT v.vehicleid,v.color,v.brandid as vbrand,v.modelid,v.vehicleimage,v.deletestatus,b.brandid,b.brandname,m.modelid,m.modelname,m.vehicletype FROM tbl_centervehicles v INNER JOIN tbl_brands b ON b.brandid=v.brandid INNER JOIN tbl_models m ON m.modelid=v.modelid WHERE v.deletestatus='1' AND v.brandid='$brandid' AND m.vehicletype='$vehicletype' ORDER BY m.modelname ";
            $result = $db->query($sql);
            ?>    
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        
                        <th scope="col">Model Name</th>
                        <th scope="col">Brand Name</th>
                        <th>Color</th>
                        <th>Vehicle Image</th>
                        <th>Vehicle Type</th>

                        <th>Action</th>
                        <th >Action</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($rows = $result->fetch_assoc()) {
                            ?>
                            <tr>                              
                                <td><?php echo $rows['modelname']; ?></td>
                                <td><?php echo $rows['brandname']; ?></td>
                                <td><?php echo $rows['color']; ?></td>
                                <td><img class="img-fluid" src="<?= SYSTEM_PATH ?>vehicles/images/<?= !empty($rows['vehicleimage']) ? $rows['vehicleimage'] : 'noimage.jpeg' ?>"></td>
                                <td><?php echo $rows['vehicletype']; ?></td>
                                
                                <td><a href="vehicles.php?mode=view&vehicleid=<?php echo $rows['vehicleid'] ?>" class="btn btn-primary btn">View</a></td>    
                                <td><a href="editvehicles.php?mode=edit&vehicleid=<?php echo $rows['vehicleid'] ?>" class="btn btn-primary">Edit</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="vehicles.php?mode=delete&vehicleid=<?php echo $rows['vehicleid']?>&brandid=<?= $rows['vbrand']?>&vehicletype=<?= $rows['vehicletype']?>" class="btn btn-danger">Delete</a></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
        <?php
    }
    ?>
</main>
<?php include '../footer.php'; ?>

