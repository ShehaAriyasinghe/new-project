<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            
            
        </div>
    </div>

    <div class="row">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reservations</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Today Reservations</h6>
                    <?php
                    $db=dbconn();
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
                    <h5 class="card-title">Total vehicles</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Vehicles</h6>
                    <?php
                    $db=dbconn();
                    $date = date('Y-m-d');
                    $sql2 = "SELECT count(vehicleid) AS vehiclecount FROM tbl_vehicles WHERE deletestatus='1'";
                    $result2 = $db->query($sql2);
                    $rowvehicle = $result2->fetch_assoc();
                    ?>
                    <h2 class="display-6"><?= $rowvehicle['vehiclecount'] ?></h2>
                    <a href="<?= SYSTEM_PATH ?>vehicles/allvehicles.php" class="card-link">View vehicle history</a>
                </div>
            </div>

        </div>
        
        
        
        
        
        
        
        
        
        
        



        
        

        


    </div>
    <hr>
    
    <div class="row">

        
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


