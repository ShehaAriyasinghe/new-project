<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Manage Suppliers Payments</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">


            </div>

        </div>
    </div>



    <h6>Suppliers payment list</h6>

    <?php
    unset($_SESSION['items']);
    extract($_GET);

//search suppliers
    $where = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (!empty($companyname)) {
            $where .= " companyname LIKE '$companyname%' AND";
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

                <input type="text" class="form-control" name="companyname" placeholder="companyname" value="<?= @$companyname; ?>">
            </div>
            <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
        </div>
    </form>






    <?php
    $db = dbconn();
    $sql = "SELECT p.adddate,s.companyname,s.creditlimit,p.supplierid,p.pendingpayment,sum(p.pendingpayment) as payment FROM tbl_purchaseorder p LEFT JOIN tbl_suppliers s ON s.supplierid=p.supplierid WHERE p.deletestatus='1' AND deliverystatus !='none' AND payment='pending' $where GROUP BY p.supplierid";
    $result = $db->query($sql);
    ?>    
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Company Name</th>
                    <th>Pending payment</th>
                    <th>Credit Limit</th>


                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                        <tr>


                            <td><?php echo $rows['adddate']; ?></td>
                            <td><?php echo $rows['companyname']; ?></td>
                            <td><?php echo $rows['payment']; ?></td>

                            <td><?php echo $rows['creditlimit']; ?></td>





                            <td><a href="viewsupplierpayment.php?supplierid=<?php echo $rows['supplierid'] ?>" class="btn btn-primary btn">Payment</a></td>   
                            



                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?>


