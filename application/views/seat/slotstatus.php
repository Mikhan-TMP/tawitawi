<style>
/* Basic reset and styling */

/* Tooltip container */
.tooltip-container {
  position: relative;
  display: inline-block;
  /* margin: 20px; */
}

/* Icon styling */
.icon {
  width: 50px;
  height: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition:
    transform 0.3s ease,
    filter 0.3s ease;
}

/* SVG Animation: Rotate and scale effect */
.icon .fas {
  transition: transform 0.5s ease-in-out;
}

.icon:hover .fas {
  transform: rotate(360deg) scale(1.2);
}

/* Tooltip styling */
.tooltip {
  visibility: hidden;
  width: 200px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 10px;
  position: absolute;
  bottom: 125%; /* Position above the icon */
  left: 50%;
  margin-left: -100px; /* Center the tooltip */
  opacity: 0;
  transition:
    opacity 0.5s,
    transform 0.5s;
  transform: translateY(10px);
}

/* Tooltip Arrow */
.tooltip::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #333 transparent transparent transparent;
}

/* Show tooltip on hover */
.tooltip-container:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
}

@keyframes bounce {
  0%,
  20%,
  50%,
  80%,
  100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-30px);
  }
  60% {
    transform: translateY(-15px);
  }
}

.tooltip-container:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
  animation: bounce 0.6s ease;
}

</style>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <!-- Data Table Department-->
  <div class="row">
    <div class="col-sm-12 col-lg-12 ml-auto ">
      <form action="" method="GET">
        <div class="row">          
          <div class="col-2">
            <input type="date" name="start" placeholder= "<?php echo $date ?>" value=<?= $date ?> class="form-control">            
            <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
          </div>         
          <div class="col-3">
            <select class="form-control" name="room">              
              <option value="all">All</option>
              <?php foreach ($roomlist as $d) : ?>
                <option value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="col-sm-1 col-1">
            <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block text-white" style="background: linear-gradient(180deg, #031084, #000748);  width: 100px;  border:none; border-radius: 15px">
                <i class="fa fa-search"></i>
                Show</button>             
          </div>
          <!-- div class="col-sm-1 col-1">
              <button type="submit" name="submit" value="Print"  class="btn btn-success btn-fill btn-block">Print</button>
          </div>
          <div class="col-sm-1 col-1">
            <button type="submit"  name="submit" value="Export" class="btn btn-success btn-fill btn-block">Export</button>
          </div -->
        </div>
      </form>
    </div>
  </div><br>
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex" 
                    style="justify-content: space-between;
                          border-top-left-radius: 15px;
                          border-top-right-radius: 15px;
                          background: linear-gradient(180deg, #031084, #000748); 
              ">
            <h6 class="m-0 text-light" 
                    style="font-size:1.5rem;
                    font-family: 'Inter', sans-serif;">Seat Status in <?php echo $date ?></h6>
          </div>
    <!-- <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-gray-700">Seat Status in <?php echo $date ?></h6>
    </div> -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
          <thead style="color: #272727; font-weight: 500;">
            <tr>                      
              <th>ID</th>
              <th>Floor</th>
              <th>Area</th>
              <th>Seat</th>
              <th>8-9AM </th>
              <th>9-10AM</th>
              <th>10-11AM</th>
              <th>11AM-12PM</th>
              <th>12PM-1PM</th>
              <th>1PM-2PM</th>
              <th>2PM-3PM</th>
              <th>3PM-4PM</th>
              <th>4PM-5PM</th>
              <th>5PM-6PM</th>
              <th>6PM-7PM</th>

              
              
              <!-- <th>8-9 AM</th>
              <th>9-10 AM</th>
              <th>10-11 AM</th>
              <th>11-12 PM</th>
              <th>12-1 PM</th>
              <th>1-2 PM</th>
              <th>2-3 PM</th>
              <th>3-4 PM</th>
              <th>4-5 PM</th>
              <th>5-6 PM</th> -->
            </tr>
          </thead>
          
          <tbody style="color: #272727;">
            <?php
            $i = 1;
            foreach ($slot as $dpt) :
            ?>
              <tr>                        
                <?php
                $slottemp = trim($dpt['status'], "[");
                $slottemp = trim($slottemp, "]");                        
                $timeslot = explode(",",$slottemp) ;                        
                ?>
                <td class="align-middle"><?= $dpt['id']; ?></td>
                <td class="align-middle"><?= $dpt['Floor']; ?></td>
                <td class="align-middle"><?= $dpt['Room']; ?></td>
                <td class="align-middle"><?= $dpt['Slot']; ?></td>

                <?php
                $slot_elements = count(explode(',',$dpt['status']));
                for($i=0;$i < $slot_elements; $i++){ 
                          if ($timeslot[$i]==1) {  ?>
                            <td class="align-middle" >
                              <div class="tooltip-container">
                                <div class="icon">
                                  <i class="fas fa-chair" style="font-size:30px;color: #f32133;"></i>
                                </div>
                                <div class="tooltip">
                                  <p>Seat # <?php echo $dpt['Slot']; ?> is not avaiable for this time slot. </p>
                                </div>
                              </div>
                            </td> 
                          <?php } else { ?>
                            <td class="align-middle">
                            <!-- <i class="fas fa-chair" style="font-size:30px;color:#6bc1e6"></i> -->
                            <div class="tooltip-container">
                              <div class="icon">
                                <i class="fas fa-chair" style="font-size:30px;color:#6bc1e6"></i>
                              </div>
                              <div class="tooltip">
                                <p>Seat # <?php echo $dpt['Slot']; ?> is avaiable for this time slot. </p>
                              </div>
                            </div>
                            </td> 
                          <?php } 
                      } ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->