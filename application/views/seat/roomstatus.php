        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Room Status</h1>

          <div class="row">
          <div class="col-sm-12 col-lg-12 ml-auto ">
      <form action="" method="GET">
        <div class="row">          
          <div class="col-2">
            <input type="date" name="start" placeholder= "<?php echo $date ?>" value=<?= $date ?>   class="form-control" >            
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
            <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block text-white" style="background: linear-gradient(180deg, #BE110E, #630908); width: 100px;  border:none; border-radius: 15px">
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

          <!-- Data Table Department-->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex" 
                            style="justify-content: space-between;
                                  border-top-left-radius: 15px;
                                  border-top-right-radius: 15px;
                                  background: linear-gradient(180deg, #BE110E, #630908);
                      ">
                    <h6 class="m-0 text-light" 
                            style="font-size:1.5rem;
                            font-family: 'Inter', sans-serif;">Room Status in <?php echo $date ?></h6>
                  </div>
            <!-- <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-gray-700">Room Status in <?php echo $date ?></h6>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                  <thead style="color: #272727; font-weight: 500;">
                    <tr>                      
                      <th>ID</th>
                      <th>Floor</th>
                      <th>Room Name</th>                      
                      <th>8AM</th>
                      <th>9AM</th>
                      <th>10AM</th>
                      <th>11AM</th>
                      <th>12PM</th>
                      <th>1PM</th>
                      <th>2PM</th>
                      <th>3PM</th>
                      <th>4PM</th>
                      <th>5PM</th>
                      <th>6PM</th>
                      <!-- th>Actions</th -->
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
                        //  $timeslot = explode(",",$slotdata->status) ;
                        $timeslot = explode(",",$slottemp) ;
                        // echo gettype($timeslot);
                        // print_r($timeslot);
                        ?>
                        <td class="align-middle"><?= $dpt['id']; ?></td>
                        <td class="align-middle"><?= $dpt['floor']; ?></td>
                        <td class="align-middle"><?= $dpt['room']; ?></td>                        
                        <?php for($i=0;$i < 11; $i++){ 
                                  if ($timeslot[$i]==1) {  ?>
                                    <!-- <td class="align-middle" ><a href="<?= base_url('Seat/v_room?').'room='.$dpt['room'].'&'.'slot='.$i.'&'.'date='.$date ?>"><i class="fas fa-clock" style="font-size:30px;color:#f32133"></i></td>  -->
                                    <td class="align-middle"><i class="fas fa-clock" style="font-size:30px;color:#f32133"></i></td> 
                                  <?php } else { ?>
                                    <!-- <td class="align-middle"><i class="fas fa-circle" style="font-size:30px;color:#28a745" title="Available"></i></td> -->
                                    <td class="align-middle"><i class="fas fa-edit" style="font-size:30px;color:#6bc1e6"></i></td> 
                                  <?php } 
                             } ?>                        
                        <!--td class="align-middle text-center">
                          <a href="<?= base_url('master/e_room/') . $dpt['id'] ?>" class="btn btn-primary btn-circle">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> 
                          <a href="<?= base_url('master/d_room/') . $dpt['id'] ?>" class="btn btn-danger btn-circle" onclick="return confirm('Deleted room will lost forever. Still want to delete?')">
                            <span class="icon text-white" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>
                        </td -->
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->