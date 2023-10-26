<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>attendance/technicianattendance.php" type="button" class="btn btn-sm btn-outline-secondary">Technician Attendance</a>
                <a href="edit_technicianattendance.php?mode=edit" type="button" class="btn btn-sm btn-outline-secondary">Edit</a>
            </div>
            
        </div>
    </div>

    <h6><?php echo date('Y-m-d')." "; ?>Technicians attendance</h6>

    <?php
    $date = date('Y-m-d');
    extract($_GET);
    $db = dbconn();
    $messages = array();

    $sql = "SELECT e.firstname,e.lastname,e.employeeid,e.designation,ta.attendancestatus,ta.date,ta.attendanceid FROM tbl_technicianattendance ta LEFT JOIN tbl_employees e ON e.employeeid=ta.technicianid  WHERE (designation='technician' OR temporarystatus='technician') AND e.deletestatus=1 AND ta.deletestatus=1 AND ta.date='$date'";
    $db = dbConn();
    $result = $db->query($sql);
    ?>
   

            <div class="table-responsive">
                <!-- View of All job cards -->
                <table class="table table-striped table-sm">
                    <thead>
                    <th>First name</th>    
                    <th>Last name</th>
                    <th>Designation</th>
                    <th>Attendance</th>
                    <th>Date</th>
                    
                    <th></th>
                    <th></th>
                    

                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) {
                                ?>   
                                <tr>
                                    <td><?= $rows['firstname'] ?></td>
                                    <td><?= $rows['lastname'] ?></td>
                                    <td><?= $rows['designation'] ?></td>
                                    <td><?= $rows['attendancestatus'] ?></td>
                                       <td><?= $rows['date'] ?></td>

                                   
                                    
                                <tr>
                                    <?php
                                }
                            }
                            ?>
                                    
                                     
                    </tbody>
                </table>
            </div>
     
    
    <?php include '../footer.php'; ?>