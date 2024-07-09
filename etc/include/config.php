<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Manila");
$dbhost = "localhost";
$dbname = "gms";
$dbuser = "root";
$dbpass = "";

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);


if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
