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

// $sql = "SELECT * FROM specialties";
// $result = mysqli_query($db, $sql);
// $specialties = mysqli_fetch_all($result, MYSQLI_ASSOC);


$sql = "SELECT * FROM specialties";
$result = mysqli_query($db, $sql);
$specialties = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch doctors for the table
$sql = "SELECT * FROM doctors";
$result = mysqli_query($db, $sql);
$doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>





<link rel="stylesheet" href="css/bootstrap1.min.css">
<link rel="stylesheet" href="css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="vendors/style1.css">

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

    .table>:not(:last-child)>:last-child>* {
        border-bottom-color: #00A651 !important;
    }

    a {
        text-decoration: none !important;
    }

    .table>:not(:last-child)>:last-child>* {
        border-bottom-color: #00A651 !important;
    }

    .btn_1 {
        background-color: #0d560d;
        border: 1px solid #0d560d;
    }

    .btn_1:hover {
        color: #fff;
        background-color: green !important;
        box-shadow: 0 3px 11px rgb(79 251 90 / 50%);
    }

    .container {
        margin: 20px;
    }


    a {
        text-decoration: none;
    }

    .table>:not(:last-child)>:last-child>* {
        border-bottom: none !important;
    }

    ul {
        padding: 0px !important;
    }

    .btn_1 i {
        padding-right: 0px !important;

    }

    .btn_1 {
        padding: 9px 15px !important;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #bbc1c9 !important;
        display: block;
        width: 100%;
        padding: .375rem .75rem !important;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        word-wrap: normal;
        text-transform: none;
        margin: 0;

    }

    .center-buttons {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    section.main_content.dashboard_part.large_header_bg {
        background: #F6F7FB !important;
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
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">List of Specialties</h3>
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

                <div class="main_content_iner ">
                    <div class="container-fluid p-0 sm_padding_15px">
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="white_card">
                                    <div class="white_card_header">
                                        <div class="box_header m-0">
                                            <div class="main-title">
                                                <h3 class="m-0">Doctors</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white_card_body">
                                        <div class="white_card_body">
                                            <form id="doctorForm">
                                                <label>Name:</label>
                                                <input type="text" class="form-control" id="name">
                                                <label>Specialty:</label>
                                                <select id="specialty" class="form-control">
                                                    <?php foreach ($specialties as $specialty) : ?>
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
                                                <select id="updateSpecialty" class="form-control mb-3">
                                                    <?php foreach ($specialties as $specialty) : ?>
                                                        <option value="<?php echo $specialty['id']; ?>"><?php echo $specialty['specialty']; ?></option>
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
                                            <table id="doctorTable" class="table table-striped" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Name</th>
                                                        <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Specialty</th>
                                                        <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; ">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($doctors as $row) : ?>
                                                        <tr>
                                                            <td class="doctorName" style='color: black; font-weight: 400'><?= $row['name']; ?></td>
                                                            <td class="doctorSpecialty" style='color: black; font-weight: 400'><?= $row['specialty']; ?></td>

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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {

            new DataTable('#doctorTable');

            // Add Doctor
            $("#doctorForm").submit(function(event) {
                // event.preventDefault();
                // var id = $("#doctorId").val();
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
                        // loadDoctors();
                        location.reload();
                    }
                });
            });

            // Edit Doctor
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

            // Update Doctor
            $("#updateForm").submit(function(event) {
                // event.preventDefault();
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
                        $("#updateForm").hide();
                        $("#doctorForm").show();
                        location.reload();
                        location.reload();
                        // loadDoctors();

                    }
                });
            });

            $("#cancelUpdate").click(function() {
                $("#updateForm").hide();
                $("#doctorForm").show();
            });

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
                        location.reload();
                        // loadDoctors();

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
                        new DataTable('#doctorTable');
                    }
                });
            }
        });
    </script>

    <?php include('include/footer.php'); ?>