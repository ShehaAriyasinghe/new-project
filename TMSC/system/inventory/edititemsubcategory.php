<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <?php
    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        //Extract inputs
        extract($_GET);

        $sql = "SELECT subcategoryname FROM tbl_itemsubcategories WHERE subcategoryid=$subcategoryid";
        $db = dbconn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $subcategoryname=$row['subcategoryname'];
        
        
    }




    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $subcategoryname = cleanInput($subcategoryname);

        //Create array
        $messages = array();

        // empty validations
        if (empty($subcategoryname)) {
            $messages['error_subcategory'] = "The Sub category Name should not be empty..!";
        }


        //advance validations

        if (!empty($subcategoryname)) {
            $sql = "SELECT * FROM tbl_itemsubcategories WHERE subcategoryname='$subcategoryname' AND subcategoryid!='$subcategoryid' AND deletestatus='1'";
            $db = dbconn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_subcategory'] = "The Sub category name already exists..!";
            }
        }

        

        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];
            $sql = "UPDATE tbl_itemsubcategories SET subcategoryname='$subcategoryname',updatedate='$updatedate',updateuser='$updateuser' WHERE subcategoryid=$subcategoryid";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>



    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Item Sub Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="itemsubcategory.php?categoryid=<?= $categoryid; ?>" class="btn btn-sm btn-outline-secondary">View Item Sub Categories</a>

            </div>

        </div>
    </div>



    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>" >
         <input type="hidden" name="subcategoryid" value="<?= @$subcategoryid; ?>" >
        <div class="mb-3">

            <label for="" class="form-label">Sub Category Name</label>
            <input type="text" class="form-control w-75" id="subcategoryname" name="subcategoryname" value="<?= @$subcategoryname; ?>" >
            <div class="text-danger"><?php echo @$messages['error_subcategory']; ?></div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/itemcategory.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>

