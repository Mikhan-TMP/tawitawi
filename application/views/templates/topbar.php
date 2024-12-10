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
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <!-- pusher -->
  <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>


<!-- 
<script>
var baseUrl = "<?= base_url() ?>";
var notificationInterval; // Declare a variable to store the interval ID

// Start the notification polling
function startNotificationPolling() {
    notificationInterval = setInterval(fetchNotifications, 500);
}

// Stop the notification polling
function stopNotificationPolling() {
    clearInterval(notificationInterval);
}

// Fetch notifications
function fetchNotifications() {
    $.ajax({
        url: "<?= base_url('Master/getNotifications') ?>", // Fetch both read and unread notifications
        method: "GET",
        success: function(data) {
            let notifications = JSON.parse(data);
            let unreadCount = notifications.filter(notification => notification.status === 'unread').length;

            // Update notification count badge
            $("#notificationCount").text(unreadCount);

            // Update notification list
            let listHtml = "";
            if (notifications.length > 0) {
                notifications.forEach(notification => {
                    const notificationClass = notification.status === 'unread' ? 'unread' : 'read'; // Set class based on status
                    listHtml += `
                        <li class="dropdown-item ${notificationClass}" data-id="${notification.id}" data-url="<?= base_url() ?>${notification.url}">
                            ${notification.message}
                            <small class="text-muted d-block">${notification.created_at}</small>
                        </li>
                    `;
                });
            } else {
                listHtml = '<li class="dropdown-item text-muted">No new notifications</li>';
            }

            $("#notificationList").html(listHtml);
        },
        error: function() {
            console.error("Failed to fetch notifications.");
        }
    });
}

// Mark notification as read and change appearance when clicked
$(document).on("click", ".dropdown-item", function() {
    var notificationId = $(this).data("id");
    var notificationUrl = $(this).data("url");

    // Mark as read and update appearance
    markAsRead(notificationId, $(this));

    // Redirect to the notification URL
    window.location.href = notificationUrl;
});

// Mark notification as read
function markAsRead(notificationId, notificationElement) {
    $.ajax({
        url: "<?= base_url('Master/markAsRead') ?>",
        method: "POST",
        data: {id: notificationId},
        success: function(data) {
            let response = JSON.parse(data);
            if (response.success) {
                notificationElement.removeClass("unread").addClass("read");
            }
        },
        error: function() {
            console.error("Failed to mark notification as read.");
        }
    });
}
</script> -->

