<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Attendance (Faculty) Report</title>
</head>

<body>
  <div class="container border">
    <div class="row mb-2">
      <div class="col">
        <h2 class="text-center">Faculty Attendance Report</h2>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-6">
        <h1 class="h5">Building Code : <?= $dept_code; ?> </h1>
      </div>
      <div class="col-6 text-right">
         <h1 class="h5">Date : <?= $start; ?> ~ <?= $end; ?></h1>
      </div>
    </div> 
    
        
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>QRcode</th>
          <th>RFID</th>
          <th>ID </th>
          <th>Name</th> 
          <th>Building </th>
          <th>Time In</th>
          <th>image</th>         
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
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <!-- Optional JavaScript -->
  <script>
    window.print();
  </script>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>