<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
if (!isset($_POST['kursi']) ){
  header("location:kursi.php");
}
$kursi = $_POST['kursi'];
$id_movies = $_POST['id_movies'];
$waktu= $_POST['waktu'];
$tanggal = $_POST['tanggal'];
$total = $_POST['total'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment Method - AZFATICKET.XXI</title>
  <style>
    /* === BASE STYLES === */
    body {
      margin: 0;
      background-color: #fef6f6; /* Soft red tint background */
      font-family: 'Montserrat', sans-serif;
      overflow-x: hidden;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    /* === PREMIUM HEADER STYLES === */
    header {
      background: linear-gradient(135deg, #c62828 0%, #8e0000 100%);
      color: white;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-radius: 0 0 30px 30px;
      box-shadow: 0 10px 30px rgba(198, 40, 40, 0.3);
      animation: navSlideIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255,255,255,0.1);
    }

    @keyframes navSlideIn {
      0% {
        opacity: 0;
        transform: translateY(-100px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* === LOGO STYLES === */
    .logo {
      display: flex;
      align-items: center;
      font-weight: 800;
      font-size: 28px;
      letter-spacing: 1px;
      text-shadow: 0 2px 5px rgba(0,0,0,0.2);
      transition: transform 0.4s ease;
    }

    .logo:hover {
      transform: scale(1.03);
    }

    .logo img {
      margin-right: 12px;
      height: 50px;
      width: auto;
      filter: drop-shadow(0 2px 5px rgba(0,0,0,0.2));
    }

    /* === NAVBAR === */
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

    /* === MAIN PAYMENT CONTAINER === */
    .payment-container {
      text-align: center;
      margin: 60px auto;
      padding: 0 30px;
      max-width: 800px;
      animation: fadeInUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .payment-container h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      font-weight: 700;
      color: #c62828;
      letter-spacing: 1px;
      margin-bottom: 20px;
      position: relative;
      display: inline-block;
    }

    .payment-container h2::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: linear-gradient(90deg, #c62828 0%, #8e0000 100%);
      border-radius: 3px;
    }

    .select-text {
      font-weight: 600;
      margin: 25px 0;
      font-size: 1.1rem;
      color: #555;
      letter-spacing: 0.5px;
    }

    .divider {
      width: 60%;
      margin: 25px auto;
      height: 1px;
      background: linear-gradient(90deg, transparent 0%, rgba(198, 40, 40, 0.3) 50%, transparent 100%);
      border: none;
    }

    /* === PAYMENT METHOD STYLES === */
    .payment-method {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      margin: 40px 0;
    }

    .bank {
      width: 80%;
      max-width: 500px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
      border-radius: 15px;
      padding: 15px 25px;
      box-shadow: 0 8px 25px rgba(198, 40, 40, 0.1);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: 1px solid rgba(198, 40, 40, 0.1);
      position: relative;
      overflow: hidden;
    }

    .bank::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 100%;
      background: linear-gradient(to bottom, #c62828, #8e0000);
      transition: width 0.3s ease;
    }

    .bank:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(198, 40, 40, 0.2);
    }

    .bank:hover::before {
      width: 8px;
    }

    .bank img {
      height: 35px;
      object-fit: contain;
      filter: drop-shadow(0 2px 5px rgba(0,0,0,0.1));
      transition: transform 0.3s ease;
    }

    .bank:hover img {
      transform: scale(1.05);
    }

    .bank input[type="radio"] {
      display: none;
    }

    .bank label {
      background-color: white;
      border: 2px solid #c62828;
      border-radius: 25px;
      padding: 8px 20px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      color: #c62828;
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
    }

    .bank label::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: 0.5s;
    }

    .bank label:hover::before {
      left: 100%;
    }

    .bank input[type="radio"]:checked + label {
      background: linear-gradient(135deg, #c62828 0%, #8e0000 100%);
      color: white;
      border-color: #8e0000;
      box-shadow: 0 5px 15px rgba(198, 40, 40, 0.3);
    }

    /* === BUY BUTTON STYLES === */
    .buy-now input[type="submit"] {
      margin: 40px 0;
      background: linear-gradient(135deg, #c62828 0%, #8e0000 100%);
      color: white;
      font-weight: 700;
      font-size: 1.2rem;
      padding: 15px 50px;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      letter-spacing: 1px;
      box-shadow: 0 10px 25px rgba(198, 40, 40, 0.3);
      position: relative;
      overflow: hidden;
    }

    .buy-now input[type="submit"]:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 15px 35px rgba(198, 40, 40, 0.4);
    }

    .buy-now input[type="submit"]::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: 0.5s;
    }

    .buy-now input[type="submit"]:hover::before {
      left: 100%;
    }

    /* === RESPONSIVE ADJUSTMENTS === */
    @media (max-width: 768px) {
      header {
        padding: 15px 20px;
        flex-direction: column;
        gap: 15px;
      }
      
      nav {
        gap: 15px;
      }
      
      .payment-container {
        margin: 40px auto;
      }
      
      .bank {
        width: 90%;
        padding: 12px 20px;
      }
    }
  </style>
</head>
<body>
  <!-- [Rest of your HTML remains exactly the same] -->
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

  <main class="payment-container">
    <h2>PAYMENT METHOD</h2>
    <hr class="divider">
    <p class="select-text">PLEASE YOUR SELECT</p>
    <hr class="divider">

    <div class="payment-method">
      <div class="bank">
        <img src="bank/BCA.jpg" alt="">
        <input type="radio" id="a"  name="button" value="bca" required>
        <label for="a">Select</label>
      </div>
      <div class="bank">
        <img src="bank/BRI.jpg" alt="">
        <input type="radio" id="b"  name="button" value="bri">
        <label for="b">Select</label>
      </div>
      <div class="bank">
        <img src="bank/BNI.jpg" alt="">
        <input type="radio" id="c"  name="button" value="bni">
        <label for="c">Select</label>
      </div>
      <div class="bank">
        <img src="bank/MANDIRI.jpg" alt="">
        <input type="radio" id="d"  name="button" value="mandiri">
        <label for="d">Select</label>
      </div>
      <div class="bank">
        <img src="bank/DANA.jpg" alt="">
        <input type="radio" id="e"  name="button" value="dana">
        <label for="e">Select</label>
      </div>
    </div>

    <hr class="divider">
    <form action="prs_metode_payment.php" method="post">
      <?php foreach($kursi as $input){ ?>
          <input type="hidden" name="kursi[]" value="<?= $input ?>">
      <?php } ?>
      <input type="hidden" name="id_movies" value="<?= $id_movies ?>">
      <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
      <input type="hidden" name="waktu" value="<?= $waktu ?>">
      <input type="hidden" name="total" value="<?= $total ?>">

      <div class="buy-now"><input type="submit" value="BUY NOW"></div>
    </form>
    
  </main>
</body>
</html>