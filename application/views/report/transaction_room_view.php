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
      <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      <!-- <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a>       -->
    </div>
  </div>
  <div class="row">
      <!-- a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Attend_export/createexcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
      <a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Report/attend_print"><i class="fa fa-file-excel-o"></i> PDF</a -->
      <div class="col-sm-12 col-lg-12 ml-auto ">
        <form action="" method="GET" id="myForm">
          <div class="row d-flex flex-wrap ml-2" style="gap: 10px">
            <?php $date = date("Y-m-d", strtotime("today"));  ?>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">From:</label>
              <div class="">
                <input type="date" name="start" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>"  class="form-control" >            
                <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">To:</label>
              <div class="">
                <input type="date" name="end" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>" class="form-control" >                 
                <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">Area:</label>
                <div class="">
                <select class="form-control" name="room">              
                  <option value="">All</option>
                  <?php foreach ($roomlist as $d) : ?>
                    <option value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option>
                  <?php endforeach; ?>
                </select>
                <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
            </div>

            <!-- <h5 class="mt-1 ml-2">Area:</h5> -->
            <div class="buttons d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px" >
              <div class="">
                <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block text-white" style="background: linear-gradient(180deg, #031084, #000748);  padding: 10px; width: 100px;  border:none; border-radius: 15px">
                <i class="fa fa-search"></i>
                Show</button>            
              </div>
              <div class="">
                  <button type="submit" name="submit" value="Print"  class="btn btn-success btn-fill btn-block text-white"
                  style="background: linear-gradient(180deg, #031084, #000748);  padding: 10px; width: 100px; border:none; border-radius: 15px">
                  <i class="fa fa-print"></i>
                  Print</button>
              </div>
              <div class="">
                <button  id="exportCsv" onclick="event.preventDefault();" class="text-white"
                style="background: linear-gradient(180deg, #031084, #000748);  border:none; padding: 10px; width: 100px; border-radius: 15px">
                <i class="fa fa-file-excel"></i>
                Export</button>
              </div>
            </div>
          </div>
        </form>
      </div>
  </div><br>
  <!-- End of row show -->
  <?php if ($book == false) : ?>
    <h1>No Data, Please Pick Your Date and Building</h1>
  <?php else : ?>


    <?php if ($book != null) : ?>
      
      <!-- Export exel and PDF -->

      <div class="card shadow mb-4" style="border-radius: 15px;">
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

          <!-- script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
         
          <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-1169273815439326"
            data-ad-slot="1311700855"
            data-ad-format="auto"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script -->

          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead style="color: #272727; font-weight: 500;">
                <tr>
                  <tr>
                    <th >#</th>
                    <th class="header">Transaction ID</th>
                    <th class="header">Floor</th> 
                    <th class="header">Area Name</th>                                         
                    <th class="header">Reserved Hour</th> 
                    <th class="header">Used Time</th> 
                    <th class="header">Usage(%)</th>
                  </tr>
              </thead>
              
              <tbody style = "color: #272727;">
                <?php
                $i = 1;

                foreach ($book as $transactions) {
                  $area_room = $transactions['room'];
                  $area_floor = $transactions['floor'];

                  $area_info = $this->db->get_where('area', ['room' => $area_room, 'floor' => $area_floor])->row_array();
                  $open_time = $area_info['opentime'];
                  $close_time = $area_info['closetime'];
                  ?>
                  <tr>
                    <td colspan="1"><?php echo $i++;?></td>
                    <td colspan="1"><?php echo $transactions['id'];?></td>
                    <td colspan="1"><?php echo $transactions['floor'];?></td>
                    <td colspan="1"><?php echo $transactions['room'];?></td>
                    <td colspan="1"><?php
                      //Reserved Hour:
                      //get the start time index and end time index
                      $end_time_index = $transactions['end_time'];
                      $start_time_index = $transactions['start_time'];
                      //get the equivalent of time of the time index
                      
                      // Convert $open_time and $close_time to timestamps
                      $open_time_timestamp = strtotime($open_time);
                      $close_time_timestamp = strtotime($close_time);

                      if ($open_time_timestamp !== false && $close_time_timestamp !== false) {
                          // Format the times
                          $formatted_open_time = date('H:i:s', $open_time_timestamp);
                          $formatted_close_time = date('H:i:s', $close_time_timestamp);
                          // Generate the time index
                          $timesIndex = array();
                          $counter = 0;
                          // Loop to generate time slots
                          for ($time = $open_time_timestamp; $time <= $close_time_timestamp; $time = strtotime('+1 hour', $time)) {
                              $timesIndex[$counter] = date('H:i', $time); // Convert timestamp to 'H:i' format
                              $counter++;
                          }
                      } else {
                          echo "Invalid open or close time.";
                      }

                      $start_time = $timesIndex[$start_time_index];
                      $end_time = $timesIndex[$end_time_index];
                      $start_time_timestamp = strtotime($start_time);
                      $end_time_timestamp = strtotime($end_time);
                      $reserved_hour = ceil(abs($end_time_timestamp - $start_time_timestamp) / 3600);
                      // echo $start_time . " - " . $end_time;
                      // echo "<br>";
                      echo $reserved_hour . " hours";
                    ?></td>
                    <td colspan="1"><?php 
                        //Used Hour:
                        //get the out_time of the booking
                        $out_time = $transactions['out_time'];
                        $in_time = $transactions['in_time'];
                        // echo $out_time;
                        // echo "<br>";
                        // echo $in_time;
                        // echo "<br>";
                        if ($out_time!= null) {
                            $out_time_timestamp = strtotime($out_time);
                            $in_time_timestamp = strtotime($in_time);
                            $diff = $out_time_timestamp - $in_time_timestamp;
                            $hours = floor($diff / 3600);
                            $minutes = floor(($diff % 3600) / 60);
                            $seconds = $diff % 60;
                            echo sprintf("%2dhrs:%2dmins", $hours, $minutes, $seconds);
                        } else {
                            echo "On Going";
                        }
                    ?></td>
                    <td colspan="1"><?php 
                      //usage
                      if ($out_time!= null || $in_time!= null) {
                        if ($transactions['in_status'] == "cancelled" || $transactions['out_status'] == "cancelled") {
                          echo "Cancelled";
                        }
                        else if ($transactions['in_status'] == "occupied" && $transactions['out_status'] == "exit") {
                          $out_time_timestamp = strtotime($out_time);
                          $in_time_timestamp = strtotime($in_time);
                          $diff = $out_time_timestamp - $in_time_timestamp;
                          
                          // Calculate total time used in hours (including fractional hours for minutes and seconds)
                          $total_used_hours = $diff / 3600; // Convert total seconds to hours
                          
                          // Calculate usage percentage
                          $usage = round(($total_used_hours * 100) / $reserved_hour, 2);
                          
                          // Output the usage percentage
                          echo $usage . "%";
                        }
                        else if ($transactions['in_status'] == "occupied" && $transactions['out_status'] == "early-exit") {
                          $out_time_timestamp = strtotime($out_time);
                          $in_time_timestamp = strtotime($in_time);
                          $diff = $out_time_timestamp - $in_time_timestamp;
                          
                          // Calculate total time used in hours (including fractional hours for minutes and seconds)
                          $total_used_hours = $diff / 3600; // Convert total seconds to hours
                          
                          // Calculate usage percentage
                          $usage = round(($total_used_hours * 100) / $reserved_hour, 2);
                          
                          // Output the usage percentage
                          echo $usage . "%";
                        }
                        else if ($transactiosn['in_status'] == "occupied" && $transactions['out_status'] == "late-exit") {
                          $out_time_timestamp = strtotime($out_time);
                          $in_time_timestamp = strtotime($in_time);
                          $diff = $out_time_timestamp - $in_time_timestamp;
                          
                          // Calculate total time used in hours (including fractional hours for minutes and seconds)
                          $total_used_hours = $diff / 3600; // Convert total seconds to hours
                          
                          // Calculate usage percentage
                          $usage = round(($total_used_hours * 100) / $reserved_hour, 2);
                          
                          // Output the usage percentage
                          echo $usage . "%";
                        }
                      }
                    ?></td>
                  </tr> 
                  <?php
                }
                ?>
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
<!-- End of Main Content -->

<script>
$(document).ready(function () {
    // Initialize DataTable
    var table = $('#dataTable').DataTable();

    $('#exportCsv').on('click', function (e) {
        e.preventDefault();

        // Step 1: Destroy DataTable instance and remove the 'id' attribute to get all rows
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            table.destroy();
        }
        $('#dataTable').removeAttr('id');

        // Step 2: Generate CSV
        var csv = [];
        var rows = $(".table tr:visible");

        // Get headers
        var headers = [];
        $(rows[1]).find('th').each(function () {
            headers.push($(this).text().trim());
        });
        csv.push(headers.join(","));

        // Get data
        $(rows).slice(2).each(function () {  // Skip filter row
            var row = [];
            $(this).find('td').each(function () {
                var cellData = $(this).text().trim().replace(/(\r\n|\n|\r)/gm, '');
                cellData = cellData.replace(/"/g, '""');  // Escape double quotes
                row.push('"' + cellData + '"');  // Enclose in double quotes
            });
            csv.push(row.join(","));
        });

        // Download CSV
        var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        var downloadLink = document.createElement("a");
        downloadLink.download = "Library Transaction Report.csv";
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);

        // Step 3: Reassign 'id' and reinitialize DataTable
        $('.table').attr('id', 'dataTable');
        table = $('#dataTable').DataTable();
    });
});
</script>
