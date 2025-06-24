<?php
include "koneksi.php";

$id_bookings = $_GET['id'];
$sql = "SELECT * FROM bookings WHERE id_bookings = '$id_bookings'";
$query = mysqli_query($koneksi,$sql);

if($query){
    header("location:admin_azfa.php?hapus=sukses");
}else{
    header("location:admin_azfa.php?hapus=gagal");
}


?>