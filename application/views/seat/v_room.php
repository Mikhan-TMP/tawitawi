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

          <form action="" method="POST" >
            <div class="card" >
              <div class="col-lg-10">
                <h5 class="card-header">Room Reservation</h5>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="id" class="col-form-label">Transaction ID</label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['id']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="floor" class="col-form-label">Floor</label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['floor']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="room" class="col-form-label">Room name</label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['room']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="date" class="col-form-label">Date</label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['date']; ?>">                      
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="start_time" class="col-form-label">Start Time</label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['start_time'].":00"; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="start_time" class="col-form-label">End Time</label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['end_time'].":00"; ?>">                                                  
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="Noa" class="col-form-label"> No of Attendee </label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['Noa']; ?>" />
                        <!-- input type="text" class="form-control-plaintext"  value="" -->
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="e_title" class="col-form-label">Title </label>
                        <input type="text" class="border-1" value="" placeholder="<?= $roomslot['title']; ?>">                      
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="Organizer" class="col-form-label">Organizer</label>
                        <input type="text" class="border-1" value="" placeholder="<?=  $roomslot['username']; ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="contact" class="col-form-label">Contact number </label>
                        <input type="text" class="border-1" value="" placeholder="<?=  $roomslot['contact'];  ?>">
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="email" class="col-form-label"> Email  </label>
                        <input type="text" class="border-1" value="" placeholder="<?=  $roomslot['email'];  ?>">
                      </div>
                    </div>                  
                  </div>
                  <div class="row">                  
                    <div class="col-lg-10">
                      <div class="form-group">
                        <label for="description" class="col-form-label">Description </label>
                        <textarea class="form-control" rows="5"  data-mdb-showcounter="true" maxlength="200" id="description"><?= $roomslot['description'];  ?></textarea>                 
                      </div>
                    </div>  
                  </div>                                    
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- End of Main Content -->