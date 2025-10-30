<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
  $user_id = $_COOKIE['user_id'];
} else {
  $user_id = '';
  header('location:home.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bookmarks</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9f9f9;
      color: #333;
      margin: 0;
      padding: 0;
    }

    .courses {
      padding: 4rem 2rem;
    }

    .heading {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 2rem;
      color: #000;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .box:hover {
      transform: translateY(-5px);
    }

    .tutor {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .tutor img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }

    .tutor h3 {
      margin: 0;
      font-size: 1rem;
    }

    .tutor span {
      font-size: 0.9rem;
      color: #666;
    }

    .thumb {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 1rem;
    }

    .title {
      font-size: 1.2rem;
      margin-bottom: 1rem;
      color: #007bff;
    }

    .inline-btn {
      background: #007bff;
      color: #fff;
      padding: 0.6rem 1.2rem;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease;
      display: inline-block;
    }

    .inline-btn:hover {
      background: #0056b3;
    }

    .empty {
      text-align: center;
      font-size: 1rem;
      color: #999;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="courses" data-aos="fade-up">
  <h1 class="heading">Bookmarked Playlists</h1>
  <div class="box-container">
    <?php
    $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
    $select_bookmark->execute([$user_id]);
    if ($select_bookmark->rowCount() > 0) {
      while ($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)) {
        $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND status = ? ORDER BY date DESC");
        $select_courses->execute([$fetch_bookmark['playlist_id'], 'active']);
        if ($select_courses->rowCount() > 0) {
          while ($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
            $course_id = $fetch_course['id'];
            $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
            $select_tutor->execute([$fetch_course['tutor_id']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="box" data-aos="zoom-in">
      <div class="tutor">
        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
        <div>
          <h3><?= $fetch_tutor['name']; ?></h3>
          <span><?= $fetch_course['date']; ?></span>
        </div>
      </div>
      <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
      <h3 class="title"><?= $fetch_course['title']; ?></h3>
      <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">View Playlist</a>
    </div>
    <?php
          }
        } else {
          echo '<p class="empty">No courses found!</p>';
        }
      }
    } else {
      echo '<p class="empty">Nothing bookmarked yet!</p>';
    }
    ?>
  </div>
</section>

<?php include 'components/footer.php'; ?>

<!-- Custom JS -->
<script src="js/script.js"></script>

<!-- AOS Animation Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true
  });
</script>

</body>
</html>