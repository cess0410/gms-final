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

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<style type="text/css">
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1060;
        display: none;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        outline: 0;
    }

    .fade {
        transition: opacity .15s linear;
    }

    .modal-backdrop.show {
        opacity: 0 !important;
    }

    .modal-backdrop {
        position: relative !important;
    }

    body.crm_body_bg.modal-open {
        overflow: none !important;
    }

    .white_card .white_card_body {
        padding: 0px !important;
    }
</style>
<?php
$sql = "SELECT * FROM doctors";
$result = mysqli_query($db, $sql);
$doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>

        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="row">
                    <div class="col-12">
                        <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                            <div class="page_title_left d-flex align-items-center">
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">Manage Doctor</h3>
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
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_header">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="main-title">
                                    <!-- <h3 class="m-0">New Users</h3> -->
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row justify-content-end">
                                    <div class="col-lg-8 d-flex justify-content-end">
                                        <a class="action_btn mr_10" data-bs-toggle="modal" data-bs-target="#Modaldoctor">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div id="dataTable_wrapper" class="dataTables_wrapper">
                                <?php foreach ($doctors as $row) : ?>
                                    <div class="white_card_body" id="doctorTable">
                                        <div class="single_user_pil d-flex align-items-center justify-content-between">
                                            <div class="user_pils_thumb d-flex align-items-center">
                                                <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="vendors/logo.png" alt=""></div>
                                                <span class="f_s_14 f_w_400 text_color_11"><?= $row['name']; ?></span>
                                            </div>
                                            <div class="user_info text-center">
                                                <?= $row['specialty']; ?>
                                            </div>
                                            <div class="action_btns d-flex">
                                                <a href="#" class="action_btn mr_10"> <i class="far fa-eye"></i> </a>
                                                <a href="#" class="action_btn mr_10"> <i class="far fa-edit"></i> </a>
                                                <a href="#" class="action_btn"> <i class="fas fa-trash"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#doctorTable');
    </script>
    <script>
        $(document).ready(function() {
            // Load Doctors on page load
            loadDoctors();

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

            // Cancel update (hide update form)
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
                        $("#updateForm").hide();
                        $("#doctorForm").show();
                        loadDoctors();
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

            // Load Doctors
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
    <?php include 'include/footer.php'; ?>