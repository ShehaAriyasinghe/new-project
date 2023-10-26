
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<?php
extract($_GET);
extract($_POST);
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add item price</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="additemprice.php?categoryid=<?= $categoryid ?>&catalogid=<?= $catalogid ?>" class="btn btn-sm btn-outline-secondary">Add item price</a>

            </div>

        </div>
    </div>
    <?php
    extract($_GET);

    if (@$mode == 'delete') {
        $delsql = "UPDATE tbl_itemprice SET deletestatus='0' WHERE catalogid='$catalogid'";
        $db = dbconn();
        $result = $db->query($delsql);
    }





    $db = dbconn();
    $sql = "SELECT c.catalogid,b.brandname,c.itemname,c.itemimage,c.modelno,p.buyingprice FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemprice p ON c.catalogid=p.catalogid  WHERE c.catalogid='$catalogid' AND c.deletestatus='1' AND p.deletestatus='1'";
    $result = $db->query($sql);
    ?>



    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Item Name</th>

                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th>Buying price</th>


                    <th>Action</th>
                    <th>Action</th>


                </tr>
            </thead>
            <?php
            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
            ?>



            <tbody>

                <tr>
                    <td><?= $row['itemname'] ?></td>
                    <td><?= $row['brandname'] ?></td>
                    <td><?= $row['modelno'] ?></td>
                    <td><?= $row['buyingprice'] ?></td>
                    <td><a href="<?= SYSTEM_PATH; ?>inventory/edit_itemprice.php?categoryid=<?= $categoryid ?>&catalogid=<?= $catalogid ?>" type="submit" class="btn btn-outline-primary">Update</a></td>
                    <td><a onclick="return confirm('Are you sure you want to delete this record ?');" href="viewitemprice.php?mode=delete&catalogid=<?php echo $catalogid ?>&categoryid=<?= $categoryid ?>" class="btn btn-outline-danger">Delete</a></td>

                </tr>






            </tbody>
        </table>
<?php
}
?>



</main>    


<?php include '../footer.php'; ?>

