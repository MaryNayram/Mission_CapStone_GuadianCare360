<?php
session_start();

if (isset($_SESSION['role'], $_SESSION['id'])) {
    include "../DB_connection.php";
    include "Model/Notification.php";
    include "Model/notification_all.php";

    $user_id = $_SESSION['id'];
    $role = $_SESSION['role'];

    // Personal notifications
    $personal_notifications = get_all_my_notifications($conn, $user_id) ?: [];

    // Broadcast notifications
    $broadcast_notifications = get_broadcast_notifications($conn, $role) ?: [];

    // Filter out broadcasts already read by this user
    $unread_broadcasts = [];
    foreach ($broadcast_notifications as $b) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM notification_read WHERE user_id=? AND broadcast_id=?");
        $stmt->execute([$user_id, $b['id']]);
        if ($stmt->fetchColumn() == 0) {
            $unread_broadcasts[] = $b;
        }
    }

    $notifications = array_merge($personal_notifications, $broadcast_notifications);
    $unread_count = 0;

    // Count unread personal notifications
    foreach ($personal_notifications as $n) {
        if (isset($n['is_read']) && $n['is_read'] == 0) $unread_count++;
    }

    // Count unread broadcasts
    $unread_count += count($unread_broadcasts);

    // Dropdown menu
    echo '<li class="nav-item dropdown">';
    echo '<a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">';
    echo '<i class="fas fa-bell fa-lg text-white"></i>';
    if ($unread_count > 0) {
        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'
             . htmlspecialchars($unread_count) . '</span>';
    }
    echo '</a>';
    echo '<ul class="dropdown-menu dropdown-menu-end">';

    if (!empty($notifications)) {
        foreach ($notifications as $notification) {
            $id = intval($notification['id']);
            $type = htmlspecialchars($notification['type']);
            $message = htmlspecialchars($notification['message']);
            $date = date("M j, Y g:i A", strtotime($notification['date']));

            $is_unread = isset($notification['is_read']) ? $notification['is_read'] == 0 : in_array($notification, $unread_broadcasts);

            echo '<li><a class="dropdown-item" href="app/notification-read.php?notification_id=' . $id . '">';
            echo $is_unread ? "<strong>$type:</strong> " : "$type: ";
            echo "$message <small class=\"text-muted\">$date</small>";
            echo '</a></li>';
        }
    } else {
        echo '<li><a class="dropdown-item" href="#">You have zero notifications</a></li>';
    }

    echo '</ul></li>';
}
?>
