        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('Seat'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="POST" class="col-lg-5  p-0">
            <div class="card">
              <h5 class="card-header">Library Seat Book</h5>
              <div class="card-body">
                <h5 class="card-title">Booked Seat</h5>
                <form>
                  <div class="form-group">                  
                    <label for="floor" class="col-form-label-lg">Floor</label>
                    <input class="form-control" list="browsers" name="floor" id="floor">
                    <datalist id="browsers">
                        <option value='GF'>GF</option>
                        <option value='2F'>2F</option>
                        <option value='3F'>3F</option>
                        <option value='4F'>4F</option>
                        <option value='5F'>5F</option>
                        <option value='6F'>6F</option>
                        <option value='7F'>7F</option>
                     </datalist>                  
                    <?= form_error('floor', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label for="room" class="col-form-label-lg">Room</label>
                    <select class="form-control form-control-lg" name="room" id="room">
                    <option value="">Select Room</option>
                    <?php
                      if(isset($_POST['floor'])) {
                          $selectedCategory = $_POST['floor'];
                          if($selectedCategory == 1) {
                              echo '<option value="11">Fiction</option>';
                              echo '<option value="12">Non-Fiction</option>';
                          } elseif($selectedCategory == 2) {
                              echo '<option value="21">Gadgets</option>';
                              echo '<option value="22">Accessories</option>';
                          }
                      }
                      ?>
                      </select>
                  </div>
                  <div class="form-group">                 
                    <label for="slot" class="col-form-label-lg">Seat</label>
                    <input type="text" class="form-control form-control-lg" name="slot" id="slot">
                    <?= form_error('slot', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                    <span class="icon text-white">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Add to system</span>
                  </button>
                </form>
              </div>
            </div>
          </form>
          <form action="" method="POST" class="col-lg-5  p-0">
            <div>
              <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            </div>
          </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->