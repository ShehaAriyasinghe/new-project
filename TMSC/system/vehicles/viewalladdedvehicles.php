<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">All Vehicle Management</h6>
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



    <?php
    extract($_GET);
    if (@$mode == 'view') {
        ?>


        <?php
        $sqltbl = "SELECT c.firstname,c.lastname,c.nic,c.mobile,c.address1,c.address2,c.city,c.email,v.vehicleid,v.plateno,v.plateimage,v.year,v.brandid,v.modelid FROM tbl_vehicles v INNER JOIN tbl_customers c ON c.userid=v.adduser WHERE v.deletestatus='1' AND vehicleid='$vehicle'";
        $db = dbconn();
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();

        $brandid = $row['brandid'];
        $modelid = $row['modelid'];

        $sql1 = "SELECT brandname FROM tbl_brands WHERE brandid= $brandid";
        $result1 = $db->query($sql1);
        $row1 = $result1->fetch_assoc();

        $sql2 = "SELECT modelname,vehicletype FROM tbl_models WHERE modelid= $modelid";
        $result2 = $db->query($sql2);
        $row2 = $result2->fetch_assoc();
        ?>



        <div class="card px-md-4 mb-2 my-card-bg">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <legend>Person Details:</legend>


                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" name="firstname" class="form-control" value='<?php echo $row['firstname']; ?>' readonly>  

                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" name="lastname" class="form-control" value='<?php echo $row['lastname']; ?>' readonly>  

                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Mobile:</label>
                        <input type="text" name="mobile" class="form-control" value='<?php echo $row['mobile']; ?>' readonly>  

                    </div>

                    <div class="mb-3 form-control">
                        <label for="lastname" class="form-label">Address:</label><br>
                        <?php
                        echo $row['address1'] . "<br>" . $row['address2'] . "<br>" . $row['city'];
                        ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="lastname" class="form-label">NIC:</label>
                        <input type="text" name="nic" class="form-control" value='<?php echo $row['nic']; ?>' readonly>  

                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Email:</label>
                        <input type="text" name="email" class="form-control" value='<?php echo $row['email']; ?>' readonly>  

                    </div>





                </div>
                <div class="col-md-4 mt-2">
                    <img class="img-fluid" src="<?= WEB_PATH ?>vehicles/images/<?= $row['plateimage'] ?>">

                </div>    
            </div> 
        </div>    
        <div class="card px-md-4 mb-2 my-card-bg">
            <div class="row">

                <div class="col-md-6"> 

                    <legend>Vehicle Details:</legend>
                    <div class="mb-3">
                        <label class="form-label">Plate No</label>
                        <input type="text" name="brand" class="form-control" value='<?php echo $row['plateno']; ?>'readonly >

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="text" name="year" class="form-control" value='<?php echo $row['year']; ?>'readonly >

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Brand Name</label>
                        <input type="text" name="brand" class="form-control" value='<?php echo $row1['brandname']; ?>'readonly >

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Model Name</label>
                        <input type="text" name="model" class="form-control" value='<?php echo $row2['modelname']; ?>'readonly >

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <input type="text" name="vtype" class="form-control" value='<?php echo $row2['vehicletype']; ?>'readonly >

                    </div> 


                    <a href='<?= SYSTEM_PATH ?>vehicles/viewalladdedvehicles.php' class='btn btn-primary mb-2 '>Back</a>
                </div>


                <?php
            } else {
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


                $sql = "SELECT v.vehicleid,v.plateno,v.plateimage,v.year,m.vehicletype,m.modelname,b.brandname,c.firstname,c.lastname FROM tbl_vehicles v INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid INNER JOIN tbl_customers c ON c.userid=v.adduser WHERE v.deletestatus=1 $where";
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
                                    <th>Customer name</th>


                                    <th>Action</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = $result->num_rows;
                                if ($count > 0) {
                                    while ($rows = $result->fetch_assoc()) {
                                        ?>
                                        <tr>


                                            <td><?php echo $rows['plateno']; ?></td>
                                            <td><img width="150" height="150" src="<?= WEB_PATH ?>vehicles/images/<?= $rows['plateimage']; ?>"></td>
                                            <td> <?php echo $rows['year']; ?></td>
                                            <td><?php echo $rows['vehicletype']; ?></td>
                                            <td><?php echo $rows['modelname']; ?></td>
                                            <td><?php echo $rows['brandname']; ?></td>
                                            <td><?php echo $rows['firstname'] . " " . $rows['lastname']; ?></td>



                                            <td><a href="<?= SYSTEM_PATH ?>vehicles/viewalladdedvehicles.php?mode=view&vehicle=<?php echo $rows['vehicleid'] ?>" class="btn card-btn  btn-sm">view</a></td>

                                            <?php
                                            if ($_SESSION['userrole'] == "cashier") {
                                                ?>
                                                <td><a href="<?= SYSTEM_PATH ?>reservations/customer_reservation.php?vehicle=<?php echo $rows['vehicleid'] ?>" class="btn card-btn  btn-sm">Get Reservation</a></td>
                                                <?php
                                            }
                                            ?>


                                        </tr>


                                        <?php
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>" . "There are no vehicles" . "</div>";
                                }
                                ?>
                                <tr>
                                    <td colspan="2">Total count:</td>
                                    <td><?= $count ?></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>    
                <?php
            }
            ?>


            </main>




            <?php include '../footer.php'; ?>


