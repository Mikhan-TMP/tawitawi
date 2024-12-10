        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1 -->
          <div class="row">
            <div class="col-lg-3">
              <a href="<?= base_url('master/faculty'); ?>" class="btn btn-secondary btn-icon-split mb-4">
                <span class="icon text-white">
                  <i class="fas fa-chevron-left"></i>
                </span>
                <span class="text">Back</span>
              </a>
            </div>
              <!-- Msg -->
            <div class="col-lg-5 offset-lg-4">
              <?= $this->session->flashdata('message'); ?>
            </div>

            </div>
            <!-- content -->
            <div class="col-lg-6 p-0 m-auto">
              <?= form_open_multipart('master/add_faculty'); ?>
              <div class="card">
                <h3 class="mb-0 text-left text-light" 
                    style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                    border-top-left-radius:15px;
                    border-top-right-radius:15px;
                    padding: 1.5rem;
                    font-size: 1.5rem;">
                    Faculty Data</h3>
                  <div class="card-body">
                    <!-- <h5 class="card-title">Add New Faculty</h5>-->
                    <!-- first row -->
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group ">
                          <label for="e_name" class="text-dark" style="font-weight: bold;">First Name</label>
                          <input type="text" class="form-control col-lg" name="f_name" id="f_name" required
                          style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter First Name">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group ">
                          <label for="e_name" class="text-dark" style="font-weight: bold;">Middle Name</label>
                          <input type="text" class="form-control col-lg" name="m_name" id="m_name"
                          style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Middle Name">
                        </div>
                      </div>
                    </div>
                    <!-- second row -->
                    <div class ="row">
                      <div class="col-lg-6">
                          <div class="form-group ">
                            <label for="e_name" class="text-dark" style="font-weight: bold;">Last Name</label>
                            <input type="text" class="form-control col-lg" name="l_name" id="l_name" required
                            style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Last Name">                     
                          </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="course" class="text-dark" style="font-weight: bold;">Department</label>
                          <input type="text" class="form-control col-lg" name="course" id="course" required
                          style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Department">                            
                        </div>
                      </div>
                    </div>
                    <!-- third row -->
                    <div class ="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="srcode" class="text-dark" style="font-weight: bold;">Faculty ID </label>
                          <input type="number" class="form-control col-lg" name="srcode" id="srcode" required
                          style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Faculty ID">                        
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                            <label for="pin" class="text-dark" style="font-weight: bold;">Pin</label>
                            <input type="number" class="form-control col-lg" name="pin" id="pin" required
                            style="border-radius:15px; font-size: 1rem; padding: 25px;" placeholder="Enter Pin">                        
                        </div>
                      </div>                    
                    </div>
                    <!-- fourth row -->
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group ">
                            <label for="e_gender" class="text-dark" style="font-weight: bold;">Gender</label>
                            <br>
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
                    <!-- fifth row -->
                    <div class="row">
                      <div class="w-100">
                        <button type="submit"style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); border:none; padding: 5px; border-radius: 15px;" class="btn btn-success btn-icon-split mt-4 float-right w-100">
                          <!-- <span class="icon text-white">
                              <i class="fas fa-plus-circle"></i>
                            </span> -->
                        <span class="text">Add to system</span>
                        </button>
                      </div>
                    </div>
                    <?= form_close(); ?>
                  </div>
            </div>

          </div>
        </div>
        </form>
        <!-- </div> -->
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