<?php
require_once('config.php');
if (!isset($_GET['id'])) {
    echo "<script> alert('Undefined Schedule ID.'); window.location.href = '../manage_schedule.php'; </script>";
    $db->close();
    exit;
}

$delete = $db->query("DELETE FROM `schedule_list` where id = '{$_GET['id']}'");
if ($delete) {
    echo "<script> alert('Event has deleted successfully.'); window.location.href = '../manage_schedule.php'; </script>";
} else {
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: " . $db->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}
$db->close();
