        <!-- Begin Page Content -->
        <div class="container-fluid">

        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
              <h1 class="h3 mb-4 text-gray-800">Faculty</h1>
              <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
                  <li class="breadcrumb-item">admin</li>
                  <li class="breadcrumb-item active">courses</li>
                </ol>
              </div>
            </div>
        </div>

          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-3">
              <button type="button" onclick="javascript:top.location.href='<?=base_url("/data_master/add_new/mk");?>';" class="btn btn-info btn-icon-split mb-4">
                <span class="icon text-white-600">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">New Course</span>
              </button>
            </div>
            <div class="col-lg-5 offset-lg-4">
              <!-- Alert -->
              <?php if($this->session->flashdata('msg_alert')) { ?>
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?=$this->session->flashdata('msg_alert');?>
              </div>
              <?php } ?>
            </div>
          </div>

          <!-- Data Table employee-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Course</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <th>No.</th>
                    <th>ID course</th>
                    <th>name course</th>
                      
                      <!-- th>IMAGE</th>
                      <th>BUILDING</th -->              
                      <th>Actions</th>
                    </tr>
                  </thead>
                
                  <tbody>
                  <?php
                    $i=1;
                    foreach ($list_mk as $d) {
                  ?>
                      
                      <tr>
                        <td class=" align-middle">
                          <?= $i++; ?>
                        </td>
                        <td class=" align-middle"><?=$d->id_course;?></td>
                        <td class=" align-middle"><?=$d->name_course;?></td>
                        
                        <td class="text-center align-middle">
                          <button type="button" onclick="javascript:top.location.href='<?=base_url("/data_master/edit/mk/{$d->id_course}");?>';" class="btn btn-primary btn-circle"><i class="fas fa-edit"></i></button>
                          <button type="button" onclick="javascript:top.location.href='<?=base_url("/data_master/delete/mk/{$d->id_course}");?>';" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->












<script src="<?=base_url('assets/plugins/');?>jquery/jquery.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>fastclick/fastclick.js"></script>

<script src="<?=base_url('assets/dist/');?>js/adminlte.js"></script>