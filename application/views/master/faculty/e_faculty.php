        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Edit Faculty</h1>

          <a href="<?= base_url('master/faculty'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <?= form_open_multipart('master/edit_faculty/' . $employee['id']); ?>
          <div class="col-lg p-0">
            <div class="row">
              <div class="col-lg-6 m-auto">
                <div class="card" style="border-radius:15px;">
                  <h3 class="mb-0 text-left text-light" 
                    style="background: linear-gradient(180deg, #BE110E, #630908);
                    border-top-left-radius:15px;
                    border-top-right-radius:15px;
                    padding: 1.5rem;
                    font-size: 1.5rem;">
                    Faculty Master Data</h3>
                  <div class="card-body">
                    <!-- <h5 class="card-title">Edit Faculty</h5> -->
                    <div class="row">
                      <div class="col-lg-1">
                        <div class="form-group">
                          <label for="employee_id" class="text-dark" style="font-weight: bold;">ID</label>
                          <input type="text" readonly class="form-control-plaintext" name="e_id" value="<?= $employee['id']; ?>"
                          style="border-radius:15px; font-size: 1rem; padding: 5px;">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="e_name" class="text-dark" style="font-weight: bold;">First Name</label>
                          <input type="text" minlength="2" maxlength="30" class="form-control" name="f_name" id="f_name" value="<?= $employee['first_name']; ?>"
                          style="border-radius:15px; font-size: 1rem; padding: 25px;">
                          <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>                          
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="e_name" class="text-dark" style="font-weight: bold;">Middle Name</label>
                          <input type="text" minlength="1" maxlength="30" class="form-control" name="m_name" id="m_name" value="<?= $employee['middle_name']; ?>"
                          style="border-radius:15px; font-size: 1rem; padding: 25px;">
                          <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>                          
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="e_name" class="text-dark" style="font-weight: bold;">Last Name</label>
                          <input type="text" minlength="2" maxlength="30" class="form-control" name="l_name" id="l_name" value="<?= $employee['last_name']; ?>"
                          style="border-radius:15px; font-size: 1rem; padding: 25px;">
                          <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="d_id" class="text-dark" style="font-weight: bold;">College </label>
                          <div class="col-lg p-0">
                            <input type="text" minlength="2" maxlength="30" class="form-control" name="college" id="college" value="<?= $employee['course']; ?>"
                            style="border-radius:15px; font-size: 1rem; padding: 25px;">
                            <?= form_error('e_college', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="e_id" class="text-dark" style="font-weight: bold;">Faculty ID </label>
                          <div class="col-lg p-0">
                            <input type="text" minlength="4" maxlength="30" class="form-control" name="srcode" id="srcode" value="<?= $employee['srcode']; ?>"
                            style="border-radius:15px; font-size: 1rem; padding: 25px;">
                            <?= form_error('e_srcode', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-lg-6">
                        <div class="form-group">
                          <label for="pin" class="text-dark" style="font-weight: bold;">PIN </label>
                          <div class="col-lg p-0">
                            <input type="text" class="form-control" name="pin" id="pin" value="<?= $employee['pin']; ?>"
                            style="border-radius:15px; font-size: 1rem; padding: 25px;">
                            <?= form_error('', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div> -->
                      <!-- qr -->
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="qrcode" class="text-dark" style="font-weight: bold;">QR Code</label>
                          <div class="col-lg p-0">
                            <input type="text" minlength="4" maxlength="30" class="form-control" name="qrcode" id="qrcode" value="<?= $employee['qrcode']; ?>"
                            style="border-radius:15px; font-size: 1rem; padding: 25px;">
                            <?= form_error('qrcode', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <!-- RFID -->
                          <label for="rfid" class="text-dark" style="font-weight: bold;">RFID</label>
                          <div class="col-lg p-0">
                            <input type="text" minlength="4" maxlength="30" class="form-control" name="rfid" id="rfid" value="<?= $employee['rfid']; ?>"
                            style="border-radius:15px; font-size: 1rem; padding: 25px;">
                            <?= form_error('rfid', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_gender" class="text-dark" style="font-weight: bold;">Gender</label>
                          <div class="row col-lg">
                            <div class="form-check form-check-inline my-0">
                              <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" <?php if ($employee['gender'] == 'M') { echo 'checked';  }; ?>>
                              <label class="form-check-label" for="m"> Male</label>
                              <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="e_gender" id="f" value="F" <?php if ($employee['gender'] == 'F') { echo 'checked'; }; ?>>
                              <label class="form-check-label" for="f"> Female </label>
                            </div>
                          </div>
                          <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                    <button style="background: linear-gradient(180deg, #BE110E, #630908); border:none; padding: 5px; border-radius: 15px;" 
                      type="submit" class="btn btn-success btn-icon-split mt-4 w-100">
                        <!-- <span class="icon text-white">
                          <i class="fas fa-check"></i>
                        </span> -->
                      <span class="text">Save Changes</span>
                    </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->