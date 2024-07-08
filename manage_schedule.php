<?php
session_start();
ob_start();
include "include/config.php";
include "include/header.php";
include "include/sidebar.php";
include "include/calendar.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}

$queryDoctors = "SELECT d.id, d.name AS doctor_name, s.specialty AS specialty FROM doctors d LEFT JOIN specialties s ON d.specialty = s.id";
$doctorsResult = $db->query($queryDoctors);
$doctorOptions = '';
if ($doctorsResult->num_rows > 0) {
    $doctorOptions .= '<option value="" selected>Select a doctor</option>';

    $selectedDoctorId = isset($_GET['doctor']) ? $_GET['doctor'] : '';
    while ($doctorRow = $doctorsResult->fetch_assoc()) {
        $selected = ($doctorRow["id"] == $selectedDoctorId) ? 'selected' : '';
        $doctorOptions .= '<option value="' . $doctorRow["id"] . '" ' . $selected . '>' . $doctorRow["doctor_name"] . '</option>';
    }
}
?>
<link rel="stylesheet" href="css/schedule.css">
<style>
    .fc-event-title {
        text-wrap: wrap !important;
    }
</style>

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>
        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="row">
                    <div class="col-12">
                        <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                            <div class="page_title_left d-flex align-items-center">
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">Manage Schedule</h3>
                            </div>
                            <div class="page_title_right">
                                <div class="page_date_button d-flex align-items-center">
                                    <img src="vendors/calender_icon.svg" alt="">
                                    <?php echo date('d F Y'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_body pt-3 pb-6">
                                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card">
                            <div class="white_card_body">
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="main-title">
                                                <h3 class="m-0"></h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-8 d-flex justify-content-end">
                                                    <button class="btn_1" onclick="location.reload()"><i class="fa fa-sync"></i> Refresh</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="save_schedule.php" method="post" id="schedule-form">
                                        <input type="hidden" name="id" value="">
                                        <div class="form-group mb-2">
                                            <label for="title" class="control-label">Doctor</label>
                                            <select class="form-select" id="doctor" name="doctor">
                                                <?php echo $doctorOptions; ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="description" class="control-label">Specialty</label>
                                            <input class="form-control" name="specialty" id="specialty" readonly>

                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="start_datetime" class="control-label">Start</label>
                                            <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="end_datetime" class="control-label">End</label>
                                            <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <div class="text-center">
                                        <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                        <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form" onclick="location.reload()"><i class="fa fa-reset"></i> Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title">Schedule Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body rounded-0">
                        <div class="container-fluid">
                            <dl>
                                <dt class="text-muted">Doctor</dt>
                                <dd id="doctor" class="fw-bold fs-4"></dd>
                                <dt class="text-muted">Specialty</dt>
                                <dd id="specialty" class=""></dd>
                                <dt class="text-muted">Start</dt>
                                <dd id="start" class=""></dd>
                                <dt class="text-muted">End</dt>
                                <dd id="end" class=""></dd>
                            </dl>
                        </div>
                    </div>

                    <div class="modal-footer rounded-0">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit"><i class="fa fa-edit"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    $schedules = $db->query("SELECT sl.id AS id, d.id AS doctor_id, d.name AS doctor, s.specialty AS specialty, sl.start_datetime AS start_datetime, sl.end_datetime AS end_datetime
                        FROM doctors d LEFT JOIN specialties s ON d.specialty = s.id LEFT JOIN schedule_list sl ON sl.doctor = d.id WHERE start_datetime IS NOT NULL AND end_datetime IS NOT NULL");


    $sched_res = [];
    foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
        $row['id'] = $row['id'];
        $row['doctor'] = $row['doctor'];
        $row['specialty'] = $row['specialty'];
        $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
        $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
        $sched_res[$row['id']] = $row;
    }
    ?>

    <script>
        var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')

        var calendar;
        var Calendar = FullCalendar.Calendar;
        var events = [];
        $(function() {
            if (!!scheds) {
                Object.keys(scheds).map(k => {
                    var row = scheds[k]
                    events.push({
                        id: row.id,
                        title: row.doctor,
                        specialty: row.specialty,
                        start: row.start_datetime,
                        end: row.end_datetime
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
                        _details.find('#doctor').text(scheds[id].doctor)
                        _details.find('#specialty').text(scheds[id].specialty)
                        _details.find('#start').text(scheds[id].sdate)
                        _details.find('#end').text(scheds[id].edate)
                        _details.find('#edit,#delete').attr('data-id', id)
                        _details.modal('show')
                    } else {
                        alert("Event is undefined");
                    }
                },
                eventDidMount: function(info) {},
                editable: true
            });

            calendar.render();

            $('#schedule-form').on('reset', function() {
                $(this).find('input:hidden').val('')
                $(this).find('input:visible').first().focus()
            })

            $('#edit').click(function() {
                var id = $(this).attr('data-id');
                if (!!scheds[id]) {
                    var _form = $('#schedule-form');

                    _form.find('[name="id"]').val(id);
                    _form.find('[name="doctor"]').val(scheds[id].doctor_id);
                    _form.find('[name="specialty"]').val(scheds[id].specialty);
                    _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"));
                    _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"));


                    _form.find('[name="doctor"] option[value="' + scheds[id].doctor_id + '"]').prop('selected', true);

                    $('#event-details-modal').modal('hide');
                    _form.find('[name="title"]').focus();
                } else {
                    alert("Event is undefined");
                }
            });


            $('#delete').click(function() {
                var id = $(this).attr('data-id')
                if (!!scheds[id]) {
                    var _conf = confirm("Are you sure to delete this scheduled event?");
                    if (_conf === true) {
                        location.href = "api/delete_schedule.php?id=" + id;
                    }
                } else {
                    alert("Event is undefined");
                }
            })

            var initialDoctorId = $('#doctor').val();
            fetchDoctorSchedule(initialDoctorId);
            fetchSpecialty(initialDoctorId);

            $('#doctor').change(function() {
                var selectedDoctorId = $(this).val();
                fetchDoctorSchedule(selectedDoctorId);
                fetchSpecialty(selectedDoctorId);
            });

            function fetchDoctorSchedule(doctorId) {
                $.ajax({
                    url: 'api/get_doctor_schedule.php',
                    type: 'GET',
                    data: {
                        doctor_id: doctorId
                    },
                    success: function(response) {
                        events = response;
                        calendar.removeAllEvents();
                        calendar.addEventSource(events);
                        calendar.refetchEvents();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error fetching doctor schedule: ' + error);
                    }
                });
            }

            function fetchSpecialty(doctorId) {
                $.ajax({
                    url: 'api/get_specialty.php',
                    type: 'GET',
                    data: {
                        doctor_id: doctorId
                    },
                    success: function(response) {
                        $('#specialty').text(response);
                        $('#specialty').val(response);
                        $('#specialtyField').show();
                        console.log('Specialty received: ' + response);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error fetching specialty: ' + error);
                    }
                });
            }

        })
    </script>

    <?php include('include/footer.php'); ?>