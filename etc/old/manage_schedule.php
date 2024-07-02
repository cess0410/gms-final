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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .container {
            margin: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 200px;
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

</head>


<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>

        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="row">
                    <div class="col-12">
                        <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                            <div class="page_title_left d-flex align-items-center">
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">List of Doctors</h3>
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
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_body pt-3 pb-6">
                                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                    <!-- <h4 class="c-grey-900 mB-20 pb-3">Specialties</h4> -->
                                    <div id="dataTable_wrapper" class="dataTables_wrapper">
                                        <div id="dataTable_filter" class="dataTables_filter">
                                        </div>
                                        <?php
                                        $sql = "SELECT * FROM doctors";
                                        $result = mysqli_query($db, $sql);
                                        $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                        ?>
                                        <table id="doctorTable" class="table table-striped" role="grid" style="width: 100%;" class="mt-3">
                                            <thead>
                                                <tr>
                                                    <th style="background: #00A651 !important; color: white !important; font-weight: 700">Name</th>
                                                    <th style="background: #00A651 !important; color: white !important; font-weight: 700">Specialty</th>
                                                    <th style="background: #00A651 !important; color: white !important; font-weight: 700">Schedule</th>
                                                    <th style="background: #00A651 !important; color: white !important; font-weight: 700">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($doctors as $row) : ?>
                                                    <tr>
                                                        <td style="color: black; font-weight: 500"><?= $row['name']; ?></td>
                                                        <?php
                                                        $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                                                        $result1 = $db->query($sql);

                                                        if ($result1 && $result1->num_rows > 0) {
                                                            $specialty_row = $result1->fetch_assoc();
                                                            $specialty_name = $specialty_row['specialty'];
                                                            echo "<td style='color: black; font-weight: 400'>$specialty_name</td>";
                                                        }
                                                        ?>
                                                        <td style="color: black; font-weight: 500"><?= $row['month']; ?><?= $row['day']; ?><?= $row['time']; ?>
                                                        </td>
                                                        <td>
                                                            <button class='editBtn btn_1 mb-1' data-id="<?= $row['id']; ?>"><i class="fas fa-edit"></i></button>
                                                            <button class='deleteBtn btn_1 mb-1' data-id="<?= $row['id']; ?>"><i class="fas fa-trash"></i></button>
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

                            <script>
                                new DataTable('#doctorTable');
                            </script>
                        </div>

                    </div>


                    <div class="col-lg-5">
                        <div class="white_card">
                            <!-- <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                       <h3 class="m-0">Doctors</h3> 
                                    </div>
                                </div>
                            </div>-->
                            <div class="white_card_body">
                                <form id="submitForm">
                                    <label class="mt-3">Doctor:</label>
                                    <!-- <select class="form-control specialty" name="specialty" multiple="multiple"> -->
                                    <?php $doctorOptionsString = '';
                                    $queryDoctors = "SELECT * FROM doctors;";
                                    $doctorsResult = $db->query($queryDoctors) or die($db->error);

                                    if ($doctorsResult->num_rows > 0) {
                                        while ($doctorRow = $doctorsResult->fetch_assoc()) {
                                            $doctorOptionsString .= '<option value="' . $doctorRow["id"] . '">' . $doctorRow["name"] . '</option>';
                                        }
                                    } else {
                                        $doctorOptionsString .= '<option value="">No doctors found for this specialty</option>';
                                    }
                                    echo '<div class="input-group mt-3">
            <div class="input-group-text">
            <span class="">Doctor</span>
        </div>
                <select class="form-select" id="specialty">';
                                    echo $doctorOptionsString;
                                    echo '</select>
            </div>'; ?>

                                    <label class="mb-2 mt-2">Specialty:</label>
                                    <!-- <select class="form-control specialty" name="specialty" multiple="multiple"> -->
                                    <select class="form-control specialty" name="specialty">
                                        <?php

                                        $sql = "SELECT * FROM specialties LEFT JOIN doctors ON doctors.specialty = specialties.id";
                                        $result = mysqli_query($db, $sql);


                                        if (!$result) {
                                            echo "<option value=''>Error retrieving data</option>";
                                        } else {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row[' id'] . "'>" . $row['specialty'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No Record</option>";
                                            }
                                        }

                                        ?>
                                    </select>


                                    <label class="mb-2 mt-2">Select Multiple Dates in the Calendar</label>
                                    <input type="text" class="form-control" id="dates" name="dates" style="width: 565px;" onselect="select()">

                                    <div id="datetime" class="center-buttons mt-2" style="display: none;">
                                        <label class="mt-2">AM:</label>
                                        <input type="time" class="form-control" id="am" name="am">
                                        <label class="mt-2">PM:</label>
                                        <input type="time" class="form-control" id="pm" name="pm">
                                    </div>

                                    <script type="text/javascript">
                                        function select() {

                                            document.getElementById("dates").addEventListener("change", function() {
                                                    var datetime = document.getElementById("datetime");
                                                    if (this.value !== "") {
                                                        datetime.style.display = "block";
                                                    } else {
                                                        datetime.style.display = "none";
                                                    }
                                                }

                                            );
                                        }



                                        document.getElementById("dates").addEventListener("change", function() {
                                            var datetime = document.getElementById("datetime");
                                            if (this.value !== "") {
                                                datetime.style.display = "block";
                                            } else {
                                                datetime.style.display = "none";
                                            }

                                        });
                                    </script>
                                    <div class="center-buttons">
                                        <button type="submit" class="btn_1 mt-3" style="margin-right: 5px!important"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
    </section>


    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dates').datepicker({
                format: 'yyyy-mm-dd',
                multidate: true,
                todayHighlight: true
            });
        });
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> -->






</body>

</html>