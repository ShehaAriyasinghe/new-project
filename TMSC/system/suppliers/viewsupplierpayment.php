<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Supplier Payments</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            </div>

        </div>
    </div>

    <h6>All Payments</h6>

    <?php
    extract($_GET);
    $db = dbconn();
    $sql = "SELECT p.purchaseorderid,p.supplierid,p.buyingprice,p.quntity,p.adddate,p.pendingpayment,s.companyname,s.creditlimit,p.supplierid,c.itemname FROM tbl_purchaseorder p LEFT JOIN tbl_suppliers s ON s.supplierid=p.supplierid INNER JOIN tbl_itemcatalog c ON c.catalogid=p.catalogid WHERE p.deletestatus='1' AND payment='pending' AND deliverystatus !='none' AND p.supplierid='$supplierid'";
    $result = $db->query($sql);
    ?>    



    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Date</th>

                    <th>Item Name</th>
                    <th>Buying Price</th>
                    <th>Quantity</th>
                    <th>Order Total</th>
                      <th>Pending payment</th>
                    <th>Payment</th>



                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>

                <?php
                $totalpending = 0;
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                        <tr>


                            <td><?php echo $rows['adddate']; ?></td>

                            <td><?php echo $rows['itemname']; ?></td>
                            <td><?php echo $rows['buyingprice']; ?></td>

                            <td><?php echo $rows['quntity']; ?></td>

                            <td><?php echo $total = $rows['quntity'] * $rows['buyingprice'] ?></td>
                            <td><?php echo $pendingtotal=$rows['pendingpayment']; ?></td>

                            <td><a href="<?= SYSTEM_PATH ?>suppliers/paypayment.php?purchaseorderid=<?= $rows['purchaseorderid'] ?>&supplierid=<?= $rows['supplierid'] ?>" class="btn btn-primary">Payment</a></td>


                            <?php
                            $companyname = $rows['companyname'];

                            $totalpending += $pendingtotal;
                            ?>

                        </tr>

                        <?php
                    }
                    echo $companyname;
                }
                ?>
                <tr>
                    <td colspan="2">Total due payment (Rs:)</td>

                    <td> <?php echo number_format($totalpending, 2) ?></td>

                </tr>
            </tbody>
        </table>
    </div>





</main>
<?php include '../footer.php'; ?>


