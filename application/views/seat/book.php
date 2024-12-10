<!-- Begin Page Content -->

<?php
/*
if(isset($_POST['room'])) {    
    $Selectedroom=1;
    $floorID= $_POST['floor'];
    $room_no=$_POST['room']; 
    echo "Selected Category: ";
    echo $room_no;
}
else{
  $Selectedroom=0;
  $floorID= 0;
  $room_no=0; 
}
*/
?>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <a href="<?= base_url('Seat'); ?>" class="btn btn-secondary btn-icon-split mb-4">
    <span class="icon text-white">
      <i class="fas fa-chevron-left"></i>
    </span>
    <span class="text">Back</span>
  </a>
  <!-- form action="" method="POST" class="col-lg-5  p-0" -->
  <form action="" method="POST" >
    <div class="row">      
      <div class="col-sm-3">        
        <div class="card">          
          <div class="card-body">
            <h5 class="card-title"> Select Date</h5>      
            <div class="form-group">
              <!-- label for="floor" class="col-form-label-lg">Floor</label -->
              <?php $date = date("Y-m-d", strtotime("today"));  ?> 
              <!-- label class="form-label" for="form3Example1m">Select date</label -->
              <input type="date" name="date_start" placeholder= "<?php echo $date ?>"  min="<?php echo $date ?>"  class="form-control form-control-sm" required >              
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">        
        <div class="card">          
          <div class="card-body">
            <h5 class="card-title">Floor select</h5>      
            <div class="form-group">
              <!-- label for="floor" class="col-form-label-lg">Floor</label -->
              <select class="form-control" name="floor" id="floor">          
                  <option value="">Select Floor</option>            
                  <option value='1'>GF</option>
                  <option value='2'>2F</option>
                  <option value='3'>3F</option>
                  <option value='4'>4F</option>
                  <option value='5'>5F</option>
                  <option value='6'>6F</option>
                  <option value='7'>7F</option>           
              <?= form_error('floor', '<small class="text-danger">', '</small>') ?>
              </select>
            </div>
          </div>
        </div>
      </div>    
      <div class="col-sm-6">
        <div class="card">                
          <div class="card-body">     
            <h5 class="card-title">Room Select</h5>             
            <div class="form-group">                
              <!-- label for="room" class="col-form-label-lg">Room </label -->
              <select class="form-control form-control-lg" name="room" id="room">            
              </select>
            </div>
          </div>
        </div>
      </div>  
    </div>    
    <div class="row">
      <div class="col-sm-12">
        <div class="card"> 
          <div class="card-body">              
            <div class="form-group">     
              <label for="todayroom" class="col-form-label-lg">Seat (Today) </label>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              </table>
              </div>                    
            </div>
          </div> 
        </div>
      </div>         
    </div>            
  </div>  
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

let roomdata = <?php echo json_encode($roomname); ?> ;                       
let seatno = <?php echo json_encode($seatcount);  ?> ;    
let seatstatus = <?php echo json_encode($slot);  ?> ;    


$(document).ready(function(){
  $("#floor").change(function(){
    var floorid = $(this).val();
    $("#room").html("");    
    if(floorid != ""){
      floorid= floorid-1;
      if(roomdata[floorid].length > 0){        
        for(var i = 0; i < roomdata[floorid].length; i++){          
          //console.log(roomdata[floorid][i].name);
          //console.log(seatno[floorid][i]);
          var option = $("<option></option>").text(roomdata[floorid][i].room+'('+seatno[floorid][i]+')').val(i);
          $("#room").append(option);
        }
      }
    }
  });

  $("#room").change(function(){
    var roomid = $(this).val();
    $("#slot").html("");    
    if(roomid != ""){                                    
      var table = document.createElement("table");
      var floorid = $("#floor").val();      
      var MaxSeat = seatno[floorid-1][roomid];
      console.log(MaxSeat);      
      for (var offset=0; offset <seatstatus.length; offset++){
        if(seatstatus[offset].Room ==roomdata[floorid-1][roomid].room){
          break;
        }
      }      
      table.border = "1";
      for (var i = 0; i <= MaxSeat; i++) {
        var row = table.insertRow();
        offset++;
        const timeslot = JSON.parse(seatstatus[offset].status);   
        console.log(timeslot);           
        for (var j = 6; j < 19; j++) { 
          var cell = row.insertCell();
          if(j==6){            
            cell.style.color = "#315D67";
            cell.textContent = i;
            cell.align="center"
          }
          else{
            if(i==0){
              let text1 = j;
              cell.style.color = "#FF0B0B";
              // cell.textContent = text1;
              cell.textContent = text1+':00';
              cell.align="center"
            }
            else{ 
              if(timeslot[j-6]==1)                           
                  cell.bgColor ="#FF0B0B";
              else 
                  cell.bgColor ="#11FAA6";
              cell.textContent = timeslot[j-6];
              cell.align="center"
              cell.setAttribute('onclick','showModal(j,i)');   
            }             
          }
        }
      }
      var tableContainer = document.getElementById("dataTable");
      tableContainer.innerHTML = "";
      tableContainer.append(table);
    }
  });
 
});
</script>
<div id="modal" class="modal-background">
  <div class="modal-content">                
    <span class="close-button" onclick="hideModal()">×</span>
    <p id="modal-value"></p>
  </div>
</div>

<script>
var modal = document.getElementById("modal");
var modalValue = document.getElementById("modal-value");
function showModal(value) {
      modalValue.innerHTML = value;
      modal.style.display = "block";
}
function hideModal() {

modal.style.display = "none";
}
</script>