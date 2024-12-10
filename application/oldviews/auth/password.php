<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center mt-5 pt-4">

    <div class="col-xl-6 col-lg-7 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5" style="
        max-width: 400px;
        background: rgba( 255, 255, 255, 0.3 );
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 1px );
        -webkit-backdrop-filter: blur( 1px );
        border-radius: 10px;
        margin:auto;
      ">
        <div class="card-body p-3">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-3">
                <div class="text-center">
                <h1 class="h3 mb-0 text-light"><?= $title; ?></h1>
                  
                </div>
                  <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $this->session->flashdata('message'); ?>
                    </div>
                <?php endif; ?>
                <form class="user" method="post" action="">
                  <div class="form-group mt-4">
                    <label class="text-light small ml-2">Username</label>
                    <input type="text" class="form-control form-control-user" name="username" placeholder="">
                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group mt-4 mb-4">
                    <label class="text-light small ml-2">Email</label>
                    <input type="email" class="form-control form-control-user" name="email" placeholder="">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group mt-4 mb-4">
                    <label class="text-light small ml-2">Password</label>
                    <!-- <p>please make more strong password minium 8 character (Combine numbers, lowercase, and uppercase letters and special characters)</p> -->
                   <input type="password" class="form-control form-control-user" name="password" placeholder="" id="password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group mt-4 mb-4">
                    <label class="text-light small ml-2">Confirm Password</label>
                    <input type="password" class="form-control form-control-user" name="cpassword" placeholder="" id="cpassword">
                    <input type="checkbox" id="showPasswordCheckbox" class="mt-3 ml-3 toggle-password">
                        <label for="showPasswordCheckbox" class="ml-2 small text-light">Show Password</label>  
                    <?= form_error('cpassword', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                    <button class="btn btn-danger btn-user btn-block mt-4" style="border:none; background: linear-gradient(180deg, #FFD602, #FAB703 , #D6890E);" type="submit">Submit and check email  <i class="fas fa-check"></i> </button>
                </form>
                    <a href="<?= base_url();  ?>">
                    <button class="btn btn-dark btn-block mt-2 rounded-4" style ="border:none; border-radius:15px ;" type="submit">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
    });
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.getElementById('cpassword');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
    });
  });
</script>