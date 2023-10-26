<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Service Income Report</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
               

            </div>

        </div>
    </div>

    <h6>Service Income Report</h6>


    <?php
    extract($_POST);
    $db = dbconn();
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (!empty($service)) {
            $where .= " j.serviceid ='$service' AND";
        }


        if (!empty($from) && !empty($to)) {
            $where .= " j.adddate BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($from) && empty($to)) {
            $where .= " j.adddate ='$from' AND";
        }

        if (empty($from) && !empty($to)) {
            $where .= " j.adddate ='$to' AND";
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
                <span>From:</span>
                <input type="date" name="from" value="<?php echo @$from; ?>" placeholder="Enter From Date" max="<?php echo date('Y-m-d') ?>">

            </div>

            <div class="col-sm">
                <span>To:</span>
                <input type="date" name="to" placeholder="Enter To Date" value="<?php echo @$to; ?>" max="<?php echo date('Y-m-d') ?>">

            </div>
            <div class="col-sm">
                <span>Type</span>
                <select name="rep_type">

                    <option value="<?php echo @$rep_type; ?>"><?php echo @$rep_type; ?></option>

                    <option value="Daily">Daily</option>
                    <option value="Monthly">Monthly</option>
                    <option value="">--</option>

                </select>

            </div>



            <div class="col-sm">


                <?php
                $sql1 = "SELECT serviceid,servicename FROM tbl_services WHERE deletestatus=1";
                $db = dbconn();
                $result = $db->query($sql1);
                ?>

                <select name="service" id="serviceid">
                    <option value="">--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value="<?php echo $row['serviceid']; ?>" <?php if (@$service == $row['serviceid']) { ?> selected <?php } ?>><?php echo $row['servicename']; ?></option>

                            <?php
                        }
                    }
                    ?>
                </select>

                <span>Service</span>

            </div>



            <div class="col-sm">
                <button type="submit" class='btn btn-primary btn-sm'>Search</button>
            </div>
    </form>


    <?php
    if (@$rep_type == 'Daily') {
        $sqltbl = "SELECT adddate,count(jobcardid) AS count FROM tbl_jobcards j WHERE deletestatus='1' $where GROUP BY adddate";
        $result = $db->query($sqltbl);
        ?>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>No of Jobs</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $totalres = 0;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['adddate'] ?></td>
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
            <td>Total Number of Jobs : <?php echo $totalres; ?></td>
            </tbody>

        </table>
        <?php
    }
    ?>



    <?php
    if (@$rep_type == 'Monthly') {
        $sqltbl = "SELECT MONTH(adddate) AS month,count(jobcardid) AS count FROM tbl_jobcards j WHERE deletestatus='1' $where GROUP BY MONTH(adddate)";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>No of Jobs</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)) ?></td>
                        <td><?php
                            echo $row['count'];
                            $total += $row['count'];
                            ?>
                        </td>

                    </tr>


                    <?php
                }
                ?>
            <td>Total Number of Jobs : <?php echo $total; ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>




    <?php
    if (empty($rep_type) && (!empty($where) || empty($where))) {
        $sqltbl = "SELECT j.adddate,s.servicename,j.plateno,j.freeservicestatus,b.servicepayment,b.itemtotalpayment,b.subservicetotalpayment,b.grosspayment FROM tbl_jobcards j INNER JOIN tbl_billpayment b ON b.jobcardid=j.jobcardid INNER JOIN tbl_services  s ON s.serviceid=j.serviceid WHERE j.deletestatus='1' $where ";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Service Name</th>
                    <th>Plate No</th>
                    <th>free service</th>
                    <th>Service Payment</th>
                    <th>Items Total</th>
                    <th>Sub service Total</th>
                    <th>Gross Payment</th>

                </tr>

            </thead>
            <tbody>

                <?php
                $totalamount = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['adddate'] ?></td>
                        <td><?php echo $row['servicename'] ?></td> 
                        <td><?php echo $row['plateno'] ?></td> 
                        <td><?php echo $row['freeservicestatus'] ?></td> 
                        <td><?php echo $row['servicepayment'] ?></td> 
                        <td><?php echo $row['itemtotalpayment'] ?></td> 
                        <td><?php echo $row['subservicetotalpayment'] ?></td> 
                        <td><?php echo $row['grosspayment'] ?></td> 
                        <?php 
                        $totalamount += $row['grosspayment'];
                        ?>

                  
                    </tr>


                    <?php
                }
                ?>
                    <tr>
                        <td colspan="3">
                            Total Amount of jobs
                        </td>
                        
                        <td>Rs.<?php echo number_format($totalamount,2);  ?></td>
                        
                    </tr>
               
            </tbody>

        </table>

        <?php
    }
    ?>



</main>
<?php
include '../footer.php';
?>





