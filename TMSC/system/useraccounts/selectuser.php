<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add User account </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>useraccounts/user.php" class="btn btn-sm btn-outline-secondary">View User Accounts</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update  Product
            </button>
        </div>
    </div>



    <form action="adduser.php" method="GET">

        <div class="mb-3">
            <?php
            $db = dbConn();
            $sql = "SELECT e.employeeid,e.firstname,e.lastname,e.userid,e.deletestatus,j.jobavailability FROM tbl_employees e INNER JOIN tbl_jobroles j ON e.designation=j.jobrolename WHERE e.userid='0' AND j.jobavailability='y' AND e.deletestatus=1";
            $result = $db->query($sql);
            ?>
            <label class="form-label">Select Employee Name :</label>
            <select class="form-select border-dark" name="employeeid" id="employee" value="<?php echo @$employeeid; ?>">
                <option value="">--</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <option value="<?php echo $row['employeeid']; ?>" <?php if (@$employee == $row['employeeid']) { ?> selected <?php } ?>><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></option>

                        <?php
                    }
                }
                ?>
            </select>
           
        </div>

        <div class="row justify-content-around">
            <div class="col-4">
                <input type="submit" class="btn btn-outline-primary" value="Create User Account">
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>useraccounts/selectuser.php" type="submit" class="btn btn-outline-primary">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>
