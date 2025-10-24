<?php
include 'components/connect.php';

$user_id = $_COOKIE['user_id'] ?? '';

$get_id = $_GET['get_id'] ?? '';
if ($get_id === '') {
  header('location:home.php');
  exit;
}

if (isset($_POST['save_list'])) {
  if ($user_id !== '') {
    $list_id = filter_var($_POST['list_id'], FILTER_SANITIZE_STRING);

    $select_list = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
    $select_list->execute([$user_id, $list_id]);

    if ($select_list->rowCount() > 0) {
      $remove_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
      $remove_bookmark->execute([$user_id, $list_id]);
      $message[] = 'Playlist removed!';
    } else {
      $insert_bookmark = $conn->prepare("INSERT INTO `bookmark`(user_id, playlist_id) VALUES(?,?)");
      $insert_bookmark->execute([$user_id, $list_id]);
      $message[] = 'Playlist saved!';
    }
  } else {
    $message[] = 'Please login first!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Playlist</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Playlist Section -->
<section class="playlist" data-aos="fade-up">
  <h1 class="heading">Playlist Details</h1>
  <div class="row">
    <?php
    $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND status = ? LIMIT 1");
    $select_playlist->execute([$get_id, 'active']);
    if ($select_playlist->rowCount() > 0) {
      $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);
      $playlist_id = $fetch_playlist['id'];

      $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
      $count_videos->execute([$playlist_id]);
      $total_videos = $count_videos->rowCount();

      $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
      $select_tutor->execute([$fetch_playlist['tutor_id']]);
      $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

      $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
      $select_bookmark->execute([$user_id, $playlist_id]);
    ?>
    <div class="col" data-aos="zoom-in">
      <form action="" method="post" class="save-list">
        <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
        <button type="submit" name="save_list">
          <i class="<?= $select_bookmark->rowCount() > 0 ? 'fas' : 'far'; ?> fa-bookmark"></i>
          <span><?= $select_bookmark->rowCount() > 0 ? 'Saved' : 'Save Playlist'; ?></span>
        </button>
      </form>
      <div class="thumb">
        <span><?= $total_videos; ?> videos</span>
        <img src="uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="Playlist Thumbnail">
      </div>
    </div>

    <div class="col" data-aos="zoom-in">
      <div class="tutor">
        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="Tutor Image">
        <div>
          <h3><?= $fetch_tutor['name']; ?></h3>
          <span><?= $fetch_tutor['profession']; ?></span>
        </div>
      </div>
      <div class="details">
        <h3><?= $fetch_playlist['title']; ?></h3>
        <p><?= $fetch_playlist['description']; ?></p>
        <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
      </div>
    </div>
    <?php
    } else {
      echo '<p class="empty">This playlist was not found!</p>';
    }
    ?>
  </div>
</section>

<!-- Videos Container Section -->
<section class="videos-container" data-aos="fade-up">
  <h1 class="heading">Playlist Videos</h1>
  <div class="box-container">
    <?php
    $select_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ? ORDER BY date DESC");
    $select_content->execute([$get_id, 'active']);
    if ($select_content->rowCount() > 0) {
      while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>" class="box" data-aos="zoom-in">
      <i class="fas fa-play"></i>
      <img src="uploaded_files/<?= $fetch_content['thumb']; ?>" alt="Video Thumbnail">
      <h3><?= $fetch_content['title']; ?></h3>
    </a>
    <?php
      }
    } else {
      echo '<p class="empty">No videos added yet!</p>';
    }
    ?>
  </div>
</section>

<?php include 'components/footer.php'; ?>

<!-- Scripts -->
<script src="js/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true
  });
</script>

</body>
</html>