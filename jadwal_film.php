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
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $movies['title'] ?> - Jadwal Tayang</title>

  <style>
    /* ===== FONT ===== */
    @font-face {
      src: url('font/BalsamiqSans.ttf') format('truetype');
      font-family: 'BalsamiqSans';
    }

    /* ===== RESET ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #fff;
      font-family: 'BalsamiqSans', sans-serif;
      animation: fadeIn 1s ease-in;
    }

    input[type="radio"] {
      display: none;
    }

    /* ===== NAVBAR ===== */
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

    /* ===== MOVIE SECTION ===== */
    .movie-container {
      text-align: center;
      margin-top: 30px;
    }

    .movie-container h2 {
      font-size: 2rem;
      color: #b12a2a;
      animation: fadeIn 1s ease-in-out;
    }

    .divider {
      width: 50%;
      margin: 10px auto;
      border: 1px solid #b12a2a;
    }

    .movie-card {
      background-color: #fff4f4;
      margin: 30px auto;
      padding: 25px;
      width: 95%;
      max-width: 1000px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      animation: fadeInUp 0.8s ease-in-out;
    }

    .movie-jarak {
      display: flex;
      gap: 30px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .poster {
      width: 200px;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .info {
      text-align: left;
      flex-grow: 1;
      max-width: 500px;
    }

    .info h3 {
      font-size: 1.8rem;
      color: #b12a2a;
      margin-bottom: 10px;
    }

    .info p {
      font-size: 1rem;
      line-height: 1.5;
    }

    /* ===== TABS ===== */
    .tabs {
      display: flex;
      gap: 30px;
      margin-top: 30px;
      font-size: 1.2rem;
    }

    #jadwal label, #sinopsi label {
      color: rgba(0, 0, 0, 0.4);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    #jadwal input[type=radio]:checked + label,
    #sinopsi input[type=radio]:checked + label {
      border-bottom: 2px solid #b12a2a;
      color: #b12a2a;
      font-weight: bold;
    }

    /* ===== JADWAL & SINOPSIS ===== */
    #isi_jadwal, #description {
      animation: fadeIn 0.5s ease-in-out;
      margin-top: 20px;
    }

    .jarak {
      margin-top: 30px;
      text-align: left;
      padding: 20px;
      background-color: #ffffff;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .schedules {
      margin-top: 10px;
    }

    .days, .times {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin: 10px 0;
    }

    .days label, .times label {
      background-color: white;
      border: 2px solid #cccccc;
      border-radius: 10px;
      padding: 8px 15px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
    }

    .days input[type="radio"]:checked + label,
    .times input[type="radio"]:checked + label {
      background-color: #b12a2a;
      color: white;
      border-color: #b12a2a;
    }

    /* ===== BUTTON ===== */
    .pick-button input[type="submit"]{
      display: inline-block;
      margin-top: 15px;
      background-color: #b12a2a;
      color: white;
      text-decoration: none;
      padding: 10px 25px;
      font-weight: bold;
      border-radius: 5px;
      transition: background 0.3s ease;
      border: hidden;
      cursor: pointer;
    }

    .pick-button input[type="submit"]:hover {
      background-color: #8e1f1f;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px);}
      to   { opacity: 1; transform: translateY(0);}
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px);}
      to   { opacity: 1; transform: translateY(0);}
    }
  </style>

  <script>
    window.onload = function() {
      document.getElementById('ja_dwal').click();
    };
    function style_isi_jadwal() {
      document.getElementById('isi_jadwal').style.display = 'none';
      document.getElementById('description').style.display = 'block';
    }
    function style_deskripsi() {
      document.getElementById('description').style.display = 'none';
      document.getElementById('isi_jadwal').style.display = 'block';
    }
  </script>
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

  <main class="movie-container">
    <h2>WELCOME THIS MOVIE</h2>
    <hr class="divider">

    <section class="movie-card">
      <div class="movie-jarak">
        <img class="poster" src="movie/<?= $movies['poster_image'] ?>" alt="">
        <div class="info">
          <h3><?= strtoupper($movies['title']) ?></h3>
          <p><strong><?= ucfirst($movies['genre']) ?></strong><br><?= $totalMenit ?> minutes</p>

          <div class="tabs">
            <div id="jadwal" onclick="style_deskripsi()">
              <input type="radio" id="ja_dwal" name="sinopsi" value="jadwal">
              <label for="ja_dwal">JADWAL</label>
            </div>
            <div id="sinopsi" onclick="style_isi_jadwal()">
              <input type="radio" id="si_nopsi" name="sinopsi" value="sinopsi">
              <label for="si_nopsi">SINOPSI</label>
            </div>
          </div>
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
                  $tanggal_hari = $date->format('d'); // hari 2 angka, pake nol
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
</body>
</html>
