<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js">
</script>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <h1 class="h3 mb-4 text-gray-800">Student Information</h1>
            <!-- <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a> -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card border-0 bg-transparent">
                <div class="card-body mb-0 p-0">
                    <a href="<?= base_url('master/a_student'); ?>" class="btn btn-icon-split mb-4 shadow-sm text-light"
                        style="background: linear-gradient(180deg, #031084, #000748); ">
                        <span class="icon text-white-600">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        <span class="text"
                            style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add New
                            Student</span>
                    </a>
                    <button type="button" class="btn btn-secondary btn-icon-split mb-4 shadow-sm" data-toggle="modal"
                        data-target=".bd-example-modal-xl" style="margin-bottom: 20px;">
                        <span class="icon text-white-600">
                            <i class="fas fa-file-import"></i>
                        </span>
                        <span class="text">Excel Import</span>
                    </button>
                    <button id="ImportDatabase" type="button" class="btn btn-secondary btn-icon-split mb-4 shadow-sm">
                        <span class="icon text-white-600">
                            <i class="fas fa-file-export"></i>
                        </span>
                        <span class="text">Database Import</span>
                    </button>
                    <!-- <button type="button" class="btn btn-secondary btn-icon-split mb-4 shadow-sm" data-toggle="modal" data-target=".bd-example-modal-xl-export">
                  <span class="icon text-white-600">
                    <i class="fas fa-file-export"></i>
                  </span>
                  <span class="text">Export</span>
                </button> -->
                    <button id="exportCsvButton" type="button" class="btn btn-secondary btn-icon-split mb-4 shadow-sm">
                        <span class="icon text-white-600">
                            <i class="fas fa-file-export"></i>
                        </span>
                        <span class="text">Excel Export</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card border-0 bg-transparent">
                <div class="card-body mb-0 pb-0">
                </div>
            </div>
        </div>
        <!-- Modal for Importing Students with Excel -->
        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="border-radius: 8px;">

                    <!-- Modal Header -->
                    <div class="modal-header"
                        style="background: linear-gradient(180deg, #031084, #000748);  color: white;">
                        <h4 class="modal-title">Import New Student with Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #f8f9fa;">
                        <div class="container-fluid">
                            <!-- Information Section -->
                            <div class="alert alert-info" role="alert">
                                Please ensure your CSV file follows the structure below:
                            </div>

                            <!-- CSV Example Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered" style="background-color: white;">
                                    <thead>
                                        <tr>
                                            <th>Student ID </th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Middle Name</th>
                                            <th>Gender</th>
                                            <th>Department </th>
                                            <th>Course </th>
                                            <th>Year </th>
                                            <!-- <th>QR</th> -->
                                            <th>PIN</th>
                                            <!-- <th>RFID</th> -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>20241001</td>
                                            <td>John</td>
                                            <td>Doe</td>
                                            <td>M</td>
                                            <td>Male</td>
                                            <td>CCIS</td>
                                            <td>BS Computer Science</td>
                                            <td>4</td>
                                            <!-- <td>1234562</td> -->
                                            <td>51231</td>
                                        </tr>
                                        <tr>
                                            <td>20241002</td>
                                            <td>Jane</td>
                                            <td>Smith</td>
                                            <td>A</td>
                                            <td>Female</td>
                                            <td>CCIS</td>
                                            <td>BS Computer Science</td>
                                            <td>4</td>
                                            <td>1234561</td>
                                            <!-- <td>42123</td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Form Section -->
                            <form method="post" action="<?php echo base_url();?>import/import_Student_File"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="uploadFile">Select Excel File (CSV format only)</label>
                                    <input type="file" name="uploadFile" class="form-control-file" id="uploadFile"
                                        required accept=".csv" style="font-size: 16px;">
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Upload" class="btn btn-info btn-block"
                                        style="background: linear-gradient(180deg, #031084, #000748);  font-size: 16px; padding: 10px;">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                            style="font-size: 14px;">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal for Exporting Students to Excel -->
        <div class="modal fade bd-example-modal-xl-export" tabindex="-1" role="dialog"
            aria-labelledby="exportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" style="border-radius: 8px;">

                    <!-- Modal Header -->
                    <div class="modal-header"
                        style="background: linear-gradient(180deg, #031084, #000748);  color: white;">
                        <h4 class="modal-title">Export Students to Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #f8f9fa;">
                        <form method="post" action="<?= base_url('report/export_students'); ?>">
                            <div class="alert alert-info" role="alert">
                                Select the parameters for exporting student data:
                            </div>
                            <div class="form-group">
                                <label for="college">College</label>
                                <select name="college" class="form-control" id="college">
                                    <option value="all">All</option>
                                    <option value="CCIS">CCIS</option>
                                    <option value="COE">COE</option>
                                    <!-- Add more college options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select name="year" class="form-control" id="year">
                                    <option value="all">All</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Export to Excel" class="btn btn-info btn-block"
                                    style="background: linear-gradient(180deg, #031084, #000748);  font-size: 16px; padding: 10px;">
                            </div>
                        </form>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="border-top: none;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                            style="font-size: 14px;">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Body -->

        <!-- <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Import New Student with Excel</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="container">
                <form method="post" action="<?php echo base_url();?>import/import_Student_File" enctype="multipart/form-data">
                    <p><label>Select Excel File</label>
                    <input type="file" name="uploadFile" required accept=".csv" /></p>
                    <br />
                    <input type="submit" name="submit" value="Upload" class="btn btn-info" />
                  </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div> -->

        <!-- Data Table Students-->
        <div class="card shadow mb-4 m-auto w-100" style="border-radius: 15px;">
            <div class="card-header py-3 d-flex" style="justify-content: space-between;
                        border-top-left-radius: 15px;
                        border-top-right-radius: 15px;
                        background: linear-gradient(180deg, #031084, #000748); 
            ">
                <h6 class="m-0 text-light" style="font-size:1.5rem;
                  font-family: 'Inter', sans-serif;">Data Tables Student</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead style="color: #272727; font-weight: 500;">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student ID</th>
                                <th>Name <span style="font-weight: normal; font-style: italic;">(LN, FN, MN)<span></th>
                                <th scope="col">Gender</th>
                                <th scope="col">College</th>
                                <th scope="col">Course</th>
                                <th scope="col">Year</th>
                                <th scope="col">Pin</th>
                                <!-- <th scope="col">QRCODE</th> -->
                                <!-- <th scope="col">RFID</th> -->
                                <!-- th>IMAGE</th>
                  <th>BUILDING</th -->
                                <th scope="col align-middle">Actions</th>
                            </tr>
                        </thead>

                        <tbody style="color: #272727;">
                            <?php
                $i = 1;
                foreach ($studentList as $emp) :
                ?>

                            <tr>
                                <td class=" align-middle"><?= $i++; ?></td>
                                <!-- td class=" align-middle"><?= $emp['id']; ?></td -->
                                <td class=" align-middle"><?= $emp['srcode']; ?></td>
                                <td class=" align-middle">
                                    <?= $emp['last_name'].", ".$emp['first_name']." ".$emp['middle_name'] ; ?></td>
                                <td class=" align-middle"><?php if ($emp['gender'] == 'M') {
                                                echo 'Male';
                                              } elseif ($emp['gender'] == 'F') {
                                                echo 'Female';
                                              } else{ }; ?></td>
                                <td class=" align-middle"><?= $emp['college']; ?></td>
                                <td class=" align-middle"><?= $emp['course']; ?></td>
                                <td class=" align-middle"><?= $emp['schoolyear']; ?></td>
                                <td class=" align-middle"><?= $emp['pin']; ?></td>
                                <!-- <td class=" align-middle"><?= $emp['qrcode']; ?></td> -->
                                <!-- <td class=" align-middle"><?= $emp['rfid']; ?></td> -->
                                <!-- td class="text-center"><img src="<?= base_url('images/pp/') . $emp['image']; ?>" style="width: 55px; height:55px" class="img-rounded"></td>
                    <td class=" align-middle"><?= $emp['building']; ?></td -->
                                <td class="text-center align-middle">
                                    <a href="<?= base_url('master/e_student/') . $emp['id'] ?>" class=""
                                        style="text-decoration:none">
                                        <span class="text-dark" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>&nbsp &nbsp
                                    <a href="<?= base_url('master/d_student/') . $emp['id'] ?>" class=""
                                        onclick="return confirm('Deleted student will lost forever. Still want to delete?')">
                                        <span class="icon text-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- /.container-fluid -->
<?php 
        //get the toasterhelper
          $this->load->helper('toast');

          if ($this->session->flashdata('student_scs')) {
           echo getAlertMessages('success', $this->session->flashdata('student_scs'));
          }
          if ($this->session->flashdata(' student_fail')) {
           echo getAlertMessages('error', $this->session->flashdata('student_fail'));
          }
          if ($this->session->flashdata('student_neutral')){
            echo getAlertMessages('info', $this->session->flashdata('student_neutral'));
          }
          if($this->session->flashdata('student_validation')) {
            echo getAlertMessages('error', $this->session->flashdata('student_validation'));
          }
          
          //unset it after use
          $this->session->unset_userdata('student_scs');
          $this->session->unset_userdata('student_fail');
          $this->session->unset_userdata('student_neutral');
          $this->session->unset_userdata('student_validation');
        ?>

<script>
  // document.addEventListener("DOMContentLoaded", function () {
  //     // Initialize the DataTable
  //     const table = $('#dataTable').DataTable();

  //     // Function to export table data to CSV
  //     function exportTableToCSV(filename) {
  //         // Extract all data from the DataTable (all rows, including those not visible)
  //         const data = table.rows().data();

  //         let csv = [];
  //         // Iterate through all rows of data
  //         data.each(function (row) {
  //             let rowData = [];
  //             // Use forEach to iterate over each cell in the row
  //             row.forEach(function (cell) {
  //                 // Escape commas and quotes in the cell data
  //                 let text = cell.replace(/"/g, '""');
  //                 rowData.push(`"${text}"`);
  //             });
  //             csv.push(rowData.join(","));
  //         });

  //         // Create CSV file content
  //         const csvContent = csv.join("\n");

  //         // Create a download link for the CSV
  //         const blob = new Blob([csvContent], { type: "text/csv" });
  //         const link = document.createElement("a");
  //         link.href = URL.createObjectURL(blob);
  //         link.download = filename;

  //         // Programmatically click the link to trigger the download
  //         link.style.display = "none";
  //         document.body.appendChild(link);
  //         link.click();
  //         document.body.removeChild(link);
  //     }

  //     // Add event listener to the export button with SweetAlert2 confirmation
  //     document.getElementById("exportCsvButton").addEventListener("click", function () {
  //         Swal.fire({
  //             title: 'Are you sure?',
  //             text: 'Do you want to export the student data to CSV?',
  //             icon: 'warning',
  //             showCancelButton: true,
  //             confirmButtonText: 'Yes, export it!',
  //             cancelButtonText: 'No, cancel',
  //         }).then((result) => {
  //             if (result.isConfirmed) {
  //                 const filename = "students_data.csv"; // Default filename
  //                 exportTableToCSV(filename); // Execute export
  //                 Swal.fire('Exported!', 'The student data has been exported to CSV.', 'success');
  //             } else {
  //                 Swal.fire('Cancelled', 'The export has been cancelled.', 'info');
  //             }
  //         });
  //     });
  // });
  document.addEventListener("DOMContentLoaded", function() {
      // Initialize the DataTable
      const table = $('#dataTable').DataTable();

      // Function to export table data to CSV
      function exportTableToCSV(filename) {
          // Define the custom header labels
          const customHeaders = [
              "First Name", "Middle Name", "Last Name", "ID Number", "College", "Department",
              "Course", "PIN"
          ];

          let csv = [];
          // Add the custom headers as the first row in the CSV
          csv.push(customHeaders.join(","));

          // Extract all data from the DataTable (all rows, including those not visible)
          const data = table.rows().data();

          // Iterate through all rows of data
          data.each(function(row) {
              let rowData = [];

              // Parse the name
              const name = row[2].trim(); // Assuming "NAME" column is at index 2
              let firstName = '';
              let middleName = '';
              let lastName = '';

              // Handle name format with a comma (Last Name, First Name)
              if (name.includes(',')) {
                  // Split by comma
                  const parts = name.split(',');
                  lastName = parts[0].trim(); // First part is Last Name
                  const firstAndMiddle = parts[1].trim().split(' ');

                  // Handle multiple first names (FN) and middle name (MN)
                  if (firstAndMiddle.length > 1) {
                      firstName = firstAndMiddle.slice(0, -1).join(' '); // Multiple first names
                      middleName = firstAndMiddle.slice(-1).join(' '); // Last part is middle name
                  } else {
                      firstName = firstAndMiddle[0]; // Single first name
                  }
              } else {
                  // Case without a comma, assume it's in the format "First Last Middle"
                  const parts = name.split(' ');
                  firstName = parts.slice(0, -2).join(' '); // Multiple first names if present
                  lastName = parts[parts.length - 2]; // Second last part is Last Name
                  middleName = parts[parts.length - 1]; // Last part is Middle Name
              }

              // Add the customized row data
              rowData.push(`"${firstName}"`, `"${middleName}"`, `"${lastName}"`);

              // Add the ID Number, College, Program, RFID
              rowData.push(`"${row[1]}"`); // ID Number (Assuming Student ID is at index 1)
              rowData.push(`"${row[4]}"`); // College
              rowData.push(`""`); // Empty Department field
              rowData.push(`"${row[5]}"`); // Program (Course -> Program)
              rowData.push(`"${row[7]}"`); // PIN

              csv.push(rowData.join(","));
          });

          // Create CSV file content
          const csvContent = csv.join("\n");

          // Create a download link for the CSV
          const blob = new Blob([csvContent], {
              type: "text/csv"
          });
          const link = document.createElement("a");
          link.href = URL.createObjectURL(blob);
          link.download = filename;

          // Programmatically click the link to trigger the download
          link.style.display = "none";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
      }

      // Add event listener to the export button with SweetAlert2 confirmation
      document.getElementById("exportCsvButton").addEventListener("click", function() {
          Swal.fire({
              title: 'Are you sure?',
              text: 'Do you want to export the student data to CSV?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, export it!',
              cancelButtonText: 'No, cancel',
          }).then((result) => {
              if (result.isConfirmed) {
                  const filename = "students_data.csv"; // Default filename
                  exportTableToCSV(filename); // Execute export
                  Swal.fire('Exported!', 'The student data has been exported to CSV.', 'success');
              } else {
                  Swal.fire('Cancelled', 'The export has been cancelled.', 'info');
              }
          });
      });
  });
</script>
<script>
  $(document).ready(function() {

      load_data();

      function load_data() {
          $.ajax({
              url: "<?php echo base_url(); ?>Excel_import/fetch",
              method: "POST",
              success: function(data) {
                  $('#customer_data').html(data);
              }
          })
      }

      $('#import_form').on('submit', function(event) {
          event.preventDefault();
          $.ajax({
              url: "<?php echo base_url(); ?>Excel_import/import_student",
              method: "POST",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              success: function(data) {
                  $('#file').val('');
                  load_data();
                  alert(data);
              }
          })
      });

  });
</script>
<script>
  $(document).ready(function() {
      // Populate College and Year dropdowns
      function populateFilters() {
          const colleges = new Set();
          const years = new Set();

          // Loop through the table rows
          $('#dataTable tbody tr').each(function() {
              const college = $(this).find('td:nth-child(5)').text().trim(); // 5th column for College
              const year = $(this).find('td:nth-child(7)').text().trim(); // 7th column for Year

              if (college) colleges.add(college);
              if (year) years.add(year);
          });

          // Add options to College dropdown
          const collegeDropdown = $('#college');
          collegeDropdown.empty(); // Clear existing options
          collegeDropdown.append('<option value="all">All</option>'); // Default option
          colleges.forEach(college => {
              collegeDropdown.append(`<option value="${college}">${college}</option>`);
          });

          // Add options to Year dropdown
          const yearDropdown = $('#year');
          yearDropdown.empty(); // Clear existing options
          yearDropdown.append('<option value="all">All</option>'); // Default option
          years.forEach(year => {
              yearDropdown.append(`<option value="${year}">${year} Year</option>`);
          });
      }

      // Populate filters when the page is ready
      populateFilters();
  });
</script>

<script>
    $(document).ready(function() {
        $('#ImportDatabase').on('click', function() {
            Swal.fire({
                title: 'Import Database',
                text: 'Are you sure you want to import the database?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, import it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    //go to master controller.
                    window.location.href = "<?= base_url('master/import_database') ?>";
                    Swal.fire(
                        'Import Started!',
                        'The database import process has begun.',
                        'success'
                    );
                }
            });
        });
    });
</script>