        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 "><?= $title; ?></h1>

          <a href="<?= base_url('seat/bookroom'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="post" >
            <div class="card" >
              <div class="col-lg-10">
                <h5 class="card-header">Room Reservation</h5>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="id" class="col-form-label">Transaction ID</label>
                        <input type="text" readonly class="form-control-plaintext" name="id" value="<?= $d_old['id']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="floor" class="col-form-label">Floor</label>
                        <input type="text" readonly class="form-control-plaintext" name="floor" value="<?= $d_old['floor']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="room" class="col-form-label">Room name</label>
                        <input type="text" readonly class="form-control-plaintext" name="room" value="<?= $d_old['room']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="date" class="col-form-label">Date</label>
                        <input type="text" class="form-control-plaintext" name="date" id="date" value="<?= $d_old['date']; ?>">                      
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="start_time" class="col-form-label">Start Time</label>
                        <input type="text" class="form-control" name="<?= $d_slot; ?>" id="<?= $d_slot; ?>" value="<?= date('H:i', strtotime($d_old['opentime'].strval($d_slot).' hour')) ; ?>">                        
                        <?= form_error('start_time', '<small class="text-danger">', '</small>') ?>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="start_time" class="col-form-label">End Time</label>
                          <select class="form-control" name="end_time" id="end_time" required> 
                            <?php for ($i = $d_slot; $i <= $d_old['operationtime']; $i++) { ?>                                                   
                              <option value=<?= $i; ?> > <?=date('H:i', strtotime($d_old['opentime'].strval($i).' hour')) ;   ?> </option>
                              <?php } ?>
                            
                          </select>               
                          <?= form_error('end_time', '<small class="text-danger">', '</small>') ?>         
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="Noa" class="col-form-label"> No of Attendee </label>
                        <input type="number" class="form-control" min=1  max =50 name="Noa"  id="Noa" value="">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="e_title" class="col-form-label">Title </label>
                        <input type="text" class="form-control" name="e_title" id="e_title" value="" required>   
                        <?= form_error('e_title', '<small class="text-danger">', '</small>') ?>                      
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="Organizer" class="col-form-label">Organizer</label>
                        <input type="text" class="form-control" name="Organizer" id='Organizer' value="" required>
                        <?= form_error('Organizer', '<small class="text-danger">', '</small>') ?>    
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="contact" class="col-form-label">Contact number </label>
                        <input type="tel" class="form-control" name="contact" id="Organizer"  value="" required>
                        <?= form_error('Organizer', '<small class="text-danger">', '</small>') ?>    
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="email" class="col-form-label"> Email  </label>
                        <input type="email" class="form-control" name="email"  id="email" value="" required>
                        <?= form_error('Organizer', '<small class="text-danger">', '</small>') ?>   
                      </div>
                    </div>                  
                  </div>
                  <div class="row">                  
                    <div class="col-lg-10">
                      <div class="form-group">
                        <label for="description" class="col-form-label">Description </label>
                        <textarea class="form-control" rows="5"  data-mdb-showcounter="true" maxlength="200" id="description"></textarea>                 
                      </div>
                    </div>  
                  </div>
                  <div class="row">              
                      <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right"  id="updateroom" name="updateroom">
                        <span class="icon text-white">
                          <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Save Changes</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- End of Main Content -->