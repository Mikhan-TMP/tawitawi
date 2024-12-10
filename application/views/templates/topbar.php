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

        <!-- Sidebar Toggle (Topbar) -->

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top"
        style="border-bottom: 1px solid #00000017;">
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
        <!-- <h1 class="text-center" >Library Management System</h1> -->
        <h1 class="text-center responsive-heading">Library Reservation System</h1>

            <style>
            .responsive-heading {
                color: #2D3748;
                font-size: 2rem; /* Default font size for larger screens */
                font-weight: bold;
                text-align: center;
            }

            @media screen and (max-width: 768px) {
                /* Styles for tablets and smaller devices */
                .responsive-heading {
                font-size: 20px;
                }
            }

            @media screen and (max-width: 480px) {
                /* Styles specifically for phones */
                .responsive-heading {
                font-size: 15px;
                }
            }
            .nav-item:not(.active) .nav-link:hover {
                /* background-color: #007bff; Change background color on hover */
                background: none;
                /* color: #fff; Change text color on hover */
                transform: translateY(0px); 
            }
            </style>

        <!-- <p style="font-style: italic;"></p> -->
        

          
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto align-items-center">

            <!-- Nav Item - Alerts -->
            <div class="topbar-divider d-none d-sm-block">
                  
            </div>

            <div class="dropdown" id="notificationArea">
                <!-- Notification Icon with Badge -->
                <a class="btn position-relative mr-3" href="#" role="button" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i> <!-- Font Awesome Bell Icon -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-light" id="notificationCount">
                        0
                    </span>
                </a>
              <!-- Notification Dropdown List -->
                <ul class="dropdown-menu dropdown-menu-right cursor-pointer" style="padding: 10px; cursor: pointer;" aria-labelledby="notificationDropdown" id="notificationList">
                    <!-- Existing Notifications will be dynamically inserted here -->
                    <li class="dropdown-item text-muted ">No new notifications</li>
                </ul>
            </div>
            <li class="nav-item dropdown no-arrow" id="userDropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $account['name']; ?></span>
                    <img class="img-profile rounded-circle" src="<?= base_url('images/LogoMSU.png')?>">
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" id="userDropdownMenu">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                    </a>
                </div>
            </li>
          </ul>

        </nav>
        <!-- End of Topbar -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- pusher -->
  <!-- <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script> -->


  

<script>
function fetchUnreadNotifications() {
    $.ajax({
        url: '<?= base_url("master/getUnreadNotifications") ?>', // Your endpoint
        method: 'GET',
        success: function (response) {
            console.log("Received notifications:", response);
            const notifications = JSON.parse(response);
            updateNotificationUI(notifications);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching notifications:", error);
        }
    });
}

function updateNotificationUI(notifications) {
    const notificationList = $("#notificationList");
    const notificationCount = $("#notificationCount");

    // Clear current notifications
    notificationList.empty();

    if (notifications.length > 0) {
        notificationCount.text(notifications.length);

        // Add notifications to the list
        notifications.forEach(notification => {
            const item = `<li class="dropdown-item" data-id="${notification.id}" onclick="markNotificationAsRead(this)">${notification.message}</li>`;
            notificationList.append(item);
        });
    } else {
        notificationCount.text("0");
        notificationList.append('<li class="dropdown-item text-muted">No new notifications</li>');
    }
}

function markNotificationAsRead(element) {
    const notificationId = $(element).data("id");

    // Mark the notification as read on the server
    $.ajax({
        url: '<?= base_url("master/markAsRead") ?>', // Your markAsRead endpoint
        method: 'POST',
        data: { id: notificationId },
        success: function(response) {
            console.log("Notification marked as read:", response);
            
            // Update the notification UI
            $(element).addClass("text-muted bg-gray-200"); // Optional: Change the appearance of the notification
            $(element).off('click'); // Disable further clicking on this notification

            // Decrease the unread count
            let currentCount = parseInt(notificationCount.text());
            if (currentCount > 0) {
                notificationCount.text(currentCount - 1);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error marking notification as read:", error);
        }
    });
}
// Fetch notifications every 10 seconds
setInterval(fetchUnreadNotifications, 5000);
</script>

