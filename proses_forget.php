<?php
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['new_password'];
$konfirmasi = $_POST['confirm_password'];

if($password == $konfirmasi){
    $sql = "UPDATE users SET password = md5('$password') WHERE username = '$username'";
    $query = mysqli_query($koneksi,$sql);
    if($query){
        header("location:login.php?forgetPassword=sukses");
    }else{
        header("location:forget.php?forgetPassword=gagal");
    }
}else{
    header("location:forget.php?konfirmasiPassword=salah");
}

?>