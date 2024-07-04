<?php include_once 'templates/template_header.php'; ?>
<div class="flex justify-center items-center mt-10 mb-5">
    <div class="w-full max-w-xl">
        <h1 class="text-3xl mb-3 text-center">View Details</h1>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
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
                    echo '<div class="input input-bordered flex items-center gap-2 mb-3 bg-gray-100">
                                            <div class="input-group-text">
                                                <span class=""><img src="vendors/calender_icon.svg" alt=""></span>
                                            </div>
                                        <input type="text"  class="form-input flex-grow" name="consultdate" id="consultdate" placeholder="Date and Time" value="' . date('F d, Y g:i A') . '" readonly>
                                        <input type="hidden" class="form-input flex-grow" name="consultmonth" id="consultmonth" value="' . date('m') . '">
                                        <input type="hidden" class="form-input flex-grow" name="consultyear" id="consultyear" value="' . date('Y') . '"></div>';
                    echo '<div class="input-bordered flex items-center gap-2 mb-3">
            <div >
                <span class="">Receiver</span>
            </div>
            <select class="select input-bordered select-ghost flex-grow id="receiver" name="receiver">';
                    $sql4 = "SELECT * FROM users Where userid = '" . $_SESSION['iuid'] . "'";
                    $result4 = $db->query($sql4);
                    if ($result4 && $result4->num_rows > 0) {
                        while ($row4 = $result4->fetch_assoc()) {
                            echo '<option value="' . $row4['userid'] . '">' . $row4['fname'] . ' ' . $row4['lname'] . '</option>';
                        }
                    }
                    echo '</select>
        </div>';

                    echo '<div class="input input-bordered flex items-center gap-2 mb-3 ">
                <div class="input-group-text">
                    <span class="">Special Endorsement</span>
                </div>
                <input value="' . $endorsement . '" name="endorsement" class="form-input flex-grow">
            </div>';

                    echo '<div class="input input-bordered flex items-center gap-2 mb-3 ">
                <div class="input-group-text">
                    <span class="">Name</span>
                </div>
                <input value="' . $name . '" name="name" class="form-input flex-grow">
            </div>';

                    echo "<div class='input-bordered flex items-center gap-2 mb-3'>
            <label class='input-group-text' for='type'>Type of Client</label>
            <select class='select input-bordered select-ghost flex-grow ' id='type' name='type'>";
                    echo "<option value='New'";
                    if ($type == 'New') echo 'selected';
                    echo ">New</option>";
                    echo "<option value='Old'";
                    if ($type == 'Old') echo 'selected';
                    echo ">Old</option>";
                    echo "</select>
        </div>";


                    echo '<div  class="input-bordered flex items-center gap-2 mb-3">
                <div class="input-group-text">
                    <span class="">Mode of Consultation</span>
                </div>
                 <select class="select input-bordered select-ghost flex-grow " id="mode" name="mode">
                                                    <option value="F2F"' . ($mode == 'F2F' ? ' selected' : '') . '>Face to Face</option>
                                                    <option value="TC"' . ($mode == 'TC' ? ' selected' : '') . '>Teleconsultation</option>
                                                </select>
            </div>';

                    echo '<div class="input input-bordered flex items-center gap-2 mb-3 ">
                <div class="input-group-text">
                    <span class="">Birthday</span>
                </div>
                <input class="form-input flex-grow" type="date" value="' . $birthdate . '" name="birthdate" id="birthdate" onchange="calculateAge()">
            </div>';

                    echo '<div class="input input-bordered flex items-center gap-2 mb-3 bg-gray-100">
                <div class="input-group-text">
                    <span class="">Age</span>
                </div>
                <input type="text" value="' . $age . '" name="age" class="form-input flex-grow" id="age" readonly>
            </div>';

                    echo "<div class='input input-bordered flex items-center gap-2 mb-3'>
            <div class='input-group-text'>
            <span class=''>Contact Number</span>
            </div>";
                    echo "<input value='$contact_no' name='contact_no' class='form-input flex-grow'>
                                         </div>";


                    echo "<div class='input-bordered flex items-center gap-2 mb-3'>
                                             <label class='input-group-text' for='type'>Gender</label>
                                             <select class='select input-bordered select-ghost flex-grow' id='gender' name='gender'>";
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



                    echo '<div class="input-bordered flex items-center gap-2 mb-3">
                                        <label class="input-group-text" for="">Specialty</label>';
                    echo "<select class='select input-bordered select-ghost flex-grow' id='specialty' name='specialty'>";
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
                    echo '<div class=" input-bordered flex items-center gap-2 mb-3">
                                        <div class="input-group-text">
                                            <span class="">Remarks</span>
                                        </div>
                                        <textarea class="input-bordered textarea flex-grow" id="remarks" name="remarks" aria-label="With textarea">' . $remarks . '</textarea>
                                      </div>';




                    echo "<div class='input input-bordered flex items-center gap-2 mb-3 bg-gray-100'>
                                              <div class='input-group-text'>
                                                  <span class=''>Schedule</span>
                                              </div>";
                    if (!empty($start_datetime)) {
                        echo "<input type='datetime-local' class='form-input flex-grow' style='font-size: 16px' name='start_datetime' id='start_datetime' value='" . htmlspecialchars($start_datetime) . "' disabled>";
                    } else {
                        echo "<input type='datetime-local' class='form-input flex-grow' style='font-size: 16px' name='start_datetime' id='start_datetime'>";
                    }
                    echo "</div>";


                    echo '<script>
    var startDatetimeInput = document.getElementById("start_datetime");
    var startDatetimeValue = ' . json_encode(!empty($start_datetime) ? htmlspecialchars($start_datetime) : "") . ';
    if (startDatetimeValue !== "") {
        startDatetimeInput.value = startDatetimeValue;
        startDatetimeInput.disabled = true;
    } else {
        startDatetimeInput.disabled = false;
    }
</script></form>';
                }
            }
            ?>
    </div>
</div>

<script>
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
                window.location.href = 'index.php';
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
<?php include_once 'templates/template_footer.php'; ?>