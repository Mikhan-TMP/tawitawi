<link href='https://fonts.googleapis.com/css?family=Alfa Slab One' rel='stylesheet'>
<!-- style>
body {
    
    font-family: 'Work Sans';font-size: 22px;
}
</style -->

<!-- Content Wrapper -->
    
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top"
        style="border-bottom: 1px solid #00000017;">
        <!-- <h1 class="text-center" >Library Management System</h1> -->
        <!-- <div id="constructionModal" style="
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.8);
              z-index: 1000;
              display: flex;
              justify-content: center;
              align-items: center;
              color: white;
              text-align: center;
              flex-direction: column;
          ">
              <h1 style="margin: 0; font-size: 2rem;">🚧 Page Under Construction 🚧</h1>
              <p style="margin-top: 10px; font-size: 1.2rem;">We're working hard to get things ready. Please check back later!</p>
          </div> -->
        <h1 class="text-center" style="
          color: #2D3748; 
          font-size: 2rem;
          font-weight: bold;
          " >Library Management System</h1>
        <!-- <p style="font-style: italic;"></p> -->
        
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <div class="topbar-divider d-none d-sm-block">
                  
            </div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $account['name']; ?></span>
                <!-- <img class="img-profile rounded-circle" src="<?= base_url('images/pp/') . $account['image']; ?>"> -->
                <img class="img-profile rounded-circle" src="<?= base_url('images/logoMSU.png')?>">
              </a>
              <!-- settings logo -->
                <!-- <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> -->
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>


          </ul>

        </nav>
        <!-- End of Topbar -->