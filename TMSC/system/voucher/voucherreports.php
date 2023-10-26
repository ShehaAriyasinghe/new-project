<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Voucher Pending payment report</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>voucher/vouchermonthlyreport.php" class="btn btn-sm btn-outline-secondary">View monthly Pending payment voucher report</a>

            </div>

        </div>
    </div>


    

    <?php
    $where = null;
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (!empty($vouchercode)) {
            $where .= " sv.vouchercode='$vouchercode' AND";
        }
        

        if (!empty($from) && !empty($to)) {
            $where .= " b.adddate  BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>
    
    <form method="post"  action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="row g-3">
            <div class="col-sm-4">
                <input type="text" name="vouchercode" value="<?= @$vouchercode ?>" class="form-control" placeholder="Voucher code">
            </div>
            
            <div class="col-sm">
                <input type="date" class="form-control" value="<?= @$from ?>" name="from" placeholder="Enter From Date" max="<?= date('Y-m-d') ?>">
                <span>From</span>
            </div>
            <div class="col-sm">
                <input type="date" class="form-control" value="<?= @$to ?>" name="to" placeholder="Enter To Date" max="<?= date('Y-m-d') ?>">
                <span>To</span>
            </div>
            <div class="col-sm">
                <button type="submit" class="btn card-btn">Search</button>
            </div>
        </div>
    </form>

    
    
    

<?php

    $db = dbConn();
    $sql = "SELECT sv.servicevoucherid,b.pendingpayment,sv.voucherstatus,b.adddate,sv.vouchercode FROM  tbl_billpayment b LEFT JOIN tbl_servicevoucher sv ON sv.jobcardid=b.jobcardid WHERE b.servicefreestatus='yes' AND sv.deletestatus='1' AND sv.voucherstatus='pending' $where";
    $result = $db->query($sql);
    ?>

    
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Voucher code</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Voucher Status</th>

                </tr>
            </thead>
            <tbody>
                
                <?php
                if ($result->num_rows > 0) {
                    $total = 0;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['vouchercode'] ?></td>
                            <td><?= $row['adddate'] ?></td>
                            <td><?= $row['pendingpayment'] ?></td>
                            <td><?= $row['voucherstatus'] ?></td>

                            <?php $total += $row['pendingpayment'] ?>
                            
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="3">Total Pending payments:</td>
                    <td><?php echo "Rs"." ". number_format(@$total, '2') ?></td>
                </tr>
            </tbody>
                    </table>

  




</main>

<?php include '../footer.php'; ?>