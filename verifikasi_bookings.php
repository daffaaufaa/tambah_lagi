<?php
include "koneksi.php";

if(isset($_GET['id'])) {
    $id_bookings = $_GET['id'];
    
    // Update status booking menjadi 'terverifikasi'
    $sql = "UPDATE bookings SET status = 'terverifikasi' WHERE id_bookings = '$id_bookings'";
    
    if(mysqli_query($koneksi, $sql)) {
        header("location:admin_azfa.php?success=1");
    } else {
        header("location:admin-azfa.php?error=1");  
    }
} else {
    header("location:admin_azfa.php");
}
?>