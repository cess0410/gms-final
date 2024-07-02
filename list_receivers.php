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
                                <h3 class="f_s_25 f_w_700 dark_text mr_30">List of Receivers</h3>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-xl-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="row align-items-center">
                                    <div class="main-title">
                                        <div class="white_card_body ">
                                            <?php
                                            $sql = "SELECT * FROM tblinquiry";
                                            $result = mysqli_query($db, $sql);
                                            $inquiry = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            ?>
                                            <table id="inquiryTable" class="table table-striped" style="width:100%">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <input type="text" id="receiverFilter" class="form-control mb-2" placeholder="Enter receiver name">
                                                        <select class="form-control" id="consultmonthFilter">
                                                            <option value="" selected>Select Month</option>
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <input type="number" id="yearFilter" class="form-control mb-2" placeholder="Enter year (yyyy)">
                                                        <select class=" form-select" id="specialtyFilter">
                                                            <option value="" selected>Select Specialty</option>
                                                            <?php
                                                            $sql2 = "SELECT * FROM `specialties`";
                                                            $result2 = $db->query($sql2);

                                                            if ($result2 && $result2->num_rows > 0) {
                                                                while ($specialty_row = $result2->fetch_assoc()) {
                                                                    $specialty_id = $specialty_row['id'];
                                                                    $specialty_name = $specialty_row['specialty'];
                                                                    echo "<option value='$specialty_name'>" . htmlspecialchars($specialty_name) . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <span class="counts"></span>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                                <div class="col-xl-6">
                                    <button id="generate" class="btn btn-primary mb-3">Generate Report</button>
                                </div>
                            </div> -->
                        <thead>
                            <tr>
                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Receiver</th>
                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Month</th>
                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Year</th>
                                <th style="background: #00A651 !important; color: white !important; font-weight: 700; font-size: 15px!important; vertical-align: middle!important;">Specialty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inquiry as $row) : ?>
                                <tr id="row_<?= $row['id']; ?>">
                                    <?php
                                    $sql_receiever = "SELECT users.fname AS name FROM tblinquiry LEFT JOIN users ON tblinquiry.receiver = users.userid WHERE tblinquiry.id = " . $row['id'];
                                    $result_receiver = $db->query($sql_receiever);

                                    if ($result_receiver === false) {
                                        die("Error querying database.");
                                    }
                                    while ($row_receiver = $result_receiver->fetch_assoc()) {
                                        $receiver = $row_receiver['name'];
                                    }
                                    ?>
                                    <td style="color: black; font-weight: 400"><?= $receiver ?></td>

                                    <td style="color: black; font-weight: 400;">
                                        <?= $row['consultmonth'] ?>
                                        <?php if ($row['consultmonth'] == '01') {
                                            echo 'January';
                                        } elseif ($row['consultmonth'] == '02') {
                                            echo 'February';
                                        } elseif ($row['consultmonth'] == '03') {
                                            echo 'March';
                                        } elseif ($row['consultmonth'] == '04') {
                                            echo 'April';
                                        } elseif ($row['consultmonth'] == '05') {
                                            echo 'May';
                                        } elseif ($row['consultmonth'] == '06') {
                                            echo 'June';
                                        } elseif ($row['consultmonth'] == '07') {
                                            echo 'July';
                                        } elseif ($row['consultmonth'] == '08') {
                                            echo 'August';
                                        } elseif ($row['consultmonth'] == '09') {
                                            echo 'September';
                                        } elseif ($row['consultmonth'] == '10') {
                                            echo 'October';
                                        } elseif ($row['consultmonth'] == '11') {
                                            echo 'November';
                                        } elseif ($row['consultmonth'] == '12') {
                                            echo 'December';
                                        }
                                        ?>


                                    <td style="color: black; font-weight: 400"><?= $row['consultyear'] ?></td>
                                    <?php
                                    $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                                    $result1 = $db->query($sql);

                                    if ($result1 && $result1->num_rows > 0) {
                                        $specialty_row = $result1->fetch_assoc();
                                        $specialty_name = $specialty_row['specialty'];
                                        echo "<td style='color: black; font-weight: 400'>$specialty_name</td>";
                                    }
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                </div>
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
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                }
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

            // function generateReport() {
            //     $.ajax({
            //         url: 'api/generate_report.php',
            // type: 'POST',
            // dataType: 'json',
            // success: function(data) {
            //     table.clear().draw();
            //     if (data) {
            //         data.forEach(function(row) {
            //             table.row.add([
            //                 row.receiver,
            //                 row.consultmonth,
            //                 row.consultyear,
            //                 row.count
            //             ]).draw();
            //         });
            //     }
            // },
            // error: function(xhr, status, error) {
            //     console.error('Error fetching report data:', error);

            //             url: 'api/generate_report.php',
            //             type: 'GET',
            //             success: function(data) {
            //                 let reportContent = '<h1>Generated Report</h1><table>';
            //                 reportContent += '<tr><th>Receiver</th><th>Month</th><th>Year</th><th>Count</th></tr>';

            //                 data.forEach(function(item) {
            //                     reportContent += '<tr>';
            //                     reportContent += '<td>' + item.receiver + '</td>';
            //                     reportContent += '<td>' + item.consultmonth + '</td>';
            //                     reportContent += '<td>' + item.consultyear + '</td>';
            //                     reportContent += '<td>' + item.count + '</td>';
            //                     reportContent += '</tr>';
            //                 });

            //                 reportContent += '</table>';

            //                 let printWindow = window.open('', '_blank');
            //                 printWindow.document.write(reportContent);

            //                 printWindow.onload = function() {
            //                     printWindow.print();
            //                 };
            //             },
            //             error: function(xhr, status, error) {
            //                 console.log('Error: ' + error);
            //             }
        });
        // }
        // });
    </script>
    <?php include 'include/footer.php'; ?>