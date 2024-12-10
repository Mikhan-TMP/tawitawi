<!-- Begin Page Content -->

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Room Reservation</h1>
  <!-- <a href="<?= base_url('Seat/bookroom'); ?>" class="btn btn-secondary btn-icon-split mb-4">
    <span class="icon text-white">
      <i class="fas fa-chevron-left"></i>
    </span>
    <span class="text">Back</span>
  </a> -->
  <!-- form action="" method="POST" class="col-lg-5  p-0" -->
  <form action="" method="POST" >
    <div class="row">
      <div class="col-2"> 
        <?php $cdate = date("Y-m-d", strtotime("today"));  ?>               
        <?php $maxdate = date("Y-m-d", strtotime("today + 15 days"));  ?>
        <!-- input type="date" name="atdate" placeholder= "<?php echo $date ?>"  min="<?php echo $cdate ?>" max="<?php echo $maxdate ?>"  class="form-control form-control-sm" required  -->
        <input type="date" name="atdate" placeholder= "<?php echo $date ?>"    class="form-control form-control-sm" required  >
      </div>
      <div class="col-3">         
        <select class="form-control form-control-sm" id="roomname" name ="roomname" aria-label="Default select example" required>
          <option value="" selected>Select room</option>
          <option value="" selected>All</option>
          <?php foreach ($roomlist as $dpt) : ?>
            <option value="<?= $dpt['room']; ?>"> <?php echo ($dpt['room'].':'.$dpt['slotnumber'].':'.$dpt['opentime'].'~'.$dpt['closetime']); ?></option>
          <?php endforeach; ?>          
        </select>        
      </div>
      <div class="col-sm-1 col-1 mb-4">
          <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block text-white" style="background: linear-gradient(180deg, #BE110E, #630908); width: 100px;  border:none; border-radius: 15px">
              <i class="fa fa-search"></i>
              Show</button>            
      </div>
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header py-3 d-flex" 
                            style="justify-content: space-between;
                                  border-top-left-radius: 15px;
                                  border-top-right-radius: 15px;
                                  background: linear-gradient(180deg, #BE110E, #630908);
                      ">
                    <h6 class="m-0 text-light" 
                            style="font-size:1.5rem;
                            font-family: 'Inter', sans-serif;"><?php echo "Room (".$date.")" ?>
                            | <span  style="text-align: left;" class="col-form-label-lg"><?php echo "Open Time :".$dpt['opentime'].'~'.$dpt['closetime'] ?></span>   
                          </h6>
                            
                  </div>
          <div class="card-body">              
            <div class="form-group">                   
              <!-- <label for="todayroom" class="col-form-label-lg"><?php echo "Room (".$date.")" ?></label> -->
              <!-- <label  style="text-align: left;" class="col-form-label-lg"><?php echo "Open Time :".$dpt['opentime'].'~'.$dpt['closetime'] ?></label>              -->
              <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                  <thead style="color: #272727; font-weight: 500;">
                    <tr>                      
                      <th>ID</th>
                      <th>Floor</th>
                      <th>Room Name</th>     
                      <?php for ($i=0;$i<11;$i++){ ?>
                            <th> <?='# '.strval($i+1) ?></th>
                            <?php } ?>
                    </tr>
                  </thead>
                  <tbody style="color: #272727;">
                    <?php                        
                    $i = 1;
                    foreach ($roomslot as $slot) :                        
                    ?>
                      <tr>
                        <?php
                        $slottemp = trim($slot['status'], "[");
                        $slottemp = trim($slottemp, "]");
                        //  $timeslot = explode(",",$slotdata->status) ;
                        $timeslot = explode(",",$slottemp) ;
                        // echo gettype($timeslot);
                        // print_r($timeslot);
                        ?>
                        <td class="align-middle"><?= $slot['id']; ?></td>
                        <td class="align-middle"><?= $slot['floor']; ?></td>
                        <td class="align-middle"><?= $slot['room']; ?></td>   
                        <?php for($i=0;$i< $slot['operationtime']; $i++){  
                                  if ($timeslot[$i]==1) {  ?>
                                    <td ><i class="fas fa-clock" style="font-size:40px;color:#f32133"></i><?=date('H:i', strtotime($slot['opentime'].strval($i).' hour')) ?></td> 
                                  <?php } else { ?>
                                    <!-- td onclick= "showModal('Reservation')" >E</td --> 
                                    <!-- td onclick="alert('reservation')" --> 
                                    <td> <a href="<?= base_url('seat/e_room/'). $slot['id'].'/'.$i ?>"  class="btn btn-primary btn-circle">
                                    <span class="icon text-white" ><i class="fas fa-edit"></i></span> </a><?=date('H:i', strtotime($slot['opentime'].strval($i).' hour')) ?></td > 
                                  <?php } 
                              } ?>  
                        </td>
                        <td></td>
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
  </div>    
</div>



<script>
  var modal = document.getElementById("modal");
  var span = document.getElementsByClassName("close")[0];
  var message = document.getElementById("message");
  // var modalValue = document.getElementById("modal-value");

  function showModal(msg) {
      message.innerHTML = msg; // Set the message text
      modal.style.display = "block"; // Display the modal
  }


  function hideModal() {
      modal.style.display = "none";
  }
  span.onclick = function() {
      hideModal();
  }
  window.onclick = function(event) {
        if (event.target == modal) {
            hideModal();
        }
  }

</script>