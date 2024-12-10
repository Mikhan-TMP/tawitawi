<div class="container-fluid">
  <h1 class="h3 mb-4 pt-3 text-gray-800"><?= $title; ?></h1>

  <div class="row">
        <div class="col-sm-12 col-lg-12 ml-auto ">
        <form action="<?= base_url('seat/live'); ?>" method="GET">
            <div class="row">                      
            <div class="col-2">                
                <select class="form-control" name="Floor">              
                <option disabled selected>Select Floor</option>
                <?php foreach ($roomlist as $d) : ?>
                    <!-- option value="<?= $d['room']; ?>"><?= $d['floor']." : ".$d['room']; ?></option -->
                     <option value="<?= $d; ?>"><?= $d; ?></option>
                <?php endforeach; ?>
                </select>
                <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="col-sm-1 col-1">
                <button type="submit" class="btn btn-success btn-fill btn-block">Show</button>            
            </div>
            <!-- div class="col-12">                
                <div id="clock"></div>
            </div -->                        
        </form>  
        </div>
    </div>
  <br><br>
</div>

<!-- <script>
  function submitForm() {
    var selectedRoom = document.getElementById("roomSelect").value;
    var base_url = '<?= base_url('seat/monitoring'); ?>';

    switch (selectedRoom) {
      case 'GF':
        window.location.href = '<?= base_url('seat/live?room=GF&submit=Show'); ?>';
        break;
      case '2F':
        window.location.href = '<?= base_url('seat/live?room=2F&submit=Show'); ?>';
        break;
      case '3F':
        window.location.href = '<?= base_url('seat/live?room=3F&submit=Show'); ?>';
        break;
      case '4F':
        window.location.href = '<?= base_url('seat/live?room=4F&submit=Show'); ?>';
        break;
      case '5F':
        window.location.href = '<?= base_url('seat/live?room=5F&submit=Show'); ?>';
        break;
      case '6F':
        window.location.href = '<?= base_url('seat/live?room=6F&submit=Show'); ?>';
        break;
      case '7F':
        window.location.href = '<?= base_url('seat/live?room=7F&submit=Show'); ?>';
        break;
      // Add more cases for each option
      default:
        window.location.href = base_url;
        break;
    }
  }
</script> -->
