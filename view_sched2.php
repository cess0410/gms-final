<?php
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


<input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Status" />
<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
    <div class="input input-bordered flex items-center gap-2 mb-3 ">
        <div class="input-group-text">
            <span class="">Name :</span>
        </div>
        <input value="<?php echo $name; ?>" name="name" class="form-input flex-grow">
    </div>
    <div class='input input-bordered flex items-center gap-2 mb-3'>
        <div class='input-group-text'>
            <span>Scheduled Date: <br></span>
        </div>
        <?php if (!empty($schedule)) : ?>
            <input type='datetime-local' class='form-input' style='font-size: 16px' name='schedule' id='schedule' value='<?php echo $schedule; ?>' readonly>
        <?php else : ?>
            <input type='datetime-local' class='form-input flex-grow' style='font-size: 16px' name='schedule' id='schedule' readonly>
        <?php endif; ?>
    </div>

    <div class="input-bordered flex items-center gap-2 mb-3">
        <label class="input-group-text" for="">Specialty : </label>
        <select class='select input-bordered select-ghost flex-grow' id='specialty' name='specialty' style='pointer-events: none'>
            <?php echo $specialty_options; ?>
        </select>
    </div>

    <form id="add">
        <div class="input-bordered flex items-center gap-2 mb-3">
            <label class="input-group-text" for="">Status :</label>
            <select class="select input-bordered select-ghost flex-grow" id="consult" name="status">
                <option value="">--Select Status--</option>
                <option value="0">Attended</option>
                <option value="1">Cancelled</option>
                <option value="2">Rescheduled</option>
            </select>
        </div>

        <div id="doctorField" style="display: none;">
            <div class="input-bordered flex items-center gap-2 mb-3">
                <label class="input-group-text" for="">Doctor :</label>
                <select class="select input-bordered select-ghost flex-grow" id="specialty" name="doctor">';
                    <?php echo $doctorOptionsString; ?>
                </select>
            </div>
        </div>

        <div id="diagnoseField" style="display: none;">
            <div class="input input-bordered flex items-center gap-2 mb-3 ">
                <span class="">Diagnose :</span>
                <input id="diagnose" class="form-control" name="diagnose" value="<?php echo $diagnose; ?>">
            </div>
        </div>

        <div id="attendedField" style="display: none;">
            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span class="">End Date :</span>
                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" value="<?php echo $end_datetime; ?>">
            </div>
        </div>

        <div id="rescheduledDateField" style="display: none;">
            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span class="">Rescheduled Date :</span>
                <input type="datetime-local" class="form-control" id="rescheduled" name="rescheduled" value="<?php echo $rescheduled; ?>">
            </div>
        </div>

        <div id="FollowUpField">
            <div class='input input-bordered flex items-center gap-2 mb-3 align-middle'>
                <label class="label cursor-pointer">
                    <span class="label-text ml-5 pr-5">No Follow Up</span>
                    <input type="radio" name="radio-10" class="radio radio-success" value="0" checked />
                </label>
                <label class="label cursor-pointer">
                    <span class="label-text ml-5 pr-5">Follow Up</span>
                    <input type="radio" name="radio-10" class="radio radio-success" value="1" />
                </label>
            </div>
        </div>

        <div id="FollowUpDateField" style="display: none;">
            <div class="input input-bordered flex items-center gap-2 mb-3">
                <span>Date:</span>
                <input type="datetime-local" class="form-control" id="followup" name="followup">
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <button class="btn btn-accent ml-3" type="submit">Save</button>
        <button class="btn btn-accent ml-2" onclick="window.history.back();">Cancel</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#consult').on('change', function() {
            var status = $(this).val();

            if (status === '0') {
                $('#attendedField').show();
                $('#diagnoseField').show();
                $('#doctorField').show();
                $('#FollowUpField').hide();
                $('#FollowUpDateField').hide();
                $('#rescheduledDateField').hide();
            } else if (status === '2') {
                $('#rescheduledDateField').show();
                $('#FollowUpField').show();
            } else {
                $('#attendedField').hide();
                $('#diagnoseField').hide();
                $('#doctorField').hide();
                $('#rescheduledDateField').hide();
                $('#FollowUpField').hide();
                $('#FollowUpDateField').hide();
            }
        });

        $('input[name="radio-10"]').on('change', function() {
            var value = $(this).val();

            if (value === '1') {
                $('#FollowUpDateField').show();
            } else {
                $('#FollowUpDateField').hide();
            }
        });

        $('#add').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'api/save_sched.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    window.location.href = 'list_inquiries.php';
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 400) {
                        // Bad request
                        alert('An error occurred while saving. Please check your data and try again.');
                    } else if (xhr.status === 500) {
                        // Internal server error
                        alert('An error occurred while saving. Please try again later.');
                    } else {
                        // Other errors
                        console.error(xhr.responseText);
                        alert('An unexpected error occurred. Please try again.');
                    }
                }
            });
        });
    });
</script>