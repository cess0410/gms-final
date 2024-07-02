<?php
require_once('config.php');

// Check if either id or specialty parameter is provided
if (isset($_GET['id']) || isset($_GET['specialty'])) {
    // Initialize variables
    $id = $_GET['id'] ?? null;
    $specialty = $_GET['specialty'] ?? null;

    // Prepare the SQL query based on the provided parameters
    if ($id && $specialty) {
        // If both id and specialty are provided
        $sql = $db->prepare("SELECT name, specialty, start_datetime, COUNT(*) AS inquiry_count FROM tblinquiry WHERE id = ? AND specialty = ?");
        $sql->bind_param('is', $id, $specialty);
    } elseif ($id) {
        // If only id is provided
        $sql = $db->prepare("SELECT name, specialty, start_datetime, COUNT(*) AS inquiry_count FROM tblinquiry WHERE id = ?");
        $sql->bind_param('i', $id);
    } elseif ($specialty) {
        // If only specialty is provided
        $sql = $db->prepare("SELECT name, specialty, start_datetime, COUNT(*) AS inquiry_count FROM tblinquiry WHERE specialty = ?");
        $sql->bind_param('s', $specialty);
    }

    // Execute the SQL query
    $sql->execute();

    // Check for errors in query execution
    if ($sql->errno) {
        die("Error executing query: " . $sql->error);
    }

    // Get the result
    $result = $sql->get_result();

    // Fetch the data
    $event_details = $result->fetch_all(MYSQLI_ASSOC);

    // Output the data as JSON
    header('Content-Type: application/json');
    echo json_encode($event_details);
} else {
    // If both id and specialty parameters are missing, return an error message
    echo json_encode(['error' => 'Either id or specialty parameter is required']);
}
