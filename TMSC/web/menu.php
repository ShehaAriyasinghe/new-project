
<div class="row">

  

        <nav class="navbar navbar-expand-md navbar-light my-nav-bg">


            <a class="navbar-brand" href="#"><img src="<?= SYSTEM_PATH; ?>assets/images/logo.png" class="img-fluid" width="70"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">



                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= WEB_PATH; ?>index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= WEB_PATH; ?>aboutus.php">ABOUT US</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="<?= WEB_PATH; ?>contact.php">CONTACT</a>
                    </li>
                    <?php
                    if (isset($_SESSION['customer_userid'])) {
                        ?>    
                        <li class="nav-item">
                            <a class="nav-link" href="<?= WEB_PATH; ?>dashboard.php">DASHBOARD</a>
                        </li> 


                        <?php
                    } else {
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                MY ACCOUNT
                            </a>
                            <ul class="dropdown-menu my-nav-bg" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="<?= WEB_PATH; ?>customers/customer_registration.php">Register</a></li>
                                <li><a class="dropdown-item" href="<?= WEB_PATH; ?>customers/customer_login.php">Sign In</a></li>

                            </ul>
                        </li>
                    </ul>



                    <?php
                }
                ?>

            </div>  

            


            <ul class="nav end-0 mx--1">

                <li class="nav-item mx-3 my-4 ">

                    <?php
                    $lastname = @$_SESSION['customer_lastname'];
                    $title = @$_SESSION['customer_title'];

                    if (isset($_SESSION['customer_userid'])) {
                        echo "Welcome," . " " . $title . " " . ucfirst($lastname);
                        ?>
                    </li>


                    <li class="nav-item mx-3 my-3">

                        <a class="nav-link" href="<?= WEB_PATH; ?>customers/customer_logout.php">Sign Out</a>

                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">

                        <a class="nav-link" href="<?= WEB_PATH; ?>customers/customer_login.php">Sign In</a>

                    </li>


                    <?php
                }
                ?>

            </ul>
        </nav>
</div>