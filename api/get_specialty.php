<?php
include 'config.php';

if (isset($_GET['doctor_id'])) {
    $doctor_id = mysqli_real_escape_string($db, $_GET['doctor_id']);

    $query = "SELECT s.specialty FROM doctors d LEFT JOIN specialties s ON d.specialty = s.id WHERE d.id = '$doctor_id'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['specialty'];
    } else {
        echo 'Specialty not found';
    }
} else {
    echo 'Doctor ID parameter is missing';
}
