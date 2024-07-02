<?php
require_once('config.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script> alert('Error: No data to save.'); location.replace('./') </script>";
    $db->close();
    exit;
}
extract($_POST);
$allday = isset($allday);

if (empty($id)) {
    $sql = "INSERT INTO `schedule_list` (`doctor`,`specialty`,`sched_date`,`am`, `pm`) VALUES ('$doctor','$specialty','$sched_date','$am', '$pm')";
} else {
    $sql = "UPDATE `schedule_list` set `doctor` = '{$doctor}', `specialty` = '{$specialty}', `sched_date` = '{$sched_date}', `am` = '{$am}', `pm` = '{$pm}' where `id` = '{$id}'";
}
$save = $db->query($sql);
if ($save) {
    echo "<script> alert('Schedule Successfully Saved.'); window.location.href = '../manage_schedule.php'; </script>";
} else {
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: " . $db->error . "<br>";
    echo "Error: " . $db->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}
$db->close();
