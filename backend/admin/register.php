<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
  $id = unique_id();
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $profession = filter_var($_POST['profession'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $pass = sha1(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
  $cpass = sha1(filter_var($_POST['cpass'], FILTER_SANITIZE_STRING));

  $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
  $ext = pathinfo($image, PATHINFO_EXTENSION);
  $rename = unique_id() . '.' . $ext;
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = '../uploaded_files/' . $rename;

  $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
  $select_tutor->execute([$email]);

  if ($select_tutor->rowCount() > 0) {
    $message[] = 'Email already taken!';
  } else {
    if ($pass !== $cpass) {
      $message[] = 'Confirm password not matched!';
    } else {
      $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
      $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
      move_uploaded_file($image_tmp_name, $image_folder);
      $message[] = 'New tutor registered! Please login now.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/admin_style.css" />
</head>
<body style="padding-left: 0;">

<?php
if (isset($message)) {
  foreach ($message as $msg) {
    echo '
    <div class="message form" data-aos="fade-down">
      <span>' . $msg . '</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>';
  }
}
?>

<!-- Register Section -->
<section class="form-container" data-aos="fade-up">
  <form class="register" action="" method="post" enctype="multipart/form-data">
    <h3>Register New</h3>
    <div class="flex">
      <div class="col">
        <p>Your Name <span>*</span></p>
        <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
        <p>Your Profession <span>*</span></p>
        <<select name="profession" class="box" required>
  <option value="" disabled selected>-- Select your profession</option>

  <!-- General Medical Roles -->
  <option value="Pharmacist">Pharmacist</option>
  <option value="Gen. Physician">General Physician</option>
  <option value="Biologist">Biologist</option>
  <option value="Physician Assistant">Physician Assistant</option>
  <option value="Dietitian">Dietitian</option>
  <option value="Therapist">Therapist</option>
  <option value="Radiologist">Radiologist</option>
  <option value="Eye Doctor">Eye Doctor</option>
  <option value="Gynaecologist">Gynaecologist</option>
  <option value="Oncologist">Oncologist</option>

  <!-- Expanded Nursing Roles -->
  <option value="Registered Nurse (RN)">Registered Nurse (RN)</option>
  <option value="Licensed Practical Nurse (LPN)">Licensed Practical Nurse (LPN)</option>
  <option value="Nurse Practitioner (NP)">Nurse Practitioner (NP)</option>
  <option value="Clinical Nurse Specialist (CNS)">Clinical Nurse Specialist (CNS)</option>
  <option value="Certified Nurse Midwife (CNM)">Certified Nurse Midwife (CNM)</option>
  <option value="Certified Registered Nurse Anesthetist (CRNA)">Certified Registered Nurse Anesthetist (CRNA)</option>
  <option value="Community Health Nurse">Community Health Nurse</option>
  <option value="Emergency Room Nurse">Emergency Room Nurse</option>
  <option value="ICU Nurse">ICU Nurse</option>
  <option value="Pediatric Nurse">Pediatric Nurse</option>
  <option value="Geriatric Nurse">Geriatric Nurse</option>
  <option value="Oncology Nurse">Oncology Nurse</option>
  <option value="Psychiatric Nurse">Psychiatric Nurse</option>
  <option value="Surgical Nurse">Surgical Nurse</option>
  <option value="Cardiac Nurse">Cardiac Nurse</option>
  <option value="Neonatal Nurse">Neonatal Nurse</option>
  <option value="Orthopedic Nurse">Orthopedic Nurse</option>
  <option value="Infection Control Nurse">Infection Control Nurse</option>
  <option value="Nurse Educator">Nurse Educator</option>
  <option value="Nursing Informatics Specialist">Nursing Informatics Specialist</option>
  <option value="Home Health Nurse">Home Health Nurse</option>
  <option value="Travel Nurse">Travel Nurse</option>
</select>
      
        <p>Your Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter your email" maxlength="100" required class="box">
      </div>
      <div class="col">
        <p>Your Password <span>*</span></p>
        <input type="password" name="pass" placeholder="Enter your password" maxlength="20" required class="box">
        <p>Confirm Password <span>*</span></p>
        <input type="password" name="cpass" placeholder="Confirm your password" maxlength="20" required class="box">
        <p>Select Picture <span>*</span></p>
        <input type="file" name="image" accept="image/*" required class="box">
      </div>
    </div>
    <p class="link">Already have an account? <a href="login.php">Login now</a></p>
    <input type="submit" name="submit" value="Register Now" class="btn">
  </form>
</section>

<!-- Dark Mode Script -->
<script>
const body = document.body;
const darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () => {
  body.classList.add('dark');
  localStorage.setItem('dark-mode', 'enabled');
};

const disableDarkMode = () => {
  body.classList.remove('dark');
  localStorage.setItem('dark-mode', 'disabled');
};

darkMode === 'enabled' ? enableDarkMode() : disableDarkMode();
</script>

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