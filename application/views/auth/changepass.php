<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center mt-5 pt-5">

    <div class="col-xl-6 col-lg-7 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-3">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <!-- your_view_name.php -->
            <div class="col-lg">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
                    </div>

                    <form class="user" method="post" action="<?= base_url('auth/resetpassword/' . $verification_token); ?>">
                        <div class="form-group mt-4 mb-4">
                            <input type="password" class="form-control form-control-user" name="password" placeholder="New Password">
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <div class="form-group mt-4 mb-4">
                            <input type="password" class="form-control form-control-user" name="cpassword" placeholder="Confirm Password">
                            <?= form_error('cpassword', '<small class="text-danger pl-3">', '</small>') ?>
                        </div>
                        <button class="btn btn-danger btn-user btn-block mt-4" type="submit">Confirm</button>
                    </form>

                    <a href="<?= base_url(); ?>">
                        <button class="btn btn-dark btn-block mt-4 rounded-1" type="button">Cancel</button>
                    </a>
                </div>
            </div>

          </div>
        </div>
      </div>

    </div>

  </div>

</div>