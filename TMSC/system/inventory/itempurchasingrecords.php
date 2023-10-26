<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
extract($_GET);
extract($_POST);
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Item Stock</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>inventory/viewreorderitems.php?" type="button" class="btn btn-sm btn-outline-secondary">View reorder items</a>
              
            </div>
            
        </div>
    </div>

    <h5>Item Catalog Purchasing Records</h5>

    <?php
    extract($_GET);
    $db = dbconn();

    // delete vehicle record
    if (@$mode == 'delete') {
        $delsql = "UPDATE tbl_itemstock SET deletestatus='0',quntity='0',issuedqty='0' WHERE itemstockid='$itemstockid'";

        $result = $db->query($delsql);
    }
    ?>




    <?php
    $sql = "SELECT s.itemstockid,c.catalogid,c.categoryid,c.itemname,s.quntity,s.issuedqty,s.purchasedate,s.buyingprice,s.sellingprice,"
            . "s.stockstatus FROM tbl_itemcatalog c LEFT JOIN tbl_itemstock s ON c.catalogid=s.catalogid WHERE s.catalogid='$catalogid' AND s.deletestatus='1'";
    $result = $db->query($sql);
    ?> 
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>

                    <th scope="col">Purchase date</th>
                    <th scope="col">Item name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Issued Qty</th>
                    <th scope="col">Buying Price</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Stock Status</th>





                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>

                            <td><?php echo $rows['purchasedate']; ?></td>
                            <td><?php echo ucfirst($rows['itemname']); ?></td>
                            <td><?php echo ucfirst($rows['quntity']); ?></td>
                            <td><?php echo $rows['issuedqty']; ?></td>
                            <td><?php echo $rows['buyingprice']; ?></td>
                            <td><?php echo $rows['sellingprice']; ?></td>                            
                            <td><?php echo $rows['stockstatus']; ?></td>

            

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