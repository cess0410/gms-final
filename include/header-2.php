<style>
    .header_iner {
        border-bottom: none !important;
    }
</style>
</style>

<div class="container-fluid g-0">
    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div class="line_icon open_miniSide d-none d-lg-block">
                    <img src="vendors/line_img.png" alt="">
                </div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="profile_info">
                        <img src="vendors/LOGO.png" alt="#">
                        <div class="profile_info_iner">
                            <div class="profile_author_name">
                                <h5><?= $_SESSION['ifname'] ?></h5>
                            </div>
                            <div class="profile_info_details">
                                <a href="logout.php" name="logout" type="submit">Log Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>