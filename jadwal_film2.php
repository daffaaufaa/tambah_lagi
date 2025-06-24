<?php
include "koneksi.php";

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

$id = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Siksa Neraka - Jadwal Tayang</title>
  <style>
    @font-face {
      src: url('font/BalsamiqSans.ttf') format('truetype');
      font-family: 'BalsamiqSans';
      font-weight: normal;
      font-style: normal;
    }
    input[type="radio"] {
      display: none;
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
      background-color: #f19c9c;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      font-weight: bold;
      font-size: 24px;
    }
    .logo img {
      margin-right: 10px;
      height: 9%;
      width: 9%;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #000;
      font-weight: bold;
    }

    .profile-icon {
      width: 40px;
      height: 40px;
      background-image: url('userputih.jpg');
      background-size: contain;
      border-radius: 50%;
    }
.screen {
  background-color: #f9a9a9;
  border-radius: 20px;
  padding: 30px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.movie-container {
  text-align: center;
  margin-top: 30px;
}

.movie-container h2 {
  font-family: 'Courier New', monospace;
  font-size: 1.6rem;
}

.divider {
  width: 50%;
  margin: 10px auto;
  border: 1px solid black;
}

.movie-card {
  background-color: #fddede;
  margin: 30px auto;
  padding: 20px;
  width: 80%;
  max-width: 900px;
  height: 90vh;
  border-radius: 10px;
}
.movie-jarak{
    
  display: flex;
  gap: 30px;
  justify-content: center;
}

.poster {
  width: 200px;
  height: 50%;
  border-radius: 8px;
}

.info {
  text-align: left;
  flex-grow: 1;
}
.info h3{
    margin-top: 15px;
}
#jadwal label,#sinopsi label {
    text-align: center;
    background:rgba(255, 255, 255, 0);
    border-bottom: none;
    color:rgba(0, 0, 0, 0.4);
    font-family: "BalsamiqSans";
    font-size: 20px;
    padding-left: 3.5vw;
    cursor: pointer; 
}
#jadwal input[type=radio]:checked + label,#sinopsi input[type=radio]:checked + label {
    
    width: 10px;
    border-bottom: 2px solid #FF0808;
    color: #FF0808;
}



.tabs {
  display: flex;
  margin-top: 120px;
  gap: 20px;
  font-size: 22px;
}


.jarak{
    margin-top: 40px;
    text-align: left;
  flex-grow: 1;
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
  border: 2px solid #ccc;
  border-radius: 10px;
  padding: 5px 10px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.days input[type="radio"]:checked + label, .times input[type="radio"]:checked + label {
  background-color:rgba(179, 44, 46, 0.82);
  color: white;
}


input[type="submit"] {
  display: inline-block;
  margin-top: 15px;
  background-color: red;
  color: white;
  text-decoration: none;
  padding: 10px 25px;
  font-weight: bold;
  border-radius: 5px;
  border: none;
  cursor: pointer;
}


  </style>

</head>
<body>
  <header>
    <div class="logo">
      <img src="logo_web.png" alt="" />
      AZFATICKET.XXI</div>
    <nav>
      <a href="#">MOVIE</a>
      <a href="#">CINEMA</a>
      <a href="#">CONTACT</a>
    </nav>
    <div class="profile-icon"></div>
  </header>

  <main class="movie-container">
    <h2>WELCOME THIS MOVIE</h2>
    <hr class="divider">

    <section class="movie-card">
        <div class="movie-jarak">
            <img class="poster" src="movie\<?= $movies['poster_image']?>" alt="">
            <div class="info">
            <h3><?= strtoupper($movies['title']) ?></h3>
            <p><strong><?= ucfirst($movies['genre']) ?></strong><br>98 minutes</p>

            <div class="tabs">
              <script>
                  window.onload = function() {
                      document.getElementById('ja_dwal').click();
                  };
              </script>

              <div id="jadwal" onclick= "style_deskripsi()">
                  <input type="radio" id="ja_dwal"  name="sinopsi" value="jadwal">
                  <label for="ja_dwal">JADWAL</label>
              </div>
              <div id="sinopsi" onclick= "style_isi_jadwal()">
                  <input type="radio" id="si_nopsi"  name="sinopsi" value="sinopsi">
                  <label for="si_nopsi">SINOPSI</label>
              </div>

              

              <script>
                function style_isi_jadwal() {
                    const btn = document.getElementById('isi_jadwal');
                    btn.style.display = 'none';
                
                    document.getElementById('description').style.display='block';
                }
            
                function style_deskripsi () {
                    const btn2 = document.getElementById('description');
                    btn2.style.display= 'none';
                    document.getElementById('isi_jadwal').style.display='block';
                }

              </script>
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
                    
                    $id += 1;
                ?>
              <input type="radio" id="<?= $id ?>"  name="tanggal" value="<?= $tanggal['tanggal'] ?>">
              <label for="<?= $id ?>"><?= $nama_hari ?><br><?= $tanggal_hari ?></label>

                
            <?php } ?>
          </div>

          <strong>TIME MOVIE</strong>
          <div class="times">
            <?php while($waktu = mysqli_fetch_assoc($query3)){?>
                    <input type="radio" id="<?= $waktu['id_jadwal_waktu'] ?>"  name="waktu" value="<?= $waktu['waktu'] ?>">
                    <label for="<?= $waktu['id_jadwal_waktu'] ?>"><?= $waktu['waktu'] ?></label>
            <?php } ?>
          </div>
        </div>
        <hr>
        <input type="submit" value="PICK YOUR SEAT">
      </div>
      </form>
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
