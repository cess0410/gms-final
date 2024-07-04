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
                                    $sql = "SELECT i.doctor, i.status, i.cancelled, i.rescheduled, i.diagnose, i.end_datetime, i.rescheduled_id, i.follow_up,ti.start_datetime, ti.name, ti.contact_no, ti.specialty, ti.remarks, 
            FROM inquiry_tbl i
            LEFT JOIN tblinquiry ti ON i.id = ti.id
            WHERE i.id = '$id'";
                                    $result = $db->query($sql);

                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $start_datetime = $row['start_datetime'];
                                        $name = $row['name'];
                                        $contact_no = $row['contact_no'];
                                        $specialty = $row['specialty'];
                                        $remarks = $row['remarks'];
                                        $start_datetime = $row['start_datetime'];
                                        // $doctor = $row['doctor'];
                                        // $status = $row['status'];
                                        // $cancelled = $row['cancelled'];
                                        // $rescheduled = $row['rescheduled'];
                                        // $diagnose = $row['diagnose'];
                                        // $end_datetime = $row['end_datetime'];
                                        // $rescheduled_id = $row['rescheduled_id'];
                                        // $follow_up = $row['follow_up'];

                                        echo '<div class="col-md-4">
                <form id="add">
                    <div class="cardt rounded-0 shadow">
                        <div class="card-header bg-gradient bg-primary text-light">
                            <!-- Header Content -->
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <input type="hidden" name="id" value="' . htmlspecialchars($id) . '">
                                
                                <div class="input-group mb-4 mt-2">
                                    <div class="input-group-text">
                                        <span class="">Consult Date</span>
                                    </div>
                                    <input type="text" class="form-control" name="consultdate" id="consultdate" value="' . date('F d, Y g:i A') . '" readonly>
                                    <input type="hidden" class="form-control" name="consultmonth" id="consultmonth" value="' . date('m') . '">
                                    <input type="hidden" class="form-control" name="consultyear" id="consultyear" value="' . date('Y') . '">
                                </div>
                                
                                <div class="input-group mt-3">
                                    <div class="input-group-text">
                                        <span class="">Schedule</span>
                                    </div>
                                    <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="' . $start_datetime . '" readonly>
                                </div>
                                
                                <div class="input-group mt-3">
                                    <div class="input-group-text">
                                        <span class="">Name</span>
                                    </div>
                                    <input value="' . htmlspecialchars($name) . '" name="name" class="form-control" readonly>
                                </div>
                                
                                <div class="input-group mt-3">
                                    <div class="input-group-text">
                                        <span class="">Contact Number</span>
                                    </div>
                                    <input value="' . htmlspecialchars($contact_no) . '" name="contact_no" class="form-control" readonly>
                                </div>
                                
                                <div class="input-group mt-3">
                                    <label class="input-group-text" for="specialty">Specialty</label>
                                    <select class="form-select" id="specialty" name="specialty" disabled>';

                                        // Fetch specialties from database and populate the dropdown
                                        $sql_specialties = "SELECT * FROM `specialties`";
                                        $result_specialties = $db->query($sql_specialties);
                                        if ($result_specialties && $result_specialties->num_rows > 0) {
                                            while ($specialty_row = $result_specialties->fetch_assoc()) {
                                                $specialty_id = $specialty_row['id'];
                                                $specialty_name = $specialty_row['specialty'];
                                                $selected = ($specialty == $specialty_id) ? "selected" : "";
                                                echo '<option value="' . htmlspecialchars($specialty_id) . '" ' . $selected . '>' . htmlspecialchars($specialty_name) . '</option>';
                                            }
                                        }

                                        echo '              </select>
                                </div>
                                
                                <div class="input-group mt-3">
                                    <div class="input-group-text">
                                        <span class="">Remarks</span>
                                    </div>
                                    <textarea class="form-control" id="remarks" aria-label="With textarea" readonly>' . htmlspecialchars($remarks) . '</textarea>
                                </div>
                                
                                <div class="input-group mt-3">
                                    <div class="input-group-text">
                                        <span class="">Status</span>
                                    </div>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">--Select Status--</option>
                                        <option value="Attended" ' . ($status == 'Attended' ? 'selected' : '') . '>Attended</option>
                                        <option value="Cancelled" ' . ($status == 'Cancelled' ? 'selected' : '') . '>Cancelled</option>
                                        <option value="Rescheduled" ' . ($status == 'Rescheduled' ? 'selected' : '') . '>Rescheduled</option>
                                    </select>
                                </div>';

                                        // Display additional fields based on status
                                        if ($status == 'Rescheduled') {
                                            echo '<div id="rescheduledDateField" class="input-group mt-3">
                    <div class="input-group-text">
                        <span class="">Re-Scheduled</span>
                    </div>
                    <input type="datetime-local" class="form-control" id="rescheduled" name="rescheduled" value="' . $rescheduled . '">
                  </div>';
                                        } elseif ($status == 'Attended') {
                                            echo '<div id="attendedField" class="input-group mt-3">
                    <div class="input-group-text">
                        <span class="">End Date</span>
                    </div>
                    <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" value="' . $end_datetime . '">
                 
                    <input type="hidden" class="form-control" id="rescheduled_id" name="rescheduled_id" value="' . $rescheduled_id . '">
                  </div>';
                                        }

                                        // Close the form and submit buttons
                                        echo '          </div>
                        </div>
                        <div class="card-footer mt-3">
                            <div class="text-center">
                                <input type="hidden" name="id" value="' . htmlspecialchars($id) . '">
                                <button class="btn btn-primary btn-sm rounded-0" type="submit" onclick="window.location.href=\'list_inquiries.php\'"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-default border btn-sm rounded-0" onclick="window.history.back();"><i class="fa fa-reset"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
              </div>';
                                    } else {
                                        echo '<p>No data found for this ID.</p>';
                                    }
                                } ?>

                            </div>
                        </div>
                    </div>
                    <?php include 'view_sched_modal.php'; ?>
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
        window.location.href = `update_inquiry.php?id=${id}`;
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