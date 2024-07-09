<?php
include 'config.php';


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $status = isset($_POST['status']) ? $db->real_escape_string($_POST['status']) : '';
        $cancelled = isset($_POST['cancelled']) ? $db->real_escape_string($_POST['cancelled']) : '';
        $attended = isset($_POST['attended']) ? $db->real_escape_string($_POST['attended']) : '';
        $doctor = isset($_POST['doctor']) ? $db->real_escape_string($_POST['doctor']) : '';
        $diagnose = isset($_POST['diagnose']) ? $db->real_escape_string($_POST['diagnose']) : '';
        $end_datetime = isset($_POST['end_datetime']) ? $db->real_escape_string($_POST['end_datetime']) : '';
        $rescheduled = isset($_POST['rescheduled']) ? $db->real_escape_string($_POST['rescheduled']) : null;
        $rescheduled_id = isset($_POST['rescheduled_id']) ? $db->real_escape_string($_POST['rescheduled_id']) : null;
        $follow_up = isset($_POST['follow_up']) ? $db->real_escape_string($_POST['follow_up']) : null;
    
    
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
        if ($status === "2" || $status === "1" || $status === "Follow Up") {
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
    
            $sql = "INSERT INTO tblinquiry (status, rescheduled,rescheduled_id, follow_up) VALUES (?,?,?, ?)";
            $stmt = $db->prepare($sql);
    
            if (!$stmt) {
                die('Prepare failed: ' . $db->error);
            }
    
            $stmt->bind_param("ssi", $status, $rescheduled, $rescheduled_id);
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
    
            $stmt->bind_param("ssssssi", $status, $cancelled, $attended, $doctor, $diagnose, $end_datetime, $id);
            $stmt->execute();
    
            if ($stmt->error) {
                die('Execute error: ' . $stmt->error);
            }
    
            $stmt->close();
        }
    }
    
    
    
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
