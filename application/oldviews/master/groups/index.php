        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-gray-700">Librarian</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>                      
                      <th class=" align-middle text-center">Main Menu</th>
                      <th class=" align-middle text-center">Sub Menu</th>                                     
                      <th class=" align-middle text-center">Librarian </th>                      
                      <th class=" align-middle text-center">Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody> 
                    <?php
                    $i = 1;
                    foreach ($data as $submenu) : 
                    ?>
                      <tr>
                        <td class=" align-middle text-center col-md-1"><?php 
                             echo $menu[$submenu['menu_id']-1]['menu']; 
                              ?></td>                                                
                        <td class=" align-middle text-center"> <?= $submenu['title']; ?>  </td>                        
                        <td class=" align-middle text-center"> <?= $access['title']; ?>    </td>                        
                        <td class="text-center align-middle">
                          <a href="<?= base_url('master/e_users/') . $submenu['id'] ?>" class="btn btn-primary btn-circle ">
                            <span class="icon text-white" title="Edit">
                              <i class="fas fa-edit"></i>
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