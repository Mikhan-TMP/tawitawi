        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/users'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="" method="POST" class="col-lg-5  p-0">
            <div class="card">              
              <div class="card-body">                
                <div class="form-group">
                  <label for="u_username" class="col-form-label-lg">User Name</label>
                  <input type="text"  class="form-control form-control-lg" name="u_username" value="<?= $users['username']; ?>">
                </div>
                <div class="form-group">
                  <label for="u_floor" class="col-form-label-lg">Floor</label>
                  <input type="text"  class="form-control form-control-lg" name="u_floor" value="<?= $users['floor']; ?>">
                </div>
                <div class="form-group">
                  <label for="u_fname" class="col-form-label-lg">First name</label>
                  <input type="text"  class="form-control form-control-lg" name="u_fname" value="<?= $users['fname']; ?>">
                </div>
                <div class="form-group">
                  <label for="u_lname" class="col-form-label-lg">Last Name</label>
                  <input type="text"  class="form-control form-control-lg" name="u_lname" value="<?= $users['lname']; ?>">
                </div>
                <div class="form-group">
                  <label for="u_email" class="col-form-label-lg">Email</label>
                  <input type="text"  class="form-control form-control-lg" name="u_email" value="<?= $users['email']; ?>">
                </div>
                <div class="form-group">
                  <label for="password" class="col-form-label-lg">Reset Key-Password</label>
                  <input type="password" class="form-control form-control-lg" name="password" id="password" >
                  <?= form_error('password', '<small class="text-danger">', '</small>') ?>
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