<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse my-nav-bg">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= WEB_PATH; ?>dashboard.php">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= WEB_PATH; ?>customers/view_customer.php">
                    
                   <i class="bi bi-person"></i>
                    User
                </a>
            </li>
            
                

            <li class="nav-item">
                <a class="nav-link" href="<?= WEB_PATH; ?>vehicles/view_vehicles.php">
                    
                    <i class="bi bi-truck-front-fill"></i>
                    Vehicles
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= WEB_PATH; ?>vehiclejobcard/viewjobcardvehicles.php">
                    <i class="bi bi-journal"></i>
                     Completed Job
                </a>
            </li>
            
            
            <li class="nav-item">
                <a class="nav-link" href="<?= WEB_PATH; ?>payments/viewjobcardpayment.php">
                     <i class="bi bi-credit-card"></i>
                      Payments
                </a>
            </li>
            
        
            
            <li class="nav-item">
                <a class="nav-link" href="<?= WEB_PATH; ?>feedback/addfeedback.php">
                    <i class="bi bi-journal-richtext"></i>
                    Feed backs
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
                <a class="nav-link" href="<?= WEB_PATH; ?>/reports/customerallexpenditures.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Customer Expenditure Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= WEB_PATH; ?>/reports/customerallvehicleexpenditures.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Customer Vehicle Expenditure Reports
                </a>
            </li>
            
            
        </ul>
    </div>
</nav>  