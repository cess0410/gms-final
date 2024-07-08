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
$sql = "SELECT * FROM specialties";
$result = mysqli_query($db, $sql);
$specialties = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch doctors for the table
$sql = "SELECT * FROM doctors";
$result = mysqli_query($db, $sql);
$doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<section class=" container m-3">
    <div class="flex justify-between items-center p-4">
        <h1 class="text-3xl font-bold text-zinc-900 ">List of Doctors</h1>
        <div class="flex items-center space-x-2">
            <img aria-hidden="true" alt="calendar-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📅" />
            <span class="text-zinc-500 dark:text-zinc-400"><?php echo date('d F Y'); ?></span>
        </div>
    </div>
    <hr />
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="col-span-1 rounded-lg my-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="grid grid-cols-1 gap-4  w-full text-center">
                </div>
                <div class="grid grid-cols-1 gap-4  w-full text-center">
                    <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
                        <div class="card-body">
                            <div class="w-full">
                                <h1 class="text-2xl font-bold mx-auto my-5">Doctors</h1>
                                <form id="doctorForm" class="text-left">
                                    <label>Name:</label>
                                    <input type="text" class="input input-bordered w-full  mb-3" id="name">
                                    <label>Specialty:</label>
                                    <select id="specialty" class="select input-bordered select-ghost flex-grow  w-full">
                                        <?php foreach ($specialties as $specialty) : ?>
                                            <option value="<?php echo $specialty['id']; ?>"><?php echo $specialty['specialty']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-success mt-3">Add Doctor</button>
                                </form>
                                <form id="updateForm" class="text-left" style="display: none;">
                                    <input type="hidden" id="doctorId">
                                    <label>Name:</label>
                                    <input type="text" id="updateName" class="input input-bordered w-full  mb-3">
                                    <label>Specialty:</label>
                                    <select id="updateSpecialty" class="select input-bordered select-ghost flex-grow w-full">
                                        <?php foreach ($specialties as $specialty) : ?>
                                            <option value="<?php echo $specialty['id']; ?>"><?php echo $specialty['specialty']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-info mt-3">Update Doctor</button>
                                    <button type="button" id="cancelUpdate" class="btn btn-error mt-3">Cancel</button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1 rounded-lg my-5">
            <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1 md:col-span-2 w-full text-center">
                            <div class="overflow-x-auto rounded-lg">
                                <table id="doctorTable" class="table rounded-lg">
                                    <thead class="bg-[#00A651] text-white ">
                                        <tr class="mx-auto">
                                            <th>Name</th>
                                            <th>Specialty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($doctors as $row) : ?>
                                            <tr>
                                                <td class="doctorName" style='color: black; font-weight: 400'><?= $row['name']; ?></td>
                                                <?php
                                                $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                                                $result1 = $db->query($sql);

                                                if ($result1 && $result1->num_rows > 0) {
                                                    $specialty_row = $result1->fetch_assoc();
                                                    $specialty_name = $specialty_row['specialty'];
                                                    echo "<td class='doctorSpecialty' style='color: black; font-weight: 400'>$specialty_name</td>";
                                                }
                                                ?>


                                                <td class="text-right">
                                                    <button class='editBtn btn btn-info' data-id="<?= $row['id']; ?>">Edit</button>
                                                    <button class='deleteBtn btn btn-error' data-id="<?= $row['id']; ?>">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <!-- foot -->
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Specialty</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<script>
    $(document).ready(function() {

        new DataTable('#doctorTable');

        // Add Doctor
        $("#doctorForm").submit(function(event) {
            // event.preventDefault();
            // var id = $("#doctorId").val();
            var name = $("#name").val();
            var specialty = $("#specialty").val();
            $.ajax({
                url: "api/doctor_action.php",
                type: "POST",
                data: {
                    action: "add",
                    name: name,
                    specialty: specialty
                },
                success: function(data) {
                    $("#name").val('');
                    $("#specialty").val('');
                    // loadDoctors();
                    location.reload();
                }
            });
        });

        // Edit Doctor
        $(document).on("click", ".editBtn", function() {
            var id = $(this).data("id");
            var name = $(this).closest("tr").find(".doctorName").text();
            var specialty = $(this).closest("tr").find(".doctorSpecialty").text();
            $("#doctorId").val(id);
            $("#updateName").val(name);
            $("#updateSpecialty").val(specialty);
            $("#doctorForm").hide();
            $("#updateForm").show();
        });

        // Update Doctor
        $("#updateForm").submit(function(event) {
            // event.preventDefault();
            var id = $("#doctorId").val();
            var name = $("#updateName").val();
            var specialty = $("#updateSpecialty").val();
            $.ajax({
                url: "api/doctor_action.php",
                type: "POST",
                data: {
                    action: "update",
                    id: id,
                    name: name,
                    specialty: specialty
                },
                success: function(data) {
                    $("#updateForm").hide();
                    $("#doctorForm").show();
                    location.reload();
                    location.reload();
                    // loadDoctors();

                }
            });
        });

        $("#cancelUpdate").click(function() {
            $("#updateForm").hide();
            $("#doctorForm").show();
        });

        $(document).on("click", ".deleteBtn", function() {
            var id = $(this).data("id");
            $.ajax({
                url: "api/doctor_action.php",
                type: "POST",
                data: {
                    action: "delete",
                    id: id
                },
                success: function(data) {
                    location.reload();
                    // loadDoctors();

                }
            });
        });

        function loadDoctors() {
            $.ajax({
                url: "api/doctor_action.php",
                type: "GET",
                data: {
                    action: "fetch"
                },
                success: function(data) {
                    $("#doctorTable tbody").html(data);
                    new DataTable('#doctorTable');
                }
            });
        }
    });
</script>

<?php include_once 'templates/template_footer.php'; ?>