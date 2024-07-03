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
</style>
<section class="main_content dashboard_part large_header_bg">
    <div class="main_content_iner ">
        <div class="container-fluid p-0 sm_padding_15px">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="white_card">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <!-- <h3 class="m-0">Inquiry</h3> -->
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <form id="UpdateinquiryForm">
                                <?php
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    $sql = "SELECT * FROM tblinquiry WHERE id = '$id'";
                                    $result = $db->query($sql);
                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $consultdate = $row['consultdate'];
                                        $consultmonth = $row['consultmonth'];
                                        $consultyear = $row['consultyear'];
                                        $receiver = $row['receiver'];
                                        $mode = $row['mode'];
                                        $endorsement = $row['endorsement'];
                                        $name = $row['name'];
                                        $type = $row['type'];
                                        $birthdate = $row['birthdate'];
                                        $age = $row['age'];
                                        $gender = $row['gender'];
                                        $contact_no = $row['contact_no'];
                                        $specialty = $row['specialty'];
                                        $remarks = $row['remarks'];
                                        $start_datetime = $row['start_datetime'];
                                        echo '<input type="hidden" name="id" id="id" value="<? echo $id; ?>">';


                                        echo '<div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class=""><img src="vendors/calender_icon.svg" alt=""></span>
                                            </div>
                                        <input type="text" class="form-control" name="consultdate" id="consultdate" placeholder="Date and Time" value="' . date('F d, Y g:i A') . '" readonly>
                                        <input type="hidden" class="form-control" name="consultmonth" id="consultmonth" value="' . date('m') . '">
                                        <input type="hidden" class="form-control" name="consultyear" id="consultyear" value="' . date('Y') . '"></div>';
                                        echo '<div class="input-group mt-3 mb-3">
            <div class="input-group-text">
                <span class="">Receiver</span>
            </div>
            <select class="form-select" id="receiver" name="receiver">';
                                        $sql4 = "SELECT * FROM users Where userid = '" . $_SESSION['iuid'] . "'";
                                        $result4 = $db->query($sql4);
                                        if ($result4 && $result4->num_rows > 0) {
                                            while ($row4 = $result4->fetch_assoc()) {
                                                echo '<option value="' . $row4['userid'] . '">' . $row4['fname'] . ' ' . $row4['lname'] . '</option>';
                                            }
                                        }
                                        echo '</select>
        </div>';

                                        echo '<div class="input-group mb-3">
                <div class="input-group-text">
                    <span class="">Special Endorsement</span>
                </div>
                <input value="' . $endorsement . '" name="endorsement" class="form-control">
            </div>';

                                        echo '<div class="input-group mb-3">
                <div class="input-group-text">
                    <span class="">Name</span>
                </div>
                <input value="' . $name . '" name="name" class="form-control">
            </div>';

                                        echo "<div class='input-group mt-3'>
            <label class='input-group-text' for='type'>Type of Client</label>
            <select class='form-select' id='type' name='type'>";
                                        echo "<option value='New'";
                                        if ($type == 'New') echo 'selected';
                                        echo ">New</option>";
                                        echo "<option value='Old'";
                                        if ($type == 'Old') echo 'selected';
                                        echo ">Old</option>";
                                        echo "</select>
        </div>";


                                        echo '<div class="input-group mt-3">
                <div class="input-group-text">
                    <span class="">Mode of Consultation</span>
                </div>
                 <select class="form-select" id="mode" name="mode">
                                                    <option value="F2F"' . ($mode == 'F2F' ? ' selected' : '') . '>Face to Face</option>
                                                    <option value="TC"' . ($mode == 'TC' ? ' selected' : '') . '>Teleconsultation</option>
                                                </select>
            </div>';

                                        echo '<div class="input-group mt-3">
                <div class="input-group-text">
                    <span class="">Birthday</span>
                </div>
                <input class="form-control" type="date" value="' . $birthdate . '" name="birthdate" id="birthdate" onchange="calculateAge()">
            </div>';

                                        echo '<div class="input-group mt-3">
                <div class="input-group-text">
                    <span class="">Age</span>
                </div>
                <input type="text" value="' . $age . '" name="age" class="form-control" id="age" readonly>
            </div>';

                                        echo "<div class='input-group mt-3'>
            <div class='input-group-text'>
            <span class=''>Contact Number</span>
            </div>";
                                        echo "<input value='$contact_no' name='contact_no' class='form-control'>
                                         </div>";


                                        echo "<div class='input-group mt-3'>
                                             <label class='input-group-text' for='type'>Gender</label>
                                             <select class='form-select' id='gender' name='gender'>";
                                        echo "<option value='Male'";
                                        if ($gender == 'Male') echo ' selected';
                                        echo ">Male</option>";
                                        echo "<option value='Female'";
                                        if ($gender == 'Female') echo ' selected';
                                        echo ">Female</option>";
                                        echo "<option value='Others'";
                                        if ($gender == 'Other/s') echo ' selected';
                                        echo ">Other/s</option>";
                                        echo "</select>
                                     </div>";



                                        echo '<div class="input-group mt-3">
                                        <label class="input-group-text" for="">Specialty</label>';
                                        echo "<select class='form-select' id='specialty' name='specialty'>";
                                        $sql5 = "SELECT * FROM `specialties`";
                                        $result5 = $db->query($sql5);

                                        if ($result5 && $result5->num_rows > 0) {
                                            while ($specialty_row = $result5->fetch_assoc()) {
                                                $specialty_id = $specialty_row['id'];
                                                $specialty_name = $specialty_row['specialty'];
                                                $selected = ($row['specialty'] == $specialty_id) ? "selected" : "";
                                                echo "<option value='$specialty_id' $selected>" . htmlspecialchars($specialty_name) . "</option>";
                                            }
                                        }
                                        echo "</select></div>";
                                        echo '<div class="input-group mt-3">
                                        <div class="input-group-text">
                                            <span class="">Remarks</span>
                                        </div>
                                        <textarea class="form-control" id="remarks" name="remarks" aria-label="With textarea">' . $remarks . '</textarea>
                                      </div>';




                                        echo "<div class='input-group mt-3'>
                                              <div class='input-group-text'>
                                                  <span class=''>Schedule</span>
                                              </div>";
                                        if (!empty($start_datetime)) {
                                            echo "<input type='datetime-local' class='form-control form-control-sm rounded-0' style='font-size: 16px' name='start_datetime' id='start_datetime' value='" . htmlspecialchars($start_datetime) . "' disabled>";
                                        } else {
                                            echo "<input type='datetime-local' class='form-control form-control-sm rounded-0' style='font-size: 16px' name='start_datetime' id='start_datetime'>";
                                        }
                                        echo "</div>";

                                        // JavaScript to handle displaying/hiding the div based on $start_datetime
                                        echo "<script>
                                              var start_datetime = '<?php echo !empty($start_datetime) ? htmlspecialchars($start_datetime) : ''; ?>';
                                              var startDatetimeInput = document.getElementById('start_datetime');
                                              if (start_datetime) {
                                                  startDatetimeInput.value = start_datetime;
                                                  startDatetimeInput.disabled = true;
                                              } else {
                                                  startDatetimeInput.disabled = false;
                                              }
                                            </script>";



                                        echo ' 
                                <div class="text-center mt-4">
                     <button type="submit" class="btn_1" name="action" value="add"><i class="fas fa-save"></i>          SAVE</button>
                    <a class="btn_1" href="list_inquiries.php"><i class="fa fa-window-close"></i>          CANCEL</a>
                </div>
                            </form> ';
                                    }
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function calculateAge() {
        var dob = document.getElementById("birthdate").value;
        var dobDate = new Date(dob);
        var today = new Date();
        sadasd
        var age = today.getFullYear() - dobDate.getFullYear();
        var m = today.getMonth() - dobDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
            age--;
        }
        document.getElementById("age").value = age;
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // $(document).ready(function() {
    //     $("#UpdateinquiryForm").submit(function(event) {
    //         event.preventDefault();


    //         var formData = $(this).serialize();
    //         var additionalData = {
    //             'id': '<?= $id ?>',
    //             'action': 'update'
    //         };
    //         formData += '&' + $.param(additionalData);
    //         $.ajax({
    //             url: "api/inquiry_update.php",
    //             type: "POST",
    //             data: formData,
    //             success: function(response) {
    //                 $("#UpdateinquiryForm")[0].reset();
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Success',
    //                     text: 'Inquiry updated successfully!'
    //                 });
    //             },
    //             error: function(xhr, status, error) {
    //                 // Handle errors
    //                 console.error(xhr.responseText);
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: 'An error occurred while updating the inquiry. Please try again later.'
    //                 });
    //             }
    //         });
    //     });
    // });


    $("#UpdateinquiryForm").submit(function(event) {
        // alert("hello");
        event.preventDefault();
        var formData = $(this).serialize();
        var additionalData = {
            'id': '<?= $id ?>',
            'action': 'add'
        };
        formData += '&' + $.param(additionalData);

        $.ajax({
            url: "api/inquiry_update.php",
            type: "POST",
            data: formData,
            success: function(response) {
                // $("#UpdateinquiryForm")[0].reset();
                window.location.href = 'list_inquiries.php';
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the inquiry. Please try again later.'
                });
            }
        });
    });
</script>

<?php include('include/footer.php'); ?>