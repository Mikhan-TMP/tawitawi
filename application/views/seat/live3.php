<!-- <meta http-equiv="refresh" content="5"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>

#clock {
    font-family: Arial, sans-serif;
    text-align: center;
    font-size: 5em;
    background-color: purple;
    color: white;
    margin-top: 20px;
}
</style>
<div class="row">
    <div class="col-sm-12 col-lg-12 ml-auto">
      <form id="monitoringForm" method="GET">
        <div class="row">
          <div class="col-2">
            <select class="form-control" name="room" id="roomSelect">
              <option value="">Select Floor</option>
              <?php foreach ($roomlist as $d) : ?>
                <option value="<?= $d; ?>"><?= $d; ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="col-sm-1 col-1">
            <button type="button" onclick="submitForm()" class="btn btn-success btn-fill btn-block">Show</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <br><br>
</div>

<div class="container-fluid">  <br>
<h1 class="h3 mb-4 pt-3 text-gray-800"><?= $title; ?></h1>
        <div class="card-group">    
        <?php $i = 0;
            foreach ($slotdata as $slot){ ?> 
        <div class="col-xl-2 col-md-2 mb-1">
            <?php if ($slot['status']==1) { ?>
            <div class="card text-white shadow py-2" style="background-color: #C41E3A;">
            <?php } else if($slot['status']==0) { ?>
            <div class="card border-left-info shadow  py-2" >
            <?php } else {?>
            <div class="card text-white shadow  py-2" style="background-color: #187E59;">
            <?php } ?>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-start">
                            <div class="font-weight-bold" style="font-size: 35px;"><?= $slot['id'] ?></div>
                        </div>
                        <div class="col">
                            <div class="text-xs font-weight-bold text-white text-center mb-1" style="font-size: 13px;"> <?= $slot['name'] ?></div>
                            <!-- <div class="text-xs font-weight-bold text-white text-center mb-1"> <?= $slot['name'].": ".$slot['id'] ?></div> -->
                            <?php if ($slot['status']==1) { ?>
                                <div class="h2 text-center mb-0 font-weight-bold text-white-400"><?= $slot['time'] ?> </div>
                                <div class="text-xs font-weight-bold text-white text-center mb-1">Occupied</div>
                            <?php } else if($slot['status']==0) { ?>
                                <div class="h3 text-center font-weight-bold text-gray-400">Vacant</div>                            
                            <?php } else {?>
                                <div class="h2 text-center mb-0 font-weight-bold text-white-400"> <?= $slot['time'] ?> </div>
                                <div class="text-xs font-weight-bold text-white text-center mb-1">Available</div>
                            <?php } ?>
                        </div>
                        <div class="col-end">
                            <?php if ($slot['status'] ==0) { ?>
                            <i class="fas fa-clock fa-2x text-white-300"></i>
                            <?php } else if($slot['status']==1) { ?>
                            <!-- <i class="fas fa-spinner fa-2x text-black-300" ></i> -->
                            <i class="fas fa-clock fa-2x text-black-300" ></i>
                            <?php } else {?>
                            <i class="fas fa-hourglass fa-2x text-black-300"></i>
                            <?php } ?>                        
                        </div>   
                    </div>                 
                </div>
            </div>
        </div>
        <?php } ?>  
    </div   
    
    

</div>
<script>
var clock = document.getElementById("clock");
function updateClock() {
var date = new Date();
var hours = date.getHours().toString().padStart(2, "0");
var minutes = date.getMinutes().toString().padStart(2, "0");
var seconds = date.getSeconds().toString().padStart(2, "0");
clock.textContent = date.toDateString() + "    "+hours + ":" + minutes + ":" + seconds;
}
setInterval(updateClock, 1000);
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatables').DataTable();

    $("#slotsSideTree").addClass('active');
    $("#manageSlotsSideTree").addClass('active');
  });
</script>
<script>
    $(document).ready(function() {
      setInterval(refreshScreen, 3000); // Refresh every 3 seconds
      function refreshScreen() {
        $('#datatables').load(' #datatables');          
      }
    });
 </script>
          