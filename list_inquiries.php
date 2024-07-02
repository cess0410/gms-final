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
        <h1 class="text-3xl font-bold text-zinc-900 ">List of Inquiries</h1>
        <div class="flex items-center space-x-2">
            <img aria-hidden="true" alt="calendar-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📅" />
            <span class="text-zinc-500 dark:text-zinc-400">02 July 2024</span>
        </div>
    </div>
    <hr />
    <div class="rounded-lg my-5">
        <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
            <div class="card-body">
                <?php
                $sql = "SELECT * FROM tblinquiry";
                $result = mysqli_query($db, $sql);
                $inquiry = mysqli_fetch_all($result, MYSQLI_ASSOC);
                ?>
                <div class="overflow-x-auto rounded-lg">
                    <table id="inquiryTable" class="table rounded-lg">
                        <thead class="bg-[#00A651] text-white ">
                            <tr class="mx-auto">
                                <th>Date</th>
                                <th>Mode</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Specialty</th>
                                <th>Scheduled Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inquiry as $row) : ?>
                                <tr id="row_<?= $row['id']; ?>">
                                    <td style="color: black; font-weight: 400;"><?= $row['consultdate'] ?></td>
                                    <td style="color: black; font-weight: 400"><?= $row['mode'] ?></td>
                                    <td style="color: black; font-weight: 400"><?= $row['name'] ?></td>
                                    <td style="color: black; font-weight: 400"><?= $row['contact_no'] ?></td>

                                    <?php
                                    $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                                    $result1 = $db->query($sql);

                                    if ($result1 && $result1->num_rows > 0) {
                                        $specialty_row = $result1->fetch_assoc();
                                        $specialty_name = $specialty_row['specialty'];
                                        echo "<td style='color: black; font-weight: 400'>$specialty_name</td>";
                                    }
                                    ?>
                                    <td style="color: black; font-weight: 400">
                                        <?php
                                        if (!empty($row['start_datetime'])) {
                                            echo date('F d, Y h:i A', strtotime($row['start_datetime']));
                                        } else {
                                            echo "";
                                        }
                                        ?>
                                    </td>

                                    </td>

                                    <td>
                                        <button class='btn mb-1' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToUpdate(<?= $row['id']; ?>)"><img class="fa w-6 h-6" src="assets/svg/pencil.svg" alt=""></button>
                                        <button class='btn mb-1' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToSchedule(<?= $row['id']; ?>)"><img class="fa w-6 h-6" src="assets/svg/eye.svg" alt=""></button>
                                        <button class='btn mb-1' style="padding: 9px 15px!important;" onclick="deleteRow(<?= $row['id']; ?>)"><img class="fa w-6 h-6" src="assets/svg/trash.svg" alt=""></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <!-- foot -->
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Mode</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Specialty</th>
                                <th>Scheduled Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
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
