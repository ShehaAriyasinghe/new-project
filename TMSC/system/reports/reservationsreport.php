<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Reservation reports</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
               

            </div>

        </div>
    </div>

    <h6>Reservation Report</h6>




    <?php
    extract($_POST);
    $db = dbconn();
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        if (!empty($from) && !empty($to)) {
            $where .= " reservationdate BETWEEN '$from' AND '$to' AND";
        }
        
        if (!empty($from) && empty($to)) {
            $where .= " reservationdate ='$from' AND";
        }
        
         if (empty($from) && !empty($to)) {
            $where .= " reservationdate ='$to' AND";
        }
        
        


        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>




    <form id="search" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="row g-3">


            <div class="col-sm">
                <label>From Date</label>
                <input type="date" name="from" value="<?php echo @$from; ?>" placeholder="Enter From Date" max="<?= date('Y-m-d')?>">
            </div>
            <div class="col-sm">
                <label>To Date</label>
                <input type="date" name="to" placeholder="Enter To Date" value="<?php echo @$to; ?>" max="<?= date('Y-m-d')?>">
            </div>
            <div class="col-sm">
                <label>Status</label>
                <select name="rep_type">
                    
                    <option value="<?php echo @$rep_type; ?>"><?php echo @$rep_type; ?></option>
                    
                    <option value="Daily">Daily</option>
                    <option value="Monthly">Monthly</option>
                    <option value="">--</option>

                </select>
            </div>
            <div class="col-sm">
                <button type="submit" class='btn btn-primary btn-sm'>Search</button>
            </div>
    </form>


    <?php
    if (@$rep_type == 'Daily') {
        $sqltbl = "SELECT reservationdate,count(reservationid) AS count FROM tbl_reservations WHERE deletestatus='1' $where GROUP BY reservationdate";
        $result = $db->query($sqltbl);
        ?>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reservation Date</th>
                    <th>No of Appoinments</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $totalres = 0;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['reservationdate'] ?></td>
                        <td>
                            <?php
                            echo $row['count'];
                            @$totalres += $row['count'];
                            ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            <td>Total Number of reservation : <?php echo $totalres; ?></td>
            </tbody>

        </table>
        <?php
    }
    ?>



    <?php
    if (@$rep_type == 'Monthly') {
        $sqltbl = "SELECT MONTH(reservationdate) AS month,count(reservationid) AS count FROM tbl_reservations WHERE deletestatus='1' $where GROUP BY MONTH(reservationdate)";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reservation Month</th>
                    <th>No of Appoinments</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo date('F', mktime(0, 0, 0, $row['month'],10)) ?></td>
                        <td><?php
                            echo $row['count'];
                            $total += $row['count'];
                            ?>
                        </td>

                    </tr>


                    <?php
                }
                ?>
            <td>Total Number of reservation : <?php echo $total; ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>
    
    
    
    
    <?php
    if (empty($rep_type) && (!empty($where) || empty($where))) {
        $sqltbl = "SELECT r.reservationdate,s.servicename,v.plateno FROM tbl_reservations r INNER JOIN tbl_vehicles v ON v.vehicleid=r.vehicleid INNER JOIN tbl_services s ON s.serviceid=r.serviceid  WHERE r.deletestatus='1' $where ";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Service Name</th>
                     <th>Plate No</th>

                </tr>

            </thead>
            <tbody>

                <?php
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['reservationdate'] ?></td>
                        <td><?php echo $row['servicename'] ?></td> 
                        <td><?php echo $row['plateno'] ?></td> 
                        
                    </tr>


                    <?php
                }
                ?>
            
            </tbody>

        </table>

        <?php
    }
    ?>

    
    








</main>
<?php
include '../footer.php';
?>




