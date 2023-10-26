<?php

session_start();

extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_SESSION['subservicetask'][] = $task;

    header("Location:editsub.php");
}
?>    