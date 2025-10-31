<?php
session_start();
if (!isset($_SESSION['role'], $_SESSION['id'])) exit;

include "../DB_connection.php";
include "Model/Notification.php";
include "Model/notification_all.php";

// Fetch personal notifications
$personal = get_all_my_notifications($conn, $_SESSION['id']);

// Fetch broadcast notifications
$broadcast = get_broadcast_notifications($conn, $_SESSION['role']);

// Merge all notifications
$notifications = array_merge(
    is_array($personal) ? $personal : [],
    is_array($broadcast) ? $broadcast : []
);

// Sort by date descending
usort($notifications, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));

// Count unread notifications
$unread_count = 0;
foreach ($notifications as $n) {
    $is_unread = (isset($n['is_read']) && $n['is_read'] == 0) || (isset($n['read_at']) && $n['read_at'] == '');
    if ($is_unread) $unread_count++;
}

// Render dropdown
echo '<li class="nav-item dropdown">';
echo '<a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">';
echo '<i class="fas fa-bell fa-lg text-white"></i>';
if ($unread_count > 0) {
    echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $unread_count . '</span>';
}
echo '</a>';

echo '<ul class="dropdown-menu dropdown-menu-end">';

if (!empty($notifications)) {
    foreach ($notifications as $n) {
        $id = intval($n['id'] ?? 0);
        $type = htmlspecialchars($n['type'] ?? '');
        $message = htmlspecialchars($n['message'] ?? '');
        $date = htmlspecialchars($n['date'] ?? '');
        $is_unread = (isset($n['is_read']) && $n['is_read'] == 0) || (isset($n['read_at']) && $n['read_at'] == '');

        echo '<li><a class="dropdown-item" href="app/notification-read.php?notification_id=' . $id . '">';
        echo $is_unread ? "<strong>$type:</strong> " : "$type: ";
        echo "$message <small class='text-muted'>$date</small></a></li>";
    }
} else {
    echo '<li><a class="dropdown-item" href="#">You have zero notifications</a></li>';
}

echo '</ul></li>';
