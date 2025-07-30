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

body {
  background: #f7f4f4ff;
  font-family: 'BalsamiqSans', sans-serif;
  color: white;
  position: relative;
  overflow-x: hidden;
}

/* ===== CINEMA SCREEN EFFECT ===== */
.cinema-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: radial-gradient(ellipse at center, 
              rgba(198,40,40,0.2) 0%, 
              rgba(0,0,0,0.8) 70%);
  z-index: -2;
  pointer-events: none;
}

/* ===== NAVBAR STYLES ===== */
@font-face {
  src: url('font/BalsamiqSans.ttf') format('truetype');
  font-family: 'BalsamiqSans';
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: #fcfafaff;
  font-family: 'BalsamiqSans', sans-serif;
  color: white;
  position: relative;
  overflow-x: hidden;
}

/* ===== HEADER STYLES ===== */
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


/* ===== MAIN CONTENT STYLES ===== */
h1 {
  text-align: center;
  margin: 50px 0 30px;
  font-size: 3.5rem;
  background: linear-gradient(to right, #fff, #ff8a80);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  text-shadow: 0 2px 10px rgba(198,40,40,0.3);
  position: relative;
  animation: textGlow 2s infinite alternate;
}

@keyframes textGlow {
  from { text-shadow: 0 0 10px rgba(255,255,255,0.3); }
  to { text-shadow: 0 0 20px rgba(255,138,128,0.8); }
}

hr {
  width: 300px;
  margin: 0 auto 50px;
  border: none;
  height: 3px;
  background: linear-gradient(to right, transparent, #c62828, transparent);
  animation: hrExpand 1.5s ease-out;
}

@keyframes hrExpand {
  from { width: 0; opacity: 0; }
  to { width: 300px; opacity: 1; }
}

/* ===== STUDIO SECTIONS ===== */
.studio {
  margin: 80px auto;
  max-width: 1200px;
  padding: 0 5%;
  animation: fadeInUp 1s ease both;
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.studio h2 {
  font-size: 2.5rem;
  margin-bottom: 30px;
  position: relative;
  display: inline-block;
  color: white;
  text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.studio h2::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 0;
  width: 100%;
  height: 3px;
  background: linear-gradient(to right, #c62828, transparent);
  transform-origin: left;
  transform: scaleX(0);
  transition: transform 0.5s ease;
}

.studio:hover h2::after {
  transform: scaleX(1);
}

.movie-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 30px;
  margin-top: 30px;
}

.movie-list a {
  position: relative;
  display: block;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);
  transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  height: 350px;
}

.movie-list img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s, filter 0.5s;
}

.movie-list a:hover {
  transform: translateY(-10px) scale(1.03);
  box-shadow: 0 15px 40px rgba(198, 40, 40, 0.4);
}

.movie-list a:hover img {
  transform: scale(1.1);
  filter: brightness(1.1);
}

.movie-list a::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%);
  z-index: 1;
  opacity: 0;
  transition: opacity 0.3s;
}

.movie-list a:hover::before {
  opacity: 1;
}

.movie-list a::after {
  content: 'VIEW NOW';
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: #c62828;
  color: white;
  padding: 10px 25px;
  border-radius: 50px;
  font-weight: bold;
  z-index: 2;
  opacity: 0;
  transition: all 0.3s;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.movie-list a:hover::after {
  opacity: 1;
  bottom: 30px;
}

/* ===== ANIMATION DELAYS ===== */
.studio:nth-child(1) { animation-delay: 0.3s; }
.studio:nth-child(2) { animation-delay: 0.6s; }
.studio:nth-child(3) { animation-delay: 0.9s; }

.movie-list a:nth-child(1) { animation-delay: 0.1s; }
.movie-list a:nth-child(2) { animation-delay: 0.2s; }
.movie-list a:nth-child(3) { animation-delay: 0.3s; }
.movie-list a:nth-child(4) { animation-delay: 0.4s; }
.movie-list a:nth-child(5) { animation-delay: 0.5s; }

/* ===== SCROLLBAR STYLES ===== */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #1a1a1a;
}

::-webkit-scrollbar-thumb {
  background: #c62828;
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: #b71c1c;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
  .movie-list {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  }
  
  h1 {
    font-size: 3rem;
  }
}

@media (max-width: 768px) {
  header {
    flex-direction: column;
    padding: 20px;
  }
  
  nav {
    margin: 20px 0;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .movie-list {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  }
  
  h1 {
    font-size: 2.5rem;
  }
  
  .studio h2 {
    font-size: 2rem;
  }
}

@media (max-width: 480px) {
  nav a {
    margin: 5px;
    font-size: 1rem;
    padding: 8px 12px;
  }
  
  .movie-list {
    grid-template-columns: 1fr 1fr;
  }
  
  h1 {
    font-size: 2rem;
  }
  
  .studio h2 {
    font-size: 1.5rem;
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
                <a href="keranjang.php"><button>Riwayat Transaksi</button></a>
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