        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
          <div class="">
                  <a href="<?= base_url('master/a_area'); ?>"
                    class="btn btn-icon-split mb-4 shadow-sm text-light" 
                    style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);">
                    <span class="icon text-white-600">
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <span class="text" style="color:#272727; color: white; font-weight: 500; text-transform: Uppercase;">Add Area</span>
                  </a>
          </div>
          <div class="">
            <?= $this->session->flashdata('message'); ?>
          </div>
          <!-- Data Table Department-->
          <div class="card shadow mb-4" 
                style="border-radius:15px;">
                <div class="card-header py-3 d-flex" 
                  style="justify-content: space-between;
                        border-top-left-radius: 15px;
                        border-top-right-radius: 15px;
                        background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                        align-item:center;
                ">
              <h6 class="mb-0 text-light" 
                  style="font-size:1.5rem;
                  font-family: 'Inter', sans-serif;">Area List</h6>
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
                          <a href="<?= base_url('master/e_area/') . $dpt['id'] ?>" class="">
                          <span class="text-dark" title="Edit">
                            <i class="fas fa-pen"></i>
                            </span>
                          </a>&nbsp &nbsp
                          <a href="<?= base_url('master/d_area/') . $dpt['id'] ?>" class="" onclick="return confirm('Deleted room will lost forever. Still want to delete?')">
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