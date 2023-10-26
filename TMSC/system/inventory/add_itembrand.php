<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Item Brand</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="itemcategory.php" class="btn btn-sm btn-outline-secondary">All Item Categories</a>

            </div>

        </div>
    </div>

    <?php
    //Extract inputs
    extract($_GET);

    if (@$mode == 'delete') {
        $upsql = "UPDATE tbl_itembrands SET deletestatus='0' WHERE brandid='$brandid'";
        $db = dbconn();
        $result = $db->query($upsql);
    }



    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $brandname = cleanInput($brandname);

        //Create array
        $messages = array();

        // empty validations
        if (empty($brandname)) {
            $messages['error_brandname'] = "The Brand Name should not be empty..!";
        }


        //advance validations

        if (!empty($brandname)) {
            $sql = "SELECT * FROM tbl_itembrands WHERE brandname='$brandname' AND subcategoryid=$subcategoryid AND deletestatus='1'";
            $db = dbconn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_brandname'] = "The Brand name already exists..!";
            }
        }


        if (!empty($brandname)) {
            if (!preg_match('/^[a-z ]+$/i', $brandname)) {
                $messages['error_brandname'] = "The Brand name is allowed letters and white spaces only.";
            }
        }


        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "INSERT INTO tbl_itembrands(categoryid,subcategoryid,brandname,adddate,adduser) VALUES ('$categoryid','$subcategoryid','$brandname','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>" >
        <input type="hidden" name="subcategoryid" value="<?= @$subcategoryid; ?>" >



        <div class="mb-3">

            <label for="brandid" class="form-label">Brand Name</label>
            <input type="text" class="form-control w-75" id="brandid" name="brandname" value="<?= @$brandname; ?>" >
            <div class="text-danger"><?php echo @$messages['error_brandname']; ?></div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/itemcategory.php" class="btn btn-outline-primary ">Back</a>
            </div>
        </div>

    </form>



    <h5 class="mt-4">Item Brand List</h5>
    <div class="table-responsive">
<?php
$db = dbconn();
$sql = "SELECT c.categoryname,b.brandid,b.brandname,b.brandid,s.subcategoryid,s.subcategoryname,b.adddate,s.deletestatus FROM tbl_itemsubcategories s INNER JOIN tbl_itemcategories c ON c.categoryid=s.categoryid INNER JOIN tbl_itembrands b ON b.subcategoryid=s.subcategoryid  WHERE b.deletestatus='1' AND s.subcategoryid=$subcategoryid";
$result = $db->query($sql);
?> 

        <table class="table table-striped table-sm">
            <thead>
                <tr>

                    <th scope="col">Brand Name</th>
                    <th scope="col">Sub Category Name</th>

                    <th scope="col">Category Name</th>

                    <th scope="col">Add Date</th>

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

                            <td><?php echo $rows['brandname']; ?></td>                                           
                            <td><?php echo $rows['subcategoryname']; ?></td>            
                            <td><?php echo $rows['categoryname']; ?></td>
                            <td><?php echo $rows['adddate']; ?></td>



                            <td><a href="edititembrand.php?mode=edit&categoryid=<?= $categoryid ?>&subcategoryid=<?= $rows['subcategoryid'] ?>&brandid=<?= $rows['brandid'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="add_itembrand.php?mode=delete&subcategoryid=<?= $rows['subcategoryid'] ?>&categoryid=<?= $categoryid ?>&brandid=<?= $rows['brandid']?>" class="btn btn-danger">Delete</a></td>
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

