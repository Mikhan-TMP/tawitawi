
<div class="container d-flex justify-content-center align-items-center mb-4">
<div class="col-lg-7">
    <div class="text-center">
        <img class="center img-fluid text-center mb-4" src="<?= base_url('images/logoMSU.png') ?> " width="130px;">
            <h3 class="text-center text-white color-white" 
            style="
            font-family: 'Inter', sans-serif;
            letter-spacing: 1rem;
            font-weight: bold;
            font-size: 2.75rem;
            ">WELCOME</h3>
            <hr style="
                /* border-color:white; */
                background: linear-gradient(90deg, rgba(255,255,255,0.14) 0%, rgba(255,255,255,1) 49%, rgba(255,255,255,0.14) 100%);
                height: 1px;
                max-width: 600px;
            ">
        </div>
    <div class="card mx-auto" style="max-width: 600px;
            background: rgba( 255, 255, 255, 0.3 );
            /* box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 ); */
            /* backdrop-filter: blur( 1px ); */
            -webkit-backdrop-filter: blur( 1px );
            border: none;
            border-radius: 10px;
        ">
        <h4 class="text-light text-center mt-4 mb-3">Register</h4>
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>

        <!-- Additional password error message -->
        <?php if (isset($password_error) && !empty($password_error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $password_error; ?>
            </div>
        <?php endif; ?>
        <!-- <?php echo form_error('username', '<div class="alert alert-danger text-center">', '</div>'); ?> -->
        <div class="card-body d-flex justify-content-center">
            <form action="<?= base_url('auth/account') ?>" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class ="text-light small ml-2" for="username">User Name</label>
                        <input type="text" class="form-control"
                        style="
                            border-radius: 10rem;
                            padding: 1.5rem;
                        " id="username" name="username" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class ="text-light small ml-2" for="fname">First Name</label>
                        <input type="text" class="form-control form-control-user"
                        style="
                            border-radius: 10rem;
                            padding: 1.5rem;
                        " id="fname" name="fname" required>
                    </div>

                    <!-- <div class="form-group col-md-4">
                        <label for="middleName">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middleName">
                    </div> -->
                    <div class="form-group col-md-6">
                        <label class ="text-light small ml-2" for="lname">Last Name</label>
                        <input type="text" class="form-control form-control-user"
                        style="
                            border-radius: 10rem;
                            padding: 1.5rem;
                        "
                        id="lname" name="lname" required>
                    </div>
                </div>
                
                <!-- <div class="form-row">
                    <div class="form-group ml-3">
                        <label>Gender</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                            <label class="form-check-label" for="male">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                            <label class="form-check-label" for="female">
                                Female
                            </label>
                        </div>
                    </div>
                </div> -->
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class ="text-light small ml-2" for="email">Email</label>
                        <input type="email" class="form-control form-control-user"
                        style="
                            border-radius: 10rem;
                            padding: 1.5rem;
                        "  id="email" name="email" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label class ="text-light small ml-2" for="password">Password</label>
                        <input type="password" class="form-control form-control-user"
                        style="
                            border-radius: 10rem;
                            padding: 1.5rem;
                        " 
                         id="password" name="password">
                        <input type="checkbox" id="showPasswordCheckbox" class="mt-3 ml-3 toggle-password">
                        <label class ="text-light small" for="showPasswordCheckbox" class="ml-2 small">Show Password</label>  
                    </div>
                </div>
                

                <!-- <div class="form-group col-md-12">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div> -->

                <!-- <div class="text-center"> -->
                    <!-- <button type="submit" class="btn btn-success btn-md w-100 small" 
                        style="background: linear-gradient(180deg, #031084, #000748); border: none;">SUBMIT</button> -->
                    <button 
                        class="btn btn-danger btn-user btn-blockmx-auto w-100 p-3"
                        style="background: linear-gradient(180deg, #FFD602, #FAB703 , #D6890E);
                        border-radius: 10rem;
                        border: none; font-size:12px" 
                        type="submit">SIGN UP</button>
                <!-- </div> -->
            </form>
        </div>
        <div class="text-center mb-4">
        <a class="small text-light" href="<?= base_url();  ?>"> Already have an account? <span
        style="color: #FFD602; font-style: italic;"> Log in </span> </a>
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
</script>