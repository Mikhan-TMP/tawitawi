        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-3">
              <a href="<?= base_url('master/a_room'); ?>" class="btn btn-info btn-icon-split mb-4">
                <span class="icon text-white-600">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add New Room</span>
              </a>
            </div>
            <div class="col-lg-5 offset-lg-4">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

          <!-- Data Table Department-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Room</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>                      
                      <th>ID</th>
                      <th>Floor</th>
                      <th>Room Name</th>
                      <th>Seat #</th>
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
                      <th>Actions</th>
                    </tr>
                  </thead>
                 
                  <tbody>
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
                        <td class="align-middle"><?= $dpt['Floor']; ?></td>
                        <td class="align-middle"><?= $dpt['Room']; ?></td>
                        <td class="align-middle"><?= $dpt['Slot']; ?></td>
                        <?php for($i=0;$i < 11; $i++){ 
                                  if ($timeslot[$i]==1) {  ?>
                                    <td bgcolor="red" class="align-middle" >O</td> 
                                  <?php } else { ?>
                                    <td bgcolor="green" class="align-middle">E</td> 
                                  <?php } 
                             } ?>                        
                        <td onclick="alert('You clicked on the first cell')" class="align-middle text-center">
                          <a href="<?= base_url('master/e_room/') . $dpt['id'] ?>" class="btn btn-primary btn-circle">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> 
                          <!-- a href="<?= base_url('master/d_room/') . $dpt['id'] ?>" class="btn btn-danger btn-circle" onclick="return confirm('Deleted room will lost forever. Still want to delete?')">
                            <span class="icon text-white" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a -->
                        </td>
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