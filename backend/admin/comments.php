<?php
include '../components/connect.php';

$tutor_id = $_COOKIE['tutor_id'] ?? '';
if (!$tutor_id) {
  header('location:login.php');
  exit;
}

if (isset($_POST['delete_comment'])) {
  $delete_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_STRING);

  $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
  $verify_comment->execute([$delete_id]);

  if ($verify_comment->rowCount() > 0) {
    $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
    $delete_comment->execute([$delete_id]);
    $message[] = 'Comment deleted successfully!';
  } else {
    $message[] = 'Comment already deleted!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="comments" data-aos="fade-up">
  <h1 class="heading">User Comments</h1>

  <div class="show-comments">
    <?php
    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
    $select_comments->execute([$tutor_id]);
    if ($select_comments->rowCount() > 0) {
      while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
        $select_content->execute([$fetch_comment['content_id']]);
        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="box" data-aos="zoom-in" style="<?= $fetch_comment['tutor_id'] == $tutor_id ? 'order:-1;' : '' ?>">
      <div class="content">
        <span><?= $fetch_comment['date']; ?></span>
        <p> - <?= $fetch_content['title']; ?> - </p>
        <a href="view_content.php?get_id=<?= $fetch_content['id']; ?>">View Content</a>
      </div>
      <p class="text"><?= $fetch_comment['comment']; ?></p>
      <form action="" method="post">
        <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
        <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('Delete this comment?');">Delete Comment</button>
      </form>
    </div>
    <?php
      }
    } else {
      echo '<p class="empty">No comments added yet!</p>';
    }
    ?>
  </div>
</section>



<!-- Scripts -->
<script src="../js/admin_script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true
  });
</script>

</body>
</html>