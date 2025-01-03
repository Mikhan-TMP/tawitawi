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
            #userDropdown:hover {
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


            <li class="nav-item dropdown no-arrow" id="userDropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $account['name']; ?></span>
                    <?php if (!empty($account['image'])): ?>
                        <img class="img-profile rounded-circle" src="data:image/jpeg;base64,<?= base64_encode($account['image']); ?>">
                    <?php else: ?>
                        <img class="img-profile rounded-circle" src="<?= base_url('images/default-avatar.jpg') ?>">
                    <?php endif; ?>
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


  

<!-- <script>
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

// fetchUnreadNotifications();

function updateNotificationUI(notifications) {
    const notificationList = $("#notificationList");
    const notificationCount = $("#notificationCount");
    const noNotificationsMessage = $("#noNotificationsMessage");
    const markAllReadBtn = $("#markAllReadBtn");
    const goToNotificationsBtn = $("#goToNotifications"); // Reference to "Go to Notifications" button
    const divider = $("#divider");

    // Clear existing notifications (but keep the "Mark All as Read" button, "Go to Notifications" button, and the "No new notifications" message)
    notificationList.find('li:not(#markAllReadBtn, #goToNotifications, #noNotificationsMessage)').remove();

    if (notifications.length > 0) {
        notificationCount.text(notifications.length);
        noNotificationsMessage.hide(); // Hide "No new notifications" message
        markAllReadBtn.show(); // Show the "Mark All as Read" button
        goToNotificationsBtn.show(); // Show the "Go to Notifications" button
        divider.show(); // Ensure the divider is visible when notifications exist

        // Add notifications to the list
        notifications.forEach(notification => {
            const item = `<li class="dropdown-item ${notification.status === 'read' ? 'text-muted bg-gray-200' : ''}" data-id="${notification.id}" onclick="markNotificationAsRead(this)">${notification.message}</li>`;
            notificationList.append(item);
        });
    } else {
        notificationCount.text("0");
        noNotificationsMessage.show(); // Show "No new notifications" if there are no unread notifications
        markAllReadBtn.hide(); // Hide "Mark All as Read" button
        goToNotificationsBtn.hide(); // Hide "Go to Notifications" button
        divider.hide(); // Hide the divider if there are no notifications
    }

    // Bind click event for "Mark All as Read" button
    markAllReadBtn.on("click", function() {
        markAllAsRead();
    });
}

function markAllAsRead() {
    $.ajax({
        url: '<?= base_url("master/markAllAsRead") ?>', // Your markAllAsRead endpoint
        method: 'POST',
        success: function(response) {
            console.log("All notifications marked as read:", response);

            // Hide the "Mark All as Read" button
            $("#markAllReadBtn").hide();

            // Update the UI to mark all notifications as read
            $(".dropdown-item").each(function() {
                $(this).addClass("text-muted bg-gray-200");
                $(this).off('click'); // Disable further clicks
            });

            // Update the notification count to 0
            $("#notificationCount").text("0");
        },
        error: function(xhr, status, error) {
            console.error("Error marking all notifications as read:", error);
        }
    });
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

// function markAllAsRead() {
//     $.ajax({
//         url: '<?= base_url("master/markAllAsRead") ?>', // Your markAllAsRead endpoint
//         method: 'POST',
//         success: function(response) {
//             console.log("All notifications marked as read:", response);

//             // Hide the "Mark All as Read" button
//             $("#markAllReadBtn").hide();

//             // Update the UI to mark all notifications as read
//             $(".dropdown-item").each(function() {
//                 $(this).addClass("text-muted bg-gray-200");
//                 $(this).off('click'); // Disable further clicks
//             });

//             // Update the notification count to 0
//             $("#notificationCount").text("0");
//         },
//         error: function(xhr, status, error) {
//             console.error("Error marking all notifications as read:", error);
//         }
//     });
// }
// Fetch notifications every 10 seconds
setInterval(fetchUnreadNotifications, 5000);
</script>
<script>
    $("#markAllReadBtn").on("click", function() {
    markAllAsRead();
});
</script> -->

