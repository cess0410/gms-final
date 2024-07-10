<?php
include 'config.php';
session_start();

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $consultdate = $_POST["consultdate"];
    $consultmonth = $_POST["consultmonth"];
    $consultyear = $_POST["consultyear"];
    $receiver = $_POST["receiver"];
    $mode = $_POST["mode"];
    $endorsement = $_POST["endorsement"];
    $name = $_POST["name"];
    $type = $_POST["type"];
    $birthdate = $_POST["birthdate"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $contact_no = $_POST["contact_no"];
    $specialty = $_POST["specialty"];
    $remarks = $_POST["remarks"];
    $schedule = $_POST["schedule"];
    $status = $_POST["status"];
    $cancelled = $_POST["cancelled"];
    $attended = $_POST["attended"];
    $doctor = $_POST["doctor"];
    $diagnose = $_POST["diagnose"];
    $end_datetime = $_POST["end_datetime"];
    $rescheduled = $_POST["rescheduled"];
    $rescheduled_id = $_POST["rescheduled_id"];
    $follow_up = $id;

    $sql = "INSERT INTO tblinquiry (consultdate, consultmonth, consultyear, receiver, mode, endorsement, name, type, birthdate, age, gender, contact_no, specialty, remarks, schedule, status, cancelled, attended, doctor, diagnose, end_datetime, rescheduled, rescheduled_id, follow_up)
            VALUES ('$consultdate', '$consultmonth', '$consultyear','$receiver', '$mode', '$endorsement', '$name', '$type', '$birthdate', '$age', '$gender', '$contact_no', '$specialty', '$remarks', '$schedule', '$status', '$cancelled', '$attended', '$doctor', '$diagnose', '$end_datetime', '$rescheduled', '$rescheduled_id', '$follow_up')";

    if ($db->query($sql) === TRUE) {
        $insert_id = $db->insert_id;
        $user_id = $_SESSION['iuid'];

        $log_sql = "INSERT INTO tblinquiry_logs (consultdate, consultmonth, consultyear, receiver, mode, endorsement, name, type, birthdate, age, gender, contact_no, specialty, remarks, schedule, status, cancelled, attended, doctor, diagnose, end_datetime, rescheduled, rescheduled_id, follow_up, inquiry_id, user_id)
                    VALUES ('$consultdate', '$consultmonth', '$consultyear', '$receiver', '$mode', '$endorsement', '$name', '$type', '$birthdate', '$age', '$gender', '$contact_no', '$specialty', '$remarks', '$schedule', '$status', '$cancelled', '$attended', '$doctor', '$diagnose', '$end_datetime', '$rescheduled', '$rescheduled_id', '$follow_up', '$insert_id', '$user_id')";
        if ($db->query($log_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error logging insert operation: " . $db->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
