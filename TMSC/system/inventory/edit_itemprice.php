
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php

extract($_GET);
  extract($_POST);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update item price</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="viewitemprice.php?categoryid=<?= $categoryid?>&catalogid=<?= $catalogid?>" class="btn btn-sm btn-outline-secondary">View item price</a>

            </div>

        </div>
    </div>
    <?php
    
        extract($_GET);
       

        $db = dbconn();
        $sql = "SELECT c.catalogid,b.brandname,c.itemname,c.itemimage,c.modelno,c.deletestatus,p.buyingprice FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemprice p ON p.catalogid=c.catalogid WHERE c.catalogid='$catalogid' AND p.deletestatus='1'";
        $result = $db->query($sql);
        $rows = $result->fetch_assoc();
        $bprice=$rows['buyingprice']; 


    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);


        //Create array
        $messages = array();

        // empty validations
        

        
        if (empty($bprice)) {

            $messages['error_bprice'] = "The Item buying price should not be empty...!";
        }
        
        
         if($bprice < 1){
            $messages['error_bprice'] = "The Item buying price should not less than one...!";
        }
                  
        
        if (!empty($bprice)) {
                    if (!preg_match('/^[0-9 . ]+$/i', $bprice)) {
                        $messages['error_bprice'] = "Buying price is allowed numbers only.";
                    }
                }
        
           
        
        //check validation is completed
        if (empty($messages)) {
            
            
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "UPDATE tbl_itemprice SET buyingprice='$bprice',updatedate='$adddate',updateuser='$adduser' WHERE catalogid='$catalogid'";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="catalogid" value="<?= @$catalogid; ?>" >
         <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>" >
        
        
        

        <div class="mb-3">
            <img class="img-fluid w-25 h-25" src="<?= SYSTEM_PATH ?>inventory/images/<?= @$rows['itemimage'] ?>">
        </div>
        <div class="row">
            <div class="col-md-6">
                <legend>Item Details</legend>
                <div class="mb-3">
                    <label for="Brandname" class="form-label">Brand Name</label>
                    <input type="text" class="form-control w-75" id="brandname" name="brandname" value="<?= @ucfirst($rows['brandname']); ?>" readonly>
                   
                </div>


                <div class="mb-3">
                    <label for="itemname" class="form-label">Item Name</label>
                    <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$rows['itemname']; ?>" readonly>
                   
                </div>

                <div class="mb-3">
                    <label for="modelname" class="form-label">Model</label>
                    <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$rows['modelno']; ?>" readonly>
                   
                </div>
            </div>
            <div class="col-md-6">
                <legend>Catalog Details</legend>
                
                <div class="mb-3">
                    <label for="" class="form-label">Buying price(Rs.)</label>
                    <input type="text" class="form-control w-75" id="bprice" name="bprice" value="<?= @$bprice; ?>" >
                    <div class="text-danger"><?php echo @$messages['error_bprice']; ?></div>
                </div>
                
            </div>
        </div>



        <div class="row justify-content-left">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            
        </div>

    </form>

</main>    


<?php include '../footer.php'; ?>

