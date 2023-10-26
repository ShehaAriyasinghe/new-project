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


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                    <i class="bi bi-people"></i>
                    Job cards
                </a>
                <div class="collapse" id="collapseExample2">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/view_jobcards.php">
                                <i class="bi bi-person-workspace"></i>
                                Issued job cards
                            </a>
                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/pending_jobcards.php">
                                <span data-feather="users" class="align-text-bottom"></span>
                               Pending job cards
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/completed_jobcards.php">
                                <span data-feather="users" class="align-text-bottom"></span>
                               Completed job cards
                            </a>
                        </li>
                        
                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/pendingpayment_jobcards.php">
                                <span data-feather="users" class="align-text-bottom"></span>
                               Pending payments
                            </a>
                        </li>
                   
                    </ul>
                </div>

            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/allvehicles.php">
                   <i class="bi bi-car-front-fill"></i>
                    vehicles history
                </a>
            </li>
            
            
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>investigationreport/create_investigationreport.php">
                    <i class="bi bi-journal-text"></i>
                     Investigation tasks
                </a>
            </li>
            
            
            
            
            
            
            
            
            
            
            
            
            
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Saved reports</span>
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
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/technicianjobcardcount.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Technician jobcards
                </a>
            </li>
            
            
            
            
            
        </ul>
    </div>
</nav>  
