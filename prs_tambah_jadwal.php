<?php
include "koneksi.php";

$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$id_movies = $_POST['id_movies'];

for ($i = 0; $i < count($tanggal); $i++) {
    $sql = "INSERT INTO jadwal_waktu (tanggal,waktu,id_movies) VALUES ('$tanggal[$i]','$waktu[$i]','$id_movies[$i]')";
    $query = mysqli_query($koneksi,$sql);
}


if($query){
    header("location:admin_azfa.php?tambah_jadwal=sukses");
}else{
    header("location:admin_azfa.php?tambah_jadwal=gagal");
}

?>