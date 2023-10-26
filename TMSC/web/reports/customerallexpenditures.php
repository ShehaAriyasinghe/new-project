
<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>
<?php
extract($_GET);
extract($_POST);
?>  
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Reports</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
 

            </div>

        </div>
    </div>


 <?php
    extract($_GET);

    //search vehicle
    $where = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (!empty($service)) {
            $where .= " b.serviceid ='$service' AND";
        }


        if (!empty($from) && !empty($to)) {
            $where .= " b.adddate BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($from) && empty($to)) {
            $where .= " b.adddate ='$from' AND";
        }

        if (empty($from) && !empty($to)) {
            $where .= " b.adddate ='$to' AND";
        }




        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>


    <!--search bar-->
    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row">

            <div class="col-sm">


                <?php
                $sql1 = "SELECT serviceid,servicename FROM tbl_services WHERE deletestatus='1'";
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

                <input type="date" name="from" value="<?php echo @$from; ?>" placeholder="Enter From Date" max="<?php echo date('Y-m-d') ?>">
                <span>From Date:</span>
            </div>

            <div class="col-sm">

                <input type="date" name="to" placeholder="Enter To Date" value="<?php echo @$to; ?>" max="<?php echo date('Y-m-d') ?>">
                <span>Date To:</span>
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



            <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
        </div>
            </form>



    <?php
    if (empty($rep_type) && (!empty($where) || empty($where))) {
        //all vehicles expenditures

        $userid = $_SESSION['customer_userid'];
        $sql = "SELECT b.adddate,sum(b.grosspayment)as total,count(b.serviceid) as countservice,s.servicename,c.firstname,c.lastname FROM tbl_billpayment b INNER JOIN tbl_services s ON s.serviceid=b.serviceid INNER JOIN tbl_customers c ON c.userid=b.customeruserid WHERE b.deletestatus=1 $where AND c.userid=$userid ";
        $db = dbconn();
        $result = $db->query($sql);
        ?>    

        <div class="table-responsive">
            <!-- View of All vehicle -->
        
            <div id="report">
                <h4>Customer Expenditures Report</h4>
                <table border="1" class="table table-striped">
                    <thead>
                        <tr>
                            

                            <th>Customer name</th>

                            <th>Gross payment</th>
                            <th>Count</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalamount = 0;
                        if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) {
                                ?>
                                <tr>

                                    

                                    <td> <?php echo $rows['firstname'] . " " . $rows['lastname']; ?></td>
                                    <td> <?php echo $rows['total']; ?></td>
                                    <td> <?php echo $rows['countservice']; ?></td>




                                    <?php
                                    $totalamount += $rows['total'];
                                    ?>


                                </tr>


                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="2">Total Payment:</td>

                            <td><?= number_format($totalamount,2) ?></td>                              
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    ?>

    <?php
    if (@$rep_type == 'Daily') {
        $userid = $_SESSION['customer_userid'];
        $sqltbl = "SELECT b.serviceid,b.adddate,count(jobcardid) AS count,sum(b.grosspayment) as totalpayment,c.firstname,c.lastname FROM tbl_billpayment b INNER JOIN tbl_customers c ON c.userid=b.customeruserid WHERE b.deletestatus='1' $where AND c.userid=$userid GROUP BY b.adddate";
        $result = $db->query($sqltbl);
        ?>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>No of Jobs</th>
                   
                    <th>Total payment</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $totaljobs = 0;
                $totalpay = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['adddate'] ?></td>
                        <td>
                            <?php
                            echo $row['count'];
                            @$totaljobs += $row['count'];
                            ?>
                        </td>

                        
                        <td>
                            <?php
                            echo $row['totalpayment'];
                            $totalpay += $row['totalpayment'];
                            ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            <td>Total Number of Jobs : <?php echo $totaljobs; ?></td>

            <td>Total Sales  : Rs. <?php echo number_format($totalpay, 2); ?></td>
            </tbody>

        </table>
        <?php
    }


    if (@$rep_type == 'Monthly') {
         $userid = $_SESSION['customer_userid'];
        $sqltbl = "SELECT MONTH(b.adddate) AS month,count(jobcardid) AS count,sum(b.grosspayment) as totalpayment,b.serviceid,c.firstname,c.lastname FROM tbl_billpayment b INNER JOIN tbl_customers c ON c.userid=b.customeruserid WHERE b.deletestatus='1' $where AND c.userid=$userid GROUP BY MONTH(b.adddate)";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>customer name</th>
                    <th>No of Jobs</th>
                    <th>Total payment</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $totalcount = 0;
                $totalpay = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)) ?></td>
                        
                        <td><?php echo $row['firstname']." ".$row['lastname'] ?>;</td>
                        <td><?php
                            echo $row['count'];
                            $totalcount += $row['count'];
                            ?>
                        </td>

                        <td><?php
                            echo $row['totalpayment'];
                            $totalpay += $row['totalpayment'];
                            ?>
                        </td>




                    </tr>


                    <?php
                }
                ?>
            <td>Total Number of Jobs : <?php echo $totalcount; ?></td>
            <td>Total payments : <?php echo number_format($totalpay,2); ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>


</main>




<?php
include '../customerfooter.php';
?>

