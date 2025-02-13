
<style>
    #select-floor-area {
        display: none;
    }
    #select-area{
        display: none;
    }
    #select-final-preferences{
        display: none;
    }
</style>

<?php 
echo"RESERVATION INFO: ";
print_r($this->session->userdata('reservation_info'));
echo"<br>AREA INFO: ";
print_r($this->session->userdata('area_info'));
echo"<br>FLOOR SELECTED: ";
if($this->session->userdata('area_info')){
    print_r($this->session->userdata('area_info')[0]['floor']);
}
echo"<br>Seat INFO: ";
print_r($this->session->userdata('seat_info'));

$area_info = $this->session->userdata('area_info') ?? "";
$seat_info = $this->session->userdata('seat_info') ?? "";
$times = [];
if ($area_info != null && $seat_info != null) {
    foreach ($seat_info as $seat) {
        foreach ($area_info as $area) {
            if ($seat['Room'] == $area['room'] && $seat['Floor'] == $area['floor']) {
                $opentime = strtotime($area['opentime']);
                $closetime = strtotime($area['closetime']);
                $minimum_hours = $area['min_slot'];
                $maximum_hours = $area['max_slot'];
    
                while ($opentime <= $closetime) {
                    $times[] = ['time' => date('H:i', $opentime)];
                    $opentime = strtotime('+1 hour', $opentime); // Adjust interval as needed
                }
            }
        }
    }
}
?>

<a href="<?= base_url('master/student'); ?>" class="btn btn-secondary btn-icon-split mb-4" style="margin-left: 50px;">
    <span class="icon text-white">
        <i class="fas fa-chevron-left"></i>
    </span>
    <span class="text">Back</span>
</a>
<a href="javascript:void(0)" class="btn btn-secondary btn-icon-split mb-4" style="margin-left: 50px;" onclick="clearAllUserData()">
    <span class="icon text-white">
        <i class="fas fa-chevron-left"></i>
    </span>
    <span class="text">Clear All</span>
</a>



        <div class="d-flex">
            <div class="select-student" id ="select-student">
                <div class="container">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Select Student</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('manual/HttpGetUserInfo') ?>" method="POST">
                                <div class="form-group">
                                    <select name="studentID" id="student" class="form-control">
                                        <option value="">Select Student</option>
                                        <?php foreach ($students as $student) : ?>
                                            <option value="<?= $student['srcode'] ?>" <?= (isset($this->session->userdata('student_info')['srcode']) && $this->session->userdata('student_info')['srcode'] == $student['srcode']) ? 'selected' : '' ?>>
                                                <?= $student['srcode'] . ' - ' . $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- submit -->
                                <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
                            </form>
                        </div>
                    </div>
                <div>
            </div>
        </div>
</div>

<div>
    <div class="select-area" id="select-floor-area" style="width: 500px">
        <div class="container">
            <div class="card shadow mb-4" id="select-floor">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Select Floor</h6>
                </div>
                <div class="card-body" >
                    <form action="<?= base_url('manual/HttpGetAreaList')?>" method="POST">
                        <div class="form-group">
                            <select name="floor" id="floor" class="form-control">
                                <option selected disabled value="">Select Floor</option>
                                <?php foreach ($floors as $floor) : ?>
                                    <option value="<?= $floor['floor'] ?>" <?= $floor['floor'] == $this->input->post('floor') ? 'selected' : '' ?>>
                                        <?= $floor['floor']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
                    </form>                       
                </div>
            </div>
            <div class="card shadow mb-4"  id="select-area">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Select Area and Date</h6>
                </div>
                <div class="card-body">  
                    <form action="<?= base_url('manual/HttpGetSeatList')?>" method="GET">
                        <div class="form-group">
                            <select name="room" id="room" class="form-control" >
                                <?= $area = $this->session->userdata('area_info');?>
                                <option selected disabled value="">Select Area</option>
                                    <?php if ($area['floor'] == $this->input->post('floor')) : ?>
                                    <option value="<?= $area[0]['room'] ?>" <?= $area[0]['room'] == $this->input->post('room') ? 'selected' : '' ?>>
                                        <?= $area[0]['room']?>
                                    </option>
                                    <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- date picker -->
                            <input type="date" name="date" id="date" class="form-control" value="<?= $this->input->get('date') ?>">
                        </div>
                        <!-- submit -->
                        <input type="hidden" name="floor" value="<?=$this->session->userdata('area_info')[0]['floor']?>"/>
                        <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
                    </form>
                </div>
            </div>
        <div>
    </div>
</div>

<div class="select-final-preferences" id="select-final-preferences">
    <div class="container">
        <!-- time picker -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Select Time</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('manual/HttpPostSeatReservation')?>" method="POST">
                    <div class="form-group">
                        <label>Start Time: </label>
                        <select name="stime" id="stime" class="form-control" onchange="updateEndTime()">
                            <option selected disabled value="">Select Time</option>
                            <?php $counter = 0; foreach ($times as $time) : $counter++;?>
                                <option value="<?= $counter ?>" <?= $counter == $this->input->get('time') ? 'selected' : '' ?>>
                                    <?= $time['time']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>End Time: </label>
                        <select name="etime" id="etime" class="form-control">
                            <option selected disabled value="">Select Time</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select a Seat</label>
                        <select name="slot" id="seat" class="form-control">
                            <option selected disabled value="">Select Seat</option>
                            <?php 
                            // Get seat data from session
                            $seat_info = $this->session->userdata('seat_info');

                            // Check if seat_info exists and loop through the seats
                            if (!empty($seat_info)) :
                                foreach ($seat_info as $seat) :
                                    // Create option for each seat
                                    ?>
                                    <option value="<?= $seat['Slot'] ?>" <?= $seat['Slot'] == $this->input->get('seat') ? 'selected' : '' ?>>
                                        <?= $seat['Room'] . ' - ' . $seat['Floor'] . ' - Seat ' . $seat['Slot'] ?>
                                    </option>
                                    <?php
                                endforeach;
                            else :
                                echo '<option value="">No seats available</option>';
                            endif;
                            ?>
                        </select>

                    <input type="hidden" name="device" value="lib-manual"/>
                    <input type="hidden" name="user_id" value="1"/>
                    <input type="hidden" name="code_type" value="birthdate"/>
                    <input type="hidden" name="code" value="<?= $this->session->userdata('reservation_info')['pin'] ?? null ?>"/>
                    <input type="hidden" name="floor" value="<?= $this->session->userdata('seat_info')[0]['Floor'] ?? null ?>"/>
                    <input type="hidden" name="room" value="<?= $this->session->userdata('seat_info')[0]['Room'] ?? null ?>"/>
                    <input type="hidden" name="date" value="<?= $this->session->userdata('seat_info')[0]['date'] ?? null ?>"/>
                    <input type="hidden" name="studentID" value="<?= $this->session->userdata('reservation_info')['srcode'] ?? null ?>"/>
                    <button type="submit" class="btn btn-primary" style="float:right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>


<div class="reservation-info">
            <div class="container">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Reservation Information</h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $reservation_info = $this->session->userdata('reservation_info');
                        if ($reservation_info) :
                            ?>
                            <p><strong>Student ID:</strong> <?= $reservation_info['srcode'] ?></p>
                            <p><strong>First Name:</strong> <?= $reservation_info['first_name'] ?></p>
                            <p><strong>Middle Name:</strong> <?= $reservation_info['middle_name'] ?></p>
                            <p><strong>Last Name:</strong> <?= $reservation_info['last_name'] ?></p>
                            <p><strong>Birthdate:</strong> <?= $reservation_info['birthdate'] ?></p>
                            <p><strong>Gender:</strong> <?= $reservation_info['gender'] ?></p>
                            <p><strong>College:</strong> <?= $reservation_info['college'] ?></p>
                            <p><strong>Course:</strong> <?= $reservation_info['course'] ?></p>
                        <?php else : ?>
                            <p><strong>Student ID:</strong> N/A</p>
                            <p><strong>First Name:</strong> N/A</p>
                            <p><strong>Middle Name:</strong> N/A</p>
                            <p><strong>Last Name:</strong> N/A</p>
                            <p><strong>Birthdate:</strong> N/A</p>
                            <p><strong>Gender:</strong> N/A</p>
                            <p><strong>College:</strong> N/A</p>
                            <p><strong>Course:</strong> N/A</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
</div>
    <?php
        $this->load->helper('toast');
        foreach (['success', 'warning', 'error'] as $type) {
            if ($this->session->flashdata($type)) {
                echo getAlertMessages($type, $this->session->flashdata($type));
                $this->session->unset_userdata($type);
                // $this->session->unset_userdata('student_info');
            }
        }
    ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Check if reservation data exists in session
        <?php if ($this->session->userdata('reservation_info')) : ?>
            document.getElementById("select-floor-area").style.display = "block";
            document.getElementById("select-student").style.display = "none";
        <?php endif; ?>
        <?php if ($this->session->userdata('area_info')) : ?>
            document.getElementById("select-area").style.display = "block";
            document.getElementById("select-floor").style.display = "none";
        <?php endif; ?>
        <?php if ($this->session->userdata('seat_info')) : ?>
            document.getElementById("select-area").style.display = "none";
            document.getElementById("select-final-preferences").style.display = "block";
        <?php endif; ?>
    });

    function clearAllUserData() {
    fetch("<?= base_url('manual/clearAllSetData') ?>", { method: "POST" })
        .then(() => window.location.reload());
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startTimeSelect = document.getElementById("stime");
        const endTimeSelect = document.getElementById("etime");

        // Retrieve min and max reservation hours from PHP
        const minHours = <?= $minimum_hours ?>;
        const maxHours = <?= $maximum_hours ?>;

        function updateEndTime() {
            let selectedStartIndex = parseInt(startTimeSelect.value); // Get the selected value (which is the index)

            // Clear previous selections
            endTimeSelect.innerHTML = "";

            // Populate end time options within the allowed range
            for (let i = selectedStartIndex + minHours; i <= selectedStartIndex + maxHours; i++) {
                let option = document.createElement("option");

                // Ensure the option exists in the startTimeSelect
                if (startTimeSelect.options[i]) {
                    option.value = i; // Assign index as value
                    option.text = startTimeSelect.options[i].text; // Use the same time text
                    endTimeSelect.appendChild(option);
                }
            }

            // Select the minimum possible end time by default
            if (endTimeSelect.options.length > 0) {
                endTimeSelect.selectedIndex = 0;
            }
        }

        // Attach event listener
        startTimeSelect.addEventListener("change", updateEndTime);
    });
</script>
