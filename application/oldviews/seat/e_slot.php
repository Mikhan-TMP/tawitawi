        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="POST" class="col-lg-5  p-0">
            <div class="card">              
              <div class="card-body">                
                <div class="form-group">
                  <label for="department_id" class="col-form-label-lg">Slot ID</label>
                  <input type="text" readonly class="form-control-plaintext form-control-lg" name="d_id" value="<?= $d_old['id']; ?>">
                </div>               
                <div class="form-group">
                  <label for="d_floor" class="col-form-label-lg">Floor</label>
                  <input type="text" class="form-control form-control-lg" name="d_floor" id="d_floor" value="<?= $d_old['Floor']; ?>">
                  <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                </div>
                <div class="form-group">
                  <label for="d_room" class="col-form-label-lg">Room </label>
                  <input type="text" class="form-control form-control-lg" name="d_room" id="d_room" value="<?= $d_old['Room']; ?>">
                  <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                </div>

                <div class="form-group">
                  <label for="d_name" class="col-form-label-lg">Number of Seat/s</label>
                  <input type="text" class="form-control form-control-lg" name="d_name" id="d_name" value="<?= $d_old['Slot']; ?>">
                  <?= form_error('d_name', '<small class="text-danger">', '</small>') ?>
                </div>
                <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                  <span class="icon text-white">
                    <i class="fas fa-check"></i>
                  </span>
                  <span class="text">Save Change</span>
                </button>
          </form>
        </div>
        </div>
        </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->