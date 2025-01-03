
 <!-- Sweet Alert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!--  -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
          <div class="">
              <a href="<?= base_url('master/a_room'); ?>"
                class="btn btn-icon-split mb-4 shadow-sm text-light" 
                style="background: linear-gradient(180deg, #BE110E, #630908);">
                <span class="icon text-white-600">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add Room</span>
              </a>
          </div>
          <!-- Data Table Department-->
          <div class="card shadow mb-4" 
                style="border-radius:15px;">
            <div class="card-header py-3 d-flex" 
                  style="justify-content: space-between;
                        border-top-left-radius: 15px;
                        border-top-right-radius: 15px;
                        background: linear-gradient(180deg, #BE110E, #630908);
            ">
              <h6 class="m-0 text-light" 
                  style="font-size:1.5rem;
                  font-family: 'Inter', sans-serif;">Room Table</h6>
                  
              <div class="row">
                <!-- <div class="col-lg-5 offset-lg-4">
                  <?= $this->session->flashdata('message'); ?>
                </div> -->
              </div>
              <!-- <div class="row"> 
                <div class="input-group rounded">
                  <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                  <span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                  </span>
                </div>
              </div> -->
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                  <thead style="color: #272727; font-weight: 500;">
                    <tr>                      
                      <th>ID</th>
                      <th>Floor</th>
                      <th>Room Name</th>
                      <th>Seats</th>
                      <th>Opening</th>
                      <th>min </th>
                      <th>max</th>                      
                      <th>Actions</th>
                    </tr>
                  </thead>
                 
                  <tbody style="color: #272727;">
                    <?php
                    $i = 1;
                    foreach ($room as $dpt) :
                    ?>
                      <tr>                        
                        <td class="align-middle"><?= $dpt['id']; ?></td>
                        <td class="align-middle"><?= $dpt['floor']; ?></td>
                        <td class="align-middle"><?= $dpt['room']; ?></td>
                        <td class="align-middle"><?= $dpt['slotnumber']; ?></td>
                        <td class="align-middle"><?php  
                        if($dpt['opentime'] != "00:00:00")
                           echo ($dpt['opentime'].'~'.$dpt['closetime']); 
                        else
                            echo "00:00:00";                        
                           ?></td>
                        <td class="align-middle"><?= $dpt['min_slot']; ?></td>
                        <td class="align-middle"><?= $dpt['max_slot']; ?></td>
                        <td class="align-middle text-center">
                          <a href="<?= base_url('master/e_room/') . $dpt['id'] ?>" class="">
                            <span class="text-dark" title="Edit">
                              <i class="fas fa-pen"></i>
                            </span>
                          </a>&nbsp &nbsp
                          <a href="<?= base_url('master/d_room/') . $dpt['id'] ?>" class="" onclick="return confirm('Deleted room will lost forever. Still want to delete?')">
                            <span class="icon text-danger" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a>
                          <!-- <a href="" class="delete-link">
                            <span class="icon text-danger" title="Delete">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                          </a> -->

                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
        </div>

        <!-- ALERT MESSAGES -->
        <!-- adding room -->
        <?php 
        //get the toasterhelper
          $this->load->helper('toast');

          if ($this->session->flashdata('room_scs')) {
           echo getAlertMessages('success', $this->session->flashdata('room_scs'));
          }
          if ($this->session->flashdata('room_fail')) {
           echo getAlertMessages('error', $this->session->flashdata('room_fail'));
          }
          
          //unset it after use
          $this->session->unset_userdata('room_scs');
          $this->session->unset_userdata('room_fail');
        ?> 

<!-- <script>
  // Attach event listener to the delete link
  document.querySelectorAll('.delete-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault(); // Prevent the default behavior (navigating to the link)

      // Show confirmation dialog using SweetAlert2
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '<?= base_url('master/d_room/') . $dpt['id'] ?>';
        }
      });
    });
  });
</script> -->