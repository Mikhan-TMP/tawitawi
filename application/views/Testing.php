<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }

        section {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #444;
        }

        select, input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        select:focus, input[type="submit"]:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 5px rgba(108, 99, 255, 0.4);
        }

        input[type="submit"] {
            background: #6c63ff;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #574dcf;
        }

        input[type="submit"]:active {
            background-color: #4c45b7;
        }

        .custom-datepicker {
            width: 95%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            background-color: #fff;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 10px;
        }

        .custom-datepicker:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 5px rgba(108, 99, 255, 0.4);
        }

        /* Optional: Add a custom icon to the date input field */
        .custom-datepicker::-webkit-calendar-picker-indicator {
            background-color: #6c63ff;
            border-radius: 4px;
            width: 25px;
            height: 25px;
        }

        /* Customize date input on Firefox */
        .custom-datepicker::-moz-calendar-picker-indicator {
            background-color: #6c63ff;
            border-radius: 4px;
            width: 25px;
            height: 25px;
        }


        @media (max-width: 600px) {
            section {
                padding: 15px;
            }

            h1 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <section>
        <h1>Test Student Attendance</h1>
        <form method='post' action="<?= base_url('kiosk/TimeInOutforTest') ?>">
            <label>Select Student</label>
            <?php 
                $students = $this->db->get('student')->result_array();
                $selected_code = $this->input->post('code');
            ?>
            <select name="code" id="student">
                <?php foreach ($students as $student) : ?>
                    <option value="<?= $student['pin'] ?>" <?= $selected_code == $student['pin'] ? 'selected' : '' ?>>
                        <?= $student['pin'] . ' - ' . $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="code_type" value="pin">
            <input type="hidden" name="kiosk_id" value="1">
            <input type="submit" name="submit" value="Submit">
        </form>
    </section>

    <section>
        <h1>Test Reservation</h1>
        <form method='post' action="<?= base_url('kiosk/reservationTesting') ?>">
            <!-- STUDENT -->
            <label>Select Student</label>
            <?php 
                $students = $this->db->get('student')->result_array();
                $selected_code = $this->input->post('code');
            ?>
            <select name="code" id="student">
                <?php foreach ($students as $student) : ?>
                    <option value="<?= $student['pin'] ?>" <?= $selected_code == $student['pin'] ? 'selected' : '' ?>>
                        <?= $student['pin'] . ' - ' . $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- DATE -->
            <label> Select Date </label>
            <input class="custom-datepicker" type="date" name="date" placeholder= "<?php echo date('Y-m-d') ?>"  class="form-control form-control-sm" required  >
            <!-- AREA -->
            <label>Select Floor and Area</label>
            <?php 
                $areas = $this->db->get('area')->result_array();
                $selected_area = $this->input->post('room');
            ?>
            <select name="room" id="room">
                <option selected value="" disabled>Please Select</option>
                <?php foreach ($areas as $area) : ?>
                    <option value="<?= $area['room'] ?>" <?= $selected_area == $area['room'] ? 'selected' : '' ?> data-floor="<?= $area['floor'] ?>">
                        <?= $area['floor'] . ' - ' . $area['room'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <!-- SEAT -->
            <label>Select Seat</label>
            <select name="slot" id="seat">
            </select>
            <!-- Duration -->
            <label>Select Duration</label>
            <select name="duration" id="duration">
            </select>
            <!-- TIME -->
            <label> Select Start Time </label>
            <select name="stime" id="start_time">
            </select>
            <label> Select End Time </label>
            <select name="etime" id="end_time">
            </select>


            <!-- <input type="text" name="forRoom" id="forRoom">
            <input type="text" name="forDate" id="forDate">
            <input type="text" name="forSeat" id="forSeat"> -->
            <input type="hidden" name="device" value="1">
            <input type="hidden" name="floor" id="floor">
            <input type="hidden" name="user_id" value="0">
            <input type="hidden" name="code_type" value="pin">
            <input type="submit" name="submit" value="Submit">
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#room').on('change', function () {
                const selectedRoom = $(this).val();
                const selectedFloor = $(this).find(':selected').data('floor');

                if (selectedRoom && selectedFloor) {
                    $.ajax({
                        url: '<?= base_url('/kiosk/getSeatstest') ?>',
                        method: 'POST',
                        data: {
                            room: selectedRoom,
                            floor: selectedFloor
                        },
                        success: function (response) {
                            const data = JSON.parse(response); // Response is an array of objects
                            const seatData = data[0]; // Access the first item in the array
                            const min_slot = parseInt(seatData.min_slot); // Convert to integer
                            const max_slot = parseInt(seatData.max_slot); // Convert to integer

                            if (data.length > 0) {
                                // Generate seat options
                                const seatNumbers = Array.from({ length: seatData.slotnumber }, (_, i) => i + 1);
                                $('#seat').empty().append('<option selected value="" disabled>Please select seat</option>');
                                seatNumbers.forEach(number => {
                                    $('#seat').append(`<option value="${number}">${number}</option>`);
                                });

                                // Generate duration options
                                const durations = Array.from({ length: max_slot - min_slot + 1 }, (_, i) => i + min_slot);
                                $('#duration').empty().append('<option selected value="" disabled>Please select duration</option>');
                                durations.forEach(duration => {
                                    $('#duration').append(`<option value="${duration}">${duration} hour${duration > 1 ? 's' : ''}</option>`);
                                });
                            } else {
                                $('#seat').empty().append('<option selected value="" disabled>No available seats</option>');
                                $('#duration').empty().append('<option selected value="" disabled>No available duration</option>');
                            }
                        },
                        error: function () {
                            alert('Error fetching seats');
                        }
                    });
                } else {
                    $('#seat').empty().append('<option selected value="" disabled>Please select a room first</option>');
                    $('#duration').empty().append('<option selected value="" disabled>Please select a room first</option>');
                }
            });
        });
        
    </script>

    <script>
        const roomSelect = document.getElementById('room');
        const floorInput = document.getElementById('floor');
        const forRoomInput = document.getElementById('forRoom');
        const forDateInput = document.getElementById('forDate');
        const forSeatInput = document.getElementById('forSeat');

        const seatSelect = document.getElementById('seat');

        roomSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            floorInput.value = selectedOption.getAttribute('data-floor');
            forRoomInput.value = selectedOption.value
            forDateInput.value = document.querySelector('input[name="date"]').valueAsDate.toISOString().split('T')[0];
        });

        seatSelect.addEventListener('change', function () {
            forSeatInput.value = this.value;
        });
        function updateEndTime() {
        var start_time = parseInt($('#start_time').val());
        var duration = parseInt($('#duration').val());
        
        if (start_time && duration) {
            // Calculate the maximum end time based on the duration
            var end_time_limit = start_time + duration;
            $('#end_time').empty(); // Clear previous end times

            // Generate end time options from start_time+1 to start_time+duration
            for (var i = start_time + 1; i <= end_time_limit; i++) {
                $('#end_time').append('<option value="' + i + '">' + i + '</option>');
            }
        } else {
            $('#end_time').empty();
        }
    }
    $(document).ready(function () {
    // Event listener for start time change
    $('#start_time').on('change', function () {
        updateEndTime();
    });

    // Event listener for duration change
    $('#duration').on('change', function () {
        updateEndTime();
    });

    // Function to update end time options based on start time and duration
    function updateEndTime() {
        var start_time = parseInt($('#start_time').val());
        var duration = parseInt($('#duration').val());
        
        if (start_time && duration) {
            // Calculate the actual end time based on the duration
            var end_time = start_time + duration;  // This gives the correct time (e.g., 8 + 2 = 10)
            $('#end_time').empty(); // Clear previous end times

            // Add the calculated end time directly (e.g., 10 for a duration of 2)
            $('#end_time').append('<option value="' + end_time + '">' + end_time + '</option>');
        } else {
            $('#end_time').empty();
        }
    }

    // Load available time slots dynamically
    function loadTimeSlots() {
        const start_time_options = [];
        const end_time_options = [];

        for (let i = 8; i <= 18; i++) { // Example range: 8 AM to 6 PM
            // Use actual time for start_time
            start_time_options.push({ time: i, value: i });

            // End time (End time will always be 1 hour after start time)
            end_time_options.push({ time: i + 1, value: i + 1 });
        }

        // Clear current options and add new ones for start_time and end_time
        $('#start_time').empty();
        start_time_options.forEach(function (option) {
            $('#start_time').append('<option value="' + option.value + '">' + option.time + '</option>');
        });

        $('#end_time').empty();
        end_time_options.forEach(function (option) {
            $('#end_time').append('<option value="' + option.value + '">' + option.time + '</option>');
        });

        // Initial update for end time
        updateEndTime();
    }

    // Call this function to initialize the time options
    loadTimeSlots();
});

    </script>
    <?php
        $this->load->helper('toast');
        foreach (['success', 'warning', 'error'] as $type) {
            if ($this->session->flashdata($type)) {
                echo getAlertMessages($type, $this->session->flashdata($type));
                $this->session->unset_userdata($type);
            }
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
