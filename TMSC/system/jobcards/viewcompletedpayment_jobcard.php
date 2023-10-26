<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>
<style>
    table, th, td {
        border:1px solid black;
    }  


</style>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Completed payment job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/completedpayment_jobcards.php" type="button" class="btn btn-sm btn-outline-secondary">View all completed payment job cards</a>
               
            </div>
            
        </div>
    </div>


    <?php
    extract($_GET);
    $db = dbconn();
    $messages = array();

    // view selected job card details
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == 'completedpayment') {

        $date = date('Y-m-d');

        $sqltbl = "SELECT j.reservationid,j.jobcardid,j.reservationdate,j.starttime,j.endtime,j.deletestatus,j.serviceid,j.testride,j.freeservicestatus,j.jobcardstatus,j.vehicleid,c.firstname,c.lastname,r.bay,r.reservationid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,vou.voucherimage,vou.vouchercode FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_customers c ON c.userid=j.customeruserid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid INNER JOIN tbl_reservations r ON r.reservationid=j.reservationid LEFT JOIN tbl_servicevoucher vou ON vou.jobcardid=j.jobcardid WHERE j.jobcardstatus='finished' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";

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
    }


  
    ?>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="jobcardid" value='<?php echo @$jobcardid; ?>' readonly> 
        <input type="hidden" name="serviceid" value='<?php echo @$serviceid; ?>' readonly> 
        <input type="hidden" name="vehicleid" value='<?php echo @$vehicleid; ?>' readonly> 
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

        <div class="row">
           


            <div class="col-6">

                <a href="completedpayment_jobcards.php" class="btn card-btn">Back</a>
            </div>
        </div>


    </form>


</main>
<?php include '../footer.php'; ?>