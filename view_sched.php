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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fullcalendar/lib/main.min.js"></script>

</head>
<style>
    .card-header:first-child {
        padding: 18px !important;
    }

    .fc-daygrid-dot-event .fc-event-title {
        text-wrap: wrap !important;
    }

    .text-muted {
        font-weight: 900;
    }

    dd {
        margin-bottom: .5rem;
        margin-left: 0;
        font-weight: 700 !important;
        color: black !important;
    }

    .btn_1 i {
        font-size: 15px;
        padding-right: 0px !important;
    }

    div#calendar {
        background: #F6F7FB !important;
        color: black !important;
    }
</style>

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>
        <div class="container-fluid p-0 ">
            <div class="row ">
                <div class="col-md-12">
                    <div class="white_card_body ">
                        <div class="container py-2" id="page-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="calendar" style="background: #F6F7FB!important;"></div>
                                </div>
                                <?php
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    $sql = "SELECT * FROM tblinquiry WHERE id = '$id'";
                                    $result = $db->query($sql);
                                    echo '       <div class="col-md-4"><form id="add">
      
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                    </div>
                <div class="card-body">
                    <div class="container-fluid">
                        
                            <input type="hidden" name="id" value="">';
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
                                        $rescheduled_id = $row['rescheduled_id'];

                                        echo "<div class='input-group mb-4 mt-2'>
        <div class='input-group-text'>
        <span class=''>Consult Date</span></div>";
                                        echo '<input type="text" class="form-control" name="consultdate" id="consultdate" placeholder="Date and Time" value="' . date('F d, Y g:i A') . '" readonly>';

                                        echo  '<input type="hidden" class="form-control" name="consultmonth" id="consultmonth" value="' . date('m') . '">
                    <input type="hidden" class="form-control" name="consultyear" id="consultyear" value="' . date('Y') . '">';

                                        echo "<div class='input-group mt-3'>
                <div class='input-group-text'>
                    <span class=''>Schedule</span>
                </div>
                <input type='datetime-local' class='form-control' name='start_datetime' id='start_datetime' value='" . $start_datetime . "' readonly>
            </div>";

                                        echo '<div class="mb-3">
            <input value="' . $consultmonth . '" name="consultmonth" class="form-control" hidden>
        </div>';
                                        echo '<div class="mb-3">
        <input value="' . $consultyear . '" name="consultyear" class="form-control" hidden>
    </div>';

                                        echo "<div class='input-group mt-3'>
        <div class='input-group-text'>
        <span class=''>Name</span></div>";
                                        echo "<input value='$name' name='name' class='form-control' readonly>";

                                        echo "<div class='input-group mt-3'>
        <div class='input-group-text'>
        <span class=''>Contact Number</span></div>";
                                        echo "<input value='$contact_no' name='contact_no' class='form-control' readonly>";

                                        echo "<div class='input-group mt-3'>";
                                        echo "<label class='input-group-text' for='specialty'>Specialty</label>";
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
                                        echo "</div>";
                                        echo '<div class="input-group mt-3">
                <div class="input-group-text">
                    <span class="">Remarks</span>
                </div>
                <textarea class="form-control" id="remarks" aria-label="With textarea" disabled>' . $remarks . '</textarea>
            </div>';

                                        echo ' </div>';



                                        echo '<div class="input-group mt-3">
    <div class="input-group-text">
    <span class="">Status</span>
</div>
        <select class="form-select" id="consult" name="status">
            <option value="">--Select Status--</option>
            <option value="Attended">Attended</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Rescheduled">Rescheduled</option>
        </select>
    </div>    </div>
    
    <div id="rescheduledDateField" style="display: none;">
       <div class="input-group mt-3">
    <div class="input-group-text">
                <span class="">Re-Scheduled</span>
            </div>
            <input type="datetime-local" class="form-control" id="rescheduled" name="rescheduled">
        </div>
    </div>';

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
                                        echo '<div id="doctorField" style="display: none;"><div class="input-group mt-3">
<div class="input-group-text">
<span class="">Doctor</span>
</div>
<select class="form-select" id="specialty" name="doctor">';
                                        echo $doctorOptionsString;
                                        echo '</select>

</div></div>';



                                        echo ' <div id="diagnoseField" style="display: none;">
                    <div class="input-group mt-3">
    <div class="input-group-text">
    <span class="">Diagnose</span>
</div><textarea id="diagnose" class="form-control" name="diagnose">' . $diagnose . '</textarea>
</div></div>';
                                        echo '
                    <div id="attendedField" style="display: none;">
                        <div class="input-group mt-3">
                            <div class="input-group-text">
                                <span class="">End Date</span>
                            </div>
                            <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" onclick="checkScheduleDate()" value="' . $end_datetime . '" >';
                                        $end_month = date('m', strtotime($end_datetime));
                                        $end_year = date('Y', strtotime($end_datetime));
                                        echo '<input type="hidden" class="form-control" id="end_month" name="end_month" value="' . $end_month . '">';
                                        echo '<input type="hidden" class="form-control" id="end_year" name="end_year" value="' . $end_year . '">';
                                        $rescheduled_id = $row['id'];
                                        echo '<input type="hidden" class="form-control" id="rescheduled_id" name="rescheduled_id" value="' . $rescheduled_id . '">';
                                    }
                                    echo '</div>
                    </div>  
</div>
</div>
</form>  ';
                                    echo '<div class="card-footer mt-3">
            <div class="text-center">
                
                
                    <input type="hidden" name="id" value="' . (isset($_GET['id']) ? $_GET['id'] : '') . '">';

                                    echo '<button class="btn btn-primary btn-sm rounded-0" type="submit" onclick="window.location.href=\'list_inquiries.php\'"><i class="fa fa-save"></i> Save</button>';

                                    echo '<a class="btn btn-default border btn-sm rounded-0" onclick="window.history.back();"><i class="fa fa-reset"></i> Cancel</a>';
                                    echo '
            </div>
        </div>';
                                }

                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-0">
                                <div class="modal-header rounded-0">
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];
                                        $sql = "SELECT * FROM tblinquiry WHERE id = '$id'";
                                        $result = $db->query($sql);
                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $consultdate = $row['consultdate'];
                                            $receiver = $row['receiver'];
                                            $mode = $row['mode'];
                                            $endorsement = $row['endorsement'];
                                            $name = $row['name'];
                                            $type = $row['type'];
                                            $birthdate = $row['birthdate'];
                                            $age = $row['age'];
                                            $gender = $row['gender'];
                                            $contact_no = $row['contact_no'];
                                            $specialty_id = $row['specialty'];
                                            $remarks = $row['remarks'];
                                            $start_datetime = $row['start_datetime'];
                                            echo "<h5 class='modal-title'>Details of &nbsp;<h5 class='modal-title' style='font-weight: 900'>$name</h5></h5>";
                                            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>';

                                            $sql_specialty = "SELECT specialty FROM specialties WHERE id = '$specialty_id'";
                                            $result_specialty = $db->query($sql_specialty);
                                            $specialty_name = "";
                                            if ($result_specialty && $result_specialty->num_rows > 0) {
                                                $row_specialty = $result_specialty->fetch_assoc();
                                                $specialty_name = $row_specialty['specialty'];
                                            }
                                            $gender_label = '';
                                            if ($gender === 'Male') {
                                                $gender_label = 'Male';
                                            } elseif ($gender === 'Female') {
                                                $gender_label = 'Female';
                                            } else {
                                                $gender_label = 'Others';
                                            }

                                            echo '
                                    <div class="row">
    <div class="col-md-6">
        <dl class="dl-horizontal">
            <dt class="text-muted">Consultation Date</dt>
            <dd>' . $consultdate . '</dd>
        </dl>
        <dt class="text-muted">Mode of Consultation</dt>
                                    <dd>' . $mode . '</dd>
                                    <dt class="text-muted">Receiver</dt>
                                    <dd>' . $receiver . '</dd>
                                   
                                    <dt class="text-muted">Birthdate</dt>
                                    <dd>' . $birthdate . '</dd>
                                    <dt class="text-muted">Contact No.</dt>
                                    <dd>' . $contact_no . '</dd>
                                    <dt class="text-muted">Specialty</dt>
                                    <dd>' . $specialty_name . '</dd>
    </div>
    <div class="col-md-6">
        <dl class="dl-horizontal">
            <dt class="text-muted">Scheduled Date</dt>
            <dd id="start"></dd>
        </dl>
        <dt class="text-muted">Type of Client</dt>
        <dd>' . $type . '</dd>
        <dt class="text-muted">Special Endorsement</dt>
                                    <dd>' . $endorsement . '</dd>
                                    <dt class="text-muted">Gender</dt>
                                    <dd>' . $gender_label . '</dd>
                                    <dt class="text-muted">Age</dt>
                                    <dd>' . $age . '</dd>
                                     <dt class="text-muted">Remarks</dt>
                                    <dd>' . $remarks . '</dd>
    </div>
</div>
                                ';
                                        }
                                    }
                                    ?>
                                    </dl>
                                </div>
                            </div>
                            <div class="modal-footer rounded-0">
                                <div class="text-end">
                                    <button class='btn_1 mb-2' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToUpdate(<?= $row['id']; ?>)"><i class="fas fa-edit"></i></button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $schedules = $db->query("SELECT id, name, specialty, start_datetime FROM `tblinquiry` WHERE id = $id");

                if ($schedules === false) {
                    die("Error executing query: " . $db->error);
                }
                $sched_res = [];

                foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
                    $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));

                    $sched_res[$row['id']] = $row;
                }
                ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $end_month = date('m', strtotime($end_datetime));
    $end_year = date('Y', strtotime($end_datetime));

    function checkScheduleDate() {
        var startDate = '<?= $row['start_datetime'] ?>';

        if (startDate.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'No Scheduled Date Available!',
                text: 'Please check the scheduled date before inputting the End Date.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }
    }
</script>

<script>
    document.getElementById("consult").addEventListener("change", function() {
        var rescheduledDateField = document.getElementById("rescheduledDateField");
        if (this.value === "Rescheduled") {
            rescheduledDateField.style.display = "block";
        } else {
            rescheduledDateField.style.display = "none";
        }
    });
    document.getElementById("consult").addEventListener("change", function() {
        var rescheduledDateField = document.getElementById("attendedField");
        var diagnoseField = document.getElementById("diagnoseField");
        var doctorField = document.getElementById("doctorField");
        if (this.value === "Attended") {
            rescheduledDateField.style.display = "block";
            diagnoseField.style.display = "block";
            doctorField.style.display = "block";
        } else {
            rescheduledDateField.style.display = "none";
            diagnoseField.style.display = "none";
            doctorField.style.display = "none";
        }
    });



    $("#add").submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var additionalData = {
            'id': '<?= $id ?>',
            'action': 'add'
        };
        formData += '&' + $.param(additionalData);

        $.ajax({
            url: "api/save_sched.php",
            type: "POST",
            data: formData,
            success: function(response) {
                window.location.href = 'list_inquiries.php';
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the inquiry. Please try again later.'
                });
            }
        });
    });
</script>
<script>
    function redirectToUpdate(id) {
        window.location.href = `update_cal_inquiry.php?id=${id}`;
    }

    function calculateAge() {
        var dob = document.getElementById("birthdate").value;
        var dobDate = new Date(dob);
        var today = new Date();
        sadasd
        var age = today.getFullYear() - dobDate.getFullYear();
        var m = today.getMonth() - dobDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }
        document.getElementById("age").value = age;
    }
</script>

<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                console.log(scheds[k])
                events.push({
                    id: row.id,
                    title: row.name,
                    consult: row.consultdate,
                    specialty: row.specialty,
                    start: row.start_datetime
                });
            })
        }
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var id = info.event.id
                if (!!scheds[id]) {
                    _details.find('#title').text(scheds[id].title)
                    _details.find('#consult').text(scheds[id].consultdate);
                    _details.find('#name').text(scheds[id].name)
                    _details.find('#specialty').text(scheds[id].specialty)
                    _details.find('#start').text(scheds[id].sdate)
                    // _details.find('#end').text(scheds[id].edate)
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.modal('show')
                }
            },
            eventDidMount: function(info) {},
            // editable: true
        });

        calendar.render();

    })
</script>
<?php include "include/footer.php"; ?>