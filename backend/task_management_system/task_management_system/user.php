<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    $users = get_all_users($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #1abc9c, #0f2027);
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      min-height: 100vh;
    }
    .side-bar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      color: #fff;
      padding-top: 20px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
      z-index: 999;
    }
    .side-bar .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      color: #e0f7fa;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.2s ease;
    }
    .side-bar .nav-link i {
      font-size: 18px;
      color: #00d4ff;
    }
    .side-bar .nav-link span {
      font-weight: 500;
      font-size: 15px;
      white-space: nowrap;
    }
    .side-bar .nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateX(5px);
    }
    .body {
      margin-left: 240px;
      padding: 20px;
    }
    .section-1 .title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
      color: #fff;
    }
    .section-1 .title a {
      font-size: 14px;
      margin-left: 10px;
      background: #00d4ff;
      color: #fff;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
    }
    .main-table {
      width: 100%;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(8px);
      border-radius: 8px;
      overflow: hidden;
      color: #fff;
    }
    .main-table th, .main-table td {
      padding: 12px 15px;
      text-align: left;
    }
    .main-table th {
      background-color: #127b8e;
    }
    .main-table tr:hover {
      background-color: rgba(21, 179, 144, 0.3);
    }
    .edit-btn, .delete-btn {
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 14px;
      text-decoration: none;
      margin-right: 5px;
    }
    .edit-btn {
      background-color: #00c853;
      color: #fff;
    }
    .delete-btn {
      background-color: #d32f2f;
      color: #fff;
    }
    .success {
      background-color: #28a745;
      padding: 10px 15px;
      border-radius: 6px;
      margin-bottom: 15px;
      color: #fff;
    }
  </style>
</head>
<body>
  <?php include "inc/header.php"; ?>
  <?php include "inc/nav.php"; ?>

  <div class="body">
    <section class="section-1">
      <h4 class="title">Manage Users <a href="add-user.php"><i class="fa fa-plus"></i> Add User</a></h4>

      <?php if (isset($_GET['success'])) { ?>
        <div class="success" role="alert">
          <?= stripcslashes($_GET['success']); ?>
        </div>
      <?php } ?>

      <?php if ($users != 0) { ?>
        <table class="main-table">
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
          <?php $i = 0; foreach ($users as $user) { ?>
            <tr>
              <td><?= ++$i ?></td>
              <td><?= htmlspecialchars($user['full_name']) ?></td>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
              <td>
                <a href="edit-user.php?id=<?= $user['id'] ?>" class="edit-btn">Edit</a>
                <a href="delete-user.php?id=<?= $user['id'] ?>" class="delete-btn">Delete</a>
              </td>
            </tr>
          <?php } ?>
        </table>
      <?php } else { ?>
        <h3>No users found.</h3>
      <?php } ?>
    </section>
  </div>

  <script>
    document.querySelector("#navList li:nth-child(2)")?.classList.add("active");
  </script>
</body>
</html>
<?php 
} else {
  $em = "First login";
  header("Location: login.php?error=$em");
  exit();
}
?>