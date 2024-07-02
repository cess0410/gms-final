<?php
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
    $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
    $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : '';
    $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
    $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';

    // Validate $_POST['id'] to prevent SQL injection
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($status === "Rescheduled") {
        $sql = "UPDATE tblinquiry SET doctor=?, status=?, rescheduled=?, diagnose=?, end_datetime=? WHERE id=?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("sssssi", $doctor, $status, $rescheduled, $diagnose, $end_datetime, $id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        $sql = "UPDATE tblinquiry SET doctor=?, status=?, diagnose=?, end_datetime=? WHERE id=?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("ssssi", $doctor, $status, $diagnose, $end_datetime, $id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();
    }
}


// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
//     $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
//     $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : '';
//     $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
//     $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';


//     if ($status === "Rescheduled") {
//         $sql = "UPDATE tblinquiry SET doctor=?, status = ?, rescheduled = ?, diagnose = ?, end_datetime = ? WHERE id = ?";
//         $stmt = $db->prepare($sql);
//         $stmt->bind_param("sssssi", $doctor, $status, $rescheduled, $diagnose, $end_datetime, $_POST['id']);
//         $stmt->execute();
//         $stmt->close();
//     } else {
//         $sql = "UPDATE tblinquiry SET  doctor = ?, status = ?, rescheduled = ?, diagnose = ?, end_datetime = ?, WHERE id = ?";
//         $stmt = $db->prepare($sql);
//         $stmt->bind_param("ssssi", $doctor, $status, $diagnose, $end_datetime,  $_POST['id']);
//         $stmt->execute();
//         $stmt->close();
//     }
// }
