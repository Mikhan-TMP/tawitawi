<div class="content-wrapper">
    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="h3 mb-4 text-gray-800">faculty Data</h1>
            <!-- <a href="<?= base_url('faculty_master/faculty') ?>" class="btn btn-md btn-info mb-2">Back</a> -->
            <a href="<?= base_url('faculty_master/faculty'); ?>" class="btn btn-secondary btn-icon-split mb-4">
                <span class="icon text-white">
                  <i class="fas fa-chevron-left"></i>
                </span>
                <span class="text">Back</span>
              </a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
              <li class="breadcrumb-item">Admim</li>
              <li class="breadcrumb-item active">Edit Data</li>
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
            <h5 class="card-header">faculty Data</h5>
              
            <div class="card-body">
                <h5 class="card-title">Edit Data</h5>
                <p class="card-text">Form to edit data to system</p>

                <?php if($this->session->flashdata('msg_alert')) { ?>

                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?=$this->session->flashdata('msg_alert');?>
                </div>
                <?php } ?>

<!-- Edit faculty mhs-->
                <?=form_open('faculty_master/edit/'.$name.'/'.$id);?>
                <?php if($name=='mhs') { ?>
                  
                  <div class="form-group"> <!-- Can edit id or stdent number placement -->
                    <input type="hidden" name="id" value="<?=$id;?>">
                    <h4> ID: <span class="badge badge-info"><?=$id;?></span></h4>
                  </div>

              <div class="row">
              
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="first_name">First Name</label>
                      <input type="text" class="form-control" name="first_name" value="<?=$first_name;?>" 
                      style="margin-bottom: 15px;"
                      id="first_name_d" 
                      placeholder="first name faculty">
                    <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" name="last_name" value="<?=$last_name;?>" 
                      style="margin-bottom: 15px;"
                      id="last_name_d" placeholder="last name faculty">
                    <label for="srcode">SR Code</label>
                      <input type="text" class="form-control" name="srcode" value="<?=$srcode;?>" 
                      style="margin-bottom: 15px;"
                      id="srcode_d" placeholder="srcode faculty">
                    <label for="gender">Gender</label>
                      <input type="text" class="form-control" name="gender" value="<?=$gender;?>" 
                      style="margin-bottom: 15px;"
                      id="gender_d" placeholder="gender faculty">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="qrcode">QR Code</label>
                      <input type="text" class="form-control" name="qrcode" value="<?=$qrcode;?>" 
                      style="margin-bottom: 15px;"
                      id="qrcode_d" placeholder="qrcode faculty">
                    <label for="rfid">RFID</label>
                      <input type="text" class="form-control" name="rfid" value="<?=$rfid;?>" 
                      style="margin-bottom: 15px;"
                      id="rfid_d" placeholder="rfid faculty">
                    <label for="course">Course</label>
                      <input type="text" class="form-control" name="course" value="<?=$course;?>" 
                      style="margin-bottom: 15px;"
                      id="course_d" placeholder="course faculty">
                  </div>
                </div>
              </div>
                  <?php } ?>

<!-- Edit Course -->
                <?php if($name=='mk') { ?>
                  <input type="hidden" name="id_course" value="<?=$id_course;?>">
                  
                <div class="row"> 
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name_course">Name Course</label>
                      <input type="text" class="form-control" name="name_course" value="<?=$name_course;?>" id="name_course_d" placeholder="Masukkan name mata kuliah...">
                    </div>
                  </div>
                </div>

                <?php } ?>

                <?php if($name=='value') { ?>
                  <input type="hidden" name="id_value" value="<?=$id_value;?>">
                  <div class="form-group">
                    <label for="id_d">name faculty</label>
                    <select name="id" id="id_d" class="form-control">
                      <?php
                        foreach($list_mhs as $lm) {
                      ?>
                      <option value="<?=$lm->id;?>"<?=( ($id==$lm->id)?' selected':'' );?>><?=$lm->first_name;?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="id_course_d">name Mata Kuliah</label>
                    <select name="id_course" id="id_course_d" class="form-control">
                      <?php
                        foreach($list_mk as $lm) {
                      ?>
                      <option value="<?=$lm->id_course;?>"<?=( ($id_course==$lm->id_course)?' selected':'' );?>><?=$lm->name_course;?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="value_d">value</label>
                    <input type="number" class="form-control" name="value" value="<?=$value;?>" id="value_d" placeholder="Masukkan value...">
                  </div>
                <?php } ?>

                <div class="card-footer">
                  <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                    <span class="icon text-white">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text">Proceed</span>
                  </button>
                </div>

              <?=form_close();?>

            </div> <!--end of card body-->
          </div>
        </div>
	  </div>
    </section>
    
  </div>

</div>
<script src="<?=base_url('assets/plugins/');?>jquery/jquery.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>slimScroll/jquery.slimscroll.min.js"></script>

<script src="<?=base_url('assets/plugins/');?>fastclick/fastclick.js"></script>

<script src="<?=base_url('assets/dist/');?>js/adminlte.js"></script>




