        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Add Librarian</h1>

          <a href="<?= base_url('master/users'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>
          <div class="col-lg-5 p-0 m-auto">
            <h3 class="mb-0 text-left text-light" 
                    style="background: linear-gradient(180deg, #BE110E, #630908);
                    border-top-left-radius:15px;
                    border-top-right-radius:15px;
                    padding: 1.5rem;
                    font-size: 1.5rem;">
                    Librarian Details</h3>
            <form action="<?= base_url('master/a_users') ?>" method="POST">
              <div class="card">                
                <div class="card-body">
                  
                  <div class="form-group row">
                    <div class="col">
                      <label for="u_username" class="text-dark" style="font-weight: bold;">Librarian Username</label>
                      <input type="text" required min-length="6" max-length="30" class="form-control col-lg" name="u_username" id="u_username"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Librarian Username">
                      <?= form_error('u_username', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col" style="    
                                      display: flex;
                                      flex-direction: column;
                                      /* border-color: blue;">
                      <label for="u_floor" class="text-dark" style="font-weight: bold;">Location Floor</label>
                      <!-- <input type="text"  class="form-control col-lg" name="u_floor" id="u_floor"
                      > -->
                      <select required class="" name="u_floor" id="u_floor"
                        style="   border-radius: 15px;
                                  font-size: 1rem;
                                  padding: 15px;
                                  /* background-color: #fff; */
                                  color: #6e707e;
                                  /* border-color: #a5a8bc; */
                                  border: 1px solid #d1d3e2;">
                        <option disabled selected>Select Floor</option>
                        <option value="GF" >Ground Floor</option>
                        <option value="2F">2nd Floor</option>
                        <!-- <option value="3F">3rd Floor</option>
                        <option value="4F">4th Floor</option>
                        <option value="5F">5th Floor</option>
                        <option value="6F">6th Floor</option>
                        <option value="7F">7th Floor</option> -->
                      </select>
                      <?= form_error('u_floor', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <div class="form-group row">
                  <div class="col">
                    <label for="u_fname" class="text-dark" style="font-weight: bold;">First Name</label>
                    <input type="text" minlength="2" maxlength="30" required class="form-control form-control-lg" name="u_fname"  id="u_fname"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter First Name">
                    <?= form_error('u_fname', '<small class="text-danger">', '</small>') ?>
                  </div>
                  </div>
                <div class="form-group row">
                  
                  <div class="col">
                    <label for="u_lname" class="text-dark" style="font-weight: bold;">Last Name</label>
                    <input type="text" minlength="2" maxlength="30" required  class="form-control form-control-lg" name="u_lname"  id="u_lname"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Last Name">
                    <?= form_error('u_lname', '<small class="text-danger">', '</small>') ?>
                  </div>                
                  </div>
                <div class="form-group row">
                  
                  <div class="col">
                    <label for="u_email" class="text-dark" style="font-weight: bold;">Email</label>
                    <input type="text"   class="form-control form-control-lg" name="u_email"  id="u_email"
                    style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Email">
                  <?= form_error('u_email', '<small class="text-danger">', '</small>') ?>
                  </div>
                </div>
                  <div class="form-group row">
                    <div class="col">
                      <label for="u_password" class="text-dark" style="font-weight: bold;">Key (password)</label>
                      <input type="password"  class="form-control col-lg" name="u_password" id="u_password"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Key">
                      <?= form_error('u_password', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col">
                      <label for="c_password" class="text-dark" style="font-weight: bold;">Confirm Key </label>
                      <input type="password" class="form-control col-lg" name="c_password" id="c_password"
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Confirm Key">
                      <?= form_error('u_password', '<small class="text-danger">', '</small>') ?>
                      
                    </div>
                  </div>
                  <button style="background: linear-gradient(180deg, #BE110E, #630908); border:none; padding: 5px; border-radius: 15px;" 
                    type="submit" class="btn btn-success btn-icon-split mt-4 w-100">
                    <!-- <span class="icon text-white">
                      <i class="fas fa-plus-circle"></i>
                    </span> -->
                    <span class="text">Add to system</span>
                  </button>
            </form>
          </div>
        </div>
        </div>
        </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

                <!-- ALERT MESSAGES -->
                <?php 
        //get the toasterhelper
          $this->load->helper('toast');

          if ($this->session->flashdata('users_scs')) {
           echo getAlertMessages('success', $this->session->flashdata('users_scs'));
          }
          if ($this->session->flashdata('users_fail')) {
           echo getAlertMessages('error', $this->session->flashdata('users_fail'));
          }
          
          //unset it after use
          $this->session->unset_userdata('users_scs');
          $this->session->unset_userdata('users_fail');
        ?> 