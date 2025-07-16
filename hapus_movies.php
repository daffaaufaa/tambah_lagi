<?php
include "koneksi.php";

$id = $_GET['id'];

$sql2 = "DELETE FROM jadwal_waktu WHERE id_movies = '$id'";
$query2 = mysqli_query($koneksi,$sql2);
$sql3 = "DELETE FROM bookings WHERE id_movies = '$id'";
$query3 = mysqli_query($koneksi,$sql3);
$sql4 = "DELETE FROM artis_movies WHERE id_movies = '$id'";
$query4 = mysqli_query($koneksi,$sql4);
$sql = "DELETE FROM movies WHERE id_movies = '$id'";
$query = mysqli_query($koneksi,$sql);

if($query){
    header("location:admin_azfa.php?hapus=sukses");
}else{
    header("location:admin_azfa.php?hapus=gagal");
}

?>