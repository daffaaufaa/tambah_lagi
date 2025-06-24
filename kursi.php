<?php
include "koneksi.php";
session_start();
if(!isset($_SESSION['username'])){
  header("location:login.php");
}
if(!isset($_POST['id_movies']) || !isset($_POST['tanggal']) || !isset($_POST['waktu'])){
  header("location:jadwal_film.php");
}

$waktu = $_POST['waktu'];
$tanggal = $_POST['tanggal'];

$id_movies = $_POST['id_movies'];
$sql = "SELECT * FROM movies WHERE id_movies = '$id_movies'";
$query = mysqli_query($koneksi, $sql);

$date = new DateTime($tanggal);

$bulan = $date->format('F'); 
$nm_bulan =[
  'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
  'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];
$array_bulan = $nm_bulan[$bulan];
$tanggal_hari = $date->format('d'); 
$nama_hari = $date->format('l'); 
$nm_hari = [
    'Monday' => 'SENIN', 'Tuesday' => 'SELASA', 'Wednesday' => 'RABU', 'Thursday' => 'KAMIS',
    'Friday' => 'JUMAT', 'Saturday' => 'SABTU', 'Sunday' => 'MINGGU'
];
$array_hari = $nm_hari[$nama_hari];

$i = 1;
$a = 1;
$b = 1;
$c = 1;
$d = 1;
$e = 1;

$sql2 = "SELECT seats_booked FROM bookings WHERE id_movies = '$id_movies' AND booking_date = '$tanggal' AND booking_time = '$waktu'";
$query2 = mysqli_query($koneksi,$sql2);

while($row = mysqli_fetch_array($query2)){
    $seats_booked[] = $row['seats_booked'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* navbar dan body */
    @font-face {
      src: url('font/KeaniaOne.ttf') format('truetype');
      font-family: 'KeaniaOne';
      font-weight: normal;
      font-style: normal;
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
    /* .profile-icon {
      width: 45px;
      height: 45px;
      background-image: url('userputih.jpg');
      background-size: cover;
      border-radius: 50%;
      border: 2px solid white;
    } */


    .posisi {
      text-align: center;
    }
    .font {
      font-family: 'KeaniaOne';
      font-size: 29px;
      margin-top: 30px;
      color: #b12a2a;
    }
    .border {
      width: 30%;
      margin: 5px auto;
      border: 1px solid #b12a2a;

    }

    .judul {
      margin-top: 20px;
      color:rgba(0, 0, 0, 0.69);
    }

    .judul .kecil{
      font-size: 15px;
    }

    /* kursi */
    .box {
      display: inline-block;
      padding: 15px;
      background-repeat: no-repeat;
      background-size: cover;
      color: white;
      margin-top: 30px
    }

    .background {
            margin-left: 220px;
            background-color: #fff4f4;
            width: 1125px;
            height: 350px;
            border-radius: 15px;
            padding: 20px;
        }
        .posisi2{
            display: flex;
            flex-direction: column;
            gap: 17px;
            margin-top: 30px;
            
        }
        .posisi2 label{
            cursor: default;  
            padding: 7px 12px;
            width: 35px;
            
        }
        
         input[type="checkbox"]:checked + label {
            background-color: red;
            color: white;
            border: 2px solid #cccccc;
        }
         label {
            padding: 7px 12px;
            border: 2px solid #cccccc;
            border-radius: 5px;
            cursor: pointer;
            background-color:rgb(255, 255, 255);
            color:rgb(0, 0, 0);
            transition: all 0.2s ease-in-out;
            font-weight: bold;
            
            margin-left: 10px;
        }
        input[type="checkbox"] {
            display: none;
        }

        .A1 {
            position: absolute;
            left: 440px;
            top: 330px;
        }

        .A2 {
            position: absolute;
            left: 773px;
            top: 330px;
        }

        .B1 {
            position: absolute;
            left: 391px;
            top: 385px;
        }

        .B2 {
            position: absolute;
            left: 773px;
            top: 385px;
        }

        .C1 {
            position: absolute;
            left: 391px;
            top: 439px;
        }

        .C2 {
            position: absolute;
            left: 773px;
            top: 439px;
        }

        .D1 {
            position: absolute;
            left: 440px;
            top: 493px;
        }

        .D2 {
            position: absolute;
            left: 773px;
            top: 493px;
        }

        .E1 {
            position: absolute;
            left: 391px;
            top: 546px;
        }

        .E2 {
            position: absolute;
            left: 773px;
            top: 546px;
        }
        
        input[type="checkbox"]:disabled + label {
            background-color: rgb(185, 41, 41);
            border: 2px solid #cccccc;
            color: white;
            cursor: default;
        }

        .kosong {
            padding: 7px 12px;
            border: 2px solid #cccccc;
            border-radius: 5px;
            width: 30px;
            height: 30px;
            position: absolute;
            left: 1200px;
            top: 355px;
            background-color: white;
            
        }
        .tempat1 {
            color: black;
            font-weight: bold;
            font-size: 18px;
            position: absolute;
            left: 1250px;
            top: 360px;
        }

        .memilih {
            padding: 7px 12px;
            background-color: red;
            border: 2px solid #cccccc;
            border-radius: 5px;
            width: 30px;
            height: 30px;
            position: absolute;
            left: 1200px;
            top: 420px;
            
        }
        .tempat2 {
            color: black;
            font-weight: bold;
            font-size: 18px;
            position: absolute;
            left: 1250px;
            top: 425px;
        }

        .terbooking {
            padding: 7px 12px;
            background-color: rgb(185, 41, 41);
            border: 2px solid rgb(255, 255, 255);
            border-radius: 5px;
            width: 30px;
            height: 30px;
            position: absolute;
            left: 1200px;
            top: 490px;
            
        }
        .tempat3 {
            color: black;
            font-weight: bold;
            font-size: 18px;
            position: absolute;
            left: 1250px;
            top: 495px;
        }

        input[type="submit"] {
            width: 300px;
            height: 60px;
            margin-left: 370px;
            border-radius: 20px;
            border: none;
            background: #DD4444;
            color: white;
            font-size: 25px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 90px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <!-- header -->
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

  <div class="posisi">
    <h3 class="font">PICK SEATS</h3>
    <hr class="border">
  
    <div class="judul">
      <h3><?= ucwords(mysqli_fetch_assoc($query)['title'])  ?></h3>
      <h3 class="kecil"><?= $tanggal_hari ?> <?= $array_bulan ?> - <?= ucfirst(strtolower($array_hari))   ?> - <?= $waktu ?></h3>
    </div>
  </div>
 

  <div class="box">
    <div class="background">
        <div class="posisi2">
            <label for="">A</label>
            <label for="">B</label>
            <label for="">C</label>
            <label for="">D</label>
            <label for="">E</label>
        </div>
        
        <form action="transaksi.php" method="post">
            <input type="hidden" name="id_movies" value="<?= $id_movies ?>">
            <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
            <input type="hidden" name="waktu" value="<?= $waktu ?>">

            <div class="A1">
            <?php while($i <= 62){?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $a ?></label>
                    
            <?php 
                if($a== 6){
                    break;
                }
                $i += 1;
                $a += 1;
            } ?>
            </div>

            <div class="A2">
            <?php while($i <= 62){
                if($a== 12){
                    $i += 1;
                    
                    break;
                }
                $i += 1;
                $a += 1;
                ?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $a ?></label>
                    
            <?php } ?>
            </div>


            <div class="B1">
            <?php while($i <= 62){?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $b ?></label>

            <?php 
                if($b== 7){
                    break;
                }
                $i += 1;
                $b += 1;
            } ?>
            </div>

            <div class="B2">
            <?php while($i <= 62){
                if($b== 14){
                    $i += 1;
                
                    break;
                }
                $i += 1;
                $b += 1;?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $b ?></label>
                
            <?php } ?>
            </div>

            <div class="C1">
            <?php while($i <= 62){?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $c ?></label>
               
            <?php 
                if($c== 7){
                    break;
                }
                $i += 1;
                $c += 1;
            } ?>
            </div>

            <div class="C2">
            <?php while($i <= 62){
                if($c== 12){
                    $i += 1;
                
                    break;
                }
                $i += 1;
                $c += 1;?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>" >
                    <label id= "<?= $i ?>" for="<?= $i ?>"><?= $c ?></label>
               
            <?php } ?>
            </div>

            <div class="D1">
            <?php while($i <= 62){?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $d ?></label>
                
            <?php 
                if($d== 6){
                    break;
                }
                $i += 1;
                $d += 1;
            } ?>
            </div>

            <div class="D2">
            <?php while($i <= 62){
                if($d== 11){
                    $i += 1;
                
                    break;
                }
                $i += 1;
                $d += 1;?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $d ?></label>
                
            <?php } ?>
            </div>

            <div class="E1">
            <?php while($i <= 62){?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $e ?></label>
                
            <?php 
                if($e== 7){
                    break;
                }
                $i += 1;
                $e += 1;
            } ?>
            </div>

            <div class="E2">
            <?php while($i <= 62){
                if($e== 13){
                    $i += 1;
                
                    break;
                }
                $i += 1;
                $e += 1;?>
                
                    <input type="checkbox" id="<?= $i ?>"  name="kursi[]" value="<?= $i ?>">
                    <label for="<?= $i ?>"><?= $e ?></label>
                
            <?php } ?>
            </div>

            <input type="submit" value="BUY NOW ">
        </form>
        <script>
                <?php foreach($seats_booked as $seat){ ?>
                    document.getElementById("<?= $seat ?>").disabled = true;
                <?php } ?>
        </script>
        <div class="kosong"></div><div class="tempat1"><h5>: Kosong</h5></div>
        <div class="memilih"></div><div class="tempat2"><h5>: Memilih</h5></div>
        <div class="terbooking"></div><div class="tempat3"><h5>: Terbooking</h5></div>
    </div>
  </div>

</body>
</html>