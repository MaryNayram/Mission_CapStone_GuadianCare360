<!-- HEADER -->
<!-- HEADER -->
<header class="header d-flex justify-content-between align-items-center px-3 py-2 shadow-sm"
        style="background: rgba(20, 22, 24, 0.85); backdrop-filter: blur(12px); color: #fff; position: relative; z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <h2 class="u-name m-0 d-flex align-items-center" style="font-size: 1.4rem; font-weight: 600;">
    GuardianCare <b style="color:#00f7ff; margin-left: 4px; text-shadow: 0 0 6px #00f7ff;">360</b>

    <!-- ✅ Hamburger Icon (clickable) -->
    <span id="navbtn" class="ms-3 d-inline-block rounded-circle p-2 hover-glow" style="cursor: pointer;">
      <i class="fas fa-bars fa-lg" aria-hidden="true"></i>
    </span>
  </h2>

  <!-- Notification Icon -->
  <span class="notification position-relative rounded-circle p-2 hover-glow" id="notificationBtn" style="cursor:pointer;">
    <i class="fas fa-bell fa-lg text-white"></i>
    <span id="notificationNum"
          class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill px-2"
          style="font-size: 12px;">0</span>
  </span>


  
</header>

<!-- NOTIFICATION BAR -->
<div class="notification-bar animate__animated" id="notificationBar"
     style="position: absolute; top: 60px; right: 20px; width: 300px; background: rgba(0, 255, 255, 0.9);
            color: #000; border-radius: 10px; box-shadow: 0 8px 16px rgba(0,0,0,0.3); display: none; z-index: 999;">
  <ul id="notifications" class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
    <!-- Notifications will be loaded here -->
  </ul>
</div>

<!-- GLOW EFFECT STYLE -->
<style>
  .hover-glow:hover {
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 10px rgba(0, 247, 255, 0.6);
    transition: all 0.3s ease;
  }
</style>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<script>
  // Notification toggle
  let openNotification = false;
  const notificationBtn = document.getElementById("notificationBtn");
  const notificationBar = document.getElementById("notificationBar");

  notificationBtn?.addEventListener("click", () => {
    if (openNotification) {
      notificationBar.classList.remove("animate__fadeInDown");
      notificationBar.style.display = "none";
      openNotification = false;
    } else {
      notificationBar.style.display = "block";
      notificationBar.classList.add("animate__fadeInDown");
      openNotification = true;
    }
  });

  // Load notifications
  $(document).ready(function () {
    $("#notificationNum").load("app/notification-count.php");
    $("#notifications").load("app/notification.php");
  });
</script>