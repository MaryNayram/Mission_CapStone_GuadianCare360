<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
  $user_id = $_COOKIE['user_id'];
} else {
  $user_id = '';
  header('location:home.php');
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

if (isset($_POST['update_now'])) {
  $update_id = filter_var($_POST['update_id'], FILTER_SANITIZE_STRING);
  $update_box = filter_var($_POST['update_box'], FILTER_SANITIZE_STRING);

  $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ?");
  $verify_comment->execute([$update_id, $update_box]);

  if ($verify_comment->rowCount() > 0) {
    $message[] = 'Comment already exists!';
  } else {
    $update_comment = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ?");
    $update_comment->execute([$update_box, $update_id]);
    $message[] = 'Comment updated successfully!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Comments</title>

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

    .heading {
      text-align: center;
      font-size: 2rem;
      margin: 2rem 0;
      color: #000;
    }

    .edit-comment, .comments {
      padding: 2rem;
    }

    .edit-comment form {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .edit-comment .box {
      width: 100%;
      padding: 1rem;
      border-radius: 8px;
      border: 1px solid #ccc;
      resize: vertical;
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    .flex {
      display: flex;
      gap: 1rem;
    }

    .inline-btn, .inline-option-btn, .inline-delete-btn {
      background: #007bff;
      color: #fff;
      padding: 0.6rem 1.2rem;
      border-radius: 5px;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .inline-option-btn {
      background: #28a745;
    }

    .inline-delete-btn {
      background: #dc3545;
    }

    .inline-btn:hover {
      background: #0056b3;
    }

    .inline-option-btn:hover {
      background: #218838;
    }

    .inline-delete-btn:hover {
      background: #c82333;
    }

    .show-comments {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .box {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .box:hover {
      transform: translateY(-5px);
    }

    .content {
      margin-bottom: 1rem;
      font-size: 0.95rem;
      color: #555;
    }

    .content span {
      font-weight: bold;
      color: #007bff;
    }

    .content a {
      color: #007bff;
      text-decoration: underline;
    }

    .text {
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    .flex-btn {
      display: flex;
      gap: 1rem;
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

<?php
if (isset($_POST['edit_comment'])) {
  $edit_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_STRING);
  $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? LIMIT 1");
  $verify_comment->execute([$edit_id]);
  if ($verify_comment->rowCount() > 0) {
    $fetch_edit_comment = $verify_comment->fetch(PDO::FETCH_ASSOC);
?>
<section class="edit-comment" data-aos="fade-up">
  <h1 class="heading">Edit Comment</h1>
  <form action="" method="post">
    <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
    <textarea name="update_box" class="box" maxlength="1000" required placeholder="Update your comment here..."><?= $fetch_edit_comment['comment']; ?></textarea>
    <div class="flex">
      <a href="comments.php" class="inline-option-btn">Cancel</a>
      <input type="submit" value="Update Comment" name="update_now" class="inline-btn">
    </div>
  </form>
</section>
<?php
  } else {
    $message[] = 'Comment was not found!';
  }
}
?>

<section class="comments" data-aos="fade-up">
  <h1 class="heading">Your Comments</h1>
  <div class="show-comments">
    <?php
    $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
    $select_comments->execute([$user_id]);
    if ($select_comments->rowCount() > 0) {
      while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
        $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
        $select_content->execute([$fetch_comment['content_id']]);
        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="box" data-aos="zoom-in" style="<?php if ($fetch_comment['user_id'] == $user_id) { echo 'order:-1;'; } ?>">
      <div class="content">
        <span>October 2025</span>
        <p> - <?= $fetch_content['title']; ?> - </p>
        <a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>">View Content</a>
      </div>
      <p class="text"><?= $fetch_comment['comment']; ?></p>
      <form action="" method="post" class="flex-btn">
        <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
        <button type="submit" name="edit_comment" class="inline-option-btn">Edit</button>
        <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('Delete this comment?');">Delete</button>
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