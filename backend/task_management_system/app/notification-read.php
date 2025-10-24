<?php
session_start();

if (isset($_SESSION['role'], $_SESSION['id'])) {
    include "../DB_connection.php";
    include "Model/Notification.php";

    $notifications = get_all_my_notifications($conn, $_SESSION['id']);
    $unread_count = 0;

    if (is_array($notifications) && count($notifications) > 0) {
        // Count unread notifications
        foreach ($notifications as $notification) {
            if (isset($notification['is_read']) && $notification['is_read'] == 0) {
                $unread_count++;
            }
        }

        // Notification icon with badge
        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">';
        echo '<i class="fas fa-bell fa-lg text-white"></i>';
        if ($unread_count > 0) {
            echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'
               . htmlspecialchars($unread_count) . '</span>';
        }
        echo '</a>';
        echo '<ul class="dropdown-menu dropdown-menu-end">';

        // Notification items
        foreach ($notifications as $notification) {
            $type = htmlspecialchars($notification['type']);
            $message = htmlspecialchars($notification['message']);
            $date = htmlspecialchars($notification['date']);
            $id = intval($notification['id']);

            echo '<li><a class="dropdown-item" href="app/notification-read.php?notification_id=' . $id . '">';
            echo ($notification['is_read'] == 0) ? "<strong>$type:</strong> " : "$type: ";
            echo "$message <small class=\"text-muted\">$date</small>";
            echo '</a></li>';
        }

        echo '</ul></li>';
    } else {
        // No notifications
        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">';
        echo '<i class="fas fa-bell fa-lg text-white"></i>';
        echo '</a>';
        echo '<ul class="dropdown-menu dropdown-menu-end">';
        echo '<li><a class="dropdown-item" href="#">You have zero notifications</a></li>';
        echo '</ul></li>';
    }
} else {
    echo '';
}
?>