<!-- Sidebar -->
    <!-- <ul class="navbar-nav sidebar sidebar-dark accordion"  -->
    <ul class="navbar-nav sidebar"
    id="accordionSidebar" 
    style="background-color: white;
          width: 18rem;
          box-shadow: -12px 0px 17px 2px #000000;
          z-index: 1;
    ">

      <!-- Sidebar - Brand -->
    <div class="sidebar-brand align-items-center mt-1">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <img  class="center img-fluid" src="<?= base_url('images/') . 'logoMSU.png'; ?> " width="48px">  
          <p class=" text-center mt-2 mb-2 ml-1"
          style="font-weight: bold;
          color: #2D3748;"
          >MSU DASHBOARD</p>
      </a>
    </div>
      <!-- div>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">          
              <img src="<?= base_url() ?>/images/logo2.png" alt="" style="width: 100%;">
        </a>
      </div -->
      <div class="mt-2" style="
      padding-left: 2.5rem; 
      padding-right: 2.5rem; 
      width: 18rem;">
      <hr 
      style="
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(228,214,214,1) 30%, rgba(199,193,193,1) 49%, rgba(228,214,214,1) 70%, rgba(255,255,255,1) 100%);        margin: 1rem 0; /* Optional: adjust spacing around the divider */
      ">
      <p class="" style="
      font-weight: bold;
      color: #2D3748;
      font-size:10px;
      ">MENU</p>
      <!-- Query Menu -->
      <?php
      $role_id = $this->session->userdata('role_id');
      $username = $this->session->userdata('username');

      $queryMenu = "SELECT user_menu.id, menu
                      FROM user_menu JOIN user_access
                        ON user_menu.id = user_access.menu_id
                     WHERE user_access.role_id = $role_id
                  ORDER BY user_access.menu_id ASC";

      $menu = $this->db->query($queryMenu)->result_array();
      $user = $this->db->get_where('users', ['username' => $username])->row_array();
      //display menu
      // print_r($menu);
      $permission= json_decode($user['permision'], true); 
      foreach ($menu as $mn) :
      ?>
        <?php endforeach; ?>
        <!-- <div class="sidebar-heading">
          <?= $mn['menu']; ?>
        </div> -->
        <?php
        $menuId = $mn['id'];
/*
        $querySubMenu = "SELECT * FROM user_submenu
                                 WHERE menu_id = $menuId 
                                   AND is_active = 1";
*/
        $querySubMenu = "SELECT * FROM user_submenu WHERE 1 ";
        $subMenu = $this->db->query($querySubMenu)->result_array();
        // echo nl2br(print_r($subMenu, true));


        if($role_id == 1){

          foreach ($subMenu as $sm) :
            
            if ($title == $sm['title']) :
          ?>
              <li class="nav-item mb-3" style="
                  background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                  box-shadow: 1px 3px 4px 1px #0000004a;
                  color:white;
                  border-radius: 15px;
              ">

            <?php else : ?>
              <li class="nav-item mb-3" style="
                  box-shadow: 0px 1px 3px -1px #0000004a;
                  border-radius: 15px;
              ">
           <?php endif; ?>

              <a class="nav-link" style="
                  display: flex;
                  align-items: center;
                  gap: 15px;
                  padding: .5rem;
              "
              href="<?= base_url($sm['url']); ?>">
                <i 
                style="
                color:white; 
                background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                padding: 10px;
                width: 2.2rem;
                border-radius: 10px;
                " class="<?= $sm['icon']; ?>"></i>
                <span><?= $sm['title']; ?></span></a>
              </li>
            <?php endforeach; ?>

        <?php }
         else if ($role_id == 2) { 
          foreach ($subMenu as $sm) :             
            if ($permission[$sm['title']]== 1 ) :
          ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url($sm['url']); ?>">
                <i class="<?= $sm['icon']; ?>"></i>
                <span><?= $sm['title']; ?></span></a>
              </li>
            <?php else : ?>
              <li class="nav-item"> </li>
            <?php endif; ?>              
            <?php endforeach;
           }  ?>            

          <hr class="sidebar-divider mt-3">
      
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center ">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </div>
    </ul>
    <!-- End of Sidebar -->