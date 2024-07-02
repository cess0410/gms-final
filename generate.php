<?php
// session_start();
// ob_start();
include "include/config.php";
include "include/header.php";
include "include/sidebar.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    // header("location: index.php");
    ob_end_flush();
    exit();
}
?>



<div class="col-lg-4">
    <div class="white_card">
        <div class="white_card_header border_bottom_1px">
            <h4 class="card-title mb-0">Receiver's Report</h4>
        </div>
        <div class="card-body">
            <div class="accordion" id="accordionExample1">
                <div class="card border mb-1 shadow-none">
                    <div class="white_card_header border_bottom_1px custom-accordion" id="headingOne1">
                        <a href="" class="text-dark d-flex justify-content-between" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1" previewlistener="true">
                            <span class="align-self-center">Generate Report</span> <img src="vendors/report.png" alt="" height="30">
                        </a>
                    </div>
                    <div id="collapseOne1" class="collapse show" aria-labelledby="headingOne1" data-parent="#accordionExample1" style="">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="select_receiver" class="form-label">Receiver:</label>
                                <?php
                                $sql_receiver = "SELECT DISTINCT r.receiver, u.fname FROM tblinquiry r, users u WHERE u.userid = r.receiver AND r.consultyear = 2024";
                                $result_receiver = $db->query($sql_receiver);

                                if ($result_receiver === false) {
                                    die("Error querying database.");
                                }
                                echo "<select name='receiver' class='form-control'>";
                                while ($row_receiver = $result_receiver->fetch_array()) {
                                    $receiver = $row_receiver['receiver'];
                                    $receivername = $row_receiver['fname'];

                                    echo "<option value='$receiver'>$receivername</option>";
                                }
                                echo "</select>";
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-lg-0">
                                        <label for="select_month1" class="form-label">Select Month</label>
                                        <?php
                                        $sql6 = "SELECT DISTINCT r.consultmonth FROM tblinquiry r, users u WHERE u.userid = r.receiver AND r.consultyear = 2024";
                                        $result6 = $db->query($sql6);

                                        if ($result6 === false) {
                                            die("Error querying database.");
                                        }
                                        ?>
                                        <select class="form-select" id="select_month">
                                            <option value="0">All</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-lg-0">
                                        <label for="select_year1" class="form-label me-2">Select Year</label>
                                        <select class="form-select" id="select_year1">
                                            <option selected="">-- Select --</option>
                                            <option value="2024">2024</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn_1 mt-1 mb-1 w-100">GENERATE REPORT</button>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="white_card">
        <div class="white_card_header border_bottom_1px">
            <h4 class="card-title mb-0">Doctor's Report</h4>
        </div>
        <div class="card-body">
            <div class="accordion" id="accordionExample2">
                <div class="card border mb-1 shadow-none">
                    <div class="white_card_header border_bottom_1px custom-accordion" id="headingOne2">
                        <a href="" class="text-dark d-flex justify-content-between" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2" previewlistener="true">
                            <span class="align-self-center">Generate Report</span> <img src="vendors/management.png" alt="" height="30">
                        </a>
                    </div>
                    <div id="collapseOne2" class="collapse show" aria-labelledby="headingOne2" data-parent="#accordionExample2" style="">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="Card_No2">Doctor :</label>
                                <?php
                                $sql = "SELECT * FROM doctors";
                                $result = mysqli_query($db, $sql);
                                $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                ?>
                                <select class="form-select" id="select_doctor">
                                    <?php foreach ($doctors as $doctor) : ?>
                                        <option value="<?php echo $doctor['id']; ?>"><?php echo $doctor['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-lg-0">
                                        <label for="select_month2" class="form-label">Select Month</label>
                                        <select class="form-select" id="select_month">
                                            <option value="0">All</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-lg-0">
                                        <label for="select_year2" class="form-label me-2">Select Year</label>
                                        <select class="form-select" id="select_year2">
                                            <option selected="">-- Select --</option>
                                            <option value="1">2020</option>
                                            <option value="2">2021</option>
                                            <option value="3">2022</option>
                                            <option value="4">2023</option>
                                            <option value="5">2024</option>
                                            <option value="6">2025</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn_1 mt-1 mb-1 w-100">GENERATE REPORT</button>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4 mb-3">
    <div class="white_card">
        <div class="white_card_header border_bottom_1px">
            <h4 class="card-title mb-0">Specialties Report</h4>
        </div>
        <div class="card-body">
            <div class="accordion" id="accordionExample2">
                <div class="card border mb-1 shadow-none">
                    <div class="white_card_header border_bottom_1px custom-accordion" id="headingOne2">
                        <a href="" class="text-dark d-flex justify-content-between" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2" previewlistener="true">
                            <span class="align-self-center">Generate Report</span> <img src="vendors/treatment.png" alt="" height="30">
                        </a>
                    </div>
                    <div id="collapseOne2" class="collapse show" aria-labelledby="headingOne2" data-parent="#accordionExample2" style="">
                        <div class="card-body">
                            <div class="mb-3">
                                <?php
                                $specialtyOptions = '';
                                $sql = "SELECT * FROM specialties";
                                $result = $db->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $specialtyOptions .= '<option value="' . $row["id"] . '">' . $row["specialty"] . '</option>';
                                    }
                                }
                                ?>
                                <label class="form-label" for="Specialty">Specialty :</label>
                                <select class="form-select" id="specialty" name="specialty">
                                    <?php echo $specialtyOptions; ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-lg-0">
                                        <label for="select_month2" class="form-label">Select Month</label>
                                        <select class="form-select" id="select_month">
                                            <option value="0">All</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-lg-0">
                                        <label for="select_year2" class="form-label me-2">Select Year</label>
                                        <select class="form-select" id="select_year2">
                                            <option selected="">-- Select --</option>
                                            <option value="1">2020</option>
                                            <option value="2">2021</option>
                                            <option value="3">2022</option>
                                            <option value="4">2023</option>
                                            <option value="5">2024</option>
                                            <option value="6">2025</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn_1 mt-1 mb-1 w-100">GENERATE REPORT</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>