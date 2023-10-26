<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Item Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="itemcategory.php" class="btn btn-sm btn-outline-secondary">View item categories</a>
               
            </div>
           
        </div>
    </div>

    <?php
    
    //Extract inputs
        extract($_GET);
        
     if ($_SERVER['REQUEST_METHOD'] == 'GET') {
          $sql = "SELECT * FROM tbl_itemcategories WHERE categoryid='$categoryid'";
            $db = dbconn();
            $result = $db->query($sql);
            $row=$result->fetch_assoc();
            $categoryname=$row['categoryname'];
         
    
    
     }
    
    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $categoryname = cleanInput($categoryname);

        //Create array
        $messages = array();

        // empty validations
        if (empty($categoryname)) {
            $messages['error_category'] = "The Category Name should not be empty..!";
        }
        
        
        //advance validations
        
        if (!empty($categoryname)) {
            $sql = "SELECT * FROM tbl_itemcategories WHERE categoryname='$categoryname' AND categoryid!='$categoryid' AND deletestatus='1'";
            $db = dbconn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_category'] = "The Category name already exists..!";
            }
        }
        
      
        
        
         if (!empty($categoryname)) {
                    if (!preg_match('/^[a-z ]+$/i', $categoryname)) {
                        $messages['error_category'] = "The Category name should be string..!";
                    }
                }
        
        
 
        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];
            $sql = "UPDATE tbl_itemcategories SET categoryname='$categoryname',updatedate='$updatedate',updateuser=$updateuser WHERE categoryid=$categoryid";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
         <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>" >
        <div class="mb-3">
            <label for="brandname" class="form-label">Category Name</label>
            <input type="text" class="form-control w-75" id="categoryname" name="categoryname" value="<?= @$categoryname; ?>" >
            <div class="text-danger"><?php echo @$messages['error_category']; ?></div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemcategory.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>

</main>

<?php include '../footer.php'; ?>

