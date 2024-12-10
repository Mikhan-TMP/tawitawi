
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- Begin Page Content -->
<div class="container-fluid">

        <div class="content-header">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="h3 mb-4 text-gray-800">Students</h1>
                <a href="<?= base_url('admin'); ?>" class="btn btn-secondary btn-icon-split mb-4">
                  <span class="icon text-white">
                    <i class="fas fa-chevron-left"></i>
                  </span>
                  <span class="text">Back</span>
                </a>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a class="text-info" href="javascript:;">Dashboard</a></li>
                  <li class="breadcrumb-item">admin</li>
                  <li class="breadcrumb-item active">students</li>
                </ol>
              </div>
            </div>
        </div>

          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">
              
                <span>
                <button type="button" onclick="javascript:top.location.href='<?=base_url("/data_master/add_new/mhs");?>';" class="btn btn-info btn-icon-split mb-4 mr-2">
                  <span class="icon text-white-600">
                    <i class="fas fa-plus-circle"></i>
                  </span>
                  <span class="text">New Student</span>
                </button>
                </span>

                <span>
                <button type="button" class="btn btn-secondary btn-icon-split mb-4 mr-2" data-toggle="modal" data-target=".bd-01-modal-xl" style="margin-bottom: 20px;">
                  <span class="icon text-white-600">
                  <i class="fas fa-file-import"></i>
                  </span>
                  <span class="text">Import</span>
                </button>
                </span>

                <!-- <span>
                <button type="button" class="btn btn-secondary btn-icon-split mb-4" data-toggle="modal" data-target=".bd-02-modal-xl" style="margin-bottom: 20px;">
                  <span class="icon text-white-600">
                  <i class="fas fa-excel"></i>
                  </span>
                  <span class="text">Filter</span>
                </button>
                </span> -->

                <span>
                <button type="button" onclick="javascript:top.location.href='<?=base_url('/filter_data/');?>';" class="btn btn-info btn-icon-split mb-4 mr-2">
                  <span class="icon text-white-600">
                  <i class="fas fa-filter"></i>
                  </span>
                  <span class="text">Filter Student</span>
                </button>
                </span>

                
                

                <!-- Modal 01 -->
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


                  <!-- Modal 02 -->
                  <div class="modal fade bd-02-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
                            <!-- Search filter -->
                              <div>
                                <!-- City -->
                                <select id='sel_city'>
                                  <option value=''>-- Select city --</option>
                                  <?php 
                                  foreach($cities as $city){
                                    echo "<option value='".$city."'>".$city."</option>";
                                  }
                                  ?>
                                </select>

                                <!-- Gender -->
                                <select id='sel_gender'>
                                  <option value=''>-- Select Gender --</option>
                                  <option value='M'>M</option>
                                  <option value='F'>F</option>
                                </select>

                                <!-- Name -->
                                <input type="text" id="searchName" placeholder="Search Name">
                              </div>

                              <!-- Table -->
                              <table id='userTable' class='display dataTable'>

                                <thead>
                                  <tr>
                                <th>first Name</th>
                                <th>Last Name</th>
                                <th>srcode</th>
                                <th>program</th>
                                <th>rfid</th>
                                <th>qrcode</th>
                                <th>gender</th>
                                <th>course</th>
                                <th>schoolyear</th>
                                <th>actions</th>
                                  </tr>
                                </thead>

                              </table>

                              
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
              <h6 class="m-0 font-weight-bold text-primary">Data-Tables Student</h6>
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
                    <th>program</th>
                    <th>rfid</th>
                    <th>qrcode</th>
                    <th>gender</th>
                    <th>course</th>
                    <th>schoolyear</th>
                    <th>actions</th>
                    </tr>
                  </thead>
                
                  <tbody>
                  <?php
                    $i=1;
                    foreach ($list_mhs as $d) : 
                  ?>
                      
                      <tr>
                        <td class=" align-middle"><?=$d->id;?></td>
                        <td class=" align-middle"><?=$d->first_name;?></td>
                        <td class=" align-middle"><?=$d->last_name;?></td>
                        <td class=" align-middle"><?=$d->srcode;?></td>
                        <td class=" align-middle"><?=$d->program;?></td>
                        <td class=" align-middle"><?=$d->rfid;?></td>
                        <td class=" align-middle"><?=$d->qrcode;?></td>
                        <td class=" align-middle"><?=$d->gender;?></td>
                        <td class=" align-middle"><?=$d->course;?></td>
                        <td class=" align-middle"><?=$d->schoolyear;?></td>
                        
                        <td class="text-center align-middle">
                          <button type="button" onclick="javascript:top.location.href='<?=base_url("/data_master/edit/mhs/{$d->id}");?>';" class="btn btn-secondary btn-circle"><i class="fas fa-edit"></i></button>
                          <button type="button" onclick="javascript:top.location.href='<?=base_url("/data_master/delete/mhs/{$d->id}");?>';" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></button>
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

<!-- Script -->
<script type="text/javascript">
  $(document).ready(function(){
      var userDataTable = $('#userTable').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          //'searching': false, // Remove default Search Control
          'ajax': {
            'url':'<?=base_url()?>Filter_data/userList',
            'data': function(data){
                data.searchCity = $('#sel_city').val();
                data.searchGender = $('#sel_gender').val();
                data.searchName = $('#searchName').val();
            }
          },
          'columns': [
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'srcode' },
            { data: 'program' },
            { data: 'rfid' },
        { data: 'qrcode' },
            { data: 'gender' },
            { data: 'course' },
            { data: 'schoolyear' }
          ]
      });

      $('#sel_city,#sel_gender').change(function(){
        userDataTable.draw();
      });
      $('#searchName').keyup(function(){
        userDataTable.draw();
      });
  });
  </script>


<script>
$(document).ready(function(){

	load_data();

	function load_data()
	{
		$.ajax({
			url:"<?php echo base_url(); ?>excel_import/fetch",
			method:"POST",
			success:function(data){
				$('#customer_data').html(data);
			}
		})
	}

	$('#import_form').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url:"<?php echo base_url(); ?>excel_import/import",
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



