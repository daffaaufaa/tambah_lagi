<?php
include "koneksi.php";
session_start();
if(!isset($_GET['id_movies'])){
  header("location:home.php");
}
$id_movies = $_GET['id_movies'];
$sql = "SELECT * FROM movies WHERE id_movies='$id_movies'";
$query = mysqli_query($koneksi, $sql);
$movies = mysqli_fetch_assoc($query);

$sql2 = "SELECT * FROM artis_movies WHERE id_movies='$id_movies'";
$query2 = mysqli_query($koneksi, $sql2);

$waktu = $movies['duration'];
$time = new DateTime($waktu);
$jam = $time->format('H');
$menit = $time->format('i');
$totalMenit = ($jam * 60) + $menit;

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siksa Neraka - Detail Film</title>
  <style>
    /* Reset dasar */
    @font-face {
      src: url('font/BakbakOne.ttf') format('truetype');
      font-family: 'BakbakOne';
    }
       body {
      margin: 0;
      background-color: #ffffff;
    }
        * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
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
    

    
    /* Pemeran */
    .pemeran-section {
      margin-top: 60px;
      margin-left: 30px;
    }

    .pemeran-section h3 {
      font-size: 16px;
      margin-bottom: 10px;
      margin-right: 700px;
      font-family: 'BakbakOne';
      border: 1px solid #000;
      border-radius: 10px;
    }

    .pemeran-list {
      display: flex;
      gap: 40px;
      overflow-x: auto;
      padding-bottom: 10px;
    }

    .pemeran-card {
      width: 80px;
      text-align: center;
      font-size: 15px;
    }

    .pemeran-card img {
      width: 100px;
      height: 100px;
      border-radius: 10px;
      margin-bottom: 5px;
    }

    .movie-container {
      text-align: center;
      margin-top: 90px;
      margin-bottom: 50px;
    }
    .movie-card {
      background-color: #fff4f4;
      margin: 30px auto;
      padding: 30px;
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
      font-size: 1.2rem;
      line-height: 1.5;
      font-weight: bold;
      color: #555;
    }

    #description {
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

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px);}
      to   { opacity: 1; transform: translateY(0);}
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px);}
      to   { opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>

  <!-- Header -->
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
    <section class="movie-card">
      <div class="movie-jarak">
        <img class="poster" src="movie/<?= $movies['poster_image'] ?>" alt="">
        <div class="info">
          <h3><?= strtoupper($movies['title']) ?></h3>
          <p><strong><?= ucfirst($movies['genre']) ?></strong><br><?= $totalMenit ?> minutes</p>
        </div>
      </div>
      <div class="pemeran-section">
        <h3>Pemeran</h3>
        <div class="pemeran-list">
          <?php while($artis= mysqli_fetch_assoc($query2)){ ?>
          <div class="pemeran-card">
            <img src="artis\<?= $artis['artis_image']?>.jpg" alt="">
            <?= ucfirst($artis['artis_name'])  ?>
          </div>
          <?php } ?>
        </div>
    </div>
      <div class="jarak">
        <div id="description">
          <?= $movies['description'] ?>
        </div>
      </div>
    </section>
  </main>


  
</body>
</html>
