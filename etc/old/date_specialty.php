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


$inquiry = [];

if (isset($_GET['id']) && isset($_GET['unixTimestamp'])) {
    $ids = $_GET['id'];
    $unixTimestamp = $_GET['unixTimestamp'];

    $date = date("Y-m-d H:i:s", $unixTimestamp);
    $sql = "SELECT * FROM tblinquiry WHERE specialty = ? AND DATE(start_datetime) = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $ids, $date);
    $stmt->execute();


    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $inquiry = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}


?>

<head>
    <link rel="stylesheet" href="vendors/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">

</head>
<style type="text/css">
    .btn_1 i {
        padding-right: 0px !important;
    }

    .btn_1 {
        padding: 9px 15px !important;
    }

    div#inquiryTable_paginate {
        display: none;
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
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">Lists</h3>
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
                            <div class="white_card_body">
                                <table id="inquiryTable" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Date</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Mode</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Endorsement</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Name</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Contact Number</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Specialty</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Scheduled Date</th>
                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important; ">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($inquiry as $row) : ?>
                                            <tr id="row_<?= $row['id']; ?>">
                                                <td style="color: black; font-weight: 400"><?= $row['consultdate'] ?></td>
                                                <td style="color: black; font-weight: 400"><?= $row['mode'] ?></td>
                                                <td style="color: black; font-weight: 400"><?= $row['endorsement'] ?></td>
                                                <td style="color: black; font-weight: 400"><?= $row['name'] ?></td>
                                                <td style="color: black; font-weight: 400"><?= $row['contact_no'] ?></td>

                                                <?php
                                                $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                                                $result1 = $db->query($sql);

                                                if ($result1 && $result1->num_rows > 0) {
                                                    $specialty_row = $result1->fetch_assoc();
                                                    $specialty_name = $specialty_row['specialty'];
                                                    echo "<td style='color: black; font-weight: 400'>$specialty_name</td>";
                                                } else {
                                                    echo "<td style='color: black; font-weight: 400'>Specialty Not Found</td>";
                                                }
                                                ?>
                                                <td style="color: black; font-weight: 400"><?= date('F d, Y g:i A', strtotime($row['start_datetime'])) ?></td>
                                                <td><button class='btn_1 mb-2' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToUpdate(<?= $row['id']; ?>)"><i class="fas fa-edit"></i></button>
                                                    <button class='btn_1 mb-2' style="padding: 9px 15px!important;" data-id="<?= $row['id']; ?>" onclick="redirectToSchedule(<?= $row['id']; ?>)"><i class="fas fa-eye"></i></button>
                                                    <button class='btn_1 mb-2' style="padding: 9px 15px!important;" onclick="deleteRow(<?= $row['id']; ?>)"><i class="fas fa-trash"></i></button>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        new DataTable('#inquiryTable');


        function redirectToUpdate(id) {
            window.location.href = `update_cal_inquiry.php?id=${id}`;
        }

        function redirectToSchedule(id) {
            window.location.href = `view_cal_sched.php?id=${id}`;
        }

        function deleteRow(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                $.ajax({
                    type: "POST",
                    url: "api/delete_inquiry.php",
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#inquiryTable').DataTable();
        });
    </script>
</body>
<?php include 'include/footer.php'; ?>