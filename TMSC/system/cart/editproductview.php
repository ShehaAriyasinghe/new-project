<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Materials</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            
          
        </div>
    </div>

    <h6>All service materials</h6>

    <?php
    $db = dbconn();
    extract($_GET);

    $sql = "SELECT c.catalogid,c.vehicletype,c.itemname,b.brandname,sub.subcategoryname,c.modelno,c.itemcode,"
            . "c.description,c.itemimage,sum(s.quntity-s.issuedqty) as balance,s.sellingprice FROM tbl_itemcatalog c INNER JOIN tbl_itembrands b ON "
            . "c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid "
            . "INNER JOIN tbl_itemstock s ON c.catalogid=s.catalogid WHERE c.categoryid='$categoryid' AND c.deletestatus='1' GROUP BY s.catalogid";

    $result = $db->query($sql);
    ?>
    <div class="row">
        <div class="col-md-6">    
            Materials value:
            <?php
            $total = 0;
            $noitms = 0;
            if (isset($_SESSION['itemcart'])) {
                foreach ($_SESSION['itemcart'] as $key => $value) {
                    $total += $value['qty'] * $value['price'];
                    $noitms += $value['qty'];
                }

                echo "(Rs.)" . " " . number_format($total, 2);
            }
            ?>
        </div>
        <div class="col-md-6">    
            <a href="editcart.php?jobcardid=<?= $jobcardid ?>">View Added Materials<i class="bi bi-cart"></i></a> 
            <?php echo "[" . $noitms . "]"; ?>
        </div> 
    </div>  

    <div class="row">
        <table width="100%" style="border: 1px solid #055160">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>


                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                  
                        <tr style="border: 1px solid black;">
                           
                            <td>
                                <img class="img-fluid" width="50" height="100" src="<?= SYSTEM_PATH ?>inventory/images/<?= $rows['itemimage'] ?>">

                            </td>
                            <td>
                                <?php
                                echo $rows['itemname'] . "<br>";
                                echo "Price:(Rs.) " . $rows['sellingprice'] . "<br>";
                                echo "Sub category: " . $rows['subcategoryname'] . "<br>";
                                echo "Available Quantity: " . $rows['balance'] . "<br>";
                                echo "Vehicle Type: " . $rows['vehicletype'] . "<br>";

                                $catalogid = $rows['catalogid'];

                                $sql1 = "SELECT cveh.modelid,m.modelname,cv.vehicleid,m.modelname FROM tbl_itemcatalog_vehicles cv INNER JOIN tbl_itemcatalog c ON c.catalogid=cv.catalogid INNER JOIN tbl_centervehicles cveh ON cveh.vehicleid=cv.vehicleid INNER JOIN tbl_models m ON m.modelid=cveh.modelid WHERE c.catalogid=$catalogid GROUP BY cveh.modelid";
                                $result1 = $db->query($sql1);
                                echo "Used vehicles:";
                                while ($row = $result1->fetch_assoc()) {
                                    echo $row['modelname'];
                                }
                                ?>






                                <form method="post" action="editshoppingcart.php">
                                    <input type="hidden" name="catalogid" value="<?= $catalogid ?>">
                                    <input type="hidden" name="categoryid" value="<?= $categoryid ?>">
                                    <input type="hidden" name="jobcardid" value="<?= $jobcardid ?>">
                                    <button type="submit" name="operate" value="add_cart"><i class="bi bi-plus-square-fill"></i></button>                       
                                </form> 
                            </td>
                             

                        </tr>
                   
                    <?php
                }
            }
            ?>

            </tbody>
        </table>

    </div>                          

    <a class="btn btn-primary btn-sm mt-2" href="<?= SYSTEM_PATH ?>jobcards/editassign_materialsjobcard.php?jobcardid=<?= $jobcardid; ?>&mode=assign">Back to Job card</a>

    <a class="btn btn-primary btn-sm mt-2" href="<?= SYSTEM_PATH ?>cart/editcart_categoryview.php?mode=assign&jobcardid=<?= $jobcardid ?>">Back to category</a>





</main>
<?php
include '../footer.php';
?>