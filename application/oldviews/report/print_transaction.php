<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="<?= base_url('images/'); ?>LIBRARY.png" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Library Room Transaction History</title>
</head>
<a id="printButton" class="btn btn-success m-5" href="<?= base_url('report/transaction_room/')?>">Back</a>
<style>
  @media print {
    #printButton {
      display: none;
    }
  }
</style>
<body>
  <div class="container border">
    <div class="col text-center p-2">
      <img src="<?= base_url('images/'); ?>LIBRARY.png" alt="" width="100px">
      <h5 class="h5">Mindanao State University - General Santos City</h5>

    </div>
    <div class="row mb-2">
      <div class="col">
        <h2 class="text-center">Library Room Transaction History</h2>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-6">
        <h1 class="h5">Building Code : <?= $room; ?> </h1>
      </div>
      <div class="col-6 text-right">
            <h1 class="h5">Date : <?= $start; ?> ~ <?= $end; ?></h1>
      </div>
    </div> 
    
        
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
                    <th >#</th>
                    <th>Date</th>
                    <th>Floor</th> 
                    <th>Room Name</th>                                         
                    <th>Reserved Hour</th> 
                    <th>Used Hour </th> 
                    <th>Usage(%)</th>
          
        </tr>
      </thead>
      <tbody style = "color: #272727;">
                <?php
                $i = 1;

                foreach ($transactions as $transactions) {
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
                            echo sprintf("%2dhrs-%2dmins-%2dsec", $hours, $minutes, $seconds);
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
  


  <!-- Optional JavaScript -->
  <script>
    window.print();
  </script>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>