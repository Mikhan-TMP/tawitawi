        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Edit Librarian</h1>

          <a href="<?= base_url('master/users'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <form action="<?= base_url('master/edit_user_access') ?>" method="POST" class="col-lg-12 p-0 mb-5">
            <div class="row">
              <div class="col-lg-6 m-auto">
                <div class="card">          
                  <h3 class="mb-0 text-left text-light" 
                    style="background: linear-gradient(180deg, #031084, #000748); 
                    border-top-left-radius:15px;
                    border-top-right-radius:15px;
                    padding: 1.5rem;
                    font-size: 1.5rem;">
                    Librarian Master Data
                  </h3> 
                  <div class="card-body d-flex flex-wrap p-4">                
                    <div class="col-lg-6" style=" border-right: 1px solid #d1d3e2;">
                      <div class="form-group">
                        <input type="hidden"  class="form-control form-control-lg" name="u_id" value="<?= $users['id']; ?> ">
                          <label for="u_username"  class="text-dark" style="font-weight: bold;">Username</label>
                          <input type="text"  class="form-control form-control-lg" name="u_username" value="<?= $users['username']; ?>"
                          style="border-radius:15px; font-size: 1rem; padding: 25px;">
                      </div>
                      <div class="form-group" style="    
                                        display: flex;
                                        flex-direction: column;
                                        /* border-color: blue;">
                        <label for="u_floor" class="text-dark" style="font-weight: bold;">Floor</label>
                        <!-- <input type="text"  class="form-control form-control-lg" name="u_floor" value="<?= $users['floor']; ?>"> -->
                        <select class="" name="u_floor" id="u_floor"
                          style="   border-radius: 15px;
                                    font-size: 1rem;
                                    padding: 15px;
                                    /* background-color: #fff; */
                                    color: #6e707e;
                                    /* border-color: #a5a8bc; */
                                    border: 1px solid #d1d3e2;">
                          <option disabled>Select Floor</option>
                          <option value="GF" <?= ($users['floor'] == 'GF') ? 'selected' : ''; ?>>Ground Floor</option>
                          <option value="2F" <?= ($users['floor'] == '2F') ? 'selected' : ''; ?>>2nd Floor</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="u_fname" class="text-dark" style="font-weight: bold;">First name</label>
                        <input type="text" minlength="3" maxlength="30" class="form-control form-control-lg" name="u_fname" value="<?= $users['fname']; ?>"
                        style="border-radius:15px; font-size: 1rem; padding: 25px;">
                      </div>
                      <div class="form-group">
                        <label for="u_lname" class="text-dark" style="font-weight: bold;">Last Name</label>
                        <input type="text" minlength="3" maxlength="30"  class="form-control form-control-lg" name="u_lname" value="<?= $users['lname']; ?>"
                        style="border-radius:15px; font-size: 1rem; padding: 25px;">
                      </div>
                      <div class="form-group">
                        <label for="u_email" class="text-dark" style="font-weight: bold;">Email</label>
                        <input type="text" required  class="form-control form-control-lg" name="u_email" value="<?= $users['email']; ?>"
                        style="border-radius:15px; font-size: 1rem; padding: 25px;">
                      </div>
                      <!-- <div class="form-group">
                        <label for="password" class="text-dark" style="font-weight: bold;">Reset Key-Password</label>
                        <input type="password" class="form-control form-control-lg" name="password" id="password" >
                        <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                      </div> --> 
                    </div>                                   
                    <div class="col-lg-6" style="border-left: 1px solid #d1d3e2;">
                      <label class="text-dark" style="font-weight: bold;">Permissions</label>
                      <?php
                        $i = 0; 
                        $permission = json_decode($users['permision'], true);
                        // print_r($permission);
                        $skipTitles = ['Room Reservation', 'Attend Room', 'Room Status', 'Room', 'Reservation Seat', 'Reservation Room', 'Live Monitoring', 'Seat Reservation'];
                        
                        foreach ($user_menu as $dt) :
                            $title = $dt['title'];
                            
                            // Skip rendering if the title is in $skipTitles
                            if (in_array($title, $skipTitles)) {
                                continue;
                            }
                        ?>
                            <div class="form-group">            
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <?php if (!empty($permission) && isset($permission[$title]) && $permission[$title] == 1) : ?>
                                    <input type="checkbox" class="custom-control-input" id=<?= 'access' . $dt['id'] ?> name=<?= 'access' . $dt['id'] ?> value="ON" onchange="toggleSwitch(this.id)" checked>
                                <?php else : ?>
                                    <input type="checkbox" class="custom-control-input" id=<?= 'access' . $dt['id'] ?> name=<?= 'access' . $dt['id'] ?> value="OFF" onchange="toggleSwitch(this.id)">
                                <?php endif; ?>
                                    <label class="custom-control-label" for=<?= 'access' . $dt['id'] ?>><?= '(' . $dt['id'] . ') ' . $title; ?></label>
                                </div>              
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                    <button style="background: linear-gradient(180deg, #031084, #000748);  border:none; padding: 5px; border-radius: 15px;" type="submit" class="btn btn-success btn-icon-split mt-4 w-100">
                      <span class="text">Save Changes</span>
                    </button>
                  </div>

                </div>
              </div>
            </div>
          </div>

          </form>
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

