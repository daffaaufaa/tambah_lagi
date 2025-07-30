<?php
include "koneksi.php";
$sql = "SELECT * FROM iklan ORDER BY id_iklan DESC";
$query = mysqli_query($koneksi,$sql);

$sql2 = "SELECT * FROM movies ";
$query2 = mysqli_query($koneksi,$sql2);

$sql3 = "SELECT * FROM bookings WHERE status='pending' ";
$query3 = mysqli_query($koneksi,$sql3);

$sql6 = "SELECT * FROM payments ";
$query6 = mysqli_query($koneksi,$sql6);

$sql7 = "SELECT id_movies,title FROM movies";
$query7 = mysqli_query($koneksi,$sql7);
$no = 1;
$total = 0;
$total_jumlah = 0;

$sql10 = "SELECT m.id_movies, m.title, m.genre, COUNT(b.id_bookings) AS total_booking FROM movies m LEFT JOIN bookings b ON m.id_movies = b.id_movies AND b.status = 'terverifikasi'
          GROUP BY m.id_movies ORDER BY total_booking DESC";
$query10 = mysqli_query($koneksi,$sql10);
$ranking = 1;

$sql11 = "SELECT * FROM bookings WHERE status IN ('terverifikasi','tertolak')";
$query11 = mysqli_query($koneksi,$sql11);

if(isset($_POST['bulan'])){
  $input = $_POST['bulan'];
  $bulan = substr($input, 5, 2); // ambil karakter ke-6 dan ke-7
}else{
  $bulan = 01;
}

$sql9 = "SELECT ";  

if(isset($_POST['jumlah'])){
    $jumlah = $_POST['jumlah'];
}else{
    $jumlah = 1;
}

if(isset($_POST['tokoh'])){
    $tokoh = $_POST['tokoh'];
}else{
    $tokoh = 1;
}


?>
  

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin AZFATICKET.XXI</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* MODIFIED CSS SECTION */
:root {
  --primary:rgb(252, 5, 5);
  --primary-dark:rgb(255, 16, 16);
  --primary-light: #ff3d3d;
  --secondary: #1a1a2e;
  --accent: #ffd700;
  --text: #333;
  --text-light: #777;
  --bg: #f8f9fa;
  --card-bg: #ffffff;
  --border: rgba(0,0,0,0.1);
  --shadow: 0 20px 50px rgba(209, 0, 0, 0.15);
  --transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', system-ui, -apple-system, sans-serif;
}

body {
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  overflow-x: hidden;
  line-height: 1.6;
  background-image: radial-gradient(rgba(209, 0, 0, 0.05) 1px, transparent 1px);
  background-size: 20px 20px;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes slideIn {
  from { transform: translateX(-30px); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-8px); }
  100% { transform: translateY(0px); }
}

@keyframes scaleIn {
  0% { transform: scale(0.95); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
.navbar {
  background: linear-gradient(135deg, 
             rgba(200, 30, 30, 0.9), 
             rgba(150, 20, 20, 0.95));
  color: white;
  padding: 25px 50px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 10px 30px rgba(200, 30, 30, 0.3),
              0 15px 25px rgba(0, 0, 0, 0.2),
              inset 0 1px 0 rgba(255, 255, 255, 0.1);
  position: relative;
  z-index: 100;
  animation: floatIn 1s cubic-bezier(0.19, 1, 0.22, 1);
  border-radius: 0 0 20px 20px;
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  transition: all 0.4s ease;
}

.navbar:hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 35px rgba(200, 30, 30, 0.4),
              0 20px 30px rgba(0, 0, 0, 0.25),
              inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

.navbar::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 85%;
  height: 3px;
  background: linear-gradient(90deg, 
              transparent, 
              rgba(255, 60, 60, 0.8), 
              transparent);
  box-shadow: 0 0 20px rgba(255, 60, 60, 0.6);
  border-radius: 50%;
  opacity: 0.8;
  transition: all 0.4s ease;
}

.navbar:hover::after {
  width: 90%;
  opacity: 1;
  height: 4px;
  box-shadow: 0 0 25px rgba(255, 80, 80, 0.8);
}

.navbar .logo {
  font-size: 28px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-shadow: 0 2px 10px rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  gap: 10px;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  background: linear-gradient(to right, #fff, #f5d6d6);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  padding: 5px 0;
}

.navbar .logo:hover {
  transform: translateY(-3px) scale(1.02);
  text-shadow: 0 4px 20px rgba(255, 255, 255, 0.3);
}
/* Add profile container styles */
.profile-container {
  position: relative;
  display: flex;
  align-items: center;
  gap: 20px;
}

.profile-logo {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,230,230,0.95));
  border: 2px solid rgba(255,255,255,0.3);
  box-shadow: 0 5px 15px rgba(200, 30, 30, 0.4),
              inset 0 0 10px rgba(255,255,255,0.2);
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-logo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile-logo:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 8px 25px rgba(200, 30, 30, 0.6),
              inset 0 0 15px rgba(255,255,255,0.3);
}

/* Dropdown menu styles */
.profile-dropdown {
  position: absolute;
  top: 70px;
  right: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(15px);
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(150, 20, 20, 0.3),
              0 5px 15px rgba(0,0,0,0.1);
  padding: 15px 0;
  width: 200px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.4);
  z-index: 1000;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.profile-dropdown.active {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.profile-dropdown::before {
  content: '';
  position: absolute;
  top: -8px;
  right: 20px;
  width: 20px;
  height: 20px;
  background: rgba(255, 255, 255, 0.95);
  transform: rotate(45deg);
  z-index: -1;
  border-radius: 3px;
}

.profile-dropdown ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.profile-dropdown li {
  padding: 10px 20px;
  color: #333;
  font-weight: 500;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.profile-dropdown li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 3px;
  height: 100%;
  background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
  transform: translateX(-10px);
  transition: all 0.3s ease;
}

.profile-dropdown li:hover {
  background: rgba(200, 30, 30, 0.1);
  color: var(--primary-dark);
  padding-left: 25px;
}

.profile-dropdown li:hover::before {
  transform: translateX(0);
}

.profile-dropdown li.logout {
  border-top: 1px solid rgba(200, 30, 30, 0.1);
  margin-top: 5px;
  padding-top: 15px;
  color: var(--primary-dark);
  font-weight: 600;
}

.profile-dropdown li.logout:hover {
  background: rgba(200, 30, 30, 0.05);
  color: #d00;
}
@keyframes slideInItem {
  0% {
    opacity: 0;
    transform: translateX(10px);
  }
  100% {
    opacity: 1;
    transform: translateX(0);
  }
}

.profile-dropdown.active li {
  animation: slideInItem 0.4s ease forwards;
}

.profile-dropdown.active li:nth-child(1) { animation-delay: 0.1s; }
.profile-dropdown.active li:nth-child(2) { animation-delay: 0.2s; }
.profile-dropdown.active li:nth-child(3) { animation-delay: 0.3s; }

@keyframes floatIn {
  0% {
    transform: translateY(-100px);
    opacity: 0;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}
.main {
  display: flex;
  min-height: calc(100vh - 83px);
  position: relative;
}

.sidebar {
  width: 280px;
  background: white;
  padding: 30px 20px;
  box-shadow: 5px 0 30px rgba(0, 0, 0, 0.1);
  animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1);
  position: relative;
  z-index: 50;
  border-right: 1px solid rgba(209, 0, 0, 0.1);
}

.sidebar h3 {
  color: var(--primary);
  margin-bottom: 30px;
  font-size: 18px;
  font-weight: 600;
  letter-spacing: 1px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgba(209, 0, 0, 0.1);
}

.sidebar button {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  padding: 14px 20px;
  margin-bottom: 12px;
  background: white;
  color: var(--text);
  border: 1px solid rgba(209, 0, 0, 0.2);
  border-radius: 8px;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
  text-align: left;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.sidebar button:hover {
  background: var(--primary);
  color: white;
  transform: translateX(8px) scale(1.02);
  box-shadow: 0 10px 25px rgba(209, 0, 0, 0.2);
  border-color: var(--primary);
}

.sidebar button i {
  font-size: 18px;
}

.content {
  flex: 1;
  padding: 40px;
  position: relative;
}

.section {
  display: none;
  background: var(--card-bg);
  border-radius: 15px;
  box-shadow: var(--shadow);
  padding: 30px;
  margin-bottom: 30px;
  border: none;
  transform: translateY(0);
  transition: var(--transition);
  position: relative;
  overflow: hidden;
  animation: scaleIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.1) forwards;
  border: 1px solid rgba(209, 0, 0, 0.1);
}

.section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 5px;
  height: 100%;
  background: linear-gradient(to bottom, var(--primary), var(--accent));
}

.section:hover {
  transform: translateY(-5px) scale(1.005);
  box-shadow: 0 25px 60px rgba(209, 0, 0, 0.15);
}

.section.active {
  display: block;
  animation: fadeIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.1) forwards;
}

.section h1, .section h2, .section h3 {
  color: var(--primary);
  margin-bottom: 25px;
  font-weight: 600;
  position: relative;
  padding-bottom: 10px;
}

.section h1::after, .section h2::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background: var(--accent);
  border-radius: 3px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 15px;
  min-width: 800px;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  animation: fadeIn 0.8s ease;
  position: relative;
  z-index: 1;
}

th {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: white;
  padding: 16px 12px;
  text-align: left;
  font-weight: 500;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  font-size: 14px;
  position: sticky;
  top: 0;
}

td {
  padding: 14px 12px;
  border-bottom: 1px solid rgba(209, 0, 0, 0.1);
  vertical-align: middle;
  color: var(--text);
  background: white;
  transition: var(--transition);
}

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background: rgba(209, 0, 0, 0.03);
  transform: scale(1.01);
}

.iklan img {
  width: 80px;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: var(--transition);
  border: 1px solid rgba(209, 0, 0, 0.1);
}

.iklan img:hover {
  transform: scale(1.1) rotate(2deg);
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

a {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 8px 16px;
  border-radius: 8px;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: var(--transition);
  margin-right: 8px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

a i {
  font-size: 14px;
}

a:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.success-message {
  background: linear-gradient(135deg,rgb(242, 7, 7),rgb(248, 8, 8));
  color: white;
  padding: 16px;
  margin-bottom: 25px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 8px 25px rgb(254, 7, 7);
  animation: fadeIn 0.5s ease, float 3s ease-in-out infinite;
  border: 1px solid rgba(255,255,255,0.2);
}

.error-message {
  background: linear-gradient(135deg, #f44336, #c62828);
  color: white;
  padding: 16px;
  margin-bottom: 25px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 8px 25px rgba(244, 67, 54, 0.3);
  animation: fadeIn 0.5s ease, float 3s ease-in-out infinite 1s;
  border: 1px solid rgba(255,255,255,0.2);
}

.verify-btn {
  background: linear-gradient(135deg,rgb(254, 6, 6),rgb(248, 19, 6));
  color: white;
  padding: 8px 20px;
  border-radius: 8px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 4px 15px rgba(248, 13, 13, 0.3);
  transition: var(--transition);
  border: none;
}

.verify-btn:hover {
  background: linear-gradient(135deg,rgb(248, 14, 14),rgb(244, 13, 13));
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 8px 25px rgba(248, 12, 12, 0.4);
}

form {
  max-width: 800px;
  margin: 0 auto;
  animation: fadeIn 0.8s ease;
  background: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: var(--shadow);
  transition: var(--transition);
  position: relative;
  overflow: hidden;
}

form:hover {
  transform: translateY(-5px);
  box-shadow: 0 25px 60px rgba(209, 0, 0, 0.15);
}

form::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(to right, var(--primary), var(--accent));
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: var(--text);
}

input[type="text"],
input[type="number"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="file"],
textarea,
select {
  width: 100%;
  padding: 14px 18px;
  margin-bottom: 20px;
  border: 1px solid rgba(209, 0, 0, 0.2);
  border-radius: 10px;
  font-size: 15px;
  transition: var(--transition);
  background: white;
  box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
input[type="month"]:focus,
input[type="time"]:focus,
textarea:focus,
select:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(209, 0, 0, 0.1);
  outline: none;
  transform: scale(1.01);
}

input[type="radio"] {
  margin-right: 8px;
  accent-color: var(--primary);
}

input[type="submit"],
button[type="submit"] {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: white;
  padding: 14px 30px;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
  box-shadow: 0 8px 25px rgba(209, 0, 0, 0.3);
  position: relative;
  overflow: hidden;
}

input[type="submit"]:hover,
button[type="submit"]:hover {
  background: linear-gradient(135deg, var(--primary-dark), var(--primary));
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 12px 30px rgba(209, 0, 0, 0.4);
}

input[type="submit"]::after,
button[type="submit"]::after {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    to bottom right,
    rgba(255, 255, 255, 0) 0%,
    rgba(255, 255, 255, 0) 45%,
    rgba(255, 255, 255, 0.5) 48%,
    rgba(255, 255, 255, 0.8) 50%,
    rgba(255, 255, 255, 0.5) 52%,
    rgba(255, 255, 255, 0) 57%,
    rgba(255, 255, 255, 0) 100%
  );
  transform: translateX(-100%) rotate(30deg);
  transition: all 0.6s ease;
}

input[type="submit"]:hover::after,
button[type="submit"]:hover::after {
  animation: shine 1.5s ease infinite;
}

@keyframes shine {
  100% {
    transform: translateX(100%) rotate(30deg);
  }
}

/* Floating elements animation */
.floating {
  animation: float 6s ease-in-out infinite;
}

.floating-2 {
  animation: float 6s ease-in-out infinite 2s;
}

.floating-3 {
  animation: float 6s ease-in-out infinite 4s;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
  .sidebar {
    width: 240px;
  }
}

@media (max-width: 992px) {
  .main {
    flex-direction: column;
  }
  .sidebar {
    width: 100%;
    padding: 20px;
  }
  .content {
    padding: 25px;
  }
}

@media (max-width: 768px) {
  .navbar {
    padding: 20px 25px;
  }
  .navbar .logo {
    font-size: 22px;
  }
  table {
    font-size: 14px;
  }
  th, td {
    padding: 12px 8px;
  }
}
    .popup {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.7);
    }
    .popup-content {
      position: relative;
      margin: 10% auto;
      padding: 20px;
      width: 60%;
      background: white;
      border-radius: 10px;
      text-align: center;
    }
    .popup-content img {
      max-width: 100%;
      height: auto;
    }
    .close {
      position: absolute;
      top: 10px; right: 20px;
      font-size: 20px;
      cursor: pointer;
      color: #333;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="logo"><i class="fas fa-film"></i> AZFATICKET.XXI</div>
  <div class="profile-container">
  <div class="profile-logo" id="profileLogo">
    <img src="userputih.jpg" alt="Profile">
  </div>
  <div class="profile-dropdown" id="profileDropdown">
    <ul>
      <a href="logout.php"><li class="logout">Logout</li></a>
    </ul>
    </div>
  </div>
</div>

  <!-- Main Area -->
  <div class="main">
    <!-- Sidebar -->
    <div class="sidebar">
      <h3><i class="fas fa-sliders-h"></i> MANAJEMEN AZFA</h3>
      <button onclick="showSection('dashboard')"><i class=" fas fa-solid fa-table-columns"></i> DASHBOARD</button>
      <button onclick="showSection('dashboard movie')"><i class="fas fa-tachometer-alt"></i> DATA MOVIE</button>
      <button onclick="showSection('transaksi')"><i class="fas fa-receipt"></i> DATA TRANSAKSI</button>      
      <button onclick="showSection('dashboard bookings')"><i class="fas fa-calendar-check"></i> DATA BOOKINGS</button>
      <button onclick="showSection('daftar verifikasi')"><i class="fas fa-solid fa-user-check"></i> Daftar Verifikasi</button>
      <button onclick="showSection('management artis')" ><i class="fas fa-solid fa-circle-user"></i>Management Artis</button>
      <button onclick="showSection('movie')"><i class="fas fa-film"></i> Management Movie</button>
      <button onclick="showSection('jadwal')"><i class="fas fa-clock"></i> Management Jadwal</button>
      
      
    </div>

    <!-- Content Area -->
    <div class="content">
      <div id="dashboard" class="section active">
        <h1><i class=" fas fa-solid fa-table-columns"></i> DASHBOARD</h1>
        <table>
          <form action="admin_azfa.php" method="post" id="formBulan">
            <label for="">Pilih Bulan Data Penjualan</label>
            <input type="month" name="bulan" id="bulan">
          </form>
          <script>
            // Saat input bulan berubah, submit form otomatis
            document.getElementById("bulan").addEventListener("change", function () {
              document.getElementById("formBulan").submit();
            });
          </script>
          <h2>Data Penjualan Pada Bulan Ke-<?= $bulan ?></h2>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Jumlah Penjualan</th>
            <th>Subtotal Penjualan</th>
          </tr>
          <?php 
            while($join = mysqli_fetch_assoc($query7)){
              $title = $join['title'];
              $id_movies = $join['id_movies'];
              $sql8 = "SELECT SUM(p.amount) AS total_amount, COUNT(b.id_bookings) AS jumlah_pnj FROM payments p JOIN bookings b ON p.id_payments = b.id_payments WHERE b.status = 'terverifikasi' AND b.id_movies = $id_movies AND MONTH(p.payment_date) = $bulan";
              $query8 = mysqli_query($koneksi,$sql8);
              $data = mysqli_fetch_assoc($query8);
              $subtotal = $data['total_amount'];
              $jumlah_pnj = $data['jumlah_pnj'];
              $total += $subtotal;
              $total_jumlah += $jumlah_pnj;

          ?>
          <tr>
            <td><?= $no ?></td>
            <td><?= $title ?></td>
            <td><?= $jumlah_pnj ?></td>
            <td><?= $subtotal ?></td>
          </tr>
          <?php $no+= 1; } ?>
          <tr>
            <td>--------------</td>
            <td>--------------</td>
            <td>--------------</td>
            <td>-----------------------------------</td>
          </tr>
          <tr>
            <th></th>
            <th>JUMLAH</th>
            <th><?= $total_jumlah ?></th>
            <th><?= $total ?></th>
          </tr>
        </table><br>

        <table>
          <h2>Peringkat Film dengan Peminat Terbanyak</h2>
          <tr>
            <th>Peringkat</th>
            <th>Judul</th>
            <th>Genre</th>
            <th>Jumlah Peminat</th>
          </tr>
          <?php while($rank = mysqli_fetch_assoc($query10)){ ?>
            <tr>
              <td><?= $ranking ?></td>
              <td><?= $rank['title'] ?></td>
              <td><?= $rank['genre'] ?></td>
              <td><?= $rank['total_booking'] ?></td>
            </tr>
          <?php $ranking += 1; } ?>
        </table>

      </div>
      <div id="transaksi" class="section">
        <h1><i class="fas fa-receipt"></i> DATA TRANSAKSI</h1>
        <table>
          <tr>
            <th>Id Transaksi</th>
            <th>Id User</th>
            <th>Total Harga</th>
            <th>Metode Pembayaran</th>
            <th>Bukti Transaksi</th>
            <th>Tanggal Transaksi</th>
          </tr>
          <?php while($payments = mysqli_fetch_assoc($query6)){ ?>
            <tr>
              <td><?= $payments['id_payments'] ?></td>
              <td><?= $payments['id_users'] ?></td>
              <td><?= $payments['amount'] ?></td>
              <td><?= $payments['mtd_payments'] ?></td>
              <td><a href="#" onclick="showPopup('bukti_pembayaran/<?= $payments['mtd_image'] ?>')" style="background: linear-gradient(135deg, #f44336, #c62828); color: white;"><i class="fas fa-regular fa-eye"></i>View</a></td>
              <td><?= $payments['payment_date'] ?></td>
            </tr>
          <?php } ?>
        </table>
        <div id="imagePopup" class="popup" onclick="hidePopup()">
          <div class="popup-content" onclick="event.stopPropagation()">
            <span class="close" onclick="hidePopup()">&times;</span>
            <img id="popupImg" src="" alt="Gambar">
          </div>
        </div>

        <script>
          function showPopup(src) {
            document.getElementById('popupImg').src = src;
            document.getElementById('imagePopup').style.display = 'block';
          }

          function hidePopup() {
            document.getElementById('imagePopup').style.display = 'none';
          }
        </script>
      </div>

      <div id="dashboard movie" class="section">
        <h1><i class="fas fa-tachometer-alt"></i> DATA MOVIE</h1>
        <table>
            <tr>
                <th>Id Movies</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Description</th>
                <th>Tanggal Release</th>
                <th>Durasi</th>
                <th>Gambar</th>
                <th>Max Tayang</th>
                <th>Aksi</th>
            </tr>
            <?php while($movies = mysqli_fetch_assoc($query2)){?>
            <tr>
                <td><?= $movies['id_movies']; ?></td>
                <td><?= $movies['title']; ?></td>
                <td><?= $movies['genre']; ?></td>
                <td><?= $movies['description']; ?></td>
                <td><?= $movies['release_date']; ?></td>
                <td><?= $movies['duration']; ?></td>
                <td><div class="iklan"><img src="movie/<?= $movies['poster_image'] ?>" ></div></td>
                <td><?= $movies['max_tayang']; ?></td>
                <td>
                  <a href="edit_movies.php?id=<?= $movies['id_movies']; ?>" style="background: linear-gradient(135deg, #2196F3, #0d47a1); color: white;"><i class="fas fa-edit"></i> Edit</a>
                  <a href="hapus_movies.php?id=<?= $movies['id_movies']; ?>" style="background: linear-gradient(135deg, #f44336, #c62828); color: white;"><i class="fas fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php }?>
        </table>
      </div>
      
      
      <div id="dashboard bookings" class ="section">
        <h1><i class="fas fa-calendar-check"></i> DATA BOOKINGS</h1>
        <table>
          <tr>
            <th>Id Bookings</th>
            <th>Id Users</th>
            <th>Seats Booked</th>
            <th>Total Price</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Id Movies</th>
            <th>Status</th>
          </tr>
          <?php while($booking = mysqli_fetch_assoc($query11)){?>
            <tr>
              <td><?= $booking['id_bookings']; ?></td>
              <td><?= $booking['id_users']; ?></td>
              <td><?= $booking['seats_booked']; ?></td>
              <td><?= $booking['total_price']; ?></td>
              <td><?= $booking['booking_date']; ?></td>
              <td><?= $booking['booking_time']; ?></td>
              <td><?= $booking['id_movies']; ?></td>
              <td><?= $booking['status']; ?></td>
            </tr>
          <?php }?>
        </table>

      </div>
      <div id="daftar verifikasi" class="section">
        <h1><i class="fas fa-solid fa-user-check"></i> DAFTAR VERIFIKASI</h1>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> Booking berhasil diverifikasi!
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['failed'])): ?>
          <div class="success-message">
            <i class="fas fa-check-circle"></i> Booking berhasil tertolak

          </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> Gagal memverifikasi booking!
            </div>
        <?php endif; ?>
        
        <table>
            <tr>
                <th>Id Bookings</th>
                <th>Id Users</th>
                <th>Seats Booked</th>
                <th>Total Price</th>
                <th>Booking date</th>
                <th>Booking Time</th>
                <th>Id Movies</th>
                <th>Aksi</th>
            </tr>
            <?php while($bookings = mysqli_fetch_assoc($query3)): ?>
            <tr>
                <td><?= htmlspecialchars($bookings['id_bookings']) ?></td>
                <td><?= htmlspecialchars($bookings['id_users']) ?></td>
                <td><?= htmlspecialchars($bookings['seats_booked']) ?></td>
                <td><?= number_format($bookings['total_price'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($bookings['booking_date']) ?></td>
                <td><?= htmlspecialchars($bookings['booking_time']) ?></td>
                <td><?= htmlspecialchars($bookings['id_movies']) ?></td>
                <td>
                    <a href="verifikasi_bookings.php?id=<?= $bookings['id_bookings'] ?>" class="verify-btn"><i class="fas fa-check"></i> Verifikasi</a>
                    <a href="tolak_bookings.php?id=<?= $bookings['id_bookings']?>" class="verify-btn"><i class="fas fa-solid fa-xmark"></i> Tolak</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
      </div>
      
      

      <div id="movie" class="section">
        <h1><i class="fas fa-film"></i> TAMBAH MOVIE BARU</h1>
        <form action="prs_tambah_movies.php" method="post" enctype="multipart/form-data">
            <label for="">Judul :</label>
            <input type="text" name="title" id="" placeholder="Masukkan judul film">
            
            <label for="">Genre :</label>
            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div>
                    <input type="radio" name="genre" id="horor" value="horor">
                    <label for="horor">Horor</label>
                </div>
                <div>
                    <input type="radio" name="genre" id="komedi" value="komedi">
                    <label for="komedi">Komedi</label>
                </div>
                <div>
                    <input type="radio" name="genre" id="romance" value="romance">
                    <label for="romance">Romance</label>
                </div>
            </div>
            
            <label for="">Description :</label>
            <textarea name="description" id="" cols="30" rows="5" placeholder="Deskripsi film"></textarea>
            
            <label for="">Tanggal Release :</label>
            <input type="date" name="release_date" id="">
            
            <label for="">Durasi :</label>
            <input type="time" name="duration" id="">
            
            <label for="">Poster Film :</label>
            <input type="file" name="poster_image" id="" accept=".jpg,.jpeg,.png">
            
            <label for="">Max Tayang :</label>
            <input type="date" name="max_tayang" id="">

            <label for="video">Pilih Video: </label>
            <input type="file" name="video" accept=".mp4" required>
            
            <input type="submit" value="Tambah Film" name="submit">
        </form>
      </div>
      
      <div id="jadwal" class="section">
        <h1><i class="fas fa-clock"></i> TAMBAH JADWAL</h1>
        <form action="admin_azfa.php" method="post" style="margin-bottom: 30px;">
            <label for="">Jumlah Jadwal</label>
            <input type="number" name="jumlah" id="" min="1" max="10">
            <input type="submit" value="Generate Form" style="margin-left: 15px;">
        </form>
        
        <form action="prs_tambah_jadwal.php" method="post">
            <?php while($jumlah >= 1){ ?>
                <div style="background: rgba(0,0,0,0.02); padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px dashed var(--border);">
                    <h3 style="color: var(--primary); margin-bottom: 15px; font-size: 16px;">Jadwal #<?= $jumlah ?></h3>
                    <label for="">Tanggal</label>
                    <input type="date" name="tanggal[]" id="">
                    
                    <label for="">Waktu</label>
                    <input type="time" name="waktu[]" id="">
                    
                    <label for="">Id Movies</label>
                    <select  name="id_movies[]" id="">
                    <?php
                      $sql4 = "SELECT id_movies FROM movies ";
                      $query4 = mysqli_query($koneksi,$sql4);
                      while($id = mysqli_fetch_assoc($query4)){
                    ?>
                      <option value="<?= $id['id_movies'] ?>"><?= $id['id_movies'] ?></option>
                    <?php } ?>
                    </select>
                    
                </div>
            <?php $jumlah -= 1;} ?>
            <input type="submit" value="Simpan Jadwal" name="tambah">
        </form>
      </div>
      
      <div id="management artis" class="section">
        <h1><i class="fas fa-solid fa-circle-user"></i> Management Artis</h1>
        <div class="tab-pane fade" id="managementArtis">
          <form action="admin_azfa.php" method="post" style="margin-bottom: 30px;">
            <label for="">Jumlah Form Artis</label>
            <input type="number" name="tokoh" id="" min="1" max="10">
            <input type="submit" value="Generate Form" style="margin-left: 15px;">
          </form>

          <form action="proses_tambah_artis.php" method="POST" enctype="multipart/form-data">
            <?php while($tokoh >= 1){ ?>
            <div style="background: rgba(0,0,0,0.02); padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px dashed var(--border);">
              <h3 style="color: var(--primary); margin-bottom: 15px; font-size: 16px;">Artis #<?= $tokoh ?></h3>
              <div class="mb-3">
                  <label for="nama" class="form-label">Nama Artis</label>
                  <input type="text" class="form-control" id="nama" name="nama[]" required>
              </div>
              <div class="mb-3">
                  <label for="gambar" class="form-label">Gambar Artis</label>
                  <input type="file" class="form-control" id="gambar" name="gambar[]" accept=".jpg,.jpeg,.png" required>
              </div>
              <div class="mb-3">
                  <label  class="form-label">ID Movies</label>
                  <select  name="id_movies[]" id="">
                    <?php
                      $sql5 = "SELECT id_movies FROM movies ";
                      $query5 = mysqli_query($koneksi,$sql5);
                      while($id = mysqli_fetch_assoc($query5)){
                    ?>
                      <option value="<?= $id['id_movies'] ?>"><?= $id['id_movies'] ?></option>
                    <?php } ?>
                    </select>
              </div>
            </div>
            <?php $tokoh -= 1;} ?>
              <button type="submit" class="btn btn-primary">Tambah Artis</button>
          </form>
        </div>

      </div>

      
      
      
    </div>
  </div>

  <script>
    document.getElementById('profileLogo').addEventListener('click', function() {
  document.getElementById('profileDropdown').classList.toggle('active');
});

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('profileDropdown');
  const logo = document.getElementById('profileLogo');
  if (!logo.contains(event.target) && !dropdown.contains(event.target)) {
    dropdown.classList.remove('active');
  }
});
    // MODIFIED JAVASCRIPT SECTION
function showSection(id) {
  const sections = document.querySelectorAll('.section');
  sections.forEach(section => {
    section.style.animation = 'fadeOut 0.5s ease forwards';
    setTimeout(() => {
      section.classList.remove('active');
      section.style.opacity = 0;
      section.style.transform = 'translateY(20px) scale(0.98)';
    }, 200);
  });
  
  const activeSection = document.getElementById(id);
  setTimeout(() => {
    activeSection.classList.add('active');
    activeSection.style.animation = 'fadeIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.1) forwards';
    activeSection.style.opacity = 1;
    activeSection.style.transform = 'translateY(0) scale(1)';
    
    // Add floating animation to elements inside the active section
    const tables = activeSection.querySelectorAll('table');
    const forms = activeSection.querySelectorAll('form');
    const headings = activeSection.querySelectorAll('h1, h2, h3');
    
    tables.forEach((table, index) => {
      table.style.animationDelay = `${index * 0.1}s`;
      table.classList.add('floating');
    });
    
    forms.forEach((form, index) => {
      form.style.animationDelay = `${index * 0.1 + 0.2}s`;
      form.classList.add('floating-2');
    });
    
    headings.forEach((heading, index) => {
      heading.style.animationDelay = `${index * 0.1 + 0.1}s`;
      heading.classList.add('floating-3');
    });
  }, 250);
}

// Add fadeOut animation to CSS
document.head.insertAdjacentHTML('beforeend', `
  <style>
    @keyframes fadeOut {
      from { opacity: 1; transform: translateY(0) scale(1); }
      to { opacity: 0; transform: translateY(20px) scale(0.95); }
    }
  </style>
`);

// Initialize first section with animations
document.addEventListener('DOMContentLoaded', function() {
  const activeSection = document.querySelector('.section.active');
  if (activeSection) {
    activeSection.querySelectorAll('table, form, h1, h2, h3').forEach((el, index) => {
      el.style.animation = `fadeIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.1) forwards ${index * 0.1}s`;
      if (index % 3 === 0) el.classList.add('floating');
      else if (index % 3 === 1) el.classList.add('floating-2');
      else el.classList.add('floating-3');
    });
  }
});
  </script>
</body>
</html>