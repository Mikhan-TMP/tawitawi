  <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <meta http-equiv="refresh" content="5"> -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <link href="<?= base_url('assets/'); ?>bootstrap_m/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="<?= base_url('images/'); ?>favicon.ico" type="image/x-icon">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Galano+Grotesque:wght@400;700&display=swap"> -->
  <title>Live Monitoring</title>
  <style>
    body {
    margin: 0;
    padding: 0;
    background: url('<?= base_url('images/elmk.png'); ?>') no-repeat center center fixed; / Set background image /
    background-size: cover; / Cover the entire viewport /
    font-family: Arial, sans-serif;
    overflow: hidden;
    }

    header {
      / background-color: #990000; /
      color: #fff;
      padding: 50px;
      text-align: center;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header img {
      max-width: 100%;
      height: auto;
    }
    
    h1 {
      font-family: 'Galano Grotesque', Arial, sans-serif; 
      color: #C41E3A;
      margin: 15px; 
      font-weight: 700;
      font-size: 55px;
      
    }
    h2 {
      font-family: 'Galano Grotesque', Arial, sans-serif; 
      color: #C41E3A;
      margin-top: 0; 
      font-weight: 700;
      font-size: 35px;
      
    }
    .pic{
      margin-top: -280px;
      border: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .head{
      margin-top: -60px;
      border: none;
    }
    .time{
      margin-top: 645px;
      margin-left: 900px;
      border: none;
    }
    
    .content{
      width: 80%;
      margin: auto;
    }
  </style>
</head>
<body>

  <header>
    
  </header>

  <div class="card bg-transparent head">
    <div class="card-body text-center">
      <h1>AREA/SEAT LIVE MONITORING</h1>
    </div>
  </div>
  <br><br><br>
  <div class="content">
  <div class="card-group">
    <?php $i = 0;
              foreach ($slotdata as $slot){ ?> 
          <div class="col-xl-2 col-md-2 mb-2">
              <?php if ($slot['status']==0) { ?>
              <div class="card text-white bg-primary shadow p-2">
              <?php } else if($slot['status']==1) { ?>
              <div class="card border-left-info shadow  p-2" >
              <?php } else {?>
              <div class="card text-white bg-success shadow  p-2" >
              <?php } ?>
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-white text-uppercase mb-1"> Seat : <?= $slot['id'] ?></div>
                              <?php if ($slot['status']==0) { ?>
                                  <div class="h3 text-center mb-0 font-weight-bold text-white-800"> <?= $slot['time'] ?> </div>
                                  <div class="text-xs font-weight-bold text-white text-center mb-1"><?= $slot['username'] ?></div>
                              <?php } else if($slot['status']==1) { ?>
                                  <div class="h3 text-center mb-0 font-weight-bold text-gray-800">Vacant</div>                            
                              <?php } else {?>
                                  <div class="h3 text-center mb-0 font-weight-bold text-white-800"> <?= $slot['time'] ?> </div>
                                  <div class="text-xs font-weight-bold text-white text-center mb-1">not attend</div>
                              <?php } ?>
                          </div>
                          <div class="col-auto">
                              <?php if ($slot['status'] ==0) { ?>
                              <i class="fas fa-clock fa-2x text-white-300"></i>
                              <?php } else if($slot['status']==1) { ?>
                              <i class="fas fa-spinner fa-2x text-black-300" ></i>
                              <?php } else {?>
                              <i class="fas fa-hourglass fa-2x text-black-300"></i>
                              <?php } ?>                        
                          </div>   
                      </div>                 
                  </div>
              </div>
          </div>
          <?php } ?>  
    </div>
  </div>
  <div class="card bg-transparent time">
    <div class="card-body text-center">
      <h2 id="clock"></h2>
    </div>
  </div>
<!-- TWO PICS AT THE BOTTOM -->
<div class="card bg-transparent pic">
  <div class="card-body p-0 m-0"> 
    <!-- <img src="<?= base_url('images/') . 'man.png'; ?>" alt="" style="margin-right: 1003px;">
    <img src="<?= base_url('images/') . 'building.png'; ?>" alt="" style="margin-top: 7px;"> -->
  </div>
</div>    

<script>
  // JavaScript code for the clock
  function updateClock() {
    var now = new Date();
    var month = now.getMonth() + 1; // Months are zero-based
    var day = now.getDate();
    var year = now.getFullYear();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'

    minutes = minutes < 10 ? '0' + minutes : minutes;

    var dateString = month + '/' + day + '/' + year;
    var timeString = hours + ':' + minutes + ' ' + ampm;

    var dateTimeString = dateString + ' ' + timeString;
    document.getElementById('clock').innerText = dateTimeString;
  }

  // Update the clock every second
  setInterval(updateClock, 1000);

  // Initial call to display the clock immediately
  window.onload = function () {
    updateClock();
  };
</script>

