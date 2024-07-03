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