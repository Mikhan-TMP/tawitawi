<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4" style="min-height: 543px; border-radius:15px;">
                        <form action="" method="POST">
                            <div class="card-header py-3 d-flex justify-content-between" style="border-radius:15px 15px 0 0; background: linear-gradient(180deg, #BE110E, #630908);">
                                <h6 class="m-0 text-light" style="font-size:1.5rem; font-family: 'Inter', sans-serif;">Attendance Sheet</h6>
                                <div class="div">
                                    <button type="button" id="exportCsv" class="btn btn-md btn-fill" style="background: #FFFFFF; color: #BE110E !important; font-size: 12px !important; font-weight: 500 !important;">
                                        <i class="fas fa-file-excel text-success"></i> EXPORT
                                    </button>
                                    <button type="button" id="filter" class="btn btn-md btn-fill" style="background: #FFFFFF; color: #BE110E !important; font-size: 12px !important; font-weight: 500 !important;">
                                        <i class="fas fa-filter text-success"></i> FILTER
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                                        <thead style="color: #272727; font-weight: 500;">
                                            <tr>
                                                <th>Name</th>
                                                <th>RFID</th>
                                                <th>Student ID</th>
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
                                                    <td><?= isset($attend['username']) ? $attend['username'] : "no data"; ?></td>
                                                    <td>
                                                        <?php
                                                        $srcode = $attend['srcode'];
                                                        $student = $this->db->get_where('student', ['srcode' => $srcode])->row_array();
                                                        echo isset($student['rfid']) ? $student['rfid'] : "-";
                                                        ?>
                                                    </td>
                                                    <td><?= isset($attend['srcode']) ? $attend['srcode'] : "no data"; ?></td>
                                                    <td><?= isset($attend['college']) ? $attend['college'] : "-"; ?></td>
                                                    <td><?= isset($attend['course']) ? $attend['course'] : "-"; ?></td>
                                                    <td><?= isset($attend['kiosk']) ? $attend['kiosk'] : "-"; ?></td>
                                                    <td><?= isset($attend['in_time']) ? date('F j, Y, g:i A', strtotime($attend['in_time'])) : "-"; ?></td>
                                                    <td><?= isset($attend['out_time']) ? date('F j, Y, g:i A', strtotime($attend['out_time'])) : "-"; ?></td>
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
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<?php   
        //get the toasterhelper
          $this->load->helper('toast');

          if ($this->session->flashdata('success')) {
            echo getAlertMessages('success', $this->session->flashdata('success'));
          }
          if ($this->session->flashdata('warning')) {
            echo getAlertMessages('warning', $this->session->flashdata('warning'));
          }
          if ($this->session->flashdata('error')) {
            echo getAlertMessages('error', $this->session->flashdata('error'));
          }
          //unset it after use
          $this->session->unset_userdata('error');
          $this->session->unset_userdata('success');
          $this->session->unset_userdata('warning');
        ?> 


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


<script>
    $(document).ready(function () {
            var table = $('#dataTable').DataTable({
                columnDefs: [{
                    targets: 6,
                    type: 'datetime',
                    render: function (data, type, row) {
                        if (type === 'sort') return new Date(data).getTime();
                        return data;
                    }
                }],
                order: [[6, 'desc']],
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var min = $('#startDateFilter').val();
                var max = $('#endDateFilter').val();
                var timeIn = data[6]; // The 'Time In' column (adjust index if necessary)

                if (timeIn) {
                    // Convert the 'Time In' string to a Date object
                    var timeInDate = new Date(timeIn);

                    // Create Date objects for the filter range
                    var minDate = min ? new Date(min) : null;
                    var maxDate = max ? new Date(max) : null;

                    if (maxDate) maxDate.setHours(23, 59, 59, 999); // Set max date to end of the day

                    // Return true if the row's date is within the filter range
                    return (!minDate || timeInDate >= minDate) && (!maxDate || timeInDate <= maxDate);
                }
                return false;
            });

            $('#startDateFilter, #endDateFilter').on('change', function () {
                    table.draw();
                });
    });
</script>

<!-- THIS WILL OPEN THE MODAL -->
<script>
document.getElementById('exportCsv').addEventListener('click', function () {
    Swal.fire({
        title: 'Export Attendance Data',
        html: `
            <form id="exportForm">
                <div class="mb-3 text-left" style="color: #272727; font-weight: 500; font-size: small;">
                    <label for="startDate" class="form-label text-left">Start Date</label>
                    <input type="date" id="startDate" name="startDate" class="form-control">
                </div>
                <div class="mb-3 text-left" style="color: #272727; font-weight: 500; font-size: small;">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" id="endDate" name="endDate" class="form-control">
                </div>
                <div class="mb-3 d-flex" style="justify-content: right;">
                    <div class="btn-group" style=" gap: 10px;">
                        <button type="button" class="p-2" style=" border: none; font-weight: 500; font-size: small; border-radius: 5px; background: linear-gradient(180deg, #BE110E, #630908); color: white; min-width: 100px" id="todayButton">Today</button>
                        <button type="button" class="p-2" id="yesterdayButton" style="border: none; font-weight: 500; font-size: small; border-radius: 5px; background: linear-gradient(180deg, #BE110E, #630908); color: white; min-width: 100px">Yesterday</button>
                        <select class="form-select" id="range" name="range" style="border: none; font-weight: 500; font-size: small; border-radius: 5px; background: linear-gradient(180deg, #FFD602, #FAB703, #D6890E); color: black;">
                            <option value="">Select Range</option>
                            <option value="7">Last 1 week</option>
                            <option value="14">Last 2 weeks</option>
                            <option value="21">Last 3 weeks</option>
                            <option value="28">Last 4 weeks</option>
                            <option value="lastmonth">Last month</option>
                            <option value="last2months">Last 2 months</option>
                            <option value="last3months">Last 3 months</option>
                            <option value="last6months">Last 6 months</option>
                            <option value="lastyear">Last year</option>
                        </select>
                    </div>
                </div>

                <?php
                $collegeCourses = [];
                foreach ($attendance as $entry) {
                    $collegeCourses[$entry['college']][] = $entry['course'];
                }
                ?>
                <div class="mb-3 text-left" style="color: #272727; font-weight: 500; font-size: small;">
                    <label for="college" class="form-label">Select College</label>
                    <select id="college" name="college" class="form-control">
                        <option value="All">All Colleges</option>
                        <?php foreach (array_keys($collegeCourses) as $college): ?>
                            <option value="<?= htmlspecialchars($college) ?>"><?= htmlspecialchars($college) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 text-left" style="color: #272727; font-weight: 500; font-size: small;">
                    <label for="course" class="form-label">Select Course</label>
                    <select id="course" name="course" class="form-control" disabled>
                        <option value="All">All Courses</option>
                    </select>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonColor: '#BE110E',
        confirmButtonText: 'Export',
        showDenyButton: true,
        denyButtonText: 'Count Only',
        didOpen: () => {
            const collegeCourses = <?= json_encode($collegeCourses) ?>;

            const collegeSelect = document.getElementById('college');
            const courseSelect = document.getElementById('course');

            collegeSelect.addEventListener('change', () => {
                const selectedCollege = collegeSelect.value;

                // Reset and disable course dropdown
                courseSelect.innerHTML = '<option value="All">All Courses</option>';
                courseSelect.disabled = (selectedCollege === "All");

                if (selectedCollege !== "All" && collegeCourses[selectedCollege]) {
                    // Populate unique courses for the selected college
                    const uniqueCourses = [...new Set(collegeCourses[selectedCollege])];
                    uniqueCourses.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course;
                        option.textContent = course;
                        courseSelect.appendChild(option);
                    });
                }
            });
        },
        preConfirm: () => {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const course = document.getElementById('course').value;
            const college = document.getElementById('college').value;

            if (!startDate || !endDate) {
                Swal.showValidationMessage('Please select a valid date range');
                return false;
            }

            return { startDate, endDate, course, college };
        },
        preDeny: () => {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const course = document.getElementById('course').value;
            const college = document.getElementById('college').value;

            if (!startDate || !endDate) {
                Swal.showValidationMessage('Please select a valid date range');
                return false;
            }

            return { startDate, endDate, course, college };
        }
    }).then((result) => {
        const { startDate, endDate, course, college } = result.value;

        if (result.isDenied) {
            const url = `<?= base_url('master/excel_export?startDate=') ?>${startDate}&endDate=${endDate}&course=${course}&college=${college}&countOnly=true`;
            window.location.href = url;
        } else if (result.isConfirmed) {
            const url = `<?= base_url('master/excel_export?startDate=') ?>${startDate}&endDate=${endDate}&course=${course}&college=${college}`;
            window.location.href = url;
        }
    });
});
</script>
<!-- FOR TODAY YESTERDAY  -->
<script>
    document.addEventListener('click', function (event) {
        const today = new Date();
        // Today Button
        if (event.target.id === 'todayButton') {
            document.getElementById('startDate').value = today.toISOString().split('T')[0];
            document.getElementById('endDate').value = today.toISOString().split('T')[0];
        }

        // Yesterday Button
        if (event.target.id === 'yesterdayButton') {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            document.getElementById('startDate').value = yesterday.toISOString().split('T')[0];
            document.getElementById('endDate').value = yesterday.toISOString().split('T')[0];
        }
    });
</script>

<!-- FOR RANGE SELECT -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delegate the change event to the document
        document.addEventListener('change', function (event) {
            if (event.target && event.target.id === 'range') {
                const today = new Date();
                const rangeValue = event.target.value;
                let startDate = null;
                
                console.log("Selected range:", rangeValue);  // Debugging log
                
                if (!rangeValue) {
                    document.getElementById('startDate').value = '';
                    document.getElementById('endDate').value = '';
                    return; 
                }

                if (rangeValue === 'lastmonth') {
                    startDate = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
                } else if (rangeValue === 'last2months') {
                    startDate = new Date(today.getFullYear(), today.getMonth() - 2, today.getDate());
                } else if (rangeValue === 'last3months') {
                    startDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate());
                } else if (rangeValue === 'last6months') {
                    startDate = new Date(today.getFullYear(), today.getMonth() - 6, today.getDate());
                } else if (rangeValue === 'lastyear') {
                    startDate = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate());
                }
                else {
                    startDate = new Date();
                    startDate.setDate(today.getDate() - parseInt(rangeValue, 10)); // Calculate for weeks
                }

                console.log("Calculated start date:", startDate);  // Debugging log

                if (startDate) {
                    document.getElementById('startDate').value = startDate.toISOString().split('T')[0];
                    document.getElementById('endDate').value = today.toISOString().split('T')[0];
                }
            }
        });
    });

</script>

<!-- OPEN THE FILTER -->
<script>
    document.getElementById('filter').addEventListener('click', function () {
        Swal.fire({
            title: 'Filter Attendance Data',
            html: `
                <form id="filterForm">
                    <div class="mb-3 text-left" style="color: #272727; font-weight: 500; font-size: small;">
                        <label for="startDateFilter" class="form-label">Start Date</label>
                        <input type="date" id="startDateFilter" name="startDateFilter" class="form-control">
                    </div>
                    <div class="mb-3 text-left" style="color: #272727; font-weight: 500; font-size: small;">
                        <label for="endDateFilter" class="form-label">End Date</label>
                        <input type="date" id="endDateFilter" name="endDateFilter" class="form-control">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Apply Filter',
            preConfirm: () => {
                const startDate = document.getElementById('startDateFilter').value;
                const endDate = document.getElementById('endDateFilter').value;

                if (!startDate || !endDate) {
                    Swal.showValidationMessage('Please select both start and end dates');
                }

                return { startDate, endDate };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { startDate, endDate } = result.value;

                // Set the date filter inputs (if you are using hidden inputs for table filtering)
                $('#startDateFilter').val(startDate);
                $('#endDateFilter').val(endDate);

                // Trigger DataTable redraw with the new filters
                $('#dataTable').DataTable().draw();

                Swal.fire('Filter Applied', 'Attendance data has been filtered.', 'success');
            }
        });
    });

</script>

<script>
    $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var min = $('#startDateFilter').val();
        var max = $('#endDateFilter').val();
        var timeIn = data[6]; // Time In column (index 6)

        if (timeIn) {
            var timeInDate = new Date(timeIn);
            var minDate = min ? new Date(min) : null;
            var maxDate = max ? new Date(max) : null;

            // Adjust maxDate to include the entire day
            if (maxDate) {
                maxDate.setHours(23, 59, 59, 999);
            }

            if (
                (!minDate || timeInDate >= minDate) &&
                (!maxDate || timeInDate <= maxDate)
            ) {
                return true; // Show row
            }
        }
        return false; // Hide row
    }
    );
</script>

<!-- CONVERT TO EXCEL -->
<!-- <script>
    const excelData = <?php echo json_encode($this->session->userdata('excel_data')); ?>;
    console.log("Excel Data:", excelData);

    const customHeaders = [
        { key: 'id', displayName: '#' },
        { key: 'rfid', displayName: 'RFID' },
        { key: 'qrcode', displayName: 'QR Code' },
        { key: 'date', displayName: 'Date' },
        { key: 'srcode', displayName: 'Student ID' },
        { key: 'student_last_name', displayName: 'Last Name' },
        { key: 'student_first_name', displayName: 'First Name' },
        { key: 'student_middle_name', displayName: 'Middle Name' },
        { key: 'in_time', displayName: 'Time In' },
        { key: 'out_time', displayName: 'Time Out' },
        { key: 'college', displayName: 'College' },
        { key: 'course', displayName: 'Course' },
        { key: 'kiosk', displayName: 'Kiosk' }
    ];

    function prepareDataWithHeaders(data, headers) {
        const processedData = [];
        const headerRow = headers.map(header => header.displayName);
        processedData.push(headerRow);

        for (const row of data) {
            const rowData = headers.map(header => row[header.key] || '');
            processedData.push(rowData);
        }

        return processedData;
    }

    const preparedData = prepareDataWithHeaders(excelData, customHeaders);

    function styleHeaderRow(ws, headers) {
        const headerRange = XLSX.utils.decode_range(ws['!ref']); // Get range of the worksheet
        const headerRowIndex = 0; // First row is the header

        headers.forEach((header, colIndex) => {
            const cellAddress = XLSX.utils.encode_cell({ r: headerRowIndex, c: colIndex });
            if (!ws[cellAddress]) return; // Skip if cell does not exist

            ws[cellAddress].s = {
                font: { bold: true, color: { rgb: "FFFFFF" } }, // Bold, white font
                fill: { fgColor: { rgb: "4F81BD" } }, // Blue background
                alignment: { horizontal: "center", vertical: "center" } // Center align
            };
        });

        // Simulate row height adjustment
        ws['!rows'] = ws['!rows'] || [];
        ws['!rows'][headerRowIndex] = { hpx: 30 }; // Set header row height to 30px
    }

    function downloadExcel(data, filename) {
        // Convert the 2D array to a worksheet
        const ws = XLSX.utils.aoa_to_sheet(data);

        // Define custom column widths
        ws['!cols'] = [
            { wpx: 30 }, //att id
            { wpx: 75 }, //rfid
            { wpx: 75 }, //qrcode
            { wpx: 75 }, //date
            { wpx: 75 }, //student id
            { wpx: 90 }, //first name
            { wpx: 90 }, //last name
            { wpx: 90 }, //middle name
            { wpx: 150 }, //time in
            { wpx: 150 }, //time out
            { wpx: 150 }, //college
            { wpx: 200 }, //course
            { wpx: 120 } //kiosk
        ];

        // Style the header row
        styleHeaderRow(ws, customHeaders);

        // Create a new workbook and append the worksheet
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        // Write the workbook and trigger download
        XLSX.writeFile(wb, filename);

        // Unset the session data after download
        fetch('<?php echo base_url("master/unset_excel_data"); ?>', {
            method: 'POST'
        }).then(response => {
            console.log('Session data unset successfully');
        }).catch(error => {
            console.error('Error unsetting session data:', error);
        });
    }

    const excelFileName = "Student Attendance.xlsx";
    downloadExcel(preparedData, excelFileName);
</script> -->

<script>
const excelData = <?php echo json_encode($this->session->userdata('excel_data')); ?>;
console.log("Excel Data:", excelData);
// log the count_only property
console.log("Count Only:", excelData.count_only);
if (excelData.count_only) {
    // Display summarized count data


    const countSummary = Object.values(excelData).filter(item => typeof item === "object");
    console.log("Count Only Data:", excelData);
    const customHeaders = [
        { key: 'course', displayName: 'Course' },
        { key: 'college', displayName: 'College' },
        { key: 'count', displayName: 'Count' }
    ];

    function downloadCountSummary() {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet("Attendance Summary Report");

        worksheet.mergeCells('A1:D1');
        worksheet.getCell('A1').value = 'Attendance Summary Report';
        worksheet.getCell('A1').font = { bold: true, size: 28 };
        worksheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'center' };
        worksheet.getCell('A1:D1').fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFC08080' }
        };

        // Add the header in the second row
        const headerRow = customHeaders.map(header => header.displayName);
        worksheet.addRow(headerRow);

        // Add data rows
        countSummary.forEach(row => {
            const rowData = customHeaders.map(header => row[header.key] || '');
            worksheet.addRow(rowData);
        });

        // Adjust column widths
        worksheet.columns = [
            { width: 30 }, // Course
            { width: 25 }, // College
            { width: 10 }  // Count
        ];

        // Save the file
        workbook.xlsx.writeBuffer().then(buffer => {
            const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
            saveAs(blob, "Attendance_Summary.xlsx");
        });

        // Unset the session data after download
        fetch('<?php echo base_url("master/unset_excel_data"); ?>', {
            method: 'POST'
        }).then(response => {
            console.log('Session data unset successfully');
        }).catch(error => {
            console.error('Error unsetting session data:', error);
        });
    }

    downloadCountSummary();
} else {
    // Proceed with the usual Excel generation logic
    const customHeaders = [
        { key: 'id', displayName: '#' },
        { key: 'rfid', displayName: 'RFID' },
        { key: 'qrcode', displayName: 'QR Code' },
        { key: 'date', displayName: 'Date' },
        { key: 'srcode', displayName: 'Student ID' },
        { key: 'student_last_name', displayName: 'Last Name' },
        { key: 'student_first_name', displayName: 'First Name' },
        { key: 'student_middle_name', displayName: 'Middle Name' },
        { key: 'in_time', displayName: 'Time In' },
        { key: 'out_time', displayName: 'Time Out' },
        { key: 'college', displayName: 'College' },
        { key: 'course', displayName: 'Course' },
        { key: 'kiosk', displayName: 'Kiosk' }
    ];

    function downloadExcel() {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet("Student Attendance");

        worksheet.mergeCells('A1:M1');
        worksheet.getCell('A1').value = 'Attendance Data Report';
        worksheet.getCell('A1').font = { bold: true, size: 28 };
        worksheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'center' };
        worksheet.getCell('A1:M1').fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFC08080' }
        };

        // Add the header in the third row
        const headerRow = customHeaders.map(header => header.displayName);
        worksheet.addRow(headerRow);

        // Add data rows (starting from row 4)
        excelData.forEach(row => {
            const rowData = customHeaders.map(header => row[header.key] || '');
            worksheet.addRow(rowData);
        });

        // Adjust column widths
        worksheet.columns = [
            { width: 5 },  // #
            { width: 15 }, // RFID
            { width: 15 }, // QR Code
            { width: 12 }, // Date
            { width: 15 }, // Student ID
            { width: 20 }, // Last Name
            { width: 20 }, // First Name
            { width: 20 }, // Middle Name
            { width: 15 }, // Time In
            { width: 15 }, // Time Out
            { width: 25 }, // College
            { width: 30 }, // Course
            { width: 20 }  // Kiosk
        ];

        // Save the file
        workbook.xlsx.writeBuffer().then(buffer => {
            const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
            saveAs(blob, "Student_Attendance.xlsx");
        });

        // Unset the session data after download
        fetch('<?php echo base_url("master/unset_excel_data"); ?>', {
            method: 'POST'
        }).then(response => {
            console.log('Session data unset successfully');
        }).catch(error => {
            console.error('Error unsetting session data:', error);
        });
    }

    downloadExcel();
}

</script>





