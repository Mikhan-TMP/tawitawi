        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1 -->
          <h5 class="card-title">Add New Student</h5>
          <div class="row">
            <div class="col-lg-3">
              <a href="<?= base_url('master/student'); ?>" class="btn btn-secondary btn-icon-split mb-4">
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
          <div class="col-lg-6 p-0 m-auto">
            <?= form_open_multipart('master/add_student'); ?>
            <div class="card">
            <h3 class="mb-0 text-left text-light" 
                  style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                  border-top-left-radius:15px;
                  border-top-right-radius:15px;
                  padding: 1.5rem;
                  font-size: 1.5rem;">
                  Student Data</h3>
              <div class="card-body">

                <div class="row">
                  <div class="col-lg-6">
                  <div class="form-group mt-4" style="    
                                                display: flex;
                                                flex-direction: column;
                                                /* border-color: blue;">
                      <label for="e_name"  class="text-dark" style="font-weight: bold;">First Name</label>                      
                        <input type="text" class="form-control col-lg" name="f_name" id="f_name" required autofocus
                        style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter First Name">
                        <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <div class="col-lg-6">
                                      <div class="form-group mt-4" style="    
                                                display: flex;
                                                flex-direction: column;
                                                /* border-color: blue;">
                      <label for="e_name"  class="text-dark" style="font-weight: bold;">Middle Name</label>                      
                        <input type="text" class="form-control col-lg" name="m_name" id="m_name" required
                        style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Middle Name">
                        <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                </div>
                <!-- Second Row -->
                <div class="row">
                  <!-- Last Name -->
                  <div class="col-lg-6">
                      <div class="form-group mt-4" style="    
                                display: flex;
                                flex-direction: column;
                                /* border-color: blue;">
                        <label for="e_name"  class="text-dark" style="font-weight: bold;">Last Name</label>                      
                        <input type="text" class="form-control col-lg" name="l_name" id="l_name" required\
                        style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Last Name">
                        <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>                      
                      </div>
                  </div>
                    <!-- Student ID -->
                  <div class="col-lg-6">
                    <div class="form-group mt-4" style="    
                              display: flex;
                              flex-direction: column;
                              /* border-color: blue;">
                      <label for="srcode"  class="text-dark" style="font-weight: bold;">Student ID</label>
                      <input type="text" class="form-control col-lg" name="srcode" id="srcode" required
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Student ID">
                      <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                </div>

                <!-- Third Row -->
                <div class="row">
                  <!-- Email -->
                  <div class="col-lg-6">
                      <div class="form-group mt-4" style="    
                                display: flex;
                                flex-direction: column;
                                /* border-color: blue;">
                      <label for="email"  class="text-dark" style="font-weight: bold;">Email</label>
                      <input type="text" class="form-control col-lg" name="email" id="email" required
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Email">
                      <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <!-- Pin -->
                  <div class="col-lg-6">
                    <div class="form-group mt-4" style="    
                                display: flex;
                                flex-direction: column;
                                /* border-color: blue;">
                      <label for="pin"  class="text-dark" style="font-weight: bold;">PIN</label>
                      <input type="text" class="form-control col-lg" name="pin" id="pin" required
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter PIN">
                      <?= form_error('e_pin', '<small class="text-danger">', '</small>') ?>
                      </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mt-4" style="    
                              display: flex;
                              flex-direction: column;
                              /* border-color: blue;">
                      <label for="d-id"  class="text-dark" style="font-weight: bold;">QR</label>
                      <input type="text" class="form-control col-lg" name="college" id="college" required
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter College">
                      <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                </div>

                <!-- Fourth Row -->
                <div class="row">
                  <!-- College -->
                  <div class="col-lg-6">
                    <div class="form-group mt-4" style="    
                              display: flex;
                              flex-direction: column;
                              /* border-color: blue;">
                      <label for="d-id"  class="text-dark" style="font-weight: bold;">College</label>
                      <input type="text" class="form-control col-lg" name="college" id="college" required
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter College">
                      <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <!-- Course -->
                  <div class="col-lg-6">
                    <div class="form-group mt-4" style="    
                              display: flex;
                              flex-direction: column;
                              /* border-color: blue;">
                      <label for="d_id"  class="text-dark" style="font-weight: bold;">Course</label>
                      <input type="text" class="form-control col-lg" name="course" id="course" required
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Course">
                      <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                </div>    


                <!-- <div class="row">
                  <div class="col-lg-6">                
                                      <div class="form-group mt-4" style="    
                                                display: flex;
                                                flex-direction: column;
                                                /* border-color: blue;">
                      <label for="qrcode"  class="text-dark" style="font-weight: bold;">QRCODE</label>
                      <input type="text" class="form-control col-lg" name="qrcode" id="qrcode">
                      <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <div class="col-lg-6">                
                                      <div class="form-group mt-4" style="    
                                                display: flex;
                                                flex-direction: column;
                                                /* border-color: blue;">
                      <label for="rfid"  class="text-dark" style="font-weight: bold;">RFID</label>
                      <input type="text" class="form-control col-lg" name="rfid" id="rfid" required>
                      <?= form_error('e_birth_date', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                </div> -->

                <!-- Fifth Row -->
                <div class="row">
                  <!-- Year -->
                  <div class="col-lg-6">              
                    <div class="form-group mt-4" style="    
                              display: flex;
                              flex-direction: column;
                              /* border-color: blue;">
                      <label   class="text-dark" style="font-weight: bold;">Year</label>
                      <input type="number" class="form-control col-lg" name="year" id="year" min=1 max=6
                      style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Year">
                      <?= form_error('e_hire_date', '<small class="text-danger">', '</small>') ?>
                    </div>
                  </div>
                  <!-- Gender -->
                  <div class="col-lg-6">           
                    <div class="form-group mt-4" style="    
                              display: flex;
                              flex-direction: column;
                              /* border-color: blue;">
                      <label for="e_gender"  class="text-dark" style="font-weight: bold;">Gender</label>
                      <br>
                      <div class="form-check form-check-inline my-0" >
                        <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" checked>
                        <label class="form-check-label" for="m"> Male   </label>
                        <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>                      
                        &nbsp
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="e_gender" id="f" value="F">
                          <label class="form-check-label" for="f"> Female </label>
                        </div>
                      </div>                  
                    </div>
                  </div>
                </div>    
                
               <!-- Last Row -->
              <div class ="row">
                  <div class="w-100">                
                    <button type="submit"style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); border:none; padding: 5px; border-radius: 15px;"
                     class="btn btn-success btn-icon-split mt-4 float-right w-100">
                      <!-- <span class="text-white icon"> <i class="fas fa-plus"></i></span> -->
                      <span class="text">ADD STUDENT </span> </button>
                    <?= form_close(); ?>
                  </div>
              </div>

            </div>
          </div>
          </form>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <script>
          // Add the following code if you want the name of the file appear on select
          $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
          });
        </script>
        <!-- RFID UID INPUT -->
        <script>
          document.addEventListener("DOMContentLoaded", function() {
              const ws = new WebSocket('ws://localhost:8090'); // Adjust the WebSocket URL if necessary

              ws.onmessage = function(event) {
                  const nfcTag = event.data;
                  document.getElementById('rfid').value = nfcTag;
                  console.log('UID received:', nfcTag);
                  // Trigger the AJAX request after receiving the NFC tag
                  getNfcTag();
              };

              ws.onopen = function() {
                  console.log('WebSocket connection established');
              };

              ws.onclose = function() {
                  console.log('WebSocket connection closed');
              };

              ws.onerror = function(error) {
                  console.error('WebSocket error:', error);
              };
          });
      </script>