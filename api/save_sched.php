<?php
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
    $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
    $cancelled = isset($_POST['cancelled']) ? $db->real_escape_string($_POST['cancelled']) : '';
    $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : '';
    $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
    $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';
    $end_month = isset($_POST['end_month']) ? $db->real_escape_string($_POST['end_month']) : '';
    $end_year = isset($_POST['end_year']) ? $db->real_escape_string($_POST['end_year']) : '';
    $rescheduled_id = isset($_POST['rescheduled_id']) ? $db->real_escape_string($_POST['rescheduled_id']) : '';
    $follow_up = isset($_POST['follow_up']) ? $db->real_escape_string($_POST['follow_up']) : '';


    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($status === "Rescheduled" || $status === "Cancelled" || $status === "Follow Up") {
        $sql = "UPDATE inquiry_tbl SET doctor=?, status=?, cancelled=?, rescheduled=?, diagnose=?, end_datetime=?,end_month=?, end_year=?, follow_up=? WHERE id=?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("siiiiiiiiii", $doctor, $status, $cancelled, $rescheduled, $diagnose, $end_datetime, $end_month, $end_year,  $follow_up, $id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();

        $sql = "INSERT INTO inquiry_tbl (status, rescheduled,rescheduled_id) VALUES (?,?,?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("iii", $status, $rescheduled, $rescheduled_id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        $sql = "UPDATE inquiry_tbl SET doctor=?, status=?, diagnose=?, end_datetime=?, end_month=?, end_year=? WHERE id=?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("ssssiii", $doctor, $status, $diagnose, $end_datetime, $end_month, $end_year, $id);
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
//         $sql = "UPDATE inquiry_tbl SET doctor=?, status = ?, rescheduled = ?, diagnose = ?, end_datetime = ? WHERE id = ?";
//         $stmt = $db->prepare($sql);
//         $stmt->bind_param("sssssi", $doctor, $status, $rescheduled, $diagnose, $end_datetime, $_POST['id']);
//         $stmt->execute();
//         $stmt->close();
//     } else {
//         $sql = "UPDATE inquiry_tbl SET  doctor = ?, status = ?, rescheduled = ?, diagnose = ?, end_datetime = ?, WHERE id = ?";
//         $stmt = $db->prepare($sql);
//         $stmt->bind_param("ssssi", $doctor, $status, $diagnose, $end_datetime,  $_POST['id']);
//         $stmt->execute();
//         $stmt->close();
//     }
// }
