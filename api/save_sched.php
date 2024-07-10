<?php
include 'config.php';
session_start();

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $schedule = isset($_POST['schedule']) ? $db->real_escape_string($_POST['schedule']) : '';
    $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
    $cancelled = isset($_POST['cancelled']) ? $db->real_escape_string($_POST['cancelled']) : '';
    $attended = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';
    $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
    $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
    $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';
    $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : '';
    $follow_up = isset($_POST['follow_up']) ? $db->real_escape_string($_POST['follow_up']) : '';

    $sql = "UPDATE tblinquiry SET 
            status='$status', 
            cancelled='$cancelled', 
            attended='$attended', 
            doctor='$doctor', 
            diagnose='$diagnose', 
            end_datetime='$end_datetime', 
            follow_up='$follow_up'";

    if ($status === '1') {
        $sql .= ", cancelled = '$cancelled'";
    } else if ($status === '2') {
        $sql .= ", rescheduled = '$rescheduled', rescheduled_id = '$id', cancelled = ''";
    } else {
        $sql .= ", rescheduled_id = '', cancelled = ''";
    }


    $sql .= " WHERE id='$id'";

    if ($db->query($sql) === TRUE) {
        $insert_id = $db->insert_id;

        $user_id = $_SESSION['iuid'];
        $log_sql = "INSERT INTO tblinquiry_logs (status, cancelled, attended, doctor, diagnose, end_datetime, rescheduled, rescheduled_id, follow_up, inquiry_id, user_id)
                    VALUES ('$status', '$cancelled', '$attended', '$doctor', '$diagnose', '$end_datetime', '$rescheduled', '$id', '$follow_up', '$insert_id', '$user_id')";

        if ($db->query($log_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error logging insert operation: " . $db->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    $db->close();
}
