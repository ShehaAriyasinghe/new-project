<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>attendance/view_technicianattendance.php" type="button" class="btn btn-sm btn-outline-secondary">view technicians</a>
                
            </div>
            
        </div>
    </div>

    <h6>Mark technicians attendance</h6>

    <?php
    extract($_GET);
    $db = dbconn();
    $messages = array();

    $date = date('Y-m-d');

    $sql = "SELECT attendancestatus,technicianid FROM tbl_technicianattendance WHERE deletestatus=1 AND date='$date'";
    $db = dbConn();
    $result = $db->query($sql);
    $attendance = array();

    while ($rows = $result->fetch_assoc()) {
        $technicianid = $rows['technicianid'];

        $status = $rows['attendancestatus'];

        $_SESSION['attendance'][$technicianid] = $status;
    }
   

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (empty($attendance)) {
            $messages['error_attendance'] = "Attendance should be marked...!";
        } 




        if (empty($messages)) {

            $updatedate = date('Y-m-d');
            $date=date('Y-m-d');
            $updateuser = $_SESSION['userid'];
            
            
            $sql1="DELETE FROM tbl_technicianattendance WHERE date='$date'";
            $db->query($sql1);
            foreach ($attendance as $key => $value) {
                $sql = "INSERT INTO tbl_technicianattendance(technicianid,attendancestatus,date,updatedate,updateuser) VALUES ($key,'$value','$date','$updatedate','$updateuser')";
                $db = dbConn();
                $db->query($sql);
                showSuccMeg();
            }
        }
    }

    extract($_GET);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == "technician") {
        

        $sql = "UPDATE tbl_employees SET temporarystatus='$mode' WHERE employeeid='$employeeid'";
        $db = dbConn();
        $db->query($sql);
    }



    if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$mode == "assistant technician") {
       

        $sql = "UPDATE tbl_employees SET temporarystatus='$mode' WHERE employeeid='$employeeid'";
        $db = dbConn();
        $db->query($sql);
    }
    ?>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">


        <?php
        $date = date('Y-m-d');
        $sql = "SELECT e.firstname,e.lastname,e.employeeid,e.designation,ta.technicianid FROM tbl_employees e LEFT JOIN tbl_technicianattendance ta ON ta.technicianid=e.employeeid WHERE ta.date='$date' AND ta.deletestatus=1 AND e.temporarystatus='technician' OR (e.designation='assistant technician' AND e.temporarystatus='technician') AND e.deletestatus=1 GROUP BY e.employeeid";
        
       
        $db = dbConn();
        $result = $db->query($sql);
        ?>
        <label class="form-check-label">Mark attendance of technicians :</label>
        <div class="row">

            <div class="col-md-6">

                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        $technicianid = $rows['employeeid'];
                        ?>



                        <label><?php echo $rows['firstname'] . " " . $rows['lastname']; ?> </label>      

                        <div class='mb-2'>
                            <label class="form-label" for="right">Yes</label>
                            <input class="form-check-input" id="right" type="radio" name="attendance[<?= $rows['employeeid'] ?>]" value="yes" <?php if (isset($_SESSION['attendance'][$technicianid]) && $_SESSION['attendance'][$technicianid] == "yes") { ?> checked <?php } ?> >

                            <label class="form-label" for="wrong">No</label>
                            <input class="form-check-input" id="wrong" type="radio" name="attendance[<?= $rows['employeeid'] ?>]" value="no" <?php if (isset($_SESSION['attendance'][$technicianid]) && $_SESSION['attendance'][$technicianid] == "no") { ?> checked <?php } ?> >
                        </div>



                        <?php
                    }
                }
                ?>
                <div class="text-danger"><?php echo @$messages['error_attendance']; ?></div> 
            </div>


            <div class="col-md-6">                    
                <?php
                  
                $sql1 = "SELECT firstname,lastname,employeeid,designation FROM tbl_employees WHERE designation='assistant technician' AND temporarystatus='assistant technician' AND deletestatus=1";
                $db = dbConn();
                $result1 = $db->query($sql1);
                ?>
                <label class="form-label">All Assistant technicians :</label>
                <div class="form-control">
                    <table>
                        <?php
                        if ($result1->num_rows > 0) {
                            while ($row1 = $result1->fetch_assoc()) {
                                ?>

                                <tr>
                                    <td>
                                        <?php echo $row1['firstname'] . " " . $row1['lastname']; ?>
                                    </td>
                                    <td>
                                        <a href="edit_technicianattendance.php?mode=technician&employeeid=<?php echo $row1['employeeid'] ?>" class="btn btn-primary">Technician</a>
                                    </td>
                                </tr>


                                <?php
                            }
                        } else {
                            echo "<div class='alert alert-danger'>" . "There are no assistance techniciances" . "</div>";
                        }
                        ?>
                    </table>  
                </div>





                <?php
                $sql1 = "SELECT firstname,lastname,employeeid,designation FROM tbl_employees WHERE designation='assistant technician' AND temporarystatus='technician' AND deletestatus=1";
                $db = dbConn();
                $result1 = $db->query($sql1);
                ?>
                <label class="form-label">Temporary technicians :</label>
                <div class="form-control">
                    <table>
                        <?php
                        if ($result1->num_rows > 0) {
                            while ($row1 = $result1->fetch_assoc()) {
                                ?>

                                <tr>
                                    <td>
                                        <?php echo $row1['firstname'] . " " . $row1['lastname']; ?>
                                    </td>
                                    <td>
                                        <a href="edit_technicianattendance.php?mode=assistant technician&employeeid=<?php echo $row1['employeeid'] ?>" class="btn btn-primary">Assistant technician</a>
                                    </td>
                                </tr>


                                <?php
                            }
                        } else {
                            echo "<div class='alert alert-danger'>" . "There are no temporary techniciances" . "</div>";
                        }
                        ?>

                    </table>  
                </div>
            </div>

        </div>  



        <div class="row">
            <div class="col-md-6">
                <button type="submit" class="btn card-btn btn-sm mt-2 mb-2">Submit</button>
                <a href="view_jobcards.php" class="btn card-btn btn-sm mt-2 mb-2">Back</a>

            </div>
        </div>

    </form>

</main>
<?php
include '../footer.php';
?>
        


























