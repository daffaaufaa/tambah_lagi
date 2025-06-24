<?php
include "koneksi.php";

$kursi = $_POST['kursi'];
$id_movies = $_POST['id_movies'];
$waktu= $_POST['waktu'];
$tanggal = $_POST['tanggal'];
$total = $_POST['total'];

$query= false;

foreach ($kursi as $item) {
    
        $item = $koneksi->real_escape_string($item); 
        $sql = "INSERT INTO bookings (seats_booked,total_price,booking_date,booking_time,id_movies) VALUES ('$item','$total','$tanggal','$waktu','$id_movies')";;
        $koneksi->query($sql);
        $query = true;
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
<?php


?>