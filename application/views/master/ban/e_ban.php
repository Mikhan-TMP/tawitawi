<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <a href="<?= base_url('master/visitor'); ?>" class="btn btn-secondary btn-icon-split mb-4">
    <span class="icon text-white">
      <i class="fas fa-chevron-left"></i>
    </span>
    <span class="text">Back</span>
  </a>

  <?= form_open_multipart('master/edit_visitor/' . $visitor['id']); ?>
  <div class="col-lg p-0">
    <div class="row">              
      <div class="col-lg-6">
        <div class="card">
          <h5 class="card-header">Visitor Master Data</h5>
          <div class="card-body">
            <h5 class="card-title">Edit Visitor</h5>
            <p class="card-text">Form to edit visitor in system</p>
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="employee_id" class="col-form-label">Visitor ID</label>
                  <input type="text" readonly class="form-control-plaintext" name="e_id" value="<?= $visitor['id']; ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="form-group">
                  <label for="e_name" class="col-form-label">Visitor Name</label>
                  <input type="text" class="form-control" name="e_name" id="e_name" value="<?= $visitor['name']; ?>">
                  <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>
                </div>
              </div>
            </div>
            <div class="row">                      
              <div class="col-lg-8">
                <div class="form-group">
                  <label for="qrcode" class="col-form-label">QR code</label>
                  <input type="text" class="form-control" name="qrcode" id="qrcode" value="<?= $visitor['qrcode']; ?>">
                  <?= form_error('qrcode', '<small class="text-danger">', '</small>') ?>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="form-group">
                  <label for="rfid" class="col-form-label">RF ID</label>
                  <input type="text" class="form-control" name="rfid" id="rfid" value="<?= $visitor['rfid']; ?>">
                  <?= form_error('rfid', '<small class="text-danger">', '</small>') ?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="e_gender" class="col-form-label">Gender</label>
                  <div class="row col-lg">
                    <div class="form-check form-check-inline my-0">
                      <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" <?php if ($visitor['gender'] == 'M') { echo 'checked';}; ?>>
                      <label class="form-check-label" for="m">
                        Male
                      </label>
                      <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="e_gender" id="f" value="F" <?php if ($visitor['gender'] == 'F') { echo 'checked'; }; ?>>
                      <label class="form-check-label" for="f">
                        Female
                      </label>
                    </div>
                  </div>
                  <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
              <span class="icon text-white"><i class="fas fa-check"></i> </span>
              <span class="text">Save Changes</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= form_close(); ?>
</div>

<!-- End of Main Content -->