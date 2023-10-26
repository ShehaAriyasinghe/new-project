<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Item available Report</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">


            </div>

        </div>
    </div>

    <h6>Stock items Report</h6>


    <?php
    extract($_POST);
    $db = dbconn();
    $where = null;
    $where1 = null;
    $wherei = null;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {




        if (!empty($from) && !empty($to)) {
            $where .= " s.adddate BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($from) && empty($to)) {
            $where .= " s.adddate ='$from' AND";
        }

        if (empty($from) && !empty($to)) {
            $where .= " s.adddate ='$to' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }






        if (!empty($itemname)) {
            $wherei .= " c.itemname LIKE '$itemname%' AND";
        }

        if (!empty($brand)) {
            $wherei .= " b.brandname LIKE '$brand%' AND";
        }


        if (!empty($wherei)) {
            $wherei = substr($wherei, 0, -3);
            $wherei = " AND $wherei";
        }







        if (!empty($from) && !empty($to)) {
            $where1 .= " ja.issuedate BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($from) && empty($to)) {
            $where1 .= " ja.issuedate ='$from' AND";
        }

        if (empty($from) && !empty($to)) {
            $where1 .= " ja.issuedate ='$to' AND";
        }

        if (!empty($where1)) {
            $where1 = substr($where1, 0, -3);
            $where1 = " AND $where1";
        }
    }
    ?>




    <form id="search" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="row g-3">


            <div class="col-sm">
                <label>From date:</label>
                <input type="date" name="from" value="<?php echo @$from; ?>" placeholder="Enter From Date" max="<?php echo date('Y-m-d') ?>">

            </div>

            <div class="col-sm">
                <label>To Date:</label>
                <input type="date" name="to" value="<?php echo @$to; ?>" max="<?php echo date('Y-m-d') ?>">

            </div>

            <?php
            if (empty($rep_type)) {
                ?>

                <div class="col-sm">
                    <label>Item</label>
                    <input type="text" name="itemname" placeholder="Enter To Item" value="<?php echo @$itemname; ?>">

                </div>

                <div class="col-sm">
                    <label>Brand</label>
                    <input type="text" name="brand" placeholder="Enter To brand" value="<?php echo @$brand; ?>">

                </div>
                <?php
            }
            ?>        




            <div class="col-sm">
                <label>Report Type</label>
                <select name="rep_type" class=''>

                    <option value="<?php echo @$rep_type; ?>"><?php echo @$rep_type; ?></option>

                    <option value="Daily">Daily</option>
                    <option value="Monthly">Monthly</option>
                    <option value="">--</option>


                </select>
            </div>

            <div class="col-sm">
                <button type="submit" class='btn btn-primary btn-sm'>Search</button>
            </div>
        </div>
    </form>


    <?php
    if (@$rep_type == 'Daily') {
        $sqltbl = "SELECT ja.issuedate,sum(ja.issueqty) as issueqty,sum(ja.amount * ja.issueqty) as totalamount FROM tbl_jobcardassignitems ja WHERE ja.issuestatus='done' AND ja.deletestatus='1' $where1 GROUP BY ja.issuedate";
        $result = $db->query($sqltbl);
        ?>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Date</th>

                    <th scope="col">Issued Qty</th>
                    <th scope="col">Total sales of item</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['issuedate'] ?></td>

                        <td><?php echo $row['issueqty'] ?></td> 
                        <td><?php echo $row['totalamount'] ?></td> 
                        <?php
                        $total += $row['totalamount'];
                        ?>
                    </tr>

                    <?php
                }
                ?>
            <td>Total Amount : <?php echo number_format($total, 2); ?></td>
            </tbody>

        </table>
        <?php
    }
    ?>



    <?php
    if (@$rep_type == 'Monthly') {


        $sqltbl = "SELECT MONTH(ja.issuedate) AS month,sum(ja.issueqty) as issueqty,sum(ja.amount * ja.issueqty) as totalamount FROM tbl_jobcardassignitems ja WHERE ja.issuestatus='done' AND ja.deletestatus='1' $where1 GROUP BY MONTH(ja.issuedate)";

        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Month</th>
                    <th scope="col">Issued Qty</th>
                    <th scope="col">Total sales of item</th>




                </tr>

            </thead>
            <tbody>

                <?php
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)) ?></td>
                        <td><?php echo $row['issueqty'] ?></td> 
                        <td><?php echo $row['totalamount'] ?></td> 

                    </tr>


                    <?php
                    $total += $row['totalamount'];
                }
                ?>
            <td>Total Amount : <?php echo number_format($total, 2); ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>




    <?php
    if (empty($rep_type)) {
        $sql = "SELECT c.catalogid,c.itemname,b.brandname,sub.subcategoryname,c.modelno,c.itemcode,sum(s.quntity) as quantity,sum(s.quntity-s.issuedqty) as available FROM tbl_itemstock s INNER JOIN tbl_itemcatalog c ON c.catalogid=s.catalogid INNER JOIN tbl_itembrands b ON c.brandid=b.brandid INNER JOIN tbl_itemsubcategories sub ON c.subcategoryid=sub.subcategoryid WHERE c.deletestatus='1' AND s.deletestatus='1' AND s.stockstatus='1' GROUP BY s.catalogid";
        $result = $db->query($sql);
        ?>

        <table class="table table-striped">
            <thead>
                <tr>

                    <th scope="col">Code</th>
                    <th scope="col">Item</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th scope="col">Subcategory</th>
                    <th scope="col">All Qty</th>  
                    <th scope="col">Available Qty</th>
                    <th scope="col">Issued Qty</th>
                    
                    <th scope="col">Total sales of item</th>

                </tr>

            </thead>
            <tbody>

                <?php
                $totalsaleitem = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['itemcode'] ?></td>
                        <td><?php echo $row['itemname'] ?></td> 
                        <td><?php echo $row['brandname'] ?></td> 
                        <td><?php echo $row['modelno'] ?></td> 
                        <td><?php echo $row['subcategoryname'] ?></td> 
                        <td><?php echo $row['quantity'] ?></td> 
                      




                        <?php
                        $catalogid = $row['catalogid'];
                        $itemquntity = $row['quantity'];
                        $sql2 = "SELECT sum(s.issueqty) as issueqty,sum(s.amount * s.issueqty) as totalamount FROM tbl_jobcardassignitems s WHERE s.issuestatus='done' AND s.catalogid='$catalogid' $where";
                        $result2 = $db->query($sql2);
                        while ($rows = $result2->fetch_assoc()) {
                            ?>

                            <td><?php echo $availablequntity=$row['quantity']-$rows['issueqty'] ?></td>

                            <td><?php echo $rows['issueqty'] > 0 ? $rows['issueqty'] : 0 ?></td>



                            <td>   <?php echo $rows['totalamount'] > 0 ? $rows['totalamount'] : 0 ?></td>

                         

                            <?php
                            $totalsaleitem += $rows['totalamount'];
                        }
                        ?>




                    </tr>


                    <?php
                }
                ?>
                <tr>
                    <td colspan="3">
                        Total Amount of Item sale
                    </td>

                    <td>Rs.<?php echo number_format($totalsaleitem, 2); ?></td>

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





