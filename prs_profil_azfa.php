<?php
include "koneksi.php";

$id_users = $_POST['id_users'];
$nama = $_POST['name'];
$no_hp = $_POST['no_hp'];
$gmail = $_POST['gmail'];
$description = $_POST['description'];

$sql = "UPDATE users SET nama = '$nama', no_hp = '$no_hp', gmail = '$gmail', description = '$description' WHERE id_users = '$id_users'";
$query = mysqli_query($koneksi, $sql);

if($query){
    header("location:profil_azfa.php?edit=berhasil");

}else{
    header("location:profil_azfa.php?edit=gagal");
}


?>