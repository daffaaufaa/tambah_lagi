<?php
include "koneksi.php";
session_start();

$sql = "SELECT * FROM movies WHERE genre = 'horor'";
$query = mysqli_query($koneksi, $sql);

$sql2 = "SELECT * FROM movies WHERE genre = 'komedi'";
$query2 = mysqli_query($koneksi, $sql2);

$sql3 = "SELECT * FROM movies WHERE genre = 'romance'";
$query3 = mysqli_query($koneksi, $sql3);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AZFATICKET.XXI</title>
  <style>
    /* === FONT CUSTOM === */
    @font-face {
      src: url('font/KeaniaOne.ttf') format('truetype');
      font-family: 'KeaniaOne';
    }
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    /* === RESET CSS === */
    
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
      background-size: cover;
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



    @keyframes logoPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }


    @keyframes spinIn {
      from { transform: rotate(0deg) scale(0); opacity: 0; }
      to { transform: rotate(360deg) scale(1); opacity: 1; }
    }


    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    h1 {
      text-align: center;
      margin: 29px 0 10px;
      font-size: 33px;
      animation: textGlow 2s ease-in-out infinite alternate;
    }

    @keyframes textGlow {
      from { text-shadow: 0 0 5px rgba(198, 40, 40, 0.5); }
      to { text-shadow: 0 0 15px rgba(198, 40, 40, 0.8); }
    }

    hr {
      width: 550px;
      margin: 20px auto 30px;
      border-top: 2px solid #000;
      animation: hrExpand 1.5s ease-out;
    }

    @keyframes hrExpand {
      from { width: 0; opacity: 0; }
      to { width: 550px; opacity: 1; }
    }

    .studio {
      margin-top: 64px;
      margin-left: 80px;
      animation: fadeInUp 1s ease both;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .studio:nth-child(1) { animation-delay: 0.3s; }
    .studio:nth-child(2) { animation-delay: 0.6s; }
    .studio:nth-child(3) { animation-delay: 0.9s; }

    .studio h2 {
      font-size: 21px;
      margin-bottom: 10px;
      position: relative;
      display: inline-block;
    }

    .studio h2::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 3px;
      bottom: -5px;
      left: 0;
      background-color: #c62828;
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.5s ease;
    }

    .studio:hover h2::after {
      transform: scaleX(1);
      transform-origin: left;
    }

    .movie-list {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .movie-list img {
      width: 130px;
      height: 190px;
      object-fit: cover;
      border-radius: 10px;
      transition: all 0.4s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      animation: cardPopIn 0.6s ease both;
    }

    @keyframes cardPopIn {
      from {
        opacity: 0;
        transform: scale(0.8) rotate(-5deg);
      }
      to {
        opacity: 1;
        transform: scale(1) rotate(0);
      }
    }

    .movie-list a:nth-child(1) img { animation-delay: 0.1s; }
    .movie-list a:nth-child(2) img { animation-delay: 0.2s; }
    .movie-list a:nth-child(3) img { animation-delay: 0.3s; }
    .movie-list a:nth-child(4) img { animation-delay: 0.4s; }
    .movie-list a:nth-child(5) img { animation-delay: 0.5s; }

    .movie-list img:hover {
      transform: translateY(-10px) scale(1.05);
      box-shadow: 0 15px 30px rgba(0,0,0,0.3);
      z-index: 10;
    }

    /* Background animation */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 30%, rgba(198, 40, 40, 0.1) 0%, transparent 30%),
                  radial-gradient(circle at 80% 70%, rgba(198, 40, 40, 0.1) 0%, transparent 30%);
      z-index: -1;
      animation: bgPulse 15s infinite alternate;
    }

    @keyframes bgPulse {
      0% { opacity: 0.3; }
      100% { opacity: 0.7; }
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

  <h1>welcome cinema studio</h1>
  <hr>

  <div class="studio">
    <h2>STUDIO 1</h2>
    <div class="movie-list">
        <?php while($horor = mysqli_fetch_assoc($query)){ ?>
            <a href="detail_film.php?id_movies=<?= $horor['id_movies'] ?>"><img src="movie\<?= $horor['poster_image']?>" alt=""></a>
        <?php } ?>
    </div>
  </div>

  <div class="studio">
    <h2>STUDIO 2</h2>
    <div class="movie-list">
        <?php while($komedi = mysqli_fetch_assoc($query2)){ ?>
            <a href="detail_film.php?id_movies=<?= $komedi['id_movies'] ?>"><img src="movie\<?= $komedi['poster_image']?>" alt=""></a>
        <?php } ?>
    </div>
  </div>

  <div class="studio">
    <h2>STUDIO 3</h2>
    <div class="movie-list">
        <?php while($romance = mysqli_fetch_assoc($query3)){ ?>
            <a href="detail_film.php?id_movies=<?= $romance['id_movies'] ?>"><img src="movie\<?= $romance['poster_image']?>" alt=""></a>
        <?php } ?>
    </div>
  </div>
</body>
</html>