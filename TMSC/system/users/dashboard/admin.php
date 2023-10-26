<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">


        </div>
    </div>

    <div class="row">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Accounts</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Number of employees:</h6>

                    <h2 class="display-6">
                        <?php
                        $db = dbconn();
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE deletestatus=1";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>
                    </h2>
                    <a href="<?= SYSTEM_PATH; ?>employees/employee.php" class="card-link">User accounts</a>
                </div>
            </div>

        </div>



    </div>
    <hr>






    
        <div class="row mt-2">
            <div class='col-md-6'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Managers:
                        <?php
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE designation='manager'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>



                    </h5>


                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Cashiers:
                        <?php
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE designation='cashier'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>

                    </h5>


                </div>
            </div>    


            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Supervisors:
                        <?php
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE designation='supervisor'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>

                    </h5>


                </div>
            </div> 
            
            </div>
            <div class='col-md-6'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Technicians:
                         <?php
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE designation='technician'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>
                        
                    </h5>


                </div>
            </div>    
            
            
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Assistant Technicians:
                         <?php
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE designation='assistant technician'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>
                        
                    </h5>


                </div>
            </div> 
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Storekeeper:
                         <?php
                        $sql = "SELECT COUNT(userid) AS numofusers FROM tbl_employees WHERE designation='storekeeper'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['numofusers'];
                        ?>
                        
                    </h5>


                </div>
            </div> 
            
            </div>
            



        </div>

    

</main>
