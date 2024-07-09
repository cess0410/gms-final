<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = isset($_POST['id']) ? $db->real_escape_string($_POST['id']) : '';
    $scheduled = isset($_POST['scheduled']) ? $db->real_escape_string($_POST['scheduled']) : '';
    $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
    $cancelled = isset($_POST['cancelled']) ? $db->real_escape_string($_POST['cancelled']) : null;
    $attended = isset($_POST['end_datetime']) ? $_POST['end_datetime'] : null;
    $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : null;
    $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : null;
    $end_datetime = isset($_POST['end_datetime']) ? date('Y-m-d H:i:s', strtotime($_POST['end_datetime'])) : null;
    $rescheduled = isset($_POST['rescheduled']) ? date('Y-m-d H:i:s', strtotime($_POST['rescheduled'])) : null;
    $follow_up = isset($_POST['follow_up']) ? $db->real_escape_string($_POST['follow_up']) : null;

    $rescheduled_id = $id;
    $attended = $end_datetime;
    $cancelled = $scheduled;

    $sql = "UPDATE tblinquiry SET status=?, cancelled=?, attended=?, doctor=?, diagnose=?, end_datetime=?, rescheduled=?, rescheduled_id=?, follow_up=? WHERE id=?";
    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $db->error);
    }

    $stmt->bind_param("sssssssssi", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $rescheduled, $rescheduled_id, $follow_up, $id);
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

    $stmt->bind_param("sssssssssi", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $rescheduled, $rescheduled_id, $follow_up, $id);
    $stmt->execute();

    if ($stmt->error) {
        die('Execute error: ' . $stmt->error);
    }

    $stmt->close();
}
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