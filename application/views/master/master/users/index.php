        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Librarian Information</h1>

          <div class="row">
          <div class="col-lg-9">
            <a href="<?= base_url('master/a_users'); ?>"
                  class="btn btn-icon-split mb-4 shadow-sm text-light" 
                  style="background: linear-gradient(180deg, #031084, #000748); ">
                  <span class="icon text-white-600">
                    <i class="fas fa-plus-circle"></i>
                  </span>
                  <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add New Librarian</span>
                </a>
            </div>
            <!-- <div class="col-lg-3">
              <a href="<?= base_url('master/user_access'); ?>" class="btn btn-icon-split mb-4" style="background: #C41E3A;">
                <span class="icon text-white">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text text-light">Librarian Access Control</span>
              </a>
            </div> -->
          </div>

          <!-- Data Table Users-->
          <div class="card shadow mb-4" style="border-radius: 15px;">
            <div class="card-header py-3 d-flex" 
                    style="justify-content: space-between;
                          border-top-left-radius: 15px;
                          border-top-right-radius: 15px;
                          background: linear-gradient(180deg, #031084, #000748); 
              ">
              <h6 class="m-0 text-light" 
                  style="font-size:1.5rem;
                  font-family: 'Inter', sans-serif;">Librarian</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                  <thead style="color: #272727; font-weight: 500;">
                    <tr>                      
                      <!-- <th>ID</th> -->
                      <th>Designation</th>                      
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <!-- <th>Position</th> -->
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody style="color: #272727;">
                    <?php
                    $i = 1;
                    foreach ($data as $dt) :
                    ?>
                      <tr>                        
                        <!-- <td class=" align-middle"><?= $dt['e_id']; ?></td> -->
                        <td class=" align-middle"><?= $dt['e_floor']; ?></td>                                                
                        <td class=" align-middle"> <?= $dt['u_username']; ?>  </td>
                        <td class=" align-middle"> <?= $dt['u_lname']; ?>  </td>
                        <td class=" align-middle"> <?= $dt['u_fname']; ?>  </td>
                        <td class=" align-middle"> <?= $dt['u_email']; ?>  </td>
                        <!-- <td class=" align-middle text-center"> Librarian   </td> -->
                        <td class="text-center align-middle">
                          <a href="<?= base_url('master/e_users/') . $dt['e_id'] ?>" class="">
                            <span class="text-dark" title="Edit">
                              <i class="fas fa-pen"></i>
                            </span>
                          </a>&nbsp &nbsp
                          <a href="<?= base_url('master/d_users/') . $dt['e_id'] ?>" class="" onclick="return confirm('Deleted Users will lost forever. Still want to delete?')">
                            <span class="icon text-danger" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

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
          if ($this->session->flashdata('users_neutral')) {
           echo getAlertMessages('info', $this->session->flashdata('users_neutral'));
          }
          if ($this->session->flashdata('users_fail')) {
           echo getAlertMessages('error', $this->session->flashdata('users_fail'));
          }
          if ($this->session->flashdata('users_validation')) {  
            echo getAlertMessages('warning', $this->session->flashdata('users_validation'));
          }
          
          //unset it after use
          $this->session->unset_userdata('users_scs');
          $this->session->unset_userdata('users_fail');
          $this->session->unset_userdata('users_neutral');
          $this->session->unset_userdata('users_validation');
        ?> 