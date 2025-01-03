
<style>
.nav-item {
    transition: background-color .5s ease, transform .5s ease;
}

.nav-item .nav-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 5px;
    border-radius: 10px;
    color: #333; /* Default text color */
    transition: color .5s ease;
}

/* Hover effect */
.nav-item:not(.active) .nav-link:hover {
    /* background-color: #007bff; Change background color on hover */
    background: linear-gradient(180deg, rgba(3,64,132,0.6474964985994398) 0%, rgba(0,7,72,0.7399334733893557) 100%);
    color: #fff; /* Change text color on hover */
    transform: translateY(-3px); /* Slight "lift" effect */
}

/* Styling for active state */
.nav-item.active .nav-link {
    background: linear-gradient(180deg, #031084, #000748);
    color: #fff; /* Active text color */
    transform: none; /* No lift effect */
}

.nav-item .nav-link i {
    transition: background-color .5s ease, color .5s ease;
}

/* Icon styling on hover */
.nav-item:not(.active) .nav-link:hover i {
    /* background: linear-gradient(180deg, #031084, #000748); */
    color: #fff; /* Change icon color on hover */
}

/* Icon styling for active state */
.nav-item.active .nav-link i {
    /* background-color: #003d7a; Active icon background color */
    color: #fff; /* Active icon color */
}

</style>
<!-- <?= $displayedTitles = [];?> -->
<!-- Sidebar -->
    <!-- <ul class="navbar-nav sidebar sidebar-dark accordion"  -->
    <ul class="navbar-nav sidebar"id="accordionSidebar" style="background-color: white; box-shadow: -12px 0px 17px 2px #000000;z-index: 1;">

      <!-- Sidebar - Brand -->
    <div class="sidebar-brand align-items-center mt-1">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" style="flex-direction: column;" href="">
        <img  class="center img-fluid" src="<?= base_url('images/') . 'LogoMSU.png'; ?> " width="48px">
        <p class="text-center mt-2 mb-2 ml-1" style="font-weight: bold; color: #2D3748;">MSU-TCTO</p>
      </a>
    </div>
      <div class="mt-4">
          <hr id="sidebarDivider" class="sidebar-divider" style="border: 0; height: 1px; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(228,214,214,1) 30%, rgba(199,193,193,1) 49%, rgba(228,214,214,1) 70%, rgba(255,255,255,1) 100%); margin: 1rem 0; transition: height 0.3s ease-in-out;">
          <!-- <hr class="sidebar-divider collapse" id="sidebarDivider" style="border: 0; height: 1px; background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(228,214,214,1) 30%, rgba(199,193,193,1) 49%, rgba(228,214,214,1) 70%, rgba(255,255,255,1) 100%); margin: 1rem 0;"> -->
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

        $permission= json_decode($user['permision'], true); 

        // Define an array of titles to skip
        $skipTitles = ['Room Reservation','Attend Room','Room Status','Room','Reservation Seat', 'Reservation Room', 'Live Monitoring', 'Seat Reservation'];
        // $skipTitles = [''];
        // Initialize an array to keep track of already displayed submenu titles
        

        foreach ($menu as $menus): ?>

            <!-- <div class="ml-2" style="font-weight: bold; color: #2D3748; font-size:10px; text-transform: uppercase;">
                <?= htmlspecialchars($menus['menu'], ENT_QUOTES, 'UTF-8'); ?>
            </div> -->
        
            <?php
            // Prepare the query for submenus
            $subMenuQuery = "SELECT * FROM `user_submenu` WHERE `menu_id` = ? AND `is_active` = 1";
            // $subMenuQuery =  "SELECT * FROM `user_submenu` WHERE 1 ";
            $subMenus = $this->db->query($subMenuQuery, [$menus['id']])->result_array();
            // $subMenus = $this->db->query($subMenuQuery)->result_array();
        
            // Loop through the submenus
            foreach ($subMenus as $submenu):
              // Skip submenu titles that are in the skip list or have been displayed already
              if (in_array($submenu['title'], $skipTitles) || in_array($submenu['title'], $displayedTitles)) {
                  continue;
              }
          
              // Role-based access control
              if ($role_id == 1 || ($role_id == 2 && isset($permission[$submenu['title']]) && $permission[$submenu['title']] == 1)):
                  // Replace "Attend Seat" with "Seat Reservation"
                  $submenuTitle = ($submenu['title'] === 'Attend Seat') ? 'Seat Reservation' : $submenu['title'];
          
                  // Add the submenu title to the displayed list
                  $displayedTitles[] = $submenu['title'];
          ?>
              <li class="nav-item mb-3 p-0<?= ($title == $submenu['title']) ? ' active' : ''; ?>" >
                  <a class="nav-link" href="<?= base_url($submenu['url']); ?>" >
                      <i class="<?= $submenu['icon']; ?>" style="padding: 10px; width: 2.2rem; border-radius: 10px;"></i>
                      <span><?= htmlspecialchars($submenuTitle, ENT_QUOTES, 'UTF-8'); ?></span>
                  </a>
              </li>
          <?php endif; ?>
          <?php endforeach; ?>
          
        <?php endforeach; ?>
        
        <!-- display the current display titles -->

        
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="ml-2">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </div>
    </ul>
    <!-- End of Sidebar -->

  <script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        var sidebarDivider = document.getElementById('sidebarDivider');
        sidebarDivider.style.height = sidebarDivider.style.height === '0px' ? '1px' : '0px'; // Toggle height of the <hr>
    });
  </script>