       <!-- Begin Page Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<div class="container-fluid">

         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
         </div>

         <!-- Content Row -->
          <div class="row">

           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-primary h-75" style="box-shadow: 4px 5px 5px -3px #00000082; background-color:white;" >
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-muted mb-1">Library Room</div>                     
                     <div class="h5 mb-0 font-weight-bold text-dark mb-4"><?php echo $room_list ?></div>
                   </div>
                   <div class="col-auto">
                    <i class="fa-solid fa-door-open text-white"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-md-6 mb-4">
             <div class="card border-left-primary h-75" style="box-shadow: 4px 5px 5px -3px #00000082; background-color:white;" >
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-muted mb-1">Total Seat</div>
                     <div class="h5 mb-0 font-weight-bold text-dark mb-4"><?php echo ($area_slot) ?></div>
                   </div>
                   <div class="col-auto">
                    <i class="fa-solid fa-chair text-white"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-primary h-75" style="box-shadow: 4px 5px 5px -3px #00000082; background-color:white;" >
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-muted mb-1">Total student</div>
                     <div class="h5 mb-0 font-weight-bold text-dark mb-4"><?= $student_list; ?> </div>
                   </div>
                   <div class="col-auto">
                    <i class="fa-solid fa-user text-white"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <!-- Pending Requests Card Example -->
           <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-primary h-75" style="box-shadow: 4px 5px 5px -3px #00000082; background-color:white;" >
               <div class="card-body">
                 <div class="row no-gutters align-items-center">
                   <div class="col mr-2">
                     <div class="text-xs font-weight-bold text-muted mb-1">Librarian</div>
                     <div class="h5 mb-0 font-weight-bold text-dark mb-4"><?= $kios_list; ?></div>
                   </div>
                   <div class="col-auto">
                    <i class="fa-solid fa-users text-white"></i>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         

         <!-- Content Row -->

         <div class="row">           
           <div class="col-xl-6 col-lg-6">
             <!-- Pie Chart -->
             <div class="col p-0">
               <div class="card shadow mb-4">
                 <!-- Card Header - Dropdown -->
                 <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-secondary">Daily Reservation Status </h6>
                 </div>
                 <!-- Card Body -->                 
                 <div class="card-body" style="max-height: 400px; overflow: scroll; overflow-x : hidden;">
                   <table class="table">
                     <thead class="text-white" style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);color: #6f1926;">
                       <tr>
                         <th scope="col">Date</th>
                         <?php foreach ($location as $loc) : ?>
                          <th scope="col" style="font-size: 12px;"><?= $loc['name']?></th>
                         <?php endforeach; ?>                        
                         <th scope="col" style="font-size: 12px;">Total</th>
                       </tr>
                     </thead>
                     <tbody>
                        <?php for($i=0; $i<31;$i++) { ?>
                          <tr>
                            <td><?= $Sdate_list[$i] ?></td>
                            <td><?= $bookingdaily[1][$i] ?></td>
                            <td><?= $bookingdaily[2][$i] ?></td>
                            <td><?= $bookingdaily[3][$i] ?></td>
                            <td><?= $bookingdaily[4][$i] ?></td>
                            <td><?= $bookingdaily[5][$i] ?></td>
                            <td><?= $bookingdaily[6][$i] ?></td>
                            <td><?= $bookingdaily[7][$i] ?></td>
                            <td><?= $bookingdaily[0][$i] ?></td>
                            
                          </tr>
                        <?php } ?>
                      </tbody>                      
                   </table>
                 </div>
               </div>
             </div>
           </div>  
           <div class="col-xl-6 col-lg-6">
             <!-- Pie Chart -->
             <div class="col p-0">
               <div class="card shadow mb-4">
                 <!-- Card Header - Dropdown -->
                 <div class="card-header py-3 d-flex flex-rowz align-items-center justify-content-between">
                   <h6 class="m-0 font-weight-bold text-secondary">Daily Attendance Status</h6>                   
                 </div>
                 <!-- Card Body -->
                 <div class="card-body" style="max-height: 400px; overflow: scroll; overflow-x : hidden;">
                  <table class="table">
                     <thead class="text-white" style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);color: #6f1926;">
                       <tr>
                       <th scope="col">Date</th>
                         <?php foreach ($location as $loc) : ?>
                          <th scope="col" style="font-size: 12px;"><?= $loc['name']?></th>
                         <?php endforeach; ?>                        
                         <th scope="col" style="font-size: 12px;">Total</th>
                       </tr>
                     </thead> 
                     <tbody>                    
                       <?php for($i=0; $i<31;$i++) { ?>
                          <tr>
                            <td><?= $Sdate_list[$i] ?></td>
                            <td><?= $attenddaily[1][$i] ?></td>
                            <td><?= $attenddaily[2][$i] ?></td>
                            <td><?= $attenddaily[3][$i] ?></td>
                            <td><?= $attenddaily[4][$i] ?></td>
                            <td><?= $attenddaily[5][$i] ?></td>
                            <td><?= $attenddaily[6][$i] ?></td>
                            <td><?= $attenddaily[7][$i] ?></td>
                            <td><?= $attenddaily[0][$i] ?></td>
                            
                          </tr>
                        <?php } ?>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
          </div>
          <!-- Graphs -->
          

          <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="col p-0">
                  <div class="card shadow mb-4">
                  <canvas id="myChart3" style="width:100%;max-width:800px;padding: 20px;"></canvas>
                </div>
            </div>
          </div>

          <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <canvas id="myChart4" style="width:100%;max-width:800px;padding: 20px;"></canvas>
              </div>
          </div>
          
          <!-- <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="col p-0">
                  <div class="card shadow mb-4">
                  <canvas id="myChart5" style="width:100%;max-width:600px;padding: 20px;"></canvas>
                </div>
            </div>
          </div> -->
        </div>
      </div>
</div>

      <!-- Graphs Building 1 -->
          <script>
                var xValues = ["1", "2", "3", "4", "5","6", "7", "8", "9", "10","11", "12", "13", "14", "15","16", "17", "18", "19", "20","21", "22", "23", "24", "25","26", "27", "28", "29", "30","31"];
                var yValues = [55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35];
                var barColors = ["red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown"];
            
            new Chart("myChart1", {
              type: "bar",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: barColors,
                  data: yValues
                }]
              },
              options: {
                legend: {display: false},
                title: {
                  display: true,
                  text: "building #1"
                }
              }
            });
          </script>
            
        
        <!-- Graphs Building 2 -->
            <script>
                var xValues = ["1", "2", "3", "4", "5","6", "7", "8", "9", "10","11", "12", "13", "14", "15","16", "17", "18", "19", "20","21", "22", "23", "24", "25","26", "27", "28", "29", "30","31"];
                var yValues = [55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35];
                var barColors = ["red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown"];

            
            new Chart("myChart2", {
              type: "bar",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: barColors,
                  data: yValues
                }]
              },
              options: {
                legend: {display: false},
                title: {
                  display: true,
                  text: "building #2"
                }
              }
            });
            </script>     
            

            <!-- Graphs Building 3 -->
            <script>                                
                var xValues = <?php  echo json_encode($Sdate_list) ?>;                
                var yValues = <?php echo '[' . implode(',', $bookingdaily[0]) . ']'; ?> ;                               

            new Chart("myChart3", {
              type: "bar",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: "#74B72E",
                  data: yValues
                }]
              },
              options: {
                legend: {display: false},
                title: {
                  display: true,
                  text: "Daily Reservation status"
                }
              }
            });
            </script>

            <!-- Graphs Building 4 -->
            <script>
              var xValues = <?php  echo json_encode($Sdate_list) ?>;                
              var yValues = <?php echo '[' . implode(',', $attenddaily[0]) . ']'; ?> ;                                             

            new Chart("myChart4", {
              type: "bar",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: "#1560BD",
                  data: yValues
                }]
              },
              options: {
                legend: {display: false},
                title: {
                  display: true,
                  text: "Daily Attendance status"
                }
              }
            });
            </script>

            <!-- Graphs Building 5 -->
            <script>
                var xValues = ["1", "2", "3", "4", "5","6", "7", "8", "9", "10","11", "12", "13", "14", "15","16", "17", "18", "19", "20","21", "22", "23", "24", "25","26", "27", "28", "29", "30","31"];
                var yValues = [55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35,55, 49, 44, 24,35];
                var barColors = ["red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown","red", "green","blue","orange","brown"];
            new Chart("myChart5", {
              type: "bar",
              data: {
                labels: xValues,
                datasets: [{
                  backgroundColor: barColors,
                  data: yValues
                }]
              },
              options: {
                legend: {display: false},
                title: {
                  display: true,
                  text: "building #5"
                }
              }
            });
            </script>