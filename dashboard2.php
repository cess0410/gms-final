<div class="col-xl-4 ">
    <div class="white_card card_height_100 mb_30 user_crm_wrapper">
        <div class="row">
            <div class="col-lg-6">
                <div class="single_crm">
                    <div class="crm_head d-flex align-items-center justify-content-between">
                        <div class="thumb">
                            <img src="vendors/contract.png" alt="" style="width: 20px!important; height: 20px!important">
                        </div>
                        <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                    </div>
                    <div class="crm_body">
                        <?php
                        $total_count = 0;
                        $sql = "SELECT COUNT(*) as total_count FROM tblinquiry";
                        $result = $db->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_count = $row['total_count'];
                            echo ' <h4>' . $total_count . '</h4>';
                        }
                        ?>
                        <p>Total Inquiries</p>
                        <button type="button" class="btn_1 mt-1 mb-1 w-100" onclick="window.location.href='list_inquiries.php'">VIEW</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single_crm ">
                    <div class="crm_head crm_bg_1 d-flex align-items-center justify-content-between">
                        <div class="thumb">
                            <img src="vendors/medical-staff.png" alt="" style="width: 20px!important; height: 20px!important">
                        </div>
                        <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                    </div>
                    <div class="crm_body">
                        <?php
                        $total_count = 0;
                        $sql = "SELECT COUNT(*) as total_count FROM tblinquiry WHERE status = 'Attended'";
                        $result = $db->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_count = $row['total_count'];
                            echo ' <h4>' . $total_count . '</h4>';
                        }

                        ?>
                        <p>Total Consult</p>
                        <button type="button" class="btn_1 mt-1 mb-1 w-100">VIEW</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single_crm">
                    <div class="crm_head crm_bg_2 d-flex align-items-center justify-content-between">
                        <div class="thumb">
                            <img src="vendors/management.png" alt="" style="width: 20px!important; height: 20px!important">
                        </div>
                        <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                    </div>
                    <div class="crm_body">
                        <?php
                        $total_count2 = 0;
                        $sql2 = "SELECT COUNT(*) as total_count FROM doctors";
                        $result2 = $db->query($sql2);

                        if ($result2 && $result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            $total_count2 = $row2['total_count'];
                            echo ' <h4>' . $total_count2 . '</h4>';
                        }

                        ?>
                        <p>Total Doctors</p>
                        <button type="button" class="btn_1 mt-1 mb-1 w-100" onclick="window.location.href='manage_doctor.php'">VIEW</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single_crm">
                    <div class="crm_head crm_bg_3 d-flex align-items-center justify-content-between">
                        <div class="thumb">
                            <img src="vendors/treatment.png" alt="" style="width: 20px!important; height: 20px!important">
                        </div>
                        <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                    </div>
                    <div class="crm_body">
                        <?php
                        $total_count3 = 0;
                        $sql3 = "SELECT COUNT(*) as total_count FROM specialties";
                        $result3 = $db->query($sql3);

                        if ($result3 && $result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();
                            $total_count3 = $row3['total_count'];
                            echo ' <h4>' . $total_count3 . '</h4>';
                        }

                        ?>
                        <p>Total Specialties</p>
                        <button type="button" class="btn_1 mt-1 mb-1 w-100" onclick="window.location.href='manage_specialty.php'">VIEW</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single_crm">
                    <div class="crm_head crm_bg_3 d-flex align-items-center justify-content-between">
                        <div class="thumb">
                            <img src="img/crm/sqr.svg" alt="">
                        </div>
                        <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                    </div>
                    <div class="crm_body">
                        <?php
                        $total_count = 0;
                        $rescheduled = 0;
                        $sql = "SELECT COUNT(*) as total_count FROM tblinquiry WHERE status = 'Rescheduled'";
                        $result = $db->query($sql);


                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total_count = $row['total_count'];
                            echo ' <h4>' . $total_count . '</h4>';
                        }

                        ?>
                        <p>Total Re-Scheduled</p>
                        <button type="button" class="btn_1 mt-1 mb-1 w-100" onclick="window.location.href='list_rescheduled.php'">VIEW</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single_crm">
                    <div class="crm_head d-flex align-items-center justify-content-between">
                        <div class="thumb">
                            <img src="vendors/contract.png" alt="" style="width: 20px!important; height: 20px!important">
                        </div>
                        <i class="fas fa-ellipsis-h f_s_11 white_text"></i>
                    </div>
                    <div class="crm_body">
                        <?php
                        $total_count = 0;
                        $sql = "SELECT DISTINCT name, COUNT(name) AS total_count 
                    FROM (
                        SELECT DISTINCT name, id, ROW_NUMBER() OVER (PARTITION BY name ORDER BY id) AS reschedule_number
                        FROM tblinquiry 
                        WHERE status = 'Rescheduled'
                    ) AS subquery 
                    WHERE reschedule_number <= 3 
                    GROUP BY name;";
                        $result = $db->query($sql);

                        if ($result && $result->num_rows > 0) {
                            // Fetch each row and display total_count
                            while ($row = $result->fetch_assoc()) {
                                $total_count = $row['total_count'];
                                echo '<h4>' . $total_count . '</h4>';
                            }
                        } else {
                            // Handle case where no rows are returned
                            echo '<h4>0</h4>'; // or any default value
                        }
                        ?>
                        <p>Total Inquiries</p>
                        <button type="button" class="btn_1 mt-1 mb-1 w-100" onclick="window.location.href='#'">VIEW</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>