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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="vendors/style1.css">

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>
        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="white_card card_height_100 mb_30 user_crm_wrapper">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="white_card mb_30 card_height_100" style="background: #F6F7FB !important;">
                                <div class="row ">
                                    <div class="col-xl-8">
                                        <div class="white_card card_height_100 mb_30">
                                            <div class="white_card_header">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-4">
                                                        <div class="main-title">
                                                            <h3 class="m-0">Doctor List</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $sql = "SELECT * FROM doctors LEFT JOIN specialties ON doctors.specialty = specialties.id";
                                            $result = mysqli_query($db, $sql);
                                            $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            ?>
                                            <div class="white_card_body">
                                                <table id="doctorTable">
                                                    <div class="row">

                                                        <thead>
                                                            <tr>
                                                                <th style="display: none;">Name</th>
                                                                <th style="display: none;">Specialty</th>
                                                                <th style="display: none;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($doctors as $row) : ?>
                                                                <tr>
                                                                    <div class="single_user_pil d-flex align-items-center justify-content-between">
                                                                        <div class="user_pils_thumb d-flex align-items-center">
                                                                            <!-- <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="vendors/logo.png" alt=""></div> -->
                                                                            <span class="f_s_14 f_w_400 text_color_11"><?= $row['name']; ?></span>
                                                                        </div>
                                                                        <div class="action_btns d-flex">
                                                                            <a href="#" class="action_btn mr_10"> <i class="far fa-eye"></i> </a>
                                                                            <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                                                            <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </div>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="white_card card_height_100 mb_30">
                                            <div class="white_card_header">
                                                <div class="row align-items-center">
                                                    <div class="main-title">
                                                        <h3 class="m-0">Specialty List</h3>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                            $sql = "SELECT * FROM specialties";
                                            $result = mysqli_query($db, $sql);
                                            $specialties = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            ?>
                                            <div class="white_card_body">
                                                <table id="specialtyTable">
                                                    <div class="row">
                                                        <thead>
                                                            <tr>
                                                                <th style="display: none;">Specialty</th>
                                                                <th style="display: none;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($specialties as $row) : ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="single_user_pil d-flex align-items-center justify-content-between" style="padding: 10px 35px;">
                                                                            <div class="user_pils_thumb d-flex align-items-center">
                                                                                <span class="f_s_14 f_w_400 text_color_11"> <?= $row['specialty']; ?></span>
                                                                            </div>
                                                                            <div class="action_btns d-flex">
                                                                                <a href="#" class="action_btn mr_10"> <i class="far fa-eye"></i> </a>
                                                                                <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                                                                <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </div>
                                                </table>
                                                <script>
                                                    let table = $('#doctorTable').DataTable({
                                                        "language": {
                                                            "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                                                        }
                                                    });
                                                    $('#searchFilter').on('keyup', function() {
                                                        table.columns(0).search(this.value).draw();
                                                    });
                                                </script>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'dashboard2.php'; ?>

                        <?php include 'generate.php'; ?>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
                        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>