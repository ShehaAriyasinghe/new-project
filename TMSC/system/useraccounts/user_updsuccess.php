<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6>User Account Updated.</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= SYSTEM_PATH; ?>useraccounts/user.php" class="btn btn-sm btn-outline-secondary">View User Accounts</a>
                <button type="button" class="btn btn-sm btn-outline-secondary">Search Product</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Update  Product
            </button>
        </div>
    </div>
    <div class="card my-card-bg">
        <div class="card-header my-card-heading">
            <p class="display-6">User's details are successfully updated.</p>
        </div>
        <div class="card-body">
            <h6 class="">User Name: <?php echo $_SESSION['accountusername']; ?></h6>
            <h6 class="">Job Role: <?php echo ucfirst($_SESSION['useraccountrole']); ?></h6>
            <a href="<?= SYSTEM_PATH; ?>useraccounts/user.php" class="btn card-btn">All user accounts</a>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>    