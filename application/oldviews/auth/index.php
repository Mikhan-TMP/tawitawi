
<link rel="stylesheet" href="sweetalert2.min.css">
<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center mx-auto">

    <div class="col-xl-6 col-lg-7 col-md-9">
    <div class="text-center">
    <img class="center img-fluid text-center mt-5 mb-4" src="<?= base_url('images/logoMSU.png') ?> " width="130px;">
        <h3 class="text-center text-white color-white" 
        style="
        font-family: 'Inter', sans-serif;
        letter-spacing: 1rem;
        font-weight: bold;
        font-size: 2.75rem;
        ">WELCOME</h3>
          <hr style="
            /* border-color:white; */
             height:1px; 
            background: linear-gradient(90deg, rgba(255,255,255,0.14) 0%, rgba(255,255,255,1) 49%, rgba(255,255,255,0.14) 100%);            max-width: 400px;
            ">
    </div>
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
              <div class="p-3 mt-2">
                <div class="text-center mb-2">
                  <h4 class="text-light">MSU-GENSAN LOGIN</h4>
                </div>
                  <?= $this->session->flashdata('message'); ?>
                <script>
                  Swal.fire({
                    title: 'Error!',
                    text: <?= $this->session->flashdata('message'); ?>,
                    icon: 'error'
                  })
                </script>
                <div class="">
                        <form class="user" method="post" action="<?= base_url(); ?>">
                            <div class="form-group mt-4">
                                <label class="text-light small ml-2">Username</label>
                                <input class="form-control form-control-user" type="text" name="username" placeholder="">
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group mt-4 mb-4 position-relative">
                              <label class="text-light small ml-2">Password</label>
                                <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="">
                                <div class="ml-2 d-flex align-items-center mt-2">
                                  <input type="checkbox" id="showPasswordCheckbox" class=" toggle-password">
                                  <label for="showPasswordCheckbox" class="mb-0 text-left align-items-center ml-1 small text-light">Show Password</label>  
                                </div>
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <input hidden value="desktop" type="text" name="device" class="form-control form-control-user">
                            <button class="btn btn-danger btn-user mb-3 mx-auto" 
                            style="
                            background: linear-gradient(180deg, #FFD602, #FAB703 , #D6890E); 
                            border: none;
                            width:100%;
                            " type="submit">Login</button>
                        </form>
                        <div class="text-center mt-2">
                          <p class="text-light small">Don't have an account?
                          <a class="font-style-italic" style="color: #FAB703; font-style: italic; " href="<?= base_url('auth/account'); ?>">Sign Up</a>
                          </p>
                          
                        </div>
                </div>
              </div>
              <div class="text-center mt-0">
                <a class="small"  style="color: #FAB703" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
<!-- <script src="sweetalert2.min.js"></script> -->

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
    });
  });
</script>