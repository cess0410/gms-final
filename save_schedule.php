<?php
require_once('include/config.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script> alert('Error: No data to save.'); location.replace('./') </script>";
    $db->close();
    exit;
}
extract($_POST);
$allday = isset($allday);

if (empty($id)) {
    $sql = "INSERT INTO `schedule_list` (`doctor`,`specialty`,`start_datetime`,`end_datetime`) VALUES ('$doctor','$specialty','$start_datetime','$end_datetime')";
} else {
    $sql = "UPDATE `schedule_list` set `doctor` = '{$doctor}', `specialty` = '{$specialty}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
}
$save = $db->query($sql);
if ($save) {
    echo "<script> alert('Schedule Successfully Saved.'); location.replace('./') </script>";
} else {
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: " . $db->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}
$db->close();
