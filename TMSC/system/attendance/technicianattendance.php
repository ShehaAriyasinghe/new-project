<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Manage Job cards</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>attendance/view_technicianattendance.php" type="button" class="btn btn-sm btn-outline-secondary">View Technician Attendance</a>
               
            </div>
           
        </div>
    </div>

    <h6>Mark technicians attendance</h6>

    <?php
    extract($_GET);
    $db = dbconn();
    $messages = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);

        if (empty($attendance)) {
            $messages['error_attendance'] = "Attendance should be marked...!";
        }else{
            
           $date=date('Y-m-d'); 
           $sql="SELECT * FROM tbl_technicianattendance WHERE date='$date'"; 
           $result=$db->query($sql);
           if($result->num_rows>0){
               $messages['error_attendance']= "This date already have been marked attendance...!";
           }
    
        }
        
        
        

        if (empty($messages)) {

            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            foreach ($attendance as $key => $value) {
                $sql = "INSERT INTO tbl_technicianattendance(technicianid,attendancestatus,date,adddate,adduser) VALUES ($key,'$value','$adddate','$adddate','$adduser')";
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
        $sql = "SELECT firstname,lastname,employeeid,designation FROM tbl_employees WHERE designation='technician' OR designation='assistant technician' AND temporarystatus='technician' AND deletestatus=1";
        $db = dbConn();
        $result = $db->query($sql);
        ?>
        <label class="form-check-label">Mark attendance of technicians :</label>
        
        <div class="row">

            <div class="col-md-6 mt-3">

                <?php
                if ($result->num_rows > 0) {
                    while ($rows = $result->fetch_assoc()) {
                        ?>



                <label class="mb-1"><?php echo $rows['firstname'] . " " . $rows['lastname']; ?> </label>                 
                        <div class='mb-2'>
                            <label class="form-label" for="right">Yes</label>
                            <input class="form-check-input" id="right" type="radio" name="attendance[<?= $rows['employeeid'] ?>]" value="yes" <?php if (isset($attendance) && @$attendance[$rows['employeeid']] == "yes") { ?> checked <?php } ?> >

                            <label class="form-label" for="wrong">No</label>
                            <input class="form-check-input" id="wrong" type="radio" name="attendance[<?= $rows['employeeid'] ?>]" value="no" <?php if (isset($attendance) && @$attendance[$rows['employeeid']] == "no") { ?> checked <?php } ?> >
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
                            <a href="technicianattendance.php?mode=technician&employeeid=<?php echo $row1['employeeid'] ?>" class="btn btn-primary">Technician</a>
                            </td>
                    </tr>


                            <?php
                        }
                    }else{
                         echo "<div class='alert alert-danger'>"."There are no assistance techniciances"."</div>";
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
                            <a href="technicianattendance.php?mode=assistant technician&employeeid=<?php echo $row1['employeeid'] ?>" class="btn btn-primary">Assistant technician</a>
                            </td>
                    </tr>


                            <?php
                        }
                    }else{
                        echo "<div class='alert alert-danger'>"."There are no temporary techniciances"."</div>";
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
        


























