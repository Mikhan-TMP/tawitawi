        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/area'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="POST" class="col-lg-5 p-0 m-auto">
            <div class="card">
            <h3 class="mb-0 text-left text-light" 
                  style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                  border-top-left-radius:15px;
                  border-top-right-radius:15px;
                  padding: 1.5rem;
                  font-size: 1.5rem;">
                  Update Area Data</h3>
              <div class="card-body">                
                <div class="form-group">
                  <label for="department_id" class="text-dark" style="font-weight: bold;">Area ID</label>
                  <input type="text" readonly class="form-control-plaintext form-control-lg" name="d_id" value="<?= $d_old['id']; ?>"
                  style="border-radius:15px; font-size: 1rem; padding: 25px;">
                </div>
                <div class="form-group" style="    
                      display: flex;
                      flex-direction: column;
                      /* border-color: blue;">
                  <label for="d_floor" class="text-dark" style="font-weight: bold;">Floor</label>
                  <select class="" name="d_floor" id="d_floor"
                      style="   border-radius: 15px;
                                font-size: 1rem;
                                padding: 15px;
                                /* background-color: #fff; */
                                color: #6e707e;
                                /* border-color: #a5a8bc; */
                                border: 1px solid #d1d3e2;">
                      <option disabled>Select Floor</option>
                      <option value="GF" <?= ($d_old['floor'] == 'GF') ? 'selected' : ''; ?>>Ground Floor</option>
                      <option value="2F" <?= ($d_old['floor'] == '2F') ? 'selected' : ''; ?>>2nd Floor</option>
                      <option value="3F" <?= ($d_old['floor'] == '3F') ? 'selected' : ''; ?>>3rd Floor</option>
                      <option value="4F" <?= ($d_old['floor'] == '4F') ? 'selected' : ''; ?>>4th Floor</option>
                      <option value="5F" <?= ($d_old['floor'] == '5F') ? 'selected' : ''; ?>>5th Floor</option>
                      <option value="6F" <?= ($d_old['floor'] == '6F') ? 'selected' : ''; ?>>6th Floor</option>
                      <option value="7F" <?= ($d_old['floor'] == '7F') ? 'selected' : ''; ?>>7th Floor</option>
                    </select>
                  <?= form_error('d_floor', '<small class="text-danger">', '</small>') ?>
                </div>
                <div class="form-group">
                  <label for="d_name" class="text-dark" style="font-weight: bold;">Name</label>
                  <input type="text" class="form-control form-control-lg" name="d_name" id="d_name" value="<?= $d_old['room']; ?>"
                  style="border-radius:15px; font-size: 1rem; padding: 25px;">
                  <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                </div>
                <div class="form-group">
                  <label for="d_seat" class="text-dark" style="font-weight: bold;">Number of Seat/s</label>
                  <input type="number" class="form-control form-control-lg" name="d_seat" id="d_seat" value="<?= $d_old['slotnumber']; ?>"
                  style="border-radius:15px; font-size: 1rem; padding: 25px;">
                  <?= form_error('d_seat', '<small class="text-danger">', '</small>') ?>
                </div>
                <div class="form-group">
                    <label for="open_time" class="text-dark" style="font-weight: bold;">Opening Time</label>
                    <input type="time" class="form-control form-control-lg" name="open_time" id="open_time" value="<?= $d_old['opentime']; ?>"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;">
                    <?= form_error('open_time', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="close_time" class="text-dark" style="font-weight: bold;">close time</label>
                    <input type="time" class="form-control form-control-lg" name="close_time" id="close_time" value="<?= $d_old['closetime']; ?>"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;">
                    <?= form_error('close_time', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="min_slot" class="text-dark" style="font-weight: bold;">Min reservation hour (1hour ~2hour)</label>
                    <input type="number" class="form-control form-control-lg" name="min_slot" id="min_slot" min="1" max="2" value="<?= $d_old['min_slot']; ?>"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;">
                    <?= form_error('min_slot', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="max_slot" class="text-dark" style="font-weight: bold;">Max reservation hour(1hour ~8hour)</label>
                    <input type="number" class="form-control form-control-lg" name="max_slot" id="max_slot"min="1" max="8" value="<?= $d_old['max_slot']; ?>"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;">
                    <?= form_error('max_slot', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <button style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); border:none; padding: 5px; border-radius: 15px;" 
                  type="submit" class="btn btn-success btn-icon-split mt-4 w-100">
                  <!-- <span class="icon text-white">
                    <i class="fas fa-check"></i>
                  </span> -->
                  <span class="text">Save</span>
                </button>
          </form>
        </div>
        </div>
        </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->