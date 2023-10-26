<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Month wise pending payment voucher report</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>voucher/voucherreports.php" class="btn btn-sm btn-outline-secondary">View pending voucher reports</a>

            </div>

        </div>
    </div>


    <form method="post"  action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="row g-3">
           
            
            <div class="col-sm">
                <input type="date" class="form-control" name="from" placeholder="Enter From Date" max="<?= date('Y-m-d') ?>" >
            <span>From</span>
            </div>
            <div class="col-sm">
                <input type="date" class="form-control" name="to" placeholder="Enter To Date" max="<?= date('Y-m-d') ?>">
            <span>To</span>
            </div>
            <div class="col-sm">
                <button type="submit" class="btn card-btn">Search</button>
            </div>
        </div>
    </form>


    <?php
    $where = null;
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       
        

        if (!empty($from) && !empty($to)) {
            $where .= " b.adddate  BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }



    $db = dbConn();
    $sql = "SELECT sum(b.pendingpayment) as total,sv.voucherstatus,Month(b.adddate) as month,COUNT(Month(b.adddate)) as count,sv.vouchercode,b.adddate FROM  tbl_billpayment b LEFT JOIN tbl_servicevoucher sv ON sv.jobcardid=b.jobcardid WHERE b.servicefreestatus='yes' AND sv.deletestatus='1' AND sv.voucherstatus='pending' $where GROUP BY Month(b.adddate) ";
    $result = $db->query($sql);
    ?>

    <div id="report">
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                   
                    <th>Month</th>
                    <th>Payment</th>
                    <th>Count</th>
                   

                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $total = 0;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                             
                            
                            <!-- get month-->
                            <td><?php echo date("F",strtotime($row['adddate'])); ?></td>
                            <td><?= $row['total'] ?></td>
                            <td><?= $row['count'] ?></td>

                            <?php $total += $row['total'] ?>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="2">Total Pending payments:</td>
                    <td><?php echo "Rs".". ". number_format(@$total, '2') ?></td>
                </tr>
            </tbody>
                    </table>


    </div>






</main>

<?php include '../footer.php'; ?>