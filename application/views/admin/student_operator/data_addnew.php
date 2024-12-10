<div class="content-wrapper">
    
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="h3 mb-4 text-gray-800">Student Form</h1>
            <a href="<?= base_url('Data_Master/student'); ?>" class="btn btn-secondary btn-icon-split mb-4">
              <span class="icon text-white">
                <i class="fas fa-chevron-left"></i>
              </span>
              <span class="text">Back</span>
            </a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Dashboard</a></li>
              <li class="breadcrumb-item">Admim</li>
              <li class="breadcrumb-item active">Add Data</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    
    
    <section class="content">
      <div class="container-fluid">
       <div class="row">
          <div class="col-12">
            <div class="card">
            <h5 class="card-header">Student Add form</h5>

              <div class="card-body">
                <h5 class="card-title">Add Data</h5>
                <p class="card-text">Form to Add data to system</p>
                <?php if($this->session->flashdata('msg_alert')) { ?>

                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?=$this->session->flashdata('msg_alert');?>
                </div>
                <?php } ?>

<!-- Add Student -->
              <?=form_open('data_master/add_new/' . $name);?>
                <?php if($name=='mhs') { ?>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="first_name">Fist Name</label>
                          <input type="text" 
                            class="form-control" 
                            name="first_name" id="first_name_d" 
                            placeholder="fist name" required>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last Name</label>
                          <input type="text" 
                            class="form-control" 
                            name="last_name" id="last_name_d" 
                            placeholder="last name" required>
                      </div>
                      <div class="form-group">
                        <label for="srcode">SR code</label>
                          <input type="text" 
                            class="form-control" 
                            name="srcode" id="srcode_d" 
                            placeholder="srcode name" required>
                      </div><div class="form-group">
                        <label for="program">Program</label>
                          <input type="text" 
                            class="form-control" 
                            name="program" id="program_d" 
                            placeholder="program name" required>
                      </div><div class="form-group">
                        <label for="rfid">RFID</label>
                          <input type="text" 
                            class="form-control" 
                            name="rfid" id="rfid_d" 
                            placeholder="rfid name" required>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="qrcode">QR Code</label>
                          <input type="text" 
                            class="form-control" 
                            name="qrcode" id="qrcode_d" 
                            placeholder="qrcode name" required>
                      </div>
                      <div class="form-group">
                        <label for="gender">Gender</label>
                          <input type="text" 
                            class="form-control" 
                            name="gender" id="gender_d" 
                            placeholder="gender name" required>
                      </div>
                      <div class="form-group">
                        <label for="course">Course</label>
                          <input type="text" 
                            class="form-control" 
                            name="course" id="course_d" 
                            placeholder="course name" required>
                      </div><div class="form-group">
                        <label for="schoolyear">School Year</label>
                          <input type="year" 
                            class="form-control" 
                            name="schoolyear" id="schoolyear_d" 
                            placeholder="shool year" required>
                      </div>
                    </div>
                  </div>

                <?php } ?>

<!-- Add Course -->
                <?php if($name=='mk') { ?>
                  <div class="form-group">
                    <label for="name_course">name course</label>
                    <input type="text" class="form-control" name="name_course" id="name_course_d" placeholder="Add Course...">
                  </div>
                <?php } ?>
                
<!-- over all Value -->
                <?php if($name=='value') { ?>
                  <div class="form-group">
                    <label for="id_d">name student</label>
                    <select name="id" id="id_d" class="form-control">
                      <option disabled selected>-- Pilih --</option>
                      <?php
                        foreach($list_mhs as $lm) {
                      ?>
                      <option value="<?=$lm->id;?>"><?=$lm->first_name;?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="id_course_d">name Mata Kuliah</label>
                    <select name="id_course" id="id_course_d" class="form-control">
                      <option disabled selected>-- Pilih --</option>
                      <?php
                        foreach($list_mk as $lm) {
                      ?>
                      <option value="<?=$lm->id_course;?>"><?=$lm->name_course;?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="value_d">value</label>
                    <input type="number" class="form-control" name="value" id="value_d" placeholder="Masukkan value...">
                  </div>
                <?php } ?>

                <div class="card-footer">
                  <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                    <span class="icon text-white">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Add Student</span>
                  </button>
                </div>
              <?=form_close();?>
            </div>
          </div>
        </div>
	  </div>
    </section>
    
  </div>
  
  <footer class="main-footer">
    <div class="container-fluid">
      School &copy; <?=date('Y');?> Batangas State University
      <div class="float-right d-none d-sm-inline-block">
        <b>CODE</b> 675688999990
      </div>
    </div>
  </footer>
  
</div>
<script src="<?=base_url('assets/plugins/');?>jquery/jquery.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>fastclick/fastclick.js"></script>

<script src="<?=base_url('assets/dist/');?>js/adminlte.js"></script>