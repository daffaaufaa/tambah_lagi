<?php
include "koneksi.php";

$id = $_GET['id'];
$sql = "DELETE FROM movies WHERE id_movies = '$id'";
$query = mysqli_query($koneksi,$sql);

if($query){
    header("location:admin_azfa.php?hapus=sukses");
}else{
    header("location:admin_azfa.php?hapus=gagal");
}

?>