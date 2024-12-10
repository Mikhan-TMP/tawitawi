        <!-- Begin Page Content -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg">
            <h1 class="h3 mb-4 text-gray-800">Faculty Information</h1>
              <!-- <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a> -->
            </div>
          </div>
          <div class="row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card border-0 bg-transparent">
                  <div class="card-body mb-0 ml-0 p-0">
                  <a href="<?= base_url('master/a_faculty'); ?>"
                    class="btn btn-icon-split mb-4 shadow-sm text-light" 
                    style="background: linear-gradient(180deg, #031084, #000748); ">
                    <span class="icon text-white-600">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add Faculty</span>
                  </a>
                    <button type="button" class="btn btn-secondary btn-icon-split mb-4 shadow-sm" data-toggle="modal" data-target=".bd-example-modal-xl" style="margin-bottom: 20px;">
                          <span class="icon text-white-600">
                          <i class="fas fa-file-import"></i>
                          </span>
                          <span class="text">Excel Import</span>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card border-0 bg-transparent">
                  <div class="card-body mb-0 pb-0">
                  </div>
                </div>
              </div>
              <!-- Modal for Importing Faculty with Excel -->
              <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content" style="border-radius: 8px;">
                    
                    <!-- Modal Header -->
                    <div class="modal-header" style="background: linear-gradient(180deg, #031084, #000748);  color: white;">
                      <h4 class="modal-title">Import New Faculty with Excel</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="modal-body" style="background-color: #f8f9fa;">
                      <div class="container-fluid">
                        <!-- Information Section -->
                        <div class="alert alert-info" role="alert">
                          Please ensure your CSV file follows the structure below:
                        </div>
                        
                        <!-- CSV Example Table -->
                        <div class="table-responsive">
                          <table class="table table-bordered" style="background-color: white;">
                            <thead>
                              <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Middle Name</th>
                                <th>Faculy ID</th>
                                <th>Department</th>
                                <th>PIN</th>
                                <!-- <th>QRCODE</th> -->
                                <th>Gender</th>

                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td>M</td>
                                <td>001122</td>
                                <td>BS Computer Science</td>
                                <!-- <td>123456</td> -->
                                <td>512311</td>                             
                                <td>Male</td>

                              </tr>
                              <tr>
                                <td>Jane</td>
                                <td>Smith</td>
                                <td>A</td>
                                <td>789012</td>
                                <td>BS Computer Science</td>
                                <td>654321</td>
                                <!-- <td>123155</td> -->
                                <td>Female</td>
                                
                              </tr>
                            </tbody>
                          </table>
                        </div>
          
                        <!-- Form Section -->
                        <form method="post" action="<?php echo base_url();?>import/import_Faculty_File" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="uploadFile">Select Excel File (CSV format only)</label>
                            <input type="file" name="uploadFile" class="form-control-file" id="uploadFile" required accept=".csv" style=" font-size: 16px;">
                          </div>
                          
                          <!-- Submit Button -->
                          <div class="form-group">
                            <input type="submit" name="submit" value="Upload" class="btn btn-info btn-block" style="background: linear-gradient(180deg, #031084, #000748);  font-size: 16px; padding: 10px;">
                          </div>
                        </form>
                      </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="modal-footer" style="border-top: none;">
                      <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 14px;">Close</button>
                    </div>
                    
                  </div>
                </div>
              </div>





          </div>

          <!-- Data Table Faculty-->
          <div class="card shadow mb-4 m-auto" style="border-radius: 15px;">
            <div class="card-header py-3 d-flex" style="justify-content: space-between; border-top-left-radius: 15px; border-top-right-radius: 15px; background: linear-gradient(180deg, #031084, #000748); ">  
              <h6 class="m-0 text-light" style="font-size:1.5rem; font-family: 'Inter', sans-serif;">DataTables Faculty</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                  <thead style="color: #272727; font-weight: 500;">
                    <tr>
                      <th>#</th>
                      <th>ID Number</th>
                      <th>NAME</th>
                      <th>GENDER</th>
                      <th>DEPARTMENT</th>
                      <th>PIN</th>
                      <!-- <th>RFID</th> -->
                      <!-- <th>QRCODE</th> -->
                      
                      
                      <!-- th>IMAGE</th>
                      <th>BUILDING</th -->              
                      <th>ACTION</th>
                    </tr>
                  </thead>
                
                  <tbody style="color: #272727;">
                    <?php
                    $i = 1;
                    foreach ($faculty as $emp) :
                    ?>
                      
                      <tr>
                        <td class=" align-middle"><?= $i++; ?></td>
                        <!-- td class=" align-middle"><?= $emp['id']; ?></td -->
                        <td class=" align-middle"><?= $emp['srcode']; ?></td>
                        <td class=" align-middle"><?= $emp['last_name'].", ".$emp['first_name']." ".$emp['middle_name']; ?></td>
                        <td class=" align-middle"><?php if ($emp['gender'] == 'M') {
                                                    echo 'Male';
                                                  } else {
                                                    echo 'Female';
                                                  }; ?></td>
                        <!-- <td class=" align-middle"><?= $emp['college']; ?></td> -->
                        <td class=" align-middle"><?= $emp['course']; ?></td>
                        <!-- <td class=" align-middle"><?= $emp['rfid']; ?></td> -->
                        <!-- <td class=" align-middle"><?= $emp['qrcode']; ?></td> -->
                        <!-- td class="text-center"><img src="<?= base_url('images/pp/') . $emp['image']; ?>" style="width: 55px; height:55px" class="img-rounded"></td>
                        <td class=" align-middle"><?= $emp['building']; ?></td -->
                        <td class=" align-middle"><?= $emp['pin']; ?></td>
                        <td class="text-center align-middle">
                          <a href="<?= base_url('master/e_faculty/') . $emp['id'] ?>" class="">
                          <span class="text-dark" title="Edit">
                            <i class="fas fa-pen"></i>
                          </span>
                          </a>&nbsp &nbsp
                          <a href="<?= base_url('master/d_faculty/') . $emp['id'] ?>" class="" onclick="return confirm('Deleted faculty will lost forever. Still want to delete?')">
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

          if ($this->session->flashdata('faculty_scs')) {
           echo getAlertMessages('success', $this->session->flashdata('faculty_scs'));
          }
          if ($this->session->flashdata('faculty_fail')) {
           echo getAlertMessages('error', $this->session->flashdata('faculty_fail'));
          }
          
          //unset it after use
          $this->session->unset_userdata('faculty_scs');
          $this->session->unset_userdata('faculty_fail');
        ?> 



<script>




$(document).ready(function(){

load_data();

function load_data()
{
  $.ajax({
    url:"<?php echo base_url(); ?>Faculty_import/fetch",
    method:"POST",
    success:function(data){
      $('#customer_data').html(data);
    }
  })
}

$('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
    url:"<?php echo base_url(); ?>Excel_import/import_faculty",
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