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
<?php

$sql = "SELECT * FROM specialties";
$result = mysqli_query($db, $sql);
$specialties = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="vendors/style1.css">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
    th.dt-type-numeric.dt-orderable-asc.dt-orderable-desc {
        text-align: left;
    }

    tbody td {
        font-size: 14px !important;
    }

    .btn_1 {
        background-color: #0d560d;
        border: 1px solid #0d560d;
    }

    .page-item.active .page-link {
        /* background-color: #0d560d !important; */
        border-color: 1px solid #0d560d !important;
        color: #fff !important;
    }

    .btn_1:hover {
        color: #fff;
        background-color: green !important;
        box-shadow: 0 3px 11px rgb(79 251 90 / 50%);
    }

    .sidebar #sidebar_menu>li a {
        font-weight: 500 !important;
    }

    .page-link {
        color: none !important;
    }
</style>

<body>
    <section class="main_content dashboard_part large_header_bg">
        <div class="main_content_iner ">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="white_card">
                            <div class="white_card_header">
                            </div>
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Doctors</h3>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="white_card_body">
                                <?php
                                $sql = "SELECT * FROM doctors";
                                $result = mysqli_query($db, $sql);
                                $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                ?>

                                <form id="doctorForm">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" id="name">
                                    <label>Specialty:</label>
                                    <select id="specialty" class="form-control">
                                        <?php foreach ($specialties as $specialty) : ?>
                            </div>
                            <option value="<?php echo $specialty['id']; ?>"><?php echo $specialty['specialty']; ?></option>
                        <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn_1 mt-3">Add Doctor</button>
                        </form>
                        <form id="updateForm" style="display: none;">
                            <input type="hidden" id="doctorId">
                            <label>Name:</label>
                            <input type="text" id="updateName" class="form-control">
                            <label>Specialty:</label>


                            <?php
                            $sql = "SELECT * FROM specialties";
                            $result1 = $db->query($sql);
                            $specialty = $result1->fetch_assoc();
                            ?>
                            <select id="updateSpecialty" class="form-control mb-3">
                                <?php foreach ($specialties as $specialty) : ?>
                                    <option value="<?php echo $specialty['id']; ?>" <?php echo ($specialty['id'] == $specialty['specialty']) ? 'selected' : ''; ?>><?php echo $specialty['specialty']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn_1">Update Doctor</button>
                            <button type="button" id="cancelUpdate" class="btn_1">Cancel</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_body pt-3 pb-6">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <!-- <h4 class="c-grey-900 mB-20 pb-3">Specialties</h4> -->

                            <?php
                            $sql = "SELECT * FROM doctors LEFT JOIN specialties ON doctors.specialty = specialties.id";
                            $result = mysqli_query($db, $sql);
                            $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            ?>
                            <table id="doctorTable" class="table table-striped" role="grid" style="width: 100%;" class="mt-3">
                                <thead>
                                    <tr>
                                        <th style="color: black; font-weight: 600">Name</th>
                                        <th style="color: black; font-weight: 600">Specialty</th>
                                        <th style="color: black; font-weight: 600">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($doctors as $row) : ?>
                                        <tr>
                                            <td style="color: black; font-weight: 400"><?= $row['name']; ?></td>
                                            <td style="color: black; font-weight: 400"><?= $row['specialty']; ?></td>

                                            <td>
                                                <button class='editBtn btn_1' data-id="<?= $row['id']; ?>">Edit</button>
                                                <button class='deleteBtn btn_1' data-id="<?= $row['id']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                            <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
                            <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script> -->
                    <script src=""></script>
                    <script>
                        new DataTable('#doctorTable');
                    </script>
                    <script>
                        $(document).ready(function() {
                            // loadDoctors();

                            // Add Doctor
                            $("#doctorForm").submit(function(event) {
                                event.preventDefault();
                                var name = $("#name").val();
                                var specialty = $("#specialty").val();
                                $.ajax({
                                    url: "api/doctor_action.php",
                                    type: "POST",
                                    data: {
                                        action: "add",
                                        name: name,
                                        specialty: specialty
                                    },
                                    success: function(data) {
                                        $("#name").val('');
                                        $("#specialty").val('');
                                        loadDoctors();
                                    }
                                });
                            });
                            $(document).on("click", ".editBtn", function() {
                                var id = $(this).data("id");
                                var name = $(this).closest("tr").find(".doctorName").text();
                                var specialty = $(this).closest("tr").find(".doctorSpecialty").text();
                                $("#doctorId").val(id);
                                $("#updateName").val(name);
                                $("#updateSpecialty").val(specialty);
                                $("#doctorForm").hide();
                                $("#updateForm").show();
                            });



                            $("#cancelUpdate").click(function() {
                                $("#updateForm").hide();
                                $("#doctorForm").show();
                            });

                            // Update Doctor
                            $("#updateForm").submit(function(event) {
                                event.preventDefault();
                                var id = $("#doctorId").val();
                                var name = $("#updateName").val();
                                var specialty = $("#updateSpecialty").val();
                                $.ajax({
                                    url: "api/doctor_action.php",
                                    type: "POST",
                                    data: {
                                        action: "update",
                                        id: id,
                                        name: name,
                                        specialty: specialty
                                    },
                                    success: function(data) {
                                        loadDoctors();
                                        $("#updateForm").hide();
                                        $("#doctorForm").show();

                                    }
                                });
                            });


                            // Delete Doctor
                            $(document).on("click", ".deleteBtn", function() {
                                var id = $(this).data("id");
                                $.ajax({
                                    url: "api/doctor_action.php",
                                    type: "POST",
                                    data: {
                                        action: "delete",
                                        id: id
                                    },
                                    success: function(data) {
                                        loadDoctors();
                                    }
                                });
                            });

                            function loadDoctors() {
                                $.ajax({
                                    url: "api/doctor_action.php",
                                    type: "GET",
                                    data: {
                                        action: "fetch"
                                    },
                                    success: function(data) {
                                        $("#doctorTable tbody").html(data);
                                    }
                                });
                            }
                        });
                    </script>

                    <?php include('include/footer.php'); ?>