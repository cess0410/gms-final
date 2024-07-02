<?php
session_start();
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


print_r($_SESSION);
echo $_SESSION['iuid'];

session_unset();
session_destroy();
header('Location: index.php');
ob_end_flush();
exit();
