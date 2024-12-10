        <!-- Begin Page Content -->
        <div class="container-fluid">

          
          <!-- Page Heading -->
          <div class="row mb-3">
            <div class="col-lg">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
              <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-3">
              <!-- a href="<?= base_url('master/a_location'); ?>" class="btn btn-info btn-icon-split mb-4">
                <span class="icon text-white">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add New Location</span>
              </a -->
            </div>
            <div class="col-lg-5 offset-lg-4">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>

          <!-- Data Table Location-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Location</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Location Name</th>
                      <th>Status From KIOSK</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                    $i = 1;
                    foreach ($location as $lct) :
                    ?>
                      <tr>
                        <td class="align-middle"><?= $i++; ?></td>
                        <td class="align-middle"><?= $lct['id']; ?></td>
                        <td class="align-middle"><?= $lct['name']; ?></td>
                        
                        <td class="align-middle">
                          <?php
                            if($i==4 || $i==3 || $i==7 || $i==5) {
                          ?>
                          <span class="badge badge-success">Kiosk On</span>
                          <span class="badge badge-danger">Camera Off</span>
                          <?php } 
                           if($i==2 || $i==6 ) {
                          ?>
                          <span class="badge badge-danger">Kiosk Off</span>
                          <span class="badge badge-success">Camera On</span>
                          <?php } ?>
                        </td>

                        <td class="align-middle text-center">
                          <a href="<?= base_url('master/e_location/') . $lct['id'] ?>" class="btn btn-info btn-circle">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
                            </span>
                          </a> |
                          <a href="<?= base_url('master/d_location/') . $lct['id'] ?>" class="btn btn-danger btn-circle" onclick="return confirm('Deleted Location will lost forever. Still want to delete?')">
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