<?php
include('config.php');

// if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === "fetch") {
//     // Fetch doctors
//     $sql = "SELECT d.id, d.name AS doctor_name, s.specialty AS specialty
//     FROM doctors d
//     LEFT JOIN specialties s ON d.id = s.id;";



//     $sql = "SELECT d.id, d.name AS doctor_name, s.specialty AS specialty FROM doctors d LEFT JOIN specialties s ON d.id = s.id";

//     $result = $db->query($sql);

//     if ($result) {
//         if ($result->num_rows > 0) {
//             while ($row = $result->fetch_assoc()) {
//                 echo "<tr>";
//                 // echo "<td>" . $row["id"] . "</td>";
//                 echo "<td class='doctorName'  style='color: black; font-weight: 400'>" . $row["doctor_name"] . "</td>";
//                 echo "<td class='doctorSpecialty'  style='color: black; font-weight: 400'>" . $row["specialty"] . "</td>";
//                 echo "<td><button class='editBtn btn_1'  data-id='" . $row["id"] . "'>Edit</button>
//              <button class='deleteBtn btn_1'   data-id='" . $row["id"] . "'>Delete</button></td>";
//                 echo "</tr>";
//             }
//         } else {
//             echo "<tr><td colspan='5'>No doctors found</td></tr>";
//         }
//     } else {
//         echo "Error: " . $sql . "<br>" . $db->error;
//     }
// }

// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
//     if ($_POST['action'] === "add") {
//         // Add doctor
//         $name = $db->real_escape_string($_POST['name']);
//         $specialty = $db->real_escape_string($_POST['specialty']);
//         $sql = "INSERT INTO doctors (name, specialty) VALUES ('$name', '$specialty')";
//         if ($db->query($sql) === TRUE) {
//             echo "Doctor added successfully";
//         } else {
//             echo "Error: " . $sql . "<br>" . $db->error;
//         }
//     }

//     if ($_POST['action'] === "update") {
//         // Update doctor
//         $id = $_POST['id'];
//         $name = $db->real_escape_string($_POST['name']);
//         $specialty = $db->real_escape_string($_POST['specialty']);
//         $sql = "UPDATE doctors SET name='$name', specialty='$specialty' WHERE id=$id";
//         if ($db->query($sql) === TRUE) {
//             echo "Doctor updated successfully";
//         } else {
//             echo "Error updating doctor: " . $db->error;
//         }
//     }

//     if ($_POST['action'] === "delete") {
//         // Delete doctor
//         $id = $_POST['id'];
//         $sql = "DELETE FROM doctors WHERE id=$id";
//         if ($db->query($sql) === TRUE) {
//             echo "Doctor deleted successfully";
//         } else {
//             echo "Error deleting doctor: " . $db->error;
//         }
//     }
// }

// $db->close();


// Handling POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    if ($_POST['action'] === "add") {
        // Add doctor
        $name = $db->real_escape_string($_POST['name']);
        $specialty = $db->real_escape_string($_POST['specialty']);
        $sql = "INSERT INTO doctors (name, specialty) VALUES ('$name', '$specialty')";
        if ($db->query($sql) === TRUE) {
            echo "Doctor added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }

    if ($_POST['action'] === "update") {
        // Update doctor
        $id = $_POST['id'];
        $name = $db->real_escape_string($_POST['name']);
        $specialty = $db->real_escape_string($_POST['specialty']);
        $sql = "UPDATE doctors SET name='$name', specialty='$specialty' WHERE id=$id";
        if ($db->query($sql) === TRUE) {
            echo "Doctor updated successfully";
        } else {
            echo "Error updating doctor: " . $db->error;
        }
    }

    if ($_POST['action'] === "delete") {
        // Delete doctor
        $id = $_POST['id'];
        $sql = "DELETE FROM doctors WHERE id=$id";
        if ($db->query($sql) === TRUE) {
            echo "Doctor deleted successfully";
        } else {
            echo "Error deleting doctor: " . $db->error;
        }
    }
}

// Handling GET request to fetch doctors for the table
// if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']) && $_GET['action'] === "fetch") {
//     $sql = "SELECT d.id, d.name AS doctor_name, s.specialty AS specialty 
//             FROM doctors d
//             LEFT JOIN specialties s ON d.specialty = s.id";
//     $result = $db->query($sql);

//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             echo "<tr>";
//             echo "<td class='doctorName'>" . $row["doctor_name"] . "</td>";
//             echo "<td class='doctorSpecialty'>" . $row["specialty"] . "</td>";
//             echo "<td>
//                     <button class='editBtn btn_1' data-id='" . $row["id"] . "'>Edit</button>
//                     <button class='deleteBtn btn_1' data-id='" . $row["id"] . "'>Delete</button>
//                   </td>";
//             echo "</tr>";
//         }
//     } else {
//         echo "<tr><td colspan='3'>No doctors found</td></tr>";
//     }
// }

$db->close();
