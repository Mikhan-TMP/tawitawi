<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center mt-5 pt-5">

    <div class="col-xl-6 col-lg-7 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-3">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
                  
                </div>
                <?= $this->session->flashdata('message'); ?>
                <form class="user" method="post" action="">
                  <div class="form-group mt-4">
                    <input type="text" class="form-control form-control-user" name="username" placeholder="Username">
                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group mt-4 mb-4">
                    <input type="email" class="form-control form-control-user" name="email" placeholder="Email">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group mt-4 mb-4">
                    <!-- <p>please make more strong password minium 8 character (Combine numbers, lowercase, and uppercase letters and special characters)</p> -->
                   <input type="password" class="form-control form-control-user" name="password" placeholder="New Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group mt-4 mb-4">
                    <input type="password" class="form-control form-control-user" name="cpassword" placeholder="Confirm Password">
                    <?= form_error('cpassword', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                    <button class="btn btn-danger btn-user btn-block mt-4" type="submit">Submit and check Email <i class="fas fa-check"></i> </button>
                </form>
                    <a href="<?= base_url();  ?>">
                    <button class="btn btn-dark btn-block mt-4 rounded-1" type="submit">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>