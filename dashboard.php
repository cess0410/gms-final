<?php include_once 'templates/template_header.php'; ?>
<div class="w-full m-3  min-h-screen ">
    <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-12 gap-4 m-3">

        <div class="col-span-1 md:col-span-6 lg:col-span-12">
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-12 gap-4">
                <div class="col-span-1 md:col-span-2 card bg-base-100  shadow-xl">
                    <figure class="bg-green-500 text-white font-extrabold">
                        <h2 class="card-title my-5 m-auto">Total Inquiries</h2>
                    </figure>
                    <div class="card-body">

                        <?php
                        $total_count = 0;
                        $sql = "SELECT COUNT(*) as total_count FROM tblinquiry";
                        $result = $db->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_count = $row['total_count'];
                            echo ' <h4 class="text-6xl text-center font-bold">' . $total_count . '</h4>';
                        }
                        ?>
                        <button type="button" class="btn mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>

                </div>
                <div class="col-span-1 md:col-span-2 card bg-base-100  shadow-xl">
                    <figure class="bg-pink-500 text-white font-extrabold">
                        <h2 class="card-title my-5 m-auto">Total Consult</h2>
                    </figure>
                    <div class="card-body">
                        <?php
                        $total_count = 0;
                        $sql = "SELECT COUNT(*) as total_count FROM tblinquiry WHERE status = 'Attended'";
                        $result = $db->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_count = $row['total_count'];
                            echo ' <h4 class="text-6xl text-center font-bold">' . $total_count . '</h4>';
                        }
                        ?>
                        <button type="button" class="btn mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>

                </div>
                <div class="col-span-1 md:col-span-2 card bg-base-100  shadow-xl">
                    <figure class="bg-red-500 text-white font-extrabold">
                        <h2 class="card-title my-5 m-auto">Total Doctors</h2>
                    </figure>
                    <div class="card-body">
                        <?php
                        $total_count2 = 0;
                        $sql2 = "SELECT COUNT(*) as total_count FROM doctors";
                        $result2 = $db->query($sql2);
                        if ($result2 && $result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            $total_count2 = $row2['total_count'];
                            echo ' <h4 class="text-6xl text-center font-bold">' . $total_count2 . '</h4>';
                        }

                        ?>
                        <button type="button" class="btn mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>

                </div>
                <div class="col-span-1 md:col-span-2 card bg-base-100  shadow-xl">
                    <figure class="bg-blue-500 text-white font-extrabold">
                        <h2 class="card-title my-5 m-auto">Total Specialties</h2>
                    </figure>
                    <div class="card-body">
                        <?php
                        $total_count3 = 0;
                        $sql3 = "SELECT COUNT(*) as total_count FROM specialties";
                        $result3 = $db->query($sql3);

                        if ($result3 && $result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();
                            $total_count3 = $row3['total_count'];
                            echo ' <h4 class="text-6xl text-center font-bold">' . $total_count3 . '</h4>';
                        }
                        ?>
                        <button type="button" class="btn mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>

                </div>
                <div class="col-span-1 md:col-span-2 card bg-base-100  shadow-xl">
                    <figure class="bg-orange-500 text-white font-extrabold">
                        <h2 class="card-title my-5 m-auto">Total Rescheduled</h2>
                    </figure>
                    <div class="card-body">
                        <?php
                        $total_count = 0;
                        $rescheduled = 0;
                        $sql = "SELECT COUNT(*) as total_count FROM tblinquiry WHERE status = 'Rescheduled'";
                        $result = $db->query($sql);


                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_count = $row['total_count'];
                            echo ' <h4 class="text-6xl text-center font-bold">' . $total_count . '</h4>';
                        }
                        ?>
                        <button type="button" class="btn mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>

                </div>
                <div class="col-span-1 md:col-span-2 card bg-base-100  shadow-xl">
                    <figure class="bg-orange-100">
                        <h2 class="card-title my-5 m-auto">Total Inquiries</h2>
                    </figure>
                    <div class="card-body">
                        <?php
                        $total_count = 0;
                        $sql = "SELECT DISTINCT name, COUNT(name) AS total_count
                    FROM (
                        SELECT DISTINCT name, id, ROW_NUMBER() OVER (PARTITION BY name ORDER BY id) AS reschedule_number
                        FROM tblinquiry
                        WHERE status = 'Rescheduled'
                    ) AS subquery
                    WHERE reschedule_number <= 3
                    GROUP BY name;";
                        $result = $db->query($sql);

                        if ($result && $result->num_rows > 0) {
                            // Fetch each row and display total_count
                            while ($row = $result->fetch_assoc()) {
                                $total_count = $row['total_count'];
                                $name = $row['name'];
                                echo ' <h4 class="text-xl text-center font-bold">' . $name . ' : ' . $total_count . '</h4>';
                            }
                        } else {
                            // Handle case where no rows are returned
                            echo '<h4>0</h4>'; // or any default value
                        }
                        ?>
                        <button type="button" class="btn mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-span-1 md:col-span-6 lg:col-span-7">
            <div id="calendar" class="m-3"></div>
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
            $specialty_counts = [];
            foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
                $row['sdate'] = date("F d, Y", strtotime($row['start_datetime']));
                $sched_res[$row['id']] = $row;
                $key = $row['sdate'] . '_' . $row['specialty'];
                $specialty_counts[$key] = $row['specialty_count'];
            }
            ?>

            <!-- End Calendar -->
        </div>
        <div class="col-span-1 md:col-span-6 lg:col-span-5">
            <div class="grid grid-cols-1 gap-4">
                <!-- Doctors -->
                <div class="col-span-1 md:col-span-6 lg:col-span-3">
                    <?php
                    $sql = "SELECT * FROM doctors LEFT JOIN specialties ON doctors.specialty = specialties.id";
                    $result = mysqli_query($db, $sql);
                    $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                    <div class="card bg-base-100 w-full shadow-xl">
                        <figure class="bg-green-500 text-white">
                            <h2 class="card-title my-5 m-auto">Doctor's List</h2>
                        </figure>
                        <div class="card-body">
                            <table id="doctorTable" class="w-full ">
                                <thead>
                                    <tr>
                                        <th style="display: none;">Name</th>
                                        <!-- <th style="display: none;">Specialty</th> -->
                                        <th style="display: none;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($doctors as $row) : ?>
                                        <tr class="m-100">

                                            <td><?= $row['name']; ?></td>
                                            <td class="text-right"><a href="#" class="btn bg-blue mb-2"> <img class="fa w-6 h-6" src="assets/svg/eye.svg" alt=""> </a>
                                                <a href="#" class="btn bg-green mb-2"> <img class="fa w-6 h-6" src="assets/svg/pencil.svg" alt=""> </a>
                                                <a href="#" class="btn bg-red mb-2"> <img class="fa w-6 h-6" src="assets/svg/trash.svg" alt=""> </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Doctors End -->
                <!-- Specialties -->
                <div class="col-span-1 md:col-span-6 lg:col-span-3">
                    <?php
                    $sql = "SELECT * FROM specialties";
                    $result = mysqli_query($db, $sql);
                    $specialties = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                    <div class="card bg-base-100 w-full shadow-xl">
                        <figure class="bg-blue-500 text-white">
                            <h2 class="card-title my-5 m-auto">Specialties</h2>
                        </figure>
                        <div class="card-body">
                            <table id="specialtiesTable" class="w-full ">
                                <thead>
                                    <tr>
                                        <th style="display: none;">Specialty</th>
                                        <th style="display: none;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($doctors as $row) : ?>
                                        <tr>
                                            <td>

                                                <span class="f_s_14 f_w_400 text_color_11"> <?= $row['specialty']; ?></span>


                                            </td>
                                            <td class="text-right ">

                                                <a href="#" class="btn bg-green mb-2"> <img class="fa w-6 h-6" src="assets/svg/eye.svg" alt=""></i> </a>
                                                <a href="#" class="btn bg-green mb-2"> <img class="fa w-6 h-6" src="assets/svg/pencil.svg" alt=""></i> </a>
                                                <a href="#" class="btn bg-green mb-2"> <img class="fa w-6 h-6" src="assets/svg/trash.svg" alt=""> </a>

                                            </td>
                                        </tr>
                                        </hr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Specialties End -->

            </div>

        </div>


    </div>
</div>
<script>
    $(document).ready(function() {
        $('#doctorTable').DataTable();
        $('#specialtiesTable').DataTable();
        var scheds = <?php echo isset($sched_res) ? json_encode($sched_res) : json_encode([]); ?>;
        var specialtyCounts = <?php echo isset($specialty_counts) ?  json_encode($specialty_counts) : json_encode([]); ?>;
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
                        allDay: true,
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
    });
</script>
<?php include_once 'templates/template_footer.php'; ?>
