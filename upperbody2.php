<?php
require 'database/credentials.php';

session_start();
//unset($_SESSION['month']);
if (!empty($_SESSION['password']) && !empty($_SESSION['username'])) {

    $password = $_SESSION['password'];
    $username = $_SESSION['username'];
    $stat = $_SESSION['stat'];
    $staffpos = $_SESSION['position'];
    $month = "";
    $year = "";
    $date = "";

    if (!empty($_SESSION['month'])) {
        $month = $_SESSION['month'];
    }

    require 'templates/header.php';
?>

    <!-- Page Content -->
    <div class="wrap">
    <?php } ?>