<?php
include 'config.php';
if (isset($_POST['action']) && $_POST['action'] === "update") {

    // Validate and sanitize inputs
    $id = $_POST['id'];
    $consultdate = $db->real_escape_string($_POST['consultdate']);
    $consultmonth = $db->real_escape_string($_POST['consultmonth']);
    $consultyear = $db->real_escape_string($_POST['consultyear']);
    $receiver = $db->real_escape_string($_POST['receiver']);
    $mode = $db->real_escape_string($_POST['mode']);
    $endorsement = $db->real_escape_string($_POST['endorsement']);
    $name = $db->real_escape_string($_POST['name']);
    $type = $db->real_escape_string($_POST['type']);
    $birthdate = $db->real_escape_string($_POST['birthdate']);
    $age = $db->real_escape_string($_POST['age']);
    $gender = $db->real_escape_string($_POST['gender']);
    $contact_no = $db->real_escape_string($_POST['contact_no']);
    $specialty = $db->real_escape_string($_POST['specialty']);
    $remarks = $db->real_escape_string($_POST['remarks']);
    $schedule = $db->real_escape_string($_POST['schedule']);


    $sql = "UPDATE tblinquiry SET
                consultdate = '$consultdate',
                consultmonth = '$consultmonth',
                consultyear = '$consultyear',
                receiver = '$receiver',
                mode = '$mode',
                endorsement = '$endorsement',
                name = '$name',
                type = '$type',
                birthdate = '$birthdate',
                age = '$age',
                gender = '$gender',
                contact_no = '$contact_no',
                specialty = '$specialty',
                remarks = '$remarks',
                schedule = '$schedule',
                WHERE id = $id";

    if ($db->query($sql) === TRUE) {
        // Log the insert operation
        $insert_id = $db->insert_id; // Get the last insert id
        $user_id = $_SESSION['iuid'];

        // Insert data into tblinquiry_logs
        $log_sql = "INSERT INTO tblinquiry_logs (consultdate, consultmonth, consultyear, receiver, mode, endorsement, name, type, birthdate, age, gender, contact_no, specialty, remarks, schedule, inquiry_id, user_id)
                VALUES ('$consultdate', '$consultmonth', '$consultyear', '$receiver', '$mode', '$endorsement', '$name', '$type', '$birthdate', '$age', '$gender', '$contact_no', '$specialty', '$remarks', '$schedule', '$insert_id', '$user_id')";
        if ($db->query($log_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error logging insert operation: " . $db->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}
