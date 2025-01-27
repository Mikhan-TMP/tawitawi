        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <div class="row">
            <div class="col-lg-3">
              <a href="<?= base_url('master/a_kiosk'); ?>" class="btn btn-icon-split mb-4 text-light" style="background-color: #C41E3A;">
                <span class="icon text-white-600">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add New Kiosk</span>
              </a>
            </div>
            <div class="col-lg-5">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

          <!-- Data Table Users-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-gray-700">Kiosks </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>                      
                      <th>ID</th>
                      <th>Floor</th>                      
                      <th>Kiosk Name</th>
                      <th>IP Address</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $dt) :
                    ?>
                      <tr>                        
                        <td class=" align-middle"><?= $dt['e_id']; ?></td>
                        <td class=" align-middle"><?= $dt['e_floor']; ?></td>                                                
                        <td class=" align-middle text-center"> <?= $dt['u_username']; ?> </td>
                        <td class=" align-middle text-center">   </td>
                        <td class="text-center align-middle">
                          <a href="<?= base_url('master/e_kiosk/') . $dt['e_id'] ?>" class="btn btn-primary btn-circle ">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> |
                          <a href="<?= base_url('master/d_kiosk/') . $dt['e_id'] ?>" class="btn btn-danger btn-circle" onclick="return confirm('Deleted Users will lost forever. Still want to delete?')">
                            <span class="icon text-white" title="Delete">
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