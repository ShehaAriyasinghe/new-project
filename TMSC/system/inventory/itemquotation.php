<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<?php
extract($_GET);
extract($_POST);
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Item Quotation</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-5">

                <a href="<?= SYSTEM_PATH; ?>inventory/itemcategoriescards.php" type="button" class="btn btn-sm btn-outline-secondary">View item categories</a>

            </div>

        </div>
    </div>

    <h5>Item Quotation.</h5>

    <?php
    extract($_GET);
    extract($_POST);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sql2 = "SELECT * FROM tbl_suppliers WHERE supplierid='$supplierid'";
        $db = dbConn();
        $result = $db->query($sql2);

        while ($row = $result->fetch_assoc()) {
            $companyname = $row['companyname'];
            $email = $row['email'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operation == 'submit') {

        if (empty($supplierid)) {
            $messages['error_supplier'] = "supplier should not be empty...!";
        }


        if (empty($itemname)) {
            $messages['error_catalog'] = "Item should not be empty...!";
        }
        if (empty($note)) {
            $messages['error_note'] = "Note should not be empty...!";
        }

        if (empty($quantity)) {
            $messages['error_qty'] = "Quantity should not be empty...!";
        }

        if (empty($from)) {
            $messages['error_from'] = "Station email should not be empty...!";
        }

        if (empty($to)) {
            $messages['error_to'] = "Supplier email should not be empty...!";
        }




        if (!empty($quantity)) {
            if (!preg_match('/^[0-9 ]+$/i', $quantity)) {
                $messages['error_qty'] = "Quntity is allowed numbers only.";
            }
        }




        if (empty($messages)) {
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "INSERT INTO tbl_itemquotation(supplierid,catalogid,itemname,quantity,note,adddate,adduser) VALUES('$supplierid','$catalogid','$itemname','$quantity','$note','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);

            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <input type="hidden" name="catalogid" value="<?= @$catalogid ?>">
        <div class="row">
            <div class="col-md-6">

                <div class="input-group-md mb-3 mt-3">
                    <?php
                    $sql = "SELECT s.companyname,s.supplierid FROM tbl_itemsofsupplier ios INNER JOIN tbl_suppliers s ON s.supplierid=ios.supplierid WHERE ios.catalogid='$catalogid' AND s.deletestatus=1;";
                    $db = dbConn();
                    $result = $db->query($sql);
                    ?>
                    <label class="form-label">Select a Supplier  :</label>
                    <select class="form-select w-75 border-dark" name="supplierid" id="supplierid" onchange="form.submit()">
                        <option value="">--</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $row['supplierid']; ?>" <?php if (@$supplierid == $row['supplierid']) { ?> selected <?php } ?>><?php echo ucfirst($row['companyname']); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php echo @$messages['error_supplier']; ?></div>

                </div>           
            </div>
            <div class="col-md-6">

                <?php
                $sql = "SELECT itemname,itemimage,modelno FROM tbl_itemcatalog WHERE catalogid='$catalogid' AND deletestatus=1;";
                $db = dbConn();
                $result = $db->query($sql);
                $rows = $result->fetch_assoc();

                $itemimage = $rows['itemimage'];
                $itemname = $rows['itemname'];
                $itemmodel = $rows['modelno'];
                ?>





            </div>

        </div>
        <?php
        $sql3 = "SELECT * FROM  tbl_stationdetails";
        $result = $db->query($sql3);
        $row = $result->fetch_assoc();
        $stationname = $row['name'];
        $stationemail = $row['email'];
        $stationaddress = $row['address'];
        ?>

        <div class="row">

            <h4><?= $stationname ?></h4>
            <div class="col-md-6">
                <label class="form-label">From address:</label><br>
                <p> <?= $stationname ?></p>
                <p><?= @$stationaddress ?></p>





                <input name="from" class="form-control" value="<?= $stationemail ?>"  readonly> 
                <div class="text-danger"><?php echo @$messages['error_from']; ?></div>



            </div>

            <div class="col-md-6">
                <label class="form-label">To address:</label><br>

                <p> <?= @$companyname ?></p>
                <p> <?php echo @$firstname . " " . @$lastname; ?></p>
                <input name="to" class="form-control" value="<?= @$email ?>"  readonly>
                <div class="text-danger"><?php echo @$messages['error_to']; ?></div>

            </div>


        </div>

        <div class="row">


            <table class="table table-striped">
                <thead>
                <th>Item Name</th>                               
                <th>Item Image</th>
                <th>Item Model</th>
                <th>Expected Qty</th>
                </thead>
                <tbody>


                    <tr>

                        <td> 
                            <input type="text" name="itemname" value="<?= @$itemname ?>"readonly>

                        </td>

                        <td>
                            <img src="<?= SYSTEM_PATH ?>inventory/images/<?= $itemimage ?>" class="img-fluid w-25">
                        </td>
                        <td>
                            <?= $itemmodel; ?>
                        </td>

                        <td>

                            <input type="number" name="quantity" value="<?= @$quantity ?>">

                        </td>


                    </tr>

                </tbody>
            </table>
            <div class="text-danger"><?php echo @$messages['error_qty']; ?></div>

        </div>   




        <div class="row">
            <div class="col-md-6">

                <label class="form-label">Note:</label><br>
                <textarea  name="note" rows="4" cols="50"><?php echo @$note ?></textarea>
                <div class="text-danger"><?php echo @$messages['error_note']; ?></div>
            </div>
        </div>


        <div class="row justify-content-left">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary" name="operation" value="submit">Submit</button>
            </div>

        </div>    









    </form>











</main>


<?php include '../footer.php'; ?>
