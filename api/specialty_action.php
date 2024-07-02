<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === "fetch") {
    // Fetch specialties
    // $sql = "SELECT d.id, d.specialty AS doctor_specialty, s.specialty AS specialty
    // FROM specialties d
    // LEFT JOIN specialties s ON d.id = s.id;";

    $sql = "SELECT * FROM specialties";

    $result = $db->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                // echo "<td>" . $row["id"] . "</td>";
                echo "<td class='specialty'  style='color: black; font-weight: 400'>" . $row["specialty"] . "</td>";
                echo "<td><button class='editBtn btn_1'  data-id='" . $row["id"] . "'>Edit</button>
             <button class='deleteBtn btn_1'   data-id='" . $row["id"] . "'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No specialties found</td></tr>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    if ($_POST['action'] === "add") {
        // Add doctor

        $specialty = $db->real_escape_string($_POST['specialty']);
        $sql = "INSERT INTO specialties (specialty) VALUES ('$specialty')";
        if ($db->query($sql) === TRUE) {
            echo "Specialty added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

    if ($_POST['action'] === "update") {
        // Update doctor
        $id = $_POST['id'];
        $specialty = $db->real_escape_string($_POST['specialty']);
        $sql = "UPDATE specialties SET specialty='$specialty'WHERE id=$id";
        if ($db->query($sql) === TRUE) {
            echo "Doctor updated successfully";
        } else {
            echo "Error updating doctor: " . $db->error;
        }
    }

    if ($_POST['action'] === "delete") {
        // Delete doctor
        $id = $_POST['id'];
        $sql = "DELETE FROM specialties WHERE id=$id";
        if ($db->query($sql) === TRUE) {
            echo "Doctor deleted successfully";
        } else {
            echo "Error deleting doctor: " . $db->error;
        }
    }
}

$db->close();
