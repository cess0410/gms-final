</div>
</div>
<link rel="stylesheet" href="assets/css/custom.css">
<style>
    .menu li a.active {
        color: green !important;
        background: #f8fafc !important;

    }
</style>
<div class="drawer-side">
    <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>

    <ul id="sidebar_menu" class="menu bg-base-200 min-h-full w-80 p-4">
        <li>
            <div class="avatar">
                <div class="w-64 my-5 rounded">

                    <img src="vendors/logo.png" style="object-fit: inherit!important;" />
                </div>
            </div>
        </li>
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
        <li><a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/dashboard.png" alt="">
                </div>
                <span class="ml-3 text-base">Dashboard</span>
            </a>
        </li>
        <li><a href="inquiry.php" class="<?= $current_page == 'inquiry.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/contract.png" alt="">
                </div>
                <span class="ml-3 text-base">Inquiry</span>
            </a>
        </li>
        <li><a href="list_inquiries.php" class="<?= $current_page == 'list_inquiries.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/checklist.png" alt="">
                </div>
                <span class="ml-3 text-base">List of Inquiries</span>
            </a>
        </li>
        <!-- <li><a href="view_calendar.php" class="<?= $current_page == 'view_calendar.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/calendar.png" alt="">
                </div>
                Calendar
            </a>
        </li> -->
        <li><a href="list_receivers.php" class="<?= $current_page == 'list_receivers.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/report.png" alt="">
                </div>
                <span class="ml-3 text-base"> List of Receivers</span>
            </a>
        </li>
        <li><a href="manage_specialty.php" class="<?= $current_page == 'manage_specialty.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/treatment.png" alt="">
                </div>
                <span class="ml-3 text-base">Manage Specialization</span>
            </a>
        </li>
        <li><a href="manage_doctor.php" class="<?= $current_page == 'manage_doctor.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/management.png" alt="">
                </div>
                <span class="ml-3 text-base">Manage Doctor</span>
            </a>
        </li>
        <li><a href="manage_schedule.php" class="<?= $current_page == 'manage_schedule.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/timetable.png" alt="">
                </div>
                <span class="ml-3 text-base">Manage Schedule</span>
            </a>
        </li>
        <li><a href="logs.php" class="<?= $current_page == 'logs.php' ? 'active' : '' ?>">
                <div class="w-10 rounded-full">
                    <img src="vendors/log.png" alt="">
                </div>
                <span class="ml-3 text-base">Logs</span>
            </a>
        </li>
        <!-- <li>
            <div class="flex items-center space-x-1 my-5">
                <div class="w-10 rounded-full">
                    <img aria-hidden="true" alt="calendar-icon" src="https://openui.fly.dev/openui/24x24.svg?text=📅" />
                </div>
                <span class="text-zinc-500 dark:text-zinc-400"><?php echo date('d F Y'); ?></span>
            </div>
        </li> -->










    </ul>

</div>
</body>

</html>