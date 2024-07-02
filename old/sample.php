<?php
session_start();
ob_start();
include "include/config.php";
include "include/header.php";
include "include/sidebar.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tblinquiry WHERE id = '$id'";
    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $consultdate = $row['consultdate'];
        $consultmonth = $row['consultmonth'];
        $consultyear = $row['consultyear'];
        $receiver = $row['receiver'];
        $mode = $row['mode'];
        $name = $row['name'];
        $type = $row['type'];
        $contact_no = $row['contact_no'];
        $specialty = $row['specialty'];
        $remarks = $row['remarks'];
        $start_datetime = $row['start_datetime'];
        $doctor = $row['doctor'];
        $status = $row['status'];
        $diagnose = $row['diagnose'];
        $rescheduled = $row['rescheduled'];
        $end_datetime = $row['end_datetime'];
    }
}
echo '<input type="text" class="form-control" name="consultdate" id="consultdate" placeholder="Date and Time" value="' . date('F d, Y g:i A') . '" readonly>';

echo  '<input type="hidden" class="form-control" name="consultmonth" id="consultmonth" value="' . date('m') . '">
<input type="hidden" class="form-control" name="consultyear" id="consultyear" value="' . date('Y') . '">';
echo "<select class='form-select' id='specialty' name='specialty' disabled>";
$sql = "SELECT * FROM `specialties`";
$result1 = $db->query($sql);

if ($result1 && $result1->num_rows > 0) {
    while ($specialty_row = $result1->fetch_assoc()) {
        $specialty_id = $specialty_row['id'];
        $specialty_name = $specialty_row['specialty'];
        $selected = ($row['specialty'] == $specialty_id) ? "selected" : "";
        echo "<option value='$specialty_id' $selected>" . htmlspecialchars($specialty_name) . "</option>";
    }
}
echo '</select>';

$doctorOptionsString = '';
$specialty = $row['specialty'];
$queryDoctors = "SELECT * FROM doctors WHERE specialty = '$specialty';";
$doctorsResult = $db->query($queryDoctors) or die($db->error);

if ($doctorsResult->num_rows > 0) {
    while ($doctorRow = $doctorsResult->fetch_assoc()) {
        $doctorOptionsString .= '<option value="' . $doctorRow["id"] . '">' . $doctorRow["name"] . '</option>';
    }
} else {
    $doctorOptionsString .= '<option value="">No doctors found for this specialty</option>';
}
echo '
<select class="form-select" id="specialty">';
echo $doctorOptionsString;
echo '</select>';
echo '
<span class="">Status</span>
 <select class="form-select" id="consult" name="status">
            <option value="Attended" selected>Attended</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Rescheduled">Rescheduled</option>
        </select>

<div id="rescheduledDateField" style="display: none;">
 <input type="datetime-local" class="form-control" id="rescheduled" name="rescheduled">
        </div>
        <textarea id="diagnose" class="form-control" name="diagnose">' . $diagnose . '</textarea>
         <span class="">End Date</span>';
if (!empty($row['start_datetime'])) {
    echo '<input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" onclick="checkScheduleDate()" value="' . $end_datetime . '">';
}
echo '</form>';
echo '<input type="hidden" name="id" value="' . (isset($_GET['id']) ? $_GET['id'] : '') . '">';

echo '<button class="btn btn-primary btn-sm rounded-0" type="submit" value="add"><i class="fa fa-save"></i> Save</button>';

?>
<script>
    document.getElementById("consult").addEventListener("change", function() {
        var rescheduledDateField = document.getElementById("rescheduledDateField");
        if (this.value === "Rescheduled") {
            rescheduledDateField.style.display = "block";
        } else {
            rescheduledDateField.style.display = "none";
        }
    });
</script>