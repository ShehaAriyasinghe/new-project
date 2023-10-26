<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Successfully Created.</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>employees/employee.php" type="button" class="btn btn-sm btn-outline-secondary">View all employees</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update Product
            </button>
        </div>
    </div>


    <h6>Added new employee</h6>



    <div class="row">
        <div class="col-md-6">
            <div class="card card-box px-5 my-card-bg" style="width: 40rem;">

                <div class="card-header my-card-heading">
                    <p class="display-6">Added new employee successfully.</p>
                </div>
                <div class="card-body ">
                    <h6 class="">Employee Name: <?php echo $_SESSION['employeefullname']; ?></h6>
                    <h6 class="">Add Date: <?php echo $_SESSION['adddate']; ?></h6>

                    <h6 class="">Employee Designation: <?php echo ucfirst($_SESSION['employeejobrole']); ?></h6>

                   
                </div>

            </div>

        </div>
    </div>







</main>
<?php include '../footer.php'; ?>