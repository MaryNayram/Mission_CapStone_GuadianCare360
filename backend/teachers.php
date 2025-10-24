<?php
include 'components/connect.php';

$user_id = $_COOKIE['user_id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Expert Tutors</title>

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
      margin: 0;
      padding: 0;
      color: #333;
    }

    .heading {
      text-align: center;
      font-size: 2rem;
      margin: 2rem 0;
      color: #007bff;
    }

    .search-tutor {
      display: flex;
      justify-content: center;
      margin-bottom: 2rem;
    }

    .search-tutor input {
      padding: 0.75rem;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 5px 0 0 5px;
      font-size: 1rem;
    }

    .search-tutor button {
      padding: 0.75rem 1rem;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
      font-size: 1rem;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      padding: 2rem;
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

    .box.offer {
      background: linear-gradient(135deg, #007bff, #00c6ff);
      color: #fff;
      text-align: center;
    }

    .box.offer h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }

    .box.offer p {
      font-size: 1rem;
      margin-bottom: 1rem;
    }

    .box.offer .inline-btn {
      background: #fff;
      color: #007bff;
      padding: 0.6rem 1.2rem;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
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
      font-size: 1.2rem;
    }

    .tutor span {
      font-size: 0.95rem;
      color: #666;
    }

    .box p {
      font-size: 1rem;
      margin: 0.5rem 0;
    }

    .inline-btn {
      display: inline-block;
      background: #007bff;
      color: #fff;
      padding: 0.6rem 1.2rem;
      border-radius: 5px;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
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

<section class="teachers" data-aos="fade-up">
  <h1 class="heading">Expert Tutors</h1>

  <form action="search_tutor.php" method="post" class="search-tutor" data-aos="fade-up">
    <input type="text" name="search_tutor" maxlength="100" placeholder="Search tutor..." required>
    <button type="submit" name="search_tutor_btn"><i class="fas fa-search"></i></button>
  </form>

  <div class="box-container">
    <div class="box offer" data-aos="zoom-in">
      <h3>Become a Tutor</h3>
     <p style="color: #000;">Share your expertise and empower learners in cybersecurity and healthcare.</p>
      <a href="admin/register.php" class="inline-btn">Get Started</a>
    </div>

    <?php
    $select_tutors = $conn->prepare("SELECT * FROM `tutors`");
    $select_tutors->execute();
    if ($select_tutors->rowCount() > 0) {
      while ($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)) {
        $tutor_id = $fetch_tutor['id'];

        $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
        $count_playlists->execute([$tutor_id]);
        $total_playlists = $count_playlists->rowCount();

        $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
        $count_contents->execute([$tutor_id]);
        $total_contents = $count_contents->rowCount();

        $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
        $count_likes->execute([$tutor_id]);
        $total_likes = $count_likes->rowCount();

        $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
        $count_comments->execute([$tutor_id]);
        $total_comments = $count_comments->rowCount();
    ?>
    <div class="box" data-aos="zoom-in">
      <div class="tutor">
        <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="Tutor Image">
        <div>
          <h3><?= $fetch_tutor['name']; ?></h3>
          <span><?= $fetch_tutor['profession']; ?></span>
        </div>
      </div>
      <p>Playlists: <span><?= $total_playlists; ?></span></p>
      <p>Total Videos: <span><?= $total_contents; ?></span></p>
      <p>Total Likes: <span><?= $total_likes; ?></span></p>
      <p>Total Comments: <span><?= $total_comments; ?></span></p>
      <form action="tutor_profile.php" method="post">
        <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
        <input type="submit" value="View Profile" name="tutor_fetch" class="inline-btn">
      </form>
    </div>
    <?php
      }
    } else {
      echo '<p class="empty">No tutors found!</p>';
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