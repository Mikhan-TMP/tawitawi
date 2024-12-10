        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/room'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="POST" class="col-lg-5  p-0 m-auto">
            <div class="">
              <h3 class="mb-0 text-left text-light" 
                  style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                  border-top-left-radius:15px;
                  border-top-right-radius:15px;
                  padding: 1.5rem;
                  font-size: 1.5rem;">
                  Room Details</h3>
            </div>
            <div class="card mt-0 " style="border-top-left-radius:0px; border-top-right-radius:0px;">              
              <div class="card-body pt-0">                
                <form class="" >
                  <div class="form-group mt-4" style="    
                                                display: flex;
                                                flex-direction: column;
                                                /* border-color: blue;">
                    <label for="d_floor" class="text-dark" style="font-weight: bold;">Floor</label>
                    <!-- dropdown -->
                    <select class="" name="d_floor" id="d_floor"
                      style="   border-radius: 15px;
                                font-size: 1rem;
                                padding: 15px;
                                /* background-color: #fff; */
                                color: #6e707e;
                                /* border-color: #a5a8bc; */
                                border: 1px solid #d1d3e2;">
                      <option disabled selected>Select Floor</option>
                      <option value="GF" >Ground Floor</option>
                      <option value="2F">2nd Floor</option>
                      <!-- <option value="3F">3rd Floor</option>
                      <option value="4F">4th Floor</option>
                      <option value="5F">5th Floor</option>
                      <option value="6F">6th Floor</option>
                      <option value="7F">7th Floor</option> -->
                    </select>
                    <!-- <input type="text" class="form-control form-control-lg" name="d_floor" id="d_floor"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Room Floor"> -->
                      <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="d_name" class="text-dark" style="font-weight: bold;">Room Name</label>
                    <input type="text" class="form-control form-control-lg" name="d_name" id="d_name"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Room Name">
                    <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="d_seat" class="text-dark" style="font-weight: bold;">Number of Seat/s</label>
                    <input type="number" class="form-control form-control-lg" name="d_seat" id="d_seat"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Number of Seat/s">
                    <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="open_time" class="text-dark" style="font-weight: bold;">Opening Time</label>
                    <input type="time" class="form-control form-control-lg" name="open_time" id="open_time"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Opening Time">
                    <?= form_error('open_time', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="close_time" class="text-dark" style="font-weight: bold;">Close time</label>
                    <input type="time" class="form-control form-control-lg" name="close_time" id="close_time"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Close Time">
                    <?= form_error('close_time', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="min_slot" class="text-dark" style="font-weight: bold;">Minimum Reservation Hour (1hour ~2hour)</label>
                    <input type="number" class="form-control form-control-lg" name="min_slot" id="min_slot" min="1" max="2"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Minimum Reservation Hour">
                    <?= form_error('min_slot', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="max_slot" class="text-dark" style="font-weight: bold;">Maximum Reservation Hour(1hour ~8hour)</label>
                    <input type="number" class="form-control form-control-lg" name="max_slot" id="max_slot"min="1" max="8"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Maximum Reservation Hour">
                    <?= form_error('max_slot', '<small class="text-danger">', '</small>') ?>
                  </div>
                <div class="form-group">
                  <button style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); border:none; padding: 5px; border-radius: 15px;" 
                  type="submit" 
                  class="btn btn-success btn-icon-split mt-4 w-100">
                    <span class="text">ADD ROOM</span>
                  </button>
                </div>
                </form>
              </div>
            </div>
          </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->