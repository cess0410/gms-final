<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM tblinquiry WHERE id = ?";
        $stmt = $db->prepare($sql);

        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to delete record."));
        }

        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "'id' parameter is missing."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
