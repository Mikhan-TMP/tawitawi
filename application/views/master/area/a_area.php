        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Add Area</h1>

          <a href="<?= base_url('master/area'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="POST" class="col-lg-5  p-0 m-auto">
            <div class="card" style="border-radius:15px;">
              <h3 class="mb-0 text-left text-light" 
                    style="background: linear-gradient(180deg, #031084, #000748); 
                    border-top-left-radius:15px;
                    border-top-right-radius:15px;
                    padding: 1.5rem;
                    font-size: 1.5rem;">
                    Library Area Details</h3>
              <div class="card-body">
                <form>                  
                <div class="form-group mt-4" style="    
                                                display: flex;
                                                flex-direction: column;
                                                /* border-color: blue;">
                  <label for="d_floor" class="text-dark" style="font-weight: bold;">Floor</label>
                    <!-- <input type="text" class="form-control form-control-lg" name="d_floor" id="d_floor"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Area Floor"> -->
                    <select class="" name="d_floor" id="d_floor" 
                      style="   border-radius: 15px;
                                font-size: 1rem;
                                padding: 15px;
                                /* background-color: #fff; */
                                color: #6e707e;
                                /* border-color: #a5a8bc; */
                                border: 1px solid #d1d3e2;"
                      value="<?= set_value('d_floor'); ?>">
                      <option disabled selected>Select Floor</option>
                      <option value="GF" >Ground Floor</option>
                      <option value="2F">2nd Floor</option>
                      <!-- <option value="3F">3rd Floor</option>
                      <option value="4F">4th Floor</option>
                      <option value="5F">5th Floor</option>
                      <option value="6F">6th Floor</option>
                      <option value="7F">7th Floor</option> -->
                    </select>
                    <?= form_error('d_floor', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="d_name" class="text-dark" style="font-weight: bold;">Area Name</label>
                    <input type="text" minlength="2" maxlength="30" class="form-control form-control-lg" name="d_name" id="d_name"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;" value="<?= set_value('d_name'); ?>" placeholder="Enter Area Name">
                    <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="d_seat" class="text-dark" style="font-weight: bold;">Number of Seat/s</label>
                    <input type="number" min="1" class="form-control form-control-lg" name="d_seat" id="d_seat" 
                    style="border-radius:15px; font-size: 1rem; padding: 25px;"  value="<?= set_value('d_seat'); ?>" placeholder="Enter Number of Seat/s">
                    <?= form_error('d_seat', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="open_time" class="text-dark" style="font-weight: bold;">Opening Time</label>
                    <input type="time" class="form-control form-control-lg" name="open_time" id="open_time"  value="<?= set_value('open_time'); ?>"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;">
                    <?= form_error('open_time', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="close_time" class="text-dark" style="font-weight: bold;">Closing Time</label>
                    <input type="time" class="form-control form-control-lg" name="close_time" id="close_time" value="<?= set_value('close_time'); ?>"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;">
                    <?= form_error('close_time', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="min_slot" class="text-dark" style="font-weight: bold;">Minimum reservation time (1hour ~ 2hours)</label>
                    <input type="number" class="form-control form-control-lg" name="min_slot" id="min_slot" min="1" max="2"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;"  value="<?= set_value('min_slot'); ?>" placeholder="Enter Minimum Reservation Hour">
                    <?= form_error('min_slot', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="max_slot"class="text-dark" style="font-weight: bold;">Maximum reservation time (1hour ~ 8hours)</label>
                    <input type="number" class="form-control form-control-lg" name="max_slot" id="max_slot"min="1" max="8"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;" value="<?= set_value('max_slot'); ?>" placeholder="Enter Maximum Reservation Hour">
                    <?= form_error('max_slot', '<small class="text-danger">', '</small><br>') ?>
                  </div>
                  <button type="submit" style="background: linear-gradient(180deg, #031084, #000748);  border:none; padding: 5px; border-radius: 15px;" 
                  class="btn btn-success btn-icon-split mt-4 w-100">
                    <span class="text">ADD AREA</span>
                  </button>
                </form>
              </div>
            </div>
          </form>
        </div>
        <!-- /.container-fluid -->
        <?php 
        //get the toasterhelper
          $this->load->helper('toast');

          if ($this->session->flashdata('warning')) {
            echo getAlertMessages('warning', $this->session->flashdata('warning'));
          }
          //unset it after use
          $this->session->unset_userdata('warning');
        ?> 