<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="<?= base_url('images/'); ?>LIBRARY.png" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Library Room Reservation</title>
</head>
<a id="printButton" class="btn btn-success m-5" href="<?= base_url('report/book_room_view/')?>">Back</a>
<style>
  @media print {
    #printButton {
      display: none;
    }
  }
</style>
<body>
  <div class="container border p-5">
    <div class="col text-center p-2">
      <img src="<?= base_url('images/'); ?>LIBRARY.png" alt="" width="100px">
      <h5 class="h5">Mindanao State University - General Santos City</h5>
    </div>
    <div class="row mb-2">
      <div class="col">
        <h2 class="text-center">Library Room Reservation History</h2>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-6">
        <h1 class="h5">Building Code : <?= $room; ?> </h1>
      </div>
      <div class="col-6 text-right">
            <h1 class="h5">Date : <?= $start; ?> ~ <?= $end; ?></h1>
      </div>
    </div> 
    
        
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
                    <th >#</th>
                    <th>Date</th>
                    <th>Floor</th> 
                    <th>Room Name</th>    
                    <th>Title</th> 
                    <th>Rep. Name</th>                                     
                    <th>Start Time</th> 
                    <th>End time </th> 
                    <th>Duration</th>
          
        </tr>
      </thead>
      <tbody>
      <?php
                $i = 1;
                foreach ($book as $atd) :
                ?>

                  <tr>
                    <!-- Kolom 1 -->
                    <td><?= $i++; ?></td>                    
                    <td><?= $atd['date']; ?></td>
                    <td><?= $atd['floor']; ?></td>
                    <td><?= $atd['room']; ?></td>                    
                    <td><?= $atd['title']; ?></td>                    
                    <td><?= $atd['username']; ?></td>                    
                    <td><?= $atd['start_time'].":00"; ?></td>
                    <td><?= $atd['end_time'].":00"; ?></td>
                    <td><?= ($atd['end_time']-$atd['start_time'])." Hour"; ?></td>
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