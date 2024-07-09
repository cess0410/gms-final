<?php
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
    $cancelled = isset($_POST['cancelled']) ? $db->real_escape_string($_POST['cancelled']) : '';
    $attended = isset($_POST['attended']) ? $db->real_escape_string($_POST['attended']) : '';
    $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
    $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
    $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';
    $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : '';
    $rescheduled_id = isset($_POST['rescheduled_id']) ? $db->real_escape_string($_POST['rescheduled_id']) : '';
    $follow_up = isset($_POST['follow_up']) ? $db->real_escape_string($_POST['follow_up']) : '';


    $id = isset($_POST['id']) ? intval($_POST['id']) : '';

    if ($status === "2" || $status === "1" || $status === "0" || $status === "Follow Up") {
        $sql = "UPDATE tblinquiry SET status=?, cancelled=?, attended=?, doctor=?, diagnose = ?, end_datetime=? WHERE id=?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("iiiiiii", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();

        $sql = "INSERT INTO tblinquiry (status, rescheduled,rescheduled_id, follow_up) VALUES (?,?,?,?)";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("iiui", $status, $rescheduled, $rescheduled_id, $id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        $sql = "UPDATE tblinquiry SET status=?, cancelled=?, attended=?, doctor=?, diagnose = ?, end_datetime=? WHERE id=?";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $stmt->bind_param("ssssiii", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $id);
        $stmt->execute();

        if ($stmt->error) {
            die('Execute error: ' . $stmt->error);
        }

        $stmt->close();
    }
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