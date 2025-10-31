<?php
session_start();
if (!isset($_SESSION['id'], $_SESSION['role'])) exit;

include "../DB_connection.php";
include "Model/Notification.php";
include "Model/notification_all.php";

/**
 * Count all unread notifications for a user (personal + broadcast)
 */
function count_combined_unread($conn, $user_id, $role) {
    $count = 0;

    // Personal unread
    $personal_unread = count_notification($conn, $user_id);
    $count += $personal_unread;

    // Broadcast unread
    $broadcasts = get_broadcast_notifications($conn, $role);
    foreach ($broadcasts as $b) {
        if (empty($b['read'])) {
            $count++;
        }
    }

    return $count;
}

// Get unread count
$unread_count = count_combined_unread($conn, $_SESSION['id'], $_SESSION['role']);

// Output badge if there are unread notifications
if ($unread_count > 0) {
    echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'
       . htmlspecialchars($unread_count) .
       '</span>';
}
