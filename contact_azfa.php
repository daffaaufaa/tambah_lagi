<?php
include "koneksi.php";
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AZFA - About & Contact</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* ======== RESET DAN DASAR ========== */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #fff;
      color: #333;
      animation: fadeInBody 1s ease;
    }

    @keyframes fadeInBody {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    a {
      text-decoration: none;
      color: inherit;
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

    /* ========= LAYOUT KONTAK ========== */
    .container {
      display: flex;
      gap: 30px;
      padding: 40px;
      max-width: 1200px;
      margin: auto;
      animation: slideUp 1s ease;
    }

    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .card {
      flex: 1;
      background-color: #fff0f0;
      border: 1px solid #ffcccc;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card h2 {
      margin-bottom: 10px;
      color: #b30000;
    }

    .card p, .card li {
      margin-bottom: 8px;
    }

    /* ====== FORMULIR ====== */
    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
      background-color: #fff;
      transition: border 0.3s;
    }

    form input:focus, form textarea:focus {
      border: 1px solid #b30000;
      outline: none;
    }

    form button {
      background-color: #b30000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    form button:hover {
      background-color: #800000;
    }

    /* ====== IKON KONTAK ====== */
    .contact-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 20px;
    }

    .contact-icon {
      width: 35px;
      height: 35px;
      background-color: #b30000;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-weight: bold;
    }

    /* ABOUT SECTION STYLES */
    .about-section {
      background: linear-gradient(to bottom right, #ffffff, #fff5f5);
      padding: 60px 20px;
      color: #800000;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .about-section h1 {
      text-align: center;
      font-size: 3rem;
      margin-bottom: 50px;
      color: #b30000;
      position: relative;
    }

    .about-section h1::after {
      content: "";
      display: block;
      width: 100px;
      height: 4px;
      background: #ff4d4d;
      margin: 10px auto 0;
      border-radius: 4px;
    }

    .about-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 50px;
      max-width: 1300px;
      margin: auto;
    }

    .profile-box {
      background: #fffafa;
      border: 2px solid #ffe0e0;
      border-radius: 25px;
      width: 420px;
      padding: 40px 30px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(255, 102, 102, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s;
      animation: floatUp 1s ease forwards;
    }

    .profile-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 30px rgba(238, 15, 15, 0.96);
    }

    @keyframes floatUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .profile-image {
      width: 130px;
      height: 130px;
      margin: 0 auto 20px;
      background-color:rgb(237, 26, 26);
      background-image: url('https://via.placeholder.com/130');
      background-size: cover;
      background-position: center;
      border-radius: 50%;
      border: 5px solid rgb(250, 16, 16);
      animation: pulse 2.5s infinite ease-in-out;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .profile-name {
      font-size: 1.7rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .profile-role {
      font-size: 1.2rem;
      color: #cc0000;
      margin-bottom: 25px;
    }

    .about-button {
      padding: 12px 24px;
      background-color: #ff4d4d;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s;
    }

    .about-button:hover {
      background-color: #e60000;
      transform: scale(1.05);
    }

    /* ======== POPUP ABOUT US ======== */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 2000;
      animation: fadeIn 0.3s ease-out;
    }

    .popup-container {
      background-color: white;
      width: 90%;
      max-width: 600px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      transform: scale(0.9);
      animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
      position: relative;
    }

    @keyframes popIn {
      0% { transform: scale(0.9); opacity: 0; }
      80% { transform: scale(1.05); }
      100% { transform: scale(1); opacity: 1; }
    }

    .popup-header {
      background: linear-gradient(135deg, #ff4d4d, #cc0000);
      color: white;
      padding: 20px;
      text-align: center;
    }

    .popup-header h2 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .popup-close-btn {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 24px;
      color: white;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .popup-close-btn:hover {
      transform: rotate(90deg) scale(1.1);
    }

    .popup-body {
      padding: 30px;
    }

    .popup-info-item {
      margin-bottom: 20px;
      animation: slideIn 0.5s ease-out forwards;
      opacity: 0;
    }

    @keyframes slideIn {
      from { transform: translateX(-20px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    .popup-info-item:nth-child(1) { animation-delay: 0.1s; }
    .popup-info-item:nth-child(2) { animation-delay: 0.2s; }
    .popup-info-item:nth-child(3) { animation-delay: 0.3s; }
    .popup-info-item:nth-child(4) { animation-delay: 0.4s; }
    .popup-info-item:nth-child(5) { animation-delay: 0.5s; }

    .popup-info-label {
      font-weight: bold;
      color: #cc0000;
      display: block;
      margin-bottom: 5px;
      font-size: 16px;
    }

    .popup-info-value {
      background-color: #f9f9f9;
      border-left: 4px solid #cc0000;
      padding: 12px 15px;
      border-radius: 0 5px 5px 0;
      font-size: 16px;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    }

    .popup-description {
      background-color: #fff5f5;
      border-radius: 8px;
      padding: 15px;
      margin-top: 20px;
      border: 1px solid #ffcccc;
      line-height: 1.6;
      animation: fadeInUp 0.6s 0.6s ease-out forwards;
      opacity: 0;
    }

    @keyframes fadeInUp {
      from { transform: translateY(10px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .popup-footer {
      text-align: center;
      padding: 15px;
      background-color: #f9f9f9;
      border-top: 1px solid #eee;
    }

    .popup-social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 10px;
    }

    .popup-social-icons a {
      color: #cc0000;
      font-size: 20px;
      transition: all 0.3s ease;
    }

    .popup-social-icons a:hover {
      color: #ff4d4d;
      transform: translateY(-3px);
    }

    /* ===== RESPONSIF ===== */
    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .profile-box {
        width: 90%;
      }
    }
  </style>
</head>
<body>
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
    </div>
  </header>

  <!-- ABOUT SECTION -->
  <section class="about-section">
    <h1>CONTACT AZFATICKET.XXI</h1>

    <div class="about-container">
      <!-- FRONT END -->
      <div class="profile-box">
        <div class="profile-image"></div>
        <div class="profile-name">Daffa Aufaa Pratama Irawan</div>
        <div class="profile-role">Front-End Developer</div>
        <button class="about-button" onclick="showPopup('frontend')">
          <i class="fas fa-user"></i> ABOUT US
        </button>
      </div>

      <!-- BACK END -->
      <div class="profile-box">
        <div class="profile-image"></div>
        <div class="profile-name">Aizar faruq Nafiul Umam</div>
        <div class="profile-role">Back-End Developer</div>
        <button class="about-button" onclick="showPopup('backend')">
          <i class="fas fa-user"></i> ABOUT US
        </button>
      </div>
    </div>
  </section>

  <!-- CONTACT SECTION -->
  <div class="container">
    <!-- INFORMASI KONTAK -->
    <div class="card">
      <h2>ABOUT AZFA</h2>
      <p>CONTACT US</p>

      <div class="contact-item">
        <div class="contact-icon">📍</div>
        <div>
          <strong>Alamat</strong><br>
          Jl. PADAMARA PERUM PERMATA B07 PUBALINGA LOR
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-icon">📞</div>
        <div>
          <strong>Telepon</strong><br>
          0857-8653-7284<br>
          067-1234-8701
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-icon">📧</div>
        <div>
          <strong>Email</strong><br>
          AZFATICKETXII@mail.com
        </div>
      </div>

      <div class="contact-item">
        <div class="contact-icon">⏰</div>
        <div>
          <strong>CIPTA</strong><br>
          AIZAR FARUQ NAFIUL UMAM - 5<br>
          DAFFA AUFAA PRATAMA IRAWAN - 10
        </div>
      </div>
    </div>

    <!-- FORM KIRIM PESAN -->
    <div class="card">
      <h2>REPORT A PROBLEM</h2>
      <p>please report what your prolem IS</p>
      <form>
        <label>Nama Lengkap</label>
        <input type="text" placeholder="Nama Anda">

        <label>Email</label>
        <input type="email" placeholder="Email Anda">

        <label>Nomor Telepon</label>
        <input type="tel" placeholder="Nomor Telepon">

        <label>Pesan</label>
        <textarea rows="5" placeholder="Tulis pesan Anda..."></textarea>

        <button type="submit">Kirim Pesan</button>
      </form>
    </div>
  </div>

  <!-- POPUP TEMPLATE -->
  <div class="popup-overlay" id="popupOverlay">
    <div class="popup-container">
      <div class="popup-header">
        <h2 id="popupTitle">ABOUT US</h2>
        <span class="popup-close-btn" onclick="hidePopup()">&times;</span>
      </div>
      <div class="popup-body">
        <div class="popup-info-item">
          <span class="popup-info-label">Nama:</span>
          <div class="popup-info-value" id="popupName">-</div>
        </div>
        <div class="popup-info-item">
          <span class="popup-info-label">Kelas:</span>
          <div class="popup-info-value" id="popupClass">-</div>
        </div>
        <div class="popup-info-item">
          <span class="popup-info-label">Absen:</span>
          <div class="popup-info-value" id="popupAbsen">-</div>
        </div>
        <div class="popup-info-item">
          <span class="popup-info-label">Asal Sekolah:</span>
          <div class="popup-info-value" id="popupSchool">-</div>
        </div>
        <div class="popup-description" id="popupDescription">
          -
        </div>
      </div>
      <div class="popup-footer">
        <p>Hubungi saya di media sosial:</p>
        <div class="popup-social-icons">
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-github"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Dropdown Menu
    function toggleDropdown() {
      document.getElementById("dropdownMenu").classList.toggle("active");
    }

    window.onclick = function(e) {
      if (!e.target.closest('.profile')) {
        document.getElementById("dropdownMenu").classList.remove("active");
      }
    }

    // Popup Functionality
    function showPopup(type) {
      const popup = document.getElementById('popupOverlay');
      const title = document.getElementById('popupTitle');
      const name = document.getElementById('popupName');
      const kelas = document.getElementById('popupClass');
      const absen = document.getElementById('popupAbsen');
      const school = document.getElementById('popupSchool');
      const description = document.getElementById('popupDescription');

      if (type === 'frontend') {
        title.textContent = 'ABOUT US FRONT END';
        name.textContent = 'DAFFA AUFAA PRATAMA IRAWAN';
        kelas.textContent = 'XI REKAYASA PERANGKAT LUNAK 2';
        absen.textContent = '10';
        school.textContent = 'SMK NEGERI 1 PURBALINGGA';
        description.textContent = 'Saya adalah seorang front end yang mendesain web, dengan keseluruhan tampilan, dengan ketelitian dan logika saya saya telah membuat website ini dengan melewati berbagai rintangan.';
      } else if (type === 'backend') {
        title.textContent = 'ABOUT US BACK END';
        name.textContent = 'AIZAR FARIQ NAFIUL UMAM';
        kelas.textContent = 'XI REKAYASA PERANGKAT LUNAK 2';
        absen.textContent = '5';
        school.textContent = 'SMK NEGERI 1 PURBALINGGA';
        description.textContent = 'Saya adalah seorang back end yang membuat tampilan admin, dengan keseluruhan tampilan, dengan ketelitian dan logika saya saya telah membuat website ini dengan melewati berbagai rintangan.';
      }

      popup.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    function hidePopup() {
      document.getElementById('popupOverlay').style.display = 'none';
      document.body.style.overflow = 'auto';
    }

    // Close popup when clicking outside
    document.getElementById('popupOverlay').addEventListener('click', function(e) {
      if (e.target === this) {
        hidePopup();
      }
    });
  </script>
</body>
</html>