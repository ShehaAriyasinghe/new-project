<?php include '../customerheader.php'; ?>
<?php include '../customermenu.php'; ?>
<?php
extract($_GET);
extract($_POST);
?>  
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">View vehicle job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
 <a href="<?= WEB_PATH; ?>vehiclejobcard/viewjobcardvehicles.php" type="button" class="btn btn-sm btn-outline-secondary">View all Job card vehicles</a>

            </div>

        </div>
    </div>

    <?php
    // view selected job card details
    if (@$mode == 'view') {



        $sqltbl = "SELECT j.reservationid,j.jobcardid,j.reservationdate,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.testride,j.freeservicestatus,j.jobcardstatus,j.vehicleid,c.firstname,c.lastname,r.bay,r.reservationid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,vou.voucherimage,vou.vouchercode FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_customers c ON c.userid=j.customeruserid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid LEFT JOIN tbl_servicevoucher vou ON vou.jobcardid=j.jobcardid WHERE j.deletestatus=1 AND j.jobcardid='$jobcardid'";
        $db = dbconn();
        $result = $db->query($sqltbl);
        $row = $result->fetch_assoc();
        $serviceid = $row['serviceid'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $plateimage = $row['plateimage'];
        $plateno = $row['plateno'];
        $reservationdate = $row['reservationdate'];
        $time = date('H:i', strtotime($row['starttime'])) . '-' . date('H:i', strtotime($row['endtime']));
        $bay = $row['bay'];
        $jobcardstatus = ucfirst($row['freeservicestatus']);
        $voucherimage = $row['voucherimage'];
        $vouchercode = $row['vouchercode'];
        $servicename = $row['servicename'];
        $vehicleid = $row['vehicleid'];
        ?>


        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <legend>Person Details:</legend>


                            <label for="firstname" class="form-label">First Name:</label>
                            <input type="text" name="firstname" class="form-control" value='<?php echo $firstname; ?>' readonly>  

                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name:</label>
                            <input type="text" name="lastname" class="form-control" value='<?php echo $lastname; ?>' readonly>  

                        </div>

                    </div>
                    <div class="col-md-4 mt-2">
                        <img class="img-fluid" src="<?= WEB_PATH ?>vehicles/images/<?= $plateimage ?>">
                        <input type="hidden" name="plateimage" class="form-control" value='<?php echo $plateimage; ?>' readonly>  

                        <legend>Vehicle Details:</legend>
                        <div class="mb-3">
                            <label class="form-label">Plate No</label>
                            <input type="text" name="plateno" class="form-control" value='<?php echo $plateno; ?>'readonly >

                        </div>  

                    </div>



                </div> 
            </div>    
            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-6">    
                        <legend>Service Details:</legend>    

                        <div class="mb-3">
                            <label class="form-label">Selected Date:</label>
                            <input type="date" class="form-control border-dark" name="reservationdate" value="<?php echo $reservationdate; ?>" readonly>           
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Selected Time:</label>
                            <input type="text" name="time" class="form-control" value="<?php echo $time; ?>" readonly>           
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="mb-3">
                            <label class="form-label">Bay</label>
                            <input type="text" name="bay" class="form-control" value='<?php echo $bay; ?>' readonly>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Free Service Available</label>
                            <input type="text" name="jobcardstatus" class="form-control" value='<?php echo $jobcardstatus; ?>' readonly>
                            <div class="text-danger"><?php echo @$messages['error_jobcardstatus']; ?></div>

                            <?php
                            //display voucher image 
                            if ($jobcardstatus == 'Yes') {
                                ?>
                                <div class="col-md-4 mt-2 mb-2">
                                    <img class="img-fluid" src="<?= SYSTEM_PATH ?>jobcards/images/<?= $voucherimage ?>">
                                    <input type="hidden" name="voucherimage" value='<?php echo $voucherimage; ?>' readonly>

                                    <label class="form-label">Voucher code:</label>
                                    <input type="text" name="vouchercode" value='<?php echo $vouchercode; ?>' readonly>


                                </div> 

                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>




            <div class="card px-md-4 mb-2 my-card-bg">

                <legend>Investigation Report:</legend>


                <table class="">
                    <thead class="card-btn">
                        <tr>
                            <th>Task</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <?php
                    $db = dbconn();
                    $sql = "SELECT i.taskname,ji.taskstatus,ji.investigationtaskid FROM tbl_investigationtasks i INNER JOIN tbl_jobcardinvestigationtasks ji ON i.investigationtaskid=ji.investigationtaskid WHERE ji.jobcardid=$jobcardid AND ji.deletestatus='1'";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($rows = $result->fetch_assoc()) {
                            ?>

                            <tr class="my-card-bg">
                                <td>
                                    <?php echo $rows['taskname'] . ":"; ?>
                                </td>    
                                <td>
                                    <?php echo ucfirst($rows['taskstatus']) ?>
                                </td>


                            </tr>

                            <?php
                        }
                    } else {
                        echo "There are no records updated yet.";
                    }
                    ?>   
                </table>   


            </div>







            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-6">

                        <legend>Service Report:</legend>  
                        <div class="mb-3">
                            <label class="form-label">Service Type:</label>
                            <input type="text" class="form-control-md" name=servicename value='<?php echo @$servicename; ?>' readonly>           
                        </div>
                        <label class="form-label">Report of service task list:</label>
                        <div class = "mb-2">
                            <?php
                            $db = dbconn();
                            $sql = "SELECT sub.subservicename,checkedservice.status FROM tbl_checkedservicetasks checkedservice INNER JOIN tbl_subservices sub ON sub.subserviceid=checkedservice.subserviceid WHERE checkedservice.jobcardid=$jobcardid AND sub.deletestatus='1'";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                while ($rows = $result->fetch_assoc()) {
                                    ?>
                                    <div class="mb-1">
                                        <label><?php echo $rows['subservicename'] . " :"; ?></label>
                                        <?php echo ucfirst($rows['status']); ?>

                                    </div>
                                    <?php
                                }
                            } else {
                                echo "There are no records updated yet.";
                            }
                            ?>
                        </div>
                    </div>


                    <div class="col-md-6">

                        <lable class="form-label">Additional sub services:</lable><br>

                        <?php
                        $db = dbconn();
                        $sql = "SELECT sub.subserviceid,sub.subservicename,checksub.status FROM tbl_checkedsubservicetasks checksub INNER JOIN tbl_subservices sub ON sub.subserviceid=checksub.subserviceid  WHERE checksub.deletestatus='1' AND checksub.jobcardid='$jobcardid'";
                        $result = $db->query($sql);
                        $count = $result->num_rows;
                        if ($count == '0') {

                            echo "<div class='mb-2'>" . "There are no selected sub services...!" . "</div>";
                        } else {
                            while ($rows = $result->fetch_assoc()) {
                                $subservicename = $rows['subservicename'];
                                $subserviceid = $rows['subserviceid'];
                                $status = $rows['status'];
                                ?> 


                                <label class="form-label"><?= $subservicename; ?>: </label>
                                <div class="mb-3">
                                    <div class = "form-check form-check-inline">
                                        <?php echo ucfirst($status); ?>
                                    </div>

                                </div>


                                <?php
                            }
                        }
                        ?>


                        <label>Test ride: </label>
                        <div class="mb-3">
                            <div class = "form-check form-check-inline">
                                <?php echo ucfirst($row['testride']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="card px-md-4 mb-2 my-card-bg">
                <div class="row">
                    <div class="col-md-6">


                        <legend>Service Bill Payment:</legend>  
                        <div class="mb-3">
                            <label class="form-label">Service Type:</label>
                            <input type="text" class="form-control-md" name="servicename" value='<?php echo @$servicename; ?>' readonly>           
                        </div>
                        <div class="text-danger"><?php echo @$messages['error_service']; ?></div>
                        <label class="form-label">Service task list:</label>


                        <table>
                            <tr>
                                <th>Service task list</th>                    
                                <th>Price</th>                         
                            </tr>
                            <tbody>



                                <?php
                                $servicetotal = 0;
                                $db = dbconn();
                                $sql = "SELECT sub.subservicename,sub.subserviceprice FROM tbl_jobcardassignserviceslist st INNER JOIN tbl_subservices sub ON sub.subserviceid=st.subserviceid WHERE st.jobcardid=$jobcardid AND st.deletestatus='1'";
                                $result = $db->query($sql);

                                while ($rows = $result->fetch_assoc()) {
                                    ?>


                                    <tr>
                                        <td>  
                                            <?php echo $rows['subservicename'] . ": ";
                                            ?>
                                        </td>
                                        <td>  
                                            <?php echo $rows['subserviceprice'];
                                            ?>
                                        </td>



                                        <td>
                                            <?php
                                            $servicetotal = $servicetotal + $rows['subserviceprice'];
                                            ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td></td>
                                        <td>   
                                            <?php
                                        }

                                        if ($jobcardstatus == 'Yes') {
                                            $servicetotal = 0;
                                            echo "Total Amount:" . "<br>" . "Rs. " . number_format($servicetotal, 2);
                                            ?>
                                            <input type="hidden" name="servicetotal" value='<?php echo @$servicetotal; ?>'> 
                                            <?php
                                        } else {
                                            echo "Total Amount:" . "<br>" . "Rs. " . number_format($servicetotal, 2);
                                            ?>
                                            <input type="hidden" name="servicetotal" value='<?php echo @$servicetotal; ?>'> 
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-6 mb-3">
                        <!<!-- additional sub services payments -->
                        <lable class="form-label">Additional sub services list:</lable><br>





                        <?php
                        $subservicetotal = 0;
                        $db = dbconn();
                        $sql = "SELECT sub.subserviceid,sub.subservicename,sub.subserviceprice FROM tbl_jobcardassignsubservices a INNER JOIN tbl_subservices sub ON sub.subserviceid=a.subserviceid  WHERE a.jobcardid=$jobcardid AND a.deletestatus='1'";
                        $result = $db->query($sql);
                        $count = $result->num_rows;
                        if ($count == '0') {

                            echo "<div class='alert alert-danger mb-2'>" . "There are no selected sub services...!" . "</div>";
                            ?>

                            <input type="hidden" name="subservicetotal" value='<?php echo @$subservicetotal; ?>'> 
                            <?php
                        } else {
                            ?>

                            <table>
                                <tr>
                                    <th>Sub service list</th>                    
                                    <th>Price</th>                         
                                </tr>
                                <tbody>

                                    <?php
                                    while ($rows = $result->fetch_assoc()) {
                                        $subservicename = $rows['subservicename'];
                                        $subserviceid = $rows['subserviceid'];
                                        $subserviceprice = $rows['subserviceprice'];
                                        $subservicetotal += $subserviceprice;
                                        ?> 
                                        <tr>
                                            <td>
                                                <?php echo $subservicename; ?>
                                            </td>
                                            <td>

                                                <?php echo $subserviceprice; ?>

                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td> <?php echo "Total Amount:" . "<br>" . "Rs. " . number_format($subservicetotal, 2); ?></td>       
                                <input type="hidden" name="subservicetotal" value='<?php echo @$subservicetotal; ?>'> 

                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>    








                        <!--added spare parts payments-->
                        <br>

                        <lable class="form-label">Added spare parts list:</lable><br>


                        <?php
                        $totalitemamount = 0;
                        $db = dbconn();
                        $sql = "SELECT ai.issueqty,ic.itemname,ai.amount FROM tbl_jobcardassignitems ai INNER JOIN tbl_itemcatalog ic ON ic.catalogid=ai.catalogid  WHERE ai.jobcardid=$jobcardid AND ai.deletestatus='1' AND issuestatus='done'";
                        $result = $db->query($sql);
                        $count = $result->num_rows;
                        if ($count == '0') {

                            echo "<div class='alert alert-danger mb-2'>" . "There are no selected Items...!" . "</div>";
                            ?>
                            <input type="hidden" name="totalitemamount" value='<?php echo @$totalitemamount; ?>'> 
                            <?php
                        } else {
                            ?>

                            <table>
                                <tr>
                                    <th>Item name</th>
                                    <th>Issue quantity</th>
                                    <th>Total Amount</th>                         
                                </tr>
                                <tbody>




                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        $quntity = $row['issueqty'];
                                        $itemname = $row['itemname'];
                                        $itemtotal = $row['amount'];
                                        $totalitemamount += $itemtotal;
                                        ?> 


                                        <tr>

                                            <td>
                                                <?php echo $itemname; ?>

                                            </td>
                                            <td>
                                                <?php echo $quntity; ?>

                                            </td>
                                            <td>
                                                <?php echo $itemtotal; ?>

                                            </td>
                                        </tr>



                                        <?php
                                    }
                                    ?>


                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo "Total Amount:" . "<br>" . " Rs. " . number_format($totalitemamount, 2) ?></td>
                                <input type="hidden" name="totalitemamount" value='<?php echo @$totalitemamount; ?>'> 

                                </tr>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8 fs-4">
                        Gross payment(Rs.):
                        <?php
                        $grosspayment = $totalitemamount + $subservicetotal + $servicetotal;
                        echo "Rs." . number_format($grosspayment, 2);
                        ?>
                        <input type="hidden" name="grosspayment" value="<?php echo @$grosspayment; ?>"> 
                    </div>
                    <div class="text-danger"><?php echo @$messages['error_grosspayment']; ?></div>

                </div>

            </div>



        </form>




        <?php
    } else {


        //search jobcard
        $where = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);

            if (!empty($servicename)) {
                $where .= " s.servicename LIKE '$servicename%' AND";
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
                    <input type="text" class="form-control" name="servicename" placeholder="Service name" value="<?= @$servicename; ?>">
                </div>

                <input type="hidden" name="vehicleid"  value="<?= @$vehicleid; ?>">

                <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
            </div>
                </form>


        <?php
        $sql = "SELECT j.jobcardid,j.adddate,v.vehicleid,v.plateno,b.grosspayment,s.servicename,s.serviceprice FROM tbl_jobcards j LEFT JOIN tbl_vehicles v ON j.vehicleid=v.vehicleid LEFT JOIN tbl_billpayment b ON j.jobcardid=b.jobcardid LEFT JOIN tbl_services s ON s.serviceid=j.serviceid WHERE j.deletestatus=1 AND j.jobcardstatus='finished' AND j.vehicleid='$vehicleid' $where";
        $db = dbconn();
        $result = $db->query($sql);
        ?>    
        <div class="card my-card-bg px-2"> 
            <div class="table-responsive">
                <!-- View of All job cards -->
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Job Date</th>
                            <th>Plate No</th>
                            <th>Service Name</th>
                            <th>Service Price</th>
                            <th>Payment</th>


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
                                    <td><?php echo $rows['servicename']; ?></td>
                                    <td><?php echo $rows['serviceprice']; ?></td>
                                    <td><?php echo $rows['grosspayment']; ?></td>

                                    <td><a href="<?= WEB_PATH ?>vehiclejobcard/view_vehiclejobcards.php?mode=view&jobcardid=<?php echo $rows['jobcardid'] ?>" class="btn card-btn  btn-sm">View</a></td>


                                </tr>


                                <?php
                            }
                        } else {
                            echo "<div class='alert alert-danger'>" . "There are no vehicles" . "</div>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>    
</main>





<?php
include '../customerfooter.php';
?>

