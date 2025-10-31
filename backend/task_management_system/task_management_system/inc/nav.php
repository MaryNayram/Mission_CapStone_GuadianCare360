<nav class="side-bar bg-dark text-light" id="sidebar" role="navigation" aria-label="Main sidebar">
  <div class="user-p text-center py-4">
    <img src="img/user.png" alt="User profile picture"
         class="rounded-circle border border-info mb-2"
         style="width: 80px; height: 80px;">
    <h4 class="fw-semibold">@<?= htmlspecialchars($_SESSION['username']) ?></h4>
  </div>

  <ul id="navList" class="list-unstyled px-3 d-flex flex-column gap-3">
    <?php if ($_SESSION['role'] === "employee") { ?>
      <!-- Employee Navigation -->
      <li>
        <a href="index.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-tachometer"></i><span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="my_task.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-tasks"></i><span>My Task</span>
        </a>
      </li>
      <li>
        <a href="profile.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-user"></i><span>Profile</span>
        </a>
      </li>
      <li class="d-flex justify-content-between align-items-center">
        <a href="notifications.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-bell"></i><span>Notifications</span>
        </a>
        <span id="sidebarNotificationCount"
              class="badge bg-danger rounded-pill px-2"
              style="font-size: 12px;">0</span>
      </li>
      <li>
        <a href="logout.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-sign-out"></i><span>Logout</span>
        </a>
      </li>
    <?php } else { ?>
      <!-- Admin Navigation -->
      <li>
        <a href="index.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-tachometer"></i><span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="user.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-users"></i><span>Manage Users</span>
        </a>
      </li>
      <li>
        <a href="create_task.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-plus"></i><span>Create Task</span>
        </a>
      </li>
      <li>
        <a href="tasks.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-tasks"></i><span>All Tasks</span>
        </a>
      </li>
      <li>
        <a href="logout.php" class="nav-link d-flex align-items-center gap-2">
          <i class="fa fa-sign-out"></i><span>Logout</span>
        </a>
      </li>
    <?php } ?>
  </ul>
</nav>

<!-- Sidebar toggle script (GLOBAL for all pages) -->
<script>
  const navBtn = document.getElementById("navbtn");
  const sidebar = document.getElementById("sidebar");
  const body = document.querySelector(".body");
  const backdrop = document.getElementById("sidebarBackdrop");

  navBtn?.addEventListener("click", () => {
    sidebar?.classList.toggle("collapsed");
    body?.classList.toggle("collapsed");
    backdrop?.classList.toggle("active");

    const icon = navBtn.querySelector("i");
    if (icon) {
      icon.classList.toggle("fa-bars");
      icon.classList.toggle("fa-times");
    }
  });

  backdrop?.addEventListener("click", () => {
    sidebar?.classList.add("collapsed");
    body?.classList.add("collapsed");
    backdrop?.classList.remove("active");

    const icon = navBtn.querySelector("i");
    if (icon) {
      icon.classList.add("fa-bars");
      icon.classList.remove("fa-times");
    }
  });
</script>
