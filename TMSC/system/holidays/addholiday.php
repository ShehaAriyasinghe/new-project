<?php
include '../header.php';
include '../menu.php';
?>


</head>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>Add Holiday days </h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>holidays/holidays.php" class="btn btn-sm btn-outline-secondary">View All holidays</a>

            </div>

        </div>
    </div>


    <?php
//Check submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Extract inputs
        extract($_POST);

        //Create array
        $messages = array();

        //required validation
        
        if (empty($title)) {

            $messages['error_title'] = "The Title should not be empty...!";
        } 
        
        

        if (empty($date)) {

            $messages['error_holiday'] = "The Date should not be empty...!";
        } else {

            $sql = "SELECT * FROM tbl_holidays WHERE holidaydate='$date'";
            $db = dbConn();
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $messages['error_holiday'] = "This Date already exists...!";
            }
        }






        if (empty($messages)) {
            $adddate = date('Y-m-d');
            $adduser = $_SESSION['userid'];

            $sql = "INSERT INTO tbl_holidays(title,holidaydate,adddate,adduser) VALUES('$title','$date','$adddate','$adduser') ";
            $db = dbconn();
            $db->query($sql);
            showSuccMeg();
        }
    }
    ?>



    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" name='title' value="<?= @$title ?>">
            <div class="text-danger"><?php echo @$messages['error_title']; ?></div>

        </div>




        <div class="mb-3 mt-3">
            <label for="day" class="form-label">Holiday date:</label>
           <?php 
           $today= date('Y-m-d');
           ?>
            <input type="date" name='date' class="form-control" value="<?= @$date ?>" min="<?= $today;?>">

            <div class="text-danger"><?php echo @$messages['error_holiday']; ?></div>

        </div>




        <div class="row justify-content-around">
            <div class="col-4">

                <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
            <div class="col-4">
                <a href="<?= SYSTEM_PATH; ?>holidays/addholiday.php" class="btn btn-outline-primary">Reset</a>
            </div>
        </div>

    </form>
</main>
<?php include '../footer.php'; ?>











