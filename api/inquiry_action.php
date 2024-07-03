<?php
include 'config.php';
session_start();

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctor = $_POST["doctor"];
    $status = $_POST["status"];
    $rescheduled = $_POST["rescheduled"];
}
