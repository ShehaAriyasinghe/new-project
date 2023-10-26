<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Customer Jobs Payment</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">


            </div>

        </div>
    </div>

    <?php
    extract($_GET);

    if (@$mode == 'view') {


        //all vehicles relevent customer

        $userid = $_SESSION['customer_userid'];
        $sql = "SELECT v.vehicleid,v.plateno,v.plateimage,b.serviceid,b.grosspayment,b.servicepayment,b.adddate,b.itemtotalpayment,b.subservicetotalpayment,b.grosspayment,b.servicefreestatus FROM tbl_billpayment b INNER JOIN tbl_vehicles v ON v.vehicleid=b.vehicleid WHERE v.deletestatus='1' AND b.vehicleid='$vehicleid'";
        $db = dbconn();
        $result = $db->query($sql);
        ?>    
        <div class="card my-card-bg px-2"> 
            <div class="table-responsive">
                <!-- View of All job cards -->
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Plate No</th>
                             <th>Service Name</th>
                            
                            <th>Service payment</th>
                            <th>Item payment</th>
                            <th>Sub service payment</th>
                            <th>Gross payment</th>
                            <th>Service free status </th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) {
                                ?>
                                <tr>

                                    <td><?php echo $rows['adddate']; ?></td>
                                    <td><?php echo $rows['plateno']; ?></td>
                                    <td><?php 
                                    $serviceid=$rows['serviceid'];
                                    $sqlser="SELECT servicename FROM tbl_services WHERE serviceid='$serviceid'";
                                    $resser=$db->query($sqlser);
                                    $rowser=$resser->fetch_assoc();
                                    $servicename=$rowser['servicename'];
                                    echo $servicename;
                                    
                                    ?></td>
                                   
                                    <td> <?php echo $rows['servicepayment']; ?></td>
                                    <td> <?php echo $rows['itemtotalpayment']; ?></td>
                                    <td> <?php echo $rows['subservicetotalpayment']; ?></td>
                                    <td> <?php echo $rows['grosspayment']; ?></td>
                                    <td> <?php echo $rows['servicefreestatus']; ?></td>




                                    

                                </tr>


                                <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>    


        <?php
    } else {



        //search vehicle
        $where = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (!empty($plateno)) {
                $where .= " v.plateno LIKE '$plateno%' AND";
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
                <div class="col">
                    <input type="text" class="form-control" name="plateno" placeholder="Plate no" value="<?= @$plateno; ?>">
                </div>


                <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
            </div>
                </form>



        <?php
        //all vehicles relevent customer

        $userid = $_SESSION['customer_userid'];
        $sql = "SELECT v.vehicleid,v.plateno,v.plateimage,b.adddate,sum(b.grosspayment)as total  FROM tbl_billpayment b INNER JOIN tbl_vehicles v ON v.vehicleid=b.vehicleid WHERE b.customeruserid='$userid' $where GROUP BY b.vehicleid";
        $db = dbconn();
        $result = $db->query($sql);
        ?>    
        <div class="card my-card-bg px-2"> 
            <div class="table-responsive">
                <!-- View of All job cards -->
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Plate No</th>
                            <th>Vehicle Image</th>
                            <th>Gross payment</th>



                            <th>Action</th>
                          


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) {
                                ?>
                                <tr>

                                    <td><?php echo $rows['adddate']; ?></td>
                                    <td><?php echo $rows['plateno']; ?></td>
                                    <td><img width="150" height="150" src="<?= WEB_PATH ?>vehicles/images/<?= $rows['plateimage']; ?>"></td>
                                    <td> <?php echo $rows['total']; ?></td>




                                    <td><a href="<?= WEB_PATH ?>payments/viewjobcardpayment.php?mode=view&vehicleid=<?php echo $rows['vehicleid'] ?>" class="btn card-btn  btn-sm">View payments</a></td>

                                    


                                </tr>


                                <?php
                            }
                        } else {
                            echo "<div class='alert alert-danger'>" . "There are no vehicles" . "</div>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>  
        <?php
    }
    ?>
</main>





<?php
include '../customerfooter.php';
?>

