<?php 
include "koneksi.php";
session_start();

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$query = mysqli_query($koneksi, $sql);

$users = mysqli_fetch_assoc($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Elegant Profil</title>
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(to bottom right, #ffe3e3, #ffccd5);
      min-height: 100vh;
    }

    /* NAVBAR */
    header {
      background-color: #c62828;
      color: white;
      padding: 25px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-radius: 0 0 50px 50px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      animation: navFadeIn 1s ease-in-out;
    }

    @keyframes navFadeIn {
      0% {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .logo {
      display: flex;
      align-items: center;
      font-weight: bold;
      font-size: 28px;
    }

    .logo img {
      margin-right: 10px;
      height: 50px;
      width: auto;
    }

    nav a {
      margin: 0 18px;
      text-decoration: none;
      color: white;
      font-weight: bold;
      font-size: 18px;
      position: relative;
      transition: all 0.4s ease;
    }

    nav a::after {
      content: '';
      display: block;
      width: 0;
      height: 2px;
      background: white;
      transition: width 0.3s;
      position: absolute;
      bottom: -5px;
      left: 0;
    }

    nav a:hover::after {
      width: 100%;
    }

    nav a:hover {
      transform: scale(1.1);
    }

    .profile img {
      width: 50px;
      height: 50px;
      background-size: contain;
      border-radius: 50%;
      cursor: pointer;

    }
    .profile a{
      text-decoration: none;
    }

    .dropdown {
      position: absolute;
      top: 65px;
      right: 0;
      background: rgba(255,255,255,0.9);
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      backdrop-filter: blur(8px);
      padding: 10px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: 0.3s ease;
      z-index: 100;
    }

    .dropdown.active {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown button {
      display: block;
      background: linear-gradient(to right, #ff8a80, #ff5252);
      color: white;
      font-size: 18px;
      font-weight: 500;
      padding: 12px 20px;
      margin: 10px 0;
      width: 200px;
      border: none;
      border-radius: 12px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .dropdown button:hover {
      background: linear-gradient(to right, #ff1744, #e53935);
      transform: scale(1.05);
    }

    /* PROFILE CARD */
    .card {
      max-width: 600px;
      margin: 60px auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 40px 30px;
      border-radius: 30px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      text-align: center;
      backdrop-filter: blur(10px);
    }

    .card .profile-pic {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid #f44336;
      margin-bottom: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }

    .card h2 {
      color: #c2185b;
      margin-bottom: 30px;
      font-size: 26px;
    }

    .form-group {
      text-align: left;
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #f44336;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 12px 18px;
      border: 1px solid #ffcdd2;
      border-radius: 12px;
      background: #fffafa;
      font-size: 16px;
      transition: 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #f06292;
      box-shadow: 0 0 8px rgba(240,98,146,0.3);
    }

    .form-group textarea {
      height: 100px;
      resize: none;
    }

    .submit-btn {
      margin-top: 20px;
      background: linear-gradient(to right, #f44336, #ff6e40);
      color: white;
      padding: 14px 40px;
      font-size: 18px;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .submit-btn:hover {
      transform: scale(1.05);
      background: linear-gradient(to right, #e53935, #ff7043);
    }

  </style>
</head>
<body>

  <!-- NAVBAR -->
  <header>
        <div class="logo">
            <img src="logo_web.png" alt="AZFATICKET Logo">
            AZFATICKET.XXI
        </div>
        <nav>
            <a href="home.php">MOVIE</a>
            <a href="cinema.php">CINEMA</a>
            <a href="contact_azfa.php">CONTACT</a>
        </nav>
        <div class="profile" onclick="toggleDropdown()">
        <img src="userputih.jpg" alt="">
        <div class="dropdown" id="dropdownMenu">
            <?php if(isset($_SESSION['username'])){ ?>
                <a href="profil_azfa.php"><button>Profil <?= $_SESSION['username'] ?></button></a>
                <a href="logout.php"><button>Logout</button></a>
            <?php }else{ ?>
                <a href="login.php"><button>Sign In</button></a>
                <a href="register.php"><button>Sign Up</button></a> 
            <?php } ?>
        </div>
        
    </header>
    <script>
    function toggleDropdown() {
      document.getElementById("dropdownMenu").classList.toggle("active");
    }

    window.onclick = function(e) {
      if (!e.target.closest('.profile')) {
        document.getElementById("dropdownMenu").classList.remove("active");
      }
    }
  </script>

  <!-- PROFIL FORM -->
  <div class="card">
    <img src="userputih.jpg" class="profile-pic" alt="">
    <h2>Update Your Profile</h2>
    <form action="prs_profil_azfa.php" method="post">
      <div class="form-group">
        <input type="hidden" name="id_users" value="<?= $users['id_users'] ?>">
        <label>Name</label>
        <input type="text" name="name" value="<?= $users['nama'] ?>" placeholder="Enter your name">
      </div>
      <div class="form-group">
        <label>Phone Number</label>
        <input type="text" name="no_hp" value="<?= $users['no_hp'] ?>" placeholder="Enter your phone number">
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="<?= $users['gmail'] ?>" placeholder="Enter your Gmail">
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" value="<?= $users['description'] ?>" placeholder="Tell us something about yourself..."><?= $users['description'] ?></textarea>
        
      </div>
      <button type="submit" class="submit-btn">Save</button>
    </form>
  </div>


</body>
</html>
