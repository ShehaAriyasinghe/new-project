<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
extract($_GET);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $date = date('Y-m-d');
    $sqltbl = "SELECT s.servicename,s.serviceid,j.plateno,j.reservationdate,j.starttime,j.endtime FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid WHERE j.jobcardstatus='pending' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
    $db = dbConn();
    $result = $db->query($sqltbl);
    $row = $result->fetch_assoc();

    $servicename = $row['servicename'];
    $serviceid = $row['serviceid'];
    $plateno = $row['plateno'];
    $starttime = $row['starttime'];
    $endtime = $row['endtime'];
    $reservationdate = $row['reservationdate'];
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Successfully Updated Materials.</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/pending_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all pending Job cards</a>
               
            </div>
           
        </div>
    </div>


    <h6>Updated materials in Job card</h6>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-box px-5" style="width: 40rem;">

                <div class="text-center card-header my-card-heading mb-3 px-1">
                    <p class="display-6">Job card is successfully updated all materials.</p>
                </div>
                <div class="card-body">

                    <h6 class="">Service Name: <?php echo $servicename; ?> </h6>
                    <h6 class="">Vehicle Plate No: <?php echo $plateno; ?></h6>
                    <h6 class="">Reservation Date: <?php echo $reservationdate; ?></h6>
                    <h6 class="">Reservation Time: <?php echo $starttime . "-" . $endtime; ?></h6>

                    <a href="<?= SYSTEM_PATH; ?>index.php" class="btn card-btn">Dashboard</a>
                </div>

            </div>

        </div>
    </div>

</main>
<?php include '../footer.php'; ?>