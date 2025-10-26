<?php
// Include database connection
include 'connect.php';

// Expire the tutor_id cookie
setcookie('tutor_id', '', time() - 3600, '/');

// Optional: destroy session if used
// session_start();
// session_unset();
// session_destroy();

// Redirect to login page
header('Location: ../admin/login.php');
exit;
?>