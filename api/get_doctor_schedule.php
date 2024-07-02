<?php
include('config.php');

if (isset($_GET['doctor_id'])) {
    $doctorId = $_GET['doctor_id'];

    // Query to fetch schedule data for the selected doctor
    $sql = "SELECT d.id, d.name AS title, sl.sched_date, sl.am, sl.pm FROM doctors d LEFT JOIN schedule_list sl ON sl.doctor = d.id WHERE doctor = $doctorId";
    // $sql = "SELECT d.id, d.name AS title, s.specialty, sl.sched_date, sl.am, sl.pm 
    //                     FROM doctors d 
    //                     LEFT JOIN specialties s ON d.specialty = s.id 
    //                     LEFT JOIN schedule_list sl ON sl.doctor = d.id";
    $result = $db->query($sql);

    // Check for errors in query execution
    if ($result === false) {
        die("Error executing query: " . $db->error);
    }


    $events = array();
    while ($row = $result->fetch_assoc()) {
        // Format each row as required by FullCalendar
        $events[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['sched_date'] . 'T' . $row['am'],
            'end' => $row['sched_date'] . 'T' . $row['pm']
        );
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($events);
}
