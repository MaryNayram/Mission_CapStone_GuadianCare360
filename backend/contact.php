<?php
include 'components/connect.php';

$user_id = $_COOKIE['user_id'] ?? '';

if (isset($_POST['submit'])) {
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
  $msg = filter_var($_POST['msg'], FILTER_SANITIZE_STRING);

  $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
  $select_contact->execute([$name, $email, $number, $msg]);

  if ($select_contact->rowCount() > 0) {
    $message[] = 'Message already sent!';
  } else {
    $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
    $insert_message->execute([$name, $email, $number, $msg]);
    $message[] = 'Message sent successfully!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact</title>

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

    .contact {
      padding: 2rem;
    }

    .contact .row {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      align-items: center;
      margin-bottom: 3rem;
    }

    .contact .image img {
      width: 100%;
      max-width: 500px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }

    .contact form {
      flex: 1 1 400px;
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .contact form h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #007bff;
    }

    .contact form .box {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    .contact form .inline-btn {
      background: #007bff;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .contact form .inline-btn:hover {
      background: #0056b3;
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
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
    }

    .box a {
      display: block;
      color: #333;
      margin: 0.3rem 0;
      text-decoration: none;
    }

    .box a:hover {
      color: #007bff;
    }
  </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="contact" data-aos="fade-up">
  <div class="row">
    <div class="image">
      <img src="images/contact-img.svg" alt="Contact Illustration">
    </div>

    <form action="" method="post">
      <h3>Get in Touch with Us!</h3>
      <input type="text" name="name" placeholder="Enter your name" required maxlength="100" class="box">
      <input type="email" name="email" placeholder="Enter your email" required maxlength="100" class="box">
      <input type="number" name="number" placeholder="Enter your number" required maxlength="10" class="box">
      <textarea name="msg" class="box" placeholder="Enter your message" required cols="30" rows="10" maxlength="1000"></textarea>
      <input type="submit" value="Send Message" class="inline-btn" name="submit">
    </form>
  </div>

  <div class="box-container" data-aos="fade-up">
    <div class="box">
      <i class="fas fa-phone"></i>
      <h3>Call Us</h3>
      <a href="tel:+233541111111">+233 54 111 1111</a>
      <a href="tel:+2502223333">+250 222 3333</a>
    </div>

    <div class="box">
      <i class="fas fa-envelope"></i>
      <h3>Email Us</h3>
      <a href="mailto:GuardianCare360@gmail.com">GuardianCare360@gmail.com</a>
      <a href="mailto:wecare360@gmail.com">wecare360@gmail.com</a>
    </div>

    <div class="box">
      <i class="fas fa-map-marker-alt"></i>
      <h3>Office Address</h3>
      <a href="#">Flat No. 1, A-1 Building, Oyibi-Central Business Center, Accra, Ghana - 400104</a>
    </div>
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