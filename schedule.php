<?php require_once('include/config.php');

$queryDoctors = "SELECT d.id, d.name AS doctor_name, s.specialty AS specialty FROM doctors d LEFT JOIN specialties s ON d.specialty = s.id";
$doctorsResult = $db->query($queryDoctors) or die($db->error);


$doctorOptions = '';
if ($doctorsResult->num_rows > 0) {
    $doctorOptions .= '<option value="">Select a doctor</option>';
    while ($doctorRow = $doctorsResult->fetch_assoc()) {
        $doctorOptions .= '<option value="' . $doctorRow["id"] . '">' . $doctorRow["doctor_name"] . '</option>';
    }
}


?>
<?php include "include/calendar.php"; ?>
<style>
    :root {
        --bs-success-rgb: 71, 222, 152 !important;
    }

    html,
    body {
        height: 100%;
        width: 100%;
        font-family: Apple Chancery, cursive;
    }

    .btn-info.text-light:hover,
    .btn-info.text-light:focus {
        background: #000;
    }

    table,
    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        border-color: #ededed !important;
        border-style: solid;
        border-width: 1px !important;
    }
</style>
</head>

<body class="bg-light">


    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title">Schedule Form</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="api/schedule_action.php" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <div class="form-group mb-2">
                                    <label for="name" class="control-label">Doctor</label>
                                    <select class="form-select" id="doctor" name="doctor">
                                        <?php echo $doctorOptions; ?>
                                    </select>
                                </div>
                                <div id="specialtyField" style="display: none;">
                                    <div class="form-group mb-2">
                                        <label for="specialty" class="control-label">Specialty</label>
                                        <input class="form-control" id="specialty" name="specialty" readonly>
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="sched_date" class="control-label">Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" name="sched_date" id="sched_date">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="am" class="control-label">A.M</label>
                                    <input type="time" class="form-control form-control-sm rounded-0" name="am" id="am">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="pm" class="control-label">P.M</label>
                                    <input type="time" class="form-control form-control-sm rounded-0" name="pm" id="pm">
                                </div>
                            </form>
                        </div>
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
    <!-- Event Details Modal -->
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
                            <dt class="text-muted">Name</dt>
                            <dd id="name" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Specialty</dt>
                            <dd id="specialty" class="fw-bold fs-4"></dd>
                            <dt class="text-muted">Date</dt>
                            <dd id="sched_date" class=""></dd>
                            <dt class="text-muted">AM</dt>
                            <dd id="am" class=""></dd>
                            <dt class="text-muted">PM</dt>
                            <dd id="pm" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

    <?php
    $schedules = $db->query("SELECT * FROM `schedule_list`");
    $sched_res = [];
    foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
        $row['name'] = ($row['name']);
        $row['specialty'] = ($row['specialty']);
        $row['sched_date'] = ($row['sched_date']);
        $row['am'] = ($row['am']);
        $row['pm'] = ($row['pm']);
        $sched_res[$row['id']] = $row;
    }
    ?>


    <script>
        var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    </script>
    <script>
        $(document).ready(function() {
            $('#doctor').change(function() {
                var doctorId = $(this).val();

                $.ajax({
                    url: 'api/get_specialty.php',
                    type: 'GET',
                    data: {
                        doctor_id: doctorId
                    },
                    success: function(response) {
                        $('#specialty').val(response);
                        $('#specialtyField').show();
                        console.log('Specialty received: ' + response);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                    }
                });
            });
        });
    </script>
    <script src="js/sched_script.js"></script>
</body>

</html>