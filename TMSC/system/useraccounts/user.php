
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage User Accounts</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>useraccounts/selectuser.php" type="button" class="btn btn-sm btn-outline-secondary">Add New User Accounts</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>
    <h6>Users</h6>

    <?php
    //Extract inputs
    extract($_GET);
    //call db connection
    $db = dbconn();

    // delete user record
    if (@$mode == 'delete') {
        $delsql = "UPDATE tbl_users SET deletestatus='0',accountstatus='inactive' WHERE userid='$userid'";
        $result = $db->query($delsql);

        $delsql1 = "UPDATE tbl_employees SET userid='0' WHERE userid='$userid'";
        $result1 = $db->query($delsql1);
    }

    //View user record
    if (@$mode == 'view') {

        $viewsql = "SELECT u.userid,e.firstname,e.lastname,e.image,e.mobile,u.userrole,u.username,u.accountstatus,u.adddate FROM tbl_users u INNER JOIN tbl_employees e ON u.userid=e.userid WHERE u.userid='$userid' AND u.deletestatus=1";
        $result = $db->query($viewsql);
        $row = $result->fetch_assoc();

        $accountstatus = $row['accountstatus'];
        $userrole = $row['userrole'];
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">FirstName:</label>
                        <input type="text" name="firstname" class="form-control form-control-sm" value='<?php echo $row['firstname']; ?>' id="firstname" readonly>  
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">LastName:</label>
                        <input type="text" name="lastname" class="form-control form-control-sm" value='<?php echo $row['lastname']; ?>' id="lastname" readonly>  
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile:</label>
                        <input type="text" name="mobile" class="form-control form-control-sm" value='<?php echo $row['mobile']; ?>' id="mobile" readonly>           
                    </div>
                </div>
                <div class="col-md-4">
                    <img class="img-fluid" src="<?= SYSTEM_PATH ?>employees/images/<?= !empty($row['image']) ? $row['image'] : 'noimage.jpeg' ?>">
                </div>    
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control form-control-sm" value='<?php echo $row['username'] ?>' id="email" readonly>
                        <div class="text-danger"><?php echo @$messages['error_email']; ?></div>
                    </div>
                    <?php
                    $db = dbConn();
                    $sql1 = "SELECT jobroleid,jobrolename FROM tbl_jobroles";
                    $result1 = $db->query($sql1);
                    ?>
                    <label class="form-label">Select Jobrole :</label>
                    <select class="form-select border-dark" name="jobrole" id="jobrole">
                        <option value="">--</option>
                        <?php
                        if ($result1->num_rows > 0) {
                            while ($row1 = $result1->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $row1['jobrolename']; ?>" <?php if (@$userrole == $row1['jobrolename']) { ?> selected <?php } ?> disabled><?php echo ucfirst($row1['jobrolename']); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php echo @$messages['error_jobrole']; ?></div>

                </div>
                <div class="col-md-4">

                    <div class="mb-3">
                        <label>Account status:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accountstatus" id="active" value="active" <?php if (isset($accountstatus) && $accountstatus == 'active') { ?> checked <?php } ?> >
                            <label class="form-check-label" for="active">
                                Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accountstatus" id="inactive" value="inactive" <?php if (isset($accountstatus) && $accountstatus == 'inactive') { ?> checked <?php } ?>>
                            <label class="form-check-label" for="inactive">
                                Inactive
                            </label>
                        </div>

                        <div class="text-danger"><?php echo @$messages['error_status']; ?></div>
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
            $sql = "SELECT u.userid,e.firstname,e.lastname,u.userrole,u.username,u.accountstatus,u.adddate FROM tbl_users u INNER JOIN tbl_employees e ON u.userid=e.userid WHERE u.userrole != 'customer' AND u.deletestatus=1";
            $result = $db->query($sql);
            ?>    
            <table class="table table-striped table-sm">
                <thead>
                    <tr>

                        <th scope="col">FirstName</th>
                        <th scope="col">LastName</th>
                        <th>Designation</th>
                        <th>Username</th>


                        <th>AccountStatus</th>
                        <th>CreatedDate</th>

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
                                <td><?php echo $rows['firstname']; ?></td>
                                <td><?php echo $rows['lastname']; ?></td>
                                <td><?php echo ucfirst($rows['userrole']); ?></td>
                                <td><?php echo $rows['username']; ?></td>
                                <td><?php echo ucfirst($rows['accountstatus']); ?></td>
                                <td><?php echo $rows['adddate']; ?></td>
                                <td><a href="user.php?mode=view&userid=<?php echo $rows['userid'] ?>" class="btn btn-primary btn">View</a></td>    
                                <td><a href="edituser.php?mode=edit&userid=<?php echo $rows['userid'] ?>" class="btn btn-primary">Edit</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="user.php?mode=delete&userid=<?php echo $rows['userid'] ?>" class="btn btn-danger">Delete</a></td>
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

