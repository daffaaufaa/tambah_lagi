<?php
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO users (username,password,role) VALUES ('$username',md5('$password'),'customer')";
$query = mysqli_query($koneksi,$sql);

if($query){
    header("location:login.php?buatAkunSukses");
}else{
    header("location:register.php?buatAkunGagal");
}
?>