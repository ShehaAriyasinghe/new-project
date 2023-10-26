<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Supplier Payment Report</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">

                <a href="<?= SYSTEM_PATH ?>reports/supplierpaymentreport.php" class="btn btn-sm btn-outline-secondary">View supplier payment report</a>
            </div>

        </div>
    </div>

    <?php
    //search 
    $where = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (!empty($method)) {
            $where .= " sp.method ='$method' AND";
        }

        if (!empty($from) && !empty($to)) {
            $where .= " sp.adddate BETWEEN '$from' AND '$to' AND";
        }

        if (!empty($from) && empty($to)) {
            $where .= " sp.adddate ='$from' AND";
        }

        if (empty($from) && !empty($to)) {
            $where .= " sp.adddate ='$to' AND";
        }
        if (!empty($method)) {
            $where .= " sp.method='$method' AND";
        }

        if (!empty($cname)) {
            $where .= " s.companyname LIKE '$cname%' AND";
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

            <div class="col-sm">

                <input type="text" name="cname" class=""placeholder="Company Name" value="<?= @$cname ?>">
            </div>
            <div class="col-sm">
                <select name="method" id="">

                    <option value="<?= @$method ?>"><?= @$method ?></option>
                    <option value="">--</option>
                    <option value="cheque">cheque</option>
                    <option value="cash">cash</option>
                    <option value="deposit">deposit</option>

                </select>

                <span>Method</span>

            </div>


            <div class="col-sm">

                <input type="date" name="from" value="<?php echo @$from; ?>" placeholder="Enter From Date" max="<?php echo date('Y-m-d') ?>">
                <span>From Date:</span>
            </div>

            <div class="col-sm">

                <input type="date" name="to" placeholder="Enter To Date" value="<?php echo @$to; ?>" max="<?php echo date('Y-m-d') ?>">
                <span>Date To:</span>
            </div>
            <div class="col-sm">
                <span>Type</span>
                <select name="rep_type">

                    <option value="<?php echo @$rep_type; ?>"><?php echo @$rep_type; ?></option>

                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                    <option value="">--</option>

                </select>

            </div>    



            <div class="col"><button type="submit" class="btn card-btn btn-sm">Search</button></div>
        </div>
            </form>



    <?php
    if (empty($rep_type) && (!empty($where) || empty($where))) {
        //all vehicles expenditures


        $sql = "SELECT sp.adddate,sum(sp.totalpayment)as total,count(sp.purchaseorderid) as totalpurchase,s.companyname FROM tbl_supplierpayments sp INNER JOIN tbl_suppliers s ON s.supplierid=sp.supplierid WHERE sp.deletestatus='1' $where GROUP BY sp.supplierid;";
        $db = dbconn();
        $result = $db->query($sql);
        ?>    

        <div class="table-responsive">
            <!-- View of All vehicle -->
            <button type="button" class="btn btn-primary mb-2" onclick="printReport('report')">Print</button>
            <button type="button" class="btn btn-primary mb-2" onclick="exportReport('report', 'Vehicles expenditures report')">Export PDF</button>
            <div id="report">
                <h4>Supplier payment report</h4>
                <table border="1" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>

                            <th>Company Name</th>

                            <th>Gross payment</th>
                            <th>Purchase Order Count</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalamount = 0;
                        if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) {
                                ?>
                                <tr>

                                    <td><?php echo $rows['adddate']; ?></td>

                                    <td> <?php echo $rows['companyname'] ?></td>
                                    <td> <?php echo $rows['total']; ?></td>
                                    <td> <?php echo $rows['totalpurchase']; ?></td>




                                    <?php
                                    $totalamount += $rows['total'];
                                    ?>


                                </tr>


                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="2">Total Payment:</td>

                            <td><?php echo number_format($totalamount, 2) ?></td>                              
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    ?>

    <?php
    if (@$rep_type == 'Daily') {
        $db = dbconn();
        $sqltbl = "SELECT s.supplierid,sp.adddate,count(sp.supplierpaymentid) AS ordercount,sum(sp.totalpayment) as totalpayment FROM tbl_supplierpayments sp INNER JOIN tbl_suppliers s ON s.supplierid=sp.supplierid WHERE sp.deletestatus='1' $where GROUP BY sp.adddate";
        $result = $db->query($sqltbl);
        ?>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>No of order</th>
                    <th>Total payment</th>





                </tr>

            </thead>
            <tbody>

                <?php
                $totalorders = 0;
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['adddate'] ?></td>
                        <td>
                            <?php
                            echo $row['ordercount'];
                            @$totalorders += $row['ordercount'];
                            ?>
                        </td>


                        <td>
                            <?php
                            echo $row['totalpayment'];
                            $total += $row['totalpayment'];
                            ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            <td>Total Number of Orders : <?php echo $totalorders; ?></td>

            <td>Total Supplier Payments  : Rs. <?php echo number_format($total, 2); ?></td>
            </tbody>

        </table>
        <?php
    }


    if (@$rep_type == 'Monthly') {
        $db= dbconn();
        $sqltbl = "SELECT s.supplierid,MONTH(sp.adddate) as month,count(sp.supplierpaymentid) AS ordercount,sum(sp.totalpayment) as totalpayment FROM tbl_supplierpayments sp INNER JOIN tbl_suppliers s ON s.supplierid=sp.supplierid WHERE sp.deletestatus='1' $where GROUP BY MONTH(sp.adddate)";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>No of order</th>
                    <th>Total payment</th>

                </tr>

            </thead>
            <tbody>

                <?php
                $totalorders = 0;
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)) ?></td>
                        <td>
                        <?php
                        echo $row['ordercount'];
                        $totalorders += $row['ordercount'];
                        ?>
                        </td>   

                        <td><?php
                            echo $row['totalpayment'];
                            $total += $row['totalpayment'];
                            ?>
                        </td>

                    </tr>


                    <?php
                }
                ?>
            <td>Total Number of Orders : <?php echo $totalorders; ?></td>

            <td>Total Supplier Payments  : Rs. <?php echo number_format($total, 2); ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>

    <?php
    
      if (@$rep_type == 'Yearly') {
        $db= dbconn();
        $sqltbl = "SELECT s.supplierid,YEAR(sp.adddate) as month,count(sp.supplierpaymentid) AS ordercount,sum(sp.totalpayment) as totalpayment FROM tbl_supplierpayments sp INNER JOIN tbl_suppliers s ON s.supplierid=sp.supplierid WHERE sp.deletestatus='1' $where GROUP BY YEAR(sp.adddate)";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>No of order</th>
                    <th>Total payment</th>

                </tr>

            </thead>
            <tbody>

                <?php
                $totalorders = 0;
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['month'] ?></td>
                        <td>
                        <?php
                        echo $row['ordercount'];
                        $totalorders += $row['ordercount'];
                        ?>
                        </td>   

                        <td><?php
                            echo $row['totalpayment'];
                            $total += $row['totalpayment'];
                            ?>
                        </td>

                    </tr>


                    <?php
                }
                ?>
            <td>Total Number of Orders : <?php echo $totalorders; ?></td>

            <td>Total Supplier Payments  : Rs. <?php echo number_format($total, 2); ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>


    
    
    <?php
    
      if (@$rep_type == 'Weekly') {
        $db= dbconn();
        $sqltbl = "SELECT s.supplierid,DAYNAME(sp.adddate) as weekday,count(sp.supplierpaymentid) AS ordercount,sum(sp.totalpayment) as totalpayment FROM tbl_supplierpayments sp INNER JOIN tbl_suppliers s ON s.supplierid=sp.supplierid WHERE sp.deletestatus='1' $where GROUP BY DAYNAME(sp.adddate)";
        $result = $db->query($sqltbl);
        ?>



        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Week Day</th>
                    <th>No of order</th>
                    <th>Total payment</th>

                </tr>

            </thead>
            <tbody>

                <?php
                $totalorders = 0;
                $total = 0;

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['weekday'] ?></td>
                        <td>
                        <?php
                        echo $row['ordercount'];
                        $totalorders += $row['ordercount'];
                        ?>
                        </td>   

                        <td><?php
                            echo $row['totalpayment'];
                            $total += $row['totalpayment'];
                            ?>
                        </td>

                    </tr>


                    <?php
                }
                ?>
            <td>Total Number of Orders : <?php echo $totalorders; ?></td>

            <td>Total Supplier Payments  : Rs. <?php echo number_format($total, 2); ?></td>
            </tbody>

        </table>

        <?php
    }
    ?>


    
    
    
    
    
    
    
    
    





</main>


<script src="<?= SYSTEM_PATH; ?>assets/js/jquery-1.12.4.js" type="text/javascript"></script>
<script src="<?= SYSTEM_PATH; ?>assets/js/html2canvas.js" type="text/javascript"></script>
<script src="<?= SYSTEM_PATH; ?>assets/js/jspdf.min.js" type="text/javascript"></script>


<script>

                function printReport(divid) {
                    //alert('printReport Function');
                    var divToPrint = document.getElementById(divid); //get the area expected to be print

                    var newWin = window.open('', 'Print-Window'); //Open a new window which contain "Print-Window" as title

                    newWin.document.open(); // instruct to open a document inside the window

                    //The content will be written as the document append to the window
                    newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

                    newWin.document.close(); // Close the document

                    //Set a time out to close the window (10seconds)
                    setTimeout(function () {
                        newWin.close();
                    }, 10);
                }






                var doc = new jsPDF();//create an instance of jspdf library
                //to make function reusable the parameters can be defined
                function exportReport(divId, title) {
                    //giving the content that should be converted to a pdf
                    doc.fromHTML(`<html><head><title>${title}</title></head><body>` + document.getElementById(divId).innerHTML + `</body></html>`);
                    doc.save('Vehicles expenditures report.pdf');//download the pdf this name will be the name of the document when downloadedd
                }



</script>



<?php
include '../footer.php';
?>

