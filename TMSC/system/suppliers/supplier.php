<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Manage Suppliers</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>suppliers/addsupplier.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Supplier</a>

            </div>

        </div>
    </div>



    <h6>Supplier list</h6>

    <?php
    
    unset($_SESSION['items']);
    extract($_GET);
    // delete supplier record
    if (@$mode == 'delete') {
        $delsql = "UPDATE tbl_suppliers SET deletestatus='0' WHERE supplierid='$supplierid'";
        $db = dbconn();
        $result = $db->query($delsql);
    }


//search suppliers
    $where = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (!empty($companyname)) {
            $where .= " companyname LIKE '$companyname%' AND";
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

                <input type="text" class="form-control" name="companyname" placeholder="companyname" value="<?= @$companyname; ?>">
            </div>



            <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
        </div>
            </form>






    <?php
    $db = dbconn();
    $sql = "SELECT * FROM tbl_suppliers WHERE deletestatus='1' $where";
    $result = $db->query($sql);
    ?>    
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>

                    <th>Company Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>

                    <th>Mobile</th>
                    <th>Email</th>


                    <th>Credit Limit</th>

                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                        <tr>



                            <td><?php echo $rows['companyname']; ?></td>
                            <td><?php echo $rows['firstname']; ?></td>
                            <td><?php echo $rows['lastname']; ?></td>

                            <td><?php echo $rows['mobile']; ?></td>
                            <td><?php echo $rows['email']; ?></td>


                            <td><?php echo $rows['creditlimit']; ?></td>




                            <td><a href="supplier_details.php?supplierid=<?php echo $rows['supplierid'] ?>" class="btn btn-primary btn">View</a></td>   
                            <td><a href="edit_supplier.php?mode=edit&supplierid=<?php echo $rows['supplierid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="supplier.php?mode=delete&supplierid=<?php echo $rows['supplierid'] ?>" class="btn btn-danger">Delete</a></td>


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


