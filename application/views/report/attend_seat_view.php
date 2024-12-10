<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css"> -->
<!-- <link rel="icon" type="image/png" href="https://webdamn.com/wp-content/themes/v2/webdamn.png"> -->

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-lg">
      <h1 class="h3 mb-4 text-gray-800">Library Seat Report</h1>
      <!-- <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a>-->
    </div>
  </div>
  <div class="row">
      <!-- a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Attend_export/createexcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
      <a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Report/attend_print"><i class="fa fa-file-excel-o"></i> PDF</a -->
      <div class="col-sm-12 col-lg-12 ml-auto ">
        <form action="" method="GET">
          <div class="row d-flex flex-wrap ml-2" style="gap: 10px">
            <?php $date = date("Y-m-d");  ?>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">From:</label>
              <div class="">
                <input type="date" name="start" placeholder= "<?php echo $date ?>"   class="form-control" value="">            
                <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">To:</label>
              <div class="">
                <input type="date" name="end" placeholder= "<?php echo $date ?>"  class="form-control" value="">                 
                <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">Area:</label>
                <div class="">
                <select class="form-control" name="roomName" style="color: white; background: linear-gradient(180deg, #031084, #000748); ">              
                  <option style="color: black" value="">All</option>
                  <?php foreach ($roomlist as $d) : ?>
                    <option style="color: black" value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option>
                  <?php endforeach; ?>
                </select>
                <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
            </div>

            <!-- <h5 class="mt-1 ml-2">Area:</h5> -->
            <div class="buttons d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px" >
              <div class="">
                <button type="submit" name="submit" value="Show"  
                class="btn btn-success btn-fill btn-block" 
                style="background: linear-gradient(180deg, #031084, #000748);   color: white; padding: 7px; width: 100px;  border:none; border-radius: 15px">
                <i class="fa fa-search"></i>
                Show</button>            
              </div>
              <div class="">
                  <button type="submit" name="submit" value="Print"  class="btn btn-success btn-fill btn-block"
                  style="background: linear-gradient(180deg, #031084, #000748);  color: white; padding: 7px; width: 100px; border:none; border-radius: 15px">
                  <i class="fa fa-print"></i>
                  Print</button>
              </div>
              <div class="">
                <button type="submit" id="exportCsv" class="btn btn-success btn-fill btn-block"
                style="background: linear-gradient(180deg, #031084, #000748);  color: white; border:none; padding: 7px; width: 100px; border-radius: 15px">
                <i class="fa fa-file-excel"></i>
                Export</button>
              </div>
              <div class="">
                <button type="button" class="btn btn-success btn-fill btn-block" data-toggle="modal" data-target="#cancelAllModal"
                  style="background: linear-gradient(180deg, #031084, #000748);  border:none; color: white; padding: 7px; width: 125px; border-radius: 15px">
                  <i class="fa fa-ban"></i>
                  Cancel All</button>

                <div class="modal fade" id="cancelAllModal" tabindex="-1" role="dialog" aria-labelledby="cancelAllModalTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="cancelAllModalTitle">Cancel Bookings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <label for="room">Area</label>
                            <select class="form-control" id="room" name="room">
                              <option value="all">All</option>
                              <?php foreach ($roomlist as $d) : ?>
                                <option value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="cancel">Cancel Bookings</label>
                            <select class="form-control" id="cancel" name="cancel">
                              <option value="today">Today</option>
                              <option value="tomorrow">Tomorrow</option>
                              <option value="specific">Specific Date Range</option>
                            </select>
                          </div>
                          <div id="specific-date" style="display: none;">
                            <div class="form-group">
                              <label for="from_date">From Date</label>
                              <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                            <div class="form-group">
                              <label for="to_date">To Date</label>
                              <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="cancelAllBookings">Cancel Bookings</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
  </div><br>
  <!-- End of row show -->
  <!-- <?=      print_r($attendance); ?> -->

  <?php if ($attendance == false) : ?>
    <h1>No Data, Please Pick Your Date and Building</h1>
  <?php else : ?>

    <?php if ($attendance != null) : ?>


      <!-- Export exel and PDF -->

      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex" 
                  style="justify-content: space-between;
                        border-top-left-radius: 15px;
                        border-top-right-radius: 15px;
                        background: linear-gradient(180deg, #031084, #000748); 
            ">
          <!-- <h6 class="m-0 text-light" 
                  style="font-size:1.5rem;
                  font-family: 'Inter', sans-serif;">Table Name</h6> -->
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead style="color: #272727; font-weight: 500;">
                <tr>
                  <tr>
                  <th >Booking ID</th>
                    <th class="header">Date</th>
                    <th class="header">Floor</th> 
                    <th class="header">Area Name</th>
                    <th class="header">Start Time </th>
                    <th class="header">End Time</th>
                    <th class="header">Seat #</th> 
                    <th class="header">Name</th> 
                    <th class="header">Time In</th> 
                    <th class="header">Time Out </th>
                    <th class="header">Action </th>
                    <th class="header">Duration</th>  
                  </tr>
              </thead>              
              <tbody style="color: #272727;">

                <?php
                $i = 1;
                foreach ($attendance as $atd) :
                ?>

                  <?php
                    //convert
                    // get compare the area name to the area in the table and it is the same floor
                    $area_info = $this->db->get_where('area', array('floor' => $atd['floor'], 'room' => $atd['room']))->row_array();
                    
                    $times = []; 

                    // Parse the opening and closing times
                    $open_time = strtotime($area_info['opentime']);
                    $close_time = strtotime($area_info['closetime']);

                    // Generate the time slots
                    $counter = 0; // Initialize counter
                    for ($time = $open_time; $time <= $close_time; $time = strtotime('+1 hour', $time)) {
                      $times[$counter] = date('H:i', $time);
                      // echo $times[$counter];
                      $counter++;
                    }
                  ?>
                  <tr 
                    <?php 
                    if ($atd['in_status'] == "occupied" && $atd['out_status'] == "exit") {
                        echo 'style="background-color: #cfffd1;"'; 
                    } else if ($atd['in_status'] == "occupied" && $atd['out_status'] == "early-exit") {
                        echo 'style="background-color: #f9ecec;"'; 
                    } else if ($atd['in_status'] == "occupied" && $atd['out_status'] == "late-exit") {
                        echo 'style="background-color: #fff4e6;"'; 
                    } else if ($atd['in_status'] == "late-in" && $atd['out_status'] == "late-exit"){
                        echo 'style="background-color: #ffcccc;"';
                    } else if ($atd['in_status'] == "occupied" && $atd['out_status'] == "f-timeout") {
                        echo 'style="background-color: #f3f3ff;"'; 
                    } else if ($atd['in_status'] == "cancelled" || $atd['out_status'] == "cancelled") {
                        echo 'style="background-color: #580202; color: white;"'; 
                    }
                    ?>
                    >
                  <td><?= $atd['id']; ?></td>                    
                    <td><?= $atd['date']; ?></td>
                    <td><?= $atd['floor']; ?></td>
                    <td><?= $atd['room']; ?></td>
                    <td>
                      <!-- <?=$atd['start_time']; ?> -->
                        <?php 
                        // echo " = ";  
                        // Compare start_time to the array of times
                        $start_time_index = $atd['start_time'];
                        if (isset($times[$start_time_index])) {
                            $start_time_format = $times[$start_time_index];  
                            echo date('g:i A', strtotime($start_time_format));
                        } else {
                            echo "Invalid start time"; 
                        }
                      ?>
                      </td>
                    <td>
                      <!-- <?=$atd['end_time']; ?> -->
                    <?php 
                    // echo " = ";  
                        // Compare end_time to the array of times
                        $end_time_index = $atd['end_time']; // 
                        if (isset($times[$end_time_index])) {
                            $end_time_format = $times[$end_time_index];
                            echo date('g:i A', strtotime($end_time_format)); 
                        } else {
                            echo "Invalid end time";
                        }
                        
                      ?>
                    </td>
                    <td><?= $atd['slot_id']; ?></td>  
                    <td><?= $atd['fname']." ".$atd['lname']; ?></td>
                    <?php if($atd['in_time']==NULL){
                    } 
                    ?>
                    <td><?php if($atd['in_time']==NULL){
                            echo "..."; 
                            // echo "
                            // <a href='#' class='btn confirm-end-booking' data-url='".base_url('master/cancelBooking?book_id='.$atd['id']. '&start='.$start_time_format. '&end='.$end_time_format). "'
                            // style='background: linear-gradient(180deg, #031084, #000748);  font-size: 12px; color: white; border: none; !important'>Cancel</a> 
                            // ";
                          }
                            else 
                            echo date('g:i A', strtotime($atd['in_time'])); ?> </td>
                    <td><?php if($atd['out_time']==NULL)
                              {
                                echo "...";
                                // echo "
                                // <a href='#' class='btn confirm-timeout-booking' data-url='".base_url('master/timeoutForce?book_id='.$atd['id'].'&end='.$end_time_format)."'
                                // style='background: linear-gradient(180deg, #031084, #000748);  font-size: 12px; color: white; border: none; !important'>Timeout</a> 
                                // ";
                              }
                            else 
                              echo date('g:i A', strtotime($atd['out_time'])); ?> </td>
                    <?php 
                          if(($atd['in_time']==NULL) || ($atd['out_time']==NULL)){                            
                            $duration = "...";
                          }
                          else{
                            $time1 = new DateTime($atd['in_time']);
                            $time2 = new DateTime($atd['out_time']);
                            $interval = $time1->diff($time2);
                            $duration = $interval->format('%hhrs: %im: %ss');
                            /*
                            $time1 = new DateTime($atd['in_time']);
                            $time2 = new DateTime($atd['out_time']);
                            $interval = $time1->diff($time2);
                            $duration = $interval->format('%h Hours %i Minutes');
                            */
                          }
                    ?>
                    <td>
                      <?php if($atd['in_time']==NULL) {
                        
                      ?>
                        <a href="#" 
                        class="btn confirm-end-booking w-100" 
                        data-url="<?= base_url('master/cancelBooking?book_id=' . $atd['id'] . '&start=' . $start_time_format . '&end=' . $end_time_format); ?>"
                        style="background: linear-gradient(180deg, #031084, #000748);  font-size: 12px; color: white; border: none !important;">
                        Cancel</a>
                      <?php }else if ($atd['out_time']==NULL){
                        ?>
                        <a href="#" 
                        class="btn confirm-timeout-booking w-100" 
                        data-url="<?= base_url('master/timeoutForce?book_id=' . $atd['id'] . '&end=' . $end_time_format); ?>"
                        style="background: linear-gradient(180deg, #031084, #000748);  font-size: 12px; color: white; border: none !important;">
                          Timeout</a>
                        <?php }else{ ?>
                          <button 
                          class="btn w-100" 
                          style="background: linear-gradient(180deg, #031084, #000748);  font-size: 12px; color: white; border: none; opacity: 0.6; cursor: not-allowed;" 
                          disabled>
                          <?php 
                            if($atd['in_status'] == "occupied" && $atd['out_status'] == "exit"){
                              echo "Completed";
                            }
                            else if ($atd['in_status'] == "occupied" && $atd['out_status'] == "early-exit"){
                              echo "Early Exit";
                            }
                            else if ($atd['in_status'] == "occupied" && $atd['out_status'] == "late-exit"){
                              echo "Late Exit";
                            }
                            else if ($atd['in_status'] == "late-in" && $atd['out_status'] == "late-exit"){
                              echo "Late";
                            }
                            else if ($atd['in_status'] == "occupied" && $atd['out_status'] == "f-timeout"){
                              echo "Timed out";
                            }
                            else if ($atd['in_status'] == "cancelled" || $atd['out_status'] == "cancelled"){
                              echo "Cancelled";
                            }
                          ?>
                        </button>
                        <?php } ?> 
                    </td>
                    <td><?php
                      if ($atd['in_time'] == NULL){
                        echo "N/A";
                      }
                      else if ($atd['out_time'] == NULL && $atd['in_time'] != NULL){
                        echo "On going";
                      }
                      else if ($atd['out_time'] != NULL && $atd['in_time'] != NULL){
                        echo $duration;
                      }
                    ?> </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<!-- /.container-fluid -->

</div>


<?php

//display the current session values
$this->load->helper('toast');
if ($this->session->flashdata('success')) {
  echo getAlertMessages('success', $this->session->flashdata('success'));
}
if ($this->session->flashdata('error')) {
  echo getAlertMessages('error', $this->session->flashdata('error'));
}
if ($this->session->flashdata('neutral')) {
  echo getAlertMessages('neutral', $this->session->flashdata('neutral'));
}
if ($this->session->flashdata('warning')){
  echo getAlertMessages('warning', $this->session->flashdata('warning'));
}

$this->session->unset_userdata('success');
$this->session->unset_userdata('error');
$this->session->unset_userdata('neutral');
$this->session->unset_userdata('warning');

?>


<!-- End of Main Content -->
<script>
  $(document).ready(function () {
    // Initialize DataTable with sorting options
    $('#dataTable').DataTable({
      "order": [
        [1, 'desc'], // Sort by Date (Column index 1)
        [8, 'asc']  // Then sort by Time In (Column index 6)
      ],
      "columnDefs": [
        { "type": "datetime", "targets": [1] }, // Ensure proper sorting of date
        { "type": "time", "targets": [8] }     // Ensure proper sorting of time
      ],
      "paging": true,
      "searching": true,
      "info": true
    });

    // Export CSV button logic
    $('#exportCsv').on('click', function () {
      var csv = [];
      var rows = $(".table tr:visible");

      // Get headers
      var headers = [];
      $(rows[1]).find('th').each(function() {
        headers.push($(this).text().trim());
      });
      csv.push(headers.join(","));

      // Get data
      $(rows).slice(2).each(function() {
        var row = [];
        $(this).find('td').each(function() {
          var cellData = $(this).text().trim().replace(/(\r\n|\n|\r)/gm, ''); 
          cellData = cellData.replace(/"/g, '""');
          row.push('"' + cellData + '"');
        });
        csv.push(row.join(","));
      });

      // Download CSV
      var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
      var downloadLink = document.createElement("a");
      downloadLink.download = "Library Seat Attendance History.csv";
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.style.display = "none";
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    });
  });
</script>

<script>
  $('#dataTable').on('click', '.confirm-end-booking', function (e) {
    e.preventDefault();
    const url = this.getAttribute('data-url');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      //FOR CANCELATION
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Yes, cancel it!',
      cancelButtonColor: '#d33'
    }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
          title: 'Loading',
          html: 'Please wait while we process your request.',
          allowOutsideClick: false,
          showConfirmButton: false,
          showCancelButton: false,
          didOpen:() => {
            Swal.showLoading(); 
            setTimeout(() => {
              window.location.href = url;
            }, 3000);
          }
        });
      }
    });
  });

  $('#dataTable').on('click', '.confirm-timeout-booking', function (e) {
    e.preventDefault();
    const url = this.getAttribute('data-url');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      //FOR Timeout
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Yes, Timeout!',
      cancelButtonColor: '#d33'
    }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
          title: 'Loading',
          html: 'Please wait while we process your request.',
          allowOutsideClick: false,
          showConfirmButton: false,
          showCancelButton: false,
          didOpen:() => {
            Swal.showLoading(); 
            setTimeout(() => {
              window.location.href = url;
            }, 3000);
          }
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Get today's date
    const today = new Date();

    // Calculate the day after tomorrow
    const dayAfterTomorrow = new Date(today);
    dayAfterTomorrow.setDate(today.getDate() + 2);

    // Format date to YYYY-MM-DD
    const formattedDate = dayAfterTomorrow.toISOString().split('T')[0];

    // Set the min attribute for the date inputs
    $('#from_date, #to_date').attr('min', formattedDate);
  });
</script>

<script>
  $('#cancelAllModal').on('change', '#cancel', function() {
    if (this.value == 'specific') {
      $('#specific-date').slideDown();
    } else {
      $('#specific-date').slideUp();
    }
  });

  $('#cancelAllBookings').click(function() {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var room = $('#room').val();
    var cancel = $('#cancel').val();

    if (cancel == 'specific' && (from_date == '' || to_date == '')) {
      Swal.fire(
        'Error',
        'Please select the date range',
        'error'
      );
      return false;
    }

    console.log("HERE!");

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
      // Close the Bootstrap modal if it's open
      $('#cancelAllModal').modal('hide');
      if (result.value) {
        Swal.fire({
          title: 'Enter password',
          input: 'password',
          inputAttributes: {
            autofocus: 'autofocus' // Ensure the input gets focus
          }
        }).then((result) => {
          console.log("HERE!");
          if (result.value) {
            $.ajax({
              url: "<?= base_url('master/cancelAllbookings') ?>",
              type: 'POST',
              data: {
                from_date: from_date,
                to_date: to_date,
                room: room,
                cancel: cancel,
                password: result.value
              },
              success: function(response) {
                console.log("HERE!");
                if (response == 'success') {
                  console.log("HERE!");
                  Swal.fire({
                    title: 'Success!',
                    text: 'Waiting to update the table...',
                    icon: 'success',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                      Swal.showLoading();
                      setTimeout(() => {
                        location.reload();
                      }, 3000);
                    }
                  });
                } else {
                  Swal.fire(
                    'Error',
                    response,
                    'error'
                  );
                }
              }
            });
          }
        });
      }
    });
  });
</script>
