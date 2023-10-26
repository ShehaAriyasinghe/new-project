<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Vehicle Recommendations</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH ?>vehicles/allvehicles.php" type="button" class="btn btn-sm btn-outline-secondary">View all Job card vehicles</a>

            </div>

        </div>
    </div>
    <?php
    extract($_GET);
    ?>

    <div class="card px-md-4 mb-2 my-card-bg">

        <legend>Recommended sub services:</legend>


        <table class="">
            <thead class="card-btn">
                <tr>
                    <th>Date</th>
                    <th>Sub service name</th>
                </tr>
            </thead>

            <?php
            $db = dbconn();
            $sql = "SELECT sub.subservicename,ns.adddate FROM tbl_nextrecommendedsubservices ns  LEFT JOIN tbl_subservices sub ON sub.subserviceid=ns.subserviceid WHERE ns.vehicleid='$vehicleid'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    ?>

                    <tr class="my-card-bg">
                        <td>
                            <?php echo $rows['adddate']; ?>
                        </td>    
                        <td>
                            <?php echo $rows['subservicename']; ?>
                        </td>


                    </tr>

                    <?php
                }
            } else {
                echo "There are no records.";
            }
            ?>   
        </table>   


    </div>



    <div class="card px-md-4 mb-2 my-card-bg">
        <div class="row">


            <legend>Next Service Details:</legend>  

            <table class="">
                <thead class="card-btn">
                    <tr>
                        <th>Date</th>
                        <th></th>

                        <th>Next Mileage</th>

                        <th>Next Service Duration</th>
                    </tr>
                </thead>



                <div class = "mb-2">
                    <?php
                    $db = dbconn();
                    $sql = "SELECT nextmileage,nextserviceduration,adddate FROM tbl_nextrecommendedmileage WHERE vehicleid='$vehicleid' AND deletestatus='1'";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($rows = $result->fetch_assoc()) {
                            ?>

                            <tr class="">
                                <td>
                                    <?php echo $rows['adddate']; ?>
                                </td>   
                                <td></td>

                                <td>
                                    <?php echo $rows['nextmileage']; ?>
                                </td>

                                <td>
                                    <?php echo $rows['nextserviceduration']; ?>
                                </td>


                            </tr>

                            <?php
                        }
                    } else {
                        echo "There are no records.";
                    }
                    ?>
            </table>   
        </div>
    </div>




    <div class="card px-md-4 mb-2 my-card-bg">
        <div class="row">


            <legend>Next Service Recommendation:</legend>  


            <div class = "mb-2">
                <?php
                $db = dbconn();
                $sql = "SELECT comment,adddate FROM tbl_nextrecommendation WHERE vehicleid='$vehicleid' AND deletestatus='1'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>

                        <div class='form-control'>
                            <?php echo $rows['adddate']; ?>
                            <?php echo $rows['comment']; ?>
                        </div>       


                        <?php
                    }
                } else {
                    echo "There are no records.";
                }
                ?>

            </div>
        </div>
    </div>





</main>




<?php include '../footer.php'; ?>


