<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
  //Extract inputs
extract($_GET);
extract($_POST);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Item Brand</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itembrand.php?categoryid=1&subcategoryid=1" class="btn btn-sm btn-outline-secondary">All Item brands</a>

            </div>

        </div>
    </div>

    <?php
   

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {



        $sql = "SELECT brandname FROM tbl_itembrands WHERE brandid=$brandid";
        $db = dbconn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $brandname = $row['brandname'];
    }
    
    




    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      
     

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
            $sql = "SELECT * FROM tbl_itembrands WHERE brandname='$brandname' AND subcategoryid=$subcategoryid AND brandid!=$brandid AND deletestatus='1'";
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
            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];
            $sql = "UPDATE tbl_itembrands SET brandname='$brandname',updatedate='$updatedate',updateuser=$updateuser WHERE brandid=$brandid";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>" >
        <input type="hidden" name="subcategoryid" value="<?= @$subcategoryid; ?>" >
        <input type="hidden" name="brandid" value="<?= @$brandid; ?>" >



        <div class="mb-3">

            <label for="brandid" class="form-label">Brand Name</label>
            <input type="text" class="form-control w-75" id="brandname" name="brandname" value="<?= @$brandname; ?>" >
            <div class="text-danger"><?php echo @$messages['error_brandname']; ?></div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itembrand.php?categoryid=1&subcategoryid=1" class="btn btn-outline-primary ">Back</a>
            </div>
        </div>

    </form>
    
    

</main>

<?php include '../footer.php'; ?>