<?php require_once('config.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fullcalendar/lib/main.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="fullcalendar/lib/main.min.js"></script>

</head>

<body class="bg-light">
    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-lg-12">
                <div id="calendar"></div>
            </div>
            <div class="container-fluid">
                <?php
                // $sql = "SELECT 
                //             i.specialty, DATE(i.start_datetime) AS date,
                //             COUNT(*) AS inquiry_count
                //         FROM 
                //             tblinquiry AS i 
                //         GROUP BY 
                //             i.specialty, 
                //             DATE(i.start_datetime)";

                // $result = $db->query($sql);
                // if ($result === false) {
                //     die("Error executing query: " . $db->error);
                // }
                // $results = $result->fetch_all(MYSQLI_ASSOC);
                // foreach ($results as $row) {
                //     echo '<div>';
                //     echo ' <span>' . $row['date'] . ':</span>
                //                 <span>' . $row['specialty'] . ':</span>
                //               <span>' . $row['inquiry_count'] . '</span>';
                //     echo '</div>';
                // }
                ?>
            </div>
        </div>
    </div>
    <!-- <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <?php
                            //     $sql = "SELECT 
                            //     i.name, i.specialty, DATE(i.start_datetime) AS date,
                            //     COUNT(*) AS inquiry_count
                            // FROM 
                            //     tblinquiry AS i 
                            // GROUP BY 
                            //     i.specialty, 
                            //     DATE(i.start_datetime)";

                            //     $result = $db->query($sql);

                            //     if ($result === false) {
                            //         die("Error executing query: " . $db->error);
                            //     }

                            //     $results = $result->fetch_all(MYSQLI_ASSOC);

                            //     foreach ($results as $row) {
                            //         echo '<dd id="start" class=""></dd>';
                            //         echo '<dd id="specialty" class=""></dd>';
                            //     }
                            ?>
                        </dl>
                    </div>
                </div>

            </div>
        </div>
    </div> -->

    <?php
    $schedules = $db->query("SELECT * FROM `tblinquiry`");
    if ($schedules === false) {
        die("Error executing query: " . $db->error);
    }

    $sched_res = [];
    $specialty_counts = []; // Array to store specialty counts per date

    foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
        $row['sdate'] = date("F d, Y", strtotime($row['start_datetime']));
        $sched_res[$row['id']] = $row;

        // Create a key to group specialties by date
        $key = $row['sdate'] . '_' . $row['specialty'];

        // Increment specialty count for each date
        if (!isset($specialty_counts[$key])) {
            $specialty_counts[$key] = 0;
        }
        $specialty_counts[$key]++;
    }
    ?>

    <script>
        var scheds = <?= json_encode($sched_res) ?>;
        var specialtyCounts = <?= json_encode($specialty_counts) ?>;
        var calendar;
        var Calendar = FullCalendar.Calendar;
        var events = [];

        $(function() {
            if (!!scheds) {
                Object.keys(scheds).forEach(k => {
                    var row = scheds[k];
                    var key = row.sdate + '_' + row.specialty;
                    var inquiry_count = specialtyCounts[key] || 0;
                    events.push({
                        id: row.id,
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
                    // var _details = $('#event-details-modal')
                    var id = info.event.id

                    <?php
                    // $sql = "SELECT 
                    //         i.name, i.specialty, DATE(i.start_datetime) AS date,
                    //         COUNT(*) AS inquiry_count
                    //     FROM 
                    //         tblinquiry AS i 
                    //     GROUP BY 
                    //         i.specialty, 
                    //         DATE(i.start_datetime)";

                    // $result = $db->query($sql);

                    // if ($result === false) {
                    //     die("Error executing query: " . $db->error);
                    // }

                    // $results = $result->fetch_all(MYSQLI_ASSOC);

                    ?>
                    // if (!!scheds[id]) {
                    //     _details.find('#title').text(scheds[id].title)
                    //     _details.find('#specialty').text(scheds[id].specialty)
                    //     _details.find('#name').text(scheds[id].name)
                    //     _details.find('#start').text(scheds[id].sdate)
                    //     _details.modal('show')
                    // } else {
                    //     alert("Event is undefined");
                    // }
                },
                eventDidMount: function(info) {},
            });

            calendar.render();

        })
    </script>

</html>