
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
            <div class="btn-group me-5">
               
               
                
            </div>
           
        </div>
    </div>

    <h5>Item Catalog</h5>
    
       



        <?php
//search reservation
        $where = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (!empty($itemcode)) {
                $where .= " c.itemcode LIKE '$itemcode%' AND";
            }

            if (!empty($itemname)) {
                $where .= " c.itemname LIKE '$itemname%' AND";
            }


            if (!empty($brandname)) {
                $where .= " b.brandname LIKE '$brandname%' AND";
            }

            if (!empty($modelno)) {
                $where .= " c.modelno LIKE '$modelno%' AND";
            }

            if (!empty($subcategoryname)) {
                $where .= " sub.subcategoryname LIKE '$subcategoryname%' AND";
            }


            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = " AND $where";
            }
        }
        ?>




        <!--search bar-->
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="categoryid" value="<?= @$categoryid; ?>">
            <div class="row">
                <div class="col">
                    
                    <input type="text" class="form-control" name="itemcode" placeholder="Item code" value="<?= @$itemcode; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="itemname" placeholder="Item name" value="<?= @$itemname; ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="brandname" placeholder="Brand" value="<?= @$brandname; ?>">

                </div>
                <div class="col">
                    <input type="text" class="form-control" name="modelno" placeholder="Model" value="<?= @$modelno; ?>">

                </div>


                <div class="col">
                    <input type="text" class="form-control" name="subcategoryname" placeholder="Subcategory" value="<?= @$subcategoryname; ?>">

                </div>

                

                <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
            </div>
                </form>


        <?php
        $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname,c.modelno,c.itemcode,c.description,c.itemimage,c.reorderqty,sum(s.quntity-s.issuedqty) as balance,sum(s.issuedqty) as issueqty FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid LEFT JOIN tbl_itemstock s ON c.catalogid=s.catalogid WHERE c.deletestatus='1' AND s.deletestatus='1' $where GROUP BY c.catalogid ";
       $db = dbconn();
        $result = $db->query($sql);
        ?> 
<div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Item</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th scope="col">Subcategory</th>


                    <th scope="col">Image</th>
                    <th scope="col">Available qty</th>
                    <th scope="col">Issued qty</th>
                    <th scope="col">Reorder</th>

                    <th>Action</th>
                    <th colspan="2">Action</th>
                    


                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        
                        if ($rows['reorderqty'] >= $rows['balance']) {
                        ?>
                        <tr>

                            <td><?php echo $rows['itemcode']; ?></td>
                            <td><?php echo ucfirst($rows['itemname']); ?></td>
                            <td><?php echo ucfirst($rows['brandname']); ?></td>
                            <td><?php echo $rows['modelno']; ?></td>
                            <td><?php echo $rows['subcategoryname']; ?></td>




                            <td> <img class="img-fluid w-50 h-50" src="<?= SYSTEM_PATH ?>inventory/images/<?= $rows['itemimage'] ?>"></td>

                            <td><?php echo $rows['balance']; ?></td>
                            <td><?php echo $rows['issueqty']; ?></td>
                            <td><?php
                                if ($rows['reorderqty'] >= $rows['balance']) {
                                    echo "<input type='color' name='color' value='#ff0000'>";
                                } else {
                                    echo "<input type='color' name='color' value='#6666ff'>";
                                }
                                ?></td>

                           
                             <td><a href="itempurchasingrecords.php?catalogid=<?php echo $rows['catalogid'] ?>" class="btn card-btn btn-sm">View</a></td>
                            <td><a href="addpurchaseorder.php?catalogid=<?php echo $rows['catalogid'] ?>" class="btn card-btn btn-sm">P.Order</a></td>
                            

                        </tr>


                        <?php
                        }
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?>