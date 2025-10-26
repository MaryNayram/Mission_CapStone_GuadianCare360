<?php
session_start();

if (isset($_SESSION['role'], $_SESSION['id'])) {
    include "../DB_connection.php";
    include "Model/Notification.php";

    // Fetch all notifications for the current user
    $notifications = get_all_my_notifications($conn, $_SESSION['id']);
    $unread_count = 0;

    // Count unread notifications
    if (!empty($notifications) && is_array($notifications)) {
        foreach ($notifications as $notification) {
            if (isset($notification['is_read']) && $notification['is_read'] == 0) {
                $unread_count++;
            }
        }
    }

    // Output badge if there are unread notifications
    if ($unread_count > 0) {
        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'
           . htmlspecialchars($unread_count) .
           '</span>';
    }
}
?>