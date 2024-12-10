
 <!-- Sweet Alert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
          <div class="">
              <a href="<?= base_url('master/a_room'); ?>"
                class="btn btn-icon-split mb-4 shadow-sm text-light" 
                style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);">
                <span class="icon text-white-600">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add Room</span>
              </a>
          </div>
          <div class="">
            <?= $this->session->flashdata('message'); ?>
          </div>
          <!-- <?php if ($this->session->flashdata('message')): ?>
              <script>
                Swal.fire({
                  position: "top-end",
                  // icon: "",
                  title: '<?=$this->session->flashdata('message');?>',
                  showConfirmButton: false,
                  timer: 1500
                });
              </script>
          <?php endif; ?>
          <?php if ($this->session->flashdata('success_message')): ?>
              <script>
                Swal.fire({
                  position: "top-end",
                  // icon: "",
                  title: '<?=$this->session->flashdata('success_message');?>',
                  showConfirmButton: false,
                  timer: 1500
                });
              </script>
          <?php endif; ?> -->
          <!-- Data Table Department-->
          <div class="card shadow mb-4" 
                style="border-radius:15px;">
            <div class="card-header py-3 d-flex" 
                  style="justify-content: space-between;
                        border-top-left-radius: 15px;
                        border-top-right-radius: 15px;
                        background: linear-gradient(180deg, #0F25EE, #1F2DB0);
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
        <!-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
