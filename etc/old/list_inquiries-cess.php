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

<style type="text/css">
    .btn_1 i {
        padding-right: 0px !important;
    }

    table.dataTable>thead>tr>th:not(.sorting_disabled) {
        padding-right: 0px !important;
    }

    .btn_1 {
        padding: 9px 15px !important;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: .5em;
        display: inline-block;
        width: auto;
        flex: 1 1 auto;
        padding: .375rem .75rem;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        margin-bottom: 0.5em;
    }

    .sidebar #sidebar_menu>li a {
        font-weight: 500 !important;
        text-decoration: none !important;
        /* padding-left: 0px !important; */
    }

    section.main_content.dashboard_part.large_header_bg {
        background-color: #F6F7FB !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #00A651 !important;
    }

    input[type="search"] {
        margin-bottom: 0.5em !important;
    }

    select {
        border: 1px solid #ced4da !important;
        /* -webkit-appearance: none; */
        -moz-appearance: none !important;
        /* appearance: none; */
        border-radius: .25rem !important;
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
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">List of Inquiries</h3>
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

                <div class="row ">
                    <div class="col-xl-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <div class="main-title">
                                            <h3 class="m-0"></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="white_card_body ">
                                <div class="table-responsive">
                                    <?php
                                    $sql = "SELECT * FROM tblinquiry";
                                    $result = mysqli_query($db, $sql);
                                    $inquiry = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                    ?>

                                    <table id="inquiryTable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Date</th>
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Mode</th>
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Name</th>
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Contact Number</th>
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Specialty</th>
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Scheduled Date</th>
                                                <!-- <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Status</th> -->
                                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important;  ">Action</th>
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
                                                        <button class='btn_1 mb-1' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToUpdate(<?= $row['id']; ?>)"><i class="fas fa-edit"></i></button>
                                                        <button class='btn_1 mb-1' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToSchedule(<?= $row['id']; ?>)"><i class="fas fa-eye"></i></button>
                                                        <button class='btn_1 mb-1' style="padding: 9px 15px!important;" onclick="deleteRow(<?= $row['id']; ?>)"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

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
    <?php include 'include/footer.php'; ?>