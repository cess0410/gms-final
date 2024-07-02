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
    <title>Per Year Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        th {
            background: #00A651 !important;
            color: white !important;
            font-weight: 700 !important;
        }

        td {
            color: black !important;
            font-weight: 400 !important;
        }

        .btn_1 i {
            padding-right: 0px !important;
        }

        .btn_1 {
            padding: 9px 15px !important;
        }

        div#inquiryTable_filter {
            display: none;
        }

        section.main_content.dashboard_part.large_header_bg {
            background-color: #F6F7FB !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: #00A651 !important;
        }

        input[type="search"],
        div.dataTables_wrapper div.dataTables_length label {
            margin-bottom: 0.5em !important;
            margin-top: 10px !important;
            margin-left: 15px !important;
            margin-right: 15px !important;
        }

        div.dataTables_wrapper div.dataTables_filter input,
        select {
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

        .main_content .main_content_iner {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
    </style>
</head>

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <div class="main_content_iner overly_inner">
            <div class="container-fluid p-0">
                <div class="white_card_body row">
                    <div class="col-xl-12">
                        <table id="perYearTable" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Receiver</th>
                                    <th>January</th>
                                    <th>February</th>
                                    <th>March</th>
                                    <th>April</th>
                                    <th>May</th>
                                    <th>June</th>
                                    <th>July</th>
                                    <th>August</th>
                                    <th>September</th>
                                    <th>October</th>
                                    <th>November</th>
                                    <th>December</th>
                                    <th>Per Specialty</th>
                                    <th>Total Consult</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $year = '2024';
                                $sql_receiever = "SELECT DISTINCT r.receiver, u.fname FROM tblinquiry r, users u WHERE u.userid = r.receiver AND r.end_year = '$year'";
                                $result_receiver = $db->query($sql_receiever);

                                if ($result_receiver) {
                                    while ($row_receiver = $result_receiver->fetch_assoc()) {
                                        $receiver = $row_receiver['receiver'];
                                        $receivername = $row_receiver['fname'];
                                        echo "<tr>";
                                        echo "<td>{$receivername}</td>";

                                        $months = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                                        foreach ($months as $month) {
                                            $sql_count = "SELECT COUNT(*) AS count FROM tblinquiry WHERE receiver = '$receiver' AND end_month = '$month' AND end_year = '$year'";
                                            $result_count = $db->query($sql_count);
                                            if ($result_count) {
                                                $row_count = $result_count->fetch_assoc();
                                                $count = $row_count['count'];
                                                echo "<td>{$count}</td>";
                                            } else {
                                                echo "<td>Error: " . $db->error . "</td>";
                                            }
                                        }

                                        echo "<td>";
                                        echo "<ul>";
                                        $total_count = 0;
                                        $sql_specialty = "SELECT DISTINCT specialty FROM tblinquiry WHERE receiver = '$receiver' AND end_year = '$year'";
                                        $result_specialty = $db->query($sql_specialty);
                                        if ($result_specialty) {
                                            while ($row_specialty = $result_specialty->fetch_assoc()) {
                                                $specialty = $row_specialty['specialty'];
                                                $sql_specialty_count = "SELECT COUNT(*) AS count FROM tblinquiry WHERE receiver = '$receiver' AND specialty = '$specialty' AND end_year = '$year'";
                                                $result_specialty_count = $db->query($sql_specialty_count);
                                                if ($result_specialty_count) {
                                                    $row_specialty_count = $result_specialty_count->fetch_assoc();
                                                    $specialty_count = $row_specialty_count['count'];
                                                    $total_count += $specialty_count;

                                                    // Fetch specialty name from another table 'specialties'
                                                    $sql_specialty_name = "SELECT specialty FROM specialties WHERE id = '$specialty'";
                                                    $result_specialty_name = $db->query($sql_specialty_name);
                                                    if ($result_specialty_name && $result_specialty_name->num_rows > 0) {
                                                        $row_specialty_name = $result_specialty_name->fetch_assoc();
                                                        $specialty_name = $row_specialty_name['specialty'];
                                                        echo "<li>{$specialty_name}: {$specialty_count}</li>";
                                                    } else {
                                                        echo "<li>Error: Specialty not found.</li>";
                                                    }
                                                }
                                            }
                                        }
                                        echo "</ul>";
                                        echo "</td>";
                                        echo "<td>{$total_count}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='15'>No data found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#perYearTable').DataTable({
                "paging": true, // Enable paging
                "searching": true, // Enable search bar
                // Add any additional options or configurations as needed
            });
        });
    </script>

    <?php include('include/footer.php'); ?>
</body>

</html>