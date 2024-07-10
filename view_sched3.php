<input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="History" />
<div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
    <div class="container mx-auto">
        <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical">
            <li>
                <div class="timeline-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end">
                    <time class="font-mono italic">Consultation Date: <?php echo date('F d, Y g:i A', strtotime($row['schedule'])); ?></time>
                    <div class="text-lg font-black font-mono italic">Scheduled Date: <?php echo date('F d, Y g:i A', strtotime($row['schedule'])); ?></div>
                    <?php
                    if ($row['status'] == '0') {
                        echo ' <span class="text-md font-black font-mono italic">Status :</span><time class="font-mono italic"> Attended</span><br>';
                    }
                    if ($row['status'] == '1') {
                        echo ' <span class="text-md font-black font-mono italic">Status :</span> <time class="font-mono italic">Cancelled</span><br>';
                        echo '<input type="hidden" name="cancelled" id="cancelled" value="' . $row['cancelled'] . '">';
                    }
                    if ($row['status'] == '2') {
                        echo ' <span class="text-md font-black font-mono italic">Status :</span> <time class="font-mono italic">Rescheduled</span><br>';
                    }
                    ?>
                    <?php $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                    $result1 = $db->query($sql);

                    if ($result1 && $result1->num_rows > 0) {
                        $specialty_row = $result1->fetch_assoc();
                        $specialty_name = $specialty_row['specialty'];
                        echo "<span class='text-md font-black font-mono italic'>Specialty : </span><time class='font-mono italic'>$specialty_name</span><br>";
                    }
                    ?>
                    <span class='text-md font-black font-mono italic'>Doctor : </span><time class='font-mono italic'><?php echo $row['doctor']; ?></span><br>

                        <?php
                        if ($row['status'] == '0') {
                            echo "<span class='text-md font-black font-mono italic'>Diagnose : </span><time class='font-mono italic'>" . $row['diagnose'] . "</time><br>";
                            echo "<span class='text-md font-black font-mono italic'>End Date : </span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['end_datetime'])) . "</time><br>";
                            if ($row['follow_up'] === '1') {
                                echo "<span class='text-md font-black font-mono italic'>Follow Up Date: </span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['follow_up'])) . "</time><br>";
                            }
                        }
                        if ($row['status'] == '1') {
                            echo "<span class='text-md font-black font-mono italic' >Cancelled Date:</span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['cancelled'])) . "</time><br>";
                        }
                        if ($row['status'] == '2') {
                            echo "<span class='text-md font-black font-mono italic' >Rescheduled Date:</span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['rescheduled'])) . "</time><br>";
                        }
                        ?>

                </div>
                <hr />
            </li>

            <li>
                <hr />
                <div class="timeline-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-end mb-10">
                    <?php

                    if ($row['follow_up'] == '1') {
                        echo '<div class="text-lg font-black font-mono italic ml-3">Follow Up Check-Up: ' . date('F d, Y g:i A', strtotime($row['follow_up'])) . '</div>';
                        $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                        $result1 = $db->query($sql);

                        if ($result1 && $result1->num_rows > 0) {
                            $specialty_row = $result1->fetch_assoc();
                            $specialty_name = $specialty_row['specialty'];
                            echo "<span class='text-md font-black font-mono italic'>Specialty : </span><time class='font-mono italic'>$specialty_name</span><br>";
                        }

                        $sql2 = "SELECT * FROM `doctors` WHERE id = '{$row['name']}'";
                        $result2 = $db->query($sql2);

                        if ($result2 && $result2->num_rows > 0) {
                            $doctor_row = $result2->fetch_assoc();
                            $doctor_name = $doctor_row['name'];
                            echo "<span class='text-md font-black font-mono italic'>Doctor : </span><time class='font-mono italic'>$doctor_name</span><br>";
                        }

                        if ($row['status'] == '0') {
                            echo ' <span class="text-md font-black font-mono italic">Status :</span><time class="font-mono italic"> Attended</span><br>';
                        }
                        if ($row['status'] == '1') {
                            echo ' <span class="text-md font-black font-mono italic">Status :</span> <time class="font-mono italic">Cancelled</span><br>';
                        }
                        if ($row['status'] == '2') {
                            echo ' <span class="text-md font-black font-mono italic">Status :</span> <time class="font-mono italic">Rescheduled</span><br>';
                        }

                        if ($row['status'] == '0') {
                            echo "<span class='text-md font-black font-mono italic'>Diagnose : </span><time class='font-mono italic'>" . $row['diagnose'] . "</time><br>";
                            echo "<span class='text-md font-black font-mono italic'>End Date : </span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['end_datetime'])) . "</time><br>";
                            if ($row['follow_up'] === '1') {
                                echo "<span class='text-md font-black font-mono italic'>Follow Up Date: </span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['follow_up'])) . "</time><br>";
                            }
                        }
                        if ($row['status'] == '1') {
                            echo "<span class='text-md font-black font-mono italic'>Cancelled Date:</span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['cancelled'])) . "</time><br>";
                        }
                        if ($row['status'] == '2') {
                            echo "<span class='text-md font-black font-mono italic'>Rescheduled Date:</span><time class='font-mono italic'>" . date('F d, Y g:i A', strtotime($row['rescheduled'])) . "</time><br>";
                        }
                    }
                    if ($row['status'] == '2') {
                        echo '<div class="text-lg font-black font-mono italic ml-3">Rescheduled Date: ' . date('F d, Y g:i A', strtotime($row['rescheduled'])) . '</div>';
                        $sql = "SELECT * FROM `specialties` WHERE id = '{$row['specialty']}'";
                        $result1 = $db->query($sql);

                        if ($result1 && $result1->num_rows > 0) {
                            $specialty_row = $result1->fetch_assoc();
                            $specialty_name = $specialty_row['specialty'];
                            echo "<span class='text-md font-black font-mono italic'>Specialty : </span><time class='font-mono italic'>$specialty_name</span><br>";
                        }
                    }

                    ?>
                </div>
                <hr />
            </li>

















            <!-- <li>
                <hr />
                <div class="timeline-middle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="timeline-start mb-10 md:text-end">
                    <time class="font-mono italic">2001</time>
                    <div class="text-lg font-black">iPod</div>
                    The iPod is a discontinued series of portable media players and multi-purpose mobile devices
                    designed and marketed by Apple Inc. The first version was released on October 23, 2001, about
                    8+1⁄2 months after the Macintosh version of iTunes was released. Apple sold an estimated 450
                    million iPod products as of 2022. Apple discontinued the iPod product line on May 10, 2022. At
                    over 20 years, the iPod brand is the oldest to be discontinued by Apple
                </div>
                <hr />
            </li> -->
        </ul>
    </div>
</div>