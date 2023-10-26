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
        <h1 class="h2">Edit Item Catalog</h1>
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



    //Extract inputs
    extract($_POST);

    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operation == "submit") {




        //Data clean

        @$itemname = cleanInput($itemname);
        @$itemcode = cleanInput($itemcode);
        @$modelno = cleanInput($modelname);
        @$description = cleanInput($description);

        //Create array
        $messages = array();

        //required validation
        if (empty($subcategoryid)) {

            $messages['error_subcategory'] = "The Sub category field should not be empty...!";
        }

        if (empty($categoryid)) {
            $messages['error_category'] = "The Category Name field should not be empty..!";
        }




        if ($categoryname == "spare parts") {

            // empty validations


            if (empty($brandid)) {

                $messages['error_brand'] = "The Brand should not be empty...!";
            }



            if (empty($itemname)) {

                $messages['error_item'] = "The Item Name field should not be empty...!";
            }
            if (empty($modelname)) {

                $messages['error_model'] = "The Model Name field should not be empty...!";
            }

            if (empty($itemcode)) {

                $messages['error_itemcode'] = "The Item Code field should not be empty...!";
            }





            if (empty($_SESSION['assignvehicles'])) {
                $messages['error_vehicles'] = "The Using vehicles should not be empty..!";
            }




            if (empty($description)) {

                $messages['error_description'] = "The Item description field should not be empty...!";
            }

            if (empty($reorderqty)) {

                $messages['error_reorder'] = "The Item reorder field should not be empty...!";
            }


            //advance validations
            if (!empty($itemname)) {
                $sql = "SELECT * FROM tbl_itemcatalog WHERE itemname='$itemname' && catalogid!=$catalogid && deletestatus='1'";
                $db = dbconn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_item'] = "The Item name already exists..!";
                } else {
                    if (!preg_match('/^[a-z 0-9 ]+$/i', $itemname)) {
                        $messages['error_item'] = "The Item name should be String..!";
                    }
                }
            }

            if (!empty($itemcode)) {
                $sql = "SELECT * FROM tbl_itemcatalog WHERE itemcode='$itemcode' && catalogid!=$catalogid && deletestatus='1'";
                $db = dbconn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_itemcode'] = "The Item code already exists..!";
                } else {
                    if (!preg_match('/^[0-9 ]+$/i', $itemcode)) {
                        $messages['error_itemcode'] = "The itemcode should be Numbers!";
                    }
                }
            }


            if (!empty($modelname)) {
                $sql = "SELECT * FROM tbl_itemcatalog WHERE modelno='$modelname' && catalogid!=$catalogid && deletestatus='1'";
                $db = dbconn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_model'] = "The Model name already exists..!";
                } else {
                    if (!preg_match('/^[a-z 0-9 ]+$/i', $modelname)) {
                        $messages['error_model'] = "The Model name should be String or Numbers!";
                    }
                }
            }






            // image validation
            if (empty($messages) && !empty($_FILES['itemimage']['name'])) {



                $image = $_FILES['itemimage'];
                $file_name = $image['name'];
                $file_tmp = $image['tmp_name'];
                $file_size = $image['size'];
                $file_error = $image['error'];

                //workout the file extension
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));
                //allow file types
                $allowed = array('txt', 'pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'gif');
                //check if the file is allowed

                if (in_array($file_ext, $allowed)) {
                    if ($file_error === 0) {
                        if ($file_size <= 2097152) {
                            $file_name_new = uniqid('', true) . '.' . $file_ext;
                            //file destination
                            $file_destination = 'images/' . $file_name_new;
                            //move the file
                            if (move_uploaded_file($file_tmp, $file_destination)) {
                                unlink('images/' . $previousproductimage);
                            } else {
                                $messages['error_file'] = "There was an error uploading the file.";
                            }
                        } else {
                            $messages['error_file'] = "File size is invalid";
                        }
                    } else {
                        $messages['error_file'] = "File has error";
                    }
                } else {
                    $messages['error_file'] = "Invalid file type";
                }
            } else {
                $file_name_new = $previousproductimage;
            }




            //check validation is completed
            if (empty($messages)) {
                //call to the db connection
                $updatedate = date('Y-m-d');
                $updateuser = $_SESSION['userid'];
                $sql = "UPDATE tbl_itemcatalog SET brandid='$brandid',itemname='$itemname',modelno='$modelname',itemcode='$itemcode',itemimage='$file_name_new',description='$description',reorderqty='$reorderqty',updatedate='$updatedate',updateuser='$updateuser' WHERE catalogid=$catalogid";
                $db = dbConn();
                $db->query($sql);

                $sql1 = "DELETE FROM tbl_itemcatalog_vehicles WHERE catalogid='$catalogid'";
                $db->query($sql1);

                foreach ($_SESSION['assignvehicles'] as $key => $value) {
                    $adddate = date('Y-m-d');
                    $adduser = $_SESSION['userid'];
                    $sql = "INSERT INTO tbl_itemcatalog_vehicles(catalogid,vehicleid,adddate,adduser) VALUES('$catalogid',$key,' $adddate','$adduser') ";
                    $db->query($sql);
                    showSuccMeg();
                }
                unset($_SESSION['assignvehicles']);
            }
        }








// validate oil details


        if ($categoryname == "oil") {

            // empty validations


            if (empty($brandid)) {

                $messages['error_brand'] = "The Brand should not be empty...!";
            }



            if (empty($itemname)) {

                $messages['error_item'] = "The Item Name field should not be empty...!";
            }
            if (empty($modelname)) {

                $messages['error_model'] = "The Model Name field should not be empty...!";
            }

            if (empty($itemcode)) {

                $messages['error_itemcode'] = "The Item Code field should not be empty...!";
            }


            if (empty($capacity)) {

                $messages['error_capacity'] = "The Item Capacity field should not be empty...!";
            }
            if (empty($description)) {

                $messages['error_description'] = "The Description field should not be empty...!";
            }
            if (empty($reorderqty)) {

                $messages['error_reorder'] = "The Description field should not be empty...!";
            }


            if (empty($vehicletype)) {

                $messages['error_vehicletype'] = "The vehicle type field should not be empty...!";
            }






            //advance validations
            if (!empty($itemname)) {
                $sql = "SELECT * FROM tbl_itemcatalog WHERE itemname='$itemname' && catalogid!=$catalogid && deletestatus='1'";
                $db = dbconn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_item'] = "The Item name already exists..!";
                } else {
                    if (!preg_match('/^[a-z0-9 ]+$/i', $itemname)) {
                        $messages['error_item'] = "The Item name should be String and numbers..!";
                    }
                }
            }

            if (!empty($itemcode)) {
                $sql = "SELECT * FROM tbl_itemcatalog WHERE itemcode='$itemcode' && catalogid!=$catalogid && deletestatus='1'";
                $db = dbconn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_itemcode'] = "The Item code already exists..!";
                } else {
                    if (!preg_match('/^[0-9 ]+$/i', $itemcode)) {
                        $messages['error_itemcode'] = "The itemcode should be Numbers!";
                    }
                }
            }


            if (!empty($modelname)) {
                $sql = "SELECT * FROM tbl_itemcatalog WHERE modelno='$modelname' && catalogid!=$catalogid && deletestatus='1'";
                $db = dbconn();
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $messages['error_model'] = "The Model name already exists..!";
                } else {
                    if (!preg_match('/^[a-z0-9 ]+$/i', $modelname)) {
                        $messages['error_model'] = "The Model name should be String or Numbers!";
                    }
                }
            }





            // image validation
            if (empty($messages) && !empty($_FILES['itemimage']['name'])) {



                $image = $_FILES['itemimage'];
                $file_name = $image['name'];
                $file_tmp = $image['tmp_name'];
                $file_size = $image['size'];
                $file_error = $image['error'];

                //workout the file extension
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));
                //allow file types
                $allowed = array('txt', 'pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'gif');
                //check if the file is allowed

                if (in_array($file_ext, $allowed)) {
                    if ($file_error === 0) {
                        if ($file_size <= 2097152) {
                            $file_name_new = uniqid('', true) . '.' . $file_ext;
                            //file destination
                            $file_destination = 'images/' . $file_name_new;
                            //move the file
                            if (move_uploaded_file($file_tmp, $file_destination)) {
                                unlink('images/' . $previousproductimage);
                            } else {
                                $messages['error_file'] = "There was an error uploading the file.";
                            }
                        } else {
                            $messages['error_file'] = "File size is invalid";
                        }
                    } else {
                        $messages['error_file'] = "File has error";
                    }
                } else {
                    $messages['error_file'] = "Invalid file type";
                }
            } else {

                $file_name_new = $previousproductimage;
            }




            //check validation is completed
            if (empty($messages)) {
                //call to the db connection
                $updatedate = date('Y-m-d');
                $updateuser = $_SESSION['userid'];
                $sql = "UPDATE tbl_itemcatalog SET brandid='$brandid',itemname='$itemname',modelno='$modelname',itemcode='$itemcode',itemimage='$file_name_new',vehicletype='$vehicletype',itemgrade='$itemgrade',capacity='$capacity',description='$description',reorderqty='$reorderqty',updatedate='$updatedate',updateuser='$updateuser' WHERE catalogid=$catalogid";
               
                $db = dbConn();
                $db->query($sql);
                showSuccMeg();
            }
        }
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        extract($_POST);

        // call db connection
        $db = dbConn();
        if (!empty($vehicle)) {


            $sql = "SELECT v.vehicleid,v.vehicleimage,v.color,v.brandid,v.modelid,b.brandid,b.brandname,m.modelid,m.modelname,v.deletestatus FROM tbl_centervehicles v INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus='1' AND v.vehicleid='$vehicle'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            $_SESSION['assignvehicles'][$row['vehicleid']] = array('brand' => $row['brandname'], 'model' => $row['modelname'], 'color' => $row['color'], 'vehicleimage' => $row['vehicleimage']);
        }


        if (@$mode == "delete" && !empty(@$vehicleid)) {

            $assignvehicles = $_SESSION['assignvehicles'];
            unset($assignvehicles[$vehicleid]);
            $_SESSION['assignvehicles'] = $assignvehicles;
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
                <select class="form-select w-75 border-dark" name="brandid" id="brandid">
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
                <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$itemname; ?>" >
                <div class="text-danger"><?php echo @$messages['error_item']; ?></div>
            </div>

            <div class="mb-3">
                <label for="modelname" class="form-label">Model Name</label>
                <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$modelname; ?>" >
                <div class="text-danger"><?php echo @$messages['error_model']; ?></div>
            </div>


            <div class="mb-3">
                <label for="itemcode" class="form-label">Item Code</label>
                <input type="text" class="form-control w-75" id="itemcode" name="itemcode" value="<?= @$itemcode; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_itemcode']; ?></div>
            </div>








            <div class="mb-3">

                <label for="" class="form-label">Select using vehicles</label>




                <?php
                $sql = "SELECT v.vehicleid,v.vehicleimage,v.color,v.brandid,v.modelid,b.brandid,b.brandname,m.modelid,m.modelname,v.deletestatus FROM tbl_centervehicles v INNER JOIN tbl_brands b ON v.brandid=b.brandid INNER JOIN tbl_models m ON v.modelid=m.modelid WHERE v.deletestatus='1'";
                $db = dbConn();
                $result = $db->query($sql);
                ?>


                <select class="form-select w-75 border-dark" name="vehicle" id="vehicleid" onchange="form.submit()">
                    <option value="">--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>

                            <option value="<?php echo $row['vehicleid']; ?>">

                                <?php echo $row['brandname'] . "-" . $row['modelname'] . "-" . $row['color']; ?>

                            </option>



                            <?php
                        }
                    }
                    ?>
                </select>




                <div class="text-danger"><?php echo @$messages['error_vehicles']; ?></div>    
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


                                    <td>             
                                        <input type="hidden" name="vehicleid" value="<?= @$key ?>">
                                        <button name="mode" value="delete" onclick="form.submit()"><i class="bi bi-x-square"></i></button>
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
                <img class="img-fluid" width="150" height="150" src="<?= SYSTEM_PATH ?>inventory/images/<?= !empty($itemimage)?$itemimage:'noimage.png' ?>">
                

              
                <input type="hidden" name="previousproductimage" value="<?= $itemimage ?>">
                <input type="hidden" name="itemimage" value="<?= $itemimage ?>">`

            </div>


            <div class="mb-3">

                <label for="image" class="form-label">Upload Item Image</label>
                <input class="form-control w-75" type="file" id="itemimage" name="itemimage">
                <div class="text-danger"><?php echo @$messages['error_file']; ?></div>
            </div>


            <div class="mb-3">
                <label for="description" class="form-label">Item Technical Description</label><br>
                <textarea rows="4" cols="50" name="description"><?= @$description ?></textarea>
                <div class="text-danger"><?php echo @$messages['error_description']; ?></div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Reorder level</label>
                <input type="number" class="form-control w-75" id="reorderqty" name="reorderqty" value="<?= @$reorderqty; ?>" >
                <div class="text-danger"><?php echo @$messages['error_reorder']; ?></div>
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
                <select class="form-select w-75 border-dark" name="brandid" id="brandid">
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
                <input type="text" class="form-control w-75" id="itemname" name="itemname" value="<?= @$itemname; ?>" >
                <div class="text-danger"><?php echo @$messages['error_item']; ?></div>
            </div>

            <div class="mb-3">
                <label for="modelname" class="form-label">Model Name</label>
                <input type="text" class="form-control w-75" id="modelname" name="modelname" value="<?= @$modelname; ?>" >
                <div class="text-danger"><?php echo @$messages['error_model']; ?></div>
            </div>

            <div class="mb-3">
                <label for="itemcode" class="form-label">Item Code</label>
                <input type="text" class="form-control w-75" id="itemcode" name="itemcode" value="<?= @$itemcode; ?>" readonly>
                <div class="text-danger"><?php echo @$messages['error_itemcode']; ?></div>
            </div>

            <div class="mb-3">
                <label for="itemgrade" class="form-label">Engine Oil Grade</label>
                <input type="text" class="form-control w-75" id="itemgrade" name="itemgrade" value="<?= @$itemgrade; ?>" >
                <div class="text-danger"><?php echo @$messages['error_itemgrade']; ?></div>
            </div>

            <div class="input-group-md mb-3 mt-3">

                <label class="form-label">Select Volumetric Capacity :</label>
                <select class="form-select w-75 border-dark" name="capacity" id="capacity">
                    <option value="">--</option>

                    <option value="250" <?php if (isset($capacity) && $capacity =="250") { ?>selected <?php } ?>>250ml</option>
                    <option value="500" <?php if (isset($capacity) && $capacity == "500") { ?>selected <?php } ?>>500ml</option>
                    <option value="750" <?php if (isset($capacity) && $capacity == "750") { ?>selected <?php } ?>>750ml</option>
                    <option value="1000" <?php if (isset($capacity) && $capacity == "1000") { ?>selected <?php } ?>>1l</option>

                </select>
                <div class="text-danger"><?php echo @$messages['error_capacity']; ?></div>
            </div>

            <div class="input-group-md mb-3 mt-3">

                <label class="form-label">Select Vehicle type:</label>
                <select class="form-select w-75 border-dark" name="vehicletype" id="vehicletype">
                    <option value="">--</option>
                    <option value="scooter" <?php if (isset($vehicletype) && $vehicletype = "scooter") { ?>selected <?php } ?>>Scooter</option>
                    <option value="motorbike" <?php if (isset($vehicletype) && $vehicletype = "motorbike") { ?>selected <?php } ?>>Motorbike</option>
                </select>
                <div class="text-danger"><?php echo @$messages['error_vehicletype']; ?></div>
            </div>



            <div class="mb-3">
                <label for="image" class="form-label">Item Image:</label><br>
                 <img class="img-fluid" width="150" height="150" src="<?= SYSTEM_PATH ?>inventory/images/<?= !empty($itemimage)?$itemimage:'noimage.png' ?>">
                 <input type="hidden" name="itemimage" value="<?= $itemimage ?>">`
                
                <input type="hidden" name="previousproductimage" value="<?= $itemimage ?>">

            </div>




            <div class="mb-3">
                <label for="image" class="form-label">Upload Item Image</label>
                <input class="form-control w-75" type="file" id="itemimage" name="itemimage">
                <div class="text-danger"><?php echo @$messages['error_file']; ?></div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Item Technical Description</label><br>
                <textarea rows="4" cols="50" name="description"><?= $description ?></textarea>
                <div class="text-danger"><?php echo @$messages['error_description']; ?></div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Reorder level</label>
                <input type="number" class="form-control w-75" id="reorderqty" name="reorderqty" value="<?= @$reorderqty; ?>" >
                <div class="text-danger"><?php echo @$messages['error_reorder']; ?></div>
            </div>

            <?php
        }
        ?>










        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary" name="operation" value="submit">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>inventory/add_itemcatalog.php" type="submit" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>








    </form>

</main>





<?php include '../footer.php'; ?>



