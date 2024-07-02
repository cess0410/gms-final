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
}


$queryDoctors = "SELECT d.id, d.name AS doctor_name, s.specialty AS specialty FROM doctors d LEFT JOIN specialties s ON d.specialty = s.id";
$doctorsResult = $db->query($queryDoctors) or die($db->error);

$doctorOptions = '';
if ($doctorsResult->num_rows > 0) {
    $doctorOptions .= '<option value="" selected>Select a doctor</option>';
    while ($doctorRow = $doctorsResult->fetch_assoc()) {
        $doctorOptions .= '<option value="' . $doctorRow["id"] . '">' . $doctorRow["doctor_name"] . '</option>';
    }
}

$schedules = $db->query("SELECT d.id, d.name AS doctor, s.specialty, sl.sched_date, sl.am, sl.pm 
                        FROM doctors d 
                        LEFT JOIN specialties s ON d.specialty = s.id 
                        LEFT JOIN schedule_list sl ON sl.doctor = d.id");
$sched_res = [];
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
    $row['sched_date'] = ($row['sched_date']);
    $sched_res[$row['id']] = $row;
    $row['doctor'] = ($row['doctor']);
    $row['specialty'] = ($row['specialty']);
    $row['am'] = ($row['am']);
    $row['pm'] = ($row['pm']);
}
?>

<?php include "include/calendar.php"; ?>
<style>
    .container {
        margin: 20px;
    }

    input[type="text"] {
        padding: 10px;
        width: 200px;
    }

    a {
        text-decoration: none;
    }

    .table>:not(:last-child)>:last-child>* {
        border-bottom: none !important;
    }

    ul {
        padding: 0px !important;
    }

    .btn_1 i {
        padding-right: 0px !important;

    }

    .btn_1 {
        padding: 9px 15px !important;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #bbc1c9 !important;
        display: block;
        width: 100%;
        padding: .375rem .75rem !important;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        word-wrap: normal;
        text-transform: none;
        margin: 0;

    }

    .center-buttons {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    section.main_content.dashboard_part.large_header_bg {
        background: #F6F7FB !important;
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
                    <div class="col-lg-7">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_body pt-3 pb-6">
                                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">

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
                                                <div class="col-lg-8 d-flex justify-content-end mb-3">
                                                    <button class="btn_1" onclick="location.reload()">
                                                        <i class="fa fa-sync"></i> Refresh
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="api/schedule_action.php" method="post" id="schedule-form">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <span>Doctor</span>
                                            </div>
                                            <select class="form-select" id="doctor" name="doctor" required>
                                                <?php echo $doctorOptions; ?>
                                            </select>
                                        </div>

                                        <div id="specialtyField" style="display: none;">
                                            <div class="input-group mt-3">
                                                <div class="input-group-text">
                                                    <span>Specialty</span>
                                                </div>
                                                <input class="form-control" id="specialty" name="specialty" readonly>
                                            </div>
                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-text">
                                                <span class=""><img src="vendors/calender_icon.svg" alt=""></span>
                                            </div>
                                            <input type="date" class="form-control form-control-sm rounded-0" name="sched_date" id="sched_date">
                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-text">
                                                <span>Start Time</span>
                                            </div>
                                            <input type="time" class="form-control form-control-sm rounded-0" name="am" id="am" pattern="(?:1[012]|0?[1-9]):[0-5][0-9] (?:AM|PM)">

                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-text">
                                                <span>End Time</span>
                                            </div>
                                            <input type="time" class="form-control form-control-sm rounded-0" name="pm" id="pm" pattern="(?:1[012]|0?[1-9]):[0-5][0-9] (?:AM|PM)">

                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <div class="text-center">
                                        <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                                        <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                                    </div>
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
                                <dt class="text-muted">Specialty</dt>
                                <dd id="specialty"></dd>
                                <dt class="text-muted">Date</dt>
                                <dd id="sched_date" class=""></dd>
                                <dt class="text-muted">Start Time</dt>
                                <dd id="am" class=""></dd>
                                <dt class="text-muted">End Time</dt>
                                <dd id="pm" class=""></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="modal-footer rounded-0">
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="" style="border-radius: 5px!important;">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="" style="border-radius: 5px!important;">Delete</button>
                            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal" style="border-radius: 5px!important;">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $('#doctor').change(function() {
            var doctorId = $(this).val();


            // Fetch doctor schedule via AJAX
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
        });

        // Initial calendar setup with empty events
    </script>


    <script>
        var scheds = <?= json_encode($sched_res) ?>;
        var calendar;
        var Calendar = FullCalendar.Calendar;
        var events = [];
        var ids = [];


        $(function() {
            if (!!scheds) {
                Object.keys(scheds).forEach(k => {
                    var row = scheds[k];
                    var key = row.sched_date + '_' + row.specialty;
                    events.push({
                        id: row.id,
                        title: row.doctor,
                        specialty: row.specialty,
                        start: row.sched_date + 'T' + row.am,
                        end: row.sched_date + 'T' + row.pm.replace('T', ' '),
                    });
                });

                var date = new Date();
                var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();

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
                        // Fetch specialty via AJAX
                        // $.ajax({
                        //     url: 'api/get_specialty.php',
                        //     type: 'GET',
                        //     data: {
                        //         doctor_id: doctorId
                        //     },
                        //     success: function(response) {
                        //         $('#specialty').val(response);
                        //         $('#specialtyField').show();
                        //         console.log('Specialty received: ' + response);
                        //     },
                        //     error: function(xhr, status, error) {
                        //         console.log('Error fetching specialty: ' + error);
                        //     }
                        // });


                    },
                    eventDidMount: function(info) {},
                });

                calendar.render();

            }
        });
    </script>
    <script>
        var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    </script>
    <script>
        // $(document).ready(function() {
        //     $('#doctor').change(function() {
        //         var doctorId = $(this).val();

        //         $.ajax({
        //             url: 'api/get_specialty.php',
        //             type: 'GET',
        //             data: {
        //                 doctor_id: doctorId
        //             },
        //             success: function(response) {
        //                 $('#specialty').val(response);
        //                 $('#specialtyField').show();
        //                 console.log('Specialty received: ' + response);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.log('Error: ' + error);
        //             }
        //         });
        //     });
        // });
    </script>
    <script src="js/sched_script.js"></script>


    <?php include('include/footer.php'); ?>