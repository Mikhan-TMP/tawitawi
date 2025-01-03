<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="row">
    <div class="col-lg-5">
      <?= $this->session->flashdata('message'); ?>
    </div>
  </div>

  <!-- Data Table Users-->
  <div class="col-lg-5">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Librian Access Control</h6>
    </div>   
    <div class="card-body">      
      <form action="<?= base_url('master/user_access') ?>" method="POST">
                
          <?php
          $i = 0;          
          foreach ($user_menu as $dt) : 
              ?>
            <div class="form-group">            
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <? if ($dt['permit']=='No'){ ?>
                    <input type="checkbox" class="custom-control-input" id= <?= 'access'.$dt['id'] ?> name=  <?= 'access'.$dt['id'] ?> value="OFF" onchange="toggleSwitch(this.id)" > 
                <?  } 
                else { ?>
                    <input type="checkbox" class="custom-control-input" id= <?= 'access'.$dt['id'] ?> name=  <?= 'access'.$dt['id'] ?>  value="ON" checked onchange="toggleSwitch( this.id)" >
                <? } ?> 

                <label class="custom-control-label" for= <?= 'access'.$dt['id'] ?> ><?= '('.$dt['id'].') '. $user_menu[$i]['title']; $i++; ?></label>
              </div>              
            </div>
              
            <?php endforeach; ?>            
            <div>
              <input type="submit" class="btn btn-success " name ='submit' value="Save Change">  
            </div>          
      </form>
    </div>
  </div>
</div>

<script>  
  function toggleSwitch(id) {
    console.log("Control id:", id);
    var checkbox = document.getElementById(id);
    var switchValue = checkbox.checked;
    checkbox.value = switchValue ? "ON" : "OFF";
    var readerValue = switchValue ? "Switch is ON" : "Switch is OFF";
    
    // Update the control and reader elements or perform other actions as needed
    console.log("Control Value:", checkbox.value);
    console.log("Reader Value:", readerValue);
  }
</script>