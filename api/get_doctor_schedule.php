<?php
include('config.php');

if (isset($_GET['doctor_id'])) {
    $doctorId = $_GET['doctor_id'];

    $sql = "SELECT d.id, d.name AS doctor_name, s.specialty, sl.start_datetime, sl.end_datetime 
                    FROM doctors d 
                    LEFT JOIN specialties s ON d.specialty = s.id
                    LEFT JOIN schedule_list sl ON sl.doctor = d.id
                    WHERE d.id = ? ";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die("Error executing query: " . $db->error);
    }
}

$events = array();
while ($row = $result->fetch_assoc()) {
    $events[] = array(
        'id' => $row['id'],
        'title' => $row['doctor_name'],
        'start' => $row['start_datetime'],
        'end' => $row['end_datetime'],
    );
}


header('Content-Type: application/json');
echo json_encode($events);




    // Query to fetch schedule data for the selected doctor
    // $sql = "SELECT d.id, d.name AS title, sl.sched_date, sl.am, sl.pm FROM doctors d LEFT JOIN schedule_list sl ON sl.doctor = d.id WHERE doctor = $doctorId";
    // $sql = "SELECT d.id, d.name AS title, s.specialty, sl.sched_date, sl.am, sl.pm 
    //                     FROM doctors d 
    //                     LEFT JOIN specialties s ON d.specialty = s.id 
    //                     LEFT JOIN schedule_list sl ON sl.doctor = d.id";