<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Received stocks</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-5">

                

            </div>

        </div>
    </div>

    <h5>Recived Item Stock</h5>



    <?php
    extract($_GET);
    $db = dbconn();

    
    
    
      if (@$mode == 'complete') {
        
        
        header("Location:http://localhost:8080/tmsc/system/inventory/add_itemstock.php?catalogid=$catalogid&categoryid=$categoryid&quantity=$quntity&bprice=$bprice&sprice=$sprice&purchaseorderid=$purchaseorderid");
          
          
      }
    
    
    
    
    
    
    ?>





    <?php
    $sql = "SELECT c.catalogid,c.categoryid,c.itemname,b.brandname,sub.subcategoryname,c.itemimage,p.buyingprice,p.sellingprice,p.quntity,p.purchaseorderid FROM tbl_purchaseorder p LEFT JOIN tbl_itemcatalog c ON c.catalogid=p.catalogid INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.deletestatus='1' AND p.deletestatus='1' AND deliverystatus='stores' ";
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
                     <th scope="col">Selling price</th>
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
                            <td><?php echo $rows['sellingprice']; ?></td>
                            <td><?php echo $rows['quntity']; ?></td>

                            
                            <td><a href="receivepurcashingstocks.php?mode=complete&purchaseorderid=<?php echo $rows['purchaseorderid']?>&catalogid=<?php echo $rows['catalogid']?>&categoryid=<?php echo $rows['categoryid']?>&bprice=<?= $rows['buyingprice']?>&sprice=<?= $rows['sellingprice']?>&quntity=<?= $rows['quntity'] ?>" class="btn card-btn btn-sm">Add stock</a></td>
       

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