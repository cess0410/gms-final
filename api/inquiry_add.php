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
    $start_datetime = $_POST["start_datetime"];

    // Insert data into tblinquiry
    $sql = "INSERT INTO tblinquiry (consultdate, consultmonth, consultyear, receiver, mode, endorsement, name, type, birthdate, age, gender, contact_no, specialty, remarks, start_datetime)
            VALUES ('$consultdate', '$consultmonth', '$consultyear','$receiver', '$mode', '$endorsement', '$name', '$type', '$birthdate', '$age', '$gender', '$contact_no', '$specialty', '$remarks', '$start_datetime')";

    if ($db->query($sql) === TRUE) {
        // Log the insert operation
        $insert_id = $db->insert_id; // Get the last insert id
        $user_id = $_SESSION['iuid'];

        // Insert data into tblinquiry_logs
        $log_sql = "INSERT INTO tblinquiry_logs (consultdate, consultmonth, consultyear, receiver, mode, endorsement, name, type, birthdate, age, gender, contact_no, specialty, remarks, start_datetime, inquiry_id, user_id)
                    VALUES ('$consultdate', '$consultmonth', '$consultyear', '$receiver', '$mode', '$endorsement', '$name', '$type', '$birthdate', '$age', '$gender', '$contact_no', '$specialty', '$remarks', '$start_datetime', '$insert_id', '$user_id')";
        if ($db->query($log_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error logging insert operation: " . $db->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
