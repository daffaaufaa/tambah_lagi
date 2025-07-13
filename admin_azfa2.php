<?php
include "koneksi.php";
$sql = "SELECT * FROM iklan ORDER BY id_iklan DESC";
$query = mysqli_query($koneksi,$sql);

$sql2 = "SELECT * FROM movies ";
$query2 = mysqli_query($koneksi,$sql2);

$sql3 = "SELECT * FROM bookings";
$query3 = mysqli_query($koneksi,$sql3);




if(isset($_POST['jumlah'])){
    $jumlah = $_POST['jumlah'];
}else{
    $jumlah = 1;
}



?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin AZFATICKET.XXI</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      height: 100vh;
      background: linear-gradient(to bottom right, #fff0f0, #ffe6e6);
      animation: fadeIn 0.8s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* === NAVBAR === */
    .navbar {
      background-color: #b30000;
      color: white;
      padding: 40px 75px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 0 0 20px 20px; 
    }

    .navbar .logo {
      font-size: 25px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    .main {
      display: flex;
      flex: 1;
    }

    /* === SIDEBAR === */
    .sidebar {
      width: 250px;
      background-color: #fff;
      padding: 30px 20px;
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
      animation: fadeIn 1.2s ease;
    }

    .sidebar h3 {
      color: #b30000;
      margin-bottom: 20px;
    }

    .sidebar button {
      display: block;
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      background-color: #b30000;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }

    .sidebar button:hover {
      background-color: #990000;
      transform: scale(1.03);
    }

    /* === CONTENT AREA === */
    .content {
      flex: 1;
      padding: 40px;
      animation: fadeIn 1.5s ease-in-out;
    }

    .section {
      display: none;
    }

    .section.active {
      display: block;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .section h2 {
      color: #b30000;
      margin-bottom: 20px;
    }

    .section input, .section textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ffd6d6;
    }

    .section button {
      background-color: #b30000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    #dashboard.movie,
  #dashboard\ movie {
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 20px;
  }

  /* Judul section */
  #dashboard.movie h1,
  #dashboard\ movie h1 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #b30000;
    border-bottom: 2px solid #b30000;
    display: inline-block;
    padding-bottom: 5px;
  }

  /* Tabel */
  #dashboard.movie table,
  #dashboard\ movie table {
    width: 100%;
    border-collapse: collapse;
    background-color: #f9f9f9;
  }

  /* Header tabel */
  #dashboard.movie th,
  #dashboard\ movie th {
    background-color: #b30000;
    color: white;
    padding: 12px;
    text-align: left;
  }

  /* Isi tabel */
  #dashboard.movie td,
  #dashboard\ movie td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
  }

  /* Gambar */
  .iklan img {
    width: 80px;
    height: auto;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  }

  /* Aksi link */
  #dashboard.movie a,
  #dashboard\ movie a {
    display: inline-block;
    margin: 4px 6px;
    padding: 6px 12px;
    color: white;
    background-color: #e60000;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.2s;
  }

  #dashboard.movie a:hover,
  #dashboard\ movie a:hover {
    background-color: #990000;
  }
  <style>
  /* Container styling */
  .content {
    padding: 40px;
    font-family: 'Segoe UI', sans-serif;
    background-color: #f9f9f9;
  }

  .section {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    padding: 30px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
  }

  th {
    background-color: #f44336;
    color: white;
    padding: 15px 10px;
    font-size: 16px;
  }

  td {
    padding: 12px 10px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
    color: #333;
  }

  tr:hover {
    background-color: #fff0f0;
  }

  .iklan img {
    width: 100px;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: 0.3s ease;
  }

  .iklan img:hover {
    transform: scale(1.05);
  }

  a {
    background-color: #e53935;
    color: white;
    padding: 8p
  }

  select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ffd6d6;
  }
  
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">🎬 AZFATICKET.XXI</div>
  </div>

  <!-- Main Area -->
  <div class="main">
    <!-- Sidebar -->
    <div class="sidebar">
      <h3>Manajemen</h3>
      <button onclick="showSection('dashboard movie')">Data Movie</button>
      <button onclick="showSection('dashboard iklan')">Data Iklan</button>
      <button onclick="showSection('daftar verifikasi')">Daftar Verifikasi</button>
      <button onclick="showSection('movie')">Management Movie</button>
      <button onclick="showSection('jadwal')">Management Jadwal</button>
      <button onclick="showSection('iklan')">Management Iklan</button>
      <button onclick="showSection('transaksi')">Management Transaksi</button>
    </div>

    <!-- Content Area -->
    <div class="content">
      <div id="dashboard movie" class="section active">
        <h1>DASHBOARD MOVIE</h1>
    <table border="1">
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
              <a href="edit_movies.php?id=<?= $movies['id_movies']; ?>">Edit</a>
            <a href="hapus_movies.php?id=<?= $movies['id_movies']; ?>">hapus</a>
            </td>
        </tr>
        <?php }?>
    </table>
      </div>
      <div class="content">
      <div id="dashboard iklan" class="section">
        <table border="1">
        <tr>
            <th>id iklan</th>
            <th>nama gambar</th>
            <th>gambar</th>
            <th>aksi</th>
        </tr>
        <?php while($iklan = mysqli_fetch_assoc($query)){?>
        <tr>
            <td><?= $iklan['id_iklan'] ?? ''; ?></td>
            <td><?= $iklan['gambar']; ?></td>
            <td><div class="iklan"><img src="iklan/<?= $iklan['gambar'] ?>" ></div></td>
            <td>
                <a href="hapus_gambar.php?id=<?= $iklan['id_iklan']; ?>">hapus</a>
            </td>
        </tr>
        <?php }?>

    </table>
        </div>
        <div class="content">
      <div id="daftar verifikasi" class="section">
        <h1>DAFTAR VERIFIKASI</h1>
          <table border="1">
        <tr>
            <th>Id Bookings</th>
            <th>Id Users</th>
            <th>Seats Booked</th>
            <th>Total Price</th>
            <th>Movie date</th>
            <th>Movie Time</th>
            <th>Id Movies</th>
            <th>Aksi</th>
        </tr>
        <?php while($bookings = mysqli_fetch_assoc($query3)){?>
        <tr>
            <td><?= $bookings['id_bookings']; ?></td>
            <td><?= $bookings['id_users']; ?></td>
            <td><?= $bookings['seats_booked']; ?></td>
            <td><?= $bookings['total_price']; ?></td>
            <td><?= $bookings['booking_date']; ?></td>
            <td><?= $bookings['booking_time']; ?></td>
            <td><?= $bookings['id_movies']; ?></td>
            <td>
                <!-- <a href="hapus_bookings.php?id=<?= $bookings['id_bookings']; ?>">hapus</a> -->
            </td>
        </tr>
        <?php }?>
    </table>
      </div>
      <div id="movie" class="section ">
        <form action="prs_tambah_movies.php" method="post" enctype="multipart/form-data">
        <label for="">Judul :</label><br>
        <input type="text" name="title" id=""><br><br>

        <label for="">genre :</label><br>
        <input type="radio" name="genre" id="horor" value="horor">
        <label for="horor">horor</label><br>
        <input type="radio" name="genre" id="komedi" value="komedi">
        <label for="komedi">komedi</label><br>
        <input type="radio" name="genre" id="romance" value="romance">
        <label for="romance">romance</label><br><br>

        <label for="">description :</label><br>
        <textarea name="description" id="" cols="30" rows="10"></textarea><br><br>

        <label for="">tanggal release :</label><br>
        <input type="date" name="release_date" id=""><br><br>

        <label for="">durasi :</label><br>
        <input type="time" name="duration" id=""><br><br>

        <label for="">gambar movies :</label><br>
        <input type="file" name="poster_image" id="" accept=".jpg"><br><br>

        <label for="">max tayang :</label><br>
        <input type="date" name="max_tayang" id=""><br><br>

        <input type="submit" value="Tambah" name="submit">
        
    </form>
      </div>
      <div id="jadwal" class="section">
       <h2>Form Tambah Jadwal</h2><br><br>
    <form action="admin_azfa.php" method="post">
        <label for="">Jumlah Jadwal</label><br>
        <input type="number" name="jumlah" id="">
        <input type="submit" value="Ya"><br><br><br>
    </form>
    <form action="prs_tambah_jadwal.php" method="post">
        <?php while($jumlah >= 1){ ?>
            <label for="">Tanggal</label><br>
            <input type="date" name="tanggal[]" id=""><br><br>

            <label for="">Waktu</label><br>
            <input type="time" name="waktu[]" id=""><br><br>  

            <label for="">Id Movies</label><br>
            <select  name="id_movies[]" id="">
              <?php
                $sql4 = "SELECT id_movies FROM movies ";
                $query4 = mysqli_query($koneksi,$sql4);
                while($id = mysqli_fetch_assoc($query4)){
              ?>
                <option value="<?= $id['id_movies'] ?>"><?= $id['id_movies'] ?></option>
              <?php } ?>
            </select><br><br><br>
        <?php $jumlah -= 1;} ?>

        <input type="submit" value="Tambah" name="tambah">
        
    </form>
      </div>
    <div id="iklan" class="section">
       <h3>IKLAN</h3><br>
       <form action="prs_tambah_gambar.php" method="post" enctype="multipart/form-data">
        <input type="file" name="gambar" id="" ><br><br>
        <input type="submit" value="Tambah gambar" name="submit">
      </form>
      </div>
      <div id="transaksi" class="section">
        <h2>Edit Transaksi</h2>
        <input type="text" placeholder="ID Transaksi">
        <input type="number" placeholder="Jumlah">
        <button>Simpan</button>
      </div>
    </div>
    
    
  </div>
  
  <script>
    function showSection(id) {
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => section.classList.remove('active'));
      document.getElementById(id).classList.add('active');
    }
  </script>
</body>
</html>
