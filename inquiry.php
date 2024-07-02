<?php include_once 'templates/template_header.php'; ?>
<div class="flex justify-center items-center mt-10 mb-5">
    <div class="w-full max-w-xl">
        <form id="inquiryForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="input input-bordered flex items-center gap-2 mb-3 bg-gray-100">
                <span>Date and Time</span>
                <input type="text" class="form-input flex-grow" name="consultdate" id="consultdate" placeholder="Date and Time" value="<?php echo date('F d, Y g:i A'); ?>" readonly>
                <input type="hidden" name="consultmonth" id="consultmonth" value="<?php echo date('m'); ?>">
                <input type="hidden" name="consultyear" id="consultyear" value="<?php echo date('Y'); ?>">
            </div>

            <div class=" input-bordered flex items-center gap-2 mb-3">
                <span>Receiver</span>
                <?php
                $sql = "SELECT * FROM users Where userid = '" . $_SESSION['iuid'] . "'";
                $result = mysqli_query($db, $sql);
                ?>
                <select class="select input-bordered select-ghost flex-grow bg-gray-100" id="receiver" name="receiver" disabled>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <option value="<?php echo $row['userid']; ?>"><?php echo $row['fname'] . ' ' . $row['lname']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class=" input-bordered flex items-center gap-2 mb-3">
                <span>Mode of Consultation</span>
                <select class="select input-bordered select-ghost flex-grow" id="mode">
                    <option value="F2F" selected>Face to Face</option>
                    <option value="TC">TC</option>
                </select>
            </div>

            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Special Endorsement</span>
                <input type="text" class="form-input flex-grow" id="endorsement">
            </div>

            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Name</span>
                <input type="text" class="form-input flex-grow" id="name" oninput="capitalizeInput(this)" required>
            </div>

            <div class=" input-bordered flex items-center gap-2 mb-3">
                <span>Type of Client</span>
                <select class="select input-bordered select-ghost flex-grow" id="type">
                    <option value="New" selected>New</option>
                    <option value="Old">Old</option>
                </select>
            </div>

            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Birthdate</span>
                <input type="date" class="form-input flex-grow" id="birthdate" onchange="calculateAge()" required>
            </div>

            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Age</span>
                <input type="text" class="form-input flex-grow" id="age" readonly>
            </div>

            <div class=" input-bordered flex items-center gap-2 mb-3">
                <span>Gender</span>
                <select class="select input-bordered select-ghost flex-grow" id="gender">
                    <option value="Male" selected>Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Contact No.</span>
                <input type="text" class="form-input flex-grow" id="contact_no" placeholder="09XX-XXX-XXXX" value="09" maxlength="13">
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
            <div class=" input-bordered flex items-center gap-2 mb-3">
                <span>Specialty</span>
                <select class="select input-bordered select-ghost flex-grow" id="specialty" name="specialty">
                    <?php echo $specialtyOptions; ?>
                </select>
            </div>

            <div class=" input-bordered flex items-center gap-2 mb-3">
                <span>Remarks</span>
                <textarea class="input-bordered textarea flex-grow" id="remarks" aria-label="With textarea"></textarea>
            </div>

            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Scheduled Date</span>
                <input type="datetime-local" class="form-input flex-grow" id="start_datetime" value="">
            </div>
            <div class="w-full text-center">
                <button type="button" id="submitForm" class="btn bg-green-500"></i>Add Inquiry</button>
            </div>
        </form>

    </div>
</div>

<script>
    var phoneNumberInput = $('#contact_no');

    $(phoneNumberInput).on('input', function() {
        var phoneNumber = $(this).val();

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

        $(this).val(phoneNumber);
    });
    $('form#inquiryForm').submit(function(event) {
        var phoneNumber = $('#contact_no').val().replace(/\D/g, ''); // Remove non-digits
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
        $('#start_datetime').on('change', function() {
            console.log('Selected date/time:', $(this).val());
        });

        $('#start_datetime').on('input', function() {
            if ($(this).val() === '') {
                console.log('Input field is empty');
            }
        });
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
<?php include_once 'templates/template_footer.php'; ?>