<?php
include "koneksi.php";
session_start();

$username = $_SESSION['username'];
$sql3 = "SELECT id_users FROM users WHERE username= '$username'";
$query3 = mysqli_query($koneksi, $sql3);
$id_users = mysqli_fetch_assoc($query3);
$id_user = $id_users['id_users'];
$kursi = $_POST['kursi'];
$id_movies = $_POST['id_movies'];
$waktu= $_POST['waktu'];
$tanggal = $_POST['tanggal'];
$total = $_POST['total'];

$tempat_gmbr = "bukti_pembayaran/";
$nama_random = uniqid().".jpg";
$target_file = $tempat_gmbr . $nama_random;
$syaratUPLD = 1;

// check apakah gambar itu betul gambar atau bukan
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["payment_proof"]["tmp_name"]);
  if($check == true) {
    $syaratUPLD = 1;
  } else {
    
    $syaratUPLD = 0;
  }
}



// Check apakah $syaratUPLD ada 0 nya
if ($syaratUPLD == 0) {
// jika semua ok, lanjut upload filenya
} else {
  if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
    
    echo "The file ". htmlspecialchars( basename( $_FILES["payment_proof"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
$method_payments = $_POST['payment_method'];
$datetime = date('Y-m-d H:i:s');
$sql4 = "INSERT INTO payments (payment_date,amount,mtd_payments,mtd_image,id_users) VALUES ('$datetime','$total','$method_payments','$nama_random','$id_user')";
$query4 = mysqli_query($koneksi,$sql4);
$sql5 = "SELECT id_payments FROM payments ORDER BY id_payments DESC";
$query5 = mysqli_query($koneksi,$sql5);
while($payments = mysqli_fetch_assoc($query5)){
    $id_payments = $payments['id_payments'];
    break;
}


foreach ($kursi as $item) {
        
        $sql = "INSERT INTO bookings (id_users,seats_booked,total_price,booking_date,booking_time,id_movies,id_payments) VALUES ('$id_user','$item','$total','$tanggal','$waktu','$id_movies','$id_payments')";;
        $query = mysqli_query($koneksi,$sql);
        $sql2 = "SELECT * FROM bookings ORDER BY id_bookings DESC ";
        $query2 = mysqli_query($koneksi,$sql2);
        while($bookings = mysqli_fetch_assoc($query2)){
            $id_bookings[] = $bookings['id_bookings'];
            break;
        }
        $bangku[] = $item;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="formku" action="print_tiket.php" method="post">
        <input type="hidden" name="id_movies" value="<?= $id_movies ?>">
        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
        <input type="hidden" name="waktu" value="<?= $waktu ?>" >
        <input type="hidden" name="total" value="<?= $total ?>">
        <input type="hidden" name="method_payments" value="<?= $method_payments ?>">
        <?php foreach($bangku as $chair){ ?>
            <input type="hidden" name="kursi[]" value="<?= $chair ?>">
        <?php } ?>
        <?php foreach($id_bookings as $id){?>
            <input type="hidden" name="id_bookings[]" value="<?= $id ?>">
        <?php } ?>
    </form>

    <script>
    document.getElementById("formku").submit();
    </script>
</body>
</html>
