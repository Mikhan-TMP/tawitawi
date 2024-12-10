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
      <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      <!-- <a href="<?= base_url('admin') ?>" class="btn btn-md btn-info mb-2">Back</a>       -->
    </div>
  </div>
  <div class="row">
      <!-- a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Attend_export/createexcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
      <a class="pull-right btn btn-info btn-sm m-3" style="margin-right:40px" href="<?php echo site_url(); ?>/Report/attend_print"><i class="fa fa-file-excel-o"></i> PDF</a -->
      <div class="col-sm-12 col-lg-12 ml-auto ">
        <form action="" method="GET">
          <div class="row d-flex flex-wrap ml-2" style="gap: 10px">
            <?php $date = date("Y-m-d", strtotime("today"));  ?>

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">From:</label>
              <div class="">
                <input type="date" name="start" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>"  class="form-control" >            
                <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>
            <!-- <h5 class="mt-1 ml-3">From:</h5>
            <div class="col-2">
              <input type="date" name="start" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>"  class="form-control" required>            
              <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
            </div> -->

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">To:</label>
              <div class="">
                <input type="date" name="end" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>" class="form-control" >                 
                <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
              </div>
            </div>

            <!-- <h5 class="mt-1 ml-2">To:</h5>
            <div class="col-2">
              <input type="date" name="end" placeholder= "<?php echo $date ?>"  max="<?php echo $date ?>" class="form-control" required>                 
              <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
            </div> -->

            <div class="d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px">
              <label class="text-dark" style="font-weight: bold;">Area:
              </label>
                <div class="">
                  <select class="form-control" name="room">              
                    <option value="">All</option>
                    <?php foreach ($roomlist as $d) : ?>
                      <option value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
                </div>
            </div>
            <!-- <h5 class="mt-1 ml-2">Area:</h5>
            <div class="col-3">
              <select class="form-control" name="room">              
                <option value="">All</option>
                <?php foreach ($roomlist as $d) : ?>
                  <option value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option>
                <?php endforeach; ?>
              </select>
              <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
            </div> -->
            
            <div class="buttons d-flex" style="align-items: center; flex-wrap: wrap; gap: 10px" >
              <div class="">
                <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block text-white" style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); padding: 10px; width: 100px;  border:none; border-radius: 15px">
                <i class="fa fa-search"></i>
                Show</button>            
              </div>
              <div class="">
                  <button type="submit" name="submit" value="Print"  class="btn btn-success btn-fill btn-block text-white"
                  style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); padding: 10px; width: 100px; border:none; border-radius: 15px">
                  <i class="fa fa-print"></i>
                  Print</button>
              </div>
              <div class="">
                <button type="submit"  id="exportCsv" class="btn btn-success btn-fill btn-block text-white"
                style="background: linear-gradient(180deg, #0F25EE, #1F2DB0); border:none; padding: 10px; width: 100px; border-radius: 15px">
                <i class="fa fa-file-excel"></i>
                Export</button>
              </div>
            </div>
          </div>
        </form>
      </div>
  </div><br>
  <!-- End of row show -->
  <?php if ($book == false) : ?>
    <h1>No Data, Please Pick Your Date and Building</h1>
  <?php else : ?>


    <?php if ($book != null) : ?>


      <!-- Export exel and PDF -->

      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex" 
                  style="justify-content: space-between;
                        border-top-left-radius: 15px;
                        border-top-right-radius: 15px;
                        background: linear-gradient(180deg, #0F25EE, #1F2DB0);
            ">
          <!-- <h6 class="m-0 text-light" 
                  style="font-size:1.5rem;
                  font-family: 'Inter', sans-serif;">Table Name</h6> -->
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
            <table class="table " id="dataTable" width="100%" cellspacing="0">
              <thead style="color: #272727; font-weight: 500;">
                <tr>
                  <tr>
                  <th >#</th>
                    <th class="header">Date</th>
                    <th class="header">Floor</th> 
                    <th class="header">Room Name</th> 
                    <th class="header">Title</th> 
                    <th class="header">Rep. Name</th> 
                    <th class="header">Time In</th> 
                    <th class="header">Time Out </th> 
                    <th class="header">Duration</th>  
                  </tr>
              </thead>              
              <tbody style="color: #272727;">
                <?php
                $i = 1;
                foreach ($book as $atd) :
                ?>

                  <tr>
                  <td><?= $i++; ?></td>                    
                    <td><?= $atd['date']; ?></td>
                    <td><?= $atd['floor']; ?></td>
                    <td><?= $atd['room']; ?></td>
                    <td><?= $atd['title']; ?></td>                    
                    <td><?= $atd['username']; ?></td>                   
                    <td><?php if($atd['in_time']==NULL)
                              echo "N/A";
                            else 
                              echo $atd['in_time']; ?></td>
                    <td><?php if($atd['out_time']==NULL)
                              echo "N/A";
                            else 
                              echo $atd['out_time']; ?></td>
                    
                    <?php 
                          if(($atd['in_time']==NULL) || ($atd['out_time']==NULL)){                            
                            $duration = "N/A";
                          }
                          else{
                            $time1 = new DateTime($atd['in_time']);
                            $time2 = new DateTime($atd['out_time']);
                            $interval = $time1->diff($time2);
                            $duration = $interval->format('%h Hours %i Minutes');
                          }
                    ?>
                    <td><?= $duration ?> </t>
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
<script>
   $(document).ready(function () {
    $('#exportCsv').on('click', function () {
            var csv = [];
            var rows = $(".table tr:visible");

            // Get headers
            var headers = [];
            $(rows[1]).find('th').each(function() {
                headers.push($(this).text().trim());
            });
            csv.push(headers.join(","));

            // Get data
            $(rows).slice(2).each(function() {  // Skip filter row
                var row = [];
                $(this).find('td').each(function() {
                    var cellData = $(this).text().trim().replace(/(\r\n|\n|\r)/gm, '');  // Remove newline characters
                    cellData = cellData.replace(/"/g, '""');  // Escape double quotes
                    row.push('"' + cellData + '"');  // Enclose in double quotes
                });
                csv.push(row.join(","));
            });

            // Download CSV
            var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
            var downloadLink = document.createElement("a");
            downloadLink.download = "Library Room Attendance History.csv";
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        });
   });
 </script>