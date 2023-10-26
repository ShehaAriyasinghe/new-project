<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Voucher management</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>voucher/voucherreports.php" class="btn btn-sm btn-outline-secondary">pending payment of vouchers</a>

            </div>

        </div>
    </div>





    <?php
    extract($_GET);

    if ($_SERVER['REQUEST_METHOD'] == "GET" && @$status == "voucherupdate") {

        $sql1 = "UPDATE tbl_servicevoucher SET voucherstatus='Released' WHERE servicevoucherid='$voucherid'";
        $db = dbconn();
        $result = $db->query($sql1);

        $sql2 = "UPDATE tbl_billpayment SET pendingpayment='0',releasedpayment='$voucherpayment',servicepayment='$voucherpayment',grosspayment= grosspayment + '" . $voucherpayment . "'  WHERE jobcardid='$jobcardid'";
        $result = $db->query($sql2);
    }




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


    <form method = "post" action = "<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class = "row g-3">
            <div class = "col-sm-4">
                <input type = "text" name = "vouchercode" value = "<?= @$vouchercode ?>" class = "form-control" placeholder = "Voucher code">
            </div>

            <div class = "col-sm">
                <input type = "date" class = "form-control" value = "<?= @$from ?>" name = "from" placeholder = "Enter From Date" max = "<?php echo date('Y-m-d') ?>" >
                <span>From</span>
            </div>
            <div class = "col-sm">
                <input type = "date" class = "form-control" value = "<?= @$to ?>" name = "to" placeholder = "Enter To Date" max = "<?php echo date('Y-m-d') ?>">
                <span>To</span>
            </div>
            <div class = "col-sm">
                <button type = "submit" class = "btn card-btn">Search</button>
            </div>
        </div>
    </form>


    <?php
    $db = dbConn();
    $sql = "SELECT sv.servicevoucherid,b.pendingpayment,sv.voucherstatus,b.adddate,sv.vouchercode,sv.voucherimage,b.jobcardid FROM  tbl_billpayment b INNER JOIN tbl_servicevoucher sv ON sv.jobcardid=b.jobcardid WHERE b.servicefreestatus='yes' AND sv.deletestatus='1' AND sv.voucherstatus='pending' $where";
    $result = $db->query($sql);
    ?>

    <div id="report">
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Voucher code</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Voucher Image</th>
                    <th>Voucher Status</th>
                    <th>Release payment</th>

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
                            <td><img src="<?= SYSTEM_PATH ?>jobcards/images/<?= $row['voucherimage'] ?>" class="img-fluid w-50 h-50"></td>
                            <td><?= $row['voucherstatus'] ?></td>
                            <?php
                            if ($row['voucherstatus'] == "pending") {
                                ?>
                                <td><a href="monthvoucher.php?voucherid=<?= $row['servicevoucherid'] ?>&status=voucherupdate&voucherpayment=<?= $row['pendingpayment'] ?>&jobcardid=<?= $row['jobcardid'] ?>" class="btn btn-primary">Release</a></td>
                                <?php
                            } else {
                                ?>
                                <td><?php echo $row['voucherstatus'] ?></td>

                                <?php
                            }
                            ?>
                            <?php $total += $row['pendingpayment'] ?>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<div class='alert alert-danger'>There are no voucher records</div>";
                }
                ?>
                <tr>
                    <td colspan="3">Total Pending payments:</td>
                    <td><?php echo "Rs" . " " . number_format(@$total, '2') ?></td>
                </tr>
            </tbody>
                    </table>


    </div>






</main>

<?php include '../footer.php'; ?>