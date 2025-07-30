<?php
include "koneksi.php";
session_start();


$username = $_SESSION['username'];
$sql2 = "SELECT id_users FROM users WHERE username='$username'";
$query2 = mysqli_query($koneksi,$sql2);
$users = mysqli_fetch_assoc($query2);
$user = $users['id_users'];

$sql = "SELECT  m.id_movies,m.title, m.poster_image, b.total_price, b.status, p.mtd_payments, b.id_bookings FROM bookings b
        JOIN movies m ON b.id_movies = m.id_movies JOIN payments p ON p.id_payments = b.id_payments WHERE b.id_users = '$user'";
$query = mysqli_query($koneksi,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

    /* isi */
    .movie-container {
      text-align: center;
      margin-top: 30px;
    }

    .movie-container h2 {
      font-size: 2rem;
      color: #b12a2a;
      animation: fadeIn 1s ease-in-out;
    }

    .movie-card {
      background-color: #fff4f4;
      margin: 30px auto;
      padding: 25px;
      width: 95%;
      max-width: 900px;
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
      height: 80px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .info {
      display: flex;
      justify-content: space-between;
      text-align: left;
      flex-grow: 1;
      max-width: 500px;
      margin-left: 50px;
    }

    .info h4 {
      font-size: 1.3rem;
      color: #b12a2a;
      
    }

    .info p {
      font-size: 1rem;
      line-height: 1.5;
    }

    .info button {
      margin-top: 24px;
      width: 135px;
      height: 40px;
      border-radius: 10px;
      border : 1px solid #c5c0c0ff

    }
    .info button:hover {
      cursor: pointer;
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
    <?php while($pesanan = mysqli_fetch_assoc($query)) { ?>
    <section class="movie-card">
        <div class="movie-jarak">
            <img class="poster" src="movie/<?= $pesanan['poster_image'] ?>" alt="">
            <div class="info">
                <h4><?= $pesanan['title'] ?></h4><h4><?= $pesanan['total_price'] ?></h4>
                <?php if($pesanan['status']== "terverifikasi"){?>
                    <form action="tiket.php" method="post">
                      <input type="hidden" name="id_movies" value="<?= $pesanan['id_movies'] ?>">
                      <input type="hidden" name="id_bookings" value= "<?= $pesanan['id_bookings'] ?>">
                      <input type="hidden" name="mtd_payments" value= "<?= $pesanan['mtd_payments'] ?>">
                      <button type="submit" style="background: linear-gradient(135deg, #f44336, #c62828); color: white;"><i class="fas fa-regular fa-eye"></i> View</button>
                    </form>
                <?php }else{ ?>
                    <button><?= strtoupper($pesanan['status']) ?></button> 
                <?php } ?>
                
            </div>
        </div>
    </section>
    <?php } ?>

  </main>
</body>
</html>