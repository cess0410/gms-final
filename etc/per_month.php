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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script> -->

</head>
<style>
    .btn_1 {
        background-color: #0d560d;
        border: 1px solid #0d560d;
    }

    .page-item.active .page-link {
        background-color: #0d560d !important;
        border-color: 1px solid #0d560d !important;
    }

    .btn_1:hover {
        color: #fff;
        background-color: green !important;
        box-shadow: 0 3px 11px rgb(79 251 90 / 50%);
    }

    .sidebar #sidebar_menu>li a {
        font-weight: 500 !important;
    }

    .btn_1 i {
        font-size: 15px;
        padding-right: 0px !important;
    }

    li {
        font-size: 16px !important;
    }
</style></div>

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="white_card_body row">
                    <div class="col-xl-12">
                        <table id="Table" class="table table-striped" style="width:100%">
                            <div class="row">
                                <div class="col-xl-6">
                                    <thead>
                                        <tr>
                                            <th style=" background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Receiver</th>
                                            <th style=" background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //$sql_receiever = "SELECT DISTINCT receiver FROM tblinquiry WHERE end_year = 2024";
                                        $sql_receiever = "SELECT DISTINCT r.receiver, u.fname FROM tblinquiry r, users u WHERE u.userid = r.receiver AND r.end_year = 2024";
                                        $result_receiver = $db->query($sql_receiever);

                                        if ($result_receiver === false) {
                                            die("Error querying database.");
                                        }
                                        while ($row_receiver = $result_receiver->fetch_assoc()) {
                                            $receiver = $row_receiver['receiver'];
                                            $receivername = $row_receiver['fname'];
                                        }
                                        ?>

                                            <tr id="row_<?= $receiver; ?>"></tr>
                                            <td style="font-size: 16px!important; color: black; font-weight: 400"><?= $receivername ?></td>
                                            <?php

                                            $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                                            $receiver_select = $receiver;
                                            $year = '2024';`
                                            foreach ($months as $month) {
                                                $sql3 = "SELECT COUNT(*) as count FROM tblinquiry WHERE receiver = '$receiver_select' AND end_month = '$month' AND end_year = '$year'";
                                                $result3 = $db->query($sql3);
                                                if ($result3) {
                                                    $row3 = $result3->fetch_assoc();
                                                    // $count = $row3['count'];
                                                    // $total_count += $count; // Add the count to the total
                                                    // echo "<td style='color: black; font-weight: 400'>{$count}</td>";

                                                }
                                            }
                                            ?>
                                            <td>
                                                <ul>
                                                    <?php
                                                    $total_count = 0;
                                                    $sql_specialty = "SELECT DISTINCT specialty FROM tblinquiry WHERE receiver = '$receiver_select' AND end_year = '$year' GROUP BY consultdate";
                                                    $result_specialty = $db->query($sql_specialty);
                                                    if ($result_specialty) {
                                                        while ($row_specialty = $result_specialty->fetch_assoc()) {
                                                            $specialty = $row_specialty['specialty'];
                                                            $sql_specialty_count = "SELECT COUNT(*) as count FROM tblinquiry WHERE receiver = '$receiver_select' AND specialty = '$specialty' AND end_year = '$year' GROUP BY consultdate";
                                                            $result_specialty_count = $db->query($sql_specialty_count);
                                                            if ($result_specialty_count) {
                                                                while ($row_specialty_count = $result_specialty_count->fetch_assoc()) {
                                                                    $count = $row_specialty_count['count'];
                                                                    $total_count += $count;
                                                                    $sql_specialty_count = "SELECT COUNT(*) as count, consultdate FROM tblinquiry WHERE receiver = '$receiver_select' AND specialty = '$specialty' AND end_year = '$year' GROUP BY consultdate";
                                                                    $result_specialty_count = $db->query($sql_specialty_count);
                                                                    $sql_specialty_name = "SELECT specialty FROM specialties WHERE id = '$specialty'";
                                                                    $result_specialty_name = $db->query($sql_specialty_name);



                                                                    echo "<ul>";
                                                                    if ($result_specialty_name && $result_specialty_name->num_rows > 0) {
                                                                        $row_specialty_name = $result_specialty_name->fetch_assoc();
                                                                        $specialty_name = $row_specialty_name['specialty'];

                                                                        while ($row_specialty_count = $result_specialty_count->fetch_assoc()) {
                                                                            $count = $row_specialty_count['count'];
                                                                            $consultdate = $row_specialty_count['consultdate'];


                                                                            $formatted_date = date('F j, Y', strtotime($consultdate));

                                                                            echo "<li>$formatted_date: $count</li>";

                                                                            // echo "<li>$consultdate: $count</li>";
                                                                            echo "<li>$specialty_name: $count</li>";
                                                                        }
                                                                        echo "</ul>";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                        </table>

                    </div>
                </div>

            </div>
    </section>
    <?php include('include/footer.php'); ?>