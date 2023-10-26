
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Employees</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>employees/addemployee.php" type="button" class="btn btn-sm btn-outline-secondary">Add Employees</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>



    <h6>All Employees</h6>

    <?php
    extract($_GET);
    $db = dbconn();

    // delete employee record
    if (@$mode == 'delete') {
        $upsql = "UPDATE tbl_employees SET deletestatus='0' WHERE employeeid='$employeeid'";
        $result = $db->query($upsql);
    }



    if (@$mode == 'view') {

        $viewsql = "SELECT * FROM tbl_employees WHERE employeeid='$employeeid' AND deletestatus='1'";
        $result = $db->query($viewsql);
        $row = $result->fetch_assoc();
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <legend>Person Details:</legend>


                            <label class="form-label">FirstName:</label>
                            <input type="text" name="firstname" class="form-control" value='<?php echo $row['firstname']; ?>' readonly>  

                        </div>
                        <div class="mb-3">
                            <label class="form-label">LastName:</label>
                            <input type="text" name="lastname" class="form-control" value='<?php echo $row['lastname']; ?>' readonly>  

                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIC:</label>
                            <input type="text" name="nic" class="form-control" value='<?php echo $row['nic']; ?>' readonly>  

                        </div>
                        



                    </div>
                    <div class="col-md-6 mt-2">


                        <img class="img-fluid" src="<?= SYSTEM_PATH ?>employees/images/<?= $row['image'] ?>">
                        
                         <div class="mb-3">
                            <label class="form-label">Designation:</label>
                            <input type="text" name="designation" class="form-control" value='<?php echo ucfirst($row['designation']); ?>' readonly>  

                        </div>


                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <legend>Contact Details:</legend>
                        <div class="mb-3">
                            <label class="form-label">Mobile:</label>
                            <input type="text" name="mobile" class="form-control" value='<?php echo $row['mobile']; ?>' readonly>  

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email:</label>
                            <input type="text" name="email" class="form-control" value='<?php echo $row['email']; ?>' readonly>  

                        </div>

                        <legend>Company Details</legend> 
                        <label class="form-label">Employee Join Date:</label>
                        <input type="text" name="joindate" class="form-control" value='<?php echo $row['joindate']; ?>' readonly>

                         <a href="<?= SYSTEM_PATH ?>employees/employee.php" class="btn btn-primary btn-sm mb-2 mt-2">All employees</a> 

                    </div>
                    <div class="col-md-6 mt-5">

                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <input type="text" name="address1" class="form-control" value='<?php echo $row['address1']; ?>' readonly>  
                            <?php
                            if (!empty($row['address2'])) {
                                ?>    
                                <input type="text" name="address2" class="form-control" value='<?php echo $row['address2']; ?>' readonly>
                                <?php
                            }
                            ?>
                            <input type="text" name="city" class="form-control" value='<?php echo $row['city']; ?>' readonly>
                        </div>
                        

                    </div>
                   
                </div>
            </div>
        </form>



        <?php
    } else {
        ?>

        <div class="table-responsive">
            <?php
            $db = dbconn();
            $sql = "SELECT * FROM tbl_employees WHERE deletestatus='1'";
            $result = $db->query($sql);
            ?>    
            <table class="table table-striped table-sm">
                <thead>
                    <tr>

                        <th>FirstName</th>
                        <th>LastName</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Address</th>
                        <th>Mobile</th>


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



                                <td><?php echo ucfirst($rows['firstname']); ?></td>
                                <td><?php echo ucfirst($rows['lastname']); ?></td>
                                <td><?php echo ucfirst($rows['designation']); ?></td>
                                <td><?php echo $rows['email']; ?></td>
                                <td><?php echo $rows['nic']; ?></td>
                                <td><?php echo $rows['address1'] . ", " . $rows['address2'] . " " . $rows['city'] . "."; ?></td>
                                <td><?php echo $rows['mobile']; ?></td>


                                <td><a href="employee.php?mode=view&employeeid=<?php echo $rows['employeeid'] ?>" class="btn btn-primary btn">View</a></td>    
                                <td><a href="editemployee.php?mode=edit&employeeid=<?php echo $rows['employeeid'] ?>" class="btn btn-primary">Edit</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="employee.php?mode=delete&employeeid=<?php echo $rows['employeeid'] ?>" class="btn btn-danger">Delete</a></td>
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

