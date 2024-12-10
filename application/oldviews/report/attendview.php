<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css"> -->
<!-- <link rel="icon" type="image/png" href="https://webdamn.com/wp-content/themes/v2/webdamn.png"> -->

<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-lg">
      <h1 class="h1 mb-4 text-gray-900"><?= $title; ?>(Student)</h1>
      <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a>
    
    </div>
  </div>
  <div class="row">
      <!-- a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Attend_export/createexcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
      <a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Report/attend_print"><i class="fa fa-file-excel-o"></i> PDF</a -->
    <div class="col-sm-10 col-lg-10 ml-auto mb-3 float-right">
      <form action="" method="GET">
        <div class="row">
          <?php $date = date("Y-m-d", strtotime("today"));  ?> 
          <div class="col-2">
            <input type="date" name="start" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>"  class="form-control" required>            
            <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="col-2">
            <input type="date" name="end" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>" class="form-control" required>  
               
            <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="col-2">
            <select class="form-control" name="dept">
              <option disabled>Building</option>
              <?php foreach ($location as $d) : ?>
                <option value="<?= $d['id']; ?>"><?= $d['name']; ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('dept', '<small class="text-danger pl-3">', '</small>') ?>
          </div>
          <div class="col-sm-2 col-1">
            <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block">Show</button>            
          </div>
          <div class="col-sm-2 col-1">
              <button type="submit" name="submit" value="Print"  class="btn btn-success btn-fill btn-block">Print</button>
          </div>
          <div class="col-sm-2 col-1">
            <button type="submit"  name="submit" value="Export" class="btn btn-success btn-fill btn-block">Export</button>
              </div>
        </div>
      </form>
    </div>
  </div>
  <!-- End of row show -->
  <?php if ($attendance == false) : ?>
    <h1>No Data, Please Pick Your Date and Building</h1>
  <?php else : ?>


    <?php if ($attendance != null) : ?>


      <!-- Export exel and PDF -->

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h3 class="m-0 font-weight-bold text-primary">Student Attendance</h3>
        </div>
        <div class="card-body">

          <!-- script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
         
          <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-1169273815439326"
            data-ad-slot="1311700855"
            data-ad-format="auto"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script -->

          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead class="bg-info text-white">
                <tr>
                  <tr>
                    <th >#</th>
                    <th class="header">QRcode</th>
                    <th class="header">RFID</th> 
                    <th class="header">SRCode</th>
                    <th class="header">Name</th>  
                    <th class="header">Building</th>
                    <th class="header">Time In</th>     
                    <th class="header">Date</th> 
                    <th class="header">Image</th> 
                  </tr>
              </thead>
              
              <tbody>
                <?php
                $i = 1;
                foreach ($attendance as $atd) :
                ?>

                  <tr>
                    <!-- Kolom 1 -->
                    <td><?= $i++; ?></td>
                    <td><?= $atd['qrcode']; ?></td>
                    <td><?= $atd['RFID']; ?></td>
                    <td><?= $atd['srcode']; ?></td>
                    <td><?= $atd['fname']." ".$atd['lname']; ?></td> 
                    <td><?= $atd['building']; ?></td>
                    <td><?= $atd['in_time']; ?></td>
                    <td><?= $atd['date']; ?></td>
                    <td class="text-center"><img src="<?= base_url('images/pp/') . "s2.png" ?>" style="width: 40px; height:40px" class="img-rounded"> </td>
                  </tr>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->