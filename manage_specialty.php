<?php include_once 'templates/template_header.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['iuid'])) {
    header("location: index.php");
    ob_end_flush();
    exit();
} ?>
<section class=" container m-3">
    <div class="flex justify-between items-center p-4">
        <h1 class="text-3xl font-bold text-zinc-900 ">List of Specialties</h1>
        <div class="flex items-center space-x-2">
            <img aria-hidden="true" alt="calendar-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📅" />
            <span class="text-zinc-500 dark:text-zinc-400"><?php echo date('d F Y'); ?></span>
        </div>
    </div>
    <hr />
    <div class="grid grid-col-2 md:grid-cols-6 gap-6">
        <div class="col-span-2 rounded-lg my-5">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div class="grid grid-cols-1 gap-4  w-full text-center">
                </div>
                <div class="grid grid-cols-1 gap-4  w-full text-center">
                    <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
                        <div class="card-body">
                            <div class="w-full">
                                <h1 class="text-2xl font-bold mx-auto my-5">Specialties</h1>
                                <form id="specialtyForm" class="text-left">
                                    <label class="font-bold text-lg">Specialty:</label>
                                    <input type="text" class="input input-bordered w-full " id="specialty">

                                    <button type="submit" class="btn btn-success mt-3 text-white">Add Specialty</button>
                                </form>
                                <form id="updateForm" class="text-left" style="display: none;">
                                    <input type="hidden" id="specialtyId">
                                    <label class="font-bold text-lg">Specialty:</label>
                                    <input type="text" id="updateSpecialty" class="input input-bordered w-full  mb-3">
                                    <button type="submit" class="btn btn-info" style="color: white">Update Specialty</button>
                                    <button type="button" id="cancelUpdate" class="btn btn-danger" style="color: white">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-4 rounded-lg my-5">
            <div class="card card-compact bg-base-100 w-full  h-full shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1 md:col-span-2 w-full text-center">
                            <div class="overflow-x-auto rounded-lg">
                                <table id="specialtyTable" class="table rounded-lg">
                                    <thead class="bg-[#00A651] text-white ">
                                        <tr class="mx-auto">
                                            <th>Specialty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <!-- foot -->
                                    <tfoot>
                                        <tr>
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
    new DataTable('#specialtyTable');
    $(document).ready(function() {
        loadspecialty();

        $("#specialtyForm").submit(function(event) {
            event.preventDefault();
            var specialty = $("#specialty").val();
            $.ajax({
                url: "api/specialty_action.php",
                type: "POST",
                data: {
                    action: "add",
                    name: name,
                    specialty: specialty
                },
                success: function(data) {
                    $("#specialty").val('');
                    loadspecialty();
                    Swal.fire('Success', 'Specialty added successfully', 'success');
                }
            });
        });

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
    });
</script>
<?php include_once 'templates/template_footer.php'; ?>