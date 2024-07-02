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

<?php include "include/calendar.php"; ?>
<style>
    .fc-event-time {
        display: none;
    }

    div#page-container,
    .main_content {
        background: #F6F7FB !important;
        margin-left: 5px !important;
    }

    .fc-daygrid-dot-event .fc-event-title {
        /* color: black !important; */
    }

    .fc-day-grid-event .fc-content,
    .fc-daygrid-dot-event .fc-event-title {
        white-space: nowrap !important;
        overflow: hidden !important;
        height: 25px !important;
        line-height: 25px !important;
        padding: 0 10px !important;
        color: black !important;
        font-size: 12px !important;
        text-transform: capitalize !important;
        font-weight: 700 !important;
        font-size: 13px !important;
    }

    .fc-theme-bootstrap a:not([href]) {
        color: black !important;
    }

    ul {
        margin: 0px !important;
        padding: 0px !important;
    }
</style>

<body class="crm_body_bg" style="background: #F6F7FB !important;">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>
        <div class="container py-5" id="page-container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="calendar" style="margin-left: 50px; "></div>
                </div>

            </div>


            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            $schedules = $db->query("SELECT i.id, i.start_datetime, DATE(i.start_datetime) AS date, i.specialty as specialty_id, s.specialty, COUNT(*) AS specialty_count 
    FROM tblinquiry AS i 
    LEFT JOIN specialties AS s ON i.specialty = s.id 
    GROUP BY DATE(i.start_datetime), i.specialty");


            if ($schedules === false) {
                die("Error executing query: " . $db->error);
            }

            // $sched_res = [];
            $specialty_counts = [];
            foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
                $row['sdate'] = date("F d, Y", strtotime($row['start_datetime']));
                $sched_res[$row['id']] = $row;
                $key = $row['sdate'] . '_' . $row['specialty'];
                $specialty_counts[$key] = $row['specialty_count'];
            }


            ?>

            <script>
                var scheds = <?= json_encode($sched_res) ?>;
                var specialtyCounts = <?= json_encode($specialty_counts) ?>;
                var calendar;
                var Calendar = FullCalendar.Calendar;
                var events = [];
                var ids = [];


                $(function() {
                    if (!!scheds) {
                        Object.keys(scheds).forEach(k => {
                            var row = scheds[k];
                            var key = row.sdate + '_' + row.specialty;
                            var inquiry_count = specialtyCounts[key] || 0;
                            // console.log(row)
                            events.push({
                                id: row.specialty_id,
                                title: row.specialty + ' (' + inquiry_count + ')',
                                start: row.start_datetime
                            });
                        });
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
                            var startDate = new Date(info.event.start);
                            startDate.setHours(0, 0, 0, 0);
                            var unixTimestamp = Math.floor(startDate.getTime() / 1000);
                            window.location.href = 'date_specialty.php?id=' + info.event.id + '&unixTimestamp=' + unixTimestamp;
                        },
                        eventDidMount: function(info) {},
                    });

                    calendar.render();

                })
            </script>
        </div>
        </div>
        </div>
    </section>
</body>

<?php include "include/footer.php"; ?>