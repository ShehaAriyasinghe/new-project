<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        
        <span class="mx-3"><?php echo $_SESSION['firstname']."-". ucwords($_SESSION['userrole'])?></span>
        
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= SYSTEM_PATH; ?>index.php">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>employees/employee.php">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Employees
                </a>
            </li>


            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                    <i class="bi bi-people"></i>
                    Users
                </a>
                <div class="collapse" id="collapseExample2">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>userroles/userrole.php">
                                <i class="bi bi-person-workspace"></i>
                                User Roles
                            </a>
                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>useraccounts/user.php">
                                <span data-feather="users" class="align-text-bottom"></span>
                                User accounts
                            </a>
                        </li>
                    </ul>
                </div>

            </li>
















            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person-workspace"></i>
                    Customer accounts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-journal-richtext"></i>
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="layers" class="align-text-bottom"></span>
                    Integrations
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
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Current month
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Last quarter
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Social engagement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Year-end sale
                </a>
            </li>
        </ul>
    </div>
</nav>  