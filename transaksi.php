<?php
include "koneksi.php";
session_start();

if(!isset($_POST['id_movies']) || !isset($_POST['tanggal']) || !isset($_POST['waktu']) || !isset($_POST['kursi'])){
  header("location:jadwal_film.php");
}
unset($_SESSION['waktu']);
    unset($_SESSION['tanggal']);
    unset($_SESSION['id_movies']);
$id_movies = $_POST['id_movies'];
$sql = "SELECT * FROM movies WHERE id_movies = '$id_movies'";
$query = mysqli_query($koneksi, $sql);
$movies = mysqli_fetch_assoc($query);

$tanggal = $_POST['tanggal'];
$date = new DateTime($tanggal);

$hari = $date->format('l');
$tanggal_hari = $date->format('d');
$bulan = $date->format('F');
$tahun = $date->format('Y');
$nm_hari = [
    'Monday' => 'SENIN', 'Tuesday' => 'SELASA', 'Wednesday' => 'RABU', 'Thursday' => 'KAMIS',
    'Friday' => 'JUMAT', 'Saturday' => 'SABTU', 'Sunday' => 'MINGGU'
];
$array_hari = $nm_hari[$hari];
$nm_bulan =[
  'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
  'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];
$array_bulan = $nm_bulan[$bulan];
$waktu = $_POST['waktu'];
$time = new DateTime($waktu);


$jam = $time->format('H');
$menit = $time->format('i');


$kursi = $_POST['kursi']; 
$jumlah_kursi = count($kursi);
$total = 35000 * $jumlah_kursi + 3000;
    

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

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AZFATiCKET.XXI</title>
  <style>
      /* navbar dan body */
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


    .dropdown button:hover {
      background: linear-gradient(to right, #ff1744, #e53935);
      transform: scale(1.05);
    }

    .posisi {
      text-align: center;
    }
    .font {
      font-family: 'KeaniaOne';
      font-size: 29px;
      margin-top: 30px;
      color: #b12a2a;
      animation: textPop 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
    }
    
    @keyframes textPop {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    .border {
      width: 30%;
      margin: 5px auto;
      border: 1px solid #b12a2a;
      animation: widthGrow 1s ease-out 0.3s both;
    }
    
    @keyframes widthGrow {
        from { width: 0; }
        to { width: 30%; }
    }
    .ticket-container {
      display: flex;
      margin: 0 auto;
      width: 90%;
      max-width: 850px;
      background-color: white;
      border-radius: 12px;
      padding: 0;
      align-items: stretch;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      position: relative;
      overflow: hidden;
      animation: fadeIn 0.6s ease-out;
      margin-top: 90px;
      margin-bottom: 55px;
    }

    .poster {
      flex: 0 0 280px;
      background: #ff5a5a;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      transition: all 0.3s ease;
    }

    .poster img {
      width: 100%;
      border-radius: 8px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }

    .poster:hover img {
      transform: scale(1.03);
    }

    .ticket-info {
      flex: 1;
      padding: 30px;
      position: relative;
    }

    .ticket-info::before {
      content: "";
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      height: 70%;
      width: 1px;
      background: linear-gradient(to bottom, transparent, #ddd, transparent);
    }

    .ticket-info h2 {
      font-family: 'Montserrat', sans-serif;
      color: #ff2e63;
      font-size: 1.8rem;
      margin: 0 0 10px 0;
      font-weight: 700;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .ticket-info h3 {
      font-family: 'Montserrat', sans-serif;
      margin: 0 0 20px 0;
      font-size: 1.8rem;
      color: #333;
      font-weight: 600;
      position: relative;
      display: inline-block;
    }

    .ticket-info h3::after {
      content: "";
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 50px;
      height: 3px;
      background: #ff5a5a;
      border-radius: 3px;
    }

    .ticket-info p {
      margin: 12px 0;
      color: #555;
      font-size: 1rem;
      display: flex;
    }

    .ticket-info p strong {
      color: #333;
      font-weight: 600;
    }

    hr {
      border: none;
      height: 1px;
      background: linear-gradient(to right, transparent, #eee, transparent);
      margin: 20px 0;
    }

    .transaction-details {
      margin-top: 25px;
      animation: slideUp 0.5s ease-out 0.2s both;
    }

    .transaction-details p {
      margin: 12px 0;
      display: flex;
      justify-content: space-between;
      font-size: 1rem;
    }

    .transaction-details .total {
      margin-top: 20px;
      padding-top: 15px;
      border-top: 1px dashed #ddd;
      font-weight: 700;
      color: #ff2e63;
      font-size: 1.2rem;
    }

    button {
      background: linear-gradient(90deg, #ff2e63, #ff5a5a);
      color: white;
      padding: 14px 30px;
      border: none;
      margin-top: 25px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      letter-spacing: 0.5px;
      font-family: 'Montserrat', sans-serif;
      box-shadow: 0 4px 15px rgba(255, 46, 99, 0.3);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    button::after {
      content: "";
      position: absolute;
      top: 50%;
      left: 50%;
      width: 5px;
      height: 5px;
      background: rgba(255,255,255,0.5);
      opacity: 0;
      border-radius: 100%;
      transform: scale(1, 1) translate(-50%);
      transform-origin: 50% 50%;
    }

    button:focus:not(:active)::after {
      animation: ripple 1s ease-out;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 46, 99, 0.4);
    }

    button:active {
      transform: translateY(1px);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes ripple {
      0% {
        transform: scale(0, 0);
        opacity: 1;
      }
      20% {
        transform: scale(25, 25);
        opacity: 1;
      }
      100% {
        opacity: 0;
        transform: scale(40, 40);
      }
    }

    /* === TAMBAHAN UNTUK UPLOAD BUKTI === */
    .payment-method {
      margin-top: 20px;
      padding: 15px;
      background: #fff9f9;
      border-radius: 10px;
      border: 1px solid #ffebee;
    }
    
    .payment-option {
      display: flex;
      align-items: center;
      margin: 10px 0;
      padding: 10px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .payment-option:hover {
      background: #ffebee;
    }
    
    .payment-option input {
      margin-right: 10px;
    }
    
    .payment-option img {
      width: 40px;
      margin-right: 15px;
    }
    
    .upload-section {
      margin-top: 20px;
      display: none;
    }
    
    .upload-container {
      border: 2px dashed #c62828;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .upload-container:hover {
      background: #ffebee;
    }
    
    .upload-icon {
      font-size: 40px;
      color: #c62828;
      margin-bottom: 10px;
    }
    
    .upload-text {
      color: #c62828;
      font-weight: 600;
    }
    
    .upload-hint {
      color: #e57373;
      font-size: 14px;
      margin-top: 5px;
    }
    
    #proof-preview {
      max-width: 100%;
      max-height: 200px;
      margin-top: 15px;
      display: none;
      border-radius: 8px;
    }
    
    #file-input {
      display: none;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .ticket-container {
        flex-direction: column;
      }
      
      .poster {
        flex: none;
        width: 100%;
        padding: 15px;
      }
      
      .ticket-info::before {
        display: none;
      }
      
      .ticket-info h2 {
        font-size: 1.6rem;
      }
      
      .ticket-info h3 {
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
                <a href="keranjang.php"><button>keranjang</button></a>
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

  <main class="ticket-container">
    <div class="poster">
      <img src="movie/<?= $movies['poster_image'] ?>" alt="">
    </div>
    <div class="ticket-info">
      <h2>AZFATiCKET.XXI</h2>
      <h3><?= strtoupper($movies['title'])?></h3>
      <p><strong>BIOSKOP: </strong> CINEMA XXI AZFA</p>
      <p><strong>TANGGAL: </strong> <?= ucfirst($array_hari) ?>, <?= $tanggal_hari ?> <?= $array_bulan ?> <?= $tahun ?></p>
      <p><strong>JAM:</strong> <?= $jam ?>.<?= $menit ?> WIB</p>
      <hr />
      <div class="transaction-details">
        <p><strong>Detail Transaksi</strong></p>
        <p><span><?= $jumlah_kursi ?> Tiket (<?php foreach ($kursi as $nomor) {
            $array_kursi = "{$nm_kursi[$nomor]}";
            if($i !== 1){
                echo ", ";
            }
            $i += 1;

            echo htmlspecialchars($array_kursi);
        } ?>)</span> <span>Rp. 35.000 x <?= $jumlah_kursi ?></span></p>
        <p><span>Layanan</span> <span>Rp. 3.000</span></p>
        <p class="total"><span>Total Pembayaran:</span> <span>Rp. <?= $total ?></span></p>
      </div>
      
      <!-- TAMBAHAN FORM UPLOAD BUKTI PEMBAYARAN -->
      <form action="proses_transaksi.php" method="post" enctype="multipart/form-data">
        <?php foreach($kursi as $input){ ?>
          <input type="hidden" name="kursi[]" value="<?= $input ?>">
        <?php } ?>
        <input type="hidden" name="id_movies" value="<?= $id_movies ?>">
        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
        <input type="hidden" name="waktu" value="<?= $waktu ?>">
        <input type="hidden" name="total" value="<?= $total ?>">
        
        <div class="payment-method">
          <h3>Metode Pembayaran</h3>
          
          <div class="payment-option" onclick="selectPayment('bca')">
            <input type="radio" name="payment_method" value="bca" id="bca" required>
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" alt="BCA">
            <label for="bca">Transfer BCA</label>
          </div>
          
          <div class="payment-option" onclick="selectPayment('mandiri')">
            <input type="radio" name="payment_method" value="mandiri" id="mandiri">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1200px-Bank_Mandiri_logo_2016.svg.png" alt="Mandiri">
            <label for="mandiri">Transfer Mandiri</label>
          </div>
          
          <div class="payment-option" onclick="selectPayment('dana')">
            <input type="radio" name="payment_method" value="dana" id="dana">
            <img src="https://enimekspres.disway.id/upload/482ef763296282fb93275e0fd7365a04.jpg" alt="DANA">
            <label for="dana">DANA</label>
          </div>
          
          <div class="upload-section" id="upload-section">
            <h3>Upload Bukti Pembayaran</h3>
            <div class="upload-container" onclick="document.getElementById('file-input').click()">
              <div class="upload-icon">📤</div>
              <div class="upload-text">Klik untuk upload bukti pembayaran</div>
              <div class="upload-hint">Format: JPG, PNG (Maks. 2MB)</div>
              <img id="proof-preview" src="#" alt="Preview Bukti Pembayaran">
            </div>
            <input type="file" id="file-input" name="payment_proof" accept=".jpg,.jpeg,.png" onchange="previewImage(this)" required>
          </div>
        </div>

        <button type="submit">KONFIRMASI PEMBAYARAN</button>
      </form>
      
    </div>
  </main>

  <script>
    // Fungsi untuk menampilkan section upload setelah memilih metode pembayaran
    function selectPayment(method) {
      document.getElementById('upload-section').style.display = 'block';
    }
    
    // Fungsi untuk preview gambar yang diupload
    function previewImage(input) {
      const preview = document.getElementById('proof-preview');
      const file = input.files[0];
      
      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
          document.querySelector('.upload-text').textContent = file.name;
          document.querySelector('.upload-icon').textContent = '✓';
        }
        
        reader.readAsDataURL(file);
      }
    }
  </script>
  
</body>
</html>