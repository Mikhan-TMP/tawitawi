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
    <a href="<?= base_url('master/student'); ?>" class="btn btn-secondary btn-icon-split mb-1" style="margin-left: 50px;">
        <span class="icon text-white">
            <i class="fas fa-chevron-left"></i>
        </span>
        <span class="text">Back</span>
    </a>
    <div class="cont d-flex m-5 " style="gap:10px; flex-wrap: wrap flex-direction: column; " >
        <section style=" min-height: 15vh; max-height: 40vh; background: linear-gradient(180deg, #031084, #000748);" class="text-light mt-0">
            <h1 class="text-light">Manual Student Attendance</h1>
            <form method='post' action="<?= base_url('kiosk/TimeInOutforTest') ?>">
                <div class="inputs" style="display:flex; flex-direction: column;">
                    <label>Enter Student ID or Name</label>
                    <input class="mb-3"type="text" name="code" id="code" style="width: 95%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; outline: none; transition: border-color 0.3s ease, box-shadow 0.3s ease;">
                    <label>Select Student</label>
                    <?php 
                        $students = $this->db->get('student')->result_array();
                        $selected_code = $this->input->post('code');
                    ?>
                    <select name="code" id="student">
                        <option selected disabled value="">No Student Selected</option>
                        <?php foreach ($students as $student) : ?>
                            <option value="<?= $student['pin'] ?>" 
                                data-name="<?= strtolower($student['last_name'] . ' ' . $student['first_name'] . ' ' . $student['middle_name']) ?>"
                                <?= $selected_code == $student['pin'] ? 'selected' : '' ?>>
                                <?= $student['pin'] . ' - ' . $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="hidden" name="code_type" value="pin">
                <input type="hidden" name="kiosk_id" value="1">
                <input type="submit" name="submit" value="Submit">
            </form>
        </section>

        <div>
            <!-- TABLE OF ATTENDNACE -->
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4" style="min-height: 543px; border-radius:15px;">
                                <form action="" method="POST">
                                    <div class="card-header py-3 d-flex justify-content-between"
                                        style="border-radius:15px 15px 0 0; background: linear-gradient(180deg, #031084, #000748); ">
                                        <h6 class="m-0 text-light" style="font-size:1.5rem; font-family: 'Inter', sans-serif;">
                                            Attendance Table</h6>
                                        <div class="div" style ="display: flex; flex-wrap: wrap; gap: 10px" >
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                                <thead style="color: #272727; font-weight: 500;">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>ID</th>
                                                        <th>College</th>
                                                        <th>Course</th>
                                                        <th>Kiosk</th>
                                                        <th>Time In</th>
                                                        <th>Time Out</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="color: #272727;">
                                                    <?php foreach ($attendance as $attend) : ?>
                                                    <tr>
                                                        <td><?= isset($attend['username']) ? $attend['username'] : "no data"; ?>
                                                        </td>
                                                        <!-- <td>
                                                            <?php
                                                                $srcode = $attend['srcode'];
                                                                $student = $this->db->get_where('student', ['srcode' => $srcode])->row_array();
                                                                echo isset($student['pin']) ? $student['pin'] : "-";
                                                                ?>
                                                        </td> -->
                                                        <td><?= isset($attend['category']) ? $attend['category'] : "no data"; ?></td>
                                                        <td><?= isset($attend['srcode']) ? $attend['srcode'] : "no data"; ?>
                                                        </td>
                                                        <td><?= isset($attend['college']) ? $attend['college'] : "-"; ?></td>
                                                        <td><?= isset($attend['course']) ? $attend['course'] : "-"; ?></td>
                                                        <td><?= isset($attend['kiosk']) ? $attend['kiosk'] : "-"; ?></td>
                                                        <td><?= isset($attend['in_time']) ? date('F j, Y, g:i A', strtotime($attend['in_time'])) : "-"; ?>
                                                        </td>
                                                        <td><?= isset($attend['out_time']) ? date('F j, Y, g:i A', strtotime($attend['out_time'])) : "-"; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if (isset($attend['in_time']) && isset($attend['out_time'])) {
                                                                    $time1 = new DateTime($attend['in_time']);
                                                                    $time2 = new DateTime($attend['out_time']);
                                                                    $duration = $time1->diff($time2)->format('%hhrs: %im: %ss');
                                                                    echo $duration;
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> 
    </div>
<!-- lmao footer gets so close that's why there's an extra closing div -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<!-- Include jQuery and Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#dataTable').DataTable({
        columnDefs: [{
            targets: 6,
            type: 'datetime',
            render: function(data, type, row) {
                if (type === 'sort') return new Date(data).getTime();
                return data;
            }
        }],
        order: [
            [6, 'desc']
        ],
    });
});
</script>

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

<script>
document.getElementById('code').addEventListener('input', function () {
    let inputValue = this.value.trim().toLowerCase();
    let studentSelect = document.getElementById('student');
    let options = studentSelect.getElementsByTagName('option');

    for (let i = 0; i < options.length; i++) {
        let option = options[i];
        let studentID = option.value.toLowerCase();
        let studentName = option.getAttribute('data-name'); 
        
        if (inputValue === studentID || (studentName && studentName.includes(inputValue))) {
            option.selected = true;
            return;
        }
    }

    // If no match, reset selection
    studentSelect.selectedIndex = 0;
});
</script>