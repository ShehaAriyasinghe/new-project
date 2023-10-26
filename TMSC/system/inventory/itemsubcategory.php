
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <?php
    //Extract inputs
    extract($_GET);
     extract($_POST);

    // delete itemcategory record
    if (@$mode == 'delete') {
        $upsql = "UPDATE tbl_itemsubcategories SET deletestatus='0' WHERE subcategoryid='$subcategoryid'";
        $db = dbconn();
        $result = $db->query($upsql);
    }
    ?>


    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Item Sub Category</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemsubcategory.php?categoryid=<?= @$categoryid; ?>" type="button" class="btn btn-sm btn-outline-secondary">Add Sub Categories</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>

    <h5>Item Sub Category List</h5>

    <?php
    //search reservation
    $where = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (!empty($subname)) {
            $where .= " s.subcategoryname LIKE '$subname%' AND";
        }


        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>


    <?php
    $db = dbconn();
    $sql = "SELECT c.categoryname,s.categoryid,s.subcategoryid,s.subcategoryname,s.adddate,s.deletestatus FROM tbl_itemsubcategories s INNER JOIN tbl_itemcategories c ON c.categoryid=s.categoryid WHERE s.deletestatus='1' AND c.categoryid=$categoryid $where";
    $result = $db->query($sql);
    ?> 


   



        <!--search bar-->
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="subname" placeholder="Sub Category Name" value="<?= @$subname; ?>">
                </div>

                <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>">
                <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
            </div>
                </form>


 <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>

                    <th scope="col">Sub Category</th>
                    <th scope="col">Category Name</th>

                    <th scope="col">Add Date</th>

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



                            <td><?php echo ucfirst($rows['subcategoryname']); ?></td>
                            <td><?php echo $rows['categoryname']; ?></td>
                            <td><?php echo $rows['adddate']; ?></td>


                            <td><a href="add_itembrand.php?categoryid=<?php echo $rows['categoryid'] ?>&subcategoryid=<?php echo $rows['subcategoryid'] ?>" class="btn btn-primary btn-sm">Add Brand</a></td>
                            <td><a href="edititemsubcategory.php?mode=edit&categoryid=<?= $categoryid ?>&subcategoryid=<?php echo $rows['subcategoryid'] ?>" class="btn btn-primary btn-sm">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="itemsubcategory.php?mode=delete&subcategoryid=<?= $rows['subcategoryid'] ?>&categoryid=<?= $categoryid ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
