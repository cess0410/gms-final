<?php
session_start();
ob_start();
include_once "api/config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMS</title>
    <script src="/gms-final/assets/js/jquery-3.6.0.min.js"></script>
    <?php include 'template_scripts_fullcalendar.php' ?>
    <?php include 'template_scripts_datatables.php' ?>
    <link rel="stylesheet" href="vendors/themify-icons.css">
    <link href="/gms-final/assets/css/daisy.css" rel="stylesheet" type="text/css" />
    <link href="/gms-final/assets/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="/gms-final/assets/css/all.min1.css" rel="stylesheet" type="text/css" />
    <script src="/gms-final/assets/js/tailwind.js"></script>
    <script src="/gms-final/assets/js/sweetalert.js"></script>

</head>
<style>
    body {

        font-family: 'mulish', sans-serif !important;
    }

    h2.card-title.my-5.m-auto {
        color: white !important;
    }
</style>

<body>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-[#036d21] w-full text-white">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="mx-2 flex-1 px-2"></div>
                <div class="hidden flex-none lg:block">
                    <ul class="menu menu-horizontal">
                        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                    </ul>
                </div>
            </div>
            <div>