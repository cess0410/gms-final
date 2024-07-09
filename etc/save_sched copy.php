<?php
include("config.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = isset($_POST['id']) ? $db->real_escape_string($_POST['id']) : '';
    $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
    $cancelled = isset($_POST['cancelled']) ? $db->real_escape_string($_POST['cancelled']) : '';
    $attended = isset($_POST['attended']) ? $db->real_escape_string($_POST['attended']) : '';
    $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
    $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
    $end_datetime = isset($_POST['end_datetime']) ? date('Y-m-d H:i:s', strtotime($_POST['end_datetime'])) : null;
    $rescheduled = isset($_POST['rescheduled']) ?  $_POST['rescheduled'] : null;
    $follow_up = isset($_POST['follow_up']) ? $db->real_escape_string($_POST['follow_up']) : '';

    $rescheduled_id = $id;

    $sql = "UPDATE tblinquiry SET status=?, cancelled=?, attended=?, doctor=?, diagnose=?, end_datetime=?, rescheduled=?, rescheduled_id=?, follow_up=? WHERE id=?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $db->error);
    }

    $stmt->bind_param("iiiiisiiii", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $rescheduled, $rescheduled_id, $follow_up, $id);
    $stmt->execute();

    if ($stmt->error) {
        die('Execute error: ' . $stmt->error);
    }

    $stmt->close();

    // $sql = "INSERT INTO tblinquiry (status, rescheduled,rescheduled_id, follow_up,id) VALUES (?,?,?,?,?)";
    // $stmt = $db->prepare($sql);

    // if (!$stmt) {
    //     die('Prepare failed: ' . $db->error);
    // }

    // $stmt->bind_param("iiiii", $status, $rescheduled, $rescheduled_id, $follow_up, $id);
    // $stmt->execute();

    // if ($stmt->error) {
    //     die('Execute error: ' . $stmt->error);
    // }
    // $stmt->close();
} else {
    $sql = "UPDATE tblinquiry SET status=?, cancelled=?, attended=?, doctor=?, diagnose = ?, end_datetime=?, rescheduled=?, rescheduled_id=?, follow_up=? WHERE id=?";
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        die('Prepare failed: ' . $db->error);
    }

    $stmt->bind_param("ssssiii", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $rescheduled, $rescheduled_id, $follow_up, $id);
    $stmt->execute();

    if ($stmt->error) {
        die('Execute error: ' . $stmt->error);
    }

    $stmt->close();
}





// if ($_SERVER["REQUEST_METHOD"] === "POST") {
// $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
// $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
// $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : '';
// $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
// $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';


// if ($status === "Rescheduled") {
// $sql = "UPDATE tblinquiry SET doctor=?, status = ?, rescheduled = ?, diagnose = ?, end_datetime = ? WHERE id = ?";
// $stmt = $db->prepare($sql);
// $stmt->bind_param("sssssi", $doctor, $status, $rescheduled, $diagnose, $end_datetime, $_POST['id']);
// $stmt->execute();
// $stmt->close();
// } else {
// $sql = "UPDATE tblinquiry SET doctor = ?, status = ?, rescheduled = ?, diagnose = ?, end_datetime = ?, WHERE id = ?";
// $stmt = $db->prepare($sql);
// $stmt->bind_param("ssssi", $doctor, $status, $diagnose, $end_datetime, $_POST['id']);
// $stmt->execute();
// $stmt->close();
// }
// }