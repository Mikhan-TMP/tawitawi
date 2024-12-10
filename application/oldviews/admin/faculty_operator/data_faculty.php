<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
              <h1 class="h3 mb-4 text-gray-800">Faculty</h1>
              <a href="<?= base_url('admin'); ?>" class="btn btn-secondary btn-icon-split mb-4">
                <span class="icon text-white">
                  <i class="fas fa-chevron-left"></i>
                </span>
                <span class="text">Back</span>
              </a>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a class="text-info" href="<?= base_url('admin'); ?>">Dashboard</a></li>
                  <li class="breadcrumb-item">admin</li>
                  <li class="breadcrumb-item active">faculty</li>
                </ol>
              </div>
            </div>
        </div>

          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">

              <span>
                <button type="button" onclick="javascript:top.location.href='<?=base_url("/faculty_master/add_new/mhs");?>';" class="btn btn-info btn-icon-split mb-4">
                  <span class="icon text-white-600">
                    <i class="fas fa-plus-circle"></i>
                  </span>
                  <span class="text">New Faculty</span>
                </button>
              </span>

              <span>
                <button type="button" class="btn btn-secondary btn-icon-split mb-4" data-toggle="modal" data-target=".bd-01-modal-xl" style="margin-bottom: 20px;">
                  <span class="icon text-white-600">
                  <i class="fas fa-file-import"></i>
                  </span>
                  <span class="text">Import</span>
                </button>
              </span>

              <span>
                <button type="button" onclick="javascript:top.location.href='<?=base_url('/filter_data/');?>';" class="btn btn-info btn-icon-split mb-4 mr-2">
                  <span class="icon text-white-600">
                  <i class="fas fa-filter"></i>
                  </span>
                  <span class="text">Filter Faculty</span>
                </button>
              </span>

              <!-- Modal 01 (import excel faculty) -->
              <div class="modal fade bd-01-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Import New Student with Excel</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div class="container">
                          <form method="post" id="import_form" enctype="multipart/form-data">
                            <p><label>Select Excel File</label>
                            <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
                            <br />
                            <input type="submit" name="import" value="Import" class="btn btn-info" />
                          </form> 
                          <!-- Here's The Table -->
                                  <div class="table-responsive" id="customer_data">
                                  </div>
                        </div>
                        </div>
                        <!-- end Modal body -->

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>



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
              <h6 class="m-0 font-weight-bold text-primary">Data-Tables Faculty</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <th>ID</th>
                    <th>first Name</th>
                    <th>Last Name</th>
                    <th>srcode</th>
                    <th>gender</th>
                    <th>qrcode</th>
                    <th>rfid</th>
                    <th>course</th>
                    <th>actions</th>
                    </tr>
                  </thead>
                
                  <tbody>
                  <?php
                    $i=1;
                    foreach ($list_fuclty as $d) {
                  ?>
                      
                      <tr>
                        <td class=" align-middle"><?=$d->id;?></td>
                        <td class=" align-middle"><?=$d->first_name;?></td>
                        <td class=" align-middle"><?=$d->last_name;?></td>
                        <td class=" align-middle"><?=$d->srcode;?></td>
                        <td class=" align-middle"><?=$d->gender;?></td>
                        <td class=" align-middle"><?=$d->rfid;?></td>
                        <td class=" align-middle"><?=$d->qrcode;?></td>
                        <td class=" align-middle"><?=$d->course;?></td>
                        
                        <td class="text-center align-middle">
                          <button type="button" onclick="javascript:top.location.href='<?=base_url("/faculty_master/edit/mhs/{$d->id}");?>';" class="btn btn-primary btn-circle"><i class="fas fa-edit"></i></button>
                          <button type="button" onclick="javascript:top.location.href='<?=base_url("/faculty_master/delete/mhs/{$d->id}");?>';" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></button>
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





        <script>
$(document).ready(function(){

	load_data();

	function load_data()
	{
		$.ajax({
			url:"<?php echo base_url(); ?>faculty_import/fetch",
			method:"POST",
			success:function(data){
				$('#customer_data').html(data);
			}
		})
	}

	$('#import_form').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url:"<?php echo base_url(); ?>faculty_import/import",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				$('#file').val('');
				load_data();
				alert(data);
			}
		})
	});

});
</script>






<script src="<?=base_url('assets/plugins/');?>jquery/jquery.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>fastclick/fastclick.js"></script>

<script src="<?=base_url('assets/dist/');?>js/adminlte.js"></script>



