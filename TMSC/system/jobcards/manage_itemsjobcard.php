<?php include '../header.php'; ?>

<!-- table styles -->
<style>
    table, th, td {
        border:1px solid black;
    }      
</style>

<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage items Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>jobcards/issue_itemsjobcard.php" type="button" class="btn btn-sm btn-outline-secondary">View all assigned item Job cards</a>
                
            </div>
            
        </div>
    </div>

    <h6>Manage items for Job card</h6>

    <?php
    //extract get variable values
    extract($_GET);
    //extract post variable values
    extract($_POST);

    $db = dbconn();

    $date = date('Y-m-d');
    $sqltbl = "SELECT j.jobcardid,j.jobcardstatus,j.vehicleid,s.servicename,s.serviceid,v.vehicleid,v.plateno,v.plateimage,v.modelid,v.brandid,v.year FROM tbl_jobcards j INNER JOIN tbl_services s ON s.serviceid=j.serviceid INNER JOIN tbl_vehicles v ON v.vehicleid=j.vehicleid  WHERE j.jobcardstatus='pending' AND j.deletestatus=1 AND j.reservationdate='$date' AND j.jobcardid='$jobcardid'";
    $result = $db->query($sqltbl);
    $row = $result->fetch_assoc();

    $modelid = $row['modelid'];
    $plateimage = $row['plateimage'];
    $servicename = $row['servicename'];
    $serviceid = $row['serviceid'];
    $plateno = $row['plateno'];
    $brandid = $row['brandid'];
    $year = $row['year'];
    $jobcardid = $row['jobcardid'];

    $sql1 = "SELECT brandname FROM tbl_brands WHERE brandid= $brandid";
    $result1 = $db->query($sql1);
    $row1 = $result1->fetch_assoc();
    $brandname = $row1['brandname'];

    $sql2 = "SELECT modelname,vehicletype FROM tbl_models WHERE modelid= $modelid";
    $result2 = $db->query($sql2);
    $row2 = $result2->fetch_assoc();
    $modelname = $row2['modelname'];
    $vehicletype = $row2['vehicletype'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'issue') {

        $messages = array();
        $db = dbConn();
        $date = date('Y-m-d');
        $order = $issue_qty;

        $i = 0;

        while ($i < $order) {
            $sql = "SELECT * FROM tbl_itemstock WHERE catalogid='$catalogid' AND stockstatus='1' ORDER BY purchasedate ASC LIMIT 1";
            $result_stock = $db->query($sql);
            if ($result_stock->num_rows > 0) {
                while ($row = $result_stock->fetch_assoc()) {
                    //get available quntity of item stock
                    $stock = $row['quntity'] - $row['issuedqty'];
                    $issue = $order - $i;
                    //if stock is greater than or equal to order
                    if ($stock >= $issue) {
                        //if stock and order equal
                        if ($stock == $issue) {
                            $status = 0;
                        } else {
                            //if have remaing stock
                            $status = 1;
                        }

                        $sql = "UPDATE tbl_itemstock  SET issuedqty= issuedqty +'" . $issue . "', stockstatus='$status' WHERE itemstockid='" . $row['itemstockid'] . "'";
                        $db->query($sql);

                        $sql1 = "UPDATE tbl_jobcardorderitems SET amount=amount + '" . $row['sellingprice'] * $issue . "' WHERE jobcardorderid='$orderid'";
                        $db->query($sql1);

                        $sql2 = "UPDATE tbl_jobcards SET itemstotalprice= itemstotalprice+ '" . $row['sellingprice'] * $issue . "' WHERE jobcardid='$jobcardid'";
                        $db->query($sql2);

                        $sql3 = "UPDATE tbl_jobcardassignitems SET amount= amount + '" . $row['sellingprice'] * $issue . "',issuestatus='done',issueqty= issueqty + '" . $issue . "',issuedate='$date' WHERE jobcardassignitemid=$jobcardassignitemid";
                        $db->query($sql3);
                        //success message
                        showSuccMeg();

                        $i += $issue;
                    } else {
                        // if there are not available items qty into first record stock
                        //get issue qty 
                        $issue = $order - $i;

                        if ($issue >= $stock) {
                            //issue item available stock quntity
                            $issue = $stock;
                            $status = 0;
                        } else {
                            $status = 1;
                        }
                        $sql = "UPDATE tbl_itemstock  SET issuedqty= issuedqty + '" . $issue . "', stockstatus='$status' WHERE itemstockid='" . $row['itemstockid'] . "'";
                        $db->query($sql);

                        $sql1 = "UPDATE tbl_jobcardorderitems SET amount=amount + '" . $row['sellingprice'] * $issue . "' WHERE jobcardorderid='$orderid'";
                        $db->query($sql1);

                        $sql2 = "UPDATE tbl_jobcards SET itemstotalprice= itemstotalprice+ '" . $row['sellingprice'] * $issue . "' WHERE jobcardid='$jobcardid'";
                        $db->query($sql2);

                        $sql3 = "UPDATE tbl_jobcardassignitems SET amount= amount + '" . $row['sellingprice'] * $issue . "',issuestatus='done',issueqty= issueqty + '" . $issue . "',issuedate='$date' WHERE jobcardassignitemid=$jobcardassignitemid";
                        $db->query($sql3);

                        //success message
                        showSuccMeg();

                        $i += $issue;
                    }
                }
            } else {
                //when stock unavailable
                $i = $order;
                $messages['error_stock'] = "Stock is not available..!";
            }
        }
    }
    ?>


    <div class="card px-md-4 mb-2 my-card-bg">
        <div class="row">
            <div class="col-md-8">
                <legend>Vehicle Details:</legend>

                <div class="mb-3">
                    <label class="form-label">Plate No</label>
                    <input type="text" name="plateno" class="form-control" value='<?php echo @$plateno; ?>'readonly >


                </div>
                <div class="mb-3">
                    <label class="form-label">Brand Name</label>
                    <input type="text" name="brandname" class="form-control" value='<?php echo @$brandname; ?>'readonly >

                </div>
                <div class="mb-3">
                    <label class="form-label">Vehicle Model Name</label>
                    <input type="text" name="model" class="form-control" value='<?php echo @$modelname; ?>'readonly >

                </div>
                <div class="mb-3">
                    <label class="form-label">Vehicle Type</label>
                    <input type="text" name="vtype" class="form-control" value='<?php echo @$vehicletype; ?>'readonly >

                </div> 
                <div class="mb-3">
                    <label class="form-label">Vehicle Year</label>
                    <input type="text" name="year" class="form-control" value='<?php echo @$year; ?>'readonly >


                </div>

            </div>
            <div class="col-md-4 mb-2 mt-2">
                <img class="img-fluid" width="350" height="350" src="<?= WEB_PATH ?>vehicles/images/<?= @$plateimage; ?>">
                <input type="hidden" name="plateimage" class="form-control" value='<?php echo @$plateimage; ?>'readonly >
            </div>    
        </div> 
    </div>    


    <div class="card px-md-4 mb-2 my-card-bg">
        <div class="text-danger"><?php echo @$messages['error_stock']; ?></div>
       
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Issue Qty</th>

                </tr>          
            </thead>


            <?php
            $sql = "SELECT ai.quantity,ai.jobcardassignitemid,ai.adddate,ai.orderid,ca.itemname,ca.catalogid,j.jobcardid from tbl_jobcards j INNER JOIN tbl_jobcardassignitems ai ON ai.jobcardid=j.jobcardid INNER JOIN tbl_itemcatalog ca ON ca.catalogid=ai.catalogid WHERE ai.jobcardid=$jobcardid AND ai.deletestatus=1 AND ai.issuestatus='none'";
            $db = dbconn();
            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $row['adddate'] ?></td>
                            <td><?= $row['itemname'] ?></td>    
                            <td><?= $row['quantity'] ?></td>

                            <!-- issued item from inventory-->
                            <td>


                                <form method="post"  action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                    



                                    <input type='hidden' name='issue_qty' value='<?= $row['quantity'] ?>'>


                                    <input type='hidden' name='action' value='issue'>
                                    <input type="hidden" name="jobcardid" value="<?= $jobcardid ?>">
                                    <input type="hidden" name="orderid" value="<?= $row['orderid'] ?>">
                                    <input type="hidden" name="jobcardassignitemid" value="<?= $row['jobcardassignitemid'] ?>">
                                    <input type="hidden" name="catalogid" value="<?= $row['catalogid'] ?>">
                                    <button class="btn card-btn btn-sm mt-2 mb-2 mx-1 " onclick="this.form.submit()">Issue item</button>

                                </form>

                            </td>    
                        </tr> 
                    </tbody>

                    <?php
                }
            }else{
                echo "<div class='alert alert-danger'>"."There are no items to issue"."</div>";
            }
            ?>  
        </table>

    </div>

</main>
<?php
include '../footer.php';
?>
