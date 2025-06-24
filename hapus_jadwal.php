<?php
include "koneksi.php";

$id_jadwal = $_GET['id'];

$sql = "DELETE FROM jadwal_waktu WHERE id_jadwal_waktu = '$id_jadwal'";
$query = mysqli_query($koneksi, $sql);

if($query){
    header("location:hal.php?hapus_jadwal=sukses");
}else{
    header("location:hal.php?hapus_jadwal=gagal");
}

?>