<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "../DB_connection.php";
    include "Model/Notification.php";

    $notifications = get_all_my_notifications($conn, $_SESSION['id']);
    $unread_count = 0;

    if (is_array($notifications) && count($notifications) > 0) {
        // Count unread notifications
        foreach ($notifications as $notification) {
            if ($notification['is_read'] == 0) {
                $unread_count++;
            }
        }

        // Show notification icon with unread count
        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">';
        echo '<i class="fas fa-bell fa-lg text-white"></i>';
        if ($unread_count > 0) {
            echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'
               . $unread_count . '</span>';
        }
        echo '</a>';
        echo '<ul class="dropdown-menu dropdown-menu-end">';

        foreach ($notifications as $notification) {
            echo '<li><a class="dropdown-item" href="app/notification-read.php?notification_id=' . $notification['id'] . '">';
            if ($notification['is_read'] == 0) {
                echo '<strong>' . htmlspecialchars($notification['type']) . ':</strong> ';
            } else {
                echo htmlspecialchars($notification['type']) . ': ';
            }
            echo htmlspecialchars($notification['message']) . ' <small class="text-muted">' . $notification['date'] . '</small>';
            echo '</a></li>';
        }

        echo '</ul></li>';
    } else {
        // No notifications
        echo '<li><a class="dropdown-item" href="#">You have zero notifications</a></li>';
    }
} else {
    echo '';
}
?>