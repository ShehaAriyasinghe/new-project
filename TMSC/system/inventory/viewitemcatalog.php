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
        <h1 class="h2">View Item Catalog</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="itemcategoriescards.php" class="btn btn-sm btn-outline-secondary">View item catalog</a>

            </div>

        </div>
    </div>



    <?php
    extract($_GET);
    extract($_POST);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $sql = "SELECT ic.categoryid,ic.brandid,ic.subcategoryid,ic.itemname,ic.modelno,ic.itemcode,ic.itemimage,ic.vehicletype,ic.itemgrade,ic.capacity,ic.description,ic.reorderqty,ca.categoryname FROM tbl_itemcatalog ic INNER JOIN tbl_itemcategories ca ON ic.categoryid=ca.categoryid WHERE catalogid=$catalogid";
        $db = dbConn();
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        $categoryid = $row['categoryid'];
        $categoryname = $row['categoryname'];
        $subcategoryid = $row['subcategoryid'];
        $brandid = $row['brandid'];
        $itemname = $row['itemname'];
        $modelname = $row['modelno'];
        $itemcode = $row['itemcode'];
        $itemgrade = $row['itemgrade'];
        $capacity = $row['capacity'];
        $vehicletype = $row['vehicletype'];
        $itemimage = $row['itemimage'];
        $description = $row['description'];
        $reorderqty = $row['reorderqty'];

        unset($_SESSION['assignvehicles']);
        $sql = "SELECT v.vehicleid,v.vehicleimage,v.color,b.brandname,m.modelname,v.deletestatus,cv.catalogid FROM tbl_itemcatalog_vehicles cv LEFT JOIN tbl_centervehicles v ON cv.vehicleid=v.vehicleid INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus='1' AND cv.catalogid='$catalogid'";
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {

            $_SESSION['assignvehicles'][$row['vehicleid']] = array('brand' => $row['brandname'], 'model' => $row['modelname'], 'color' => $row['color'], 'vehicleimage' => $row['vehicleimage']);
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">

        <div class="input-group-md mb-3 mt-3">
            <input type="hidden" name="catalogid" value="<?= $catalogid; ?>">
            <?php
            $sql = "SELECT categoryid,categoryname FROM tbl_itemcategories WHERE deletestatus=1";
            $db = dbConn();
            $result = $db->query($sql);
            ?>
            <label class="form-label">Select a Category Name :</label>
            <select class="form-select w-75 border-dark" name="categoryid" id="categoryid" disabled>
                <option value="">--</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <option value="<?php echo $row['categoryid']; ?>" <?php if (@$categoryid == $row['categoryid']) { ?> selected <?php } ?>><?php echo $row['categoryname']; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <input type="hidden" name="categoryid" value="<?= $categoryid; ?>">
            <input type="hidden" name="categoryname" value="<?= $categoryname; ?>">


            <div class="text-danger"><?php echo @$messages['error_category']; ?></div>

        </div>





        <div class="input-group-md mb-3 mt-3">
            <?php
            if (isset($categoryid)) {
                $sql = "SELECT subcategoryid,subcategoryname FROM tbl_itemsubcategories WHERE categoryid='$categoryid' AND deletestatus=1";
                $db = dbConn();
                $result = $db->query($sql);
            }
            ?>
            <label class="form-label">Select Sub Category  :</label>
            <select class="form-select w-75 border-dark" name="subcategoryid" id="subcategoryid" disabled>
                <option value="">--</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <option value="<?php echo $row['subcategoryid']; ?>" <?php if (@$subcategoryid == $row['subcategoryid']) { ?> selected <?php } ?>><?php echo ucfirst($row['subcategoryname']); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <input type="hidden" name="subcategoryid" value="<?= $subcategoryid; ?>">
            <div class="text-danger"><?php echo @$messages['error_subcategory']; ?></div>

        </div>





        <?php
        if (@$categoryname == "spare parts") {
            // spare parts form fields
            ?>



            <div class="input-group-md mb-3 mt-3">
                <?php
                $sql = "SELECT brandid,brandname FROM tbl_itembrands WHERE subcategoryid='$subcategoryid' AND deletestatus=1";
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <label class="form-label">Select Brand Name :</label>
                <select class="form-select w-75 border-dark" name="brandid" id="brandid" disabled>
                    <option value="">--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value="<?php echo $row['brandid']; ?>" <?php if (@$brandid == $row['brandid']) { ?> selected <?php } ?>><?php echo ucfirst($row['brandname']); ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div class="text-danger"><?php echo @$messages['error_brand']; ?></div>

            </div>

            <div class="mb-3">
                <label for="itemname" class="form-label">Item Name</label>
                <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$itemname; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_item']; ?></div>
            </div>

            <div class="mb-3">
                <label for="modelname" class="form-label">Model Name</label>
                <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$modelname; ?>"readonly>
                <div class="text-danger"><?php echo @$messages['error_model']; ?></div>
            </div>


            <div class="mb-3">
                <label for="itemcode" class="form-label">Item Code</label>
                <input type="text" class="form-control w-75" id="itemcode" name="itemcode" value="<?= @$itemcode; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_itemcode']; ?></div>
            </div>





            <div class="mb-3">
                <?php
                if (isset($_SESSION['assignvehicles'])) {
                    ?>
                    <table>
                        <thead>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Image</th>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($_SESSION['assignvehicles']as $key => $value) {
                                ?>


                                <tr>
                                    <td>
                                        <?= $value['brand']; ?>
                                    </td>
                                    <td>
                                        <?= $value['model']; ?>
                                    </td>

                                    <td>
                                        <img class="img-fluid" width="100" height="150" src="<?= SYSTEM_PATH ?>vehicles/images/<?= $value['vehicleimage']; ?>">
                                    </td>



                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Item Image:</label><br>
                <img class="img-fluid" width="150" height="150" src="<?= SYSTEM_PATH ?>inventory/images/<?= !empty($itemimage) ? $itemimage : 'noimage.png' ?>">



                <input type="hidden" name="previousproductimage" value="<?= $itemimage ?>">
                <input type="hidden" name="itemimage" value="<?= $itemimage ?>">`

            </div>





            <div class="mb-3">
                <label for="description" class="form-label">Item Technical Description</label><br>
                <textarea rows="4" cols="50" name="description" readonly><?= @$description ?></textarea>
                <div class="text-danger"><?php echo @$messages['error_description']; ?></div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Reorder level</label>
                <input type="number" class="form-control w-75" id="reorderqty" name="reorderqty" value="<?= @$reorderqty; ?>" readonly >
                <div class="text-danger"><?php echo @$messages['error_reorder']; ?></div>
            </div>


            <div class="input-group-md mb-3 mt-3">
                <?php
                $sql = "SELECT s.companyname,s.supplierid FROM tbl_itemsofsupplier ios INNER JOIN tbl_suppliers s ON s.supplierid=ios.supplierid INNER JOIN tbl_itemcatalog c ON c.catalogid=ios.catalogid WHERE ios.catalogid='$catalogid' AND s.deletestatus=1;";
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <label class="form-label">Supplier  :</label>


                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="mb-2">

                            <?php echo ucfirst($row['companyname']); ?>

                        </div>
                        <?php
                    }
                }
                ?>
                </select>


            </div>












            <!--Oil form-->

            <?php
        }
        if (@$categoryname == "oil") {
            // oil form fields
            ?>

            <div class="input-group-md mb-3 mt-3">
                <?php
                $sql = "SELECT brandid,brandname FROM tbl_itembrands WHERE subcategoryid='$subcategoryid' AND deletestatus=1";
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <label class="form-label">Select Brand Name :</label>
                <select class="form-select w-75 border-dark" name="brandid" id="brandid" disabled>
                    <option value="">--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value="<?php echo $row['brandid']; ?>" <?php if (@$brandid == $row['brandid']) { ?> selected <?php } ?>><?php echo ucfirst($row['brandname']); ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <div class="text-danger"><?php echo @$messages['error_brand']; ?></div>

            </div>


            <div class="mb-3">
                <label for="itemname" class="form-label">Oil Name</label>
                <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$itemname; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_item']; ?></div>
            </div>

            <div class="mb-3">
                <label for="modelname" class="form-label">Model Name</label>
                <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$modelname; ?>" readonly >
                <div class="text-danger"><?php echo @$messages['error_model']; ?></div>
            </div>

            <div class="mb-3">
                <label for="itemcode" class="form-label">Item Code</label>
                <input type="text" class="form-control w-75" id="itemcode" name="itemcode" value="<?= @$itemcode; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_itemcode']; ?></div>
            </div>

            <div class="mb-3">
                <label for="itemgrade" class="form-label">Engine Oil Grade</label>
                <input type="text" class="form-control w-75" id="itemgrade" name="itemgrade" value="<?= @$itemgrade; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_itemgrade']; ?></div>
            </div>

            <div class="input-group-md mb-3 mt-3">

                <label class="form-label">Select Volumetric Capacity :</label>
                <select class="form-select w-75 border-dark" name="capacity" id="capacity" disabled>
                    <option value="">--</option>

                    <option value="250" <?php if (isset($capacity) && $capacity == "250") { ?>selected <?php } ?>>250ml</option>
                    <option value="500" <?php if (isset($capacity) && $capacity == "500") { ?>selected <?php } ?>>500ml</option>
                    <option value="750" <?php if (isset($capacity) && $capacity == "750") { ?>selected <?php } ?>>750ml</option>
                    <option value="1000" <?php if (isset($capacity) && $capacity == "1000") { ?>selected <?php } ?>>1l</option>

                </select>
                <div class="text-danger"><?php echo @$messages['error_capacity']; ?></div>
            </div>

            <div class="input-group-md mb-3 mt-3">

                <label class="form-label">Select Vehicle type:</label>
                <select class="form-select w-75 border-dark" name="vehicletype" id="vehicletype" disabled>
                    <option value="">--</option>
                    <option value="scooter" <?php if (isset($vehicletype) && $vehicletype = "scooter") { ?>selected <?php } ?>>Scooter</option>
                    <option value="motorbike" <?php if (isset($vehicletype) && $vehicletype = "motorbike") { ?>selected <?php } ?>>Motorbike</option>
                </select>
                <div class="text-danger"><?php echo @$messages['error_vehicletype']; ?></div>
            </div>



            <div class="mb-3">
                <label for="image" class="form-label">Item Image:</label><br>
                <img class="img-fluid" width="150" height="150" src="<?= SYSTEM_PATH ?>inventory/images/<?= !empty($itemimage) ? $itemimage : 'noimage.png' ?>">
                <input type="hidden" name="itemimage" value="<?= $itemimage ?>">`

                <input type="hidden" name="previousproductimage" value="<?= $itemimage ?>">

            </div>





            <div class="mb-3">
                <label for="description" class="form-label">Item Technical Description</label><br>
                <textarea rows="4" cols="50" name="description" readonly><?= $description ?></textarea>
                <div class="text-danger"><?php echo @$messages['error_description']; ?></div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Reorder level</label>
                <input type="number" class="form-control w-75" id="reorderqty" name="reorderqty" value="<?= @$reorderqty; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_reorder']; ?></div>
            </div>


            <div class="input-group-md mb-3 mt-3">
                <?php
                $sql = "SELECT s.companyname,s.supplierid FROM tbl_itemsofsupplier ios INNER JOIN tbl_suppliers s ON s.supplierid=ios.supplierid INNER JOIN tbl_itemcatalog c ON c.catalogid=ios.catalogid WHERE ios.catalogid='$catalogid' AND s.deletestatus=1;";
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <label class="form-label">Supplier  :</label>


                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="mb-2">

                            <?php echo ucfirst($row['companyname']); ?>

                        </div>
                        <?php
                    }
                }
                ?>
                </select>


            </div>







            <?php
        }
        ?>



    </form>

</main>





<?php include '../footer.php'; ?>



