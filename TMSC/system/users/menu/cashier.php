<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        
         <img class="rounded-circle w-100 h-25" src="<?= SYSTEM_PATH ?>employees/images/<?= !empty($_SESSION['image'])?$_SESSION['image']:'noimage.jpeg' ?>">
        
        <span class="mx-3"><?php echo $_SESSION['firstname']."-". ucwords($_SESSION['userrole'])?></span>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= SYSTEM_PATH; ?>index.php">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reservations/view_reservations.php">
                    <i class="bi bi-journal-text"></i>
                    Reservations
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php">
                    <i class="bi bi-journal"></i>
                    Job cards
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="bi bi-credit-card"></i>
                    Payments
                </a>
                <div class="collapse" id="collapseExample">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/pendingpayment_jobcards.php">
                               <i class="bi bi-credit-card"></i>
                                Pending payments of job cards
                            </a>

                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/completedpayment_jobcards.php">
                                <i class="bi bi-credit-card"></i>
                                Completed payments
                            </a>
                        </li>    
                    </ul>    
                </div>

            </li>
            
             <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/viewalladdedvehicles.php">
                   <i class="bi bi-car-front-fill"></i>
                    All vehicles
                </a>
            </li>
            
            

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/allvehicles.php">
                   <i class="bi bi-car-front-fill"></i>
                    vehicles history
                </a>
            </li>








        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle" class="align-text-bottom"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/reservationsreport.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Reservation Report
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/serviceincomereport.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                   Service Income Report
                </a>
            </li>
            
            
            
         
            
        </ul>
    </div>
</nav>  