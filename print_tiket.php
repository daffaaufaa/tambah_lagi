<?php
include "koneksi.php";
session_start();
$kursi = $_POST['kursi'];

$waktu= $_POST['waktu'];
$tanggal = $_POST['tanggal'];
$total = $_POST['total'];

$id_movies = $_POST['id_movies'];
$sql = "SELECT * FROM movies WHERE id_movies = '$id_movies'";
$query = mysqli_query($koneksi, $sql);
$movies = mysqli_fetch_array($query);

$waktu= $_POST['waktu'];
$time = new DateTime($waktu);
$jam = $time->format('H');
$menit = $time->format('i');

$tanggal = $_POST['tanggal'];
$date = new DateTime($tanggal);

$tanggal_hari = $date->format('d');
$bulan = $date->format('M');
$tahun = $date->format('Y');

$total = $_POST['total'];

$kursi = $_POST['kursi'];
$nm_kursi = [
    '1' => 'A1', '2' => 'A2', '3' => 'A3', '4' => 'A4', '5' => 'A5', '6' => 'A6', '7' => 'A7', '8' => 'A8', '9' => 'A9', '10' => 'A10',
     '11' => 'A11', '12' => 'A12', '13' => 'B1', '14' => 'B2', '15' => 'B3', '16' => 'B4', '17' => 'B5', '18' => 'B6', '19' => 'B7', '20' => 'B8', 
     '21' => 'B9', '22' => 'B10', '23' => 'B11', '24' => 'B12', '25' => 'B13' , '26' => 'B14', '27' => 'C1', '28' => 'C2', '29' => 'C3',
     '30' => 'C4', '31' => 'C5', '32' => 'C6', '33' => 'C7', '34' => 'C8', '35' => 'C9', '36' => 'C10', '37' => 'C11', '38' => 'C12',
     '39' => 'D1', '40' => 'D2', '41' => 'D3', '42' => 'D4', '43' => 'D5', '44' => 'D6', '45' => 'D7', '46' => 'D8', '47' => 'D9', 
     '48' => 'D10', '49' => 'D11', '50' => 'E1', '51' => 'E2', '52' => 'E3', '53' => 'E4', '54' => 'E5', '55' => 'E6', '56' => 'E7', 
     '57' => 'E8', '58' => 'E9', '59' => 'E10', '60' => 'E11' , '61' => 'E12', '62' => 'E13'
];


$i = 1;
if($movies['genre']=='horor'){
  $g = 1;
}elseif($movies['genre']=='komedi'){
  $g = 2;
}else{
  $g = 3;
}

$username = $_SESSION['username'];
$sql2 = "SELECT * FROM users WHERE username='$username'";
$query2 = mysqli_query($koneksi,$sql2);
$users = mysqli_fetch_assoc($query2);

$id_bookings = $_POST['id_bookings'];
$f = 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cetak Tiket - AZFATiCKET.XXI</title>
  <style>
    /* === BASE STYLES === */
    body {
      margin: 0;
      padding: 0;
      background-color: #f9f3f3; /* Lighter red tint background */
      font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    * {
      box-sizing: border-box;
    }
    
    /* === NAVIGATION LINK STYLES === */
    a {
      margin: 30px 18px 0;
      text-decoration: none;
      color: #c62828;
      font-weight: 700;
      font-size: 18px;
      position: relative;
      transition: all 0.4s ease;
      display: inline-block;
      padding: 5px 10px;
    }
    
    a:hover {
      transform: translateY(-3px);
      color: #8e0000;
      text-shadow: 0 2px 5px rgba(198, 40, 40, 0.2);
    }
    
    a::after {
      content: '';
      display: block;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #c62828, #8e0000);
      transition: width 0.3s;
      position: absolute;
      bottom: 0;
      left: 0;
    }
    
    a:hover::after {
      width: 100%;
    }
    
    /* === TICKET CONTAINER STYLES === */
    .ticket-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin: 20px 0 40px;
      perspective: 1000px;
      width: 100%;
    }
    
    /* === MAIN TICKET CARD STYLES === */
    .ticket-card {
      width: 340px;
      background: white;
      color: #333;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(198, 40, 40, 0.15);
      text-align: center;
      position: relative;
      overflow: hidden;
      transform-style: preserve-3d;
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      animation: ticketAppear 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
      border: none;
    }
    
    .ticket-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #c62828 0%, #8e0000 50%, #c62828 100%);
      z-index: 2;
    }
    
    .ticket-card::after {
      content: '';
      position: absolute;
      top: 6px;
      left: 0;
      right: 0;
      height: 60px;
      background: linear-gradient(180deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 100%);
      z-index: 1;
    }
    
    .ticket-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 15px 40px rgba(198, 40, 40, 0.25);
    }
    
    .ticket-card h2 {
      font-weight: 800;
      font-size: 26px;
      margin: 10px 0 15px;
      color: #c62828;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      position: relative;
      display: inline-block;
      z-index: 3;
    }
    
    .ticket-card h2::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 2px;
      background: linear-gradient(90deg, #c62828 0%, #8e0000 100%);
      border-radius: 2px;
    }
    
    /* === POSTER STYLES === */
    .poster {
      height: 220px; /* Reduced height */
      margin: 10px 0 20px;
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      transition: all 0.5s ease;
      z-index: 3;
      border: 1px solid rgba(198, 40, 40, 0.1);
    }
    
    .poster:hover {
      transform: scale(1.01);
      box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }
    
    .poster img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 8px;
      display: block;
      transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .poster:hover img {
      transform: scale(1.03);
    }
    
    /* === MOVIE TITLE STYLES === */
    .ticket-card h3 {
      font-size: 18px;
      margin: 15px 0 8px;
      color: #222;
      font-weight: 700;
      z-index: 3;
    }
    
    .ticket-card .genre {
      font-weight: 600;
      color: #c62828;
      text-transform: capitalize;
      letter-spacing: 0.5px;
    }
    
    .subtext {
      font-size: 0.75em;
      color: #888;
      margin-bottom: 15px;
      font-style: italic;
      letter-spacing: 0.3px;
      z-index: 3;
    }
    
    /* === TICKET DETAILS GRID === */
    .ticket-details {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      font-size: 0.85em;
      text-align: left;
      margin-bottom: 15px;
      z-index: 3;
    }
    
    .ticket-details div {
      padding: 10px;
      background: rgba(255, 255, 255, 0.7);
      border-radius: 6px;
      transition: all 0.4s ease;
      backdrop-filter: blur(2px);
      border: 1px solid rgba(198, 40, 40, 0.1);
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .ticket-details div:hover {
      background: rgba(255, 255, 255, 0.9);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(198, 40, 40, 0.1);
    }
    
    .ticket-details strong {
      display: block;
      color: #c62828;
      margin-bottom: 5px;
      font-size: 0.8em;
      letter-spacing: 0.5px;
    }
    
    /* === DIVIDER STYLES === */
    hr {
      margin: 15px 0;
      border: none;
      height: 1px;
      background: linear-gradient(90deg, transparent 0%, rgba(198, 40, 40, 0.3) 20%, rgba(198, 40, 40, 0.3) 80%, transparent 100%);
      position: relative;
      z-index: 3;
    }
    
    /* === PREMIUM BARCODE STYLES === */
    .barcode {
      width: 100%;
      height: 60px;
      background: white;
      position: relative;
      margin: 15px 0 5px;
      border: 1px solid rgba(198, 40, 40, 0.1);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      border-radius: 4px;
      z-index: 3;
    }
    
    .barcode::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: 
        /* Barcode pattern */
        repeating-linear-gradient(90deg, 
          #000, #000 2px, 
          transparent 2px, transparent 4px),
        /* Glossy overlay */
        linear-gradient(180deg, 
          rgba(255,255,255,0.7) 0%, 
          rgba(255,255,255,0.2) 50%, 
          rgba(255,255,255,0) 100%);
    }
    
    .barcode::after {
      content: 'AZFA BIOSKOP MALL XXI';
      position: absolute;
      bottom: 5px;
      font-size: 9px;
      letter-spacing: 3px;
      color: #c62828;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    /* Subtle shine animation */
    @keyframes barcodeShine {
      0% { background-position: -100px 0; }
      100% { background-position: 100px 0; }
    }
    
    .barcode:hover::before {
      animation: barcodeShine 1.5s ease-in-out;
    }
    
    /* === PRINT BUTTON STYLES === */
    button {
      margin-top: 25px;
      background: linear-gradient(135deg, #c62828 0%, #8e0000 100%);
      color: white;
      font-weight: 700;
      padding: 12px 35px;
      border: none;
      border-radius: 30px;
      font-size: 0.9rem;
      cursor: pointer;
      box-shadow: 0 5px 20px rgba(198, 40, 40, 0.3);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      letter-spacing: 0.5px;
      z-index: 3;
    }
    
    button:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 8px 25px rgba(198, 40, 40, 0.4);
    }
    
    button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, 
        transparent, 
        rgba(255,255,255,0.3), 
        transparent);
      transition: 0.6s;
    }
    
    button:hover::before {
      left: 100%;
    }
    
    /* === PREMIUM ANIMATIONS === */
    @keyframes ticketAppear {
      0% { 
        opacity: 0;
        transform: translateY(30px) rotateX(15deg);
      }
      100% { 
        opacity: 1;
        transform: translateY(0) rotateX(0);
      }
    }
    
    /* === PRINT SPECIFIC STYLES === */
    @media print {
      .navbar, button {
        display: none;
      }
    
      .ticket-wrapper {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    
      .ticket-card {
        box-shadow: none;
        border: 1px solid #ddd;
        transform: none !important;
        animation: none;
        height: auto;
      }
    
      body {
        background-color: white;
      }
    
      .ticket-card::before {
        height: 6px;
      }
    
      .barcode::before {
        animation: none;
      }
      
      .poster {
        height: 200px;
      }
    }
  </style>
</head>
<body>
  <a href="home.php">MOVIE</a>

  <main class="ticket-wrapper">
    <div class="ticket-card" id="ticket">
      <h2>TICKET</h2>
      <div class="poster"><img  src="movie\<?= $movies['poster_image']?>" alt=""></div>
      <h3><?= strtoupper($movies['title']) ?> - <span class="genre"><?= $movies['genre'] ?></span></h3>
      <p class="subtext">Show this ticket at the entrance</p>

      <div class="ticket-details">
        <div>
          <strong>CINEMA</strong><br>AZFA BIOSKOP MALL XXI
        </div>
        <div>
          <strong>DATE</strong><br><?= $tanggal_hari ?> <?= $bulan ?> <?= $tahun ?>
        </div>
        <div>
          <strong>TIMER</strong><br><?= $jam ?>:<?= $menit ?>
        </div>
        <div>
          <strong>STUDIO</strong><br><?= $g ?>
        </div>
        <div>
          <strong>SEAT</strong><br><?php foreach ($kursi as $nomor) {
            $array_kursi = "{$nm_kursi[$nomor]}";
            if($i !== 1){
                echo ", ";
            }
            $i += 1;

            echo htmlspecialchars($array_kursi);
        } ?>
        </div>
        <div>
          <strong>COST</strong><br>Rp. <?= $total ?>
        </div>
        <div>
          <strong>ID ORDER</strong><br><?php foreach ($id_bookings as $id) {
          
            if($i !== 1){
                echo ", ";
            }
            $i += 1;

            echo htmlspecialchars($id);
        }?>
        </div>
      </div>

      <hr />
      <div class="barcode"></div>
    </div>

    <button onclick="window.print()">PRINT</button>
  </main>
</body>
</html>