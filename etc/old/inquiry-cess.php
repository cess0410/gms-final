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
<style>
    .white_card .white_card_body {
        padding: 5px 30px 16px !important;
    }

    .main_content .main_content_iner {
        padding-top: 5px !important;
        padding-right: 30px;
        padding-left: 30px;
    }
</style>

<body class="crm_body_bg">
    <section class="main_content dashboard_part large_header_bg">
        <?php include 'include/header-2.php'; ?>

        <div class="main_content_iner overly_inner ">
            <div class="container-fluid p-0 ">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="white_card">

                            <div class="white_card_body">
                                <form id="inquiryForm">
                                    <div class="mt-5 mb-3">



                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class=""><img src="vendors/calender_icon.svg" alt=""></span>
                                            </div>
                                            <input type="text" class="form-control" name="consultdate" id="consultdate" placeholder="Date and Time" value="<?php echo date('F d, Y g:i A'); ?>" readonly>
                                            <input type="hidden" class="form-control" name="consultmonth" id="consultmonth" value="<?php echo date('m'); ?>">
                                            <input type="hidden" class="form-control" name="consultyear" id="consultyear" value="<?php echo date('Y'); ?>">

                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Receiver</span>
                                            </div>
                                            <?php
                                            $sql = "SELECT * FROM users Where userid = '" . $_SESSION['iuid'] . "'";
                                            $result = mysqli_query($db, $sql);

                                            ?>
                                            <select class="form-select" id="receiver" name="receiver" disabled>
                                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                                    <option value="<?php echo $row['userid']; ?>"><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="">Mode of Consultation</label>
                                            <select class="form-select" id="mode">
                                                <option value="F2F" selected>Face to Face</option>
                                                <option value="TC">TC</option>
                                            </select>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Special Endorsement</span>
                                            </div>
                                            <input type="text" class="form-control" id="endorsement">
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Name</span>
                                            </div>
                                            <input type="text" class="form-control" id="name" oninput="capitalizeInput(this)" required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="">Type of Client</label>
                                            <select class="form-select" id="type">
                                                <option value="New" selected>New</option>
                                                <option value="Old">Old</option>
                                            </select>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Birthdate</span>
                                            </div>
                                            <input type="date" class="form-control" id="birthdate" onchange="calculateAge()" required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Age</span>
                                            </div>
                                            <input type="text" class="form-control" id="age" readonly>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="">Gender</label>
                                            <select class="form-select" id="gender">
                                                <option value="Male" selected>Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                        <?php
                                        $phone_no = "09123456789";

                                        $format_phone =
                                            substr($phone_no, 0, 4) . "-" .
                                            substr($phone_no, 4, 3) . "-" .
                                            substr($phone_no, 7);

                                        ?>
                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Contact No.</span>
                                            </div>
                                            <input type="text" class="form-control" id="contact_no" placeholder="09XX-XXX-XXXX" value="09" maxlength="13"> <!-- Set maxlength to 13 for the dashes -->
                                        </div>

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
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="">Specialty</label>
                                            <select class="form-select" id="specialty" name="specialty">
                                                <?php echo $specialtyOptions; ?>
                                            </select>
                                        </div>



                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Remarks</span>
                                            </div>
                                            <textarea class="form-control" id="remarks" aria-label="With textarea"></textarea>
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-text">
                                                <span class="">Scheduled Date</span>
                                            </div>
                                            <input type="datetime-local" class="form-control" id="start_datetime" value="">
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var input = document.getElementById('start_datetime');

                                                input.addEventListener('change', function() {
                                                    console.log('Selected date/time:', input.value);
                                                });

                                                input.addEventListener('input', function() {
                                                    if (input.value === '') {
                                                        console.log('Input field is empty');
                                                    }
                                                });
                                            });
                                        </script>
                                        <div class="text-center">
                                            <button type="button" id="submitForm" class="btn_1 mt-2"><i class="fas fa-plus"></i>ADD</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var phoneNumberInput = document.getElementById('contact_no');

        phoneNumberInput.addEventListener('input', function() {
            var phoneNumber = phoneNumberInput.value;

            phoneNumber = phoneNumber.replace(/\D/g, '');

            if (phoneNumber.length > 4) {
                phoneNumber = phoneNumber.substring(0, 4) + '-' + phoneNumber.substring(4);
            }
            if (phoneNumber.length > 8) {
                phoneNumber = phoneNumber.substring(0, 8) + '-' + phoneNumber.substring(8);
            }

            if (phoneNumber.length > 13) {
                phoneNumber = phoneNumber.substring(0, 13);
            }

            phoneNumberInput.value = phoneNumber;
        });
        document.querySelector('inquiryForm').addEventListener('submit', function(event) {
            var phoneNumber = phoneNumberInput.value.replace(/\D/g, ''); // Remove non-digits
            if (phoneNumber.length !== 11 || phoneNumber.length === 0 || phoneNumber.length > 11) {
                alert('Please enter a valid 11-digit phone number.');
                event.preventDefault(); // Prevent form submission
            } else {
                var firstDigit = phoneNumber.charAt(0);
                // Check if the first digit is valid for a Philippine mobile number (0, 9)
                if (firstDigit !== '0' && firstDigit !== '9') {
                    alert('Please enter a valid Philippine mobile number starting with 09.');
                    event.preventDefault(); // Prevent form submission
                }
            }
        });

        var inputElement = document.getElementById('endorsement');

        inputElement.addEventListener('input', function() {
            var value = inputElement.value;

            var capitalizedValue = value.toUpperCase();

            inputElement.value = capitalizedValue;
        });

        function capitalizeInput(input) {
            let value = input.value;

            let words = value.split(" ");

            for (let i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
            }

            let capitalizedValue = words.join(" ");

            input.value = capitalizedValue;
        }

        function calculateAge() {
            var dob = document.getElementById("birthdate").value;
            var dobDate = new Date(dob);
            var today = new Date();
            var age = today.getFullYear() - dobDate.getFullYear();
            var m = today.getMonth() - dobDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
                age--;
            }
            document.getElementById("age").value = age;
        }

        $(document).ready(function() {
            $("#submitForm").click(function() {
                // Prevent default form submission
                event.preventDefault();
                // Validate Name field
                var name = $("#name").val();
                if (name.trim() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Name is required!',
                    });
                    return;
                }

                // Validate Birthdate field
                var birthdate = $("#birthdate").val();
                if (birthdate.trim() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Birthdate is required!',
                    });
                    return;
                }

                // Serialize form data
                var formData = {
                    consultdate: $("#consultdate").val(),
                    consultmonth: $("#consultmonth").val(),
                    consultyear: $("#consultyear").val(),
                    receiver: $("#receiver").val(),
                    mode: $("#mode").val(),
                    endorsement: $("#endorsement").val(),
                    name: $("#name").val(),
                    type: $("#type").val(),
                    birthdate: $("#birthdate").val(),
                    age: $("#age").val(),
                    gender: $("#gender").val(),
                    contact_no: $("#contact_no").val(),
                    specialty: $("#specialty").val(),
                    remarks: $("#remarks").val(),
                    start_datetime: $("#start_datetime").val()
                };

                // Send AJAX request
                $.ajax({
                    url: "api/inquiry_add.php",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Clear form fields after successful submission
                        $("#inquiryForm")[0].reset();

                        // Optionally, you can show a success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Inquiry added successfully!'
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <?php include 'include/footer.php'; ?>