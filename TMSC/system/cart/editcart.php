<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Materials</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            
           
        </div>
    </div>

    <h6>All Items Of Job Card</h6>




    <?php
    extract($_GET);
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'del') {
        $cart = $_SESSION['itemcart'];
        unset($cart[$catalogid]);
        $_SESSION['itemcart'] = $cart;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$action == 'empty') {
        $_SESSION['itemcart'] = array();
    }

    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "update_qty") {
        foreach ($_SESSION['itemcart'] as $key => $value) {
            if ($key == $catalogid) {
                $_SESSION['itemcart'][$key]['qty'] = $qty;
            }
        }
    }
    ?>


    <a href="editcart.php?action=empty&jobcardid=<?= $jobcardid ?>">empty</a>
    <table width="100%" style="border: 1px solid black">
        <thead>
            <tr>

                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;

            foreach ($_SESSION['itemcart'] as $key => $value) {
                ?>
                <tr style="border: 1px solid black;">

                    <td><img class="img-fluid" width="100" height="100" src="../inventory/images/<?= $value['image'] ?>"></td>
                    <td><?= $value['itemname'] ?></td>
                    <td><?= $value['price'] ?></td>





                    <td>
                        <?php
                        $qty = $value['qty'];
                        $catalogid = $key;
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <input type="hidden" name="catalogid" value="<?= $catalogid ?>">
                            <input type="hidden" name="action" value="update_qty">
                            <input type="hidden" name="jobcardid" value="<?= $jobcardid ?>">

                            <select name="qty" id="qty" onchange="this.form.submit();">
                                <option value="1" <?php if ($qty == 1) { ?> selected <?php } ?>>1</option>
                                <option value="2" <?php if ($qty == 2) { ?> selected <?php } ?>>2</option>
                                <option value="3" <?php if ($qty == 3) { ?> selected <?php } ?>>3</option>
                                <option value="4" <?php if ($qty == 4) { ?> selected <?php } ?>>4</option>
                                <option value="5" <?php if ($qty == 5) { ?> selected <?php } ?>>5</option>
                            </select>

                        </form>

                    </td>
                    <td><?php
                        $amt = $value['price'] * $value['qty'];
                        $total += $amt;
                        echo number_format($amt, 2);
                        ?></td>
                    <td><a href="editcart.php?catalogid=<?= $key; ?>&action=del&jobcardid=<?= $jobcardid ?>"><i class="bi bi-x-square-fill"></i></a></td>

                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>Total(Rs.)</td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right"><?= number_format($total, 2) ?></td>
            </tr>

        </tfoot>
    </table>
    <div class="row">
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm mt-1" href="<?= SYSTEM_PATH ?>cart/editcart_categoryview.php?mode=assign&jobcardid=<?= $jobcardid ?>">Back to category</a>
        </div>   
        <div class="col-md-4">
            <a class="btn btn-primary btn-sm mt-1" href="<?= SYSTEM_PATH ?>jobcards/editassign_materialsjobcard.php?jobcardid=<?= $jobcardid ?>&mode=assign">Back to Job card</a>
        </div>
    </div>

</main>
<?php
include '../footer.php';
?>