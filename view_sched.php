<?php include_once 'templates/template_header.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
}
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
?>
        <style>
            .tabs-lifted>.tab:is(input:checked) {
                background-color: #00A651;
                color: white;
            }
        </style>
        <section class=" container m-3">
            <div class="flex justify-between items-center p-4">
                <h1 class="text-3xl font-bold text-zinc-900 ">View Details</h1>
                <div class="flex items-center space-x-2">
                    <img aria-hidden="true" alt="calendar-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📅" />
                    <span class="text-zinc-500 dark:text-zinc-400"><?php echo date('d F Y'); ?></span>
                </div>
            </div>
            <hr />
            <div class="flex justify-center items-center">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div class="col-span-1 rounded-lg my-5">
                        <div class="col-span-1 rounded-lg my-5">
                            <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
                                <div class="card-body">
                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                        <div class="col-span-1 md:col-span-2 w-full text-center">
                                            <div class="overflow-x-auto rounded-lg">
                                                <div role="tablist" class="tabs tabs-lifted">
                                                    <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Personal Information" checked="checked" />
                                                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                                                <?php

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

                                                    <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Status" />
                                                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">



                                                        <label class="label cursor-pointer">
                                                            <span class="label-text">Attended</span>
                                                            <input type="radio" name="radio-10" class="radio radio-success" value="0" checked="checked" />
                                                        </label>
                                                        <label class="label cursor-pointer">
                                                            <span class="label-text">Cancelled</span>
                                                            <input type="radio" name="radio-10" class="radio radio-success" value="0" />
                                                        </label>
                                                        <label class="label cursor-pointer">
                                                            <span class="label-text">Rescheduled</span>
                                                            <input type="radio" name="radio-10" class="radio radio-success" value="2" />
                                                        </label>




                                                    </div>

                                                    <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="History" />
                                                    <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                                                        History
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


        </section>
        <script>
            $(document).on("click", ".deleteBtn", function() {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "api/specialty_action.php",
                            type: "POST",
                            data: {
                                action: "delete",
                                id: id
                            },
                            success: function(data) {
                                loadspecialty();
                                Swal.fire('Deleted!', 'Specialty has been deleted.', 'success');
                            }
                        });
                    }
                });
            });

            $("#updateForm").submit(function(event) {
                event.preventDefault();
                var id = $("#specialtyId").val();
                var name = $("#updateName").val();
                var specialty = $("#updateSpecialty").val();
                $.ajax({
                    url: "api/specialty_action.php",
                    type: "POST",
                    data: {
                        action: "update",
                        id: id,
                        specialty: specialty
                    },
                    success: function(data) {
                        $("#updateForm").hide();
                        $("#specialtyForm").show();
                        loadspecialty();
                        Swal.fire('Success', 'Specialty updated successfully', 'success');
                    }
                });
            });

            $(document).on("click", ".editBtn", function() {
                var id = $(this).data("id");
                var specialty = $(this).closest("tr").find(".specialty").text();
                $("#specialtyId").val(id);
                $("#updateSpecialty").val(specialty);
                $("#specialtyForm").hide();
                $("#updateForm").show();
            });


            $("#cancelUpdate").click(function() {
                $("#updateForm").hide();
                $("#specialtyForm").show();
            });


            function loadspecialty() {
                $.ajax({
                    url: "api/specialty_action.php",
                    type: "GET",
                    data: {
                        action: "fetch"
                    },
                    success: function(data) {
                        $("#specialtyTable tbody").html(data);
                    }
                });
            }
        </script>
        <?php include_once 'templates/template_footer.php'; ?>