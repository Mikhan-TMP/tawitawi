        <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
      <div class="col-lg-3">
        <a href="<?= base_url('master/visitor'); ?>" class="btn btn-secondary btn-icon-split mb-4">
          <span class="icon text-white">
            <i class="fas fa-chevron-left"></i>
          </span>
          <span class="text">Back</span>
        </a>
      </div>
      <div class="col-lg-5 offset-lg-4">
        <?= $this->session->flashdata('message'); ?>
      </div>
    </div>
    <div class="col-lg-10 p-0">
      <?= form_open_multipart('master/add_visitor'); ?>
      <div class="card">
        <h5 class="card-header">Visitor Master Data</h5>
        <div class="card-body">
          <h5 class="card-title">Add New Visitor</h5>
          <p class="card-text">Form to add new visitor to system</p>
          <div class="row">
            <div class="col-lg-6">              
              <div class="form-group row">
                <label for="e_name" class="col-form-label col-lg-4">Visitor Name</label>                
                  <input type="text" class="form-control col-lg" name="e_name" id="e_name" required>
                  <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>                
              </div>
              <div class="form-group row">
                <label for="qrcode" class="col-form-label col-lg-4">QR Code</label>                
                  <input type="text" class="form-control col-lg" name="qrcode" id="qrcode" required>
                  <?= form_error('qrcode', '<small class="text-danger">', '</small>') ?>                
              </div>
            </div>
          </div>
          <div class ="row" >
            <div class="col-lg-6">
              <div class="form-group row">
                <label for="rfid" class="col-form-label col-lg-4">RF ID</label>
                <div class="col p-0">
                  <input type="text" class="form-control col-lg" name="rfid" id="rfid" autofocus>
                  <?= form_error('rfid', '<small class="text-danger">', '</small>') ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="e_gender" class="col-form-label col-lg-4">Gender</label>
                <div class="col p-0">
                  <div class="form-check form-check-inline my-0">
                    <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" checked>
                    <label class="form-check-label" for="m">
                      Male
                    </label>
                    <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="e_gender" id="f" value="F">
                    <label class="form-check-label" for="f">
                      Female
                    </label>
                  </div>
                </div>
              </div>
            </div>                  
              
          </div>
          <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
            <span class="icon text-white">
              <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text">Add to system</span>
          </button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
    </form>
  </div>

        <!-- End of Main Content -->

        