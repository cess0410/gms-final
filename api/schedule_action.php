<?php
require_once('config.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script> alert('Error: No data to save.'); location.replace('./') </script>";
    $db->close();
    exit;
}
extract($_POST);
$allday = isset($allday);
// process start time and emd time using $start_datetime and $end_datetime
// if (empty($id)) {
$sql = "SELECT id FROM schedule_list WHERE doctor = ? AND specialty = ? AND ((start_datetime <= ? AND end_datetime >= ?) OR (start_datetime <= ? AND end_datetime >= ?))";
$stmt = $db->prepare($sql);
$stmt->bind_param("ssssss", $doctor, $specialty, $end_datetime, $start_datetime, $end_datetime, $start_datetime);
$stmt->execute();
$stmt->store_result();
$conflict = $stmt->num_rows() > 0;

if (!$conflict) {
    $insert_sql = "INSERT INTO `schedule_list` (`doctor`, `specialty`, `start_datetime`, `end_datetime`) VALUES (?, ?, ?, ?)";
    $insert_stmt = $db->prepare($insert_sql);
    $insert_stmt->bind_param("ssss", $doctor, $specialty, $start_datetime, $end_datetime);


    if (!$insert_stmt->execute()) {
        echo "<pre>";
        echo "An error occurred.<br>";
        echo "Error: " . $insert_stmt->error . "<br>";
        echo "SQL: " . $insert_sql . "<br>";
        echo "</pre>";
    }
} else {

    echo "<script> alert('Schedule conflicts with existing Schedule.'); window.location.href = '../manage_schedule.php';</script>";
}
// } else {
//     $sql = "UPDATE `schedule_list` set `doctor` = ?, `specialty` = ?, `start_datetime` = ?, `end_datetime` = ? where `id` = ?";
//     $stmt = $db->prepare($sql);
//     $stmt->bind_param("sssss", $doctor, $specialty, $start_datetime, $end_datetime, $id);
//     $stmt->execute();
// }
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
