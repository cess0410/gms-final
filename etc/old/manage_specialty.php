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
        background-color: #0d560d !important;
        border-color: #0d560d !important;
    }

    .btn_1:hover {
        color: #fff;
        background-color: green !important;
        box-shadow: 0 3px 11px rgb(79 251 90 / 50%);
    }

    .sidebar #sidebar_menu>li a {
        font-weight: 500 !important;
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
                            <div class="col-lg-3">
                                <div class="white_card">
                                    <div class="white_card_header">
                                        <div class="box_header m-0">
                                            <div class="main-title">
                                                <h3 class="m-0">Specialties</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="white_card_body">
                                        <form id="specialtyForm">
                                            <label>Specialty:</label>
                                            <input type="text" class="form-control" id="specialty">

                                            <button type="submit" class="btn_1 mt-3">Add Specialty</button>
                                        </form>
                                        <form id="updateForm" style="display: none;">
                                            <input type="hidden" id="specialtyId">
                                            <label>Specialty:</label>
                                            <input type="text" id="updateSpecialty" class="form-control mb-3">
                                            <button type="submit" class="btn_1">Update Specialty</button>
                                            <button type="button" id="cancelUpdate" class="btn_1">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="white_card card_height_100 mb_30">
                                    <div class="white_card_body pt-3 pb-6">
                                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                            <!-- <h4 class="c-grey-900 mB-20 pb-3">Specialties</h4> -->
                                            <div id="dataTable_wrapper" class="dataTables_wrapper">
                                                <div id="dataTable_filter" class="dataTables_filter">
                                                    <!-- <label class="mb-5">Search:<input type="search" class="" placeholder="" aria-controls="dataTable"></label> -->
                                                </div>
                                                <table class="table table-striped" id="specialtyTable" role="grid" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="">Specialty</th>
                                                            <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($specialties as $row) : ?>
                                                            <tr>
                                                                <td style="color: black; font-weight: 400"><?= $row['specialty']; ?></td>
                                                                <!-- <td style="color: black; font-weight: 400"><?= $row['id']; ?></td> -->
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
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                                    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
                                    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
                                    <script src=""></script>
                                    <script>
                                        new DataTable('#specialtyTable');
                                    </script>
                                    <script>
                                        $(document).ready(function() {
                                            loadspecialty();
                                            // Add specialty
                                            // $("#specialtyForm").submit(function(event) {
                                            //     event.preventDefault();
                                            //     var name = $("#name").val();
                                            //     var specialty = $("#specialty").val();
                                            //     $.ajax({
                                            //         url: "api/specialty_action.php",
                                            //         type: "POST",
                                            //         data: {
                                            //             action: "add",
                                            //             name: name,
                                            //             specialty: specialty
                                            //         },
                                            //         success: function(data) {
                                            //             $("#specialty").val('');
                                            //             loadspecialty();
                                            //         }
                                            //     });
                                            // });
                                            // $(document).on("click", ".editBtn", function() {
                                            //     var id = $(this).data("id");
                                            //     var specialty = $(this).closest("tr").find(".specialty").text();
                                            //     $("#specialtyId").val(id);
                                            //     $("#updateSpecialty").val(specialty);
                                            //     $("#specialtyForm").hide();
                                            //     $("#updateForm").show();
                                            // });
                                            // // Cancel update (hide update form)
                                            // $("#cancelUpdate").click(function() {
                                            //     $("#updateForm").hide();
                                            //     $("#specialtyForm").show();
                                            // });
                                            // // Update specialty
                                            // $("#updateForm").submit(function(event) {
                                            //     event.preventDefault();
                                            //     var id = $("#specialtyId").val();
                                            //     var name = $("#updateName").val();
                                            //     var specialty = $("#updateSpecialty").val();
                                            //     $.ajax({
                                            //         url: "api/specialty_action.php",
                                            //         type: "POST",
                                            //         data: {
                                            //             action: "update",
                                            //             id: id,
                                            //             specialty: specialty
                                            //         },
                                            //         success: function(data) {
                                            //             $("#updateForm").hide();
                                            //             $("#specialtyForm").show();
                                            //             loadspecialty();
                                            //         }

                                            //     });
                                            // });
                                            // // Delete specialty
                                            // $(document).on("click", ".deleteBtn", function() {
                                            //     var id = $(this).data("id");
                                            //     $.ajax({
                                            //         url: "api/specialty_action.php",
                                            //         type: "POST",
                                            //         data: {
                                            //             action: "delete",
                                            //             id: id
                                            //         },
                                            //         success: function(data) {
                                            //             loadspecialty();
                                            //         }
                                            //     });
                                            // });
                                            $("#specialtyForm").submit(function(event) {
                                                event.preventDefault();
                                                var specialty = $("#specialty").val();
                                                $.ajax({
                                                    url: "api/specialty_action.php",
                                                    type: "POST",
                                                    data: {
                                                        action: "add",
                                                        name: name,
                                                        specialty: specialty
                                                    },
                                                    success: function(data) {
                                                        $("#specialty").val('');
                                                        loadspecialty();
                                                        Swal.fire('Success', 'Specialty added successfully', 'success');
                                                    }
                                                });
                                            });

                                            $(document).on("click", ".deleteBtn", function() {
                                                var id = $(this).data("id");
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: "You won't be able to revert this!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: "api/specialty_action.php",
                                                            type: "POST",
                                                            data: {
                                                                action: "delete",
                                                                id: id
                                                            },
                                                            success: function(data) {
                                                                loadspecialty();
                                                                Swal.fire('Deleted!', 'Specialty has been deleted.', 'success');
                                                            }
                                                        });
                                                    }
                                                });
                                            });

                                            $("#updateForm").submit(function(event) {
                                                event.preventDefault();
                                                var id = $("#specialtyId").val();
                                                var name = $("#updateName").val();
                                                var specialty = $("#updateSpecialty").val();
                                                $.ajax({
                                                    url: "api/specialty_action.php",
                                                    type: "POST",
                                                    data: {
                                                        action: "update",
                                                        id: id,
                                                        specialty: specialty
                                                    },
                                                    success: function(data) {
                                                        $("#updateForm").hide();
                                                        $("#specialtyForm").show();
                                                        loadspecialty();
                                                        Swal.fire('Success', 'Specialty updated successfully', 'success');
                                                    }
                                                });
                                            });

                                            $(document).on("click", ".editBtn", function() {
                                                var id = $(this).data("id");
                                                var specialty = $(this).closest("tr").find(".specialty").text();
                                                $("#specialtyId").val(id);
                                                $("#updateSpecialty").val(specialty);
                                                $("#specialtyForm").hide();
                                                $("#updateForm").show();
                                            });


                                            $("#cancelUpdate").click(function() {
                                                $("#updateForm").hide();
                                                $("#specialtyForm").show();
                                            });


                                            function loadspecialty() {
                                                $.ajax({
                                                    url: "api/specialty_action.php",
                                                    type: "GET",
                                                    data: {
                                                        action: "fetch"
                                                    },
                                                    success: function(data) {
                                                        $("#specialtyTable tbody").html(data);
                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                    <?php include('include/footer.php'); ?>