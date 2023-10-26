<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">View Purchasing orders</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-5">

                

            </div>

        </div>
    </div>

    <h5>Item purchasing Orders</h5>



    <?php
    extract($_GET);
    $db = dbconn();

    // delete vehicle record
    if (@$mode == 'delete') {

        $sql1 = "SELECT catalogid,supplierid,buyingprice,sellingprice,quntity FROM tbl_purchaseorder  WHERE purchaseorderid='$purchaseorderid' AND deletestatus='1'";
        $db = dbConn();
        $result1 = $db->query($sql1);
        $row = $result1->fetch_assoc();

        $supplierid = $row['supplierid'];
        $bprice = $row['buyingprice'];
        $sprice = $row['sellingprice'];
        $itemqty = $row['quntity'];

        $relesedcredit = $row['buyingprice'] * $row['quntity'];

        $sql2 = "UPDATE tbl_suppliers SET creditlimit=creditlimit + '" . $relesedcredit . "'  WHERE supplierid='$supplierid'";
        $result = $db->query($sql2);

        $delsql = "UPDATE tbl_purchaseorder SET deletestatus='0' WHERE purchaseorderid='$purchaseorderid'";
        $result = $db->query($delsql);
    }
    
    
      if (@$mode == 'received') {
        $delsql = "UPDATE tbl_purchaseorder SET deliverystatus='stores' WHERE purchaseorderid='$purchaseorderid'";
        $result = $db->query($delsql);
          
          
      }
    
   
    
    ?>





    <?php
    $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname,c.itemimage,p.buyingprice,p.quntity,p.purchaseorderid FROM tbl_purchaseorder p LEFT JOIN tbl_itemcatalog c ON c.catalogid=p.catalogid INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.deletestatus='1' AND p.deletestatus='1' AND p.deliverystatus='none' ";
    $result = $db->query($sql);
    ?> 
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Item Name</th>
                    <th scope="col">Item Image</th>
                    <th scope="col">Brand</th>

                    <th scope="col">Subcategory</th>
                    <th scope="col">Buying price</th>
                    <th scope="col">Qty</th>




                    <th>Action</th>
                


                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>


                            <td><?php echo ucfirst($rows['itemname']); ?></td>
                            <td> <img class="img-fluid" width="100" hight="100" src="<?= SYSTEM_PATH ?>inventory/images/<?= $rows['itemimage'] ?>"></td>
                            <td><?php echo ucfirst($rows['brandname']); ?></td>

                            <td><?php echo $rows['subcategoryname']; ?></td>
                            <td><?php echo $rows['buyingprice']; ?></td>
                            <td><?php echo $rows['quntity']; ?></td>

                            <td><a href="viewpurchaseorder.php?catalogid=<?php echo $rows['catalogid'] ?>&purchaseorderid=<?php echo $rows['purchaseorderid'] ?>" class="btn card-btn btn-sm">View</a></td>
                            <td><a href="editpurchaseorder.php?catalogid=<?php echo $rows['catalogid'] ?>&purchaseorderid=<?php echo $rows['purchaseorderid'] ?>" class="btn card-btn btn-sm">Update details</a></td>
                            <td><a href="purchaseorders.php?mode=received&purchaseorderid=<?php echo $rows['purchaseorderid'] ?>" class="btn card-btn btn-sm">Received</a></td>

                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="purchaseorders.php?mode=delete&catalogid=<?php echo $rows['catalogid'] ?>&purchaseorderid=<?php echo $rows['purchaseorderid'] ?>" class="btn card-btn btn-sm">Delete</a></td>

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