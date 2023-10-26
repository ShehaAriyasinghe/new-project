<?php include '../header.php'; ?>

<!-- table styles -->
<style>
    table, th, td {
        border:1px solid black;
    }  
</style>

<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all Jobcards</a>

            </div>

        </div>
    </div>

    <h6>Assign service materials for Job card</h6>



    <?php
    extract($_GET);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'edit') {


        $sql = "SELECT c.catalogid,c.itemname,c.itemimage,s.sellingprice,s.discount,ai.quantity FROM tbl_itemcatalog c INNER JOIN tbl_itemstock s ON s.catalogid=c.catalogid INNER JOIN tbl_jobcardassignitems ai ON ai.catalogid=c.catalogid WHERE ai.jobcardid='$jobcardid'";
        $db = dbConn();
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {

            $_SESSION['itemcart'][$row['catalogid']] = array('catalogid' => $row['catalogid'], 'itemname' => $row['itemname'], 'price' => $row['sellingprice'], 'image' => $row['itemimage'], 'discount' => $row['discount'], 'qty' => $row['quantity']);
        }
    }



    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'del') {
        $cart = $_SESSION['itemcart'];
        unset($cart[$catalogid]);
        $_SESSION['itemcart'] = $cart;
    }





    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (empty($_SESSION['itemcart'])) {
            $messages['error_itemcart'] = "The item cart should not be empty...!";
        }




        if (empty($messages)) {

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            $updatedate = date('Y-m-d');
            $updateuser = $_SESSION['userid'];

            $sql1 = "UPDATE tbl_jobcardorderitems SET orderdate='$adddate',updateuser='$updateuser',updatedate='$updatedate' WHERE jobcardid='$jobcardid'";
            $db = dbConn();
            $db->query($sql1);

            $sql2 = "SELECT jobcardorderid FROM tbl_jobcardorderitems WHERE jobcardid='$jobcardid'";
            $db = dbConn();
            $result2 = $db->query($sql2);
            $row = $result2->fetch_assoc();
            $orderid = $row['jobcardorderid'];

            if (isset($_SESSION['itemcart'])) {
                $sql3 = "DELETE FROM tbl_jobcardassignitems WHERE jobcardid='$jobcardid'";
                $db = dbConn();
                $db->query($sql3);

                foreach ($_SESSION['itemcart'] as $key => $value) {

                    $catalogid = $value['catalogid'];
                    $quntity = $value['qty'];
                    $sql = "INSERT INTO tbl_jobcardassignitems(jobcardid,orderid,catalogid,quantity,adddate,adduser) VALUES ('$jobcardid','$orderid','$catalogid','$quntity','$adddate','$adduser')";
                    $db = dbConn();
                    $db->query($sql);
                }
            }


            unset($_SESSION['itemcart']);

            header("Location:editassign_servicejobcard.php?jobcardid=$jobcardid&mode=edit");
        }
    }
    ?>

    <legend>Investigation Report:</legend>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped">
                <thead class="card-btn">
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                    </tr>
                </thead>

<?php
$db = dbconn();
$sql = "SELECT i.taskname,ji.taskstatus,ji.investigationtaskid FROM tbl_investigationtasks i INNER JOIN tbl_jobcardinvestigationtasks ji ON i.investigationtaskid=ji.investigationtaskid WHERE ji.jobcardid=$jobcardid AND ji.deletestatus='1'";
$result = $db->query($sql);
while ($rows = $result->fetch_assoc()) {
    ?>

                    <tr>
                        <td>
    <?php echo $rows['taskname'] . ":"; ?>
                        </td>    
                        <td>
                            <?php echo ucfirst($rows['taskstatus']) ?>
                        </td>


                    </tr>

    <?php
}
?>   
            </table>   

        </div>



        <div class="col-md-6">
            <a class="btn card-btn mt-2" href="<?= SYSTEM_PATH ?>cart/editcart_categoryview.php?jobcardid=<?= $jobcardid ?>&mode=assign">Add spare parts and oils</a>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                <input type="hidden" name="jobcardid" value='<?= @$jobcardid; ?>'>
                <label class="fs-4">Spare parts and oils:</label>


<?php
$amount = 0;
$totalcart = 0;
if (isset($_SESSION['itemcart'])) {
    ?>

                    <table>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price</th>

                            <th>Amount</th>
                            <th>Action</th>
                        </tr>


    <?php
    foreach ($_SESSION['itemcart'] as $key => $value) {
        ?>
                            <tr>


                                <td><?= $value['itemname'] ?></td>
                                <td><?= $value['qty'] ?></td>
                                <td><?php echo "Rs." . $value['price'] ?></td>

                                <td>
        <?php
        $amount = $value['qty'] * $value['price'];
        echo "Rs" . number_format($amount, 2);
        $totalcart += $amount;
        ?>                                    
                                </td>

                                <td><a href="editassign_materialsjobcard.php?catalogid=<?= $key ?>&action=del&jobcardid=<?= $jobcardid ?>"><i class="bi bi-x-square-fill"></i></a></td>
        <?php
    }
    ?>

                        </tr>
                        <tr>
                            <td></td>
                            <td>Total price:</td>
                            <td></td>
                            <td><?php echo "Rs" . number_format($totalcart, 2); ?></td>
                        </tr>
    <?php
}
?>
                    <input type="hidden"  value="<?= @$totalcart; ?>" name="itemtotalprice">
                </table>
                <div class="text-danger"><?php echo @$messages['error_itemcart']; ?></div>



        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <button type="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>

        </div>
        <div class="col-md-3">
            <a class="btn card-btn btn-sm mt-2 mb-2" href="editassign_servicejobcard.php?jobcardid=<?= $jobcardid; ?>&mode=edit">Next</a>
        </div>
    </div>

</form>




</main>
<?php
include '../footer.php';
?>
