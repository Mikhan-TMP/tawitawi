<style>
  /* Basic reset and styling */

/* Tooltip container */
.tooltip-container {
  position: relative;
  display: inline-block;
}

/* Icon styling */
.ex-icon {
  width: 50px;
  height: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition:
    transform 0.3s ease,
    filter 0.3s ease;
}

/* SVG Animation: Rotate and scale effect */
.ex-icon i {
  transition: transform 0.5s ease-in-out;
}

.ex-icon:hover i{
  transform: rotate(360deg) scale(1.2);
}


/* Tooltip Arrow */
.tooltip::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #333 transparent transparent transparent;
}

/* Show tooltip on hover */
.tooltip-container:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
}

@keyframes bounce {
  0%,
  20%,
  50%,
  80%,
  100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-30px);
  }
  60% {
    transform: translateY(-15px);
  }
}

.tooltip-container:hover .tooltip {
  visibility: visible;
  opacity: 1;
  transform: translateY(0);
  animation: bounce 0.6s ease;
}

</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Library Area Information</h1>
    <div class="d-flex align-items-center mb-4 w-100 " style="cursor: pointer">
        <a href="<?= base_url('master/a_area'); ?>" class="btn btn-icon-split shadow-sm text-light" style="background: linear-gradient(180deg, #031084, #000748);  ">
            <span class="icon text-white-600">
                <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add Area</span>
        </a>
        <!-- Add a ! icon -->
        <div class="tooltip-container">
          <div class="ex-icon">
            <i class="fas fa-exclamation-circle text-danger" style="font-size: 1.5rem; margin-left: 1rem; cursor: pointer;" data-toggle="modal" data-target="#infoModal"> </i>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Library Area Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>This page is used to manage the library areas.</p>
                <p>Adding a new area will automatically create a booking record for the area.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- Data Table Department-->
    <div class="card shadow mb-4" style="border-radius:15px;">
        <div class="card-header py-3 d-flex" 
              style="justify-content: space-between;
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
                background: linear-gradient(180deg, #031084, #000748); 
                align-item:center;">
            <h6 class="mb-0 text-light" style="font-size:1.5rem; font-family: 'Inter', sans-serif;">Area List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead style="color: #272727; font-weight: 500;">
                        <tr>
                            <th>ID</th>
                            <th>Floor</th>
                            <th>Area Name</th>
                            <th>Seats</th>
                            <th>Availability</th>
                            <th>Minimum Hour/s</th>
                            <th>Maximum Hour/s</th>
                            <th>Action</th>
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
                            <td class="align-middle">
                            <?php  
                              if($dpt['opentime'] != "00:00:00")
                                  echo date('h:i A', strtotime($dpt['opentime'])).'~'.date('h:i A', strtotime($dpt['closetime'])); 
                              else
                                  echo "00:00:00";                        
                            ?>
                            </td>
                            <td class="align-middle"><?= $dpt['min_slot']; ?></td>
                            <td class="align-middle"><?= $dpt['max_slot']; ?></td>
                            <td class="align-middle text-center">
                                <a href="<?= base_url('master/e_area/') . $dpt['id'] ?>" class=""
                                    style="text-decoration:none">
                                    <span class="text-dark" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </span>
                                </a>&nbsp &nbsp
                                <!-- <a href="#" class="" style="text-decoration:none" onclick="event.preventDefault(); Swal.fire({
                                    title: 'Are you sure?',
                                    text: '<?= ($dpt['availability'] == 0 ? 'This action will unlock the area.' : 'This action will lock the area.') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '<?= ($dpt['availability'] == 0 ? 'Yes, open it!' : 'Yes, lock it!') ?>'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                      window.location.href = '<?= base_url('master/lockArea?area_id=') . $dpt['id']?>';
                                    }
                                  });">
                                    <span
                                        class="icon <?= ($dpt['availability'] == 0 ? 'text-danger' : 'text-success') ?>"
                                        title="<?= ($dpt['availability'] == 0 ? 'Locked' : 'Open') ?>">
                                        <i
                                            class="fas <?= ($dpt['availability'] == 0 ? 'fa-lock' : 'fa-unlock') ?>"></i>
                                    </span>
                                </a>&nbsp &nbsp -->
                                <a href="#" class="" onclick="event.preventDefault(); Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'Deleted room will be lost forever. Additionally, existing bookings and past bookings may have an error. Please refrain from deleting the area unless absolutely necessary.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '<?= base_url('master/d_area/') . $dpt['id'] ?>';
                                    }
                                });">
                                    <span class="icon text-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </a>
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
<!-- End of Main Content -->

<!-- ALERT MESSAGES -->
<?php 
//get the toasterhelper
  $this->load->helper('toast');

  if ($this->session->flashdata('area_scs')) {
    echo getAlertMessages('success', $this->session->flashdata('area_scs'));
  }
  if ($this->session->flashdata('area_fail')) {
    echo getAlertMessages('error', $this->session->flashdata('area_fail'));
  }
  if ($this->session->flashdata('area_neutral')) {
    echo getAlertMessages('info', $this->session->flashdata('area_neutral'));
  }
  if ($this->session->flashdata('success')) {
    echo getAlertMessages('success', $this->session->flashdata('success'));
  }
  if ($this->session->flashdata('warning')) {
    echo getAlertMessages('warning', $this->session->flashdata('warning'));
  }
  //unset it after use
  $this->session->unset_userdata('area_scs');
  $this->session->unset_userdata('area_fail');
  $this->session->unset_userdata('area_neutral');
  $this->session->unset_userdata('success');
  $this->session->unset_userdata('warning');
?>