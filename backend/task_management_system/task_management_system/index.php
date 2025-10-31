<?php
session_start();
if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: login.php?error=" . urlencode("First login"));
    exit();
}

include "DB_connection.php";
include "app/Model/Task.php";
include "app/Model/User.php";

// Initialize variables
$num_users = $num_task = $todaydue_task = $overdue_task = $nodeadline_task = $pending = $in_progress = $completed = $num_my_task = 0;

if ($_SESSION['role'] === "admin") {
    $num_users        = count_users($conn);
    $num_task         = count_tasks($conn);
    $todaydue_task    = count_tasks_due_today($conn);
    $overdue_task     = count_tasks_overdue($conn);
    $nodeadline_task  = count_tasks_NoDeadline($conn);
    $pending          = count_pending_tasks($conn);
    $in_progress      = count_in_progress_tasks($conn);
    $completed        = count_completed_tasks($conn);
} else {
    $num_my_task      = count_my_tasks($conn, $_SESSION['id']);
    $overdue_task     = count_my_tasks_overdue($conn, $_SESSION['id']);
    $nodeadline_task  = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
    $pending          = count_my_pending_tasks($conn, $_SESSION['id']);
    $in_progress      = count_my_in_progress_tasks($conn, $_SESSION['id']);
    $completed        = count_my_completed_tasks($conn, $_SESSION['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>GuardianCare 360 | Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
:root {
    --accent: #00f7ff;
    --card-text: #10f7d8ff;
    --panel-bg: rgba(255,255,255,0.08);
}
body {
    background: linear-gradient(135deg, #1abc9c, #0f2027);
    font-family: 'Segoe UI', sans-serif;
    color: #fff;
    min-height: 100vh;
    margin: 0;
}

/* Sidebar */
.side-bar {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100vh;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(10px);
    color: #fff;
    padding-top: 20px;
    box-shadow: 0 0 12px rgba(0,0,0,0.3);
    z-index: 999;
    transform: translateX(0);
    transition: transform 0.3s ease;
}
.side-bar.collapsed { transform: translateX(-100%); }
.side-bar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    margin: 8px 12px;
    border-radius: 8px;
    color: #e0f7fa;
    text-decoration: none;
    transition: background 0.3s ease, transform 0.2s ease;
}
.side-bar .nav-link i { font-size: 18px; color: #00d4ff; }
.side-bar .nav-link:hover { background: rgba(255,255,255,0.06); transform: translateX(5px); }

/* Header */
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: rgba(20,22,24,0.85);
    backdrop-filter: blur(12px);
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    z-index: 1000;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.u-name { font-size: 1.2rem; font-weight: 600; display:flex; align-items:center; gap:8px; }
.hover-glow:hover {
    background-color: rgba(255,255,255,0.05);
    box-shadow: 0 0 10px rgba(0,247,255,0.2);
    transition: all 0.2s ease;
}

/* Backdrop */
.sidebar-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 998;
    display: none;
}
.sidebar-backdrop.active { display: block; }

/* Notification */
.notification-bar {
    position: absolute;
    top: 60px;
    right: 20px;
    width: 320px;
    background: rgba(255,255,255,0.95);
    color: #000;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.25);
    display: none;
    z-index: 999;
}
.notification-bar ul { max-height: 300px; overflow-y: auto; padding: 10px; list-style: none; margin:0; }

/* Body */
.body {
    margin-left: 240px;
    padding: 80px 20px 40px;
    transition: margin-left 0.3s ease;
    min-height: calc(100vh - 80px);
}
.body.collapsed { margin-left: 0 !important; }

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 10px;
}
.dashboard-card {
    background: var(--panel-bg);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 22px 15px;
    text-align: center;
    box-shadow: 0 8px 16px rgba(0,0,0,0.25);
    transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
    color: var(--card-text);
    cursor: pointer;
    text-decoration: none;
    display: block;
}
.dashboard-card:hover { transform: translateY(-6px); box-shadow: 0 12px 26px rgba(0,0,0,0.35); }
.dashboard-card i { font-size: 28px; margin-bottom: 10px; color: #00d4ff; }
.dashboard-card h6 { margin: 8px 0 4px; font-size: 15px; font-weight: 600; color:#eaffff; }
.dashboard-card span { display:block; font-size:16px; font-weight:600; color:#ffffff; }

.floating-broadcast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #00d4ff;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 12px 18px;
    font-size: 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    cursor: pointer;
    z-index: 999;
    display:flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
}

@media (max-width: 768px) {
    .body { margin-left: 0 !important; padding-top: 100px; }
    .side-bar { width: 220px; }
}
</style>
</head>
<body>

<?php include "inc/header.php"; ?>
<?php include "inc/nav.php"; ?>

<div id="sidebarBackdrop" class="sidebar-backdrop d-md-none"></div>

<div class="notification-bar animate__animated" id="notificationBar">
    <ul id="notifications" class="list-group list-group-flush"></ul>
</div>

<div class="body" id="mainBody">
<section class="p-4">
<h4 class="mb-3" style="color: #e9fdfc;">Welcome to Your Dashboard</h4>
<div class="dashboard-grid">
<?php if ($_SESSION['role'] === "admin") { ?>
    <a href="user.php" class="dashboard-card"><i class="fas fa-users"></i><h6>Employees</h6><span><?= $num_users ?> Total</span></a>
    <a href="tasks.php" class="dashboard-card"><i class="fas fa-tasks"></i><h6>All Tasks</h6><span><?= $num_task ?> Tasks</span></a>
    <a href="tasks.php?filter=overdue" class="dashboard-card"><i class="fas fa-calendar-times"></i><h6>Overdue</h6><span><?= $overdue_task ?> Tasks</span></a>
    <a href="tasks.php?filter=no_deadline" class="dashboard-card"><i class="fas fa-calendar-minus"></i><h6>No Deadline</h6><span><?= $nodeadline_task ?> Tasks</span></a>
    <a href="tasks.php?filter=today" class="dashboard-card"><i class="fas fa-calendar-day"></i><h6>Due Today</h6><span><?= $todaydue_task ?> Tasks</span></a>
    <a href="notifications.php" class="dashboard-card"><i class="fas fa-bell"></i><h6>Notifications</h6><span><?= $overdue_task ?> Alerts</span></a>
    <a href="tasks.php?filter=pending" class="dashboard-card"><i class="fas fa-hourglass-start"></i><h6>Pending</h6><span><?= $pending ?> Tasks</span></a>
    <a href="tasks.php?filter=in_progress" class="dashboard-card"><i class="fas fa-spinner"></i><h6>In Progress</h6><span><?= $in_progress ?> Tasks</span></a>
    <a href="tasks.php?filter=completed" class="dashboard-card"><i class="fas fa-check-circle"></i><h6>Completed</h6><span><?= $completed ?> Tasks</span></a>
    <a href="admin_generate_quiz.php" class="dashboard-card"><i class="fas fa-magic"></i><h6>Generate Quiz</h6><span>AI-Powered</span></a>
<?php } else { ?>
    <a href="my_task.php" class="dashboard-card"><i class="fas fa-tasks"></i><h6>My Tasks</h6><span><?= $num_my_task ?> Total</span></a>
    <a href="my_task.php?filter=overdue" class="dashboard-card"><i class="fas fa-calendar-times"></i><h6>Overdue</h6><span><?= $overdue_task ?> Tasks</span></a>
    <a href="my_task.php?filter=no_deadline" class="dashboard-card"><i class="fas fa-calendar-minus"></i><h6>No Deadline</h6><span><?= $nodeadline_task ?> Tasks</span></a>
    <a href="my_task.php?filter=pending" class="dashboard-card"><i class="fas fa-hourglass-start"></i><h6>Pending</h6><span><?= $pending ?> Tasks</span></a>
    <a href="my_task.php?filter=in_progress" class="dashboard-card"><i class="fas fa-spinner"></i><h6>In Progress</h6><span><?= $in_progress ?> Tasks</span></a>
    <a href="my_task.php?filter=completed" class="dashboard-card"><i class="fas fa-check-circle"></i><h6>Completed</h6><span><?= $completed ?> Tasks</span></a>
    <a href="incident_quiz.php" class="dashboard-card"><i class="fas fa-question-circle"></i><h6>Take Quiz</h6><span>Cyber Safety</span></a>
<?php } ?>
</div>
</section>
</div>

<?php if ($_SESSION['role'] === "admin") { ?>
<a href="send_broadcast.php" class="floating-broadcast">
<i class="fas fa-bullhorn"></i> <span>Broadcast</span>
</a>
<?php } ?>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){

    // Function to load notifications
    function loadNotifications() {
        // Load notification count
        if($("#notificationNum").length){
            $("#notificationNum").load("app/notification-count.php");
        }
        // Load notification list
        if($("#notifications").length){
            $("#notifications").load("app/notification.php");
        }
    }

    // Initial load
    loadNotifications();

    // Auto-refresh every 15 seconds
    setInterval(loadNotifications, 15000);

    // Toggle notification dropdown
    let openNotification = false;
    const notificationBtn = $("#notificationBtn");
    const notificationBar = $("#notificationBar");

    notificationBtn.click(function(){
        if(openNotification){
            notificationBar.removeClass("animate__fadeInDown").fadeOut(200);
            openNotification = false;
        } else {
            notificationBar.fadeIn(200).addClass("animate__fadeInDown");
            openNotification = true;
        }
    });

    // Close notification if clicked outside
    $(document).click(function(e) {
        if(!$(e.target).closest("#notificationBtn, #notificationBar").length && openNotification){
            notificationBar.removeClass("animate__fadeInDown").fadeOut(200);
            openNotification = false;
        }
    });

});
</script>


</body>
</html>
