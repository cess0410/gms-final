<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === "fetch") {
    // Fetch specialties
    // $sql = "SELECT d.id, d.specialty AS doctor_specialty, s.specialty AS specialty
    // FROM specialties d
    // LEFT JOIN specialties s ON d.id = s.id;";

    $sql = "SELECT * FROM tblinquiry";

    $result = $db->query($sql);
}
