<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Investigation report Management</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>investigationreport/investigationlist.php" type="button" class="btn btn-sm btn-outline-secondary">Investigation list</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>

    <h6>Add Investigation Task</h6>
    
    <?php
    //Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Data clean
        $taskname = cleanInput($taskname);

        //Create array
        $messages = array();

        // empty validations
        if (empty($taskname)) {
            $messages['error_taskname'] = "The task name should not be empty..!";
        }
        
        
        //advance validations
        
        if (!empty($taskname)) {
            $sql = "SELECT * FROM tbl_investigationtasks WHERE taskname='$taskname' AND deletestatus='1'";
            $db = dbconn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_taskname'] = "The task name already exists..!";
            }else{
                if (!preg_match('/^[a-z ]+$/i', $taskname)) {
                $messages['error_taskname'] = "The task name is allowed letters and white spaces only.";
            }
                
            }
        }
        
        
 
        //check validation is completed
        if (empty($messages)) {
            //call to the db connection
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];
            $sql = "INSERT INTO tbl_investigationtasks(taskname,adddate,adduser) VALUES ('$taskname','$adddate','$adduser')";
            $db = dbConn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        
        <div class="mb-3">
            
            <label for="taskid" class="form-label">Investigation task name</label>
            <input type="text" class="form-control w-75" id="taskid" name="taskname" value="<?= @$taskname; ?>" >
            <div class="text-danger"><?php echo @$messages['error_taskname']; ?></div>
        </div>


        <div class="row justify-content-around">
            <div class="col-4">
                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>investigationreport/create_investigationreport.php" class="btn btn-outline-primary ">Reset</a>
            </div>
        </div>

    </form>
    
    
    
</main>
<?php 
include '../footer.php';
?>