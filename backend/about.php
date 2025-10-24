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
  <title>About</title>

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

    .about, .reviews {
      padding: 4rem 2rem;
    }

    .about .row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 2rem;
    }

    .about .image img {
      width: 100%;
      max-width: 500px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }

    .about .content h3 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: #000;
      animation: fadeInUp 0.6s ease-in-out;
    }

    .about .content p {
      font-size: 1rem;
      margin-bottom: 2rem;
    }

    .inline-btn {
      background: #007bff;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .inline-btn:hover {
      background: #0056b3;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }

    .box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .box:hover {
      transform: translateY(-5px);
    }

    .box i {
      font-size: 2rem;
      color: #007bff;
      margin-bottom: 1rem;
    }

    .box h3 {
      font-size: 1.5rem;
      margin: 0;
    }

    .box span {
      font-size: 1rem;
      color: #666;
    }

    .heading {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 2rem;
      color: #000;
    }

    .reviews .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .reviews .box {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .reviews .box:hover {
      transform: scale(1.02);
    }

    .reviews .user {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-top: 1rem;
    }

    .reviews .user img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }

    .reviews .user h3 {
      margin: 0;
      font-size: 1rem;
    }

    .stars i {
      color: #ffc107;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- About Section -->
<section class="about" data-aos="fade-up">
  <div class="row">
    <div class="image">
      <img src="images/about-img.svg" alt="About Us" />
    </div>
    <div class="content">
      <h3>Why choose us?</h3>
      <p>Whether you're a small clinic or a large hospital network, GuardianCare360 offers scalable cybersecurity solutions that can adapt to your organization's size and growth requirements.</p>
      <a href="courses.php" class="inline-btn">Our courses</a>
    </div>
  </div>

  <div class="box-container">
    <div class="box" data-aos="zoom-in">
      <i class="fa fa-plus-square"></i>
      <h3>+10</h3>
      <span>Hospitals</span>
    </div>
    <div class="box" data-aos="zoom-in">
      <i class="fa fa-users"></i>
      <h3>+100</h3>
      <span>Healthcare staff</span>
    </div>
    <div class="box" data-aos="zoom-in">
      <i class="fas fa-chalkboard-user"></i>
      <h3>+50</h3>
      <span>Expert teachers</span>
    </div>
    <div class="box" data-aos="zoom-in">
      <i class="fas fa-briefcase"></i>
      <h3>100%</h3>
      <span>Deliverable success</span>
    </div>
  </div>
</section>

<!-- Reviews Section -->
<section class="reviews" data-aos="fade-up">
  <h1 class="heading">Student's Reviews</h1>
  <div class="box-container">
    <div class="box" data-aos="fade-up">
      <p>GuardianCare360 gave me the confidence to implement cybersecurity protocols in our clinic. The training was clear, practical, and empowering.</p>
      <div class="user">
        <img src="images/pic-2.jpg" alt="Sarah Mensah" />
        <div>
          <h3>Sarah Mensah</h3>
          <div class="stars">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="box" data-aos="fade-up">
      <p>The instructors were incredibly knowledgeable and supportive. I now feel equipped to protect patient data effectively.</p>
      <div class="user">
        <img src="images/pic-3.jpg" alt="Kwame Boateng" />
        <div>
          <h3>Kwame Boateng</h3>
          <div class="stars">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="box" data-aos="fade-up">
      <p>As a nurse, I found the modules on patient privacy and data protection extremely relevant and easy to apply.</p>
      <div class="user">
        <img src="images/pic-4.jpg" alt="Linda Owusu" />
        <div>
          <h3>Linda Owusu</h3>
          <div class="stars">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
          </div>
        </div>
      </div>
    </div>
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