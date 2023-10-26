<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>




<main>


    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card my-card-bg card-box px-2" style="width: 50rem; ">
                <div class="card-header text-center card-header">
                    <h2 class="display-6 fw-bolder text-white">Customer successfully Registered..!</h2>
                </div>

                <div class="card-body">

                    <p class="card-text">Congratulations, your account has been successfully created.</p>
                    <h3>Your Registration Number is</h3>
                    <h1 class="heading"><strong><?php echo $_SESSION['RegNumber']; ?></strong></h1>


                    <?php if (isset($_SESSION['reservation_date'])) { ?>
                    <p class="card-text">If you want to confirm your reservation and also you want to add the vehicle for your reservation. You must log in to the system now.</p>
                        <?php
                    }
                    ?>



                    <a href="<?= WEB_PATH; ?>index.php" class="btn btn-outline-primary">Home Page</a>
                    <a href="<?= WEB_PATH; ?>customers/customer_login.php" class="btn btn-outline-primary">Login Page</a>

                </div>

            </div>
        </div>
    </div>

</main>
</html>
