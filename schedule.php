<?php
session_start();
ob_start();
include "include/config.php";
include "include/header.php";
include "include/sidebar.php";
include "include/calendar.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
$appointments = $db->query("SELECT * FROM `inquiry_tbl` where `status` in (0,1) and date(schedule) >= '" . date("Y-m-d") . "' ");
$appoinment_arr = [];
while ($row = $appointments->fetch_assoc()) {
    if (!isset($appoinment_arr[$row['schedule']])) $appoinment_arr[$row['schedule']] = 0;
    $appoinment_arr[$row['schedule']] += 1;
}
