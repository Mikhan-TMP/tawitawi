<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Library Area Information</h1>
    <div class="">
        <a href="<?= base_url('master/a_area'); ?>" class="btn btn-icon-split mb-4 shadow-sm text-light" style="background: linear-gradient(180deg, #031084, #000748);  ">
            <span class="icon text-white-600">
                <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add Area</span>
        </a>
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
                                <a href="<?= base_url('master/d_area/') . $dpt['id'] ?>" class=""
                                    onclick="return confirm('Deleted room will lost forever. Still want to delete?')">
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