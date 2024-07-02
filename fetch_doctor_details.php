<?php include "include/config.php";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $doctorId = $_GET['id'];

    // Query to fetch doctor details
    $query = "SELECT d.name AS doctor_name, s.specialty, sl.sched_date, sl.am, sl.pm 
              FROM doctors d 
              LEFT JOIN specialties s ON d.specialty = s.id 
              LEFT JOIN schedule_list sl ON sl.doctor = d.id 
              WHERE d.id = $doctorId";

    $result = $db->query($query);

    if ($result) {
        // Fetch data as associative array
        $doctorDetails = $result->fetch_assoc();

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($doctorDetails);
    } else {
        // Error handling for query execution
        echo json_encode(['error' => 'Failed to fetch doctor details']);
    }

    // Close database connection
    $db->close();
} else {
    // Handle case where ID parameter is missing or invalid
    echo json_encode(['error' => 'Invalid doctor ID']);
}
