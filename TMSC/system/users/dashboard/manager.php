<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">

            </div>

        </div>
    </div>

    <div class="row">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Purchase Orders</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Pending Orders</h6>

                    <h2 class="display-6">
                        <?php
                        $db = dbconn();
                        $sql = "SELECT count(p.purchaseorderid) as pcount FROM tbl_purchaseorder p WHERE p.deletestatus='1' AND p.deliverystatus='none' ";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['pcount'];
                        ?>
                    </h2>
                    <a href="<?= SYSTEM_PATH ?>inventory/purchaseorders.php" class="card-link">Purchasing Orders</a>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reservations</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Today Reservations</h6>
                    <?php
                    $date = date('Y-m-d');
                    $sqltbl = "SELECT reservationdate,count(reservationid) AS count FROM tbl_reservations WHERE deletestatus='1' AND reservationdate='$date'";
                    $result1 = $db->query($sqltbl);
                    $rowcount = $result1->fetch_assoc();
                    ?>
                    <h2 class="display-6"><?= $rowcount['count'] ?></h2>
                    <a href="<?= SYSTEM_PATH ?>reports/reservationsreport.php" class="card-link">View Reservations</a>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Suppliers</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Number of suppliers</h6>
                    <?php
                    $sql = "SELECT count(supplierid)as countsupplier  FROM tbl_suppliers WHERE deletestatus='1'";
                    $result2 = $db->query($sql);
                    $rowsupplier = $result2->fetch_assoc();
                    ?>
                    <h2 class="display-6"><?php echo $rowsupplier['countsupplier'] ?></h2>

                    <a href="<?= SYSTEM_PATH ?>suppliers/supplier.php" class="card-link">View Suppliers</a>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Items</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Reorder Items</h6>
                    <?php
                    $count = 0;
                    $sql = "SELECT c.reorderqty,sum(s.quntity-s.issuedqty) as balance,sum(s.issuedqty) as issueqty FROM tbl_itemcatalog c INNER JOIN tbl_itemstock s ON c.catalogid=s.catalogid WHERE  c.deletestatus='1' AND s.deletestatus='1' GROUP BY c.catalogid";
                    $db = dbconn();
                    $result3 = $db->query($sql);
                    while ($rowitem = $result3->fetch_assoc()) {
                        if ($rowitem['balance'] <= $rowitem['reorderqty']) {
                            $count += 1;
                            ?>



                            <?php
                        }
                    }
                    ?>
                    <h2 class="display-6"><?php echo @$count; ?></h2>
                    <a href="<?= SYSTEM_PATH ?>inventory/viewreorderitems.php" class="card-link">View Reorder items</a>

                </div>
            </div>

        </div>

    </div>
    <hr>

    <div class="row">

        <div class="col">
            <?php
            $db = dbconn();
            $date = date('Y-m-d');
            $sql = "SELECT count(r.reservationid) as fullservice,r.reservationdate,r.serviceid,s.servicename FROM tbl_reservations r INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE s.serviceid='1' AND r.adddate='$date'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $fullservice = $row['fullservice'];

            $sql1 = "SELECT count(r.reservationid) as normalservice,r.reservationdate,r.serviceid,s.servicename FROM tbl_reservations r INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE s.serviceid='2' AND r.adddate='$date'";
            $result1 = $db->query($sql1);
            $row1 = $result1->fetch_assoc();
            $normalservice = $row1['normalservice'];

            $sql2 = "SELECT count(r.reservationid) as bodywash,r.reservationdate,r.serviceid,s.servicename FROM tbl_reservations r INNER JOIN tbl_services s ON s.serviceid=r.serviceid WHERE s.serviceid='3' AND r.adddate='$date'";
            $result2 = $db->query($sql2);
            $row2 = $result2->fetch_assoc();
            $bodywash = $row2['bodywash'];
            ?>
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h5 class="card-title">Today Total Service Types</h5>
                    <canvas id="myChart1" style="width:30%; max-width:300px"></canvas>

                    <script>
                        var xValues = ["Full service", "Normal service", "Bodywash"];
                        var yValues = [<?= $fullservice ?>, <?= $normalservice ?>, <?= $bodywash ?>];
                        var barColors = [
                            "#b91d47",
                            "#00aba9",
                            "#2b5797",
                            "#e8c3b9",
                            "#1e7145"
                        ];

                        new Chart("myChart1", {
                            type: "doughnut",
                            data: {
                                labels: xValues,
                                datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: "Today Service Types"
                                }
                            }
                        });
                    </script>


                </div>

                <a href="<?= SYSTEM_PATH ?>reports/serviceincomereport.php ">View Today Service Types</a>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reservations</h5>
                    <canvas id="myChart2" style="width:30%; max-width:300px"></canvas>

                    <?php
                    $db = dbconn();
                    $date = date('Y-m-d');
                    $sql = "SELECT count(reservationid) as complete,reservationdate FROM tbl_reservations WHERE jobcardstatus='completed' AND deletestatus='1' AND adddate='$date'";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    $complete = $row['complete'];

                    $sql1 = "SELECT count(reservationid) as cancel,reservationdate FROM tbl_reservations WHERE jobcardstatus='cancel' AND deletestatus='0' AND adddate='$date'";
                    $result1 = $db->query($sql1);
                    $row1 = $result1->fetch_assoc();
                    $cancel = $row1['cancel'];

                    $sql2 = "SELECT count(reservationid) as pending,reservationdate FROM tbl_reservations WHERE jobcardstatus='pending' AND deletestatus='1' AND adddate='$date'";
                    $result2 = $db->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    $pending = $row2['pending'];
                    ?>


                    <script>
                        var xValues = ["Complete", "Pending", "Cancel"];
                        var yValues = [<?= $complete ?>, <?= $pending ?>, <?= $cancel ?>];
                        var barColors = ["red", "green", "blue"];

                        new Chart("myChart2", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [{
                                        backgroundColor: barColors,
                                        data: yValues
                                    }]
                            },
                            options: {
                                legend: {display: false},
                                title: {
                                    display: true,
                                    text: "Today Reservations"
                                }
                            }
                        });
                    </script>



                </div>
                <a href="<?= SYSTEM_PATH ?>reports/reservationsreport.php ">View Today Reservations</a>
            </div>


        </div>







    </div>


</main>
