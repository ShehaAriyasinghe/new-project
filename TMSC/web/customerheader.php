<?php
ob_start();
session_start();
include 'config.php';
include 'function.php';


if (!isset($_SESSION['customer_userid'])) {
    header("Location:http://localhost:8080/tmsc/web/customers/customer_login.php");
}




?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ThusithaServiceCentre-HONDA</title>

        <link href="<?= WEB_PATH; ?>assets/css/bootstrap.min.css" rel="stylesheet">


        <!-- Custom styles -->
        <link href="<?= WEB_PATH; ?>assets/css/dashboard.css" rel="stylesheet">

        <link href="<?= SYSTEM_PATH; ?>assets/css/mystyle.css" rel="stylesheet" type="text/css"/>

        <!-- bootstrap icons -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


        <!-- font-awesome icons link -->

        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <header class="my-nav-bg navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">ServiceCenter-HONDA</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">

                    <span class='nav-heading'>Welcome, <?php echo $_SESSION['customer_title']." ".$_SESSION['customer_firstname'] ." ".$_SESSION['customer_lastname'];?></span>
                    <a class="top-0 end-0 nav-heading px-3" href="<?= WEB_PATH; ?>customers/customer_logout.php">Sign out</a>
                </div>
            </div>  
        </header>

        <div class="container-fluid">
            <div class="row">