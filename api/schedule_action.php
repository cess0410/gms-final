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
if (strtotime($start_datetime) > strtotime($end_datetime)) {
    echo "<script> alert('Start time should be lesser than End time.'); location.replace('./') </script>";
    $db->close();
    exit;
}
$conflict = $db->query("SELECT id FROM schedule_list WHERE doctor = '$doctor' AND specialty = '$specialty' AND ((start_datetime <= '$end_datetime' AND end_datetime >= '$start_datetime') OR (start_datetime <= '$start_datetime' AND end_datetime >= '$end_datetime'))")->num_rows > 0;

if ($conflict) {
    echo "<script> alert('Schedule conflicts with existing Schedule.'); window.location.href = '../manage_schedule.php';</script>";
    $db->close();
    exit;
}else{
    $insert_sql = "INSERT INTO `schedule_list` (`doctor`, `specialty`, `start_datetime`, `end_datetime`) VALUES ('$doctor', '$specialty', '$start_datetime', '$end_datetime')";
    $save = $db->query($insert_sql);
    if ($save) {
        echo "<script> alert('Schedule Successfully Saved.'); window.location.href = '../manage_schedule.php';</script>";
    } else {
        echo "<pre>";
        echo "An Error occured.<br>";
        echo "Error: " . $db->error . "<br>";
        echo "SQL: " . $insert_sql  . "<br>";
        echo "</pre>";
    }

}
// } else {
//     $sql = "UPDATE `schedule_list` set `doctor` = ?, `specialty` = ?, `start_datetime` = ?, `end_datetime` = ? where `id` = ?";
//     $stmt = $db->prepare($sql);
//     $stmt->bind_param("sssss", $doctor, $specialty, $start_datetime, $end_datetime, $id);
//     $stmt->execute();
// }

$db->close();
