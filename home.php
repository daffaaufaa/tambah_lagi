<?php
include "koneksi.php";
session_start();

if(isset($_SESSION['username'])){
  $username = $_SESSION['username']."!";
  
}else{
  $username = "to AZFATICKET.XXI!";
  
}
$sql = "SELECT * FROM iklan";
$query = mysqli_query($koneksi, $sql);

$sekarang = date("Y-m-d");
$sql2 = "SELECT * FROM movies WHERE max_tayang >= '$sekarang'";
$query2 =  mysqli_query($koneksi,$sql2);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
.welcome {
  text-align: center;
  font-size: 3rem;
  margin: 50px 0 30px;
  color: #fff;
  text-shadow: 0 0 10px #c62828, 0 0 20px #c62828;
  animation: neonGlow 2s infinite alternate;
}

@keyframes neonGlow {
  from {
    text-shadow: 0 0 10px #c62828, 0 0 20px #c62828;
  transform: scale(1);
  opacity: 1;
  letter-spacing: 0;
  filter: brightness(1);
  }
  to {
    text-shadow: 0 0 20px #c62828, 0 0 30px #c62828, 0 0 40px #c62828;
    transform: scale(1.02);
    opacity: 0.9;
    letter-spacing: 1px;
    filter: brightness(1.1);
  }
}

/* Remove voucher container */
.voucher-container {
  display: none;
}

/* ===== MOVIE SECTION STYLES ===== */
.movie-section {
  text-align: center;
  margin: 60px auto;
  max-width: 1400px;
  padding: 0 20px;
}

.movie-section h2 {
  font-size: 3rem;
  font-weight: bold;
  color: #fff;
  margin-bottom: 40px;
  position: relative;
  display: inline-block;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 1);
}

.movie-section h2::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 3px;
  background: linear-gradient(to right, transparent, #c62828, transparent);
}

.movie-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 30px;
  margin-bottom: 60px;
}

.movie-list a {
  position: relative;
  display: block;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);
  transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  height: 400px;
  perspective: 1000px;
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
  background: linear-gradient(to top, rgba(253, 250, 250, 1) 0%, transparent 50%);
  z-index: 1;
  opacity: 0;
  transition: opacity 0.3s;
}

.movie-list a:hover::before {
  opacity: 1;
}

.movie-list a::after {
  content: 'BOOK NOW';
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  background: #c62828;
  color: white;
  padding: 10px 25px;
  border-radius: 30px;
  font-weight: bold;
  z-index: 2;
  opacity: 0;
  transition: all 0.3s;
}

.movie-list a:hover::after {
  opacity: 1;
  bottom: 30px;
}

/* ===== UPDATE SECTION STYLES ===== */
.update-section {
  text-align: center;
  margin: 80px auto;
  max-width: 1000px;
  padding: 0 20px;
  position: relative;
}

.update-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
  opacity: 0.1;
  z-index: -1;
  border-radius: 20px;
}

.update-section h2 {
  font-size: 3rem;
  color: #fff;
  margin-bottom: 30px;
  text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.update-section h3 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #c62828;
  text-shadow: 0 2px 5px rgba(0,0,0,0.5);
}

.about-us {
  font-size: 1.1rem;
  line-height: 1.8;
  color: #ddd;
  background: rgba(255, 252, 252, 1);
  padding: 30px;
  border-radius: 20px;
  backdrop-filter: blur(5px);
  border: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 10px 30px rgba(250, 247, 247, 1);
}

/* ===== FOOTER STYLES ===== */
footer {
  background: linear-gradient(to top, #000000, #c62828);
  color: white;
  padding: 50px 30px;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  position: relative;
  overflow: hidden;
}

footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url('https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
  opacity: 0.1;
  z-index: 0;
}

.social-media, .download, .contact {
  width: 30%;
  position: relative;
  z-index: 1;
}

.social-media h4, .download h4, .contact h4 {
  font-size: 1.5rem;
  margin-bottom: 20px;
  color: #fff;
  text-shadow: 0 2px 5px rgba(0,0,0,0.5);
}

.social-media p, .contact p {
  margin-bottom: 15px;
  font-size: 1rem;
  color: #ddd;
}

.download img {
  width: 150px;
  margin-right: 10px;
  margin-bottom: 10px;
  transition: transform 0.3s;
  border-radius: 10px;
}

.download img:hover {
  transform: scale(1.05);
}

.copyright {
  width: 100%;
  text-align: center;
  font-size: 0.9rem;
  margin-top: 40px;
  color: #aaa;
  position: relative;
  z-index: 1;
}

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

/* ===== ANIMATIONS ===== */
@keyframes float {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(0px);
  }
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
  .movie-list {
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  }
  
  .social-media, .download, .contact {
    width: 100%;
    margin-bottom: 30px;
  }
}

@media (max-width: 768px) {
  header {
    flex-direction: column;
    padding: 20px;
  }
  
  nav {
    margin: 20px 0;
  }
  
  .movie-list {
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  }
  
  .welcome, .movie-section h2, .update-section h2 {
    font-size: 2rem;
  }
}

@media (max-width: 480px) {
  nav a {
    margin: 0 10px;
    font-size: 16px;
  }
  
  .movie-list {
    grid-template-columns: 1fr;
  }
  
  .about-us {
    padding: 20px;
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
              <a href="keranjang.php"><button>keranjang</button></a>
              <a href="logout.php"><button>Logout</button></a>
                
            <?php }else{ ?>
                <a href="login.php"><button>Sign In</button></a>
                <a href="register.php"><button>Sign Up</button></a> 
            <?php } ?>
        </div>
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

  <div class="welcome">Welcome <?= $username; ?></div>

  <div class="voucher-container">
    <?php while($gambar= mysqli_fetch_assoc($query)){ ?>
        <img src="iklan/<?= $gambar['gambar']?>" alt="">
    <?php } ?>
  </div>

  <div class="movie-section">
    <h2>MOVIE SELECTION</h2>
    <div class="movie-list">
      <?php while($gambar2=mysqli_fetch_assoc($query2)){ ?>
        <a href="jadwal_film.php?id_movies=<?= $gambar2['id_movies'] ?>">
          <img src="movie/<?= $gambar2['poster_image']?>" alt="">
        </a>
      <?php } ?>
    </div>
  </div>

  <div class="update-section">
    <h2>AZFA UPDATE</h2>
    <h3>About Us</h3>
    <p class="about-us">
      Azfa Bioskop adalah tempat terbaik untuk menikmati film dengan pengalaman menonton yang nyaman, modern, dan seru. Kami menyajikan berbagai film pilihan dari dalam dan luar negeri, lengkap dengan teknologi layar dan suara terkini. <br><br>
      Bukan sekadar bioskop, Azfa adalah ruang berkumpul untuk keluarga, sahabat, dan komunitas pecinta film. Kami hadir untuk menghadirkan hiburan berkualitas dan momen tak terlupakan di setiap tayangan. <br><br>
      AZFATICKET.XXI – Tempat cerita dimulai!
    </p>
  </div>

  <footer>
    <div class="social-media">
      <h4>Social Media</h4>
      <p>@azfabioskop_1indonesia</p>
      <p>@azfabioskopindonesia</p>
    </div>
    <div class="download">
      <h4>Download by</h4>
      <img src="#" alt="Google Play">
      <img src="#" alt="App Store">
    </div>
    <div class="contact">
      <h4>Contact Me</h4>
      <p>Jl. Kenyamanan Blok A no. 4 Jakarta pusat</p>
      <p>+62 857 8663 7284</p>
      <p>azfaticket@gmail.com</p>
    </div>
    <div class="copyright">
      COPYRIGHT 2025. AZFA XXI ALL RIGHTS RESERVED.
    </div>
  </footer>
</body>
</html>
