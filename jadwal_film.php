<?php
include "koneksi.php";
session_start();
if(!isset($_GET['id_movies'])){
  header("location:home.php");
}
$id_movies = $_GET['id_movies'];
$sql = "SELECT * FROM movies WHERE id_movies = '$id_movies'";
$query = mysqli_query($koneksi,$sql);
$movies = mysqli_fetch_assoc($query);

$sql2 = "SELECT * FROM jadwal_waktu WHERE id_movies = '$id_movies'";
$query2 = mysqli_query($koneksi,$sql2);

$sql3 = "SELECT DATE_FORMAT(waktu, '%H:%i') AS waktu, id_jadwal_waktu FROM jadwal_waktu WHERE id_movies = '$id_movies'";  
$query3 = mysqli_query($koneksi,$sql3);

$waktu = $movies['duration'];
$time = new DateTime($waktu);
$jam = $time->format('H');
$menit = $time->format('i');
$totalMenit = ($jam * 60) + $menit;

$id = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<style>
    /* ===== FONT & BASE STYLES ===== */
    @font-face {
      src: url('font/BalsamiqSans.ttf') format('truetype');
      font-family: 'BalsamiqSans';
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    input[type="radio"] {
      display: none;
    }
    body {
      background: linear-gradient(135deg, #f9f9f9 0%, #fff5f5 100%);
      font-family: 'BalsamiqSans', sans-serif;
      animation: fadeIn 1s ease-in;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 30%, rgba(255, 215, 215, 0.8) 0%, rgba(255, 255, 255, 0) 50%),
                  radial-gradient(circle at 80% 70%, rgba(215, 215, 255, 0.6) 0%, rgba(255, 255, 255, 0) 50%);
      z-index: -1;
      opacity: 0.5;
    }

    /* ===== NAVBAR ===== */
    header {
      background: linear-gradient(135deg, #c62828 0%, #8e0000 100%);
      color: white;
      padding: 25px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-radius: 0 0 30px 30px;
      box-shadow: 0 10px 30px rgba(198, 40, 40, 0.3);
      animation: navFadeIn 1s ease-in-out;
    }

    @keyframes navFadeIn {
      0% { opacity: 0; transform: translateY(-50px) scale(0.9); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .logo {
      display: flex;
      align-items: center;
      font-weight: bold;
      font-size: 28px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.03);
    }

    .logo img {
      margin-right: 10px;
      height: 50px;
      width: auto;
      filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
    }

    nav a {
      margin: 0 18px;
      text-decoration: none;
      color: white;
      font-weight: bold;
      font-size: 18px;
      position: relative;
      transition: all 0.4s ease;
      padding: 8px 12px;
      border-radius: 8px;
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
      background: rgba(255, 255, 255, 0.1);
    }

    .profile img {
      width: 50px;
      height: 50px;
      background-size: contain;
      border-radius: 50%;
      cursor: pointer;
      transition: transform 0.3s ease;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .profile:hover img {
      transform: scale(1.1);
    }

    .profile a {
      text-decoration: none;
    }

    .dropdown {
      position: absolute;
      top: 65px;
      right: 0;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(8px);
      padding: 10px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
      z-index: 100;
      border: 1px solid rgba(255, 255, 255, 0.2);
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
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown button:hover {
      background: linear-gradient(to right, #ff1744, #e53935);
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* ===== MOVIE SECTION ===== */
    .movie-container {
      text-align: center;
      margin-top: 30px;
      position: relative;
    }

    .movie-container h2 {
      font-size: 2.5rem;
      color: #b12a2a;
      animation: fadeIn 1s ease-in-out;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
      position: relative;
      display: inline-block;
    }

    .movie-container h2::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: linear-gradient(to right, #b12a2a, #ff8a80);
      border-radius: 3px;
    }

    .divider {
      width: 50%;
      margin: 20px auto;
      border: none;
      height: 1px;
      background: linear-gradient(to right, transparent, #b12a2a, transparent);
    }

    .movie-card {
      background: linear-gradient(145deg, #ffffff 0%, #fff4f4 100%);
      margin: 40px auto;
      padding: 30px;
      width: 95%;
      max-width: 850px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 0.8s ease-in-out;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(255, 182, 182, 0.3);
    }

    .movie-card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255, 215, 215, 0.1) 0%, transparent 70%);
      z-index: 0;
    }

    .movie-jarak {
      display: flex;
      gap: 40px;
      justify-content: center;
      flex-wrap: wrap;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .poster {
      width: 240px;
      height: auto;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      border: 3px solid white;
    }

    .poster:hover {
      transform: scale(1.03) rotate(1deg);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .info {
      text-align: left;
      flex-grow: 1;
      max-width: 500px;
      margin-left: 20px;
      margin-top: 12px;
    }

    .info h3 {
      font-size: 2rem;
      color: #b12a2a;
      margin-bottom: 15px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
      position: relative;
      display: inline-block;
    }

    .info h3::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(to right, #b12a2a, transparent);
    }

    .info p {
      font-size: 1.1rem;
      line-height: 1.6;
      margin-bottom: 15px;
      color: #555;
    }

    .trailer-btn {
      display: inline-block;
      background: linear-gradient(to right, #ff5252, #b12a2a);
      color: white;
      padding: 10px 20px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 10px;
      box-shadow: 0 4px 10px rgba(177, 42, 42, 0.3);
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .trailer-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(177, 42, 42, 0.4);
    }

    .trailer-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .trailer-btn:hover::before {
      left: 100%;
    }

    /* ===== TRAILER POPUP ===== */
    .trailer-popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.9);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .trailer-popup.active {
      opacity: 1;
      visibility: visible;
    }

    .trailer-content {
      position: relative;
      width: 80%;
      max-width: 900px;
      background: #000;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 30px rgba(255, 82, 82, 0.5);
      transform: scale(0.8);
      transition: transform 0.3s ease;
    }

    .trailer-popup.active .trailer-content {
      transform: scale(1);
    }

    .close-trailer {
      position: absolute;
      top: 10px;
      right: 10px;
      color: white;
      font-size: 30px;
      cursor: pointer;
      z-index: 10;
      transition: transform 0.3s ease;
    }

    .close-trailer:hover {
      transform: rotate(90deg);
      color: #ff5252;
    }

    /* ===== TABS ===== */
    .tabs {
      display: flex;
      justify-content: center;
      gap: 100px;
      margin-top: 40px;
      font-size: 1.3rem;
      position: relative;
      z-index: 1;
    }

    #jadwal, #sinopsi {
      position: relative;
    }

    #jadwal label, #sinopsi label {
      color: rgba(0, 0, 0, 0.4);
      cursor: pointer;
      transition: all 0.3s ease;
      padding: 5px 15px;
      border-radius: 30px;
    }

    #jadwal input[type=radio]:checked + label,
    #sinopsi input[type=radio]:checked + label {
      border-bottom: 2px solid #b12a2a;
      color: #b12a2a;
      font-weight: bold;
    }

    #jadwal label:hover, #sinopsi label:hover {
      color: #b12a2a;
      background: rgba(177, 42, 42, 0.05);
    }

    /* ===== JADWAL & SINOPSIS ===== */
    #isi_jadwal, #description {
      animation: fadeIn 0.5s ease-in-out;
      margin-top: 20px;
      position: relative;
      z-index: 1;
    }

    .jarak {
      margin-top: 30px;
      text-align: left;
      padding: 30px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(0, 0, 0, 0.05);
      position: relative;
      overflow: hidden;
    }

    .jarak::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 100%;
      background: linear-gradient(to bottom, #b12a2a, #ff5252);
    }

    .schedules {
      margin-top: 10px;
    }

    .schedules strong {
      font-size: 1.2rem;
      color: #b12a2a;
      display: block;
      margin-bottom: 15px;
      padding-left: 10px;
      border-left: 3px solid #b12a2a;
    }

    .days, .times {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin: 15px 0;
    }

    .days label, .times label {
      background-color: white;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
      min-width: 80px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .days label::before, .times label::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(177, 42, 42, 0.1), transparent);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .days label:hover::before, .times label:hover::before {
      opacity: 1;
    }

    .days input[type="radio"]:checked + label,
    .times input[type="radio"]:checked + label {
      background: linear-gradient(135deg, #b12a2a, #ff5252);
      color: white;
      border-color: #b12a2a;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(177, 42, 42, 0.3);
    }

    /* ===== BUTTON ===== */
    .pick-button {
      text-align: center;
      margin-top: 30px;
    }

    .pick-button input[type="submit"] {
      display: inline-block;
      background: linear-gradient(to right, #b12a2a, #ff5252);
      color: white;
      text-decoration: none;
      padding: 12px 30px;
      font-weight: bold;
      border-radius: 30px;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      font-size: 1.1rem;
      box-shadow: 0 5px 15px rgba(177, 42, 42, 0.3);
      position: relative;
      overflow: hidden;
    }

    .pick-button input[type="submit"]::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .pick-button input[type="submit"]:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(177, 42, 42, 0.4);
    }

    .pick-button input[type="submit"]:hover::before {
      left: 100%;
    }

    /* ===== DESCRIPTION ===== */
    #description {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #444;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    /* ===== DECORATIONS ===== */
    .floating {
      position: absolute;
      opacity: 0.1;
      z-index: 0;
    }

    .floating-1 {
      top: 10%;
      left: 5%;
      width: 100px;
      height: 100px;
      background: #b12a2a;
      border-radius: 50%;
      filter: blur(30px);
      animation: float 15s infinite ease-in-out;
    }

    .floating-2 {
      bottom: 15%;
      right: 5%;
      width: 150px;
      height: 150px;
      background: #ff5252;
      border-radius: 50%;
      filter: blur(40px);
      animation: float 18s infinite ease-in-out reverse;
    }

    @keyframes float {
      0% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-50px) rotate(180deg); }
      100% { transform: translateY(0) rotate(360deg); }
    }
  </style>

  <script>
    window.onload = function() {
      document.getElementById('ja_dwal').click();
    };
    
    function style_isi_jadwal() {
      document.getElementById('isi_jadwal').style.display = 'block';
      document.getElementById('description').style.display = 'none';
    }
    
    function style_deskripsi() {
      document.getElementById('description').style.display = 'block';
      document.getElementById('isi_jadwal').style.display = 'none';
    }
    
    function toggleDropdown() {
      document.getElementById("dropdownMenu").classList.toggle("active");
    }
    
    function showTrailer() {
      document.getElementById("trailerPopup").classList.add("active");
      document.body.style.overflow = 'hidden';
    }
    
    function hideTrailer() {
      document.getElementById("trailerPopup").classList.remove("active");
      document.body.style.overflow = 'auto';
    }

    window.onclick = function(e) {
      if (!e.target.closest('.profile')) {
        document.getElementById("dropdownMenu").classList.remove("active");
      }
      if (e.target.classList.contains('trailer-popup')) {
        hideTrailer();
      }
    }
  </script>
</head>

<body>
  <!-- Floating decorations -->
  <div class="floating floating-1"></div>
  <div class="floating floating-2"></div>

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
          <a href="keranjang.php"><button>Riwayat Transaksi</button></a>
          <a href="logout.php"><button>Logout</button></a>
        <?php }else{ ?>
          <a href="login.php"><button>Sign In</button></a>
          <a href="register.php"><button>Sign Up</button></a> 
        <?php } ?>
      </div>
    </div>
  </header>

  <main class="movie-container">
    <h2>WELCOME THIS MOVIE</h2>
    <hr class="divider">

    <section class="movie-card">
      <div class="movie-jarak">
        <img class="poster" src="movie/<?= $movies['poster_image'] ?>" alt="">
        <div class="info">
          <h3><?= strtoupper($movies['title']) ?></h3>
          <p><strong><?= ucfirst($movies['genre']) ?></strong></p>
          <p><?= $totalMenit ?> minutes</p>
          <button class="trailer-btn" onclick="showTrailer()">WATCH TRAILER</button>
        </div>
      </div>
      
      <div class="tabs">
        <div id="jadwal" onclick="style_deskripsi()">
          <input type="radio" id="ja_dwal" name="sinopsi" value="jadwal">
          <label for="ja_dwal">SINOPSI</label>
        </div>
        <div id="sinopsi" onclick="style_isi_jadwal()">
          <input type="radio" id="si_nopsi" name="sinopsi" value="sinopsi">
          <label for="si_nopsi">JADWAL</label>
        </div>
      </div>

      <div id="isi_jadwal">
        <form action="kursi.php" method="post">
          <input type="hidden" name="id_movies" value="<?= $id_movies ?>">
          <div class="jarak">
            <div class="schedules">
              <strong>SCHEDULES</strong>
              <div class="days">
                <?php while($tanggal = mysqli_fetch_assoc($query2)){
                  $date = new DateTime($tanggal['tanggal']);
                  $tanggal_hari = $date->format('d');
                  $nama_hari = $date->format('l'); 
                  $nm_hari = [
                    'Monday' => 'SENIN', 'Tuesday' => 'SELASA', 'Wednesday' => 'RABU', 'Thursday' => 'KAMIS',
                    'Friday' => 'JUMAT', 'Saturday' => 'SABTU', 'Sunday' => 'MINGGU'
                  ];
                  $array_hari = $nm_hari[$nama_hari];
                  $id++;
                ?>
                  <input type="radio" id="<?= $id ?>" name="tanggal" value="<?= $tanggal['tanggal'] ?>">
                  <label for="<?= $id ?>"><?= ucfirst($array_hari) ?><br><?= $tanggal_hari ?></label>
                <?php } ?>
              </div>

              <strong>TIME MOVIE</strong>
              <div class="times">
                <?php while($waktu = mysqli_fetch_assoc($query3)){ ?>
                  <input type="radio" id="<?= $waktu['id_jadwal_waktu'] ?>" name="waktu" value="<?= $waktu['waktu'] ?>">
                  <label for="<?= $waktu['id_jadwal_waktu'] ?>"><?= $waktu['waktu'] ?></label>
                <?php } ?>
              </div>
            </div>
            <hr>
            <div class="pick-button"><input type="submit" value="PICK YOUR SEAT"></div>
          </div>
        </form>
      </div>

      <div class="jarak">
        <div id="description" style="display:none;">
          <?= $movies['description'] ?>
        </div>
      </div>
    </section>
  </main>

  <!-- Trailer Popup -->
  <div class="trailer-popup" id="trailerPopup">
    <div class="trailer-content">
      <span class="close-trailer" onclick="hideTrailer()">&times;</span>
      <!-- Replace with your actual trailer embed code -->
      <iframe width="100%" height="500" src="video/<?= $movies['video_path'] ?>" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</body>
</html>