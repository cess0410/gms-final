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
    $sql = "SELECT * FROM tblinquiry WHERE id = '$id';";
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
        $schedule = $row['schedule'];
        $status = $row['status'];
        $cancelled = $row["cancelled"];
        $attended = $row["attended"];
        $doctor = $row["doctor"];
        $diagnose = $row["diagnose"];
        $end_datetime = $row["end_datetime"];
        $rescheduled = $row["rescheduled"];
        $rescheduled_id = $row["rescheduled_id"];
        $follow_up = $id;

        $sql_specialties = "SELECT * FROM `specialties`";
        $result_specialties = $db->query($sql_specialties);
        $specialty_options = '';
        if ($result_specialties && $result_specialties->num_rows > 0) {
            while ($specialty_row = $result_specialties->fetch_assoc()) {
                $specialty_id = $specialty_row['id'];
                $specialty_name = htmlspecialchars($specialty_row['specialty']);
                $selected = ($specialty == $specialty_id) ? "selected" : "";
                $specialty_options .= "<option value='$specialty_id' $selected>$specialty_name</option>";
            }
        } else {
            $specialty_options .= "<option value=''>No specialties found</option>";
        }

        $doctorOptionsString = '';
        $specialty = $row['specialty'];
        $queryDoctors = "SELECT * FROM doctors WHERE specialty = '$specialty';";
        $doctorsResult = $db->query($queryDoctors) or die($db->error);

        if ($doctorsResult->num_rows > 0) {
            while ($doctorRow = $doctorsResult->fetch_assoc()) {
                $doctorOptionsString .= '<option value="' . $doctorRow["id"] . '">' . $doctorRow["name"] . '</option>';
            }
        } else {
            $doctorOptionsString .= '<option value="">No doctors found for this specialty</option>';
        }
?>
        <style>
            .tabs-lifted>.tab:is(input:checked) {
                background-color: #00A651;
                color: white;
            }
        </style>
        <section class="container m-3">
            <hr />

            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div class="col-span-1 rounded-lg my-2">
                    <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
                        <div class="card-body">
                            <div class="col-span-1 md:col-span-2 w-full text-center">
                                <div class="overflow-x-auto rounded-lg">
                                    <div role="tablist" class="tabs tabs-lifted">
                                        <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Personal Information" checked="checked" />
                                        <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                                            <!-- <div class="card bg-base-100 w-full flex-center max-w-xl shrink-0 shadow-2xl"> -->
                                            <form class="card-body mt-3">

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
<div>
<label class="">Receiver :</span>
</div>
<select class="select input-bordered select-ghost flex-grow id="receiver" name="receiver" style="pointer-events: none,">';
                                        $sql4 = "SELECT * FROM users Where userid = '" . $_SESSION['iuid'] . "'";
                                        $result4 = $db->query($sql4);
                                        if ($result4 && $result4->num_rows > 0) {
                                            while ($row4 = $result4->fetch_assoc()) {
                                                echo '<option value="' . $row4['userid'] . '">' . $row4['fname'] . ' ' . $row4['lname'] . '</option>';
                                            }
                                        }
                                        echo '</select></div>';

                                        echo '<div class="input input-bordered flex items-center gap-2 mb-3 ">
<div class="input-group-text">
<span class="">Special Endorsement  :</span>
</div>
<input value="' . $endorsement . '" name="endorsement" class="form-input flex-grow" readonly>
</div>';

                                        echo '<div class="input input-bordered flex items-center gap-2 mb-3 ">
<div class="input-group-text">
<span class="">Name :</span>
</div>
<input value="' . $name . '" name="name" class="form-input flex-grow">
</div>';

                                        echo "<div class='input-bordered flex items-center gap-2 mb-3'>
<label class='input-group-text' for='type'>Type of Client   :</label>
<select class='select input-bordered select-ghost flex-grow ' id='type' name='type' style='pointer-events: none'>";
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
<label class="">Mode of Consultation :</label>
</div>
<select class="select input-bordered select-ghost flex-grow " id="mode" name="mode" style="pointer-events: none">
<option value="F2F"' . ($mode == 'F2F' ? ' selected' : '') . '>Face to Face</option>
<option value="TC"' . ($mode == 'TC' ? ' selected' : '') . '>Teleconsultation</option>
</select>
</div>';

                                        echo '<div class="input input-bordered flex items-center gap-2 mb-3 ">
<div class="input-group-text">
<span class="">Birthday :</span>
</div>
<input class="form-input flex-grow" type="date" value="' . $birthdate . '" name="birthdate" id="birthdate" onchange="calculateAge()" readonly>
</div>';

                                        echo '<div class="input input-bordered flex items-center gap-2 mb-3 bg-gray-100">
<div class="input-group-text">
<span class="">Age  :</span>
</div>
<input type="text" value="' . $age . '" name="age" class="form-input flex-grow" id="age" readonly>
</div>';

                                        echo "<div class='input input-bordered flex items-center gap-2 mb-3'>
<div class='input-group-text'>
<span class=''>Contact Number   :</span>
</div>";
                                        echo "<input value='$contact_no' name='contact_no' class='form-input flex-grow' readonly>
</div>";

                                        echo "<div class='input-bordered flex items-center gap-2 mb-3'>
<label class='input-group-text' for='type'>Gender   :</label>
<select class='select input-bordered select-ghost flex-grow' id='gender' name='gender' style='pointer-events: none'>";
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
<label class="input-group-text" for="">Specialty    :</label>';
                                        echo "<select class='select input-bordered select-ghost flex-grow' id='specialty' name='specialty' style='pointer-events: none'>";
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
<label class="">Remarks  :</label>
</div>
<textarea class="input-bordered textarea flex-grow" id="remarks" name="remarks" aria-label="With textarea">' . $remarks . '</textarea>
</div>';


                                        echo '<div class="input input-bordered flex items-center gap-2 mb-3 bg-gray-100">
<div class="input-group-text">
<span class="">Schedule Date and Time: </span>';
                                        if (!empty($schedule)) {
                                            echo "<input type='datetime-local' class='form-input flex-grow' style='font-size: 16px' name='schedule' id='schedule' value='" . date('Y-m-d\TH:i', strtotime($row['schedule'])) . "'>";
                                        } else {
                                            echo "<input type='datetime-local' class='form-input flex-grow' style='font-size: 16px' name='schedule' id='schedule'>";
                                        }
                                        echo "</div></div>";

                                        echo '<script>
var startDatetimeInput = document.getElementById("schedule");
var startDatetimeValue = ' . json_encode(!empty($schedule) ? htmlspecialchars($schedule) : "") . ';
if (startDatetimeValue !== "") {
startDatetimeInput.value = startDatetimeValue;
startDatetimeInput.disabled = true;
} else {
startDatetimeInput.disabled = false;
}
</script>';
                                    }
                                }
                                        ?>
                                        </div>

                                        <!-- </div> -->

                                        </form>



                                        <!-- Tab 2 -->

                                        <?php include_once 'view_sched2.php'; ?>


                                        <!-- Tab 3 -->
                                        <?php include_once 'view_sched3.php'; ?>


                                    </div>
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
                var age = today.getFullYear() - dobDate.getFullYear();
                var m = today.getMonth() - dobDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
                    age--;
                }
                document.getElementById("age").value = age;
            }
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