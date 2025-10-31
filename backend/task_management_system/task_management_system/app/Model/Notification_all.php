<?php
// app/Model/notification_all.php

/**
 * Fetch all active broadcast notifications for the current user.
 *
 * @param PDO $conn
 * @param string $role
 * @return array
 */
function get_broadcast_notifications($conn, $role = 'employee') {
    if (!isset($_SESSION['id'])) return [];

    $sql = "SELECT n.*, IFNULL(r.read_at, '') AS read_at
            FROM notification_all n
            LEFT JOIN notification_read r 
                ON n.id = r.broadcast_id AND r.user_id = ?
            WHERE n.target_role = ? AND n.is_active = TRUE
            ORDER BY n.date DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['id'], $role]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Send a broadcast notification to all users of a role.
 *
 * @param PDO $conn
 * @param string $message
 * @param string $type
 * @param string $role
 * @param int|null $created_by
 * @return bool
 */
function send_broadcast_notification($conn, $message, $type = 'general', $role = 'employee', $created_by = null) {
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO notification_all (message, type, date, target_role, created_by, is_active)
            VALUES (?, ?, ?, ?, ?, TRUE)";
    
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$message, $type, $date, $role, $created_by]);
}

/**
 * Count users who have read a broadcast.
 *
 * @param PDO $conn
 * @param int $broadcast_id
 * @return int
 */
function get_broadcast_read_count($conn, $broadcast_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM notification_read WHERE broadcast_id = ?");
    $stmt->execute([$broadcast_id]);
    return (int) $stmt->fetchColumn();
}

/**
 * Count total users by role.
 *
 * @param PDO $conn
 * @param string $role
 * @return int
 */
function get_total_users_by_role($conn, $role) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
    $stmt->execute([$role]);
    return (int) $stmt->fetchColumn();
}

/**
 * Mark a broadcast as read by a user.
 *
 * @param PDO $conn
 * @param int $broadcast_id
 * @param int $user_id
 * @return bool
 */
function mark_broadcast_as_read($conn, $broadcast_id, $user_id) {
    $sql = "INSERT IGNORE INTO notification_read (broadcast_id, user_id, read_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$broadcast_id, $user_id]);
}
