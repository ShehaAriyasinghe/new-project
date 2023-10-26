
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
extract($_GET);
extract($_POST);
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Item Catalog</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-5">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemcatalog.php?categoryid=<?= $categoryid; ?>" type="button" class="btn btn-sm btn-outline-secondary">Add New Catalog</a>
                <a href="<?= SYSTEM_PATH; ?>inventory/itemcategoriescards.php" type="button" class="btn btn-sm btn-outline-secondary">View item categories</a>

            </div>

        </div>
    </div>

    <h5>Item Catalog List</h5>

    <?php
    extract($_GET);
    $db = dbconn();

    // delete item record
    if (@$mode == 'delete') {
        $delsql = "UPDATE tbl_itemcatalog SET deletestatus='0' WHERE catalogid='$catalogid'";
        $db = dbconn();
        $result = $db->query($delsql);
    }
    ?>






    <?php
//search items
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
    $sql = "SELECT c.catalogid,ca.categoryname,c.capacity,c.itemname,b.brandname,sub.subcategoryname,c.modelno,c.itemcode,c.description,c.itemimage,c.reorderqty FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid LEFT JOIN tbl_itemstock s ON c.catalogid=s.catalogid INNER JOIN tbl_itemcategories ca ON ca.categoryid=c.categoryid WHERE c.categoryid='$categoryid' AND c.deletestatus='1' $where GROUP BY c.catalogid";
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

                    <th scope="col">Reorder</th>                  
                    <th scope="col">Image</th>
                    <?php
                    if ($categoryid == '2') {
                        ?>
                        <th scope="col">Capacity</th>
                        <?php
                    }
                    ?>
                    <th>Action</th>



                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>

                            <td><?php echo $rows['itemcode']; ?></td>
                            <td><?php echo ucfirst($rows['itemname']); ?></td>
                            <td><?php echo ucfirst($rows['brandname']); ?></td>
                            <td><?php echo $rows['modelno']; ?></td>
                            <td><?php echo $rows['subcategoryname']; ?></td>
                            <td><?php echo $rows['reorderqty']; ?></td>   
                            <td> <img class="img-fluid w-50 h-50" src="<?= SYSTEM_PATH ?>inventory/images/<?= $rows['itemimage'] ?>"></td>

                            <?php if ($rows['categoryname'] == "oil") {
                                ?>    
                                <td><?php echo $rows['capacity'] . "ml"; ?></td>
                                <?php
                            }
                            ?>







                            <?php
                            if ($_SESSION['userrole'] == "storekeeper") {
                                ?>
                                <td><a href="add_itemstock.php?catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">Stock</a></td>
                                <?php
                            } else if ($_SESSION['userrole'] == "manager") {
                                ?>
                                <td><a href="addpurchaseorder.php?catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">P.Order</a></td>
                                <td><a href="itemquotation.php?catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">Quotation</a></td>
                                <td><a href="additemprice.php?catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">Price</a></td>
                                <?php
                            }
                            ?>
                            <td><a href="viewitemcatalog.php?catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">View</a></td>
                            <td><a href="edititemcatalog.php?catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="itemcatalog.php?mode=delete&catalogid=<?php echo $rows['catalogid'] ?>&categoryid=<?= $categoryid ?>" class="btn card-btn btn-sm">Delete</a></td>

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