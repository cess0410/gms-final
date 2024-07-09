<?php include_once 'templates/template_header.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
?>

<section class=" container m-3">
    <div class="flex justify-between items-center p-4">
        <h1 class="text-3xl font-bold text-zinc-900 ">List of Receivers</h1>
        <div class="flex items-center space-x-2">
            <img aria-hidden="true" alt="calendar-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📅" />
            <span class="text-zinc-500 dark:text-zinc-400"><?php echo date('d F Y'); ?></span>
        </div>
    </div>
    <hr />
    <div class="rounded-lg my-5">
        <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="grid grid-cols-1 gap-4  w-full text-center">
                        <div class="w-full">
                            <input type="text" id="receiverFilter" placeholder="Enter receiver name" class="input input-bordered w-full " />
                        </div>
                        <div class="w-full">
                            <select class="select select-bordered w-full " id="consultmonthFilter">
                                <option value="" selected>Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>

                    </div>
                    <div class="grid grid-cols-1 gap-4  w-full text-center">
                        <div class="w-full">
                            <input type="number" id="yearFilter" placeholder="Enter year (yyyy)" class="input input-bordered w-full " />
                        </div>
                        <div class="w-full">
                            <select class="select select-bordered w-full" id="specialtyFilter">
                                <option value="" selected>Select Specialty</option>
                                <?php
                                $sql2 = "SELECT * FROM `specialties`";
                                $result2 = $db->query($sql2);

                                if ($result2 && $result2->num_rows > 0) {
                                    while ($specialty_row = $result2->fetch_assoc()) {
                                        $specialty_id = $specialty_row['id'];
                                        $specialty_name = $specialty_row['specialty'];
                                        echo "<option value='$specialty_name'>" . htmlspecialchars($specialty_name) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="col-span-2 w-full text-center">
                        <div class="overflow-x-auto rounded-lg">
                            <table id="inquiryTable" class="table rounded-lg">
                                <thead class="bg-[#00A651] text-white ">
                                    <tr class="mx-auto">
                                        <th>Receiver</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Specialty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tblinquiry";
                                    $result = mysqli_query($db, $sql);
                                    $inquiry = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                    ?>
                                    <?php foreach ($inquiry as $row) : ?>
                                        <tr id="row_<?= $row['id']; ?>">
                                            <?php
                                            $sql_receiever = "SELECT users.fname AS name FROM tblinquiry LEFT JOIN users ON tblinquiry.receiver = users.userid WHERE tblinquiry.id = " . $row['id'];
                                            $result_receiver = $db->query($sql_receiever);

                                            if ($result_receiver === false) {
                                                die("Error querying database.");
                                            }
                                            while ($row_receiver = $result_receiver->fetch_assoc()) {
                                                $receiver = $row_receiver['name'];
                                            }
                                            ?>
                                            <td style="color: black; font-weight: 400"><?= $receiver ?></td>

                                            <td style="color: black; font-weight: 400;">
                                                <?= $row['consultmonth'] ?>
                                                <?php if ($row['consultmonth'] == '01') {
                                                    echo 'January';
                                                } elseif ($row['consultmonth'] == '02') {
                                                    echo 'February';
                                                } elseif ($row['consultmonth'] == '03') {
                                                    echo 'March';
                                                } elseif ($row['consultmonth'] == '04') {
                                                    echo 'April';
                                                } elseif ($row['consultmonth'] == '05') {
                                                    echo 'May';
                                                } elseif ($row['consultmonth'] == '06') {
                                                    echo 'June';
                                                } elseif ($row['consultmonth'] == '07') {
                                                    echo 'July';
                                                } elseif ($row['consultmonth'] == '08') {
                                                    echo 'August';
                                                } elseif ($row['consultmonth'] == '09') {
                                                    echo 'September';
                                                } elseif ($row['consultmonth'] == '10') {
                                                    echo 'October';
                                                } elseif ($row['consultmonth'] == '11') {
                                                    echo 'November';
                                                } elseif ($row['consultmonth'] == '12') {
                                                    echo 'December';
                                                }
                                                ?>


                                            <td style="color: black; font-weight: 400"><?= $row['consultyear'] ?></td>
                                            <?php
                                            $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                                            $result1 = $db->query($sql);

                                            if ($result1 && $result1->num_rows > 0) {
                                                $specialty_row = $result1->fetch_assoc();
                                                $specialty_name = $specialty_row['specialty'];
                                                echo "<td style='color: black; font-weight: 400'>$specialty_name</td>";
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <!-- foot -->
                                <tfoot>
                                    <tr>
                                        <th>Receiver</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Specialty</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

<script>
    $(document).ready(function() {
        let table = $('#inquiryTable').DataTable({
            // "language": {
            //     "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            // }


        });

        table.on('draw', function() {
            let totalEntries = table.page.info().recordsTotal;
            $('.counts').text(totalEntries);
        });

        $('#receiverFilter').on('keyup', function() {
            table.columns(0).search(this.value).draw();
        });

        $('#yearFilter').on('keyup', function() {
            let selectedYear = this.value;
            table.columns(2).search(selectedYear).draw();
        });

        $('#consultmonthFilter').on('change', function() {
            let selectedMonth = this.value;
            table.columns(1).search(selectedMonth).draw();
        });

        $('#specialtyFilter').on('change', function() {
            let selectedSpecialty = this.value;
            table.columns(3).search(selectedSpecialty).draw();
        });

        $('#generate').on('click', function() {
            generateReport();
        });

    });

    function redirectToUpdate(id) {
        window.location.href = `update_inquiry.php?id=${id}`;
    }

    function redirectToSchedule(id) {
        window.location.href = `view_sched.php?id=${id}`;
    }

    function deleteRow(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                type: "POST",
                url: "api/inquiry_delete.php",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#row_" + id).remove();
                        location.reload();
                    } else {
                        alert("Failed to delete record: " + response.message);
                    }
                },

                error: function(xhr, status, error) {
                    alert("Error occurred while processing your request.");
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>
<?php include_once 'templates/template_footer.php'; ?>